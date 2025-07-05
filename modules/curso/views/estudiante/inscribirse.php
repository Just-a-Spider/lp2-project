<?php
include_once __DIR__ . "../../../../../public/header.php";
require_once __DIR__ . "../../../../matricula/controllers/MatriculaController.php";
require_once __DIR__ . "../../../controllers/CursoController.php";

$id_curso = $_GET['id_curso'] ?? null;
if (!$id_curso) {
    echo "ID de curso no proporcionado.";
    exit();
}

$cursoCtrl = new CursoController();
$curso = $cursoCtrl->buscar($id_curso)['data'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $id_estudiante = $_SESSION['estudiante_id'] ?? null;
    if (!$id_estudiante) {
        header('Location: /modules/usuario/views/estudiante-login.php');
        exit();
    }

    // Aquí podrías validar los datos de la tarjeta si fuera un sistema real
    $card_number = $_POST['card_number'] ?? '';
    $expiry_date = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    $matriculaCtrl = new MatriculaController();
    $resultado = $matriculaCtrl->inscribir($id_estudiante, $id_curso, $curso['costo']);

    if ($resultado['exito']) {
        header('Location: /modules/matricula/views/estudiante/mis-cursos.php');
        exit();
    } else {
        $error = $resultado['mensaje'] ?? "Error al inscribirse en el curso.";
        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>
                <strong>Error:</strong> " . htmlspecialchars($error) . "
            </div>";
    }
}
?>

<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
    <h2 class="text-xl font-bold mb-6 text-center">Inscribirse en <?= htmlspecialchars($curso['nombre_curso']) ?></h2>
    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <p><strong>Duración:</strong> <?= htmlspecialchars($curso['duracion']) ?> semanas</p>
        <p><strong>Costo:</strong> S/ <?= htmlspecialchars($curso['costo']) ?></p>
        <p><strong>Aula:</strong> <?= htmlspecialchars($curso['id_aula']) ?></p>

        <h3 class="text-lg font-bold mt-6 mb-4">Detalles de Pago (Simulado)</h3>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Número de Tarjeta</label>
            <input type="text" name="card_number" required class="mt-1 block w-full border rounded px-3 py-2" placeholder="XXXX XXXX XXXX XXXX" pattern="[0-9]{16}" title="Número de tarjeta de 16 dígitos" />
        </div>
        <div class="mb-4 flex space-x-4">
            <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-700">Fecha de Vencimiento (MM/AA)</label>
                <input type="text" name="expiry_date" required class="mt-1 block w-full border rounded px-3 py-2" placeholder="MM/AA" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" title="Formato MM/AA" />
            </div>
            <div class="w-1/2">
                <label class="block text-sm font-medium text-gray-700">CVV</label>
                <input type="text" name="cvv" required class="mt-1 block w-full border rounded px-3 py-2" placeholder="XXX" pattern="[0-9]{3,4}" title="Código de seguridad de 3 o 4 dígitos" />
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 mt-6">Confirmar Inscripción</button>
    </form>
</div>

<?php
include_once __DIR__ . "../../../../../public/footer.php";
?>