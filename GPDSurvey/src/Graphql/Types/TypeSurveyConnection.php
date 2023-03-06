<?php

namespace GPDSurvey\Graphql\Types;

use GPDCore\Library\AbstractConnectionTypeServiceFactory;

class TypeSurveyConnection extends AbstractConnectionTypeServiceFactory
{

    const NAME = 'SurveyConnection';
    const DESCRIPTION = '';
    protected static $instance = null;
}
