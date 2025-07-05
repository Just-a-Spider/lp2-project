<?php
// filepath: /home/andre/Academics/LPII/Projects/current/modules/curso/views/admin/crear-curso.php
include_once __DIR__ . '../../../../../public/header.php';
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

    // Validaciones básicas
    if (empty($dias)) {
        $error = 'Debe seleccionar al menos un día de clase.';
    } elseif (empty($hora)) {
        $error = 'Debe especificar una hora de inicio.';
    } else {
        $resultado = $controlador->registrarConHorarios($nombre, $duracion, $estado, $costo, $id_aula, $dias, $hora);
        if ($resultado['exito']) {
            header("Location: lista-curso.php");
            exit();
        } else {
            $error = $resultado['mensaje'] ?? 'Error al crear el curso.';
            $conflictos = $resultado['horarios_conflicto'] ?? [];
        }
    }
}
?>

<div class="max-w-6xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Crear Curso</h2>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 max-w-4xl mx-auto">
            <?= htmlspecialchars($error) ?>
            <?php if (!empty($conflictos)): ?>
                <div class="mt-2">
                    <strong>Conflictos detectados:</strong>
                    <ul class="list-disc list-inside mt-1">
                        <?php foreach ($conflictos as $conflicto): ?>
                            <li><?= htmlspecialchars($conflicto['nombre_curso']) ?> - <?= htmlspecialchars($conflicto['dia']) ?> <?= htmlspecialchars($conflicto['hora']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="max-w-6xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-6 justify-center mb-6">
            <!-- Información del Curso -->
            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex-1 max-w-lg">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Información del Curso</h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del curso *</label>
                    <input type="text" name="nombre_curso" value="<?= htmlspecialchars($_POST['nombre_curso'] ?? '') ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duración (semanas) *</label>
                    <input type="number" step="1" min="1" name="duracion" value="<?= htmlspecialchars($_POST['duracion'] ?? '') ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="estado" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="activo" <?= ($_POST['estado'] ?? '') === 'activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="inactivo" <?= ($_POST['estado'] ?? '') === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Costo *</label>
                    <input type="number" step="0.01" min="0" name="costo" value="<?= htmlspecialchars($_POST['costo'] ?? '') ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Aula *</label>
                    <select name="id_aula" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Seleccione un aula</option>
                        <?php foreach ($aulas as $aula): ?>
                            <option value="<?= $aula['id_aula'] ?>" <?= ($_POST['id_aula'] ?? '') == $aula['id_aula'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($aula['nombre']) ?> (Capacidad: <?= $aula['capacidad'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Horarios -->
            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex-1 max-w-lg">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Horarios de Clase</h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Días de clase *</label>
                    <div class="grid grid-cols-2 gap-2">
                        <?php
                        $diasSeleccionados = $_POST['dias'] ?? [];
                        foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia): ?>
                            <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="dias[]" value="<?= $dia ?>" <?= in_array($dia, $diasSeleccionados) ? 'checked' : '' ?> class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="text-sm text-gray-700"><?= $dia ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora de inicio *</label>
                    <input type="time" name="hora" value="<?= htmlspecialchars($_POST['hora'] ?? '') ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p class="text-xs text-gray-500 mt-1">Cada clase dura 1 hora y 30 minutos</p>
                </div>
            </div>
        </div>

        <!-- Botón debajo de los contenedores -->
        <div class="flex flex-col items-center space-y-4">
            <button type="submit" class="w-full max-w-md bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                Crear Curso con Horarios
            </button>
            <a href="lista-curso.php" class="text-gray-600 hover:text-gray-800 underline">Cancelar</a>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '../../../../../public/footer.php'; ?>