<?php

include 'conexion.php';
class Estudiante
{
    private $conection;
    public function __construct()
    {
        $conexion = new Conexion();
        $this->conection = $conexion->conectar();
    }

    public function insertarEstudiante($cedula, $nombre, $apellido, $direccion, $telefono)
    {
        try {
            if (!$this->validarCampos($cedula, $nombre, $apellido, $direccion, $telefono)) {
                http_response_code(400);
                return json_encode(array("error" => "Todos los campos son requeridos"));
            }

            if ($this->existeEstudiante($cedula)) {
                http_response_code(400);
                return json_encode(array("error" => "El estudiante ya existe"));
            }

            $insertSql = "INSERT INTO estudiante (cedula, nombre, apellido, direccion, telefono) VALUES(:cedula, :nombre, :apellido, :direccion, :telefono)";
            $resultado = $this->conection->prepare($insertSql);
            $resultado->bindParam(':cedula', $cedula);
            $resultado->bindParam(':nombre', $nombre);
            $resultado->bindParam(':apellido', $apellido);
            $resultado->bindParam(':direccion', $direccion);
            $resultado->bindParam(':telefono', $telefono);
            $resultado->execute();

            if ($resultado->rowCount() == 0) {
                http_response_code(400);
                return json_encode(array("error" => "No se pudo insertar el estudiante"));
            }

            http_response_code(201);
            return json_encode(array("mensaje" => "Estudiante insertado correctamente"));
        } catch (Exception $e) {
            http_response_code(500);
            return json_encode(array("error" => $e->getMessage()));
        }
    }

    public function obtenerEstudiantes()
    {
        try {
            $sqlSelect = "SELECT * FROM estudiante";
            $resultado = $this->conection->prepare($sqlSelect);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            return json_encode(array("error" => $e->getMessage()));
        }
    }

    public function actualizarEstudiante($cedula, $nombre, $apellido, $direccion, $telefono)
    {
        try {
            if (empty($cedula) || empty($nombre) || empty($apellido) || empty($direccion) || empty($telefono)) {
                http_response_code(400);
                return json_encode(array("error" => "Todos los campos son requeridos"));
            }

            $updateSql = "UPDATE estudiante SET nombre = :nombre, apellido = :apellido, direccion = :direccion, telefono = :telefono WHERE cedula = :cedula";
            $resultado = $this->conection->prepare($updateSql);
            $resultado->bindParam(':cedula', $cedula);
            $resultado->bindParam(':nombre', $nombre);
            $resultado->bindParam(':apellido', $apellido);
            $resultado->bindParam(':direccion', $direccion);
            $resultado->bindParam(':telefono', $telefono);
            $resultado->execute();

            if ($resultado->rowCount() == 0) {
                http_response_code(400);
                return json_encode(array("error" => "No se pudo actualizar el estudiante"));
            }

            http_response_code(200);
            return json_encode(array("mensaje" => "Estudiante actualizado correctamente"));
        } catch (Exception $e) {
            http_response_code(400);
            return json_encode(array("error" => $e->getMessage()));
        }
    }

    public function eliminarEstudiante($cedula)
    {
        try {
            if (empty($cedula)) {
                http_response_code(400);
                return json_encode(array("error" => "La cedula es requerida"));
            }

            $deleteSql = "DELETE FROM estudiante WHERE cedula = :cedula";
            $resultado = $this->conection->prepare($deleteSql);
            $resultado->bindParam(':cedula', $cedula);
            $resultado->execute();

            if ($resultado->rowCount() == 0) {
                http_response_code(400);
                return json_encode(array("error" => "No se pudo eliminar el estudiante"));
            }

            http_response_code(200);
            return json_encode(array("mensaje" => "Estudiante eliminado correctamente"));
        } catch (Exception $e) {
            http_response_code(400);
            return json_encode(array("error" => $e->getMessage()));
        }
    }

    public function obtenerEstudiante($cedula)
    {
        try {
            if (empty($cedula)) {
                http_response_code(400);
                return json_encode(array("error" => "La cedula es requerida"));
            }

            $sqlSelect = "SELECT * FROM estudiante WHERE cedula = :cedula";
            $resultado = $this->conection->prepare($sqlSelect);
            $resultado->bindParam(':cedula', $cedula);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

            if (count($data) == 0) {
                http_response_code(400);
                return json_encode(array("error" => "El estudiante no existe"));
            }

            return json_encode($data);
        } catch (Exception $e) {
            http_response_code(400);
            return json_encode(array("error" => $e->getMessage()));
        }
    }

    public function existeEstudiante($cedula)
    {
        try {
            $sqlSelect = "SELECT * FROM estudiante WHERE cedula = :cedula";
            $resultado = $this->conection->prepare($sqlSelect);
            $resultado->bindParam(':cedula', $cedula);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            return count($data) > 0;
        } catch (Exception $e) {
            http_response_code(500);
            return json_encode(array("error" => $e->getMessage()));
        }
    }

    public function validarCampos($cedula, $nombre, $apellido, $direccion, $telefono)
    {
        if (empty($cedula) || empty($nombre) || empty($apellido) || empty($direccion) || empty($telefono)) {
            return false;
        }
        return true;
    }
}
