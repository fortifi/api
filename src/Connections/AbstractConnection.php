<?php
namespace Fortifi\Api\Core\Connections;

use Fortifi\Api\Core\IApiConnection;
use Fortifi\Api\Core\IApiRequestDetail;

abstract class AbstractConnection implements IApiConnection
{
  protected $_orgFid;
  protected $_accessToken;

  /**
   * @param string $fid Organisation FID
   *
   * @return $this
   */
  public function setOrganisationFid($fid)
  {
    $this->_orgFid = $fid;
    return $this;
  }

  /**
   * @param string $token Access Token
   *
   * @return $this
   */
  public function setAccessToken($token)
  {
    $this->_accessToken = $token;
    return $this;
  }

  protected function _buildHeaders(IApiRequestDetail $request)
  {
    $headers = $request->getHeaders();
    if(!empty($this->_orgFid))
    {
      $headers['X-Fortifi-Org'] = $this->_orgFid;
    }

    if(!empty($this->_accessToken))
    {
      $headers['Authorization'] = 'Bearer ' . $this->_accessToken;
    }

    if($request->getRequestBody())
    {
      $headers['Content-Type'] = 'application/json';
    }

    return $headers;
  }

  protected function _buildData(IApiRequestDetail $request)
  {
    if($request->getRequestBody())
    {
      return $request->getRequestBody();
    }
    else
    {
      return $request->getPostFields();
    }
  }
}
