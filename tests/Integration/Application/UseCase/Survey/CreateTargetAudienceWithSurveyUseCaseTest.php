<?php

declare(strict_types=1);

namespace Tests\Integration\Application\UseCase\Survey;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Application\Command\Survey\CreateTargetAudienceWithSurveyCommand;
use GPDSurvey\Application\UseCase\Survey\CreateTargetAudienceWithSurveyUseCase;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyTargetAudience;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyConfigurationRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyContentRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyTargetAudienceRepositoryAdapter;
use PHPUnit\Framework\TestCase;
use Tests\Support\TestBootstrap;

final class CreateTargetAudienceWithSurveyUseCaseTest extends TestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = TestBootstrap::createEntityManager();
        TestBootstrap::createSchema($this->entityManager, [
            DoctrineSurvey::class,
            DoctrineSurveyConfiguration::class,
            DoctrineSurveyContent::class,
            DoctrineSurveyTargetAudience::class,
        ]);
    }

    protected function tearDown(): void
    {
        TestBootstrap::dropSchema($this->entityManager);
        $this->entityManager->close();
    }

    public function testExecuteCreatesSurveyAndTargetAudience(): void
    {
        $configurationRepository = new DoctrineSurveyConfigurationRepositoryAdapter($this->entityManager);
        $contentRepository = new DoctrineSurveyContentRepositoryAdapter($this->entityManager, $configurationRepository);
        $surveyRepository = new DoctrineSurveyRepositoryAdapter($this->entityManager);
        $targetAudienceRepository = new DoctrineSurveyTargetAudienceRepositoryAdapter(
            $this->entityManager,
            $contentRepository,
            $configurationRepository
        );

        $useCase = new CreateTargetAudienceWithSurveyUseCase($surveyRepository, $targetAudienceRepository);

        $command = new CreateTargetAudienceWithSurveyCommand(
            'Customer satisfaction',
            'Customer satisfaction survey',
            true,
            new DateTime('2026-01-01 08:00:00'),
            new DateTime('2026-01-10 20:00:00'),
            'Welcome to the survey',
            'Thank you for your time',
            3,
            ['theme' => 'dark'],
            'secret123',
            ['layout' => 'card'],
            ['layout' => 'footer']
        );

        $targetAudience = $useCase->execute($command);

        self::assertSame('Customer satisfaction', $targetAudience->title());
        self::assertSame('Customer satisfaction', $targetAudience->survey()->title());
        self::assertTrue($targetAudience->survey()->isActive());
        self::assertSame('secret123', $targetAudience->password());
        self::assertNotNull($targetAudience->welcome());
        self::assertNotNull($targetAudience->farewell());
        self::assertNotNull($targetAudience->presentation());
        self::assertSame(3, $targetAudience->attempts());

        $persisted = $targetAudienceRepository->findById($targetAudience->id()->value());

        self::assertNotNull($persisted);
        self::assertSame($targetAudience->id()->value(), $persisted->id()->value());
        self::assertSame('Customer satisfaction', $persisted->title());
        self::assertSame($targetAudience->survey()->id()->value(), $persisted->survey()->id()->value());
        self::assertSame('secret123', $persisted->password());
        self::assertNotNull($persisted->welcome());
        self::assertNotNull($persisted->farewell());
    }
}
