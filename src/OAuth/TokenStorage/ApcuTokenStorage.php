<?php
namespace Fortifi\Api\Core\OAuth\TokenStorage;

use Fortifi\Api\Core\OAuth\Tokens\IToken;

class ApcuTokenStorage implements ITokenStorage
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
    return apcu_store($this->_cacheKey($key), $token);
  }

  /**
   * Retrieve a token from storage
   *
   * @param string        $key      location key for token
   * @param callable|null $retrieve method to retireve token
   *
   * @return IToken|null
   */
  public function retrieveToken($key, ?callable $retrieve = null)
  {
    $token = apcu_fetch($this->_cacheKey($key));

    if($token instanceof IToken && $token->getExpiryTime() > time() + 60)
    {
      return $token;
    }

    if($retrieve !== null)
    {
      $token = $retrieve();
      if($token instanceof IToken)
      {
        $this->storeToken($key, $token);
      }
    }

    return $token instanceof IToken ? $token : null;
  }

  public function clearToken($key)
  {
    apcu_delete($this->_cacheKey($key));
  }

  /**
   * Create a temporary filename
   *
   * @param $key
   *
   * @return string
   */
  private function _cacheKey($key): string
  {
    return 'fortifi-api-token-' . $key;
  }
}
