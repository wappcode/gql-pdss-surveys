<?php

namespace GPDSurvey\Graphql\Types;

use GPDCore\Library\AbstractConnectionTypeServiceFactory;

class TypeSurveySectionConnection extends AbstractConnectionTypeServiceFactory
{

    const NAME = 'SurveySectionConnection';
    const DESCRIPTION = '';
    protected static $instance = null;
}
