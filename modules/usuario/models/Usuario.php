<?php

require_once __DIR__ . "/../../../db/Conn.php";

class Usuario
{
    private $username;
    private $password;
    private $apellidos;
    private $nombres;
    private $tipo;
    private $id_escuela;
    private $email;

    public function __construct()
    {
        /*    $this->username = $username;
        $this->password = $password;
        $this->apellidos = $apellidos;
        $this->nombres = $nombres;
        $this->tipo = $tipo;
        $this->id_escuela = $id_escuela;
        $this->email = $email; */
    }

    public function mostrar()
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "SELECT * FROM usuario";
        $resultado = $conexion->buscar($sql);
        $conn->cerrarConexion();
        return $resultado;
    }

    public function buscar(int $id)
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "SELECT * FROM usuario WHERE id=$id";
        $resultado = $conexion->buscar($sql);
        $conn->cerrarConexion();
        return $resultado;
    }

    public function guardar($username, $nombres, $apellidos, $password, $tipo, $escuela, $email)
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "INSERT INTO usuario(username,nombres,apellidos,password,tipo,id_escuela,email) 
        VALUES('$username','$nombres','$apellidos','$password','$tipo',$escuela,'$email')";
        $resultado = $conexion->correr($sql);
        $conn->cerrarConexion();
        return $resultado;
    }



    public function eliminar($id)
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "DELETE FROM usuario WHERE id=$id";
        $resultado = $conexion->correr($sql);
        $conn->cerrarConexion();
        return $resultado;
    }


    public function actualizar($username, $nombres, $apellidos, $tipo, $id)
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "UPDATE usuario SET username= '$username',nombres='$nombres',apellidos ='$apellidos',tipo='$tipo' WHERE id=$id";
        $resultado = $conexion->correr($sql);
        $conn->cerrarConexion();
        return $resultado;
    }
}
