<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Exceptions\GQLException;
use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Library\BuildSurveySection;
use GPDCore\Doctrine\QueryBuilderHelper;

class FieldBuildSurveySection
{


    public static function createResolve()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $input = $args["input"];
            $entityManager = $context->getEntityManager();
            $entityManager->beginTransaction();
            try {
                $section = BuildSurveySection::build($context, $input);
                if (!($section instanceof SurveySection)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = QueryBuilderHelper::fetchById($entityManager, SurveySection::class, $section->getId());
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
