<?php

namespace GPDSurvey\Graphql\Types;

use GPDCore\Library\AbstractConnectionTypeServiceFactory;

class TypeSurveyQuestionOptionConnection extends AbstractConnectionTypeServiceFactory
{

    const NAME = 'SurveyQuestionOptionConnection';
    const DESCRIPTION = '';
    protected static $instance = null;
}
