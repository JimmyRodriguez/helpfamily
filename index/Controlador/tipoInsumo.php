<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:24 AM
 */
class tipoInsumo
{

    private $idTipoInsumo;
    private $nombreTipoInsumo;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataTipoInsumo;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataStock = null;

        $this->idTipoInsumo = null;
        $this->nombreTipoInsumo = null;
    }

    public function nuevoTipoInsumo($nombreIns){

        $this->nombreTipoInsumo = $nombreIns;

        try{
            $this->stmQuery = "INSERT INTO TipoInsumo(nombreTipoInsumo)
                               VALUES(:nombreTipoInsumo)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":nombreTipoInsumo",$this->nombreTipoInsumo);

            $this->dataTipoInsumo =  $this->bind->execute();

            if($this->dataTipoInsumo == true){

                return true;

            }else{

                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end nuevoTipoInsumo

    public function actualizarTipoInsumo($idTipIns,$nombreIns){

        $this->idTipoInsumo = $idTipIns;
        $this->nombreTipoInsumo = $nombreIns;

        try{
            $this->stmQuery = "UPDATE TipoInsumo SET nombreTipoInsumo = :nombreTipoInsumo                                  
                               WHERE idTipoInsumo = :idTipoInsumo";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idTipoInsumo",$this->idTipoInsumo);
            $this->bind->bindParam(":nombreTipoInsumo",$this->nombreTipoInsumo);

            $this->dataTipoInsumo =  $this->bind->execute();

            if($this->dataTipoInsumo == true){
                return true;
            }else{
                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end actualizarTipoInsumo

    public function eliminarTipoInsumo($idTipIns){

        $this->idTipoInsumo = $idTipIns;

        try{
            $this->stmQuery = "DELETE FROM TipoInsumo WHERE idTipoInsumo = :idTipoInsumo";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idTipoInsumo",$this->idTipoInsumo);

            $this->dataTipoInsumo =  $this->bind->execute();

            if($this->dataTipoInsumo == true){
                return true;
            }else{
                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end eliimarTipoInsumo

    public function consultarTodosTipoInsumos()
    {
        try{

            $this->stmQuery = "SELECT * FROM TipoInsumo";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataTipoInsumo = $this->bind->fetchAll();

            return $this->dataTipoInsumo;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end consultarTipoInsumo


}//end Class Area
