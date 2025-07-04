<?php
require_once __DIR__ . "/../models/Usuario.php";

class AdminController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Usuario();
    }

    public function login($username, $password)
    {
        $admin = $this->modelo->buscarAdminPorUsername($username);

        if ($admin['exito']) {
            $adminData = $admin['data'];
            if (password_verify($password, $adminData['password'])) {
                $_SESSION['admin_id'] = $adminData['id_usuario'];
                $_SESSION['admin_username'] = $adminData['username'];
                $_SESSION['tipo_usuario'] = 'admin';
                return ['exito' => true, 'mensaje' => 'Login exitoso'];
            } else {
                return ['exito' => false, 'mensaje' => 'Contraseña incorrecta'];
            }
        }
        return ['exito' => false, 'mensaje' => $admin['mensaje'] ?? 'Credenciales incorrectas'];
    }

    public function logout()
    {
        session_start();
        session_destroy();
        return ['exito' => true, 'mensaje' => 'Logout exitoso'];
    }

    // CRUD para estudiantes por si acaso
    public function listarEstudiantes()
    {
        $estudiantes = $this->modelo->mostrarEstudiantes();
        return ['exito' => true, 'data' => $estudiantes];
    }

    public function buscarEstudiante($username)
    {
        $estudiante = $this->modelo->buscarEstudiantePorUsername($username);
        return ['exito' => true, 'data' => $estudiante];
    }
}
