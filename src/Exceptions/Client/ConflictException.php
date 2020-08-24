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
    $this->field = $headers['X-fortifi-conflict-field'];
    $this->value = $headers['X-fortifi-conflict-value'];
    $this->owner = $headers['X-fortifi-conflict-owner'];
  }
}
