<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:24 AM
 */
class AREAS
{

    private $idArea;
    private $idBodega;
    private $nombreArea;
    private $descripcionArea;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataAreas;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataAreas = null;

        $this->idArea = null;
        $this->idBodega = null;
        $this->nombreArea = null;
        $this->descripcionArea = null;
    }

    public function nuevaArea($idBod,$nombre,$desc){

        $this->idBodega = $idBod;
        $this->nombreArea = $nombre;
        $this->descripcionArea = $desc;

        try{
            $this->stmQuery = "INSERT INTO Areas(idBodega,nombreArea,descripcionArea)
                               VALUES(:idBod,:nombreAr,:descAr)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idBod",$this->idBodega);
            $this->bind->bindParam(":nombreAr",$this->nombreArea);
            $this->bind->bindParam(":descAr",$this->descripcionArea);

            $this->dataArea =  $this->bind->execute();

            if($this->dataArea == true){

                return true;

            }else{

                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end nuevoEmpleado

    public function actualizarArea($idAr,$idBod,$nombre,$desc){

        $this->idArea = $idAr;
        $this->idBodega = $idBod;
        $this->nombreArea = $nombre;
        $this->descripcionArea = $desc;

        try{
            $this->stmQuery = "UPDATE Areas SET idBodega = :idBo,
                                               nombreArea = :nombreAr,
                                               descripcionArea = :descAr                   
                               WHERE idArea = :idAr";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idAr",$this->idArea);
            $this->bind->bindParam(":nombreAr",$this->nombreArea);
            $this->bind->bindParam(":descAr",$this->descripcionArea);

            $this->dataArea =  $this->bind->execute();

            if($this->dataArea == true){
                return true;
            }else{
                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end actualizarEmpleado

    public function eliminarArea($idAr){

        $this->idArea = $idAr;

        try{
            $this->stmQuery = "DELETE FROM Areas WHERE idArea = :idAr";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idAr",$this->idArea);

            $this->dataArea =  $this->bind->execute();

            if($this->dataArea == true){
                return true;
            }else{
                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end eliimarEmpleado

    public function consultarTodasArea()
    {
        try{

            $this->stmQuery = "SELECT * FROM Areas";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataAreas = $this->bind->fetchAll();

            return $this->dataAreas;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados


}//end Class Area
