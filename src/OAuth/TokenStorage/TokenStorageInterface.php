<?php
namespace Fortifi\Api\Core\OAuth\TokenStorage;

interface TokenStorageInterface
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
  public function storeToken($key, $token);

  /**
   * Retrieve a token from storage
   *
   * @param string $key location key for token
   *
   * @return string|null
   */
  public function retrieveToken($key);
}
