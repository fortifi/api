<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class UnauthorizedException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Unauthorized', $code = 401, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
