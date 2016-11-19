<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:24 AM
 */
class BODEGA
{

    //private $idBodega;
    private $nombreBodega;
    private $telefonoBodega;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataBodega;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataBodega = null;

        $this->nombreBodega = null;
        $this->telefonoBodega = null;

    }

    public function nuevoBodega($nombreBodega,$telefonoBodega){

        try{
            $this->stmQuery = "INSERT INTO Bodega(nombreBodega,telefonoBodega)
                               VALUES(:nombreBod,:telefonoBod)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":nombreBod",$nombreBodega);
            $this->bind->bindParam(":telefonoBod",$telefonoBodega);

            $this->dataBodega =  $this->bind->execute();

            if($this->dataBodega == true){
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

    public function actualizarBodega($idBodega,$nombreBodega,$telefonoBodega){

        try{
            $this->stmQuery = "UPDATE Bodega SET  nombreBodega = :nombreBod,
                                                  telefonoBodega = :telefonoBod
                               WHERE idBodega = :idBod";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idBod",$idBodega);
            $this->bind->bindParam(":nombreBod",$nombreBodega);
            $this->bind->bindParam(":telefonoBod",$telefonoBodega);

            $this->dataBodega =  $this->bind->execute();

            if($this->dataBodega == true){
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

    public function eliminarBodega($idBodega){

        try{
            $this->stmQuery = "DELETE FROM Bodega WHERE idBodega = :idBodega";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":idBodega",$idBodega);

            $this->dataBodega =  $this->bind->execute();

            if($this->dataBodega == true){
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

    public function consultarTodasBodega()
    {
        try{

            $this->stmQuery = "SELECT * FROM Bodega";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataBodega = $this->bind->fetchAll();

            return $this->dataBodega;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados

}//end Class Bodega
