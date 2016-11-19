<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:13 AM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');



class DESASTRE_NATURAL
{
    private $idDesastre;
    private $idTipoDesastre;
    private $nombreDesastre;
    private $fechaDesastre;
    private $ubicacionDesastre;
    private $descricionDesastre;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataDesastre;


    public function __construct()
    {
        $this->idDesastre = null;
        $this->idTipoDesastre = null;
        $this->nombreDesastre = null;
        $this->fechaDesastre = null;
        $this->ubicacionDesastre = null;
        $this->descricionDesastre = null;

        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataDesastre = null;
    }

    public function nuevoDesastre($idTipoDes,$nombreDes,$fechaDes,$ubicacionDes,$descripcionDes){

        $this->idTipoDesastre = $idTipoDes;
        $this->nombreDesastre = $nombreDes;
        $this->fechaDesastre = $fechaDes;
        $this->ubicacionDesastre = $ubicacionDes;
        $this->descricionDesastre = $descripcionDes;

        try{
            $this->stmQuery = "INSERT INTO DesastreNatural(idTipoDesastre,nombreDesastre,fechaDesastre,
                                                            ubicacionDesastre,descripcionDesastre)
                               VALUES(:a,:b,:d,:e,:f)";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":a",$this->idTipoDesastre);
            $this->bind->bindParam(":b",$this->nombreDesastre);
            $this->bind->bindParam(":d",$this->fechaDesastre);
            $this->bind->bindParam(":e",$this->ubicacionDesastre);
            $this->bind->bindParam(":f",$this->descricionDesastre);


            $this->dataDesastre =  $this->bind->execute();

            if($this->dataDesastre == true){
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

    public function actualizarEmpleado($idDes,$idTipoDes,$nombreDes,$fechaDes,$ubicacionDes,$descripcionDes){

        $this->idDesastre = $idDes;
        $this->idTipoDesastre = $idTipoDes;
        $this->nombreDesastre = $nombreDes;
        $this->fechaDesastre = $fechaDes;
        $this->ubicacionDesastre = $ubicacionDes;
        $this->descricionDesastre = $descripcionDes;

        try{
            $this->stmQuery = "UPDATE DesastreNatural SET idTipoDesastre = :a,
                                                          nombreDesastre = :b,
                                                          fechaDesastre = :d,
                                                          ubicacionDesastre = :e,
                                                          descripcionDesastre = :f
                               WHERE idDesastre = :idDes";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idDes",$this->idDesastre);
            $this->bind->bindParam(":a",$this->idTipoDesastre);
            $this->bind->bindParam(":b",$this->nombreDesastre);
            $this->bind->bindParam(":d",$this->fechaDesastre);
            $this->bind->bindParam(":e",$this->ubicacionDesastre);
            $this->bind->bindParam(":f",$this->descricionDesastre);

            $this->dataDesastre =  $this->bind->execute();

            if($this->dataDesastre == true){
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

    public function eliminarDesastre($idDes){

        $this->idDesastre = $idDes;

        try{
            $this->stmQuery = "DELETE FROM DesastreNatural WHERE idDesastre = :idDes";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idDes",$this->idDesastre);

            $this->dataDesastre =  $this->bind->execute();

            if($this->dataDesastre == true){
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

    public function consultarDesastre($idDes){

        $this->idDesastre = $idDes;

        try{
            $this->stmQuery = "SELECT * FROM DesastreNatural WHERE idDesastre = :idDes";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":idDes",$this->idDesastre);
            $this->bind->execute();

            $this->dataDesastre = $this->bind->fetchAll();

            return json_encode($this->dataDesastre);

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }

    public function consultarTodosDesastres()
    {
        try{

            $this->stmQuery = "SELECT idDesastre,nombreTipoDesastre,fechaDesastre,ubicacionDesastre,descripionDesastre
                               FROM DesastreNatural as DN, TipoDesastre TD
                               WHERE DN.idTipoDesastre = TD.idTipoDesastre";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataDesastre = $this->bind->fetchAll();

            return $this->dataDesastre;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados

    public function buscarDesastre($nombre){

        try{
            $this->stmQuery = "SELECT idEmpleado,nombreEstado,nombreSexo,
                                       nombreEmpleado,dpiEmpleado,telefonoEmpleado,
                                       emailEmpleado,direccionEmpleado,fechaNacEmpleado
                               FROM Empleado as E, Estado as ES, Sexo as S
                               WHERE E.idEstado = ES.idEstado
                               AND E.idSexo = S.idSexo
                               AND E.nombreEmpleado LIKE '%:nombre%'";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":nombre",$nombre);
            $this->bind->execute();

            $this->dataEmpleado = $this->bind->fetchAll();

            return $this->dataEmpleado;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }// end buscarEmpleado
}//end Class Empleado
