opc<?php


require_once 'Modelo.php';
require_once 'Jugador.php';
require_once 'ResultadoPartido.php';
$bd = new Modelo();
if ($bd->getConexion() == null) {
    $mensaje = array('e', 'Error, no hay conexión con la bd');
} else {
    //Chequear el perfile del usuario
    session_start();
	

	if(isset($_SESSION['codigo']) && isset($_SESSION['jugador1']) && isset($_SESSION['jugador2'])){
		
	}else{
		header('location:index.php');
	}

	if(isset($_POST['cambiar'])){
		unset($_SESSION['codigo']);
        unset($_SESSION['jugador1']);
		unset($_SESSION['jugador2']);
        header('location:index.php');
	}

	
	
}
?>
<!doctype html>
<html>
      <head>
        <meta charset="utf-8">        
        <title>Recuperación T3 2</title>
       </head>
     <body>
     	<form action="" method="post">
         	<input type="submit" name="cambiar" value="Cambiar Partido"/><hr/>
    		<h1><?php echo $_SESSION['jugador1'].'-'.$_SESSION['jugador2'] ?></h1>
         	<h2 style="color:red;"><?php if(isset($mensaje)) echo $mensaje?></h2>
         	<hr/>
         	<!-- <h2 style="color:red;">mensaje si es necesario</h2> -->
         	<hr/>
    		<h2>Datos del Partido</h2>
    		<table width="50%">
    			<tr>
    				<td><b>Código</b></td>
    				<td><b>Jugador 1</b></td>
    				<td><b>Jugador 2</b></td>
    				<td><b>Fecha</b></td>
    				<td><b>Número de Sets</b></td>
    			</tr>
				<?php
				if(isset($_SESSION['partido'])){

					$datosPartido = $_SESSION['partido'];

					
					
					echo '<tr>';
					echo '<td><b>',$datosPartido->getCodigo(),'</b></td>';
					echo '<td><b>',$datosPartido->getJugador1(),'</b></td>';
					echo '<td><b>',$datosPartido->getJugador2(),'</b></td>';
					echo '<td><b>',$datosPartido->getFecha(),'</b></td>';
					echo '<td><b>',$datosPartido->getNumSets(),'</b></td>';
					echo '</tr>';

				}
				?>
    			
    		</table>
    		<hr/>
    		<h2>Estadísticas Jugadores</h2>
    		<table width="50%">
    			<tr>
    				<th align="left">Jugador</th>
    				<th align="left">Ganados</th>
    				<th align="left">Jugados</th>
    			</tr>
				<?php
				if(isset($_SESSION['jugador1']) && isset($_SESSION['jugador2']) ){

					$datosJ1 = $bd->obtenerJugador($_SESSION['jugador1']);
					$datosJ2 = $bd->obtenerJugador($_SESSION['jugador2']);
					
					$partidosJugados = $bd->obtenerJugados($_SESSION['jugador1'],$_SESSION['jugador2']);
					

					echo '<tr>';
					echo '<td  align="left">',$datosJ1->getNombre(),'</td>';
					echo '<td  align="left">',$datosJ1->getGanados(),'</td>';
					echo '<td  align="left">',$partidosJugados,'</td>';
					echo '</tr>';

					echo '<tr>';
					echo '<td  align="left">',$datosJ2->getNombre(),'</td>';
					echo '<td  align="left">',$datosJ2->getGanados(),'</td>';
					echo '<td  align="left">',$partidosJugados,'</td>';
					echo '</tr>';
				}


				?>
    		</table>
    		<hr/>
    		
    		<h2>Resultados del Partido</h2>		
        		<table width="50%">
    			<tr>
    				<th align="left">Set</th>
    				<th align="left">Juegos Jugador1</th>
    				<th align="left">Juegos Jugador2</th>
    				<th align="left">Acción</th>
    			</tr>
				<?php
				if(isset($_SESSION['partido'])){
					$resulP = $bd->obtenerResultadoPartido($_SESSION['codigo']);

					if(empty($resulP)){
						$mensaje = "No hay datos de ningun resultado de partidos";
						echo '<h2 style="color:red;">'.$mensaje.'</h2>';
					}else{
					
						foreach($resulP as $rP){
					echo '<tr>';
					echo '<td  align="left">'.$rP->getNumSet().'</td>';
					echo '<td  align="left">',$rP->getJuegosJ1(),'</td>';
					echo '<td  align="left">',$rP->getJuegosJ2(),'</td>';
					echo '</tr>';
						}
					}
					}
				

				?>
    			<tr>
    				<td><select name="set">
						<?php
						$nSet=6;
						for($i=0;$i<$nSet;$i++){
							echo '<option value"'.$i.'>'.$i.'</option>';
						}
						?>
    				</select></td>
    				<td><input type="number" name="juegosJ1"/></td>
    				<td><input type="number" name="juegosJ2"/></td>
    				<td><input type="submit" name="grabarSet" value="Guardar Set" style="<?= $grabarSetStyle ?>">/></td>
					<?php
					if(isset($_POST['grabarSet'])){
						if(isset($_POST['set'])!=0 && !empty($_POST['juegosJ1']) && !empty($_POST['juegosJ2'])){
								
						
								
								if ($bd->crearRP($_SESSION['codigo'],$_POST['set'],$_POST['juegosJ1'],$_POST['juegosJ2'])) {
									$mensaje = array('i', 'Vehículo Creado');
								} else {
									$mensaje = array('e', 'Se ha producido un error al crear el vehículo');
								}
							
						}
					}
					?>
    				
    			</tr>
    			<tr>
    				<td></td>
    				<td><input type="radio" name="ganador1" value="j1"/>Gana <?php echo $datosPartido->getJugador1()?></td>
    				<td><input type="radio" name="ganador2" value="j2"/>Gana <?php echo $datosPartido->getJugador2()?></td>
    				<td><input type="submit" name="finPartido" value="Finalizar" style="<?= $finPartidoStyle ?>"/></td>
					<?php
						if(isset($_POST['finPartido'])){
							
							if(isset($_POST['ganador1']) && isset($_POST['ganador2'])){
								$finalizado = true;

								$partidoFinalizado = $bd->modificarFinalizado($finalizado);

								if(isset($_POST['ganador1'])){
									$jug = $bd->obtenerJugador($_SESSION['jugador1']);
									$nombreJugador = $jug->getNombre();
									$partidosGanados = $jug->getGanados();
									$pG = $bd->modificarGanador($nombreJugador,$partidosGanados);
								}

								if(isset($_POST['ganador2'])){
									$jug2 = $bd->obtenerJugador($_SESSION['jugador2']);
									$nombreJugador2 = $jug2->getNombre();
									$partidosGanados2 = $jug2->getGanados();
									$pG2 = $bd->modificarGanador($nombreJugador2,$partidosGanados2);
								}
							}
							$grabarSetStyle = isset($_POST['grabarSet']) ? 'display: none;' : '';
   							$finPartidoStyle = isset($_POST['finPartido']) ? 'display: none;' : '';
						}else{
							$mensaje = array('e', 'Se ha producido un error al finalizar el partido');
						}
					?>
    			</tr>
    		</table>
		</form>
	</body>
</html>
