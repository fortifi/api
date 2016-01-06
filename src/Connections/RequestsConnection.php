<?php
namespace Fortifi\Api\Core\Connections;

use Fortifi\Api\Core\ApiResult;
use Fortifi\Api\Core\IApiConnection;
use Fortifi\Api\Core\IApiRequest;

class RequestsConnection implements IApiConnection
{
  /**
   * @inheritDoc
   */
  public function load(IApiRequest $request)
  {
    $req = $request->getRequestDetail();
    $response = \Requests::request(
      $req->getUrl(),
      $req->getHeaders(),
      $req->getPostFields(),
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
          'headers' => $reqDet->getHeaders(),
          'data'    => $reqDet->getPostFields(),
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
    $result->setContent($response->body);
    $result->setStatusCode($response->status_code);
    $result->setCallId(reset($response->headers->getValues('X-Call-Id')));
    $result->setCookies($response->cookies);
    $result->setHeaders($response->headers);
    return $result;
  }
}
