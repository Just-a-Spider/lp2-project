<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$esEstudiante = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'estudiante';
$esAdmin = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';

$estudianteLogin = "/modules/usuario/views/estudiante-login.php";
$estudianteRegistro = "/modules/usuario/views/estudiante-registro.php";
$adminLogin = "/modules/usuario/views/admin-login.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <div class="flex items-center">
                        <span class="mr-2 ml-2 text-xl font-bold text-gray-900">Academia </span>
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">E</span>
                        </div>
                    </div>
                </div>

                <?php if ($esEstudiante): ?>
                    <!-- Student Navigation -->
                    <nav class="hidden md:flex space-x-4">
                        <a href="/modules/curso/views/estudiante/lista-cursos.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Cursos Disponibles
                        </a>
                        <a href="/modules/matricula/views/estudiante/mis-cursos.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Mis Cursos
                        </a>
                        <a href="/modules/usuario/views/estudiante-logout.php" class="bg-red-500 hover:bg-red-700 text-white rounded-xl px-3 py-2 text-sm">
                            Cerrar Sesión
                        </a>
                    </nav>

                <?php elseif ($esAdmin): ?>
                    <!-- Admin Navigation -->
                    <nav class="hidden md:flex space-x-4">
                        <a href="/modules/curso/views/admin/lista-curso.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Listar Cursos
                        </a>
                        <a href="/modules/curso/views/admin/crear-curso.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Crear Curso
                        </a>
                        <a href="/modules/usuario/views/admin-logout.php" class="bg-red-500 hover:bg-red-700 text-white rounded-xl px-3 py-2 text-sm">
                            Cerrar Sesión
                        </a>
                    </nav>

                <?php else: ?>
                    <!-- Default CTA Buttons -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="<?= $estudianteLogin ?>" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Iniciar Sesión
                        </a>
                        <a href="<?= $estudianteRegistro ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Regístrate
                        </a>
                        <a href="<?= $adminLogin ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Admin Login
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="mobile-menu-button text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600 p-2" aria-label="Toggle menu">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="mobile-menu hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <div class="pt-4 pb-2 border-t border-gray-200">
                    <a href="/modules/usuario/views/estudiante-login.php" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors">
                        Inicair Sesión
                    </a>
                    <a href="/modules/usuario/views/estudiante-registro.php" class="block px-3 py-2 text-base font-medium bg-blue-600 text-white hover:bg-blue-700 rounded-md transition-colors mx-3 mt-2 text-center">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </header>
    <div class="flex-grow">
