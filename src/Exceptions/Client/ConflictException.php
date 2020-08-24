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
    $this->field = !empty($headers['x-fortifi-conflict-field']) ? $headers['x-fortifi-conflict-field'][0] : null;
    $this->value = !empty($headers['x-fortifi-conflict-value']) ? $headers['x-fortifi-conflict-value'][0] : null;
    $this->owner = !empty($headers['x-fortifi-conflict-owner']) ? $headers['x-fortifi-conflict-owner'][0] : null;
  }
}
