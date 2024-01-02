<?php

use Doctrine\ORM\EntityManager;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswer;
use GPDSurvey\Entities\SurveyAnswerSession;

final class DeleteSurveyAnswerSession
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
        $instance = new DeleteSurveyAnswerSession($context);
        $instance->process($id);
    }

    private function __construct(IContextService $context)
    {
        $this->context = $context;
        $this->entityManager = $context->getEntityManager();
    }

    private function process(string $id): void
    {
        $exceptionInvalidEntity = throw new GQLException("Answer session doesn't exit");
        if (empty($id)) {
            throw $exceptionInvalidEntity;
        }

        $this->entityManager->beginTransaction();
        try {
            $session = $this->entityManager->find(SurveyAnswerSession::class, $id);
            if (!($session instanceof SurveyAnswerSession)) {
                throw $exceptionInvalidEntity;
            }
            $this->removeAnswers($id);
            $this->entityManager->remove($session);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
    private function removeAnswers(string $sessionId)
    {
        $this->entityManager->createQueryBuilder()->delete(SurveyAnswer::class, 'answer')
            ->andWhere("answer.session = :sessionId")
            ->setParameter(":sessionId", $sessionId)
            ->getQuery()->execute();
    }
}
