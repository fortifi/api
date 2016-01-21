<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class GoneException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Gone', $code = 410, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
