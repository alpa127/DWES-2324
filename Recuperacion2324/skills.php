<?php

require_once 'Modelo.php';
require_once 'Modalidad.php';
require_once 'Alumno.php';
$bd = new Modelo();
$mensaje='';
$mostrarModalidad = true;
$mostrarAlumno = false;
$mostrarCorreccion= false;
$mostrarCalificaciones=false;
if ($bd->getConexion() == null) {
    $mensaje = array('e', 'Error, no hay conexión con la bd');
} else {
    //Chequear el perfile del usuario
    session_start();

	if(isset($_POST['selModalidad'])){
		$modalidad = $bd->obtenerModalidad($_POST['modalidad']);
        
		
       if($modalidad != null){
        $_SESSION['modalidad']= $modalidad;
        $mostrarModalidad=false;
        $mostrarAlumno=true;
        $mostrarCorreccion=true;
        $mostrarCalificaciones=true;
       }else{
        $mensaje = 'Error opcion no valida';
       }
        
       
	}elseif(isset($_POST['selAlumno'])){
        $alumno = $bd->obtenerAlumno($_POST['alumno']);
        
        if($alumno != null){
		$_SESSION['alumno']= $alumno;
        $mostrarModalidad =false;
        $mostrarAlumno=false;
        $mostrarCorreccion=true;
        $mostrarCalificaciones=true;
        }else{
            $mensaje = 'Error opcion no valida';
        }
        
    }elseif(isset($_POST['cambiarA'])){
        
        unset($_SESSION['alumno']);
        session_destroy();

    }elseif(isset($_POST['cambiarM'])){
        
        unset($_SESSION['alumno']);
        unset($_SESSION['modalidad']);
        session_destroy();
        header('location:skills.php');
    }
	
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <h1 style='color:red;'><?php echo $mensaje?></h1>
    </div>
    <form action="skills.php" method="post">
        <div <?php if (!$mostrarModalidad) echo 'style="display:none;"'; ?>>
            <h1 style='color:blue;'>Modalidad</h1>
            <label for="tienda">Modalidad</label><br />

            <select name="modalidad">
                <?php
                    $modalidades = $bd->obtenerModalidades();

                    foreach($modalidades as $mod){
                        echo '<option value="'.$mod->getId().'">'.$mod->getModalidad().'</option>';
                    }
                ?>

            </select>
            <button type="submit" name="selModalidad">Seleccionar Modalidad</button>
        </div>

        <div <?php if (!$mostrarAlumno) echo 'style="display:none;"'; ?>>
            <h1 style='color:blue;'>Alumno</h1>
            <label for="tienda">Alumno</label><br />
            <select name="alumno">
                <?php
                    $idMod = $modalidad->getId();

                    $alumnos = $bd->obtenerAlumnos($idMod);

                    foreach($alumnos as $alum){
                        echo '<option value="'.$alum->getId().'">'.$alum->getNombre().'</option>';
                    }
                ?>

            </select>
            <button type="submit" name="selAlumno">Seleccionar Alumno</button>
        </div>

        <div <?php if (!$mostrarCorreccion) echo 'style="display:none;"'; ?>>
            <h1 style='color:blue;'>Corrección</h1>
            <h2 style='color:green;'>Modalidad Seleccionada - Nombre Alumno - Nota:X (Provisional)
                <button type="submit" name="cambiarM">Cambiar Modalidad</button>
                <button type="submit" name="cambiarA">Cambiar Alumno</button>
            </h2>
            <table>
                <tr>
                    <td><label for="prueba">Prueba</label><br /></td>
                    <td><label for="puntos">Puntos</label><br /></td>
                    <td><label for="comentario">Comentario</label></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <select id="prueba" name="prueba">

                        </select>
                    </td>
                    <td><input id="puntos" type="number" name="puntos" value="1" /></td>
                    <td><input id="comentario" type="text" name="comentario" placeholder="Comentario" /></td>
                    <td><button type="submit" name="guardar">Guardar</button></td>
                </tr>
            </table>
        </div>
        <div <?php if (!$mostrarCalificaciones) echo 'style="display:none;"'; ?>>
            <h1 style='color:blue;'>Calificaciones del alumno</h1>
            <table border="1" rules="all" width="50%">
                <tr>
                    <td><b>Prueba</b></td>
                    <td><b>Puntos Asignados</b></td>
                    <td><b>Puntos Obtenidos</b></td>
                    <td><b>Comentario</b></td>
                </tr>

            </table>
            <button type="submit" name="finalizar">Finalizar Corrección</button>
        </div>
    </form>
</body>

</html>