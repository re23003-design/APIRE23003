<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],

                'db' => [
                    'host' => 'wgxc01.h.filess.io',
                    'port' => '61002', // Agregamos el puerto de Filess
                    'database' => 'db_casa_top_behaviorno', 
                    'username' => 'db_casa_top_behaviorno',        
                    'password' => '924cc935048f696bb61dc547ee2a28e7f1e26ea8', 
                    'charset' => 'utf8mb4'
                ],
                // ============================================================
                // CONFIGURACIÓN DE TU BASE DE DATOS LOCAL (XAMPP)
                // ============================================================
                /*'db' => [
                    'host' => 'localhost',
                   'database' => 'db_casa_top', // El nombre que creaste en tu phpMyAdmin
                    'username' => 'root',        // Por defecto en XAMPP
                    'password' => '12345',            // Por defecto vacío en XAMPP
                    'charset' => 'utf8mb4',
                    'port' => '3306',
                ],*/
            ]);
        }
    ]);
};