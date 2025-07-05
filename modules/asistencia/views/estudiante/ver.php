<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/AsistenciaController.php';
require_once __DIR__ . '../../../../curso/controllers/CursoController.php';

if (!isset($_SESSION['estudiante_id'])) {
    header('Location: /modules/usuario/views/estudiante-login.php');
    exit();
}

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

$asistencias_resultado = $asistencia_controller->obtenerAsistenciasDeEstudiantePorCurso($_SESSION['estudiante_id'], $id_curso);
$asistencias = $asistencias_resultado['exito'] ? $asistencias_resultado['data'] : [];

?>

<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center">Mi Asistencia en <?= htmlspecialchars($curso_info['data']['nombre_curso']) ?></h1>

    <?php if (empty($asistencias)): ?>
        <p class="text-center text-gray-500">No tienes asistencias registradas para este curso.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Fecha</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Hora</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Día</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($asistencias as $asistencia): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($asistencia['fecha']) ?></td>
                            <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($asistencia['hora']) ?></td>
                            <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($asistencia['dia']) ?></td>
                            <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($asistencia['estado']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
include_once __DIR__ . '../../../../../public/footer.php';
?>