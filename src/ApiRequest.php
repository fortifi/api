<?php
namespace Fortifi\Api\Core;

class ApiRequest implements IApiRequest
{
  /**
   * @var bool
   */
  private $_throw = true;

  /**
   * @var IFortifiApi
   */
  private $_api;

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
   * @param IApiResult $result
   *
   * @return $this
   */
  public function setResult(IApiResult $result)
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
   * @param IFortifiApi $api
   *
   * @return $this
   */
  public function setApi(IFortifiApi $api)
  {
    $this->_api = $api;
    return $this;
  }

  /**
   * @return bool
   */
  public function hasApi()
  {
    return $this->_api !== null;
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
