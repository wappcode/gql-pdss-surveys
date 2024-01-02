<?php

use Doctrine\ORM\EntityManager;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveyQuestionOption;
use Symfony\Component\Console\Question\Question;

final class DeleteSurveyQuestionOption
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

    public static function delete(IContextService $context, int $id): void
    {
        $instance = new DeleteSurveyQuestionOption($context);
        $instance->process($id);
    }

    private function __construct(IContextService $context)
    {
        $this->context = $context;
    }

    private function process(int $id): void
    {
        $exceptionInvalidOption = throw new GQLException("Question option doesn't exit");
        if (empty($id)) {
            throw $exceptionInvalidOption;
        }
        $qb = $this->entityManager->createQueryBuilder()->from(SurveyQuestionOption::class, 'option')
            ->leftJoin("option.content", "content")
            ->leftJoin("option.presentantion", "presentation");
        $option = $qb->andWhere("option.id = :id")
            ->setParameter(':id', $id)
            ->getQuery()->getOneOrNullResult();
        if (!($option instanceof SurveyQuestionOption)) {
            throw $exceptionInvalidOption;
        }
        $this->entityManager->remove($option);
        $this->entityManager->flush();
    }
}
