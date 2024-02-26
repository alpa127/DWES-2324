<?php

require_once 'skills.php';
require_once 'Modalidad.php';
require_once 'Alumno.php';

class Modelo{
    private $conexion;

const URL = 'mysql:host=localhost;port=3306;dbname=skills';
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

function obtenerModalidades()
    {
        $resultado = array();
        try {
            $datos = $this->conexion->query('SELECT * from modalidad');
            while ($fila = $datos->fetch()) {
                $m = new Modalidad(
                    $fila[0],
                    $fila[1]
                );
                $resultado[] = $m;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    function obtenerModalidad($idM)
    {
        $resultado = null;
        try {
          
            $consulta = $this->conexion->prepare('SELECT * from modalidad 
            where id = ?');
            $params = array($idM);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Modalidad(
                        $fila['id'],
                        $fila['modalidad']
                    );
                    
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }


    function obtenerAlumnos($idM)
    {
        
        $resultado = array();
        try {
            $consulta = $this->conexion->prepare('SELECT * from alumno where modalidad = ?');
             $params = array($idM);
            if($consulta->execute($params)){
            while ($fila = $consulta->fetch()) {
                $a = new Alumno(
                    $fila[0],
                    $fila[1],
                    $fila[2],
                    $fila[3],
                    $fila[4]
                );
                $resultado[] = $a;
            }
        }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    function obtenerAlumno($idA)
    {
        $resultado = null;
        try {
            $consulta = $this->conexion->prepare('SELECT * from alumno 
            where id = ?');
            $params = array($idA);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = new Alumno(
                        $fila['id'],
                        $fila['nombre'],
                        $fila['modalidad'],
                        $fila['puntuacion'],
                        $fila['finalizado']
                    );
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
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