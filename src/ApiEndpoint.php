<?php
namespace Fortifi\Api\Core;

use Packaged\Helpers\Path;

class ApiEndpoint implements IApiEndpoint
{
  protected $_baseUrl = 'http://localhost';
  protected $_basePath = '';
  protected $_connection;

  public function setBaseUrl($baseUrl)
  {
    $this->_baseUrl = $baseUrl;
    return $this;
  }

  public function setBasePath($basePath)
  {
    $this->_basePath = $basePath;
    return $this;
  }

  /**
   * @return string
   */
  public function getBaseUrl()
  {
    return $this->_baseUrl;
  }

  /**
   * @return string
   */
  public function getBasePath()
  {
    return $this->_basePath;
  }

  protected function _buildUrl($path)
  {
    return Path::buildUnix($this->_baseUrl, $this->_basePath, $path);
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
