<?php
namespace Fortifi\Api\Core;

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
   * @var IApiResult
   */
  private $_result;
  /**
   * @var IApiRequestDetail
   */
  private $_requestDetail;

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
   * @return IApiResult
   */
  public function getRawResult()
  {
    return $this->_result;
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

}
