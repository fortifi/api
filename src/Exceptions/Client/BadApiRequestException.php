<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class BadApiRequestException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Bad Request', $code = 400, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
