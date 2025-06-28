<?php
require_once __DIR__ . "/../models/Usuario.php";

class EstudianteController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Usuario();
    }

    public function login($username, $password) {
        $estudiante = $this->modelo->buscarEstudiantePorUsername($username);
        
        if ($estudiante) {
            if (password_verify($password, $estudiante['password'])) {
                session_start();
                $_SESSION['estudiante_id'] = $estudiante['id'];
                $_SESSION['estudiante_username'] = $estudiante['username'];
                $_SESSION['estudiante_nombres'] = $estudiante['nombres'];
                $_SESSION['estudiante_apellidos'] = $estudiante['apellidos'];
                $_SESSION['tipo_usuario'] = 'estudiante';
                return ['exito' => true, 'mensaje' => 'Login exitoso'];
            }
        }
        return ['exito' => false, 'mensaje' => 'Credenciales incorrectas'];
    }

    public function logout() {
        session_start();
        session_destroy();
        return ['exito' => true, 'mensaje' => 'Logout exitoso'];
    }

    public function verificarSesion() {
        session_start();
        return isset($_SESSION['estudiante_id']) && $_SESSION['tipo_usuario'] === 'estudiante';
    }

    public function registrarse($username, $nombres, $apellidos, $password, $email, $telefono, $direccion) {
        // Verificar si el username ya existe
        $existeUsuario = $this->modelo->buscarEstudiantePorUsername($username);
        if ($existeUsuario) {
            return ['exito' => false, 'mensaje' => 'El username ya existe'];
        }

        // Validar campos requeridos
        if (empty($username) || empty($nombres) || empty($apellidos) || empty($password) || empty($email)) {
            return ['exito' => false, 'mensaje' => 'Todos los campos obligatorios deben estar completos'];
        }

        // Validar formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['exito' => false, 'mensaje' => 'El formato del email no es válido'];
        }

        $resultado = $this->modelo->registrarEstudiante($username, $nombres, $apellidos, $password, $email, $telefono, $direccion);
        if ($resultado) {
            return ['exito' => true, 'mensaje' => 'Registro exitoso. Ya puedes iniciar sesión'];
        }
        return ['exito' => false, 'mensaje' => 'Error al registrar usuario'];
    }

    public function obtenerPerfil() {
        if (!$this->verificarSesion()) {
            return ['exito' => false, 'mensaje' => 'No autorizado'];
        }

        session_start();
        $username = $_SESSION['estudiante_username'];
        $estudiante = $this->modelo->buscarEstudiantePorUsername($username);
        
        if ($estudiante) {
            // Remover la contraseña de los datos retornados
            unset($estudiante['password']);
            return ['exito' => true, 'data' => $estudiante];
        }
        return ['exito' => false, 'mensaje' => 'Usuario no encontrado'];
    }

    public function actualizarPerfil($nombres, $apellidos, $email, $telefono, $direccion) {
        if (!$this->verificarSesion()) {
            return ['exito' => false, 'mensaje' => 'No autorizado'];
        }

        session_start();
        $id = $_SESSION['estudiante_id'];
        $username = $_SESSION['estudiante_username'];

        // Validar campos requeridos
        if (empty($nombres) || empty($apellidos) || empty($email)) {
            return ['exito' => false, 'mensaje' => 'Los campos nombres, apellidos y email son obligatorios'];
        }

        // Validar formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['exito' => false, 'mensaje' => 'El formato del email no es válido'];
        }

        $resultado = $this->modelo->actualizarEstudiante($username, $nombres, $apellidos, $telefono, $direccion, $id);
        if ($resultado) {
            // Actualizar datos de sesión
            $_SESSION['estudiante_nombres'] = $nombres;
            $_SESSION['estudiante_apellidos'] = $apellidos;
            return ['exito' => true, 'mensaje' => 'Perfil actualizado exitosamente'];
        }
        return ['exito' => false, 'mensaje' => 'Error al actualizar perfil'];
    }
}