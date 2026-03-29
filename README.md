# GPD Survey Module (`wappcode/gql-pdss-surveys`)

Modulo para administrar cuestionarios sobre `wappcode/gqlpdss`.

Incluye:

- Esquema GraphQL para encuestas, secciones, preguntas, respuestas y sesiones.
- Resolvers CRUD automaticos con Doctrine.
- Mutations de construccion (`build*`) para operaciones compuestas.
- Utilidades de dominio en `GPDSurvey\Library`.

## Requisitos

- PHP 8.2+
- Doctrine ORM 3
- `wappcode/gqlpdss` 5.x

## Instalacion

Agregar dependencia:

```json
{
    "require": {
        "wappcode/gql-pdss-surveys": "^4.0"
    }
}
```

Registrar entidades en `config/doctrine.local.php`:

```php
<?php

return [
        "driver" => [
                "user" => "root",
                "password" => "dbpassword",
                "dbname" => "procesot_survey",
                "driver" => "pdo_mysql",
                "host" => "127.0.0.1",
                "charset" => "utf8mb4"
        ],
        "entities" => [
                "GPDSurvey\\Entities" => __DIR__ . "/../vendor/wappcode/gql-pdss-surveys/GPDSurvey/src/Entities",
        ]
];
```

Actualizar autoload:

```bash
composer dump-autoload -o
```

Generar SQL de actualizacion:

```bash
bin/doctrine orm:schema-tool:update --dump-sql
```

Aplicar cambios en base de datos:

```bash
bin/doctrine orm:schema-tool:update --force
```

## Registro del modulo en la aplicacion

Ejemplo de `public/index.php`:

```php
<?php

use AppModule\AppModule;
use GPDCore\Core\AppConfig;
use GPDCore\Core\Application;
use GPDCore\Factory\EntityManagerFactory;
use GPDSurvey\GPDSurveyModule;
use GraphqlModule\GraphqlModule;

// ... bootstrap

$app
        ->addModule(new GraphqlModule(route: '/api'))
        ->addModule(GPDSurveyModule::class)
        ->addModule(AppModule::class);
```

Con esa configuracion, el endpoint GraphQL queda en:

- `POST /api`
- `GET /api` en entorno no productivo

## Uso de GraphQL

Formato de request:

```json
{
    "query": "query Q($id: ID!) { getSurvey(id: $id) { id title active } }",
    "variables": {
        "id": "gqt03d4086ab23209f12247449ec693aa05"
    },
    "operationName": "Q"
}
```

## Queries disponibles

Las queries del modulo se definen en `GPDSurvey/src/GPDSurveyModule.php` y `GPDSurvey/config/survey-schema.graphql`:

- `getSurveys(input: ConnectionInput): SurveyConnection`
- `getSurvey(id: ID!): Survey`
- `getSurveyTargetAudiences(input: ConnectionInput): SurveyTargetAudienceConnection`
- `getSurveyTargetAudience(id: ID!): SurveyTargetAudience`
- `getSurveyAnswers(input: ConnectionInput): SurveyAnswerConnection`
- `getSurveyAnswer(id: ID!): SurveyAnswer`
- `getSurveyConfigurations(input: ConnectionInput): SurveyConfigurationConnection`
- `getSurveyConfiguration(id: ID!): SurveyConfiguration`
- `getSurveyContents(input: ConnectionInput): SurveyContentConnection`
- `getSurveyContent(id: ID!): SurveyContent`
- `getSurveyQuestions(input: ConnectionInput): SurveyQuestionConnection`
- `getSurveyQuestion(id: ID!): SurveyQuestion`
- `getSurveyQuestionOptions(input: ConnectionInput): SurveyQuestionOptionConnection`
- `getSurveyQuestionOption(id: ID!): SurveyQuestionOption`
- `getSurveySections(input: ConnectionInput): SurveySectionConnection`
- `getSurveySection(id: ID!): SurveySection`
- `getSurveySectionItems(input: ConnectionInput): SurveySectionItemConnection`
- `getSurveySectionItem(id: ID!): SurveySectionItem`
- `getSurveyAnswerSessions(input: ConnectionInput): SurveyAnswerSessionConnection`
- `getSurveyAnswerSession(id: ID!): SurveyAnswerSession`
- `findSurveyAnswerSessionByUsernameAndPassword(targetAudience: ID!, username: String!, password: String!): SurveyAnswerSession`
- `findSurveyAnswerSessionByOwnerCode(targetAudience: ID!, ownerCode: String!): SurveyAnswerSession`

### Ejemplos de query

Query de conexion con paginacion, filtros y orden:

