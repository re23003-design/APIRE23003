<?php
declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface; 
use App\Models\VehiculoModel;

class VehiculoController
{
    private $container;

    // El constructor recibe el contenedor de Slim automáticamente
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // Método para el GET /vehiculos
    public function VerTodos(Request $request, Response $response): Response
    {
        require_once __DIR__ . '/../Models/VehiculoModel.php';
        
        // Sacamos el PDO usando el container guardado
        $db = $this->container->get(\PDO::class); 
        $model = new VehiculoModel($db);
        
        $vehiculos = $model->obtenerVehiculos();
        
        $response->getBody()->write(json_encode($vehiculos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Método para el POST /vehiculos
    public function Insertar(Request $request, Response $response): Response
    {
        require_once __DIR__ . '/../Models/VehiculoModel.php';
        
        $db = $this->container->get(\PDO::class); 
        $model = new VehiculoModel($db);
        
        $body = $request->getParsedBody();
        $exito = $model->insertarVehiculo(
            $body['Placa'] ?? null,
            $body['ModeloVehiculo'] ?? null,
            $body['Color'] ?? null,
            $body['AnioFabricacion'] ?? null,
            $body['Kilometraje'] ?? null,
            $body['NPrecioOriginal'] ?? null,
            $body['IdMarca'] ?? null
        );
        
        $response->getBody()->write(json_encode(["status" => $exito ? "Éxito" : "Error"]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}