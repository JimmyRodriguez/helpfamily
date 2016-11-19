<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:24 AM
 */
class STOCK
{

    private $idStock;
    private $idArea;
    private $numeroStock;
    private $descripcionStock;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataStock;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataStock = null;

        $this->idStock = null;
        $this->idArea = null;
        $this->numeroStock = null;
        $this->descripcionStock = null;
    }

    public function nuevoStock($idAr,$nombreSt,$descSt){

        $this->idArea = $idAr;
        $this->nombreStock = $nombreSt;
        $this->descripcionStock = $descSt;

        try{
            $this->stmQuery = "INSERT INTO STOCK(idArea,numeroStock,descripcionStock)
                               VALUES(:idArea,:nombreStock,:descStock)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idArea",$this->idArea);
            $this->bind->bindParam(":nombreStock",$this->nombreStock);
            $this->bind->bindParam(":descStock",$this->descripcionStock);

            $this->dataStock =  $this->bind->execute();

            if($this->dataStock == true){

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

    public function actualizarStock($idSt,$idAr,$nombreSt,$descSt){

        $this->idStock = $idSt;
        $this->idArea = $idAr;
        $this->numeroStock = $nombreSt;
        $this->descripcionStock = $descSt;


        try{
            $this->stmQuery = "UPDATE STOCK SET idArea = :idArea,
                                                numeroStock = :numeroStock,
                                                descripcionStock = :descStock                   
                               WHERE idStock = :idStock";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idStock",$this->idStock);
            $this->bind->bindParam(":idArea",$this->idArea);
            $this->bind->bindParam(":numeroStock",$this->numeroStock);
            $this->bind->bindParam(":descStock",$this->descripcionStock);

            $this->dataStock =  $this->bind->execute();

            if($this->dataStock == true){
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

    public function eliminarStock($idSt){

        $this->idStock = $idSt;

        try{
            $this->stmQuery = "DELETE FROM STOCK WHERE idStock = :idStock";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idStock",$this->idStock);

            $this->dataStock =  $this->bind->execute();

            if($this->dataStock == true){
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

    public function consultarTodosStock()
    {
        try{

            $this->stmQuery = "SELECT * FROM STOCK";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataStock = $this->bind->fetchAll();

            return $this->dataStock;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end consultarTodosLosEmpleados


}//end Class Area
