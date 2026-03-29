<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Exceptions\GQLException;
use GPDCore\Contracts\AppContextInterface;
use GPDCore\Doctrine\QueryBuilderHelper;
use GPDSurvey\Entities\SurveySectionItem;
use GPDSurvey\Library\BuildSurveySectionItem;

class FieldBuildSurveySectionItem
{


    public static function createResolve()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $input = $args["input"];
            $entityManager = $context->getEntityManager();
            $entityManager->beginTransaction();
            try {
                $item = BuildSurveySectionItem::build($context, $input);
                if (!($item instanceof SurveySectionItem)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = QueryBuilderHelper::fetchById($entityManager, SurveySectionItem::class, $item->getId());
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
