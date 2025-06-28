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

        if ($admin && count($admin) > 0) {
            $adminData = $admin[0];
            if (password_verify($password, $adminData['password'])) {
                session_start();
                $_SESSION['admin_id'] = $adminData['id'];
                $_SESSION['admin_username'] = $adminData['username'];
                $_SESSION['tipo_usuario'] = 'admin';
                return ['exito' => true, 'mensaje' => 'Login exitoso'];
            }
        }
        return ['exito' => false, 'mensaje' => 'Credenciales incorrectas'];
    }

    public function logout()
    {
        session_start();
        session_destroy();
        return ['exito' => true, 'mensaje' => 'Logout exitoso'];
    }

    // CRUD operations for students
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
