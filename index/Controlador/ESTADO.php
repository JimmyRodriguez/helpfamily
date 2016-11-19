<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');

/**
 * Created by PhpStorm.
 * User: jimmysidneys
 * Date: 11/1/16
 * Time: 9:14 AM
 */

class ESTADO
{
    private $idEstado;
    private $nombreEstado;
    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataEmpleado;


    public function __construct()
    {

       $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataEmpleado = null;


    }

    public function nuevoEstado($nomEstado){
        try{

            $this->stmQuery = "insert into Estado(nombreEstado) values(:nombreEstado)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":nombreEstado",$nomEstado);
            $this->bind->execute();

            $this->dataEmpleado = $this->bind->fetchAll();

            return $this->dataEmpleado;

            //return $this->stmQuery;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }


    }

    public function actualizarEstado(){

    }

    public function eliminarEstado(){

    }

    public function consultarEstado(){

        try{

            $this->stmQuery = "select * from ".TABLAS::$Estado;

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataEmpleado = $this->bind->fetchAll();

            return $this->dataEmpleado;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }


}//fin de la clase
?>