<?php
namespace Fortifi\Api\Core\ApiDefinition;

class DocumentationDefinition
{
  public $description;
  public $url;

  /**
   * @return mixed
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * @param mixed $description
   *
   * @return DocumentationDefinition
   */
  public function setDescription($description)
  {
    $this->description = $description;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * @param mixed $url
   *
   * @return DocumentationDefinition
   */
  public function setUrl($url)
  {
    $this->url = $url;
    return $this;
  }

}
