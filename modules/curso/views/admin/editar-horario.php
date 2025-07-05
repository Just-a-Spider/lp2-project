<?php
// filepath: /home/andre/Academics/LPII/Projects/current/modules/curso/views/admin/editar-horario.php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/CursoController.php';
require_once __DIR__ . '../../../controllers/HorarioController.php';

$id_curso = $_GET['id_curso'] ?? null;
if (!$id_curso) {
    echo "<div class='text-center mt-10 text-red-600'>ID de curso no proporcionado.</div>";
    exit();
}

$cursoCtrl = new CursoController();
$horarioCtrl = new HorarioController();
$curso = $cursoCtrl->buscar($id_curso)['data'];
$duracion = $curso['duracion'];

$horario_resultado = $horarioCtrl->listarPorCurso($id_curso);
$horarios_data = $horario_resultado['exito'] ? $horario_resultado['data'] : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dias = $_POST['dias'] ?? [];
    $hora = $_POST['hora'] ?? '';

    if (empty($dias)) {
        $error = 'Debe seleccionar al menos un día de clase.';
    } elseif (empty($hora)) {
        $error = 'Debe especificar una hora de inicio.';
    } else {
        $resultado = $horarioCtrl->actualizar($id_curso, $dias, $hora, $duracion);
        if ($resultado['exito']) {
            header("Location: lista-curso.php");
            exit();
        } else {
            $error = $resultado['mensaje'];
            $conflictos = $resultado['horarios_conflicto'] ?? [];
        }
    }
}
?>

<div class="max-w-2xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Editar Horarios - <?= htmlspecialchars($curso['nombre_curso']) ?></h2>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
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

    <form method="POST" class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Días de clase</label>
            <div class="grid grid-cols-2 gap-2">
                <?php
                $diasSeleccionados = [];
                if (!empty($horarios_data)) {
                    foreach ($horarios_data as $h) {
                        $diasSeleccionados[] = $h['dia'];
                    }
                    $diasSeleccionados = array_unique($diasSeleccionados);
                }
                foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia): ?>
                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="dias[]" value="<?= $dia ?>" <?= in_array($dia, $diasSeleccionados) ? 'checked' : '' ?> class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="text-sm text-gray-700"><?= $dia ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Hora de inicio</label>
            <input type="time" name="hora" value="<?= !empty($horarios_data) ? htmlspecialchars($horarios_data[0]['hora']) : '' ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Duración</label>
            <input type="text" value="<?= htmlspecialchars($duracion) ?> semanas" disabled class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100" />
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                Actualizar Horarios
            </button>
            <a href="lista-curso.php" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
                Cancelar
            </a>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '../../../../../public/footer.php'; ?>