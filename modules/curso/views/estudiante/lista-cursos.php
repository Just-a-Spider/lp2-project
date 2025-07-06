<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/CursoController.php';

$controlador = new CursoController();
$resultado = $controlador->listarDisponibles();
$cursos = $resultado['exito'] ? $resultado['data'] : [];
?>

<div class="container mx-auto mt-10 p-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Cursos Disponibles para Inscripción</h1>

    <?php if (empty($cursos)): ?>
        <div class="text-center text-gray-500 bg-white p-10 rounded-2xl shadow-md">
            <p class="text-xl">No hay cursos disponibles en este momento.</p>
            <p class="mt-2">Por favor, vuelve a consultar más tarde.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($cursos as $curso): ?>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out border border-gray-100 flex flex-col">
                    <div class="p-6 flex-grow">
                        <h2 class="text-2xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($curso['nombre_curso']) ?></h2>
                        
                        <div class="text-md text-gray-700 space-y-3 mb-6">
                            <p><span class="font-semibold text-gray-600">Duración:</span> <?= htmlspecialchars($curso['duracion']) ?> Semanas</p>
                            <p><span class="font-semibold text-gray-600">Aula:</span> Aula <?= htmlspecialchars($curso['id_aula']) ?></p>
                            <p class="text-2xl font-bold text-blue-600 mt-2">S/ <?= htmlspecialchars(number_format($curso['costo'], 2)) ?></p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4">
                        <a href="/modules/curso/views/estudiante/inscribirse.php?id_curso=<?= $curso['id_curso'] ?>" class="block w-full text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold text-lg">
                            Inscribirme Ahora
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
include_once __DIR__ . '../../../../../public/footer.php';
?>
