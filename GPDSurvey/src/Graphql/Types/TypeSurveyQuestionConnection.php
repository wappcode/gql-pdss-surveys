<?php

namespace GPDSurvey\Graphql\Types;

use GPDCore\Library\AbstractConnectionTypeServiceFactory;

class TypeSurveyQuestionConnection extends AbstractConnectionTypeServiceFactory
{

    const NAME = 'SurveyQuestionConnection';
    const DESCRIPTION = '';
    protected static $instance = null;
}
