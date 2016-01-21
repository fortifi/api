<?php
namespace Fortifi\Api\Core\Exceptions\Server;

class NotImplementedException extends ServerApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Not Implemented', $code = 501, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