```graphql
query GetSurveys($input: ConnectionInput) {
    getSurveys(input: $input) {
        totalCount
        edges {
            node {
                id
                title
                active
            }
        }
        pageInfo {
            hasNextPage
            endCursor
        }
    }
}
```

Variables:

```json
{
    "input": {
        "pagination": { "first": 10 },
        "filters": [
            {
                "groupLogic": "AND",
                "conditionsLogic": "AND",
                "conditions": [
                    {
                        "filterOperator": "EQUAL",
                        "property": "active",
                        "value": { "single": "1" }
                    }
                ]
            }
        ],
        "sorts": [
            { "property": "title", "direction": "ASC" }
        ]
    }
}
```

Busqueda de sesion por credenciales:

```graphql
query FindSession($targetAudience: ID!, $username: String!, $password: String!) {
    findSurveyAnswerSessionByUsernameAndPassword(
        targetAudience: $targetAudience
        username: $username
        password: $password
    ) {
        id
        completed
        score
        scorePercent
    }
}
```

## Mutations disponibles

Las mutations del modulo:

- `buildSurvey(input: BuildSurveyInput!): Survey`
- `createSurvey(input: SurveyInput!): Survey!`
- `updateSurvey(id: ID!, input: SurveyPartialInput!): Survey!`
- `deleteSurvey(id: ID!): Boolean!`
- `buildSurveyTargetAudience(input: BuildSurveyTargetAudienceInput!): SurveyTargetAudience`
- `createSurveyTargetAudience(input: SurveyTargetAudienceInput!): SurveyTargetAudience!`
- `updateSurveyTargetAudience(id: ID!, input: SurveyTargetAudiencePartialInput!): SurveyTargetAudience!`
- `deleteSurveyTargetAudience(id: ID!): Boolean!`
- `createSurveyAnswer(input: SurveyAnswerInput!): SurveyAnswer!`
- `updateSurveyAnswer(id: ID!, input: SurveyAnswerPartialInput!): SurveyAnswer!`
- `deleteSurveyAnswer(id: ID!): Boolean!`
- `createSurveyConfiguration(input: SurveyConfigurationInput!): SurveyConfiguration!`
- `updateSurveyConfiguration(id: ID!, input: SurveyConfigurationPartialInput!): SurveyConfiguration!`
- `deleteSurveyConfiguration(id: ID!): Boolean!`
- `createSurveyContent(input: SurveyContentInput!): SurveyContent!`
- `updateSurveyContent(id: ID!, input: SurveyContentPartialInput!): SurveyContent!`
- `deleteSurveyContent(id: ID!): Boolean!`
- `buildSurveyQuestion(input: BuildSurveyQuestionInput!): SurveyQuestion`
- `createSurveyQuestion(input: SurveyQuestionInput!): SurveyQuestion!`
- `updateSurveyQuestion(id: ID!, input: SurveyQuestionPartialInput!): SurveyQuestion!`
- `deleteSurveyQuestion(id: ID!): Boolean!`
- `createSurveyQuestionOption(input: SurveyQuestionOptionInput!): SurveyQuestionOption!`
- `updateSurveyQuestionOption(id: ID!, input: SurveyQuestionOptionPartialInput!): SurveyQuestionOption!`
- `deleteSurveyQuestionOption(id: ID!): Boolean!`
- `buildSurveySection(input: BuildSurveySectionInput!): SurveySection`
- `createSurveySection(input: SurveySectionInput!): SurveySection!`
- `updateSurveySection(id: ID!, input: SurveySectionPartialInput!): SurveySection!`
- `deleteSurveySection(id: ID!): Boolean!`
- `buildSurveySectionItem(input: BuildSurveySectionItemInput!): SurveySectionItem`
- `createSurveySectionItem(input: SurveySectionItemInput!): SurveySectionItem!`
- `updateSurveySectionItem(id: ID!, input: SurveySectionItemPartialInput!): SurveySectionItem!`
- `deleteSurveySectionItem(id: ID!): Boolean!`
- `createSurveyAnswerSession(input: SurveyAnswerSessionInput): SurveyAnswerSession`
- `updateSurveyAnswerSession(id: ID!, input: SurveyAnswerSessionPartialInput): SurveyAnswerSession`
- `deleteSurveyAnswerSession(id: ID!): Boolean!`

### Ejemplos de mutation

Crear encuesta:

```graphql
mutation CreateSurvey($input: SurveyInput!) {
    createSurvey(input: $input) {
        id
        title
        active
    }
}
```

Variables:

```json
{
    "input": {
        "title": "Encuesta onboarding",
        "active": false
    }
}
```

