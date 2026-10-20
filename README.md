# Edu Framework Skeleton

Bienvenue dans votre projet avec **Edu Framework** !

## Documentation

La documentation complète est disponible sur : [https://studoo-app.github.io/edu-framework](https://studoo-app.github.io/edu-framework)

## Prérequis

- **PHP 8.4 ou supérieur**
- Extensions PHP requises : `mbstring`, `pdo_sqlite`, `pdo_mysql`, `openssl`
- Extension PHP optionnelle : `excimer` (profiler de code de la barre de debug, déjà installée dans l'image Docker)
- Composer 2.x
- Docker et Docker Compose

Vérifiez votre configuration avec `php bin/edu check:config`.

## Installation

1. **Cloner le projet**
   ```bash
   git clone <votre-repo>
   cd <votre-projet>
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer l'environnement**
   ```bash
   composer edu:init   # copie .env.example vers .env
   # Modifier .env selon vos besoins (APP_ENV=dev pour la barre de debug)
   ```

4. **Démarrer l'application**, au choix :

   - **Tout dans Docker** (application servie par FrankenPHP)
     ```bash
     docker compose up -d --build
     ```
     L'application est disponible sur [http://localhost](http://localhost) (port `HTTP_PORT`).

   - **Services dans Docker, application sur votre poste**
     ```bash
     docker compose up -d database mailer dbgate phpmyadmin
     php bin/edu start
     ```
     L'application est disponible sur [http://localhost:8042](http://localhost:8042).

Le guide [L'application dans Docker](https://studoo-app.github.io/edu-framework/installation/docker.html) détaille les deux modes.

## Services disponibles

| Service | Port (défaut) | Variable `.env` | Description |
|---------|---------------|-----------------|-------------|
| FrankenPHP | 80 / 443 | `HTTP_PORT` / `HTTPS_PORT` | Serveur web (PHP + Caddy, HTTPS et HTTP/3) |
| MariaDB | 3306 | `DB_SOCKET` | Base de données |
| phpMyAdmin | 8081 | `PMA_PORT` | Administration MariaDB |
| dbgate | 8082 | `DBGATE_PORT` | Administration des bases (MariaDB et SQLite des logs) |
| Mailpit | 1025 (SMTP), 8025 (Web) | `MAILER_SMTP_PORT` / `MAILER_UI_PORT` | Test des emails |
| Serveur intégré | 8042 | — | `php bin/edu start` (hors Docker) |

Les conteneurs sont préfixés par `APP_NAME`. Si un autre projet occupe déjà ces ports, modifiez-les dans le `.env`.

### HTTPS

Le serveur FrankenPHP est piloté par la variable `SERVER_NAME` :

- `:80` : HTTP simple (défaut, développement)
- `localhost` : HTTPS local avec certificat auto-signé ([https://localhost](https://localhost))
- `mon-site.fr` : HTTPS via Let's Encrypt (production, domaine public requis)

## Barre de debug et profiler

En mode développement (`APP_ENV=dev`), une barre de debug s'affiche en bas de chaque page et le profiler est accessible sur `/_debug/profiler` :

- journal de toutes les requêtes HTTP (statut, durée, mémoire, SAPI, erreurs), stocké dans `var/logs/core_logs.sqlite`
- requêtes SQL exécutées par chaque requête HTTP (durée, requêtes répétées)
- liens vers les services de développement (Mailpit, dbgate, phpMyAdmin)
- **profiler de code** (extension Excimer) : temps passé dans chaque fonction PHP, export Speedscope pour un flamegraph

Configuration du profiler de code dans le `.env` :

| Variable | Valeurs | Description |
|----------|---------|-------------|
| `EDU_PROFILER` | `off`, `trigger` (défaut), `on` | `trigger` : profilage à la demande via le bouton **Code** de la barre de debug ou `?_profile=1` ; `on` : chaque requête est profilée |
| `EDU_PROFILER_KEEP` | `50` | Nombre de profils conservés |
| `EDU_PROFILER_BUILD` | `1` (défaut), `0` | Image Docker avec ou sans Excimer |

Voir [La barre de debug et le profiler](https://studoo-app.github.io/edu-framework/boost/debug-bar.html).

## Commandes utiles

- **Démarrer le serveur intégré** : `php bin/edu start --port=8080`
- **Vérifier la configuration** : `php bin/edu check:config` (dans Docker : `docker compose exec frankenphp php bin/edu check:config`)
- **Voir la version** : `php bin/edu --version`
- **Générer un controller** : `php bin/edu make:controller NomController`
- **Générer une commande CLI** : `php bin/edu make:command nom:commande`
- **Générer une API** : `php bin/edu make:api NomApi`
- **Lancer les tests** : `vendor/bin/phpunit`

## Migration

- [Migrer de la version 2.3 à la version 2.8](https://studoo-app.github.io/edu-framework/migrate/migration-2_3-2_8.html) (MariaDB, templates d'erreur, cache Twig, `.env`, fichiers Docker)
- [Migrer de la version 2.2 à la version 2.3](https://studoo-app.github.io/edu-framework/migrate/migration-2_2-2_3.html)

## Contribuer

Pour contribuer au projet, consultez le [guide de contribution](https://studoo-app.github.io/edu-framework/contributor/contributing.html).

## Licence

MIT License - Copyright (c) 2022-2026 Collectif Studoo
