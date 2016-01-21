<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class ConflictException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Conflict', $code = 409, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
