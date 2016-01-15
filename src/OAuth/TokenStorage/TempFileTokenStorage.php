<?php
namespace Fortifi\Api\Core\OAuth\TokenStorage;

use Fortifi\Api\Core\OAuth\Tokens\IToken;
use Packaged\Helpers\Path;

class TempFileTokenStorage implements ITokenStorage
{
  /**
   * Store a token in storage
   *
   * @param string $key location key to store the token in
   *
   * @param IToken $token
   *
   * @return bool
   */
  public function storeToken($key, IToken $token)
  {
    return file_put_contents(
      $this->_createFileName($key),
      serialize($token)
    ) !== false;
  }

  /**
   * Retrieve a token from storage
   *
   * @param string   $key      location key for token
   * @param callable $retrieve method to retireve token
   *
   * @return IToken|null
   */
  public function retrieveToken($key, callable $retrieve = null)
  {
    $location = $this->_createFileName($key);
    if(file_exists($location))
    {
      return unserialize(file_get_contents($location));
    }

    if($retrieve !== null)
    {
      $token = $retrieve();
      if($token instanceof IToken)
      {
        $this->storeToken($key, $token);
        return $token;
      }
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