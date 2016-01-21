<?php
namespace Fortifi\Api\Core\Exceptions\Server;

class InternalServerException extends ServerApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Internal Server Error', $code = 500, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
