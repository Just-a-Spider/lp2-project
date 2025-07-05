<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/CursoController.php';

$controlador = new CursoController();
$resultado = $controlador->listarDisponibles();
$cursos = $resultado['data'];
?>

<div class="max-w-4xl mx-auto mt-10 w-full">
    <h1 class="text-2xl font-bold mb-6 text-center">Cursos Disponibles</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Nombre</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Duración</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Costo</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Aula</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($cursos as $curso): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['id_curso']) ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['nombre_curso']) ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['duracion']) ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['estado']) ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['costo']) ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['id_aula']) ?></td>
                        <td class="py-3 px-4 text-sm">
                            <a href="/modules/curso/views/estudiante/inscribirse.php?id_curso=<?= $curso['id_curso'] ?>" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs">Inscribirse</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include_once __DIR__ . '../../../../../public/footer.php';
?>