GPD Surveys
--------


## Instalar

Editar composer.json

    "require": {
         "wappcode/gqlpdss-surveys": "dev-master"
    }
    ....
    "repositories":[
        {
            "type": "vcs",
            "url": "git@github.com:jesus-abarca-g/gqlpdss-surveys.git"
        }
        .....
    ]


Agregar path para entities

    // config/doctrine.local.php

    "entities"=>[
        "GPDSurvey\Entities" => __DIR__."/../vendor/wappcode/gqlpdss-surveys/GPDSurvey/src/Entities",
        .....
    ]

Ejecutar

    composer dump-autoload -o

Para obtener SQL con la actualización para la base de datos usar

    vendor/bin/doctrine orm:schema-tool:update --dump-sql

Para actualizar dirctamente la base de datos usar

    vendor/bin/doctrine orm:schema-tool:update --force