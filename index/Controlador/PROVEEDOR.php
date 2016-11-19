<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:13 AM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');


class PROVEEDOR
{
    private $idProveedor;
    private $idEstado;
    private $nitProveedor;
    private $nombreProveedor;
    private $direccionProveedor;
    private $emailProveedor;
    private $telefonoProveedor;
    private $descripcionProveedor;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataProveedor;


    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataProveedor = null;
    }

    public function nuevoProveedor($idEstado,$nitProveedor,$nombreProveedor,$direccionProveedor,$telefonoProveedor,$descripcionProveedor){

        try{
            $this->stmQuery = "INSERT INTO Proveedor(idEstado,nitProveedor,nombreProveedor,
                                                     direccionProveedor,telefonoProveedor,descripcionProveedor)
                               VALUES(:idEstado,:nitProv,:nombreProv,:direccionProv,:telefonoProv,:descripcionProv)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idEstado",$idEstado);
            $this->bind->bindParam(":nitProv",$nitProveedor);
            $this->bind->bindParam(":nombreProv",$nombreProveedor);
            $this->bind->bindParam(":direccionProv",$direccionProveedor);
            $this->bind->bindParam(":telefonoProv",$telefonoProveedor);
            $this->bind->bindParam(":descripcionProv",$descripcionProveedor);

            $this->dataProveedor =  $this->bind->execute();

            if($this->dataProveedor == true){
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

    public function actualizarProveedor($idProveedor,$idEstado,$nitProveedor,$nombreProveedor,$direccionProveedor,$telefonoProveedor,$descripcionProveedor){

        try{

            $this->stmQuery = "UPDATE Proveedor SET  idEstado = :idEstado,
                                                    nitProveedor = :nitProv,
                                                    nombreProveedor = :nombreProv,
                                                    direccionProveedor = :direccionProv,
                                                    telefonoProveedor = :telefonoProv,
                                                    descripcionProveedor = :descripcionProv
                               WHERE idProveedor = :idProv";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idProv",$idProveedor);
            $this->bind->bindParam(":idEstado",$idEstado);
            $this->bind->bindParam(":nitProv",$nitProveedor);
            $this->bind->bindParam(":nombreProv",$nombreProveedor);
            $this->bind->bindParam(":direccionPrvo",$direccionProveedor);
            $this->bind->bindParam(":telefonoProv",$telefonoProveedor);
            $this->bind->bindParam(":descripcionProv",$descripcionProveedor);


            $this->dataProveedor =  $this->bind->execute();

            if($this->dataProveedor == true){
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

    public function eliminarProveedor($idProveedor){

        try{
            $this->stmQuery = "DELETE FROM Proveedores WHERE idProveedor = :idProveedor";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idProveedor",$idProveedor);

            $this->dataProveedor =  $this->bind->execute();

            if($this->dataProveedor == true){
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

    public function consultarProveedor($idProveedor){

        try{

            $this->stmQuery = "SELECT * FROM Proveedores WHERE idProveedor = :idProveedor";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":idEmp",$idEmpleado);
            $this->bind->execute();

            $this->dataProveedor = $this->bind->fetchAll();

            return json_encode($this->dataProveedor);

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }

    public function consultarTodosEmpleado()
    {
        try{

            $this->stmQuery = "SELECT idProveedor,nombreEstado,nitProveedor,nombreProveedor,direccionProveedor,emailProveedor,telefonoProveedor,descripcionProveedor
                               FROM Proveedores as P, Estado as E 
                               WHERE P.idEstado = E.idEstado
                               ORDER BY nombreProveedor";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataProveedor = $this->bind->fetchAll();

            return $this->dataProveedor;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados

    public function buscarEmpleado($nombre){

    }// end buscarEmpleado
}//end Class Empleado
