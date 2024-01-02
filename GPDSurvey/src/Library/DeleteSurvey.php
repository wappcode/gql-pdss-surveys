<?php

namespace GPDSurvey\Library;

use Exception;
use GPDSurvey\Entities\Survey;
use Doctrine\ORM\EntityManager;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;

final class DeleteSurvey
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

    public static function delete(IContextService $context, string $id): void
    {
        $instance = new DeleteSurvey($context);
        $instance->process($id);
    }

    private function __construct(IContextService $context)
    {
        $this->context = $context;
        $this->entityManager = $context->getEntityManager();
    }

    private function process(string $id): void
    {
        $exceptionInvalidEntity = new GQLException("Survey doesn't exit");
        if (empty($id)) {
            throw $exceptionInvalidEntity;
        }

        $this->entityManager->beginTransaction();
        try {
            $qb = $this->entityManager->createQueryBuilder()->from(Survey::class, 'survey')
                ->leftJoin('survey.targetAudiences', 'targetAudiences')
                ->leftJoin('survey.sections', 'sections')
                ->select(["partial survey.{id,active}", 'partial targetAudiences.{id}', 'partial sections.{id}']);
            /**@var Survey */
            $survey = $qb->andWhere("survey.id = :id")
                ->setParameter(":id", $id)
                ->getQuery()
                ->getOneOrNullResult();

            if (!($survey instanceof Survey)) {
                throw $exceptionInvalidEntity;
            }
            if ($survey->getActive()) {
                throw new GQLException("Can delete active survey");
            }
            $sections = $survey->getSections();
            foreach ($sections as $section) {
                DeleteSurveySection::delete($this->context, $section->getId());
            }
            $audience = $survey->getTargetAudiences();
            foreach ($audience as $audience) {
                DeleteSurveyTargetAudience::delete($this->context, $audience->getId());
            }
            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
