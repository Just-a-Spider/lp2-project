<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/CursoController.php';

$controlador = new CursoController();

$id_curso = $_GET['id'] ?? null;
if (!$id_curso) {
    echo "<div class='text-center mt-10 text-red-600'>ID de curso no proporcionado.</div>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $controlador->eliminar($id_curso);
    if ($resultado['exito']) {
        header('Location: lista-curso.php');
        exit();
    } else {
        $error = "Error al eliminar el curso.";
    }
}

$curso = $controlador->buscar($id_curso)['data'];
?>

<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    <h2 class="text-xl font-bold mb-6 text-center text-red-600">Eliminar Curso</h2>
    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <p class="mb-6 text-center">¿Estás seguro de que deseas eliminar el curso <strong><?= htmlspecialchars($curso['nombre_curso']) ?></strong>?</p>
        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">Eliminar</button>
        <a href="lista-curso.php" class="block mt-4 text-center text-blue-600 hover:underline">Cancelar</a>
    </form>
</div>