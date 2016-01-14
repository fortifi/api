<?php
namespace Fortifi\Api\Core\Connections;

use Fortifi\Api\Core\ApiResult;
use Fortifi\Api\Core\IApiRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Pool;

class Guzzle5Connection extends AbstractConnection
{
  protected $_client;

  /**
   * @inheritDoc
   */
  public function __construct()
  {
    $this->_client = new Client();
  }

  protected function _getOptions(IApiRequest $request)
  {
    return array_merge_recursive(
      (array)$request->getRequestDetail()->getOptions(),
      [
        'body' => $this->_buildData($request->getRequestDetail()),
      ]
    );
  }

  protected function _makeRequest(IApiRequest $request)
  {
    $req = $request->getRequestDetail();
    $gRequest = $this->_client->createRequest(
      $req->getMethod(),
      $req->getUrl(),
      $this->_getOptions($request)
    );
    $gRequest->setHeaders($this->_buildHeaders($request->getRequestDetail()));
    return $gRequest;
  }

  /**
   * @inheritDoc
   */
  public function load(IApiRequest $request)
  {
    $response = $this->_client->send($this->_makeRequest($request));
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
        $batchRequests[$i] = $this->_makeRequest($request);
      }
    }
    $options = [];
    $responses = Pool::batch($this->_client, $batchRequests, $options);

    foreach($responses as $id => $response)
    {
      $originals[$id]->setRawResult($this->_getResult($response));
    }

    return $this;
  }

  /**
   * @param ResponseInterface $response
   *
   * @return ApiResult
   */
  protected function _getResult(ResponseInterface $response)
  {
    $result = new ApiResult();
    $result->setStatusCode($response->getStatusCode());
    $callId = $response->getHeader('X-Call-Id');
    if(!empty($callId))
    {
      $result->setCallId($callId);
    }

    $decoded = json_decode((string)$response->getBody());
    if(isset($decoded->meta) && isset($decoded->data)
      && isset($decoded->meta->code)
      && $decoded->meta->code == $response->getStatusCode()
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
      $result->setContent((string)$response->getBody());
    }

    $result->setHeaders($response->getHeaders());
    return $result;
  }
}
