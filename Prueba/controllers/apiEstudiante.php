<?php
include "../models/estudiante.php";

$metho = $_SERVER['REQUEST_METHOD'];

$estudiante = new Estudiante();

switch ($metho) {
    case 'GET':
        $estudiante = $estudiante->getAll();
        echo $estudiante;
        break;

    case 'POST':

        $data = json_decode(file_get_contents('php://input'), true);

        $cedula = $data["cedula"];
        $nombre = $data["nombre"];
        $apellido = $data["apellido"];
        $direccion = $data["direccion"];
        $telefono = $data["telefono"];

        $estudiante = $estudiante->create($cedula, $nombre, $apellido, $direccion, $telefono);
        echo $estudiante;
        break;
    default:
        # code...
        break;
}
