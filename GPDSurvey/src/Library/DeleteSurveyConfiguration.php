<?php

namespace GPDSurvey\Library;

use Exception;
use Doctrine\ORM\EntityManager;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;

final class DeleteSurveyConfiguration
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

    /**
     * Elimina un objeto SurveyConfiguration
     *
     * @param IContextService $context
     * @param integer $id
     * @return void
     */
    public static function delete(IContextService $context, int $id): void
    {
        $instance = new DeleteSurveyConfiguration($context);
        $instance->process($id);
    }

    private function __construct(IContextService $context)
    {
        $this->context = $context;
        $this->entityManager = $context->getEntityManager();
    }

    private function process(int $id): void
    {

        if (empty($id)) {
            return;
        }
        try {
            $this->entityManager->createQueryBuilder()->delete(SurveyConfiguration::class, 'entity')
                ->andWhere('entity.id = :id')
                ->setParameter(':id', $id)
                ->setMaxResults(1)
                ->getQuery()->execute();
        } catch (Exception $e) {

            // Debe lanzar excepción porque despues del error se cierra entintityManager y no se pueden hacer más consultas
            throw $e;
        }
    }
}
