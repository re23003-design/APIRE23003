<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([

        // 1. SERVICIO DE LOGGER (Ya venía en el Skeleton)
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        }, // <- Aquí cierra correctamente el Logger con su coma

       // 2. NUESTRO NUEVO SERVICIO DE CONEXIÓN A BASE DE DATOS (PDO)
        PDO::class => function (ContainerInterface $c) {
            // Jalamos los datos de configuración que escribimos en settings.php
            $settings = $c->get(SettingsInterface::class);
            $dbSettings = $settings->get('db');

            // Armamos el DSN incluyendo el PUERTO personalizado para Filess.io
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $dbSettings['host'],
                $dbSettings['port'], // <-- Metemos el puerto aquí en orden
                $dbSettings['database'],
                $dbSettings['charset']
            );

            // Creamos e instanciamos el objeto PDO nativo de PHP
            $pdo = new PDO($dsn, $dbSettings['username'], $dbSettings['password']);
            
            // Configuración de seguridad y captura de errores de SQL
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            
            return $pdo;
        }, // <- Cierra el servicio PDO
    ]);
};