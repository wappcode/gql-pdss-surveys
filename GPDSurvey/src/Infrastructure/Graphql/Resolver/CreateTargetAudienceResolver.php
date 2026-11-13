<?php

namespace GPDSurvey\Infrastructure\Graphql\Resolver;

use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyConfigurationRepositoryAdapter;
use GPDSurvey\Application\UseCase\Survey\CreateTargetAudienceUseCase;
use GPDSurvey\Application\Command\Survey\CreateTargetAudienceCommand;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyContentRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyTargetAudienceRepositoryAdapter;
use GraphQL\Type\Definition\ResolveInfo;


class CreateTargetAudienceResolver
{
    public static function resolve()
    {
        return function ($root, array $args, AppContextInterface $context, ResolveInfo $info) {
            $entityManager = $context->getEntityManager();
            $configurationRepository = new DoctrineSurveyConfigurationRepositoryAdapter($entityManager);
            $contentRepository = new DoctrineSurveyContentRepositoryAdapter($entityManager, $configurationRepository);
            $targetAudienceRepository = new DoctrineSurveyTargetAudienceRepositoryAdapter($entityManager, $contentRepository, $configurationRepository);
            $surveyRepository = new DoctrineSurveyRepositoryAdapter($entityManager);
            $command = new CreateTargetAudienceCommand(
                $args['survey'],
                $args['title'],
                $args['starts'] ?? null,
                $args['ends'] ?? null,
                $args['welcomeMessage'] ?? null,
                $args['farewellMessage'] ?? null,
                $args['attempts'] ?? null,
                $args['presentation'] ?? null,
                $args['password'] ?? null,
                $args['welcomeMessagePresentation'] ?? null,
                $args['farewellMessagePresentation'] ?? null,
            );
            $useCase = new CreateTargetAudienceUseCase($targetAudienceRepository, $surveyRepository);
            $targetAudience = $useCase->execute($command);
            return $targetAudience->toArray();
        };
    }
}
