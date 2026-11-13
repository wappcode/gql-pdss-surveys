<?php

declare(strict_types=1);

namespace Tests\Support;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use GPDCore\Factory\EntityManagerFactory;

final class TestBootstrap
{
    public static function createEntityManager(): EntityManagerInterface
    {
        return EntityManagerFactory::createFromAttributesAndXml(
            [
                'driver' => [
                    'driver' => 'pdo_sqlite',
                    'memory' => true,
                    'path' => ':memory:',
                ],
                'entities' => require __DIR__ . '/../../dev/config/doctrine.entities.php',
                'xml' => require __DIR__ . '/../../dev/config/doctrine.xml.php',
            ],
            __DIR__ . '/../../dev/data/DoctrineORMModule',
            true
        );
    }

    public static function createSchema(EntityManagerInterface $entityManager, array $classes): void
    {
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->createSchema(array_map(
            static fn (string $class) => $entityManager->getClassMetadata($class),
            $classes
        ));
    }

    public static function dropSchema(EntityManagerInterface $entityManager): void
    {
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();

        if ($metadata === []) {
            return;
        }

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->dropSchema($metadata);
    }
}
