<?php
require_once "../controllers/CursosControllers.php";
if(!empty($_POST)){
    $id = $_GET["id"];
}
else{
    $id = $_POST["id"];
}
$curs = new CursosController();
$cursos = $curs->buscar($id);
foreach($cursos as $curso){
    $id_curso = $curso["id_curso"];
    $nombre_curso = $curso["nombre_curso"];
    $duracion = $curso["duracion"];
    $estado = $curso["estado"];
    $costo = $curso["costo"];
    $id_aula = $curso["id_aula"];
}
?>
<h1>Editar Curso</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="id_curso" placeholder="id curso" value="<?=$id_curso?>"><br>
</form>