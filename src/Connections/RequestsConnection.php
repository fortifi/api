<?php
namespace Fortifi\Api\Core\Connections;

use Fortifi\Api\Core\ApiResult;
use Fortifi\Api\Core\IApiConnection;
use Fortifi\Api\Core\IApiRequest;
use Fortifi\Api\Core\IApiRequestDetail;

class RequestsConnection implements IApiConnection
{
  protected $_orgFid;
  protected $_accessToken;

  /**
   * @param string $fid Organisation FID
   *
   * @return $this
   */
  public function setOrganisationFid($fid)
  {
    $this->_orgFid = $fid;
    return $this;
  }

  /**
   * @param string $token Access Token
   *
   * @return $this
   */
  public function setAccessToken($token)
  {
    $this->_accessToken = $token;
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function load(IApiRequest $request)
  {
    $req = $request->getRequestDetail();
    $response = \Requests::request(
      $req->getUrl(),
      $this->_buildHeaders($req),
      $this->_buildData($req),
      $req->getMethod(),
      $req->getOptions()
    );

    $result = $this->_getResult($response);

    $request->setRawResult($result);
    return $request;
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
    $responses = \Requests::request_multiple($batchRequests);

    foreach($responses as $id => $response)
    {
      $originals[$id]->setRawResult($this->_getResult($response));
    }

    return $this;
  }

  protected function _getResult(\Requests_Response $response)
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

  protected function _buildData(IApiRequestDetail $request)
  {
    if($request->getRequestBody())
    {
      return $request->getRequestBody();
    }
    else
    {
      return $request->getPostFields();
    }
  }

  protected function _buildHeaders(IApiRequestDetail $request)
  {
    $headers = $request->getHeaders();
    if(!empty($this->_orgFid))
    {
      $headers['X-Fortifi-Org'] = $this->_orgFid;
    }

    if(!empty($this->_accessToken))
    {
      $headers['Authorization'] = 'Bearer ' . $this->_accessToken;
    }

    if($request->getRequestBody())
    {
      $headers['Content-Type'] = 'application/json';
    }

    return $headers;
  }
}
