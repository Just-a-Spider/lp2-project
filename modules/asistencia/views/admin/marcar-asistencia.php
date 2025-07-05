<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/AsistenciaController.php';

$id_curso = $_GET['id_curso'] ?? null;
$id_horario = $_GET['id_horario'] ?? null;
$controlador = new AsistenciaController();

if (!$id_curso) {
    echo "ID de curso no proporcionado.";
    exit();
}

$horarios_resultado = $controlador->obtenerHorariosPorCurso($id_curso);
$horarios = $horarios_resultado['exito'] ? $horarios_resultado['data'] : [];

if (!$id_horario && !empty($horarios)) {
    $id_horario = $horarios[0]['id_horario'];
}

$estudiantes_resultado = $controlador->obtenerEstudiantes($id_curso);
$estudiantes = $estudiantes_resultado['exito'] ? $estudiantes_resultado['data'] : [];

$asistencias_resultado = $id_horario ? $controlador->obtenerAsistenciasPorHorario($id_horario) : ['exito' => false];
$asistencias = $asistencias_resultado['exito'] ? $asistencias_resultado['data'] : [];

$asistencias_map = [];
foreach ($asistencias as $a) {
    $asistencias_map[$a['id_estudiante']] = $a['estado'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($estudiantes as $est) {
        $estado = $_POST['asistencia'][$est['id_usuario']] ?? 'ausente';
        $controlador->registrar($est['id_usuario'], $id_horario, $estado);
    }
    header("Location: marcar-asistencia.php?id_curso=$id_curso&id_horario=$id_horario");
    exit();
}
?>

<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center">Marcar Asistencia</h1>
    <form method="POST">
        <div class="mb-4">
            <label class="block mb-2">Seleccionar horario:</label>
            <select name="horario" onchange="location = '?id_curso=<?= $id_curso ?>&id_horario=' + this.value;">
                <?php foreach ($horarios as $h): ?>
                    <option value="<?= $h['id_horario'] ?>" <?= $h['id_horario'] == $id_horario ? 'selected' : '' ?>>
                        <?= htmlspecialchars($h['fecha']) ?> <?= htmlspecialchars($h['dia']) ?> <?= htmlspecialchars($h['hora']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Estudiante</th>
                    <th class="py-2 px-4 border-b">Presente</th>
                    <th class="py-2 px-4 border-b">Ausente</th>
                    <th class="py-2 px-4 border-b">Justificado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantes as $est): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?= htmlspecialchars($est['nombres'] . ' ' . $est['apellidos']) ?></td>
                        <?php
                        $estado = $asistencias_map[$est['id_usuario']] ?? 'ausente';
                        ?>
                        <td class="py-2 px-4 border-b text-center">
                            <input type="radio" name="asistencia[<?= $est['id_usuario'] ?>]" value="presente" <?= $estado == 'presente' ? 'checked' : '' ?>>
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            <input type="radio" name="asistencia[<?= $est['id_usuario'] ?>]" value="ausente" <?= $estado == 'ausente' ? 'checked' : '' ?>>
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            <input type="radio" name="asistencia[<?= $est['id_usuario'] ?>]" value="justificado" <?= $estado == 'justificado' ? 'checked' : '' ?>>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Guardar Asistencias</button>
    </form>
</div>
<?php include_once __DIR__ . '../../../../../public/footer.php';?>