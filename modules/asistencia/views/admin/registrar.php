<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/AsistenciaController.php';
require_once __DIR__ . '../../../controllers/CursoController.php';

$asistencia_controller = new AsistenciaController();
$curso_controller = new CursoController();

$id_curso = $_GET['id_curso'] ?? null;
if (!$id_curso) {
    echo "<div class='text-center mt-10 text-red-600'>ID de curso no proporcionado.</div>";
    exit();
}

$curso_info = $curso_controller->buscar($id_curso);
if (!$curso_info['exito']) {
    echo "<div class='text-center mt-10 text-red-600'>Curso no encontrado.</div>";
    exit();
}

$estudiantes_resultado = $asistencia_controller->obtenerEstudiantes($id_curso);
$estudiantes = $estudiantes_resultado['exito'] ? $estudiantes_resultado['data'] : [];

$horarios_resultado = $curso_controller->obtenerHorariosPorCurso($id_curso);
$horarios = $horarios_resultado['exito'] ? $horarios_resultado['data'] : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_horario = $_POST['id_horario'] ?? null;
    $asistencias = $_POST['asistencias'] ?? [];

    if ($id_horario && !empty($asistencias)) {
        foreach ($asistencias as $id_estudiante => $estado) {
            $asistencia_controller->registrar($id_estudiante, $id_horario, $estado);
        }
        $mensaje = "Asistencia registrada exitosamente.";
    }
}
?>

<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center">Registrar Asistencia para <?= htmlspecialchars($curso_info['data']['nombre_curso']) ?></h1>

    <?php if (isset($mensaje)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Seleccionar Horario</label>
            <select name="id_horario" required class="mt-1 block w-full border rounded px-3 py-2">
                <option value="">Seleccione un horario</option>
                <?php foreach ($horarios as $horario): ?>
                    <option value="<?= $horario['id_horario'] ?>"><?= htmlspecialchars($horario['dia'] . ' ' . $horario['fecha'] . ' ' . $horario['hora']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Estudiante</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Presente</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Ausente</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Justificado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?></td>
                            <td class="py-3 px-4 text-sm text-gray-800 text-center"><input type="radio" name="asistencias[<?= $estudiante['id_usuario'] ?>]" value="presente" required></td>
                            <td class="py-3 px-4 text-sm text-gray-800 text-center"><input type="radio" name="asistencias[<?= $estudiante['id_usuario'] ?>]" value="ausente"></td>
                            <td class="py-3 px-4 text-sm text-gray-800 text-center"><input type="radio" name="asistencias[<?= $estudiante['id_usuario'] ?>]" value="justificado"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Registrar Asistencia</button>
        </div>
    </form>
</div>

<?php
include_once __DIR__ . '../../../../../public/footer.php';
?>
