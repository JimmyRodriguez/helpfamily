<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:13 AM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');



class tipoDesastre
{
    private $idTipoDesastre;
    private $nombreTipoDesastre;


    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataTipoDesastre;


    public function __construct()
    {
        $this->idTipoDesastre = null;
        $this->nombreTipoDesastre = null;

        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataTipoDesastre = null;
    }

    public function nuevoTipoDesastre($nombreTipDes){

        $this->nombreTipoDesastre = $nombreTipDes;


        try{
            $this->stmQuery = "INSERT INTO TipoDesastre(nombreTipoDesastre)
                               VALUES(:a)";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":a",$this->nombreTipoDesastre);

            $this->dataTipoDesastre =  $this->bind->execute();

            if($this->dataTipoDesastre == true){
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

    public function actualizarTipoDesastre($idTipoDes,$nombreTipDes){

        $this->idTipoDesastre = $idTipoDes;
        $this->nombreTipoDesastre = $nombreTipDes;


        try{
            $this->stmQuery = "UPDATE DesastreNatural SET nombreTipoDesastre = :a
                               WHERE idTipoDesastre = :idTipoDes";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idTipoDes",$this->idTipoDesastre);
            $this->bind->bindParam(":a",$this->nombreTipoDesastre);


            $this->dataTipoDesastre =  $this->bind->execute();

            if($this->dataTipoDesastre == true){
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

    public function eliminarTipoDesastre($idTipoDes){

        $this->idTipoDesastre = $idTipoDes;

        try{
            $this->stmQuery = "DELETE FROM TipoDesastre WHERE idTipoDesastre = :a";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":a",$this->idTipoDesastre);

            $this->dataTipoDesastre =  $this->bind->execute();

            if($this->dataTipoDesastre == true){
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

    public function consultarDesastre($idTipoDes){

        $this->idTipoDesastre = $idTipoDes;

        try{
            $this->stmQuery = "SELECT * FROM TipoDesastre WHERE idTipoDesastre = :a";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":a",$this->idTipoDesastre);
            $this->bind->execute();

            $this->dataTipoDesastre = $this->bind->fetchAll();

            return json_encode($this->dataTipoDesastre);

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }

    public function consultarTodosTiposDesastres()
    {
        try{

            $this->stmQuery = "SELECT * FROM TipoDesastre";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataTipoDesastre = $this->bind->fetchAll();

            return $this->dataTipoDesastre;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados

    public function buscarTiposDesastre($nombre){

        try{
            $this->stmQuery = "";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":nombre",$nombre);
            $this->bind->execute();

            $this->dataTipoDesastre = $this->bind->fetchAll();

            return $this->dataTipoDesastre;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }// end buscarEmpleado
}//end Class Empleado
