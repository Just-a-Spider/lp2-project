<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . './../../controllers/MatriculaController.php';
require_once __DIR__ . './../../../curso/controllers/CursoController.php';

$matriculaControlador = new MatriculaController();
$cursoControlador = new CursoController();

$id_curso = $_GET['id_curso'] ?? null;

if (!$id_curso) {
    echo "<div class='text-center mt-10 text-red-600'>ID de curso no proporcionado.</div>";
    include_once __DIR__ . '../../../../../public/footer.php';
    exit();
}

$cursoInfo = $cursoControlador->buscar($id_curso);
$inscritosResult = $matriculaControlador->obtenerInscritosPorCurso($id_curso);

$cursoNombre = $cursoInfo['exito'] ? $cursoInfo['data']['nombre_curso'] : 'Curso no encontrado';
$inscritos = $inscritosResult['exito'] ? $inscritosResult['data'] : [];
$totalInscritos = count($inscritos);

?>

<div class="container mx-auto mt-10 p-4">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Estudiantes Inscritos</h1>
                <p class="text-lg text-gray-600">Curso: <span class="font-semibold"><?= htmlspecialchars($cursoNombre) ?></span></p>
            </div>
            <div class="mt-4 sm:mt-0">
                 <a href="/modules/curso/views/admin/lista-curso.php" class="inline-flex items-center gap-2 bg-white text-gray-700 px-4 py-2 rounded-full hover:bg-gray-100 transition-colors shadow-sm border">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Volver a Cursos
                </a>
            </div>
        </div>

        <?php if (empty($inscritos)): ?>
            <div class="text-center bg-white p-10 rounded-2xl shadow-md border">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">No hay inscritos</h2>
                <p class="text-gray-500">Aún no hay estudiantes matriculados en este curso.</p>
            </div>
        <?php else: ?>
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mb-8">
                 <h2 class="text-xl font-bold text-gray-800 mb-4">Total de Inscritos: <?= $totalInscritos ?></h2>
                 <div class="space-y-4">
                    <?php foreach ($inscritos as $estudiante): ?>
                        <div class="p-4 rounded-lg border border-gray-200 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-lg text-gray-800"><?= htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?></p>
                                    <p class="text-sm text-gray-600"><?= htmlspecialchars($estudiante['email']) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-700">Inscrito el:</p>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars(date('d/m/Y', strtotime($estudiante['fecha_matricula']))) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                 </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once __DIR__ . '../../../../../public/footer.php'; ?>