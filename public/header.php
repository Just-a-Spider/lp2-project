<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$esEstudiante = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'estudiante';
$esAdmin = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';

$nombreUsuario = '';
if ($esEstudiante) {
    $nombreUsuario = $_SESSION['estudiante_nombres'] ?? 'Estudiante';
} elseif ($esAdmin) {
    $nombreUsuario = $_SESSION['admin_username'] ?? 'Admin';
}

$estudianteLogin = "/modules/usuario/views/estudiante-login.php";
$estudianteRegistro = "/modules/usuario/views/estudiante-registro.php";
$adminLogin = "/modules/usuario/views/admin-login.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia E</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/heroicons/2.0.16/24/outline/heroicons.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col font-sans">
    <header x-data="{ mobileMenuOpen: false }" class="bg-white shadow-md border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="/index.php" class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-inner">
                        <span class="text-white font-bold text-2xl">E</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-800">Academia</span>
                </a>

                <!-- Navegación para Escritorio -->
                <nav class="hidden md:flex items-center space-x-8">
                    <?php if ($esEstudiante): ?>
                        <a href="/modules/curso/views/estudiante/lista-cursos.php" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Cursos Disponibles</a>
                        <a href="/modules/matricula/views/estudiante/mis-cursos.php" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Mis Cursos</a>
                    <?php elseif ($esAdmin): ?>
                        <a href="/modules/curso/views/admin/lista-curso.php" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Gestionar Cursos</a>
                        <a href="/modules/curso/views/admin/crear-curso.php" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Nuevo Curso</a>
                    <?php endif; ?>
                </nav>

                <!-- Botones de Usuario / CTA -->
                <div class="hidden md:flex items-center space-x-4">
                    <?php if ($esEstudiante || $esAdmin): ?>
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-3 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors">
                                <span class="font-medium text-gray-700">Hola, <?= htmlspecialchars($nombreUsuario) ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50" x-transition>
                                <a href="<?= $esAdmin ? '/modules/usuario/views/admin-logout.php' : '/modules/usuario/views/estudiante-logout.php' ?>" class="block px-4 py-2 text-gray-700 hover:bg-red-100 hover:text-red-600">Cerrar Sesión</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= $estudianteLogin ?>" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Iniciar Sesión</a>
                        <a href="<?= $estudianteRegistro ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-medium transition-colors shadow-md">Regístrate</a>
                    <?php endif; ?>
                </div>

                <!-- Botón de Menú Móvil -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-blue-600 p-2 rounded-md">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menú de Navegación Móvil -->
        <div x-show="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-200" x-transition>
            <div class="px-4 pt-4 pb-6 space-y-4">
                <?php if ($esEstudiante): ?>
                    <a href="/modules/curso/views/estudiante/lista-cursos.php" class="block text-gray-700 hover:bg-gray-100 p-3 rounded-lg font-medium">Cursos Disponibles</a>
                    <a href="/modules/matricula/views/estudiante/mis-cursos.php" class="block text-gray-700 hover:bg-gray-100 p-3 rounded-lg font-medium">Mis Cursos</a>
                    <a href="/modules/usuario/views/estudiante-logout.php" class="block text-red-600 bg-red-50 hover:bg-red-100 p-3 rounded-lg font-medium text-center">Cerrar Sesión</a>
                <?php elseif ($esAdmin): ?>
                    <a href="/modules/curso/views/admin/lista-curso.php" class="block text-gray-700 hover:bg-gray-100 p-3 rounded-lg font-medium">Gestionar Cursos</a>
                    <a href="/modules/curso/views/admin/crear-curso.php" class="block text-gray-700 hover:bg-gray-100 p-3 rounded-lg font-medium">Nuevo Curso</a>
                    <a href="/modules/usuario/views/admin-logout.php" class="block text-red-600 bg-red-50 hover:bg-red-100 p-3 rounded-lg font-medium text-center">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="<?= $estudianteLogin ?>" class="block text-gray-700 hover:bg-gray-100 p-3 rounded-lg font-medium">Iniciar Sesión</a>
                    <a href="<?= $estudianteRegistro ?>" class="block bg-blue-600 text-white p-3 rounded-lg font-medium text-center">Regístrate Gratis</a>
                    <a href="<?= $adminLogin ?>" class="block text-center text-sm text-gray-600 hover:text-blue-600 pt-4">Acceso Admin</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main class="flex-grow">