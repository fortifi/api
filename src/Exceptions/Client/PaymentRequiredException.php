<?php
namespace Fortifi\Api\Core\Exceptions\Client;

class PaymentRequiredException extends ClientApiException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    $message = 'Payment Required', $code = 402, \Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
  }
}
