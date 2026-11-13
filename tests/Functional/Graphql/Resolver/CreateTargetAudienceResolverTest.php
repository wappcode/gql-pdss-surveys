<?php

declare(strict_types=1);

namespace Tests\Functional\Graphql\Resolver;

use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyTargetAudience;
use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\TestCase;
use Tests\Support\DoctrineTestFactory;
use Tests\Support\SurveyFactory;
use Tests\Support\TestApplicationFactory;

final class CreateTargetAudienceResolverTest extends TestCase
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

    public function testGraphqlMutationCreatesTargetAudience(): void
    {
        $survey = SurveyFactory::create($this->entityManager, 'Customer survey', true);

        $app = TestApplicationFactory::createApplication($this->entityManager);
        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_METHOD' => 'POST'],
            [],
            [
                'query' => 'mutation CreateTargetAudience($input: SurveyTargetAudienceInput!) { createTargetAudience(input: $input) { id title password survey { id title } welcome { id body } farewell { id body } presentation { id } attempts } }',
                'variables' => [
                    'input' => [
                        'survey' => $survey->getId(),
                        'title' => 'VIP Audience',
                        'starts' => '2026-01-02T10:00:00+00:00',
                        'ends' => '2026-01-15T18:00:00+00:00',
                        'welcomeMessage' => 'Welcome to our survey',
                        'farewellMessage' => 'Thanks for your time',
                        'attempts' => 5,
                        'presentation' => '{"theme":"dark"}',
                        'password' => 'secret123',
                        'welcomeMessagePresentation' => '{"layout":"hero"}',
                        'farewellMessagePresentation' => '{"layout":"footer"}',
                    ],
                ],
            ]
        );

        $response = $app->run($request);
        $payload = json_decode((string) $response->getBody(), true);

        self::assertArrayNotHasKey('errors', $payload, json_encode($payload));
        self::assertSame('VIP Audience', $payload['data']['createTargetAudience']['title']);
        self::assertSame('secret123', $payload['data']['createTargetAudience']['password']);
        self::assertSame($survey->getId(), $payload['data']['createTargetAudience']['survey']['id']);
        self::assertSame(5, $payload['data']['createTargetAudience']['attempts']);
        self::assertNotEmpty($payload['data']['createTargetAudience']['id']);
        self::assertNotNull($payload['data']['createTargetAudience']['welcome']);
        self::assertNotNull($payload['data']['createTargetAudience']['farewell']);

        $savedPayload = $this->entityManager->getRepository(DoctrineSurveyTargetAudience::class)->findOneBy(['title' => 'VIP Audience']);

        self::assertNotNull($savedPayload);
        self::assertSame('VIP Audience', $savedPayload->getTitle());
        self::assertSame($survey->getId(), $savedPayload->getSurvey()->getId());
        self::assertSame('secret123', $savedPayload->getPassword());
        self::assertSame(5, $savedPayload->getAttempts());
        self::assertNotNull($savedPayload->getWelcome());
        self::assertNotNull($savedPayload->getFarewell());
    }
}
