<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class RequestTimeoutException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Request Timeout', $code = 408, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
