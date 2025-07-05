<?php
require_once __DIR__ . '../../../controllers/CursoController.php';

$controlador = new CursoController();
$aulas = $controlador->listarAulas();

$id_curso = $_GET['id'] ?? null;
if (!$id_curso) {
    echo "<div class='text-center mt-10 text-red-600'>ID de curso no proporcionado.</div>";
    include_once __DIR__ . '../../../../../public/footer.php';
    exit();
}

$cursoResult = $controlador->buscar($id_curso);
if (!$cursoResult['exito']) {
    echo "<div class='text-center mt-10 text-red-600'>Curso no encontrado.</div>";
    include_once __DIR__ . '../../../../../public/footer.php';
    exit();
}
$curso = $cursoResult['data'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_curso'] ?? '';
    $duracion = $_POST['duracion'] ?? '';
    $estado = $_POST['estado'] ?? 'activo';
    $costo = $_POST['costo'] ?? '';
    $id_aula = $_POST['id_aula'] ?? '';

    $resultado = $controlador->actualizar($id_curso, $nombre, $duracion, $estado, $costo, $id_aula);
    if ($resultado['exito']) {
        header('Location: lista-curso.php?success=actualizado');
        exit();
    } else {
        $error = $resultado['mensaje'] ?? "Error al actualizar el curso.";
    }
}
include_once __DIR__ . '../../../../../public/header.php';
?>

<div class="container mx-auto mt-10 p-4">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Editar Curso</h1>
            <p class="text-lg text-gray-600">Modifica los detalles del curso seleccionado.</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <p class="font-bold">Error</p>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
            <div class="space-y-6">
                <div>
                    <label for="nombre_curso" class="block text-sm font-medium text-gray-700">Nombre del curso</label>
                    <input type="text" id="nombre_curso" name="nombre_curso" value="<?= htmlspecialchars($curso['nombre_curso']) ?>" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (semanas)</label>
                        <input type="number" id="duracion" step="1" min="1" name="duracion" value="<?= htmlspecialchars($curso['duracion']) ?>" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="costo" class="block text-sm font-medium text-gray-700">Costo (S/)</label>
                        <input type="number" id="costo" step="0.01" name="costo" value="<?= htmlspecialchars($curso['costo']) ?>" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="id_aula" class="block text-sm font-medium text-gray-700">Aula</label>
                        <select id="id_aula" name="id_aula" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                            <?php foreach ($aulas as $aula): ?>
                                <option value="<?= $aula['id_aula'] ?>" <?= $curso['id_aula'] == $aula['id_aula'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($aula['nombre']) ?> (Capacidad: <?= $aula['capacidad'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="estado" name="estado" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                            <option value="activo" <?= $curso['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= $curso['estado'] === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end gap-4">
                <a href="lista-curso.php" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors font-semibold">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-md">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '../../../../../public/footer.php'; ?>