Construccion compuesta de encuesta:

```graphql
mutation BuildSurvey($input: BuildSurveyInput!) {
    buildSurvey(input: $input) {
        id
        title
        sections {
            id
            title
            items {
                id
                type
            }
        }
    }
}
```

Guardar sesion de respuestas:

```graphql
mutation CreateAnswerSession($input: SurveyAnswerSessionInput) {
    createSurveyAnswerSession(input: $input) {
        id
        completed
        score
        scorePercent
        answers {
            id
            value
            score
            scorePercent
        }
    }
}
```

## Payloads listos para mutations compuestas

Esta seccion concentra ejemplos de variables para ejecutar las mutations `build*` con estructura valida.

### `buildSurvey`

```graphql
mutation BuildSurvey($input: BuildSurveyInput!) {
    buildSurvey(input: $input) {
        id
        title
        active
    }
}
```

```json
{
    "input": {
        "title": "Encuesta de satisfaccion",
        "active": true,
        "sections": [
            {
                "title": "Datos generales",
                "order": 1,
                "hidden": false,
                "items": [
                    {
                        "type": "QUESTION",
                        "order": 1,
                        "hidden": false,
                        "question": {
                            "title": "Como calificas el servicio?",
                            "code": "SERVICIO_CALIFICACION",
                            "type": "RADIO_LIST",
                            "required": true,
                            "other": false,
                            "score": 10,
                            "options": [
                                { "title": "Excelente", "value": "5", "order": 1 },
                                { "title": "Bueno", "value": "4", "order": 2 },
                                { "title": "Regular", "value": "3", "order": 3 },
                                { "title": "Malo", "value": "2", "order": 4 }
                            ],
                            "content": {
                                "type": "TEXT",
                                "body": "Selecciona una opcion"
                            }
                        }
                    }
                ]
            }
        ],
        "targetAudience": {
            "title": "Clientes 2026",
            "attempts": 1,
            "password": "demo"
        }
    }
}
```

### `buildSurveyTargetAudience`

```graphql
mutation BuildSurveyTargetAudience($input: BuildSurveyTargetAudienceInput!) {
    buildSurveyTargetAudience(input: $input) {
        id
        title
        attempts
    }
}
```

```json
{
    "input": {
        "survey": "SURVEY_ID",
        "title": "Clientes Premium",
        "starts": "2026-03-01T00:00:00Z",
        "ends": "2026-12-31T23:59:59Z",
        "attempts": 2,
        "password": "acceso2026",
        "welcome": {
            "type": "HTML",
            "body": "<h3>Bienvenido</h3><p>Gracias por participar.</p>"
        },
        "farewell": {
            "type": "TEXT",
            "body": "Gracias por completar la encuesta"
        },
        "presentation": {
            "type": "PRESENTATION",
            "value": {
                "theme": "light",
                "brandColor": "#0A6EBD"
            }
        }
    }
}
```

### `buildSurveySection`

```graphql
mutation BuildSurveySection($input: BuildSurveySectionInput!) {
    buildSurveySection(input: $input) {
        id
        title
        order
    }
}
```

```json
{
    "input": {
        "survey": "SURVEY_ID",
        "title": "Experiencia de compra",
        "order": 2,
        "hidden": false,
        "content": {
            "type": "TEXT",
            "body": "Responde segun tu ultima compra"
        },
        "items": [
            {
                "type": "QUESTION",
                "order": 1,
                "hidden": false,
                "question": {
                    "title": "La entrega fue puntual?",
                    "code": "ENTREGA_PUNTUAL",
                    "type": "RADIO_LIST",
                    "required": true,
                    "other": false,
                    "options": [
                        { "title": "Si", "value": "SI", "order": 1 },
                        { "title": "No", "value": "NO", "order": 2 }
                    ]
                }
            }
        ]
    }
}
```

### `buildSurveyQuestion`

```graphql
mutation BuildSurveyQuestion($input: BuildSurveyQuestionInput!) {
    buildSurveyQuestion(input: $input) {
        id
        title
        type
    }
}
```

```json
{
    "input": {
        "survey": "SURVEY_ID",
        "title": "Recomendarias nuestro servicio?",
        "code": "NPS",
        "type": "NUMBER_LIST",
        "required": true,
        "other": false,
        "score": 10,
        "validators": {
            "type": "VALIDATOR",
            "value": {
                "min": 0,
                "max": 10
            }
        },
        "answerScore": {
            "type": "ANSWER_SCORE",
            "value": {
                "scores": [
                    { "answer": "10", "score": 10 },
                    { "answer": "9", "score": 9 },
                    { "answer": "8", "score": 8 }
                ]
            }
        },
        "options": [
            { "title": "10", "value": "10", "order": 1 },
            { "title": "9", "value": "9", "order": 2 },
            { "title": "8", "value": "8", "order": 3 }
        ]
    }
}
```

