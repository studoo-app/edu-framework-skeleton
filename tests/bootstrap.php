<?php

/*
 * Configuration des tests unitaires (PHPUnit)
 * Ce fichier remplace public/index.php pendant les tests : il charge les librairies
 * et configure le framework (templates, routes, bases SQLite).
 * Le fichier .env n'est volontairement pas chargé : les tests ne doivent jamais
 * utiliser la base de données de développement.
 * Documentation : https://studoo-app.github.io/edu-framework/build/tests-unitaires/
 */

use Studoo\EduFramework\Core\ConfigCore;
use Studoo\EduFramework\Core\View\TwigCore;

require __DIR__ . '/../vendor/autoload.php';

// Configuration du framework pour les tests (même chose que public/index.php)
new ConfigCore([
    'base_path'         => __DIR__ . '/../',
    'twig_path'         => __DIR__ . '/../app/Template',
    'route_config_path' => __DIR__ . '/../app/Config/',
    'cache_path'        => __DIR__ . '/../var/cache/',
    'sqlite_path'       => __DIR__ . '/../var/sqlite/',
]);

// Moteur de template Twig, utilisé par les controllers
TwigCore::setEnvironment();
