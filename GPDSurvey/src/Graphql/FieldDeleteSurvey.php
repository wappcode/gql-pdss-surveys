<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDSurvey\Entities\Survey;
use GPDCore\Library\GQLException;
use GraphQL\Type\Definition\Type;
use GPDCore\Library\EntityUtilities;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Entities\SurveySectionItem;
//TODO: separar el eliminar sections y sectionsItems en otros archivos para ser reusuados en los campos graphql delete
class FieldDeleteSurvey
{
    public static function get(IContextService $context, ?callable $proxy)
    {
        $resolver = static::createReslove();
        $proxyResolver = is_callable($proxy) ? $proxy($resolver) : $resolver;
        return [
            'type' => Type::nonNull(Type::boolean()),
            'args' => [
                'id' => Type::nonNull(Type::id()),
            ],
            'resolve' => $proxyResolver,
        ];
    }
    protected function createReslove()
    {
        return function ($root, $args, IContextService $context, $info) {
            $entityManager = $context->getEntityManager();
            if (empty($relations)) {
                $relations = EntityUtilities::getColumnAssociations($entityManager, Survey::class);
            }
            $id = $args["id"];
            if (empty($id)) {
                throw new Exception("Invalid ID");
            }
            /** @var Survey */
            $entity = $entityManager->find(Survey::class, $id);

            if (empty($entity)) {
                throw new Exception("Survey doesn't exist");
            }
            if ($entity->getActive()) {
                throw new Exception("Can delete active survey");
            }
            $entityManager->beginTransaction();
            try {
                static::removeSections($context, $entity->getId());
                static::removeQuestions($context, $entity->getId());
                $entityManager->createQueryBuilder()->delete(Survey::class, 'entity')
                    ->andWhere("entity.id = :id")
                    ->setMaxResults(1)
                    ->setParameter(':id', $id)->getQuery()->execute();
                $entityManager->flush();
                $entityManager->commit();
                return true;
            } catch (Exception $e) {
                $entityManager->rollback();
                $message = $e->getMessage();
                if (str_contains($message, "SQLSTATE") && str_contains($message, "Cannot delete or update a parent row")) {
                    throw new GQLException("Related elements must be deleted first");
                } else {
                    throw $e;
                }
            }
        };
    }

    private function getSurveyQuestionsIds(IContextService $context, $surveyId)
    {
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveyQuestion::class, 'question')
            ->select("question.id")
            ->andWhere("question.survey = :surveyId")
            ->setParameter(":surveyId", $surveyId);
        $result = $qb->getQuery()->getArrayResult();
        $ids = array_map("current", $result);
        return $ids;
    }
    private function getSurveySectionsIds(IContextService $context, $surveyId)
    {
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveySection::class, 'section')
            ->select("section.id")
            ->andWhere("section.survey = :surveyId")
            ->setParameter(":surveyId", $surveyId);
        $result = $qb->getQuery()->getArrayResult();
        $ids = array_map("current", $result);
        return $ids;
    }
    private function removeSectionItems(IContextService $context, array $sectionsIds)
    {
        if (empty($sectionsIds)) {

            return;
        }
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->delete(SurveySectionItem::class, 'entity');
        $qb->andWhere($qb->expr()->in("entity.section", ":sectionsIds"))
            ->setParameter(
                ':sectionsIds',
                $sectionsIds
            )->getQuery()->execute();
    }
    private function removeQuestions(IContextService $context, $surveyId)
    {

        try {
            $entityManager = $context->getEntityManager();
            $entityManager->createQueryBuilder()->delete(SurveyQuestion::class, 'entity')
                ->andWhere("entity.survey = :surveyId")
                ->setParameter(
                    ':surveyId',
                    $surveyId
                )->getQuery()->execute();
        } catch (Exception $e) {
            $message = $e->getMessage();
            if (str_contains($message, "SQLSTATE") && str_contains($message, "Cannot delete or update a parent row")) {
                throw new GQLException("Cannot delete survey with answers");
            } else {
                throw $e;
            }
        }
    }
    private function removeSections(IContextService $context, $surveyId)
    {
        $sectionsIds = static::getSurveySectionsIds($context, $surveyId);
        if (empty($sectionsIds)) {
            return;
        }
        static::removeSectionItems($context, $sectionsIds);
        $entityManager = $context->getEntityManager();
        $entityManager->createQueryBuilder()->delete(SurveySection::class, 'entity')
            ->andWhere("entity.survey = :surveyId")
            ->setParameter(
                ':surveyId',
                $surveyId
            )->getQuery()->execute();
    }
}
