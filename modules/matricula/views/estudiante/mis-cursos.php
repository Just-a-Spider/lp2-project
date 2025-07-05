<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/MatriculaController.php';

if (!isset($_SESSION['estudiante_id'])) {
    header('Location: /modules/usuario/views/estudiante-login.php');
    exit();
}

$controlador = new MatriculaController();
$resultado = $controlador->obtenerCursosInscritos($_SESSION['estudiante_id']);
$cursos_inscritos = $resultado['exito'] ? $resultado['data'] : [];

?>

<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center">Mis Cursos Inscritos</h1>
    <?php if (empty($cursos_inscritos)): ?>
        <p class="text-center text-gray-500">No estás inscrito en ningún curso.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Nombre del Curso</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Duración</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Fecha de Matrícula</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                    <?php foreach ($cursos_inscritos as $curso): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['nombre_curso']) ?></td>
                            <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['duracion']) ?> semanas</td>
                            <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['fecha_matricula']) ?></td>
                            <td class="py-3 px-4 text-sm">
                                <a href="/modules/asistencia/views/estudiante/ver.php?id_curso=<?= $curso['id_curso'] ?>" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-xs">Ver Asistencias</a>
                            </td>
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
