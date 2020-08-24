<?php
namespace Fortifi\Api\Core\Exceptions\Client;

use Exception;
use Packaged\Helpers\Arrays;

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
    Arrays::value($headers, 'x-fortifi-conflict-field');
    Arrays::value($headers, 'x-fortifi-conflict-value');
    Arrays::value($headers, 'x-fortifi-conflict-owner');
  }
}
