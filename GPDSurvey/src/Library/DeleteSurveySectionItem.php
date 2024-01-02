<?php

use Doctrine\ORM\EntityManager;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Entities\SurveySectionItem;

final class DeleteSurveySectionItem
{


    /**
     * 
     *
     * @var IContextService
     */
    private $context;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    public static function delete(IContextService $context, int $id): void
    {
        $instance = new DeleteSurveySectionItem($context);
        $instance->process($id);
    }

    private function __construct(IContextService $context)
    {
        $this->context = $context;
        $this->entityManager = $context->getEntityManager();
    }

    private function process(int $id): void
    {
        $exceptionInvalidEntity = throw new GQLException("Survey section item doesn't exit");
        if (empty($id)) {
            throw $exceptionInvalidEntity;
        }
        $this->entityManager->beginTransaction();
        try {
            $qb = $this->entityManager->createQueryBuilder()->from(SurveySectionItem::class, "item")
                ->leftJoin("item.content", "content")
                ->leftJoin("item.question", "question")
                ->select(["partial item.{id}", "partial content.{id}", "partial question.{id}"]);
            /** @var SurveySectionItem */
            $item = $qb->andWhere("item.id = :id")
                ->setParameter(":id", $id)
                ->getQuery()->getOneOrNullResult();

            if (!($item instanceof SurveySectionItem)) {
                throw $exceptionInvalidEntity;
            }
            $this->entityManager->remove($item);
            $this->entityManager->flush();
            $content = $item->getContent();
            if ($content instanceof SurveyContent) {
                DeleteSurveyContent::delete($this->context, $content->getId());
            }
            $question = $item->getQuestion();
            if ($question instanceof SurveyQuestion) {
                DeleteSurveyQuestion::delete($this->context, $question->getId());
            }

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
