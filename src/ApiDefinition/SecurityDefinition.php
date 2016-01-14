<?php
namespace Fortifi\Api\Core\ApiDefinition;

class SecurityDefinition
{
  const TYPE_BASIC = 'basic';
  const TYPE_API_KEY = 'apiKey';
  const TYPE_OAUTH2 = 'oauth2';

  const IN_QUERY = 'query';
  const IN_HEADER = 'header';

  const FLOW_IMPLICIT = 'implicit';
  const FLOW_PASSWORD = 'password';
  const FLOW_APPLICATION = 'application';
  const FLOW_ACCESS_CODE = 'accessCode';

  public $type;
  public $description;
  public $name;
  public $in;
  public $flow;
  public $authorizationUrl;
  public $tokenUrl;
  public $scopes = [];
}
