<?php

namespace GPDSurvey\Library;

use Exception;
use Doctrine\ORM\EntityManager;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Entities\SurveyConfiguration;

final class DeleteSurveySection
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
        $instance = new DeleteSurveySection($context);
        $instance->process($id);
    }

    private function __construct(IContextService $context)
    {
        $this->context = $context;
        $this->entityManager = $context->getEntityManager();
    }

    private function process(string $id): void
    {
        $exceptionInvalidEntity =  new GQLException("Survey section doesn't exit");
        if (empty($id)) {
            throw $exceptionInvalidEntity;
        }
        $this->entityManager->beginTransaction();
        try {
            $qb = $this->entityManager->createQueryBuilder()->from(SurveySection::class, "section")
                ->leftJoin("section.content", "content")
                ->leftJoin("section.presentation", "presentation")
                ->leftJoin("section.items", "items")
                ->select(["partial section.{id}", "partial content.{id}", "partial presentation.{id}", "partial items.{id}"]);
            /** @var SurveySection */
            $section = $qb->andWhere("section.id = :id")
                ->setParameter(":id", $id)
                ->getQuery()->getOneOrNullResult();

            if (!($section instanceof SurveySection)) {
                throw $exceptionInvalidEntity;
            }

            $items = $section->getItems();
            foreach ($items as $item) {
                DeleteSurveySectionItem::delete($this->context, $item->getId());
            }
            $this->entityManager->remove($section);
            $this->entityManager->flush();
            $content = $section->getContent();
            if ($content instanceof SurveyContent) {
                DeleteSurveyContent::delete($this->context, $content->getId());
            }
            $presentation = $section->getPresentation();
            if ($presentation instanceof SurveyConfiguration) {
                DeleteSurveyConfiguration::delete($this->context, $presentation->getId());
            }

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
