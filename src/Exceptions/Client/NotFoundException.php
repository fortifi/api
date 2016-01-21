<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class NotFoundException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Not Found', $code = 404, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
