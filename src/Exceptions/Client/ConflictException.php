<?php
namespace Fortifi\Api\Core\Exceptions\Client;

use Exception;

class ConflictException extends ClientApiException
{
  public $field;
  public $value;
  public $owner;

  /**
   * @inheritDoc
   */
  public function __construct($message = '', $code = 409, Exception $previous = null)
  {
    parent::__construct($message ?: 'Conflict', $code, $previous);
  }

  public function handleHeaders(array $headers)
  {
    $this->field = $headers['x-fortifi-conflict-field'][0];
    $this->value = $headers['x-fortifi-conflict-value'][0];
    $this->owner = $headers['x-fortifi-conflict-owner'][0];
  }
}
