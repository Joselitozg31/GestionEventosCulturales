<?php

namespace App\Model;

use PDO;
use PDOException;
use App\Utils\Utils;

class Usuario extends Model
{
    function __construct($con)
    {
        parent::__construct($con);
        $this->table = "usuario";
    }

    // Función para obtener un usuario por su correo
    public function obtenerPorCorreo($correo)
    {
        try {
            // Se busca el usuario por su correo y se retorna el resultado
            $sql = "SELECT * FROM $this->table WHERE Correo = :correo";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error al obtener el usuario: ' . $e->getMessage();
            return false;
        }
    }

    // Función para insertar un usuario en la base de datos
    public function insertarUsuario($datos)
    {
        try {
            // Se obtienen las columnas y valores a insertar
            $columnas = implode(", ", array_keys($datos));
            $valores = ":" . implode(", :", array_keys($datos));
            $sql = "INSERT INTO $this->table ($columnas) VALUES ($valores)";
            $stmt = $this->con->prepare($sql);
            foreach ($datos as $campo => $valor) {
                $tipo = Utils::obtenerTipoParametro($valor);
                $stmt->bindValue(":$campo", $valor, $tipo);
            }

            // Se ejecuta la consulta y se retorna el resultado
            if ($stmt->execute()) {
                return true;
                // Si ocurre un error, se muestra un mensaje
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "Error al insertar el usuario: " . $errorInfo[2];
                return false;
            }
        } catch (PDOException $e) {
            echo 'Error al insertar el usuario: ' . $e->getMessage();
            return false;
        }
    }

    // Función para actualizar un usuario en la base de datos
    public function validarUsuario($correo, $codigo)
    {
        try {
            // Se busca el usuario por su correo y código
            $sql = "SELECT * FROM $this->table WHERE Correo = :correo AND Codigo = :codigo";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si el usuario existe, se actualiza el campo Codigo a NULL
            if ($usuario) {
                $sql = "UPDATE $this->table SET Codigo = NULL WHERE idUsuarios = :id";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam(':id', $usuario['idUsuarios']);
                return $stmt->execute();
                // Si el usuario no existe, se retorna false
            } else {
                return false;
            }
            // Si ocurre un error, se muestra un mensaje
        } catch (PDOException $e) {
            echo 'Error al validar el usuario: ' . $e->getMessage();
            return false;
        }
    }
}