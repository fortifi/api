<?php
namespace Fortifi\Api\Core;

use Fortifi\Api\Core\ApiDefinition\IApiDefinition;
use Packaged\Helpers\Path;

class ApiEndpoint implements IApiEndpoint
{
  protected $_connection;
  protected $_baseUrl;

  /**
   * @var IApiDefinition
   */
  protected $_definition;

  public function setApiDefinition(IApiDefinition $definition)
  {
    $this->_definition = $definition;
    $this->_baseUrl = null;
    return $this;
  }

  /**
   * @return IApiDefinition
   */
  public function getDefinition()
  {
    return $this->_definition;
  }

  protected function _buildUrl($path)
  {
    if($this->_baseUrl === null)
    {
      $schemas = $this->_definition->getSchemas();
      rsort($schemas);
      $this->_baseUrl = reset($schemas);
      $this->_baseUrl .= $this->_definition->getHost();
      $this->_baseUrl .= '/' . ltrim($this->_definition->getBasePath(), '/');
    }

    return Path::buildUnix($this->_baseUrl, $path);
  }

  /**
   * @param IApiConnection $connection
   *
   * @return $this
   */
  public function setConnection(IApiConnection $connection)
  {
    $this->_connection = $connection;
    return $this;
  }

  /**
   * @return IApiConnection
   */
  protected function _getConnection()
  {
    return $this->_connection;
  }

  /**
   * @return bool
   */
  public function hasConnection()
  {
    return $this->_connection !== null;
  }
}
