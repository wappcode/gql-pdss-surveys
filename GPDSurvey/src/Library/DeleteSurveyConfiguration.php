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
     * El lanzar la excepción ene caso de error es opcional
     *
     * @param IContextService $context
     * @param integer $id
     * @param boolean $trowException Determina si se lanza o no una excepción en caso de error
     * @return void
     */
    public static function delete(IContextService $context, int $id, bool $trowException = false): void
    {
        $instance = new DeleteSurveyConfiguration($context);
        $instance->process($id, $trowException);
    }

    private function __construct(IContextService $context)
    {
        $this->context = $context;
        $this->entityManager = $context->getEntityManager();
    }

    private function process(int $id, bool $trowException): void
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
            // si hay error lanza la excepción solo si se configuro para hacerlo
            if ($trowException) {
                throw $e;
            }
        }
    }
}
