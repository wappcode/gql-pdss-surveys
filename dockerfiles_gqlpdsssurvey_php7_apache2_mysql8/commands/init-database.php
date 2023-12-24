<?php
echo "\n Preparando para inicializar base de datos \n";
$user = getenv("GQLPDSSSURVEY_DBUSER") ? getenv("GQLPDSSSURVEY_DBUSER") : 'root';
$pass = getenv("GQLPDSSSURVEY_DBPASSWORD") ?  getenv("GQLPDSSSURVEY_DBPASSWORD") : 'dbpassword';
$host = "gqlpdsssurvey-mysql";
$databasename = getenv("GQLPDSSSURVEY_DBNAME") ?  getenv("GQLPDSSSURVEY_DBNAME") : 'gqlpdss_surveydb';
$pdo = new PDO("mysql:host={$host}", $user, $pass);
echo "\n Limpiando base de datos {$databasename} \n";
$pdo->exec("DROP DATABASE IF EXISTS {$databasename};");
echo "\n Creando base de datos {$databasename};";
$pdo->exec("CREATE DATABASE IF NOT EXISTS {$databasename};");
