<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:24 AM
 */
class tipoPatrocinador
{

    private $idTipoPatrocinador;
    private $nombreTipoPatrocinador;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataTipoPatrocinador;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataTipoPatrocinador = null;
    }

    public function nuevoTipoPatrocinador(){



    }
    public function actualizarTipoPatrocinador(){

    }
    public function eliminarTipoPatrocinador(){

    }

    public function consultarTipoPatrocinador(){
        try{

            $this->stmQuery = "select * from ".TABLAS::$TipoPatrocinador;

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataTipoPatrocinador = $this->bind->fetchAll();

            return $this->dataTipoPatrocinador;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }

}