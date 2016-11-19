<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:24 AM
 */
class CUENTA
{

    private $idCuenta;
    private $idTipoCuenta;
    private $descripcionCuenta;
    private $fechaAperturaCuenta;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataCuenta;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataCuenta = null;

        //$this->idCuenta = null;
        $this->idTipoCuenta = null;
        $this->descripcionCuenta = null;
        $this->fechaAperturaCuenta = null;
    }

    public function nuevaCuenta($idTipoCuenta,$descripcionCuenta,$fechaAperturaCuenta){

        try{
            $this->stmQuery = "INSERT INTO Cuenta(idTipoCuenta,descripcionCuenta,fechaAperturaCuenta)
                               VALUES(:idTipoCta,:descripcionCta,:fechaAperturaCta)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idTipoCta",$idTipoCuenta);
            $this->bind->bindParam(":idDescripcionCta",$descripcionCuenta);
            $this->bind->bindParam(":fechaAperturaCta",$fechaAperturaCuenta);

            $this->dataCuenta =  $this->bind->execute();

            if($this->dataCuenta == true){
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

    public function actualizarCuenta($idCuenta,$idTipoCuenta,$descripcionCuenta,$fechaAperturaCuenta){

        try{
            $this->stmQuery = "UPDATE Cuenta SET idTipoCuenta = :idTipoCta,
                                                    descripcionCuenta = :descripcionCta,
                                                    fechaAperturaCuenta = :fechaAperturaCta                   
                               WHERE idCuenta = :idCta";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idCta",$idCuenta);
            $this->bind->bindParam(":idTipoCta",$idTipoCuenta);
            $this->bind->bindParam(":descripcionCta",$descripcionCuenta);
            $this->bind->bindParam(":fechaAperturaCta",$fechaAperturaCuenta);


            $this->dataAlbergue =  $this->bind->execute();

            if($this->dataCuenta == true){
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

    public function eliminarCuenta($idCuenta){

        try{
            $this->stmQuery = "DELETE FROM Cuenta WHERE idCuenta = :idCta";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idCta",$idCuenta);

            $this->dataCuenta =  $this->bind->execute();

            if($this->dataCuenta == true){
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

    public function consultarTodasCuentas()
    {
        try{

            $this->stmQuery = "SELECT idCuenta,nombreTipoCuenta,descripionCuenta,fechaAperturaCuenta
                               FROM Cuenta as C, tipoCuenta as TC
                               WHERE C.idTipoCuenta = TC.idTipoCuenta";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataCuenta = $this->bind->fetchAll();

            return $this->dataCuenta;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados

    public function buscarCuenta($nombre){

    }// end buscarAlbergue
}//end Class Albergue
