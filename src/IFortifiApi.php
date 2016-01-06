<?php
namespace Fortifi\Api\Core;

interface IFortifiApi
{
  /**
   * @param IApiRequest $request to load
   *
   * @return IApiRequest Returns the loaded request
   */
  public function load(IApiRequest $request);

  /**
   * @param IApiRequest[] $requests Requests to load
   *
   * @return self
   */
  public function batchLoad($requests);
}
