<?php

declare(strict_types=1);

namespace Tests\Functional\Graphql\Resolver;

use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;
use PHPUnit\Framework\TestCase;
use Tests\Support\TestApplicationFactory;
use Tests\Support\TestBootstrap;

final class CreateSurveyMutationTest extends TestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = TestBootstrap::createEntityManager();
        TestBootstrap::createSchema($this->entityManager, [
            DoctrineSurvey::class,
        ]);
    }

    protected function tearDown(): void
    {
        TestBootstrap::dropSchema($this->entityManager);
        $this->entityManager->close();
    }

    public function testCreateSurveyMutation(): void
    {
        $app = TestApplicationFactory::createApplication($this->entityManager);

        $payload = TestApplicationFactory::executeGraphQL(
            $app,
            'mutation CreateSurvey($input: SurveyInput!) { createSurvey(input: $input) { id title active } }',
            [
                'input' => [
                    'title' => 'Survey created via GraphQL',
                    'active' => true,
                ],
            ]
        );

        self::assertArrayNotHasKey('errors', $payload, json_encode($payload));
        self::assertSame('Survey created via GraphQL', $payload['data']['createSurvey']['title']);
        self::assertTrue((bool) $payload['data']['createSurvey']['active']);
        self::assertNotEmpty($payload['data']['createSurvey']['id']);

        $savedSurvey = $this->entityManager->getRepository(DoctrineSurvey::class)->findOneBy(['title' => 'Survey created via GraphQL']);
        self::assertNotNull($savedSurvey);
        self::assertTrue($savedSurvey->getActive());
    }
}
