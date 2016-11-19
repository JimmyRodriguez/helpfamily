<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:24 AM
 */
class PAGOS
{
    private $idPago;
    private $idProveedor;
    private $idEmpleado;
    private $idCompra;
    private $idCuenta;
    private $noChequePago;
    private $montoPago;
    private $fechaPago;
    private $descripcionPago;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataPago;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataPago = null;

        $this->idPago = null;
        $this->idProveedor = null;
        $this->idEmpleado = null;
        $this->idCompra = null;
        $this->idCuenta = null;
        $this->noChequePago = null;
        $this->montoPago = null;
        $this->fechaPago = null;
        $this->descripcionPago = null;
    }

    public function nuevoPago($idProveedor,$idEmpleado,$idCompra,$idCuenta,$noChequePago,$montoPago,$descripcionPago){

        try{
            $this->stmQuery = "INSERT INTO Pagos(idProveedor,idEmpleado,idCompra,
                                                 idCuenta,noChequePago,montoPago,descripcionPago)
                               VALUES(:idProvee,:idEmp,:idCpra,:idCta,:noChequePa,:montoPa,:descripcionPa)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idProvee",$idProveedor);
            $this->bind->bindParam(":idEmp",$idEmpleado);
            $this->bind->bindParam(":idCpra",$idCompra);
            $this->bind->bindParam(":idCta",$idCuenta);
            $this->bind->bindParam(":noChequePa",$noChequePago);
            $this->bind->bindParam(":montoPa",$montoPago);
            $this->bind->bindParam(":descripcionPa",$descripcionPago);


            $this->dataPago =  $this->bind->execute();

            if($this->dataPago == true){
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

    public function actualizarPago($idPago,$idProveedor,$idEmpleado,$idCompra,$idCuenta,$noChequePago,$montoPago,$descripcionPago){

        try{
            $this->stmQuery = "UPDATE Albergue SET  idProveedor = :idProvee,
                                                    idEmpleado = :idEmp,
                                                    idCompra = :idCpra,
                                                    idCuenta = :idCta,
                                                    noChequePago = :noChequePa,
                                                    montoPago = :montoPa,
                                                    descripcionPago = :descripcionPa
                               WHERE idPago = :idPa";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idPa",$idPago);
            $this->bind->bindParam(":idProvee",$idProveedor);
            $this->bind->bindParam(":idEmp",$idEmpleado);
            $this->bind->bindParam(":idCpra",$idCompra);
            $this->bind->bindParam(":idCta",$idCuenta);
            $this->bind->bindParam(":noChequePa",$noChequePago);
            $this->bind->bindParam(":montoPa",$montoPago);
            $this->bind->bindParam(":descripcionPa",$descripcionPago);

            $this->dataPago =  $this->bind->execute();

            if($this->dataPago == true){
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

    public function eliminarPago($idPago){

        try{
            $this->stmQuery = "DELETE FROM Pago WHERE idPago = :idPago";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idPago",$idPago);

            $this->dataPago =  $this->bind->execute();

            if($this->dataPago == true){
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

    public function consultarTodosPago()
    {
        try{

            $this->stmQuery = "SELECT nombreProveedor, nombreEmpleado, descripcionCompra, descripionCuenta, noChequePago, montoPago, fechaPago, descripcionPago
                               FROM Pagos as P, Proveedores as PR, Empleado as E, Compras as C, Cuenta as CU
                               WHERE P.idProveedor = PR.idProveedor
                               AND P.idEmpleado = E.idEmpleado
                               AND P.idCompra = C.idCompra
                               AND P.idCuenta = CU.idCuenta;";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataPago = $this->bind->fetchAll();

            return $this->dataPago;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados

    public function buscarPago($noChequePago){

        try{
            $this->stmQuery = "SELECT nombreProveedor, nombreEmpleado, descripcionCompra, descripionCuenta, noChequePago, montoPago, fechaPago, descripcionPago
                               FROM Pagos as P, Proveedores as PR, Empleado as E, Compras as C, Cuenta as CU
                               WHERE P.idProveedor = PR.idProveedor
                               AND P.idEmpleado = E.idEmpleado
                               AND P.idCompra = C.idCompra
                               AND P.idCuenta = CU.idCuenta
                               AND P.noChequePago LIKE '%:noCheque%'";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":noCheque",$noChequePago);
            $this->bind->execute();

            $this->dataPago = $this->bind->fetchAll();

            return $this->dataPago;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }// end buscarPago
}//end Class Pago
