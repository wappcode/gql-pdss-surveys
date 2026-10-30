# AGENTS.md

## Repo shape
- This is a Composer PHP library, not an app with npm scripts or a test runner. The package is `wappcode/gql-pdss-surveys` in `composer.json`.
- PSR-4 autoloading maps `GPDSurvey\` to `GPDSurvey/src/`.
- Main module entrypoint is `GPDSurvey/src/GPDSurveyModule.php`; GraphQL types, resolvers, and query/mutation registration live there.
- The local/demo app lives under `dev/`; `dev/public/index.php` bootstraps `GPDSurveyModule` and `AppModule` via `GPDApp`.

## Local dev / config
- Doctrine config is loaded from `dev/config/doctrine.local.php` and reads DB settings from environment variables:
  - `GQLPDSSSURVEY_DBUSER` (default: `root`)
  - `GQLPDSSSURVEY_DBPASSWORD` (default: `dbpassword`)
  - `GQLPDSSSURVEY_DBNAME` (default: `gqlpdss_surveydb`)
  - `GQLPDSSSURVEY_DBHOST` (default: `localhost`)
- Doctrine entity paths are in `dev/config/doctrine.entities.php`; they include both `AppModule\Entities` and `GPDSurvey\Entities`.
- `GPDSurvey/config/module.config.php` defines `survey_upload_file_dir` and `app_upload_dir`; `app_upload_dir` must be overridden in the app config to a real upload directory like `public/uploads`.

## Commands that matter here
- Refresh Composer autoloading after structure or namespace changes:
  - `composer dump-autoload -o`
- Inspect Doctrine schema changes without altering the DB:
  - `vendor/bin/doctrine orm:schema-tool:update --dump-sql`
- Apply the schema directly to the configured DB:
  - `vendor/bin/doctrine orm:schema-tool:update --force`
- There is no repo-defined lint/test/build task list in this project; do not invent JS/PHP package commands. This repo’s executable source of truth is Composer + Doctrine config.

## Architecture notes
- If you add or change entities, also review `dev/config/doctrine.entities.php` and any GraphQL registration in `GPDSurvey/src/GPDSurveyModule.php`.
- The README is focused on consuming this package in another app and shows how to add it as a Composer dependency and register the entity path.
- This repository is a library module for survey functionality; the app wiring and environment-specific setup live in `dev/`, not in the library root.
