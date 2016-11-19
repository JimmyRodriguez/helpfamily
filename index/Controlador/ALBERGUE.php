<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:24 AM
 */
class ALBERGUE
{

    private $idAlbergue;
    private $idTipoAlbergue;
    private $idEstado;
    private $nombreAlbergue;
    private $direccionAlbergue;
    private $telefonoAlbergue;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataAlbergue;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataAlbergue = null;

        $this->idAlbergue = null;
        $this->idTipoAlbergue = null;
        $this->idEstado = null;
        $this->nombreAlbergue = null;
        $this->direccionAlbergue = null;
        $this->telefonoAlbergue = null;
    }

    public function nuevoAlbergue($idTip,$idEst,$nombreAlb,$direccAlb,$telAlb){

        $this->idTipoAlbergue = $idTip;
        $this->idEstado = $idEst;
        $this->nombreAlbergue = $nombreAlb;
        $this->direccionAlbergue = $direccAlb;
        $this->telefonoAlbergue = $telAlb;

        try{
            $this->stmQuery = "INSERT INTO Albergue(idTipoAlbergue,idEstado,nombreAlbergue,
                                         direccionAlbergue,telefonoAlbergue)
                               VALUES(:idTipo,:idEstado,:nombreAlb,:direccionAlb,:telAlb)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idTipo",$this->idTipoAlbergue);
            $this->bind->bindParam(":idEstado",$this->idEstado);
            $this->bind->bindParam(":nombreAlb",$this->nombreAlbergue);
            $this->bind->bindParam(":direccionAlb",$this->direccionAlbergue);
            $this->bind->bindParam(":telAlb",$this->telefonoAlbergue);


            $this->dataAlbergue =  $this->bind->execute();

            if($this->dataAlbergue == true){

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

    public function actualizarAlbergue($idAlb,$idTip,$idEst,$nombreAlb,$direccAlb,$telAlb){

        $this->idAlbergue = $idAlb;
        $this->idTipoAlbergue = $idTip;
        $this->idEstado = $idEst;
        $this->nombreAlbergue = $nombreAlb;
        $this->direccionAlbergue = $direccAlb;
        $this->telefonoAlbergue = $telAlb;

        try{
            $this->stmQuery = "UPDATE Albergue SET  idTipoAlbergue = :idTipoAlb,
                                                    idEstado = :idEstado,
                                                    nombreAlbergue = :nombreAlb,
                                                    direccionAlbergue = :direccAlb,
                                                    telefonoAlbergue = :telAlb
                               WHERE idAlbergue = :idAlb";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idTipoAlb",$this->idTipoAlbergue);
            $this->bind->bindParam(":idEstado",$this->idEstado);
            $this->bind->bindParam(":nombreAlb",$this->nombreAlbergue);
            $this->bind->bindParam(":direccAlb",$this->direccAlbergue);
            $this->bind->bindParam(":telAlb",$this->telAlbergue);
            $this->bind->bindParam(":idAlb",$this->idAlbergue);

            $this->dataAlbergue =  $this->bind->execute();

            if($this->dataAlbergue == true){
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

    public function eliminarAlbergue($idAlb){

        $this->idAlbergue = $idAlb;

        try{
            $this->stmQuery = "DELETE FROM Albergue WHERE idEmpleado = :idAlbergue";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idAlbergue",$this->idAlbergue);

            $this->dataAlbergue =  $this->bind->execute();

            if($this->dataAlbergue == true){
                return true;
            }else{
                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end eliimarAlbergue

    public function consultarTodosAlbergue()
    {

        try{

            $this->stmQuery = "SELECT idAlbergue,nombreTipoAlbergue,nombreEstado,
                                      nombreAlbergue,direccionAlbergue,telefonoAlbergue
                               FROM Albergue as A, TipoAlbergue as TA, Estado as ES
                               WHERE A.idTipoAlbergue = TA.idTipoAlbergue
                               AND  A.idEstado = ES.idEstado";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataAlbergue = $this->bind->fetchAll();

            return $this->dataAlbergue;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosAlbergue

    public function buscarAlbergue($nombreAlb){

        $this->nombreAlbergue = $nombreAlb;


        try{
            $this->stmQuery = "SELECT idAlbergue,nombreTipoAlbergue,nombreEstado,
                                      nombreAlbergue,direccionAlbergue,telefonoAlbergue
                               FROM Albergue as A, TipoAlbergue as TA, Estado as ES
                                WHERE A.idTipoAlbergue = TA.idTipoAlbergue
                                AND  A.idEstado = ES.idEstado
                                AND A.nombreAlbergue  LIKE '%:nombre%'";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":nombre",$this->nombreAlbergue);
            $this->bind->execute();

            $this->dataAlbergue = $this->bind->fetchAll();

            return $this->dataAlbergue;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }// end buscarAlbergue
}//end Class Albergue
