<?php

namespace GPDSurvey\Library;

use Exception;
use Doctrine\ORM\EntityManager;
use GPDCore\Exceptions\GQLException;
use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyTargetAudience;

final class DeleteSurveyTargetAudience
{


    /**
     * 
     *
     * @var AppContextInterface
     */
    private $context;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    public static function delete(AppContextInterface $context, string $id): void
    {
        $instance = new DeleteSurveyTargetAudience($context);
        $instance->process($id);
    }

    private function __construct(AppContextInterface $context)
    {
        $this->context = $context;
        $this->entityManager = $context->getEntityManager();
    }

    private function process(string $id): void
    {
        $exceptionInvalidEntity =  new GQLException("Survey target audience doesn't exit");
        if (empty($id)) {
            throw $exceptionInvalidEntity;
        }
        $this->entityManager->beginTransaction();
        try {
            $qb = $this->entityManager->createQueryBuilder()->from(SurveyTargetAudience::class, "audience")
                ->leftJoin("audience.welcome", "welcome")
                ->leftJoin("audience.farewell", "farewell")
                ->leftJoin("audience.presentation", "presentation")
                ->select(["partial audience.{id}", "partial welcome.{id}", "partial farewell.{id}", "partial presentation.{id}"]);
            /** @var SurveyTargetAudience */
            $audience = $qb->andWhere("audience.id = :id")
                ->setParameter(":id", $id)
                ->getQuery()->getOneOrNullResult();

            if (!($audience instanceof SurveyTargetAudience)) {
                throw $exceptionInvalidEntity;
            }
            $hasAnswers = $this->hasAnwers($id);
            if ($hasAnswers) {
                throw new GQLException("Can not be deleted, there are answers");
            }
            $this->entityManager->remove($audience);
            $this->entityManager->flush();
            $welcome = $audience->getWelcome();
            if ($welcome instanceof SurveyContent) {
                DeleteSurveyContent::delete($this->context, $welcome->getId());
            }
            $farewell = $audience->getFarewell();
            if ($farewell instanceof SurveyContent) {
                DeleteSurveyContent::delete($this->context, $farewell->getId());
            }
            $presentation = $audience->getPresentation();
            if ($presentation instanceof SurveyConfiguration) {
                DeleteSurveyConfiguration::delete($this->context, $presentation->getId());
            }

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    private function hasAnwers(string $targetAudienceId)
    {
        $qb = $this->entityManager->createQueryBuilder()->from(SurveyAnswerSession::class, 'session')
            ->select(['count(session.id)']);
        $total = $qb->andWhere("session.targetAudience =:targetAudienceId")->setParameter(":targetAudienceId", $targetAudienceId)
            ->getQuery()->getSingleScalarResult();
        return intval($total) > 0;
    }
}
