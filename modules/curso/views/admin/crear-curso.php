<?php
require_once __DIR__ . '../../../controllers/CursoController.php';

$controlador = new CursoController();
$aulas = $controlador->listarAulas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_curso'] ?? '';
    $duracion = $_POST['duracion'] ?? '';
    $estado = $_POST['estado'] ?? 'activo';
    $costo = $_POST['costo'] ?? '';
    $id_aula = $_POST['id_aula'] ?? '';
    $dias = $_POST['dias'] ?? [];
    $hora = $_POST['hora'] ?? '';

    if (empty($dias)) {
        $error = 'Debe seleccionar al menos un día de clase.';
    } elseif (empty($hora)) {
        $error = 'Debe especificar una hora de inicio.';
    } else {
        $resultado = $controlador->registrarConHorarios($nombre, $duracion, $estado, $costo, $id_aula, $dias, $hora);
        if ($resultado['exito']) {
            header("Location: lista-curso.php?success=creado");
            exit();
        } else {
            $error = $resultado['mensaje'] ?? 'Error al crear el curso.';
            $conflictos = $resultado['horarios_conflicto'] ?? [];
        }
    }
}
include_once __DIR__ . '../../../../../public/header.php';
?>

<div class="container mx-auto mt-10 p-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Crear Nuevo Curso</h1>
            <p class="text-lg text-gray-600">Rellena los detalles para añadir un nuevo curso al sistema.</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <p class="font-bold">Error al crear el curso</p>
                <p><?= htmlspecialchars($error) ?></p>
                <?php if (!empty($conflictos)): ?>
                    <div class="mt-2">
                        <strong>Conflictos de horario detectados:</strong>
                        <ul class="list-disc list-inside mt-1 text-sm">
                            <?php foreach ($conflictos as $conflicto): ?>
                                <li><?= htmlspecialchars($conflicto['nombre_curso']) ?> en el aula seleccionada - <?= htmlspecialchars($conflicto['dia']) ?> a las <?= htmlspecialchars(date("g:i A", strtotime($conflicto['hora']))) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <!-- Columna Izquierda: Detalles del Curso -->
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Información Básica</h3>
                    <div>
                        <label for="nombre_curso" class="block text-sm font-medium text-gray-700">Nombre del curso *</label>
                        <input type="text" id="nombre_curso" name="nombre_curso" value="<?= htmlspecialchars($_POST['nombre_curso'] ?? '') ?>" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (semanas) *</label>
                        <input type="number" id="duracion" step="1" min="1" name="duracion" value="<?= htmlspecialchars($_POST['duracion'] ?? '') ?>" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="costo" class="block text-sm font-medium text-gray-700">Costo (S/) *</label>
                        <input type="number" id="costo" step="0.01" min="0" name="costo" value="<?= htmlspecialchars($_POST['costo'] ?? '') ?>" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                     <div>
                        <label for="id_aula" class="block text-sm font-medium text-gray-700">Aula *</label>
                        <select id="id_aula" name="id_aula" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione un aula</option>
                            <?php foreach ($aulas as $aula): ?>
                                <option value="<?= $aula['id_aula'] ?>" <?= ($_POST['id_aula'] ?? '') == $aula['id_aula'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($aula['nombre']) ?> (Capacidad: <?= $aula['capacidad'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Columna Derecha: Horarios -->
                <div class="space-y-6">
                     <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Horario de Clases</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Días de clase *</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <?php
                            $diasSeleccionados = $_POST['dias'] ?? [];
                            foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia): ?>
                                <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="dias[]" value="<?= $dia ?>" <?= in_array($dia, $diasSeleccionados) ? 'checked' : '' ?> class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="text-sm text-gray-700"><?= $dia ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div>
                        <label for="hora" class="block text-sm font-medium text-gray-700">Hora de inicio *</label>
                        <input type="time" id="hora" name="hora" value="<?= htmlspecialchars($_POST['hora'] ?? '') ?>" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                     <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado del curso</label>
                        <select id="estado" name="estado" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                            <option value="activo" <?= ($_POST['estado'] ?? 'activo') === 'activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= ($_POST['estado'] ?? '') === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end gap-4">
                <a href="lista-curso.php" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors font-semibold">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-md">Crear Curso</button>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '../../../../../public/footer.php'; ?>
