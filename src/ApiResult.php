<?php
namespace Fortifi\Api\Core;

class ApiResult implements IApiResult
{
  protected $_statusCode = 200;
  protected $_statusMessage = 'OK';
  protected $_content = '';
  protected $_callId = '';
  protected $_timeTaken = 0;

  /**
   * @inheritDoc
   */
  public function getStatusCode()
  {
    return $this->_statusCode;
  }

  /**
   * @inheritDoc
   */
  public function getStatusMessage()
  {
    return $this->_statusMessage;
  }

  /**
   * @inheritDoc
   */
  public function getContent()
  {
    return $this->_content;
  }

  /**
   * @inheritDoc
   */
  public function getCallId()
  {
    return $this->_callId;
  }

  /**
   * @inheritDoc
   */
  public function getTotalTime()
  {
    return $this->_timeTaken;
  }

  /**
   * @param mixed $statusCode
   */
  public function setStatusCode($statusCode)
  {
    $this->_statusCode = $statusCode;
  }

  /**
   * @param mixed $statusMessage
   */
  public function setStatusMessage($statusMessage)
  {
    $this->_statusMessage = $statusMessage;
  }

  /**
   * @param mixed $content
   */
  public function setContent($content)
  {
    $this->_content = $content;
  }

  /**
   * @param mixed $callId
   */
  public function setCallId($callId)
  {
    $this->_callId = $callId;
  }

  /**
   * @param mixed $timeTaken
   */
  public function setTotalTime($timeTaken)
  {
    $this->_timeTaken = $timeTaken;
  }
}