### `buildSurveySectionItem`

```graphql
mutation BuildSurveySectionItem($input: BuildSurveySectionItemInput!) {
    buildSurveySectionItem(input: $input) {
        id
        type
        order
    }
}
```

```json
{
    "input": {
        "section": "SECTION_ID",
        "type": "CONTENT",
        "order": 3,
        "hidden": false,
        "content": {
            "type": "HTML",
            "body": "<strong>Gracias por llegar a esta seccion</strong>"
        },
        "conditions": {
            "type": "CONDITION",
            "value": {
                "field": "ENTREGA_PUNTUAL",
                "operator": "EQUAL",
                "value": "SI"
            }
        }
    }
}
```

### `createSurveyAnswerSession` (flujo de respuesta)

```graphql
mutation CreateSurveyAnswerSession($input: SurveyAnswerSessionInput) {
    createSurveyAnswerSession(input: $input) {
        id
        completed
        score
        scorePercent
    }
}
```

```json
{
    "input": {
        "targetAudience": "TARGET_AUDIENCE_ID",
        "name": "Pedro Lopez",
        "username": "p.lopez",
        "password": "demo",
        "ownerCode": "ORD-2026-001",
        "completed": false,
        "answers": [
            {
                "questionId": "QUESTION_ID_1",
                "value": "SI"
            },
            {
                "questionId": "QUESTION_ID_2",
                "value": "8"
            }
        ]
    }
}
```

### `updateSurveyAnswerSession` (actualizacion de respuestas)

```graphql
mutation UpdateSurveyAnswerSession($id: ID!, $input: SurveyAnswerSessionPartialInput) {
    updateSurveyAnswerSession(id: $id, input: $input) {
        id
        completed
        score
        scorePercent
    }
}
```

```json
{
    "id": "ANSWER_SESSION_ID",
    "input": {
        "completed": true,
        "answers": [
            {
                "questionId": "QUESTION_ID_1",
                "value": "NO"
            },
            {
                "questionId": "QUESTION_ID_2",
                "value": "10"
            }
        ]
    }
}
```

### Consideraciones de actualizacion con `build*`

- Si envias `id` en el input de `build*`, el registro se actualiza.
- Las actualizaciones `build*` no son parciales: la estructura relacionada no enviada puede eliminarse segun la regla de cada builder.
- En `updateSurveyAnswerSession`, los campos `ownerCode` y `targetAudience` no se modifican por diseno.

## Input y tipos base de filtros

Los tipos base reutilizados por queries de conexion vienen de `wappcode/gqlpdss`:

- `ConnectionInput`
- `PaginationInput`
- `FilterGroupInput`
- `FilterConditionInput`
- `JoinInput`
- `SortGroupInput`

Operadores de filtro disponibles:

- `EQUAL`
- `NOT_EQUAL`
- `BETWEEN`
- `GREATER_THAN`
- `LESS_THAN`
- `GREATER_EQUAL_THAN`
- `LESS_EQUAL_THAN`
- `LIKE`
- `NOT_LIKE`
- `IN`
- `NOT_IN`

## Clases utilitarias para desarrolladores

Las clases de `GPDSurvey/src/Library` se usan para encapsular logica de negocio y operaciones compuestas.

### Builders

- `BuildSurvey`: construccion/actualizacion de encuestas con secciones y audiencia.
- `BuildSurveySection`: construccion/actualizacion de secciones e items.
- `BuildSurveySectionItem`: construccion/actualizacion de items de seccion.
- `BuildSurveyQuestion`: construccion/actualizacion de preguntas y opciones.
- `BuildSurveyQuestionOption`: construccion/actualizacion de opciones.
- `BuildSurveyTargetAudience`: construccion/actualizacion de audiencias.
- `BuildSurveyContent`: construccion de contenidos.
- `BuildSurveyConfiguration`: construccion de configuraciones.

### Deletes

- `DeleteSurvey`
- `DeleteSurveySection`
- `DeleteSurveySectionItem`
- `DeleteSurveyQuestion`
- `DeleteSurveyQuestionOption`
- `DeleteSurveyTargetAudience`
- `DeleteSurveyAnswerSession`
- `DeleteSurveyContent`
- `DeleteSurveyConfiguration`

### Guardado de respuestas y scoring

