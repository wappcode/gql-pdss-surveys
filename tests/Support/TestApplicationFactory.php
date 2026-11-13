<?php

declare(strict_types=1);

namespace Tests\Support;

use Doctrine\ORM\EntityManagerInterface;
use GPDCore\Core\AppConfig;
use GPDCore\Core\Application;
use GPDCore\Services\GraphQLServer;
use GPDSurvey\GPDSurveyModule;
use GraphqlModule\GraphqlModule;
use Laminas\Diactoros\ServerRequestFactory;

final class TestApplicationFactory
{
    public static function createApplication(?EntityManagerInterface $entityManager = null): Application
    {
        $entityManager ??= DoctrineTestFactory::createEntityManager();
        AppConfig::getInstance()->setMasterConfig([]);

        $app = new Application(AppConfig::getInstance(), $entityManager, 'testing');
        $app
            ->addModule(new GraphqlModule(route: '/api'))
            ->addModule(new GPDSurveyModule());

        return $app;
    }

    public static function createGraphQLServer(?Application $application = null): GraphQLServer
    {
        $application ??= self::createApplication();

        return new GraphQLServer(
            $application,
            null,
            null,
            true,
            15,
            1000
        );
    }

    public static function executeGraphQL(Application $app, string $query, array $variables = []): array
    {
        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_METHOD' => 'POST'],
            [],
            ['query' => $query, 'variables' => $variables]
        );

        $response = $app->run($request);
        $payload = json_decode((string) $response->getBody(), true);

        return is_array($payload) ? $payload : [];
    }
}
