<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/2/16
 * Time: 8:12 AM
 */
class SEXO
{
    private $idSexo;
    private $nombreSexo;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataSexo;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataSexo = null;
    }

    public function nuevoSexo(){

    }
    public function actualizar(){

    }

    public function eliminarSexo(){

    }
    public function consultarSexo(){

        try{

            $this->stmQuery = "select * from ".TABLAS::$Sexo;

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataSexo = $this->bind->fetchAll();

            return $this->dataSexo;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }


}