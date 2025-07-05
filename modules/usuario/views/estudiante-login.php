<?php
include_once __DIR__ . '../../../../public/header.php';
require_once __DIR__ . '../../controllers/EstudianteController.php';

$controlador = new EstudianteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $resultado = $controlador->login($username, $password);
    $mensaje = $resultado['mensaje'];
    $exito = $resultado['exito'];
    if ($exito) {
        header('Location: /'); // Redirige al inicio o dashboard
        exit();
    }
}
?>

<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    <h2 class="text-xl font-bold mb-6 text-center">Iniciar Sesión</h2>
    <?php if (isset($mensaje)): ?>
        <div class="<?= $exito ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' ?> border px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-4">
            <label class="block text-sm font-medium">Username</label>
            <input type="text" name="username" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium">Contraseña</label>
            <input type="password" name="password" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Iniciar Sesión</button>
    </form>
    <div class="mt-4 text-center">
        <a href="estudiante-registro.php" class="text-blue-600 hover:underline">¿No tienes cuenta? Regístrate</a>
    </div>
</div>
<?php include_once __DIR__ . '../../../../public/footer.php'; ?>