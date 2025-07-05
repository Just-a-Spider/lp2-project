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

// Calcular estadísticas
$total_clases = count($asistencias);
$presente_count = 0;
$ausente_count = 0;
$justificado_count = 0;

if ($total_clases > 0) {
    foreach ($asistencias as $asistencia) {
        switch ($asistencia['estado']) {
            case 'presente':
                $presente_count++;
                break;
            case 'ausente':
                $ausente_count++;
                break;
            case 'justificado':
                $justificado_count++;
                break;
        }
    }
    $porcentaje_presente = round(($presente_count / $total_clases) * 100);
} else {
    $porcentaje_presente = 0;
}

function get_estado_styles($estado) {
    switch ($estado) {
        case 'presente':
            return ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>', 'bg' => 'bg-green-50', 'text' => 'text-green-800'];
        case 'ausente':
            return ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>', 'bg' => 'bg-red-50', 'text' => 'text-red-800'];
        case 'justificado':
            return ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>', 'bg' => 'bg-yellow-50', 'text' => 'text-yellow-800'];
        default:
            return ['icon' => '', 'bg' => 'bg-gray-50', 'text' => 'text-gray-800'];
    }
}
?>

<div class="container mx-auto mt-10 p-4">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Mi Historial de Asistencia</h1>
                <p class="text-lg text-gray-600">Curso: <?= htmlspecialchars($curso_info['data']['nombre_curso']) ?></p>
            </div>
            <a href="/modules/matricula/views/estudiante/mis-cursos.php" class="text-blue-600 hover:underline">Volver a Mis Cursos</a>
        </div>

        <?php if (empty($asistencias)): ?>
            <div class="text-center text-gray-500 bg-white p-10 rounded-2xl shadow-md">
                <p class="text-xl">Aún no hay registros de asistencia para este curso.</p>
            </div>
        <?php else: ?>
            <!-- Resumen de Asistencia -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Resumen General</h2>
                <div class="flex items-center">
                    <div class="w-2/3 pr-8">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-3xl font-bold text-green-600"><?= $presente_count ?></p>
                                <p class="text-sm text-gray-600">Presente</p>
                            </div>
                            <div>
                                <p class="text-3xl font-bold text-red-600"><?= $ausente_count ?></p>
                                <p class="text-sm text-gray-600">Ausente</p>
                            </div>
                            <div>
                                <p class="text-3xl font-bold text-yellow-600"><?= $justificado_count ?></p>
                                <p class="text-sm text-gray-600">Justificado</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/3 text-center">
                        <p class="text-4xl font-bold text-blue-600"><?= $porcentaje_presente ?>%</p>
                        <p class="text-md text-gray-600">Asistencia Total</p>
                    </div>
                </div>
            </div>

            <!-- Historial Detallado -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Historial de Clases</h2>
                <div class="space-y-3">
                    <?php foreach ($asistencias as $asistencia): ?>
                        <?php $styles = get_estado_styles($asistencia['estado']); ?>
                        <div class="p-4 rounded-lg flex items-center justify-between <?= $styles['bg'] ?>">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    <?= $styles['icon'] ?>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        <?= htmlspecialchars(ucfirst($asistencia['dia'])) ?>, <?= htmlspecialchars(date("d/m/Y", strtotime($asistencia['fecha']))) ?>
                                    </p>
                                    <p class="text-sm text-gray-600">Hora: <?= htmlspecialchars(date("g:i A", strtotime($asistencia['hora']))) ?></p>
                                </div>
                            </div>
                            <p class="font-bold text-lg <?= $styles['text'] ?>"><?= htmlspecialchars(ucfirst($asistencia['estado'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include_once __DIR__ . '../../../../../public/footer.php';
?>
