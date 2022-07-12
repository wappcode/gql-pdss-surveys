<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\Library\ResolverFactory;
use GPDSurvey\Graphql\BufferSurveyQuestion;
use GPDSurvey\Graphql\BufferSurveyAnswerSession;

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
        $resolver = ResolverFactory::createEntityResolver(BufferSurveyQuestion::getInstance(), 'question');
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
        $resolver = ResolverFactory::createEntityResolver(BufferSurveyAnswerSession::getInstance(), 'session');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
