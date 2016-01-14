<?php
namespace Fortifi\Api\Core\ApiDefinition;

class TagDefinition
{
  public $name;
  public $description;

  /**
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @param mixed $name
   *
   * @return TagDefinition
   */
  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }

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
   * @return TagDefinition
   */
  public function setDescription($description)
  {
    $this->description = $description;
    return $this;
  }

}
