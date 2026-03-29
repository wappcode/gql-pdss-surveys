<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Exceptions\GQLException;
use GPDCore\Contracts\AppContextInterface;
use GPDCore\Doctrine\QueryBuilderHelper;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Library\BuildSurveyQuestion;

class FieldBuildSurveyQuestion
{

    public static function createResolve()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $input = $args["input"];
            $entityManager = $context->getEntityManager();
            $entityManager->beginTransaction();
            try {
                $question = BuildSurveyQuestion::build($context, $input);
                if (!($question instanceof SurveyQuestion)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = QueryBuilderHelper::fetchById($entityManager, SurveyQuestion::class, $question->getId());
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
