<?php
include_once __DIR__ . '../../../../../public/header.php';
require_once __DIR__ . '../../../controllers/CursoController.php';

$controlador = new CursoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'desactivar_curso') {
        $id_curso = $_POST['id_curso'] ?? null;
        if ($id_curso) {
            $resultado = $controlador->actualizarEstado($id_curso, 'inactivo');
            if ($resultado['exito']) {
                // Recargar la página para mostrar el estado actualizado
                header('Location: lista-curso.php');
                exit();
            } else {
                $error = $resultado['mensaje'] ?? 'Error al desactivar el curso.';
            }
        }
    }
    if (isset($_POST['action']) && $_POST['action'] === 'activar_curso') {
        $id_curso = $_POST['id_curso'] ?? null;
        if ($id_curso) {
            $resultado = $controlador->actualizarEstado($id_curso, 'activo');
            if ($resultado['exito']) {
                // Recargar la página para mostrar el estado actualizado
                header('Location: lista-curso.php');
                exit();
            } else {
                $error = $resultado['mensaje'] ?? 'Error al activar el curso.';
            }
        }
    }
}

$resultado = $controlador->listar();
$cursos = $resultado['data'];
?>

<div class="max-w-6xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center">Listado de Cursos</h1>
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
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($cursos as $curso): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['id_curso']) ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['nombre_curso']) ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['duracion']) ?> Semanas</td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['estado']) ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['costo']) ?> Soles</td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= htmlspecialchars($curso['id_aula']) ?></td>
                        <td class="py-3 px-4 text-sm">
                            <a href="/modules/asistencia/views/admin/marcar-asistencia.php?id_curso=<?= $curso['id_curso'] ?>" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-xs">Ver Asistencias</a>
                            <a href="/modules/curso/views/admin/editar-horario.php?id_curso=<?= $curso['id_curso'] ?>" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 ml-2 text-xs">Editar Horarios</a>
                            <?php if ($curso['estado'] === 'activo'): ?>
                                <form method="POST" action="" class="inline-block ml-2">
                                    <input type="hidden" name="action" value="desactivar_curso">
                                    <input type="hidden" name="id_curso" value="<?= $curso['id_curso'] ?>">
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">Desactivar Curso</button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="" class="inline-block ml-2">
                                    <input type="hidden" name="action" value="activar_curso">
                                    <input type="hidden" name="id_curso" value="<?= $curso['id_curso'] ?>">
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">Activar Curso</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once __DIR__ . '../../../../../public/footer.php'; ?>