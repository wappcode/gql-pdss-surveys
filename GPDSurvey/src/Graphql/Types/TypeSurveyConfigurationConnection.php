<?php

namespace GPDSurvey\Graphql\Types;

use GPDCore\Library\AbstractConnectionTypeServiceFactory;

class TypeSurveyConfigurationConnection extends AbstractConnectionTypeServiceFactory
{

    const NAME = 'SurveyConfigurationConnection';
    const DESCRIPTION = '';
    protected static $instance = null;
}
