<?php
include_once __DIR__ . '../../../../public/header.php';
require_once __DIR__ . '../../controllers/EstudianteController.php';

$controlador = new EstudianteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';

    $resultado = $controlador->registrarse($username, $nombres, $apellidos, $password, $email, $telefono, $direccion);
    $mensaje = $resultado['mensaje'];
    $exito = $resultado['exito'];
}
?>

<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    <h2 class="text-xl font-bold mb-6 text-center">Registro de Estudiante</h2>
    <?php if (isset($mensaje)): ?>
        <div class="<?= $exito ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' ?> border px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-4">
            <label class="block text-sm font-medium">Username*</label>
            <input type="text" name="username" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Nombres*</label>
            <input type="text" name="nombres" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Apellidos*</label>
            <input type="text" name="apellidos" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Contraseña*</label>
            <input type="password" name="password" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Email*</label>
            <input type="email" name="email" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium">Teléfono</label>
            <input type="text" name="telefono" class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium">Dirección</label>
            <input type="text" name="direccion" class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Registrarse</button>
    </form>
    <div class="mt-4 text-center">
        <a href="estudiante-login.php" class="text-blue-600 hover:underline">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
</div>
<?php include_once __DIR__ . '../../../../public/footer.php'; ?>