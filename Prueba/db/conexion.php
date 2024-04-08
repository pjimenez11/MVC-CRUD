
<?php

class Conexion
{
    private $server;
    private $db;
    private $user;
    private $pw;
    private $opc;

    private static $conexion;

    public function __construct()
    {
        $this->server = "localhost";
        $this->db = "quinto";
        $this->user = "root";
        $this->pw = "";
        $this->opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    }

    public static function conectar()
    {
        if (!isset(self::$conexion)) {
            $conexion = new Conexion();
            try {
                self::$conexion = new PDO("mysql:host=" . $conexion->server .";dbname=". $conexion->db, $conexion->user, $conexion->pw, $conexion->opc);
            } catch (Exception $e) {
                http_response_code(500);
                die("Error:" . $e->getMessage());
            }
        } 
        return self::$conexion;
    }
}

?>