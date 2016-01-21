<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class NotAcceptableException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Not Acceptable', $code = 406, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
