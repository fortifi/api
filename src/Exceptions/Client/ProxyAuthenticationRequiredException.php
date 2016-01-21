<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class ProxyAuthenticationRequiredException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Proxy Authentication Required', $code = 407,
    \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
