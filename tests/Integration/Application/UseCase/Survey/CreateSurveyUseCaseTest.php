<?php

declare(strict_types=1);

namespace Tests\Integration\Application\UseCase\Survey;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use GPDSurvey\Application\Command\Survey\CreateSurveyCommand;
use GPDSurvey\Application\UseCase\Survey\CreateSurveyUseCase;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyRepositoryAdapter;
use PHPUnit\Framework\TestCase;
use Tests\Support\DoctrineTestFactory;

final class CreateSurveyUseCaseTest extends TestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = DoctrineTestFactory::createEntityManager();
        DoctrineTestFactory::createSchema($this->entityManager, [DoctrineSurvey::class]);
    }

    protected function tearDown(): void
    {
        DoctrineTestFactory::dropSchema($this->entityManager);
        $this->entityManager->close();
    }

    public function testExecuteCreatesAndPersistsSurvey(): void
    {
        $repository = new DoctrineSurveyRepositoryAdapter($this->entityManager);
        $useCase = new CreateSurveyUseCase($repository);

        $survey = $useCase->execute(new CreateSurveyCommand('Customer satisfaction', true));

        self::assertSame('Customer satisfaction', $survey->title());
        self::assertTrue($survey->isActive());
        self::assertNotSame('', $survey->id()->value());
        self::assertMatchesRegularExpression('/^[0-9A-HJKMNP-TV-Z]{26}$/', $survey->id()->value());

        $persistedSurvey = $repository->findById($survey->id()->value());

        self::assertNotNull($persistedSurvey);
        self::assertSame($survey->id()->value(), $persistedSurvey->id()->value());
        self::assertSame('Customer satisfaction', $persistedSurvey->title());
        self::assertTrue($persistedSurvey->isActive());
    }
}
