
<?php
include "../db/conexion.php";
class Estudiante
{

    private $conection;

    public function __construct()
    {
        $this->conection = Conexion::conectar();
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM estudiante";
            $resultado = $this->conection->prepare($sql);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            http_response_code(200);
            return json_encode($data);
        } catch (Exception $e) {
            http_response_code(500);
            return json_encode(array("error" => $e->getMessage()));
        }
    }


    public function create($cedula, $nombre, $apellido, $direccion, $telefono) {

        try {
            $sql = "INSERT INTO estudiante (cedula, nombre, apellido, direccion, telefono) VALUES(:cedula, :nombre, :apellido, :direccion, :telefono)";
            $result = $this->conection->prepare($sql);
            $result->bindParam(":cedula", $cedula);
            $result->bindParam(":nombre", $nombre);
            $result->bindParam(":apellido", $apellido);
            $result->bindParam(":direccion", $direccion);
            $result->bindParam(":telefono", $telefono);
            $result->execute();
            if(!$result) {
                http_response_code(400);
                return json_encode(array("error" => "No se pudo guardar el estudiante"));
            }

            http_response_code(201);
            return json_encode(array("message" => "Se guardo correctamente el estudiante"));

        } catch (Exception $e) {
            http_response_code(500);
                return json_encode(array("error" => $e->getMessage()));
        }

    }
}

?>