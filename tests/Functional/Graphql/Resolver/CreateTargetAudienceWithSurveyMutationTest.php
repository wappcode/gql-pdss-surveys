<?php

declare(strict_types=1);

namespace Tests\Functional\Graphql\Resolver;

use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyTargetAudience;
use PHPUnit\Framework\TestCase;
use Tests\Support\DoctrineTestFactory;
use Tests\Support\TestApplicationFactory;

final class CreateTargetAudienceWithSurveyMutationTest extends TestCase
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

    public function testCreateTargetAudienceWithSurveyMutation(): void
    {
        $app = TestApplicationFactory::createApplication($this->entityManager);

        $payload = TestApplicationFactory::executeGraphQL(
            $app,
            'mutation CreateTargetAudienceWithSurvey($input: CreateTargetAudienceWithSurveyInput!) { createTargetAudienceWithSurvey(input: $input) { id title survey { id title } welcome { id body } farewell { id body } attempts password } }',
            [
                'input' => [
                    'title' => 'Audience for survey',
                    'description' => 'Audience for survey description',
                    'active' => true,
                    'starts' => '2026-01-02T10:00:00+00:00',
                    'ends' => '2026-01-15T18:00:00+00:00',
                    'welcomeMessage' => 'Welcome to the survey',
                    'farwellMessage' => 'Thanks for participating',
                    'attempts' => 3,
                    'presentation' => '{"theme":"dark"}',
                    'password' => 'secret123',
                    'welcomeMessagePresentation' => '{"layout":"hero"}',
                    'farewellMessagePresentation' => '{"layout":"footer"}',
                ],
            ]
        );

        self::assertArrayNotHasKey('errors', $payload, json_encode($payload));
        self::assertSame('Audience for survey', $payload['data']['createTargetAudienceWithSurvey']['title']);
        self::assertSame('secret123', $payload['data']['createTargetAudienceWithSurvey']['password']);
        self::assertSame(3, $payload['data']['createTargetAudienceWithSurvey']['attempts']);
        self::assertNotEmpty($payload['data']['createTargetAudienceWithSurvey']['id']);
        self::assertNotNull($payload['data']['createTargetAudienceWithSurvey']['welcome']);
        self::assertNotNull($payload['data']['createTargetAudienceWithSurvey']['farewell']);

        $savedAudience = $this->entityManager->getRepository(DoctrineSurveyTargetAudience::class)->findOneBy(['title' => 'Audience for survey']);
        self::assertNotNull($savedAudience);
        self::assertSame('Audience for survey', $savedAudience->getTitle());
        self::assertSame('secret123', $savedAudience->getPassword());
        self::assertSame(3, $savedAudience->getAttempts());
        self::assertNotNull($savedAudience->getWelcome());
        self::assertNotNull($savedAudience->getFarewell());
        self::assertNotNull($savedAudience->getSurvey());
    }
}
