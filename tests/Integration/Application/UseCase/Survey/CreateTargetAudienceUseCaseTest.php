<?php

declare(strict_types=1);

namespace Tests\Integration\Application\UseCase\Survey;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Application\Command\Survey\CreateTargetAudienceCommand;
use GPDSurvey\Application\UseCase\Survey\CreateTargetAudienceUseCase;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyTargetAudience;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyConfigurationRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyContentRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyRepositoryAdapter;
use GPDSurvey\Infrastructure\Doctrine\Provider\Repository\DoctrineSurveyTargetAudienceRepositoryAdapter;
use PHPUnit\Framework\TestCase;
use Tests\Support\DoctrineTestFactory;
use Tests\Support\SurveyFactory;

final class CreateTargetAudienceUseCaseTest extends TestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = DoctrineTestFactory::createEntityManager();
        DoctrineTestFactory::createSchema($this->entityManager, [
            DoctrineSurvey::class,
            DoctrineSurveyConfiguration::class,
            DoctrineSurveyContent::class,
            DoctrineSurveyTargetAudience::class,
        ]);
    }

    protected function tearDown(): void
    {
        DoctrineTestFactory::dropSchema($this->entityManager);
        $this->entityManager->close();
    }

    public function testExecuteCreatesAndPersistsTargetAudience(): void
    {
        $survey = SurveyFactory::create($this->entityManager, 'Customer satisfaction', true);

        $configurationRepository = new DoctrineSurveyConfigurationRepositoryAdapter($this->entityManager);
        $contentRepository = new DoctrineSurveyContentRepositoryAdapter($this->entityManager, $configurationRepository);
        $targetAudienceRepository = new DoctrineSurveyTargetAudienceRepositoryAdapter(
            $this->entityManager,
            $contentRepository,
            $configurationRepository
        );
        $surveyRepository = new DoctrineSurveyRepositoryAdapter($this->entityManager);

        $useCase = new CreateTargetAudienceUseCase($targetAudienceRepository, $surveyRepository);
        $command = new CreateTargetAudienceCommand(
            $survey->getId(),
            'VIP Audience',
            new DateTime('2026-01-02 10:00:00'),
            new DateTime('2026-01-15 18:00:00'),
            'Welcome to our survey',
            'Thanks for your participation',
            5,
            ['theme' => 'dark'],
            'secret123',
            ['layout' => 'hero'],
            ['layout' => 'footer']
        );

        $targetAudience = $useCase->execute($command);

        self::assertSame('VIP Audience', $targetAudience->title());
        self::assertSame($survey->getId(), $targetAudience->survey()->id()->value());
        self::assertSame('secret123', $targetAudience->password());
        self::assertSame(5, $targetAudience->attempts());
        self::assertNotNull($targetAudience->welcome());
        self::assertNotNull($targetAudience->farewell());
        self::assertNotNull($targetAudience->presentation());

        $persisted = $targetAudienceRepository->findById($targetAudience->id()->value());

        self::assertNotNull($persisted);
        self::assertSame($targetAudience->id()->value(), $persisted->id()->value());
        self::assertSame('VIP Audience', $persisted->title());
        self::assertSame($survey->getId(), $persisted->survey()->id()->value());
        self::assertSame('secret123', $persisted->password());
        self::assertSame(5, $persisted->attempts());
        self::assertNotNull($persisted->welcome());
        self::assertNotNull($persisted->farewell());
        self::assertNotNull($persisted->presentation());
    }
}
