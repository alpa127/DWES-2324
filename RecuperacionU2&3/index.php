<?php


require_once 'Modelo.php';
$bd = new Modelo();
if ($bd->getConexion() == null) {
    $mensaje = array('e', 'Error, no hay conexión con la bd');
} else {
    //Chequear el perfile del usuario
    session_start();

	
	
	

	if(isset($_POST['resultados'])){
		$partido = $bd->obtenerPartido($_POST['partido']);
		$_SESSION['codigo']= $partido->getCodigo();
		$_SESSION['jugador1']= $partido->getJugador1();
		$_SESSION['jugador2']= $partido->getJugador2();
		$_SESSION['partido']= $partido;
		header('location:resultados.php');
	}
	
}
?>
<!doctype html>
<html>
      <head>
        <meta charset="utf-8">        
        <title>Recupearción T3 2</title>
       </head>
     <body>
		<h1>Selecciona Partido</h1>
		<form action="" method="post">
		
    		<select name="partido">
    			<?php
					
					$partidos = $bd->obtenerPartidos();
				
					 foreach($partidos as $n) {
                        echo '<option value="' . $n->getCodigo().'">' . $n->getJugador1(). '-'. $n->getJugador2().'</option>';
                    }
				?>
    		</select>
    		<input type="submit" value="Resultados" name="resultados">
		</form>
		
	</body>
</html>

