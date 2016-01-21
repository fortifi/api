<?php
namespace Fortifi\Api\Core\Exceptions\Server;

class BadGatewayException extends ServerApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Bad Gateway', $code = 502, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
