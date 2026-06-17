<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;

class MarcaModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Insertar una nueva marca (POST)
    public function insertarMarca($idMarca, $descripMarca, $paisMarca, $sitioWeb)
    {
        try {
            $sql = "INSERT INTO marcas (IdMarca, DescripMarca, PaisMarca, SitioWebOficial) VALUES (?,?,?,?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$idMarca, $descripMarca, $paisMarca, $sitioWeb]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Buscar una marca específica por ID (GET con parámetro)
    public function obtenerMarcaPorId($idMarca)
    {
        try {
            $sql = "SELECT * FROM marcas WHERE IdMarca = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idMarca]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
}