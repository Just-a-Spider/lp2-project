<?php

require_once __DIR__ . "/../../../db/Conn.php";

class Usuario
{

    private $conn = null;

    public function __construct()
    {
        $this->conn = new Conn();
    }

    // Métodos de Estudiante
    public function mostrarEstudiantes()
    {
        $sql = "SELECT * FROM usuario";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'No se encontraron estudiantes'];
        }
        return ['exito' => true, 'data' => $resultado];
    }

    public function buscarEstudiantePorUsername(string $username)
    {
        $sql = "SELECT * FROM usuario WHERE username='$username'";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'Estudiante no encontrado'];
        }
        return ['exito' => true, 'data' => $resultado[0]];
    }

    public function registrarEstudiante($username, $nombres, $apellidos, $password, $email, $telefono, $direccion)
    {
        $sql = "INSERT INTO usuario(username, nombres, apellidos, password, email, telefono, direccion) 
        VALUES('$username','$nombres','$apellidos','$password','$email','$telefono','$direccion')";
        $resultado = $this->conn->correr($sql);
        if (!$resultado) {
            return ['exito' => false, 'mensaje' => 'Error al registrar el estudiante'];
        }
        return ['exito' => true, 'mensaje' => 'Estudiante registrado exitosamente'];
    }

    public function eliminarEstudiante($id)
    {
        $sql = "DELETE FROM usuario WHERE id=$id";
        $resultado = $this->conn->correr($sql);
        if (!$resultado) {
            return ['exito' => false, 'mensaje' => 'Error al eliminar el estudiante'];
        }
        return ['exito' => true, 'mensaje' => 'Estudiante eliminado exitosamente'];
    }

    public function actualizarEstudiante($username, $nombres, $apellidos, $telefono, $direccion, $id)
    {
        $sql = "UPDATE usuario SET username= '$username',nombres='$nombres',apellidos ='$apellidos',telefono='$telefono',direccion='$direccion' WHERE id=$id";
        $resultado = $this->conn->correr($sql);
        if (!$resultado) {
            return ['exito' => false, 'mensaje' => 'Error al actualizar el estudiante'];
        }
        return ['exito' => true, 'mensaje' => 'Estudiante actualizado exitosamente'];
    }

    // Métodos de Admin
    public function buscarAdminPorUsername($username)
    {
        $sql = "SELECT * FROM usuario WHERE username='$username' AND tipo='admin'";
        $resultado = $this->conn->buscar($sql);
        if (empty($resultado)) {
            return ['exito' => false, 'mensaje' => 'Administrador no encontrado'];
        }
        return ['exito' => true, 'data' => $resultado[0]];
    }
}
