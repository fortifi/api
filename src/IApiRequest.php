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
   * Information about the request
   *
   * @return IApiRequestDetail
   */
  public function getRequestDetail();

  /**
   * @param IFortifiApi $api
   *
   * @return self
   */
  public function setApi(IFortifiApi $api);

  /**
   * Check for existing binding of an IFortifiApi
   *
   * @return bool
   */
  public function hasApi();

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
