<?php
include "../models/estudiante.php";

$opc = $_SERVER['REQUEST_METHOD'];

$estudiante = new Estudiante();

switch ($opc) {
    case 'GET':
        $resultado = $estudiante->obtenerEstudiantes();
        echo $resultado;
        break;
    case 'POST':
        $cedula = $_POST["cedula"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $direccion = $_POST["direccion"];
        $telefono = $_POST["telefono"];

        $resultado = $estudiante->insertarEstudiante($cedula, $nombre, $apellido, $direccion, $telefono);
        echo $resultado;
        break;
    case 'PUT':

        $cedula = $_GET["cedula"];
        $nombre = $_GET["nombre"];
        $apellido = $_GET["apellido"];
        $direccion = $_GET["direccion"];
        $telefono = $_GET["telefono"];

       $resultado = $estudiante->actualizarEstudiante($cedula, $nombre, $apellido, $direccion, $telefono);
        echo $resultado;
        break;
    case 'DELETE':
        $cedula = $_GET["cedula"];

        $resultado  = $estudiante->eliminarEstudiante($cedula);
        
        echo $resultado;
        break;
    default:
        $resultado = "Metodo no implementado: " . $opc;
        echo $resultado;
        break;
}


?>