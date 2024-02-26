<?php
    require_once 'Partido.php';
    require_once 'ResultadoPartido.php';


    class Modelo{
        private $conexion;

    const URL = 'mysql:host=localhost;port=3306;dbname=tenis';
    const USUARIO = 'root';
    const PS = '';

    function __construct()
    {
        try {
            //Establecer conexión con la BD
            $this->conexion = new PDO(Modelo::URL, Modelo::USUARIO, Modelo::PS);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function obtenerPartidos()
    {
        $resultado = array();
        try {
            $datos = $this->conexion->query('select * from partido');
            while ($fila = $datos->fetch()) {
                $p = new Partido(
                    $fila[0],
                    $fila[1],
                    $fila[2],
                    $fila[3],
                    $fila[4],
                    $fila[5]
                );
                $resultado[] = $p;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    function obtenerPartido($codigo)
    {
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from partido 
            where codigo = ?');
            $params = array($codigo);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Partido(
                        $fila['codigo'],
                        $fila['jugador1'],
                        $fila['jugador2'],
                        $fila['fecha'],
                        $fila['numSets'],
                        $fila['finalizado']
                        
                    );
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    function obtenerJugador($nombre){

        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from jugador 
            where nombre = ?');
            $params = array($nombre);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Jugador(
                        $fila['nombre'],
                        $fila['ganados'],
                        
                        
                    );
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    function obtenerJugados($nombre1, $nombre2){

        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT count(*) as jugados from partido
            where finalizado=true and (jugador1 = ? or jugador2 = ?)');
            $params = array($nombre1, $nombre2);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado =$fila['jugados'];
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    function obtenerResultadoPartido($partido)
    {
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare('SELECT * from resultadopartido 
            where partido = ?
            ');
            $params = array($partido);
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    $rp = new ResultadoPartido(
                        $fila[0],
                        $fila[1],
                        $fila[2],
                        $fila[3]   
                    );
                    $resultado[] = $rp;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    function crearRP($codigo,$nSets,$juegosJ1,$juegosJ2)
    {
        $resultado = false;
        try {
            $consulta = $this->conexion->prepare('INSERT into resultadopartido 
            values(?,?,?,?)');
            $params = array($codigo,$nSets,$juegosJ1,$juegosJ2);
            if ($consulta->execute($params)) {
                if ($consulta->rowCount() == 1) {
                    $resultado = true;
                    
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    function modificarFinalizado($terminado)
    {
        try {
            $consulta = $this->conexion->prepare('update partido set finalizado=?');
            $params = array($terminado);
            if($consulta->execute($params)){
                if($consulta->rowCount()==1){
                    return true;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function modificarGanador($nombre,$ganados)
    {
        try {
            $consulta = $this->conexion->prepare('UPDATE jugador set ganados=(?+1) where nombre = ?');
            $params = array($nombre,$ganados);
            if($consulta->execute($params)){
                if($consulta->rowCount()==1){
                    return true;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }


    public function getConexion()
    {
        return $this->conexion;
    }

    public function setConexion($conexion)
    {
        $this->conexion = $conexion;

        return $this;
    }

    }

  
?>