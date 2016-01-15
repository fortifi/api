<?php
namespace Fortifi\Api\Core;

use Packaged\Helpers\ValueAs;

class ApiRequest implements IApiRequest
{
  /**
   * @var bool
   */
  private $_throw = true;

  /**
   * @var IApiConnection
   */
  private $_connection;

  /**
   * @var \stdClass
   */
  private $_decoded;

  /**
   * @var IApiResult
   */
  private $_result;
  /**
   * @var IApiRequestDetail
   */
  private $_requestDetail;

  /**
   * @var IApiEndpoint
   */
  protected $_endpoint;

  /**
   * @param IApiRequestDetail $requestDetail
   *
   * @return $this
   */
  public function setRequestDetail(IApiRequestDetail $requestDetail)
  {
    $this->_requestDetail = $requestDetail;
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function setRawResult(IApiResult $result)
  {
    $this->_result = $result;
    return $this;
  }

  /**
   * @return IApiResult|null
   * @throws \Exception
   */
  public function getRawResult()
  {
    if($this->_result === null)
    {
      if($this->hasConnection())
      {
        if($this->_requestDetail->requiresAuth())
        {
          $this->_getConnection()->setToken($this->_endpoint->getToken());
          try
          {
            $result = $this->_getConnection()->load($this);
          }
          catch(\Exception $e)
          {
            if($e->getCode() == 403 && stristr($e->getMessage(), 'token'))
            {
              $result = $this->_getConnection()->load($this);
            }
            else
            {
              throw $e;
            }
          }
        }
        else
        {
          $result = $this->_getConnection()->load($this);
        }

        $this->setRawResult($result->getRawResult());
      }
      else
      {
        throw new \Exception("No API Connection Available", 500);
      }
    }

    if($this->_result instanceof IApiResult)
    {
      if($this->shouldThrowExceptions())
      {
        if($this->_result->getStatusCode() !== 200)
        {
          throw new \Exception(
            $this->_result->getStatusMessage(),
            $this->_result->getStatusCode()
          );
        }
      }

      return $this->_result;
    }

    throw new \Exception("Invalid API Result Stored", 500);
  }

  protected function _getResultJson()
  {
    if($this->_decoded === null)
    {
      $this->_decoded = $this->_prepareResult(
        json_decode($this->getRawResult()->getContent())
      );
    }
    return $this->_decoded;
  }

  public function getDecodedResponse()
  {
    return $this->_getResultJson();
  }

  protected function _prepareResult($result)
  {
    return $result;
  }

  public function wasSuccessful()
  {
    try
    {
      return $this->getRawResult()->getStatusCode() == 200;
    }
    catch(\Exception $e)
    {
      return false;
    }
  }

  /**
   * @return IApiRequestDetail
   */
  public function getRequestDetail()
  {
    return $this->_requestDetail;
  }

  /**
   * @param IApiConnection $connection
   *
   * @return $this
   */
  public function setConnection(IApiConnection $connection)
  {
    $this->_connection = $connection;
    return $this;
  }

  /**
   * @return IApiConnection
   */
  protected function _getConnection()
  {
    return $this->_connection;
  }

  /**
   * @return bool
   */
  public function hasConnection()
  {
    return $this->_connection !== null;
  }

  /**
   * @param bool $throw
   *
   * @return $this
   */
  public function setThrowExceptions($throw = true)
  {
    $this->_throw = $throw;
    return $this;
  }

  /**
   * @return bool
   */
  public function shouldThrowExceptions()
  {
    return $this->_throw;
  }

  public function hydrate($data)
  {
    $this->_decoded = $this->_prepareResult(ValueAs::obj($data));
    $this->_result = json_encode($this->_decoded);
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function hasResult()
  {
    return $this->_result !== null;
  }

}
