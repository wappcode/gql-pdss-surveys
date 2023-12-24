<?php
return [
    "driver" => [
        'user'     =>   getenv('GQLPDSSSURVEY_DBUSER') ? getenv('GQLPDSSSURVEY_DBUSER') : 'root',
        'password' =>   getenv('GQLPDSSSURVEY_DBPASSWORD') ? getenv('GQLPDSSSURVEY_DBPASSWORD') : 'dbpassword',
        'dbname'   =>   getenv('GQLPDSSSURVEY_DBNAME') ? getenv('GQLPDSSSURVEY_DBNAME') : 'gqlpdss_surveydb',
        'driver'   =>   'pdo_mysql',
        'host'   =>     getenv('GQLPDSSSURVEY_DBHOST') ? getenv('GQLPDSSSURVEY_DBHOST') : 'localhost',
        'charset' =>    'utf8mb4'
    ],
    "entities" => require __DIR__ . "/doctrine.entities.php"
];
