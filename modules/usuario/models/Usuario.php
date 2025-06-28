<?php

require_once __DIR__ . "/../../../db/Conn.php";

class Usuario
{

    public function __construct() {}

    // Métodos de Estudiante
    public function mostrarEstudiantes()
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "SELECT * FROM usuario";
        $resultado = $conexion->buscar($sql);
        $conn->cerrarConexion();
        return $resultado;
    }

    public function buscarEstudiantePorUsername(string $username)
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "SELECT * FROM usuario WHERE username='$username'";
        $resultado = $conexion->buscar($sql)[0] ?? null;
        $conn->cerrarConexion();
        return $resultado;
    }

    public function registrarEstudiante($username, $nombres, $apellidos, $password, $email, $telefono, $direccion)
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario(username, nombres, apellidos, password, email, telefono, direccion) 
        VALUES('$username','$nombres','$apellidos','$hashedPassword','$email','$telefono','$direccion')";
        $resultado = $conexion->correr($sql);
        $conn->cerrarConexion();
        return $resultado;
    }


    public function eliminarEstudiante($id)
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "DELETE FROM usuario WHERE id=$id";
        $resultado = $conexion->correr($sql);
        $conn->cerrarConexion();
        return $resultado;
    }

    public function actualizarEstudiante($username, $nombres, $apellidos, $telefono, $direccion, $id)
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "UPDATE usuario SET username= '$username',nombres='$nombres',apellidos ='$apellidos',telefono='$telefono',direccion='$direccion' WHERE id=$id";
        $resultado = $conexion->correr($sql);
        $conn->cerrarConexion();
        return $resultado;
    }

    // Métdos de Admin
    public function buscarAdminPorUsername($username)
    {
        $conn = new Conn();
        $conexion = $conn->obtenerConexion();
        $sql = "SELECT * FROM admin WHERE username='$username'";
        $resultado = $conexion->buscar($sql);
        $conn->cerrarConexion();
        return $resultado;
    }
}
