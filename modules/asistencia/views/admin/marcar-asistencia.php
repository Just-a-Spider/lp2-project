<?php
require_once __DIR__ . './../../controllers/AsistenciaController.php';
require_once __DIR__ . './../../../curso/controllers/CursoController.php';

$id_curso = $_GET['id_curso'] ?? null;
$id_horario = $_GET['id_horario'] ?? null;
$asistencia_controller = new AsistenciaController();
$curso_controller = new CursoController();

if (!$id_curso) {
    echo "<div class='text-center mt-10 text-red-600'>ID de curso no proporcionado.</div>";
    exit();
}

$curso_info = $curso_controller->buscar($id_curso);
$curso_nombre = $curso_info['exito'] ? $curso_info['data']['nombre_curso'] : 'Curso no encontrado';

$horarios_resultado = $asistencia_controller->obtenerHorariosPorCurso($id_curso);
$horarios = $horarios_resultado['exito'] ? $horarios_resultado['data'] : [];

if (!$id_horario && !empty($horarios)) {
    $id_horario = $horarios[0]['id_horario'];
}

$estudiantes_resultado = $asistencia_controller->obtenerEstudiantes($id_curso);
$estudiantes = $estudiantes_resultado['exito'] ? $estudiantes_resultado['data'] : [];

$asistencias_map = [];
if ($id_horario) {
    $asistencias_resultado = $asistencia_controller->obtenerAsistenciasPorHorario($id_horario);
    if ($asistencias_resultado['exito']) {
        foreach ($asistencias_resultado['data'] as $a) {
            $asistencias_map[$a['id_estudiante']] = $a['estado'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_horario) {
    foreach ($estudiantes as $est) {
        $estado = $_POST['asistencia'][$est['id_usuario']] ?? 'ausente';
        $asistencia_controller->registrar($est['id_usuario'], $id_horario, $estado);
    }
    header("Location: marcar-asistencia.php?id_curso=$id_curso&id_horario=$id_horario&success=1");
    exit();
}
include_once __DIR__ . '../../../../../public/header.php';
?>

<div class="container mx-auto mt-10 p-4">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Control de Asistencia</h1>
                <p class="text-lg text-gray-600">Curso: <?= htmlspecialchars($curso_nombre) ?></p>
            </div>
            <a href="/modules/curso/views/admin/lista-curso.php" class="text-blue-600 hover:underline">Volver a Cursos</a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <p class="font-bold">Éxito</p>
                <p>Las asistencias se han guardado correctamente.</p>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
            <form method="POST" action="marcar-asistencia.php?id_curso=<?= $id_curso ?>&id_horario=<?= $id_horario ?>">
                <div class="mb-6">
                    <label for="horario-select" class="block text-lg font-semibold text-gray-700 mb-2">Seleccionar Fecha de Clase:</label>
                    <select id="horario-select" name="horario" class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" onchange="if(this.value) { location = '?id_curso=<?= $id_curso ?>&id_horario=' + this.value; }">
                        <option value="">-- Elige una fecha --</option>
                        <?php foreach ($horarios as $h): ?>
                            <option value="<?= $h['id_horario'] ?>" <?= $h['id_horario'] == $id_horario ? 'selected' : '' ?>>
                                <?= htmlspecialchars(ucfirst($h['dia'])) ?>, <?= htmlspecialchars(date("d/m/Y", strtotime($h['fecha']))) ?> a las <?= htmlspecialchars(date("g:i A", strtotime($h['hora']))) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($id_horario && !empty($estudiantes)): ?>
                    <div class="space-y-4">
                        <?php foreach ($estudiantes as $est): ?>
                            <?php $estado_actual = $asistencias_map[$est['id_usuario']] ?? 'ausente'; ?>
                            <div class="p-4 rounded-lg border border-gray-200 flex items-center justify-between">
                                <p class="text-lg font-medium text-gray-800"><?= htmlspecialchars($est['nombres'] . ' ' . $est['apellidos']) ?></p>
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center space-x-2 cursor-pointer p-2 rounded-lg <?= $estado_actual == 'presente' ? 'bg-green-100 text-green-800' : '' ?>">
                                        <input type="radio" name="asistencia[<?= $est['id_usuario'] ?>]" value="presente" class="form-radio text-green-500 h-5 w-5" <?= $estado_actual == 'presente' ? 'checked' : '' ?>>
                                        <span>Presente</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer p-2 rounded-lg <?= $estado_actual == 'ausente' ? 'bg-red-100 text-red-800' : '' ?>">
                                        <input type="radio" name="asistencia[<?= $est['id_usuario'] ?>]" value="ausente" class="form-radio text-red-500 h-5 w-5" <?= $estado_actual == 'ausente' ? 'checked' : '' ?>>
                                        <span>Ausente</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer p-2 rounded-lg <?= $estado_actual == 'justificado' ? 'bg-yellow-100 text-yellow-800' : '' ?>">
                                        <input type="radio" name="asistencia[<?= $est['id_usuario'] ?>]" value="justificado" class="form-radio text-yellow-500 h-5 w-5" <?= $estado_actual == 'justificado' ? 'checked' : '' ?>>
                                        <span>Justificado</span>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="mt-8 w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold text-lg shadow-md">Guardar Asistencias</button>
                <?php elseif ($id_horario): ?>
                    <div class="text-center text-gray-500 bg-gray-50 p-8 rounded-lg">
                        <p>No hay estudiantes inscritos en este curso todavía.</p>
                    </div>
                <?php else: ?>
                    <div class="text-center text-gray-500 bg-gray-50 p-8 rounded-lg">
                        <p>Por favor, selecciona una fecha para comenzar a pasar lista.</p>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '../../../../../public/footer.php'; ?>