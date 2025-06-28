<?php

    if(!empty($POST["registro"])){

        if(empty($POST["nombre"]) or empty($POST["apellido"]) or empty($POST["email"]) or empty($POST["celular"]) or
         empty($POST["direccion"]) or empty($POST["dni"])){

            echo 'Uno de los campos esta  vacio';
         }else {

            $nombre=$_POST["nombre"];
            $apellido=$_POST["napellido"];
            $email=$_POST["email"];
            $celular=$_POST["celular"];
            $direccion=$_POST["direccion"];
            $dni=$_POST["dni"];

            $sql=$conexion->query("insert into estudiante(nombre,apellido,email,celular,direccion,dni)values('$nombre',
            '$apellido', '$email' , ' $celular' , '$direccion' , '$dni')");
            if($sql==1){

                echo 'Usuario registrado correctamente';
            }else{

                echo 'Error al registrar';
            }
         }

    }



?>