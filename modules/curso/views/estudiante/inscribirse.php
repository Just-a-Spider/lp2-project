<?php
require_once __DIR__ . "../../../../matricula/controllers/MatriculaController.php";
require_once __DIR__ . "../../../controllers/CursoController.php";

$id_curso = $_GET['id_curso'] ?? null;
if (!$id_curso) {
    echo "<div class='text-center mt-10 text-red-600'>ID de curso no proporcionado.</div>";
    include_once __DIR__ . "../../../../../public/footer.php";
    exit();
}

$cursoCtrl = new CursoController();
$cursoResult = $cursoCtrl->buscar($id_curso);

if (!$cursoResult['exito']) {
    echo "<div class='text-center mt-10 text-red-600'>Curso no encontrado.</div>";
    include_once __DIR__ . "../../../../../public/footer.php";
    exit();
}
$curso = $cursoResult['data'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $id_estudiante = $_SESSION['estudiante_id'] ?? null;
    if (!$id_estudiante) {
        header('Location: /modules/usuario/views/estudiante-login.php?redirect_url=' . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }

    $matriculaCtrl = new MatriculaController();
    $resultado = $matriculaCtrl->inscribir($id_estudiante, $id_curso, $curso['costo']);

    if ($resultado['exito']) {
        header('Location: /modules/matricula/views/estudiante/mis-cursos.php?success=1');
        exit();
    } else {
        $error = $resultado['mensaje'] ?? "Error al inscribirte en el curso.";
    }
}
include_once __DIR__ . "../../../../../public/header.php";
?>

<div class="container mx-auto mt-10 p-4">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Confirmar Inscripción</h1>
            <p class="text-lg text-gray-600">Estás a un paso de unirte al curso.</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <p class="font-bold">¡Oops! Hubo un problema</p>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Resumen del Curso -->
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex flex-col">
                <h2 class="text-2xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($curso['nombre_curso']) ?></h2>
                <div class="text-gray-700 space-y-3 flex-grow">
                    <p><span class="font-semibold">Duración:</span> <?= htmlspecialchars($curso['duracion']) ?> semanas</p>
                    <p><span class="font-semibold">Aula:</span> Aula <?= htmlspecialchars($curso['id_aula']) ?></p>
                </div>
                <div class="mt-6 border-t pt-4">
                    <p class="text-sm text-gray-600">Total a pagar:</p>
                    <p class="text-4xl font-bold text-blue-600">S/ <?= htmlspecialchars(number_format($curso['costo'], 2)) ?></p>
                </div>
            </div>

            <!-- Formulario de Pago Simulado -->
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Detalles de Pago (Simulado)</h3>
                <form method="POST">
                    <div class="space-y-4">
                        <div>
                            <label for="card_number" class="block text-sm font-medium text-gray-700">Número de Tarjeta</label>
                            <input type="text" id="card_number" name="card_number" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="4929 1234 5678 9101" pattern="[0-9]{16}" title="Número de tarjeta de 16 dígitos" value="4929123456789101">
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700">Vencimiento</label>
                                <input type="text" id="expiry_date" name="expiry_date" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="MM/AA" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" title="Formato MM/AA" value="12/25">
                            </div>
                            <div class="flex-1">
                                <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                <input type="text" id="cvv" name="cvv" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="123" pattern="[0-9]{3,4}" title="Código de seguridad de 3 o 4 dígitos" value="123">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-8 w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors duration-300 font-semibold text-lg shadow-md">Confirmar y Pagar</button>
                </form>
            </div>
        </div>
         <div class="text-center mt-8">
            <a href="/modules/curso/views/estudiante/lista-cursos.php" class="text-sm text-gray-600 hover:text-blue-600">o volver a la lista de cursos</a>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . "../../../../../public/footer.php";
?>
