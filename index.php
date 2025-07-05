<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirige al usuario según su rol si la sesión está iniciada
if (isset($_SESSION['tipo_usuario'])) {
    if ($_SESSION['tipo_usuario'] === 'admin') {
        // Redirige al panel de administrador
        header('Location: /modules/curso/views/admin/lista-curso.php');
        exit();
    } elseif ($_SESSION['tipo_usuario'] === 'estudiante') {
        // Redirige al panel de estudiante
        header('Location: /modules/matricula/views/estudiante/mis-cursos.php');
        exit();
    }
} else {
    // Si no hay sesión, redirige a la página de login de estudiante por defecto
    header('Location: /modules/usuario/views/estudiante-login.php');
    exit();
}
