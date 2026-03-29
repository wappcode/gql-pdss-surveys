<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Contracts\AppContextInterface;
use GPDCore\Doctrine\QueryBuilderHelper;
use GPDCore\Exceptions\GQLException;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Library\BuildSurvey;

class FieldBuildSurvey
{


    public static function createResolve()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $input = $args["input"];
            $entityManager = $context->getEntityManager();
            $entityManager->beginTransaction();
            try {
                $survey = BuildSurvey::build($context, $input);
                if (!($survey instanceof Survey)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = QueryBuilderHelper::fetchById($entityManager, Survey::class, $survey->getId(), Survey::RELATIONS_MANY_TO_ONE);
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
