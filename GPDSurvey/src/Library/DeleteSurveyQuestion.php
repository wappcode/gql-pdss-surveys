<?php

namespace GPDSurvey\Library;

use Exception;
use Doctrine\ORM\EntityManager;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveyConfiguration;

final class DeleteSurveyQuestion
{


    /**
     * 
     *
     * @var IContextService
     */
    private $context;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public static function delete(IContextService $context, string $id): void
    {
        $instance = new DeleteSurveyQuestion($context);
        $instance->process($id);
    }

    private function __construct(IContextService $context)
    {
        $this->context = $context;
        $this->entityManager = $this->context->getEntityManager();
    }

    private function process(string $id): void
    {
        $exceptionInvalidEntity =  new GQLException("Question doesn't exit");
        if (empty($id)) {
            throw $exceptionInvalidEntity;
        }
        $this->entityManager->beginTransaction();
        try {
            $qb = $this->entityManager->createQueryBuilder()->from(SurveyQuestion::class, 'question')
                ->leftJoin("question.content", "content")
                ->leftJoin("question.presentation", "presentation")
                ->leftJoin("question.validators", "validators")
                ->leftJoin("question.answerScore", "answerScore")
                ->leftJoin("question.options", "options")
                ->select(['partial question.{id}', 'partial content.{id}', 'partial presentation.{id}', 'partial options.{id}']);
            /** @var SurveyQuestion */
            $question = $qb->andWhere("question.id = :id")
                ->setParameter(":id", $id)
                ->getQuery()
                ->getOneOrNullResult();

            if (!($question instanceof SurveyQuestion)) {
                throw $exceptionInvalidEntity;
            }
            $options = $question->getOptions();
            foreach ($options as $option) {
                DeleteSurveyQuestionOption::delete($this->context, $option->getId());
            }
            $presentation = $question->getPresentation();
            if ($presentation instanceof SurveyConfiguration) {
                DeleteSurveyConfiguration::delete($this->context, $presentation->getId());
            }
            $content = $question->getContent();
            if ($content instanceof SurveyContent) {
                DeleteSurveyContent::delete($this->context, $content->getId());
            }
            $this->entityManager->remove($question);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            $message = $e->getMessage();
            if (str_contains($message, "SQLSTATE") && str_contains($message, "Cannot delete or update a parent row") && str_contains($message, "answer")) {
                throw new GQLException("Cannot delete questions with answers");
            } else {
                throw $e;
            }
        }
    }
}
