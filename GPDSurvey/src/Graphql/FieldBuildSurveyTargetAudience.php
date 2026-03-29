<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Doctrine\QueryBuilderHelper;
use GPDCore\Exceptions\GQLException;
use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Entities\SurveyTargetAudience;
use GPDSurvey\Library\BuildSurveyTargetAudience;

class FieldBuildSurveyTargetAudience
{


    public static function createResolve()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $input = $args["input"];
            $entityManager = $context->getEntityManager();
            $entityManager->beginTransaction();
            try {
                $audience = BuildSurveyTargetAudience::build($context, $input);
                if (!($audience instanceof SurveyTargetAudience)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = QueryBuilderHelper::fetchById($entityManager, SurveyTargetAudience::class, $audience->getId(), SurveyTargetAudience::RELATIONS_MANY_TO_ONE);
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
