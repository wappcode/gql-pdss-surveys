<?php

namespace GPDSurvey\Graphql\Types;

use GPDCore\Library\AbstractConnectionTypeServiceFactory;

class TypeSurveyAnswerConnection extends AbstractConnectionTypeServiceFactory
{

    const NAME = 'SurveyAnswerConnection';
    const DESCRIPTION = '';
    protected static $instance = null;
}
