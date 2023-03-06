<?php

namespace GPDSurvey\Graphql\Types;

use GPDCore\Library\AbstractConnectionTypeServiceFactory;

class TypeSurveyAnswerSessionConnection extends AbstractConnectionTypeServiceFactory
{

    const NAME = 'SurveyAnswerSessionConnection';
    const DESCRIPTION = '';
    protected static $instance = null;
}
