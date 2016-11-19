<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:13 AM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');



class HISTORIAL_SOCIO_ECONOMICO
{
    private $idHistorial;
    private $idFamilia;
    private $descripcionHistorial;
    private $fechaHistorial;
    private $casaHistorial;
    private $materialCasaHistorial;
    private $trabajaHistorial;
    private $salarioHistorial;
    private $empresaHistorial;
    private $vehiculoHistorial;

    //crear una Clase que se llame parentesco

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataHistorial;


    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataHistorial = null;

         $this->idHistorial = null;
         $this->idFamilia = null;
         $this->descripcionHistorial = null;
         $this->fechaHistorial = null;
         $this->casaHistorial = null;
         $this->materialCasaHistorial = null;
         $this->trabajaHistorial = null;
         $this->salarioHistorial = null;
         $this->empresaHistorial = null;
         $this->vehiculoHistorial = null;
    }

    public function nuevoHistorialSocioEconomico($idFam,$descHis,$fechaHis,$casaHis,$materialCasa,
                                                 $trabajaHis,$salarioHis,$empresaHis,$vehiculoHis){

        $this->idFamilia = $idFam;
        $this->descripcionHistorial = $descHis;
        $this->fechaHistorial = $fechaHis;
        $this->casaHistorial = $casaHis;
        $this->materialCasaHistorial = $materialCasa;
        $this->trabajaHistorial = $trabajaHis;
        $this->salarioHistorial = $salarioHis;
        $this->empresaHistorial = $empresaHis;
        $this->vehiculoHistorial = $vehiculoHis;

        try{
            $this->stmQuery = "INSERT INTO HistorialSocioeconomico(idFamilia,descripionHistorial,fechaHistorial,
                                                                  casaHistorial,materialCasaHistorial,trabajaHistorial,
                                                                  salarioHistorial,empresaHistorial,vehiculoHistorial)
                               VALUES(:a,:b,:d,:e,:f,:g,:h,:i,:j)";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":a",$this->idFamilia);
            $this->bind->bindParam(":b",$this->descripcionHistorial);
            $this->bind->bindParam(":d",$this->fechaHistorial);
            $this->bind->bindParam(":e",$this->casaHistorial);
            $this->bind->bindParam(":f",$this->materialCasaHistorial);
            $this->bind->bindParam(":g",$this->trabajaHistorial);
            $this->bind->bindParam(":h",$this->salarioHistorial);
            $this->bind->bindParam(":i",$this->empresaHistorial);
            $this->bind->bindParam(":j",$this->vehiculoHistorial);

            $this->dataHistorial =  $this->bind->execute();

            if($this->dataHistorial == true){
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

    public function actualizarHistorialSocioEconomico($idHis,$idFam,$descHis,$fechaHis,$casaHis,$materialCasa,
                                                      $trabajaHis,$salarioHis,$empresaHis,$vehiculoHis){
        $this->idHistorial = $idHis;
        $this->idFamilia = $idFam;
        $this->descripcionHistorial = $descHis;
        $this->fechaHistorial = $fechaHis;
        $this->casaHistorial = $casaHis;
        $this->materialCasaHistorial = $materialCasa;
        $this->trabajaHistorial = $trabajaHis;
        $this->salarioHistorial = $salarioHis;
        $this->empresaHistorial = $empresaHis;
        $this->vehiculoHistorial = $vehiculoHis;

        try{
            $this->stmQuery = "UPDATE HistorialSocioeconomico SET idFamilia = :a,
                                                                  descripionHistorial = :b,
                                                                  fechaHistorial = :e,
                                                                  casaHistorial = :d,
                                                                  materialCasaHistorial = :f,
                                                                  trabajaHistorial = :g,
                                                                  salarioHistorial = :h,
                                                                  empresaHistorial = :i,
                                                                  vehiculoHistorial = :j
                               WHERE idHistorial = :idHistorial";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idFamilia",$this->idHistorial);
            $this->bind->bindParam(":a",$this->idAlbergue);
            $this->bind->bindParam(":b",$this->idEstado);
            $this->bind->bindParam(":d",$this->idPatrocinador);
            $this->bind->bindParam(":e",$this->idDesastre);
            $this->bind->bindParam(":f",$this->nombreFamilia);
            $this->bind->bindParam(":g",$this->direccionFamilia);
            $this->bind->bindParam(":h",$this->idDesastre);
            $this->bind->bindParam(":i",$this->nombreFamilia);
            $this->bind->bindParam(":j",$this->direccionFamilia);

            $this->dataHistorial =  $this->bind->execute();

            if($this->dataHistorial == true){
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

    public function eliminarHistorialSocioEconomico($idHis){

        $this->idHistorial = $idHis;

        try{
            $this->stmQuery = "DELETE FROM HistorialSocioeconomico WHERE idHistorial = :idHistorial";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idHistorial",$this->idHistorial);

            $this->dataHistorial =  $this->bind->execute();

            if($this->dataHistorial == true){
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

    public function consultarHistorialSocioEconomico($idHis){

        $this->idHistorial = $idHis;

        try{
            $this->stmQuery = "SELECT * FROM HistorialSocioeconomico WHERE idHistorial = :idHistorial";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":idHistorial",$this->idHistorial);
            $this->bind->execute();

            $this->dataHistorial = $this->bind->fetchAll();

            return json_encode($this->dataHistorial);

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }

    public function consultarTodosHistorialSocioEconomico()
    {
        try{

            $this->stmQuery = "SELECT idHistorial,fechaHistorial,nombreFamilia,descripionHistorial,casaHistorial,materialCasaHistorial,trabajaHistorial,salarioHistorial,empresaHistorial,vehiculoHistorial
                                  FROM HistorialSocioeconomico AS HS, Familia as F
                                WHERE HS.idFamilia = F.idFamilia";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataHistorial = $this->bind->fetchAll();

            return $this->dataHistorial;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodos

    public function buscarHistorialSocioEconomico($nombre){

        try{
            $this->stmQuery = "";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":nombre",$nombre);
            $this->bind->execute();

            $this->dataHistorial = $this->bind->fetchAll();

            return $this->dataHistorial;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }// end
}//end Class Historial socioeconomico
