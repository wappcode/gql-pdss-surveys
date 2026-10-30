<?php

namespace AppModule;

use GPDCore\Core\AbstractModule;
use GraphQL\Type\Definition\Type;

class AppModule extends AbstractModule
{

    /**
     * Array con la configuración del módulo
     *
     * @return array
     */
    function getConfig(): array
    {
        return require(__DIR__ . '/../config/module.config.php');
    }
    function getSchema(): string
    {
        return file_get_contents(__DIR__ . '/../config/gql-pdss.graphqls') ?: '';
    }
    function getServices(): array
    {
        return [
            'invokables' => [],
            'factories' => [],
            'aliases' => []
        ];
    }
    /**
     * Array con los resolvers del módulo
     *
     * @return array array(string $key => callable $resolver)
     */
    function getResolvers(): array
    {
        return [];
    }
    public function getMiddlewares(): array
    {

        return [];
    }
    /**
     * Array con los tipos scalar graphql del módulo. El indice se utiliza como nombre del tipo.
     *
     * @return array<string, ScalarType | class-string<ScalarType>>
     */
    public function getTypes(): array
    {


        return [];
    }
    /**
     * Array con las rutas REST del módulo. El indice se utiliza como path de la ruta.
     *
     * @return array<GPDCore\Routing\RouteModel>
     */
    public function getRoutes(): array
    {
        return [];
    }
}
