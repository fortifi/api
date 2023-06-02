<?php
namespace Fortifi\Api\Core\Connections;

use Fortifi\Api\Core\ApiResult;
use Fortifi\Api\Core\Exceptions\ApiException;
use Fortifi\Api\Core\Exceptions\Client\RequestTimeoutException;
use Fortifi\Api\Core\Exceptions\Server\ServerApiException;
use Fortifi\Api\Core\Exceptions\Server\ServiceUnavailableException;
use Fortifi\Api\Core\IApiRequest;
use Fortifi\Api\Core\IApiResult;
use WpOrg\Requests\Exception;
use WpOrg\Requests\Requests;
use WpOrg\Requests\Response;
use function array_filter;

class Requests2Connection extends AbstractConnection
{
  protected $_timeout = 20;

  /**
   * @inheritDoc
   */
  public function setTimeout($timout = 20)
  {
    $this->_timeout = $timout;
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function load(IApiRequest $request)
  {
    $req = $request->getRequestDetail();

    try
    {
      $headers = $this->_buildHeaders($req);
      $data = $this->_buildData($req);
      if(!$data || (is_array($data) && empty(array_filter($data))))
      {
        // Prevent 411 errors from some servers
        $headers['Content-Length'] = 0;
      }

      $response = Requests::request(
        $req->getUrl(),
        $headers,
        $data,
        $req->getMethod(),
        array_merge(['timeout' => $this->_timeout], (array)$req->getOptions())
      );

      $result = $this->_getResult($response);

      $request->setRawResult($result);
      return $request;
    }
    catch(\Exception $e)
    {
      $this->_handleException($e);
    }
  }

  protected function _handleException(\Exception $e)
  {
    try
    {
      throw $e;
    }
    catch(Exception $e)
    {
      if(is_resource($e->getData()))
      {
        $errNo = curl_errno($e->getData());
        switch($errNo)
        {
          case 7:
            throw new ServiceUnavailableException($e->getMessage(), 503, $e);
          case 28:
            throw new RequestTimeoutException($e->getMessage(), 408, $e);
        }
      }
    }
    catch(ApiException $e)
    {
      throw $e;
    }
    throw new ServerApiException($e->getMessage(), 500, $e);
  }

  /**
   * @inheritDoc
   */
  public function batchLoad($requests)
  {
    /** @var IApiRequest[] $originals */
    $originals = [];
    $batchRequests = [];
    foreach($requests as $i => $request)
    {
      if($request instanceof IApiRequest)
      {
        $originals[$i] = $request;
        $reqDet = $request->getRequestDetail();

        $batchReq = [
          'url'     => $reqDet->getUrl(),
          'headers' => $this->_buildHeaders($reqDet),
          'data'    => $this->_buildData($reqDet),
          'type'    => $reqDet->getMethod(),
          'options' => $reqDet->getOptions(),
          'cookies' => [],
        ];
        $batchRequests[$i] = $batchReq;
      }
    }

    try
    {
      $responses = Requests::request_multiple($batchRequests);

      foreach($responses as $id => $response)
      {
        $originals[$id]->setRawResult($this->_getResult($response));
      }

      return $this;
    }
    catch(\Exception $e)
    {
      $this->_handleException($e);
    }
  }

  /**
   * @param Response $response
   *
   * @return IApiResult
   */
  protected function _getResult(Response $response)
  {
    $result = new ApiResult();
    $result->setStatusCode($response->status_code);
    $callId = $response->headers->getValues('X-Call-Id');
    if(!empty($callId))
    {
      $result->setCallId(reset($callId));
    }

    $decoded = json_decode($response->body);
    if(isset($decoded->meta) && isset($decoded->data)
      && isset($decoded->meta->code)
      && $decoded->meta->code == $response->status_code
    )
    {
      $meta = $decoded->meta;
      $data = $decoded->data;
      if(isset($meta->message))
      {
        $result->setStatusMessage($meta->message);
      }
      $result->setContent(json_encode($data));
    }
    else
    {
      $result->setContent($response->body);
    }

    $cookies = $response->cookies;
    if(!is_array($cookies))
    {
      if($cookies instanceof \IteratorAggregate)
      {
        $cookies = (array)$cookies->getIterator();
      }
    }
    $result->setCookies($cookies);
    $headers = $response->headers;
    if(!is_array($headers))
    {
      if($headers instanceof \IteratorAggregate)
      {
        $headers = (array)$headers->getIterator();
      }
    }
    $result->setHeaders($headers);
    return $result;
  }
}
