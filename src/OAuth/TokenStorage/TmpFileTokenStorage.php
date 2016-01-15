<?php
namespace Fortifi\Api\Core\OAuth\TokenStorage;

use Packaged\Helpers\Path;

class TmpFileTokenStorage implements TokenStorageInterface
{
  /**
   * Store a token in storage
   *
   * @param string $key location key to store the token in
   *
   * @param string $token
   *
   * @return bool
   */
  public function storeToken($key, $token)
  {
    return file_put_contents($this->_createFileName($key), $token) !== false;
  }

  /**
   * Retrieve a token from storage
   *
   * @param string $key location key for token
   *
   * @return string|null
   */
  public function retrieveToken($key)
  {
    $location = $this->_createFileName($key);
    if(file_exists($location))
    {
      return file_get_contents($location);
    }
    return null;
  }

  /**
   * Create a temporary filename
   *
   * @param $key
   *
   * @return string
   */
  private function _createFileName($key)
  {
    return Path::build(sys_get_temp_dir(), 'Fortifi-Token-' . $key);
  }
}
