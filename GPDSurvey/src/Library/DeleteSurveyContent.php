<?php

namespace GPDSurvey\Library;

use Exception;
use Doctrine\ORM\EntityManager;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyConfiguration;

final class DeleteSurveyContent
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

    /**
     * Elimna un registro SurveyContent
     * El lanzar la excepción ene caso de error es opcional
     *
     * @param IContextService $context
     * @param integer $id
     * @param boolean $trowException Determina si se lanza o no una excepción en caso de error
     * @return void
     */
    public static function delete(IContextService $context, int $id, bool $trowException = false): void
    {
        $instance = new DeleteSurveyContent($context);
        $instance->process($id, $trowException);
    }

    private function __construct(IContextService $context)
    {
        $this->context = $context;
        $this->entityManager = $context->getEntityManager();
    }

    private function process(int $id, bool $trowException): void
    {
        try {
            $qb = $this->entityManager->createQueryBuilder()->from(SurveyContent::class, 'content')
                ->leftJoin('content.presentation', 'presentation')
                ->select(["partial content.{id}", "partial presentation.{id}"]);

            $content = $qb->andWhere('content.id =:id')
                ->setParameter(':id', $id)
                ->getQuery()
                ->getOneOrNullResult();
            if (!($content instanceof SurveyContent)) {
                return;
            }
            $this->entityManager->remove($content);
            $this->entityManager->flush();
            $presentation = $content->getPresentation();
            if ($presentation instanceof SurveyConfiguration) {
                DeleteSurveyConfiguration::delete($this->context, $presentation->getId());
            }
        } catch (Exception $e) {
            // si hay error lanza la excepción solo si se configuro para hacerlo
            if ($trowException) {
                throw $e;
            }
        }
    }
}
