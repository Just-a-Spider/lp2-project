<?php
class Conn{
    private $dsn;
    private $usuario;
    private $passw;
    private $conexion;

    public function __construct() {
        $this->dsn = "mysql:host=localhost;dbname=sistema_matriculas";
        $this->usuario = "root";
        $this->passw = "";
    }

    public function conectar(){
        $this->conexion = new PDO($this->dsn, $this->usuario, $this->passw);
        return $this->conexion;
    }
    public function cerrarConexion(){
        $this->conexion = null;
    }
}