<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class TooManyRequestsException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Too Many Requests', $code = 429, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
