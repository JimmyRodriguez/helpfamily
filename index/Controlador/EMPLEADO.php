<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:13 AM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');



class EMPLEADO
{
    private $idEmpleado;
    private $idEstado;
    private $nombreEmpleado;
    private $dpiEmpleado;
    private $sexoEmpleado;
    private $telefonoEmpleado;
    private $emailEmpleado;
    private $direccionEmpleado;
    private $fechaNacEmpleado;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataEmpleado;


    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataEmpleado = null;
    }

    public function nuevoEmpleado($idEstado,$idSexo,$nombre,$dpi,$tel,$email,$direcc,$fechaNac){

        try{
            $this->stmQuery = "INSERT INTO Empleado(idEstado,idSexo,nombreEmpleado,
                                        dpiEmpleado,telefonoEmpleado,emailEmpleado,
                                        direccionEmpleado,fechaNacEmpleado)
                               VALUES(:idEstado,:idSexo,:nombreEmp,:dpiEmp,:telEmp,:emailEmp,:direccionEmp,:fechaNacEmp)";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idEstado",$idEstado);
            $this->bind->bindParam(":idSexo",$idSexo);
            $this->bind->bindParam(":nombreEmp",$nombre);
            $this->bind->bindParam(":dpiEmp",$dpi);
            $this->bind->bindParam(":telEmp",$tel);
            $this->bind->bindParam(":emailEmp",$email);
            $this->bind->bindParam(":direccionEmp",$direcc);
            $this->bind->bindParam(":fechaNacEmp",$fechaNac);

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

    }//end nuevoEmpleado

    public function actualizarEmpleado($idEmpleado,$idEstado,$idSexo,$nombreEmpleado,$dpiEmpleado,$telEmpleado,$emailEmpleado,$direccionEmpleado){

        try{
            $this->stmQuery = "UPDATE Empleado SET idEstado = :idEstado,
                                                    idSexo = :idSexo,
                                                    nombreEmpleado = :nombreEmp,
                                                    dpiEmpleado = :dpiEmp,
                                                    telefonoEmpleado = :telEmp,
                                                    emailEmpleado = :emailEmp,
                                                    direccionEmpleado = :direccionEmp
                               WHERE idEmpleado = :idEmp";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idEmp",$idEmpleado);
            $this->bind->bindParam(":idEstado",$idEstado);
            $this->bind->bindParam(":idSexo",$idSexo);
            $this->bind->bindParam(":nombreEmp",$nombreEmpleado);
            $this->bind->bindParam(":dpiEmp",$dpiEmpleado);
            $this->bind->bindParam(":telEmp",$telEmpleado);
            $this->bind->bindParam(":emailEmp",$emailEmpleado);
            $this->bind->bindParam(":direccionEmp",$direccionEmpleado);

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

    }//end actualizarEmpleado

    public function eliminarEmpleado($idEmpleado){

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
    
    public function consultarEmpleado($idEmpleado){

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

    public function consultarTodosEmpleado()
    {
        try{

            $this->stmQuery = "SELECT idEmpleado,nombreEstado,nombreSexo,
                                          nombreEmpleado,dpiEmpleado,telefonoEmpleado,
                                          emailEmpleado,direccionEmpleado,fechaNacEmpleado
                                   FROM Empleado as E, Estado as ES, Sexo as S
                                   WHERE E.idEstado = ES.idEstado
                                   AND E.idSexo = S.idSexo";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataEmpleado = $this->bind->fetchAll();

            return $this->dataEmpleado;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados

    public function buscarEmpleado($nombre){

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
