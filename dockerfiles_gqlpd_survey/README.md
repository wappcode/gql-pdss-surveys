# Docker de desarrollo

Este directorio contiene configuracion Docker para entorno local de desarrollo.

No forma parte de los artefactos distribuidos de la libreria en Composer.

## Servicios

- `gqlpdsssurvey-mysql` (MySQL 8)
- `gqlpdsssurvey-php` (PHP/Apache)

## Levantar entorno

```bash
docker compose up
```

Con puertos y credenciales personalizadas:

```bash
GQLPDSSSURVEY_APP_PORT=8080 \
GQLPDSSSURVEY_MYSQL_PORT=3308 \
GQLPDSSSURVEY_DBPASSWORD=dbpassword \
docker compose up
```

Recompilar imagenes:

```bash
docker compose build
```

## Crear base de datos

Con servicios arriba, cargar un SQL:

```bash
mysql --port 3308 -h 127.0.0.1 -uroot -pdbpassword procesot_survey < ~/archivosbd.sql
```

## Shell del contenedor PHP

```bash
docker exec -it gqlpdsssurvey-php7.4 bash
```

## Xdebug en VS Code

Agregar en `launch.json`:

```json
{
    "name": "Docker Listen for Xdebug",
    "type": "php",
    "request": "launch",
    "port": 9003,
    "pathMappings": {
        "/var/www/html": "${workspaceFolder}"
    },
    "hostname": "localhost"
}
```

`hostname` es util en WSL/Windows.
