<?php
namespace Fortifi\Api\Core\Exceptions\Client;

use Exception;

class ConflictException extends ClientApiException
{
  const FIELD = 'x-fortifi-conflict-field';
  const VALUE = 'x-fortifi-conflict-value';
  const OWNER = 'x-fortifi-conflict-owner';

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
    $this->field = !empty($headers[static::FIELD]) ? $headers[static::FIELD][0] : null;
    $this->value = !empty($headers[static::VALUE]) ? $headers[static::VALUE][0] : null;
    $this->owner = !empty($headers[static::OWNER]) ? $headers[static::OWNER][0] : null;
  }
}
