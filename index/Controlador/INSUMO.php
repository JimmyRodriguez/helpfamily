<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:13 AM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');


class INSUMO
{
    private $idInsumo;
    private $idTipoInsumo;
    private $idEstado;
    private $idBodega;
    private $idArea;
    private $idStock;
    private $nombreInsumo;
    private $cantidadProductos;
    private $costoInsumo;
    private $descripcionInsumo;
    private $fechaVencimientoInsumo;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataInsumo;


    public function __construct()
    {
        //$this->idInsumo = null;
        $this->idTipoInsumo = null;
        $this->idEstado = null;
        $this->idBodega = null;
        $this->idArea = null;
        $this->idStock = null;
        $this->nombreInsumo = null;
        $this->cantidadProductos = null;
        $this->costoInsumo = null;
        $this->descripcionInsumo = null;
        $this->fechaVencimientoInsumo = null;

        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataInsumo = null;

    }

    public function nuevoInsumo($idTins,$idEst,$idBod,$idAr,$idSt,$nombreIns,$cantIns,$costIns,$desc,$fechaV){

        //$this->idInsumo = $idIns;
        $this->idTipoInsumo = $idTins;
        $this->idEstado = $idEst;
        $this->idBodega = $idBod;
        $this->idArea = $idAr;
        $this->idStock = $idSt;
        $this->nombreInsumo = $nombreIns;
        $this->cantidadProductos = $cantIns;
        $this->costoInsumo = $costIns;
        $this->descripcionInsumo = $desc;
        $this->fechaVencimientoInsumo = $fechaV;


        try{
            $this->stmQuery = "INSERT INTO Insumos(idTipoInsumo,idEstado,idBodega,idArea,nombreInsumo,cantidadProductos,
                                                   costoInsumo,descripcionInsumo,fechaVencimientoInsumo,idStock)
                               VALUES(:idTipoInsumo,:idEstado,:idBodega,:idArea,:nombreInsumo,:cantidadProd,:costoInsumo,
                                      :descInsumo,:fechaVencInsumo,idStock)";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idTipoInsumo",$this->idTipoInsumo);
            $this->bind->bindParam(":idEstado",$this->idEstado);
            $this->bind->bindParam(":idBodega",$this->idBodega);
            $this->bind->bindParam(":idArea",$this->idArea);
            $this->bind->bindParam(":nombreInsumo",$this->nombreInsumo);
            $this->bind->bindParam(":cantidadProd",$this->cantidadProductos);
            $this->bind->bindParam(":costoInsumo",$this->costoInsumo);
            $this->bind->bindParam(":descInsumo",$this->descripcionInsumo);
            $this->bind->bindParam(":fechaVencInsumo",$this->fechaVencimientoInsumo);
            $this->bind->bindParam(":idStock",$this->idStock);

            $this->dataInsumo =  $this->bind->execute();

            if($this->dataInsumo == true){
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

    public function actualizarInsumo($idIns,$idTins,$idEst,$idBod,$idAr,$idSt,$nombreIns,$cantIns,$costIns,$desc,$fechaV){

        $this->idInsumo = $idIns;
        $this->idTipoInsumo = $idTins;
        $this->idEstado = $idEst;
        $this->idBodega = $idBod;
        $this->idArea = $idAr;
        $this->idStock = $idSt;
        $this->nombreInsumo = $nombreIns;
        $this->cantidadProductos = $cantIns;
        $this->costoInsumo = $costIns;
        $this->descripcionInsumo = $desc;
        $this->fechaVencimientoInsumo = $fechaV;


        try{
            $this->stmQuery = "UPDATE Empleado SET idTipoInsumo = :idTipoInsumo,
                                                   idEstado = :idEstado,
                                                   idBodega = :idBodega,
                                                   idArea = :idArea,
                                                   nombreInsumo = :nombreInsumo,
                                                   cantidadProductos = :cantidadProd,
                                                   costoInsumo = :costoInsumo,
                                                   descripcionInsumo = :descInsumo,
                                                   fechaVencimientoInsumo = :descInsumo,
                                                   idStock = :idStock
                               WHERE idInsumo = :idInsumo";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idInsumo",$this->idInsumo);
            $this->bind->bindParam(":idTipoInsumo",$this->idTipoInsumo);
            $this->bind->bindParam(":idEstado",$this->idEstado);
            $this->bind->bindParam(":idBodega",$this->idBodega);
            $this->bind->bindParam(":idArea",$this->idArea);
            $this->bind->bindParam(":nombreInsumo",$this->nombreInsumo);
            $this->bind->bindParam(":cantidadProd",$this->cantidadProductos);
            $this->bind->bindParam(":costoInsumo",$this->costoInsumo);
            $this->bind->bindParam(":descInsumo",$this->descripcionInsumo);
            $this->bind->bindParam(":fechaVencInsumo",$this->fechaVencimientoInsumo);
            $this->bind->bindParam(":idStock",$this->idStock);

            $this->dataInsumo =  $this->bind->execute();

            if($this->dataInsumo == true){
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

    public function eliminarInsumo($idIns){

        try{
            $this->stmQuery = "DELETE FROM Empleado WHERE idEmpleado = :idEmpleado";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idEmpleado",$idEmpleado);

            $this->dataEmpleado =  $this->bind->execute();

            if($this->dataEmpleado == true){
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

    public function consultarInsumo($idEmpleado){

        try{
            $this->stmQuery = "SELECT * FROM Empleado WHERE idEmpleado = :idEmp";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":idEmp",$idEmpleado);
            $this->bind->execute();

            $this->dataEmpleado = $this->bind->fetchAll();

            return json_encode($this->dataEmpleado);

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }

    public function consultarTodosInsumo()
    {
        try{

            $this->stmQuery = "SELECT idInsumo,nombreEstado,nombreBodega,nombreArea,nombreInsumo,numeroStock,costoInsumo,
                                      cantidadProductos,descripcionInsumo,fechaVencimientoInsumo
                                FROM Insumos as I, Estado as E, Bodega as B, Areas as A, STOCK as S
                                WHERE I.idEstado = E.idEstado
                                AND I.idBodega = B.idBodega
                                AND I.idArea = A.idArea
                                AND I.idStock = S.idStock";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataInsumo = $this->bind->fetchAll();

            return $this->dataInsumo;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados

    public function buscarInsumo($nombre){

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
