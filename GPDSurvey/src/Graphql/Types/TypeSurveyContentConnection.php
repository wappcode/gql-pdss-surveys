<?php

namespace GPDSurvey\Graphql\Types;

use GPDCore\Library\AbstractConnectionTypeServiceFactory;

class TypeSurveyContentConnection extends AbstractConnectionTypeServiceFactory
{

    const NAME = 'SurveyContentConnection';
    const DESCRIPTION = '';
    protected static $instance = null;
}
