<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class ForbiddenException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Forbidden', $code = 403, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
