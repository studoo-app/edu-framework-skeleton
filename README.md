# Edu Framework Skeleton

Welcome to your project built with **Edu Framework**!

## Documentation

The full documentation is available in English and French:

- English: [https://studoo-app.github.io/edu-framework/en/](https://studoo-app.github.io/edu-framework/en/)
- French: [https://studoo-app.github.io/edu-framework/](https://studoo-app.github.io/edu-framework/)

## Requirements

- **PHP 8.4 or higher**
- Required PHP extensions: `mbstring`, `pdo_sqlite`, `pdo_mysql`, `openssl`
- Optional PHP extension: `excimer` (code profiler of the debug bar, already installed in the Docker image)
- Composer 2.x
- Docker and Docker Compose

Check your setup with `php bin/edu check:config`.

## Installation

1. **Clone the project**
   ```bash
   git clone <your-repo>
   cd <your-project>
   ```

2. **Install the dependencies**
   ```bash
   composer install
   ```

3. **Configure the environment**
   ```bash
   composer edu:init   # copies .env.example to .env
   # Edit .env to suit your needs (APP_ENV=dev for the debug bar)
   ```

4. **Start the application**, either:

   - **Everything in Docker** (application served by FrankenPHP)
     ```bash
     docker compose up -d --build
     ```
     The application is available at [http://localhost](http://localhost) (port `HTTP_PORT`).

   - **Services in Docker, application on your computer**
     ```bash
     docker compose up -d database mailer dbgate phpmyadmin
     php bin/edu start
     ```
     The application is available at [http://localhost:8042](http://localhost:8042).

The guide [The application in Docker](https://studoo-app.github.io/edu-framework/en/installation/docker/) describes both modes in detail.

## Available services

| Service | Port (default) | `.env` variable | Description |
|---------|----------------|-----------------|-------------|
| FrankenPHP | 80 / 443 | `HTTP_PORT` / `HTTPS_PORT` | Web server (PHP + Caddy, HTTPS and HTTP/3) |
| MariaDB | 3306 | `DB_SOCKET` | Database |
| phpMyAdmin | 8081 | `PMA_PORT` | MariaDB administration |
| dbgate | 8082 | `DBGATE_PORT` | Database administration (MariaDB and the SQLite logs database) |
| Mailpit | 1025 (SMTP), 8025 (Web) | `MAILER_SMTP_PORT` / `MAILER_UI_PORT` | Email testing |
| Built-in server | 8042 | — | `php bin/edu start` (outside Docker) |

Container names are prefixed with `APP_NAME`. If another project already uses these ports, change them in the `.env` file.

### HTTPS

The FrankenPHP server is driven by the `SERVER_NAME` variable:

- `:80`: plain HTTP (default, development)
- `localhost`: local HTTPS with a self-signed certificate ([https://localhost](https://localhost))
- `my-site.com`: HTTPS with Let's Encrypt (production, public domain required)

## Debug bar and profiler

In development mode (`APP_ENV=dev`), a debug bar is displayed at the bottom of every page and the profiler is available at `/_debug/profiler`:

- log of every HTTP request (status, duration, memory, SAPI, errors), stored in `var/logs/core_logs.sqlite`
- SQL queries run by each HTTP request (duration, repeated queries)
- links to the development services (Mailpit, dbgate, phpMyAdmin)
- **code profiler** (Excimer extension): time spent in each PHP function, Speedscope export for a flame graph

Code profiler settings in the `.env` file:

| Variable | Values | Description |
|----------|--------|-------------|
| `EDU_PROFILER` | `off`, `trigger` (default), `on` | `trigger`: on-demand profiling with the **Code** button of the debug bar or `?_profile=1`; `on`: every request is profiled |
| `EDU_PROFILER_KEEP` | `50` | Number of profiles kept |
| `EDU_PROFILER_BUILD` | `1` (default), `0` | Docker image with or without Excimer |

See [The debug bar and the profiler](https://studoo-app.github.io/edu-framework/en/boost/debug-bar/).

## Unit tests

PHPUnit is already installed and configured (`phpunit.xml`, `tests/bootstrap.php`): write your tests in the `tests` folder and run them with `vendor/bin/phpunit`.

See [Test your application (unit tests)](https://studoo-app.github.io/edu-framework/en/build/tests-unitaires/).

## Useful commands

- **Start the built-in server**: `php bin/edu start --port=8080`
- **Check the configuration**: `php bin/edu check:config` (in Docker: `docker compose exec frankenphp php bin/edu check:config`)
- **Show the version**: `php bin/edu --version`
- **Generate a controller**: `php bin/edu make:controller NameController`
- **Generate a CLI command**: `php bin/edu make:command name:command`
- **Generate an API**: `php bin/edu make:api NameApi`
- **Run the tests**: `vendor/bin/phpunit`

## Migration

- [Migrate from version 2.8 to version 2.9](https://studoo-app.github.io/edu-framework/en/migrate/migration-2_8-2_9/)
- [Migrate from version 2.3 to version 2.8](https://studoo-app.github.io/edu-framework/en/migrate/migration-2_3-2_8/) (MariaDB, error templates, Twig cache, `.env`, Docker files)
- [Migrate from version 2.2 to version 2.3](https://studoo-app.github.io/edu-framework/en/migrate/migration-2_2-2_3/)

## Contributing

To contribute to the project, read the [contribution guide](https://studoo-app.github.io/edu-framework/en/contributor/contributing/).

## License

MIT License - Copyright (c) 2022-2026 Collectif Studoo
