<?php
namespace Fortifi\Api\Core;

interface IApiRequest extends IApiConnectionAware
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
