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

<div class="container mx-auto mt-10 p-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Mis Cursos</h1>

        <?php if (empty($cursos_inscritos)): ?>
            <div class="text-center bg-white p-10 rounded-2xl shadow-md">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Aún no te has inscrito a ningún curso.</h2>
                <p class="text-gray-500 mb-6">Explora los cursos que tenemos disponibles y empieza a aprender hoy mismo.</p>
                <a href="/modules/curso/views/estudiante/lista-cursos.php" class="bg-blue-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition-transform transform hover:scale-105 shadow-lg">
                    Ver Cursos Disponibles
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($cursos_inscritos as $curso): ?>
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transform hover:-translate-y-1 transition-transform duration-300 ease-in-out">
                        <div class="p-6 md:flex md:items-center md:justify-between">
                            <div class="md:flex-grow">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($curso['nombre_curso']) ?></h2>
                                <div class="flex flex-wrap gap-x-6 gap-y-2 text-gray-600 text-sm mb-4 md:mb-0">
                                    <p><span class="font-semibold">Duración:</span> <?= htmlspecialchars($curso['duracion']) ?> semanas</p>
                                    <p><span class="font-semibold">Inscrito el:</span> <?= htmlspecialchars(date('d/m/Y', strtotime($curso['fecha_matricula']))) ?></p>
                                </div>
                            </div>
                            <div class="md:flex-shrink-0 mt-4 md:mt-0">
                                <a href="/modules/asistencia/views/estudiante/ver.php?id_curso=<?= $curso['id_curso'] ?>" class="block w-full md:w-auto text-center bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors duration-300 font-semibold shadow-md">
                                    Ver Mi Asistencia
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include_once __DIR__ . '../../../../../public/footer.php';
?>