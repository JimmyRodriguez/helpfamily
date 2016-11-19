<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/16/16
 * Time: 6:42 AM
 */
class DEPOSITO
{

    private $idDeposito;
    private $idPatrocinador;
    private $idCuenta;
    private $idEmpleado;
    private $noDeposito;
    private $montoDeposito;
    private $fechaDeposito;
    private $descripcionDeposito;

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataDeposito;

    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataDeposito = null;

        $this->idDeposito = null;
        $this->idPatrocinador = null;
        $this->idCuenta = null;
        $this->idEmpleado = null;
        $this->noDeposito = null;
        $this->montoDeposito = null;
        $this->fechaDeposito = null;
        $this->descripcionDeposito = null;

    }

    public function nuevoDeposito($idPat,$idCta,$idEmp,$noDep,$montoDep,$fechaDep,$descDep){

        $this->idPatrocinador = $idPat;
        $this->idCuenta = $idCta;
        $this->idEmpleado = $idEmp;
        $this->noDeposito = $noDep;
        $this->montoDeposito = $montoDep;
        $this->fechaDeposito = $fechaDep;
        $this->descripcionDeposito = $descDep;


        try{
            $this->stmQuery = "INSERT INTO Deposito(idPatrocinador,idCuenta,idEmpleado,
                                                    noDeposito,montoDeposito,fechaDeposito,descripcionDeposito)
                               VALUES(:idPatroc,:idCuenta,:idEmplead,:noDeposit,:montoDeposit,:fechaDeposit,:descDeposit)";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idPatroc",$this->idPatrocinador);
            $this->bind->bindParam(":idCuenta",$this->idCuenta);
            $this->bind->bindParam(":idEmplead",$this->idEmpleado);
            $this->bind->bindParam(":noDeposit",$this->noDeposito);
            $this->bind->bindParam(":montoDeposit",$this->montoDeposito);
            $this->bind->bindParam(":fechaDeposit",$this->fechaDeposito);
            $this->bind->bindParam(":descDeposit",$this->descripcionDeposito);


            $this->dataDeposito =  $this->bind->execute();

            if($this->dataDeposito == true){

                return true;

            }else{

                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end nuevoDeposito

    public function actualizarDeposito($idDep,$idPat,$idCta,$idEmp,$noDep,$montoDep,$fechaDep,$descDep){

        $this->idDeposito = $idDep;
        $this->idPatrocinador = $idPat;
        $this->idCuenta = $idCta;
        $this->idEmpleado = $idEmp;
        $this->noDeposito = $noDep;
        $this->montoDeposito = $montoDep;
        $this->fechaDeposito = $fechaDep;
        $this->descripcionDeposito = $descDep;

        try{
            $this->stmQuery = "UPDATE Deposito SET  idPatrocinador = :idPatroc,
                                                    idCuenta = :idCuent,
                                                    idEmpleado = :idEmplead,
                                                    noDeposito = :noDepos,
                                                    montoDeposito = :montoDepos,
                                                    fechaDeposito = :fechaDepos,
                                                    descripcionDeposito = :descripcionDepos
                               WHERE idDeposito = :idDepos";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idDepos",$this->idDeposito);
            $this->bind->bindParam(":idPatroc",$this->idPatrocinador);
            $this->bind->bindParam(":idCuent",$this->idCuenta);
            $this->bind->bindParam(":idEmplead",$this->idEmpleado);
            $this->bind->bindParam(":noDepos",$this->noDeposito);
            $this->bind->bindParam(":montoDespos",$this->montoDeposito);
            $this->bind->bindParam(":fechaDepos",$this->fechaDeposito);
            $this->bind->bindParam(":descripcionDespos",$this->descripcionDeposito);

            $this->dataDeposito =  $this->bind->execute();

            if($this->dataDeposito == true){
                return true;
            }else{
                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end actualizarDeposito

    public function eliminarDesposito($idDep){

        $this->idDeposito = $idDep;

        try{

            $this->stmQuery = "DELETE FROM Deposito WHERE idDeposito = :idDeposit";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idDeposit",$this->idDeposito);

            $this->dataDeposito =  $this->bind->execute();

            if($this->dataDeposito == true){
                return true;
            }else{
                return false;
            }

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }//end eliimarDeposito

    public function consultarTodosLosDepositos()
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
    }//end consultarTodosLosDesposito

    public function buscarDesposito($nombreAlb){

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
    }// end buscarDeposito

}