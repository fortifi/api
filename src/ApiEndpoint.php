<?php
namespace Fortifi\Api\Core;

class ApiEndpoint implements IApiEndpoint
{
  protected $_connection;

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
