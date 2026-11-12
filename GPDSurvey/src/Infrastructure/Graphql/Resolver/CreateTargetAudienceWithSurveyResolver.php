<?php

namespace GPDSurvey\Infrastructure\Graphql\Resolver;

use GPDCore\Contracts\AppContextInterface;

use GPDSurvey\Application\Command\Survey\CreateTargetAudienceWithSurveyCommand;
use GPDSurvey\Application\UseCase\Survey\CreateTargetAudienceWithSurveyUseCase;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyConfigurationRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyContentRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyTargetAudienceRepositoryAdapter;
use GraphQL\Type\Definition\ResolveInfo;

class CreateTargetAudienceWithSurveyResolver
{
    public static function resolve()
    {
        return function ($root, $args, AppContextInterface $context, ResolveInfo $info) {
            $entityManager = $context->getEntityManager();
            $surveyRepository = new DoctrineSurveyRepositoryAdapter($entityManager);
            $configurationRepository = new DoctrineSurveyConfigurationRepositoryAdapter($entityManager);
            $contentRepository = new DoctrineSurveyContentRepositoryAdapter($entityManager, $configurationRepository);
            $targetAudienceRepository = new DoctrineSurveyTargetAudienceRepositoryAdapter($entityManager, $contentRepository, $configurationRepository);
            $useCase = new CreateTargetAudienceWithSurveyUseCase($surveyRepository, $targetAudienceRepository);
            $input = $args['input'] ?? [];
            $command = new CreateTargetAudienceWithSurveyCommand(
                $input['title'],
                $input['description'],
                $input['active'],
                $input['starts'] ?? null,
                $input['ends'] ?? null,
                $input['welcomeMessage'] ?? null,
                $input['farwellMessage'] ?? null,
                $input['attempts'] ?? null,
                $input['presentation'] ?? null,
                $input['password'] ?? null,
                $input['welcomeMessagePresentation'] ?? null,
                $input['farewellMessagePresentation'] ?? null,
            );
            $entityManager->beginTransaction();
            try {
                $survey = $useCase->execute($command);
                $entityManager->commit();
                $result = $survey->toArray();
                return $result;
            } catch (\Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
