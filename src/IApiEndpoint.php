<?php
namespace Fortifi\Api\Core;

use Fortifi\Api\Core\ApiDefinition\IApiDefinition;

interface IApiEndpoint extends IApiConnectionAware
{
  public function setApiDefinition(IApiDefinition $definition);

  /**
   * @return IApiDefinition
   */
  public function getApiDefinition();

  /**
   * @return bool
   */
  public function hasConnection();
}
