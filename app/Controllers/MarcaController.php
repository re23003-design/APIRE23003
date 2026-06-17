<?php
declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface; // <--- Importante para el contenedor
use App\Models\MarcaModel;

class MarcaController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // Método para el POST /marcas
    public function Insertar(Request $request, Response $response): Response
    {
        require_once __DIR__ . '/../Models/MarcaModel.php';
        
        $db = $this->container->get(\PDO::class); 
        $model = new MarcaModel($db);
        
        $body = $request->getParsedBody();
        $exito = $model->insertarMarca(
            $body['IdMarca'] ?? null,
            $body['DescripMarca'] ?? null,
            $body['PaisMarca'] ?? null,
            $body['SitioWebOficial'] ?? null
        );
        
        $response->getBody()->write(json_encode(["status" => $exito ? "Éxito" : "Error"]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Método para el GET /marcas/{id}
    public function VerPorId(Request $request, Response $response, array $args): Response
    {
        require_once __DIR__ . '/../Models/MarcaModel.php';
        
        $db = $this->container->get(\PDO::class); 
        $model = new MarcaModel($db);
        
        $resultado = $model->obtenerMarcaPorId($args['id']);
        
        if ($resultado) {
            $response->getBody()->write(json_encode($resultado));
            $status = 200;
        } else {
            $response->getBody()->write(json_encode(["status" => "Error", "mensaje" => "Marca no encontrada"]));
            $status = 404;
        }
        
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}