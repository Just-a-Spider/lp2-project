<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/CursoController.php';

$controlador = new CursoController();
$aulas = $controlador->listarAulas();

$id_curso = $_GET['id'] ?? null;
if (!$id_curso) {
    echo "<div class='text-center mt-10 text-red-600'>ID de curso no proporcionado.</div>";
    exit();
}

$curso = $controlador->buscar($id_curso)['data'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_curso'] ?? '';
    $duracion = $_POST['duracion'] ?? '';
    $estado = $_POST['estado'] ?? 'activo';
    $costo = $_POST['costo'] ?? '';
    $id_aula = $_POST['id_aula'] ?? '';

    $resultado = $controlador->actualizar($id_curso, $nombre, $duracion, $estado, $costo, $id_aula);
    if ($resultado['exito']) {
        header('Location: lista-curso.php');
        exit();
    } else {
        $error = "Error al actualizar el curso.";
    }
}
?>

<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    <h2 class="text-xl font-bold mb-6 text-center">Editar Curso</h2>
    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nombre del curso</label>
            <input type="text" name="nombre_curso" value="<?= htmlspecialchars($curso['nombre_curso']) ?>" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Duración</label>
            <input type="text" name="duracion" value="<?= htmlspecialchars($curso['duracion']) ?>" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Estado</label>
            <select name="estado" class="mt-1 block w-full border rounded px-3 py-2">
                <option value="activo" <?= $curso['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                <option value="inactivo" <?= $curso['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Costo</label>
            <input type="number" step="0.01" name="costo" value="<?= htmlspecialchars($curso['costo']) ?>" required class="mt-1 block w-full border rounded px-3 py-2" />
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Aula</label>
            <select name="id_aula" required class="mt-1 block w-full border rounded px-3 py-2">
                <?php foreach ($aulas as $aula): ?>
                    <option value="<?= $aula['id_aula'] ?>" <?= $curso['id_aula'] == $aula['id_aula'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($aula['nombre']) ?> (Capacidad: <?= $aula['capacidad'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Actualizar Curso</button>
    </form>
</div>
<?php include_once __DIR__ . '../../../../public/footer.php'; ?>