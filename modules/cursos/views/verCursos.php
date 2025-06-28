<?php
require_once '../controllers/CursosControllers.php';
$curs = new CursosController();
$cursos = $curs->mostrar();
?>
<h1 class="mt-5">Cursos de la Academia E</h1>
<table class="table">
    <thead>
        <tr>
            <th>id</th>
            <th>Nomble del curso</th>
            <th>Duracion</th>
            <th>Estado</th>
            <th>Costo</th>
            <th>Id del aula</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($cursos as $curso){
        echo "<tr>
                <td>".$curso["id_curso"]."</td>
                <td>".$curso["nombre_curso"]."</td>
                <td>".$curso["duracion"]."</td>
                <td>".$curso["estado"]."</td>
                <td>".$curso["costo"]."</td>
                <td>".$curso["id_aula"]."</td>
            </tr>";

    }
    ?>
    </tbody>
</table>