- `SurveySaveAnswerSession`: crea/actualiza sesiones completas y recalcula score global.
- `SurveySaveAnswers`: persiste respuestas individuales con validacion de ventana de fechas.
- `SurveyScoreUtilities`:
    - `calculateAnswerScore(...)`
    - `calculateAnswerScorePercent(...)`
    - `calculateAnswerSessionScore(...)`
    - `calculateAnswerSessionScorePercent(...)`
- `QuestionOptionsValueUtilities`: formatea respuestas por tipo de pregunta (listas, imagen, archivo). Los datos de la pregunta se pasan como array; dicho array debe contener la clave `type` o `question_type` con el tipo de pregunta.

### Interfaces con constantes de dominio

- `ISurveyQuestion`
- `ISurveySectionItem`
- `ISurveyConfiguration`
- `ISurveyContent`

## Seguridad en resolvers con pipeline (`getResolvers`)

`wappcode/gqlpdss` soporta pipelines de resolver via `ResolverPipelineFactory::createPipeline(...)`.

`GPDSurveyModule` ya define resolvers por campo. La extension recomendada es heredar el modulo y envolver los resolvers que requieren capas de seguridad/log.

```php
<?php

namespace AppModule;

use GPDSurvey\GPDSurveyModule;
use GPDCore\Graphql\ResolverPipelineFactory;
use GPDCore\Graphql\ResolverTransactionMiddlewareFactory;

final class SecureSurveyModule extends GPDSurveyModule
{
        public function getResolvers(): array
        {
                $resolvers = parent::getResolvers();

                $authProxy = function (callable $resolver) {
                        return function ($root, array $args, $context, $info) use ($resolver) {
                                if (!$context->getAuthUser()) {
                                        throw new \RuntimeException('Unauthorized');
                                }
                                return $resolver($root, $args, $context, $info);
                        };
                };

                $logProxy = function (callable $resolver) {
                        return function ($root, array $args, $context, $info) use ($resolver) {
                                $start = microtime(true);
                                $result = $resolver($root, $args, $context, $info);
                                $duration = microtime(true) - $start;
                                error_log("{$info->parentType->name}::{$info->fieldName} {$duration}s");
                                return $result;
                        };
                };

                $protectedKeys = [
                        'Mutation::createSurvey',
                        'Mutation::updateSurvey',
                        'Mutation::deleteSurvey',
                        'Mutation::buildSurvey',
                ];

                foreach ($protectedKeys as $key) {
                        $base = $resolvers[$key] ?? null;
                        if (!is_callable($base)) {
                                continue;
                        }

                        $resolvers[$key] = ResolverPipelineFactory::createPipeline($base, [
                                ResolverPipelineFactory::createWrapper($logProxy),
                                ResolverPipelineFactory::createWrapper($authProxy),
                                ResolverTransactionMiddlewareFactory::createMiddleware(),
                        ]);
                }

                return $resolvers;
        }
}
```

Orden de ejecucion del pipeline:

- Se ejecuta en orden inverso al array de middlewares.
- El middleware de transaccion en la ultima posicion se ejecuta primero y envuelve toda la cadena.

## Seguridad global HTTP (`getMiddlewares`)

Para seguridad transversal a nivel endpoint HTTP GraphQL, sobrescribir `getMiddlewares()` en el modulo.

> Nota: el nombre del metodo en la version actual es `getMiddlewares`.

Ejemplo:

```php
<?php

namespace AppModule\Middleware;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class AuthMiddleware implements MiddlewareInterface
{
        public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
        {
                $token = $request->getHeaderLine('Authorization');
                if ($token === '') {
                        return new JsonResponse(['error' => 'Unauthorized'], 401);
                }

                return $handler->handle($request);
        }
}
```

Registro en el modulo:

```php
<?php

namespace AppModule;

use GPDSurvey\GPDSurveyModule;
use AppModule\Middleware\AuthMiddleware;

final class SecureSurveyModule extends GPDSurveyModule
{
        public function getMiddlewares(): array
        {
                return [
                        AuthMiddleware::class,
                ];
        }
}
```

## Referencias internas del paquete

- Esquema: `GPDSurvey/config/survey-schema.graphql`
- Registro de resolvers y operaciones: `GPDSurvey/src/GPDSurveyModule.php`
- Utilidades de dominio: `GPDSurvey/src/Library`
- Tipos base y pipeline GraphQL (`wappcode/gqlpdss`):
    - `vendor/wappcode/gqlpdss/GraphqlModule/config/gql-pdss.graphqls`
    - `vendor/wappcode/gqlpdss/GPDCore/src/Graphql/ResolverPipelineFactory.php`
    - `vendor/wappcode/gqlpdss/GPDCore/src/Core/AbstractModule.php`