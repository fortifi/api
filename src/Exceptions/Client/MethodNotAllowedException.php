<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class MethodNotAllowedException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Method Not Allowed', $code = 405, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
