<?php
namespace Fortifi\Api\Core\Exceptions\Server;

class ServiceUnavailableException extends ServerApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Service Unavailable', $code = 503, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
