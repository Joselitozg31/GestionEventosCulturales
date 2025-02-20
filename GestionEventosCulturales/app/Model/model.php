<?php

namespace App\Model;

use PDO;
use PDOException;
use App\Utils\Utils;

class Model
{
    protected $con;
    protected $table;

    public static $nombreBD = "eventosculturales";

    // Constructor de la clase
    function __construct($con)
    {
        if ($con != null && $this->con == null) $this->con = $con;
    }

    // Función para obtener un registro por su id
    function cargar($id)
    {
        try {
            // Se busca el registro por su id y se retorna el resultado
            $sql = "SELECT * FROM $this->table WHERE id{$this->table} = :id";
            $stmt = $this->con->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado = $stmt->execute();

            return $resultado ? $stmt->fetch() : false;
        } catch (PDOException $e) {
            echo 'Error al cargar el registro: ' . $e->getMessage();
            return false;
        }
    }

    // Función para obtener todos los registros
    function cargarTodoPaginado($num_pag, $elem_pag)
    {
        try {
            // Se calcula el offset y se obtienen los registros
            $offset = ($num_pag - 1) * $elem_pag;
            $sql = "SELECT * FROM $this->table LIMIT $elem_pag OFFSET $offset";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error al cargar los registros: ' . $e->getMessage();
            return false;
        }
    }

    // Función para contar todos los registros
    function contarTodos()
    {
        try {
            // Se cuenta el total de registros
            $sql = "SELECT COUNT(*) as total FROM $this->table";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            return $stmt->fetch()['total'];
        } catch (PDOException $e) {
            echo 'Error al contar los registros: ' . $e->getMessage();
            return false;
        }
    }

    // Función para borrar un registro por su id
    function borrar($id)
    {
        try {
            // Se borra el registro por su id y se retorna el resultado
            $sql = "DELETE FROM $this->table WHERE id{$this->table} = :id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error al borrar el registro: ' . $e->getMessage();
            return false;
        }
    }

    // Función para buscar registros por un campo y un valor
    function insertar($datos)
    {
        try {
            // Se obtienen las columnas y valores a insertar
            $columnas = implode(", ", array_keys($datos));
            $valores = ":" . implode(", :", array_keys($datos));
            $sql = "INSERT INTO $this->table ($columnas) VALUES ($valores)";
            $stmt = $this->con->prepare($sql);
            // Se ejecuta la consulta y se retorna el resultado
            foreach ($datos as $campo => $valor) {
                $tipo = Utils::obtenerTipoParametro($valor);
                $stmt->bindValue(":$campo", $valor, $tipo);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error al insertar el registro: ' . $e->getMessage();
            return false;
        }
    }

    // Función para modificar un registro por su id
    function modificar($id, $datos)
    {
        try {
            // Se obtienen los campos y valores a modificar
            $campos = [];
            foreach ($datos as $campo => $valor) {
                $campos[] = "$campo = :$campo";
            }
            $sql = "UPDATE $this->table SET " . implode(', ', $campos) . " WHERE id{$this->table} = :id";
            $stmt = $this->con->prepare($sql);

            // Se ejecuta la consulta y se retorna el resultado
            foreach ($datos as $campo => $valor) {
                $tipo = Utils::obtenerTipoParametro($valor);
                $stmt->bindValue(":$campo", $valor, $tipo);
            }
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error al modificar el registro: ' . $e->getMessage();
            return false;
        }
    }
}
