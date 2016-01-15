<?php
namespace Fortifi\Api\Core;

use Fortifi\Api\Core\ApiDefinition\IApiDefinition;
use Fortifi\Api\Core\OAuth\Grants\IGrant;
use Fortifi\Api\Core\OAuth\TokenStorage\ITokenStorage;
use Fortifi\Api\Core\OAuth\TokenStorage\TempFileTokenStorage;
use Packaged\Helpers\Path;

class ApiEndpoint implements IApiEndpoint
{
  protected $_connection;
  protected $_baseUrl;
  /**
   * @var IGrant
   */
  protected $_grant;
  /**
   * @var ITokenStorage
   */
  protected $_tokenStorage;

  /**
   * @var IApiDefinition
   */
  protected $_definition;

  /**
   * @return OAuth\Tokens\IToken|null
   */
  public function getToken()
  {
    if($this->_tokenStorage === null)
    {
      $this->setTokenStorage(new TempFileTokenStorage());
    }

    if($this->_connection === null || $this->_grant === null)
    {
      throw new \RuntimeException(
        'API Connection and Access Grant must be defined'
        . ' on the endpoint before requesting a token'
      );
    }
    return $this->_tokenStorage->retrieveToken(
      $this->_grant->getKey(),
      function ()
      {
        return $this->_grant->getToken(
          $this->_getConnection(),
          $this->_definition->getSecurityDefinition('oauth2')
        );
      }
    );
  }

  public function setApiDefinition(IApiDefinition $definition)
  {
    $this->_definition = $definition;
    $this->_baseUrl = null;
    return $this;
  }

  /**
   * @param IGrant $grant
   *
   * @return $this
   */
  public function setAccessGrant(IGrant $grant)
  {
    $this->_grant = $grant;
    return $this;
  }

  /**
   * @param ITokenStorage $storage
   *
   * @return $this
   */
  public function setTokenStorage(ITokenStorage $storage)
  {
    $this->_tokenStorage = $storage;
    return $this;
  }

  /**
   * @return IApiDefinition
   */
  public function getApiDefinition()
  {
    return $this->_definition;
  }

  protected function _buildUrl($path)
  {
    if($this->_baseUrl === null)
    {
      $schemas = $this->_definition->getSchemas();
      rsort($schemas);
      $this->_baseUrl = reset($schemas) . '://';
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
