<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;

class VehiculoModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Listar todos los carros (GET)
    public function obtenerVehiculos()
    {
        try {
            // CORREGIDO: "vehiculos" en minúscula para que Linux (Filess.io) lo encuentre
            $sql = "SELECT * FROM vehiculos";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // Guardar un carro (POST)
    public function insertarVehiculo($placa, $modelo, $color, $anio, $km, $precio, $idMarca)
    {
        try {
          
            $sql = "INSERT INTO vehiculos (Placa, ModeloVehiculo, Color, AnioFabricacion, Kilometraje, NPrecioOriginal, IdMarca) VALUES (?,?,?,?,?,?,?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$placa, $modelo, $color, $anio, $km, $precio, $idMarca]);
        } catch (PDOException $e) {
            return false;
        }
    }
}