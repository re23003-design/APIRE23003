<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

// Forzamos la carga de los controladores para evitar el error 500 de clase no encontrada
require_once __DIR__ . '/Controllers/VehiculoController.php';
require_once __DIR__ . '/Controllers/MarcaController.php';

use App\Controllers\VehiculoController;
use App\Controllers\MarcaController;

return function (App $app) {

    // 1. GET /vehiculos - Listar todos usando el Controlador
    $app->get('/vehiculos', [VehiculoController::class, 'VerTodos']);

    // 2. POST /vehiculos - Guardar nuevo usando el Controlador
    $app->post('/vehiculos', [VehiculoController::class, 'Insertar']);

    // 3. POST /marcas - Guardar nueva usando el Controlador
    $app->post('/marcas', [MarcaController::class, 'Insertar']);

    // 4. GET /marcas/{id} - Buscar una específica usando el Controlador
    $app->get('/marcas/{id}', [MarcaController::class, 'VerPorId']);

};