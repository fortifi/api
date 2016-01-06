<?php
namespace Fortifi\Api\Core;

class ApiRequestDetail implements IApiRequestDetail
{
  protected $_url = '';
  protected $_headers = [];
  protected $_options = [];
  protected $_post = [];
  protected $_query = [];
  protected $_body = '';
  protected $_method = 'GET';
  protected $_isAsync = false;

  /**
   * @inheritDoc
   */
  public function getUrl()
  {
    return $this->_url;
  }

  /**
   * @inheritDoc
   */
  public function getHeaders()
  {
    return $this->_headers;
  }

  /**
   * @inheritDoc
   */
  public function getOptions()
  {
    return $this->_options;
  }

  /**
   * @inheritDoc
   */
  public function getPostFields()
  {
    return $this->_post;
  }

  /**
   * @inheritDoc
   */
  public function getQueryFields()
  {
    return $this->_query;
  }

  /**
   * @inheritDoc
   */
  public function getRequestBody()
  {
    return $this->_body;
  }

  /**
   * @inheritDoc
   */
  public function getMethod()
  {
    return $this->_method;
  }

  /**
   * @inheritDoc
   */
  public function isAync()
  {
    return $this->_isAsync;
  }

  /**
   * @param string $url
   *
   * @return ApiRequestDetail
   */
  public function setUrl($url)
  {
    $this->_url = $url;
    return $this;
  }

  /**
   * @param array $headers
   *
   * @return ApiRequestDetail
   */
  public function setHeaders(array $headers)
  {
    $this->_headers = $headers;
    return $this;
  }

  /**
   * @param array $options
   *
   * @return ApiRequestDetail
   */
  public function setOptions(array $options)
  {
    $this->_options = $options;
    return $this;
  }

  /**
   * @param array $post
   *
   * @return ApiRequestDetail
   */
  public function setPostFields(array $post)
  {
    $this->_post = $post;
    return $this;
  }

  /**
   * @param array $query
   *
   * @return ApiRequestDetail
   */
  public function setQueryFields(array $query)
  {
    $this->_query = $query;
    return $this;
  }

  /**
   * @param string $body
   *
   * @return ApiRequestDetail
   */
  public function setBody($body)
  {
    $this->_body = $body;
    return $this;
  }

  /**
   * @param string $method
   *
   * @return ApiRequestDetail
   */
  public function setMethod($method)
  {
    $this->_method = $method;
    return $this;
  }

  /**
   * @param boolean $isAsync
   *
   * @return ApiRequestDetail
   */
  public function setAsync($isAsync)
  {
    $this->_isAsync = $isAsync;
    return $this;
  }

}