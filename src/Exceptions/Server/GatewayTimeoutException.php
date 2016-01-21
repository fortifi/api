<?php
namespace Fortifi\Api\Core\Exceptions\Server;

class GatewayTimeoutException extends ServerApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Gateway Exception', $code = 504, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
