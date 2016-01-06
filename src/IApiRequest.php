<?php
namespace Fortifi\Api\Core;

interface IApiRequest
{
  /**
   * Raw result from the API Request
   *
   * @return IApiResult
   */
  public function getRawResult();

  /**
   * Decode the result as json
   *
   * @return \stdClass
   */
  public function getResultJson();

  /**
   * @param IApiResult $result
   *
   * @return self
   */
  public function setRawResult(IApiResult $result);

  /**
   * Information about the request
   *
   * @return IApiRequestDetail
   */
  public function getRequestDetail();

  /**
   * @param IApiConnection $connection
   *
   * @return self
   */
  public function setConnection(IApiConnection $connection);

  /**
   * Check for existing binding of an IFortifiApi
   *
   * @return bool
   */
  public function hasConnection();

  /**
   * Should Exceptions be thrown when processing the raw result
   *
   * @param bool $throw
   *
   * @return mixed
   */
  public function setThrowExceptions($throw = true);

  /**
   * If exceptions should be thrown when processing the raw result
   *
   * @return bool
   */
  public function shouldThrowExceptions();
}
