<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDCore\Library\ResolverFactory;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyQuestion;

class ResolversSurveyAnswer
{
    /**
     * Recupera una function ($source, $args, $context, $info) con los resultados de la consulta
     *
     * @param callable|null $proxy
     * @return callable
     */
    public static function getQuestionResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'question');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    /**
     * Recupera una function ($source, $args, $context, $info) con los resultados de la consulta
     *
     * @param callable|null $proxy
     * @return callable
     */
    public static function getSessionResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(SurveyAnswerSession::class, SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'session');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
