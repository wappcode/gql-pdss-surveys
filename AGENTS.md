# AGENTS.md

## Repo shape
- This repo is a Composer PHP library package: `wappcode/gql-pdss-surveys` (`composer.json`). It is not a Node app and does not define npm/test scripts.
- PSR-4 autoloading maps `GPDSurvey\` to `GPDSurvey/src/`.
- The library entrypoint is `GPDSurvey/src/GPDSurveyModule.php`; it loads the GraphQL schema from `GPDSurvey/config/gql-pdss.graphqls` and registers query resolvers there.
- The demo app wiring lives in `dev/`; `dev/public/index.php` boots the module stack via `GPDApp`.

## Local setup and config
- Doctrine settings are loaded from `dev/config/doctrine.local.php`; they read env vars:
  - `GQLPDSSSURVEY_DBUSER` (default `root`)
  - `GQLPDSSSURVEY_DBPASSWORD` (default `dbpassword`)
  - `GQLPDSSSURVEY_DBNAME` (default `gqlpdss_surveydb`)
  - `GQLPDSSSURVEY_DBHOST` (default `localhost`)
- Entity paths are declared in `dev/config/doctrine.entities.php`; if you add/change entities, update both the app entity list and the GraphQL module registration.
- `GPDSurvey/config/module.config.php` defines `survey_upload_file_dir` and `app_upload_dir`; `app_upload_dir` must be overridden in the consuming app to a real writable upload path such as `public/uploads`.

## Commands that matter
- Refresh Composer autoloading after namespace/structure changes:
  - `composer dump-autoload -o`
- Preview Doctrine schema changes without modifying the DB:
  - `vendor/bin/doctrine orm:schema-tool:update --dump-sql`
- Apply the schema to the configured database:
  - `vendor/bin/doctrine orm:schema-tool:update --force`
- There is no repo-defined lint/test/build task list; do not invent JS/PHP package commands. The executable source of truth here is Composer + Doctrine config.

## Change safety
- If you add or change Doctrine entities, also review `dev/config/doctrine.entities.php` and `GPDSurvey/src/GPDSurveyModule.php`.
- The README is written for consuming this package in another app (Composer dependency + entity path registration); it is not the app runtime for this repo.
- Keep app-specific wiring in `dev/`; the library module itself is in `GPDSurvey/`.
