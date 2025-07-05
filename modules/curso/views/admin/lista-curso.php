<?php
require_once __DIR__ . '../../../controllers/CursoController.php';

$controlador = new CursoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id_curso = $_POST['id_curso'] ?? null;

    if ($id_curso) {
        $nuevo_estado = ($action === 'desactivar_curso') ? 'inactivo' : 'activo';
        $resultado = $controlador->actualizarEstado($id_curso, $nuevo_estado);

        if ($resultado['exito']) {
            header('Location: lista-curso.php');
            exit();
        } else {
            $error = $resultado['mensaje'] ?? 'Error al cambiar el estado del curso.';
        }
    }
}

$resultado = $controlador->listar();
$cursos = $resultado['data'];
include_once __DIR__ . '../../../../../public/header.php';
?>

<div class="container mx-auto mt-10 p-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Cursos</h1>
        <a href="crear-curso.php" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-transform transform hover:scale-105 shadow-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Crear Nuevo Curso
        </a>
    </div>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <p class="font-bold">Error</p>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($cursos as $curso): ?>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out border border-gray-100">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($curso['nombre_curso']) ?></h2>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $curso['estado'] === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= htmlspecialchars(ucfirst($curso['estado'])) ?>
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4">ID: <?= htmlspecialchars($curso['id_curso']) ?></p>

                    <div class="text-sm text-gray-700 space-y-2 mb-6">
                        <p><span class="font-semibold">Duración:</span> <?= htmlspecialchars($curso['duracion']) ?> Semanas</p>
                        <p><span class="font-semibold">Costo:</span> S/ <?= htmlspecialchars(number_format($curso['costo'], 2)) ?></p>
                        <p><span class="font-semibold">Aula:</span> <?= htmlspecialchars($curso['id_aula']) ?></p>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <p class="text-sm font-semibold text-gray-600 mb-3 text-center">ACCIONES</p>
                        <div class="grid grid-cols-2 gap-2 text-center">
                            <a href="/modules/asistencia/views/admin/marcar-asistencia.php?id_curso=<?= $curso['id_curso'] ?>" class="text-sm bg-gray-100 text-gray-800 px-3 py-2 rounded-lg hover:bg-green-200 hover:text-green-900 transition-colors">Asistencia</a>
                            <a href="/modules/matricula/views/admin/ver-inscritos.php?id_curso=<?= $curso['id_curso'] ?>" class="text-sm bg-gray-100 text-gray-800 px-3 py-2 rounded-lg hover:bg-purple-200 hover:text-purple-900 transition-colors">Inscritos</a>
                            <a href="/modules/curso/views/admin/editar-horario.php?id_curso=<?= $curso['id_curso'] ?>" class="text-sm bg-gray-100 text-gray-800 px-3 py-2 rounded-lg hover:bg-blue-200 hover:text-blue-900 transition-colors">Horarios</a>
                            <a href="/modules/curso/views/admin/editar-curso.php?id=<?= $curso['id_curso'] ?>" class="text-sm bg-gray-100 text-gray-800 px-3 py-2 rounded-lg hover:bg-yellow-200 hover:text-yellow-900 transition-colors">Editar</a>
                            <form method="POST" action="" class="col-span-2">
                                <input type="hidden" name="id_curso" value="<?= $curso['id_curso'] ?>">
                                <?php if ($curso['estado'] === 'activo'): ?>
                                    <input type="hidden" name="action" value="desactivar_curso">
                                    <button type="submit" class="w-full bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">Desactivar</button>
                                <?php else: ?>
                                    <input type="hidden" name="action" value="activar_curso">
                                    <button type="submit" class="w-full bg-green-500 text-white px-3 py-2 rounded-lg hover:bg-green-600 transition-colors">Activar</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include_once __DIR__ . '../../../../../public/footer.php'; ?>