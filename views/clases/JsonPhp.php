<?php
//json_encode convertir run objeto de php a json
//Con la flecha es para hacer referencia a un objeto, la flecha sirve para llamar a los metodos y atributos como en js 

header('Content_Type:application/json; charset=utf-8;');
$objeto = new stdClass();
$objeto->nombre = "Carlos";
$objeto->apellido = "Mundo";
print_r($objeto);
$miJson = json_encode($objeto);
echo ($miJson);

//array simple de php a Json
$colores = array('rojo', 'verde');
print_r($colores);
$JsonColores = json_encode($colores);
echo ($JsonColores);
//aray asociativos de php a Json
$arrayAso = array('Nombre' => 'Carlos', 'Apellido' => 'Nunez');
print_r($arrayAso);
echo (json_encode($arrayAso));

//Json a php json decode
//convierte de JSON  PHP

$lista = '{ "nombre": "Carlos", "apellido": "Jimenez", "edad" : 20 }';
echo ($lista);

$miPhp = json_decode($lista);
print_r($miPhp)

?>