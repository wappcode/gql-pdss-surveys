<?php

namespace GPDSurvey\Infrastructure\Graphql\Resolver;

use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyRepositoryAdapter;
use GPDSurvey\Application\UseCase\Survey\CreateSurveyUseCase;
use GPDSurvey\Application\Command\Survey\CreateSurveyCommand;

class CreateSurveyResolver
{



    public static function resolve()
    {
        return function ($root, array $args, AppContextInterface $context, $info) {
            $entityManger = $context->getEntityManager();
            $surveyRepository = new DoctrineSurveyRepositoryAdapter($entityManger);
            $input = $args['input'];
            $command = new CreateSurveyCommand($input['title'], $input['active']);
            $useCase = new CreateSurveyUseCase($surveyRepository);
            $survey = $useCase->execute($command);
            return $survey->toArray();
        };
    }
}
