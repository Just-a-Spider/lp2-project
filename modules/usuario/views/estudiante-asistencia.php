<?php
require_once 'Conn.php'; // aquí usas tu conexión ya configurada ($pdo)

$usando_bd = true;

// Obtener horario del día
$fecha_clase = isset($_POST['fecha_clase']) ? $_POST['fecha_clase'] : date('Y-m-d');
$stmt = $pdo->prepare("SELECT * FROM horario WHERE fecha = ?");
$stmt->execute([$fecha_clase]);
$horario = $stmt->fetch();

if (!$horario) {
    die("<div style='background:#fff3cd;color:#856404;padding:20px;border-radius:5px;margin:20px;font-family:Arial;'>
    <h3>⚠️ No hay clases programadas para el $fecha_clase</h3>
    <p>Agrega un horario en la base de datos para continuar.</p></div>");
}

// Obtener estudiantes matriculados en el curso de este horario
$stmt = $pdo->prepare("
    SELECT u.id_usuario, u.nombres, u.apellidos
    FROM usuario u
    INNER JOIN matricula m ON m.id_estudiante = u.id_usuario
    WHERE m.id_curso = ?
");
$stmt->execute([$horario['id_curso']]);
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar asistencia
$mensaje = '';
if (isset($_POST['guardar_asistencia'])) {
    $asistencias = $_POST['asistencia'] ?? [];
    $stmt_del = $pdo->prepare("DELETE FROM asistencia WHERE id_horario = ?");
    $stmt_del->execute([$horario['id_horario']]);

    $stmt_ins = $pdo->prepare("INSERT INTO asistencia (id_estudiante, id_horario, estado) VALUES (?, ?, ?)");
    foreach ($estudiantes as $est) {
        $estado = $asistencias[$est['id_usuario']] ?? 'ausente';
        $stmt_ins->execute([$est['id_usuario'], $horario['id_horario'], $estado]);
    }

    $mensaje = "<div class='alert alert-success mt-3'><strong>✅ Asistencia guardada para el $fecha_clase</strong></div>";
}

// Consultar asistencias guardadas
$asistencias_guardadas = [];
$stmt = $pdo->prepare("SELECT id_estudiante, estado FROM asistencia WHERE id_horario = ?");
$stmt->execute([$horario['id_horario']]);
foreach ($stmt as $row) {
    $asistencias_guardadas[$row['id_estudiante']] = $row['estado'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 0 auto;
            max-width: 1200px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 20px;
        }
        .estudiante-row {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 8px;
            padding: 15px;
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .estudiante-row:hover {
            background: #f8f9fa;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transform: translateY(-3px);
            border-color: #667eea;
        }
        .checkbox-asistencia {
            transform: scale(1.8);
            margin-left: 15px;
            cursor: pointer;
        }
        .presente {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
            border-color: #28a745 !important;
            box-shadow: 0 4px 20px rgba(40, 167, 69, 0.3) !important;
        }
        .fecha-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .btn-custom {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: bold;
            transition: all 0.3s;
            border: none;
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        .status-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: bold;
            z-index: 1000;
        }
        .status-online {
            background: #28a745;
            color: white;
        }
        .status-offline {
            background: #ffc107;
            color: #212529;
        }
        .info-banner {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-light p-4">
<div class="container bg-white p-4 rounded shadow">
    <h2 class="mb-4">📅 Asistencia para el <?= htmlspecialchars($fecha_clase) ?></h2>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Fecha de Clase:</label>
            <input type="date" name="fecha_clase" value="<?= htmlspecialchars($fecha_clase) ?>" 
                   class="form-control" onchange="this.form.submit()">
        </div>

        <?php if ($mensaje) echo $mensaje; ?>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Estudiante</th>
                        <th>Presente</th>
                        <th>Ausente</th>
                        <th>Justificado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $est): 
                        $estado = $asistencias_guardadas[$est['id_usuario']] ?? 'ausente';
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($est['nombres']." ".$est['apellidos']) ?></td>
                        <td>
                            <input type="radio" name="asistencia[<?= $est['id_usuario'] ?>]" value="presente"
                                <?= $estado == 'presente' ? 'checked' : '' ?>>
                        </td>
                        <td>
                            <input type="radio" name="asistencia[<?= $est['id_usuario'] ?>]" value="ausente"
                                <?= $estado == 'ausente' ? 'checked' : '' ?>>
                        </td>
                        <td>
                            <input type="radio" name="asistencia[<?= $est['id_usuario'] ?>]" value="justificado"
                                <?= $estado == 'justificado' ? 'checked' : '' ?>>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button type="submit" name="guardar_asistencia" class="btn btn-success mt-3">
            <i class="fas fa-save"></i> Guardar Asistencia
        </button>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
        function toggleCheckbox(estudianteId) {
            const checkbox = document.querySelector(`input[name="asistencia[${estudianteId}]"]`);
            checkbox.checked = !checkbox.checked;
            togglePresente(estudianteId);
        }

        function togglePresente(estudianteId) {
            const checkbox = document.querySelector(`input[name="asistencia[${estudianteId}]"]`);
            const fila = document.getElementById(`estudiante-${estudianteId}`);
            
            if (checkbox.checked) {
                fila.classList.add('presente');
            } else {
                fila.classList.remove('presente');
            }
            
            actualizarContadores();
        }

        function marcarTodos(marcar) {
            const checkboxes = document.querySelectorAll('input[name^="asistencia"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = marcar;
                const estudianteId = checkbox.name.match(/\[(\d+)\]/)[1];
                togglePresente(estudianteId);
            });
        }

        function actualizarContadores() {
            const checkboxes = document.querySelectorAll('input[name^="asistencia"]');
            const presentes = Array.from(checkboxes).filter(cb => cb.checked).length;
            const total = checkboxes.length;
            const ausentes = total - presentes;

            document.getElementById('presentes').textContent = presentes;
            document.getElementById('ausentes').textContent = ausentes;
        }

        document.addEventListener('DOMContentLoaded', function() {
            actualizarContadores();
        });

        document.querySelectorAll('.estudiante-row').forEach(row => {
            row.addEventListener('mousedown', function() {
                this.style.transform = 'scale(0.98) translateY(-1px)';
            });
            
            row.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(-3px)';
            });
        });
    </script>
</body>
</html>
