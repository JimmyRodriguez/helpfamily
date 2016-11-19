<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:13 AM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/BASE_DE_DATOS.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Modelo/TABLAS.php');



class FAMILIA
{
    private $idFamilia;
    private $idAlbergue;
    private $idEstado;
    private $idPatrocinador;
    private $idDesastre;
    private $nombreFamilia;
    private $direccionFamilia;

    //crear una Clase que se llame parentesco

    private $conexion;
    private $pdoConexion;
    private $stmQuery;
    private $bind;
    private $dataFamilia;


    public function __construct()
    {
        $this->conexion = new BASE_DE_DATOS();
        $this->pdoConexion = null;
        $this->stmQuery = null;
        $this->bind = null;
        $this->dataFamilia = null;

       $this->idFamilia = null;
       $this->idAlbergue = null;
       $this->idEstado = null;
       $this->idPatrocinador = null;
       $this->idDesastre = null;
       $this->nombreFamilia = null;
       $this->direccionFamilia = null;
    }

    public function nuevaFamilia($idAlb,$idEst,$idPatr,$idDesas,$nombreFam,$direccFam){

        $this->idAlbergue = $idAlb;
        $this->idEstado = $idEst;
        $this->idPatrocinador = $idPatr;
        $this->idDesastre = $idDesas;
        $this->nombreFamilia = $nombreFam;
        $this->direccionFamilia = $direccFam;

        try{
            $this->stmQuery = "INSERT INTO Familia(idAlbergue,idEstado,idPatrocinador,idDesastre,nombreFamilia,direccionFamilia)
                               VALUES(:a,:b,:c,:d,:e,:f,:g,)";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":a",$this->idAlbergue);
            $this->bind->bindParam(":b",$this->idEstado);
            $this->bind->bindParam(":c",$this->idPatrocinador);
            $this->bind->bindParam(":d",$this->idDesastre);
            $this->bind->bindParam(":f",$this->nombreFamilia);
            $this->bind->bindParam(":g",$this->direccionFamilia);


            $this->dataFamilia =  $this->bind->execute();

            if($this->dataFamilia == true){
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

    public function actualizarFamilia($idFam,$idAlb,$idEst,$idPatr,$idDesas,$nombreFam,$direccFam){

        $this->idFamilia = $idFam;
        $this->idAlbergue = $idAlb;
        $this->idEstado = $idEst;
        $this->idPatrocinador = $idPatr;
        $this->idDesastre = $idDesas;
        $this->nombreFamilia = $nombreFam;
        $this->direccionFamilia = $direccFam;

        try{
            $this->stmQuery = "UPDATE Familia SET idAlbergue = :a,
                                                  idEstado = :b,
                                                  idPatrocinador = :e,
                                                  idDesastre = :d,
                                                  nombreFamilia = f,
                                                  direccionFamilia = g
                               WHERE idFamilia = :idFamilia";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idFamilia",$this->idFamilia);
            $this->bind->bindParam(":a",$this->idAlbergue);
            $this->bind->bindParam(":b",$this->idEstado);
            $this->bind->bindParam(":e",$this->idPatrocinador);
            $this->bind->bindParam(":d",$this->idDesastre);
            $this->bind->bindParam(":f",$this->nombreFamilia);
            $this->bind->bindParam(":g",$this->direccionFamilia);

            $this->dataFamilia =  $this->bind->execute();

            if($this->dataFamilia == true){
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

    public function eliminarFamilia($idFam){

        $this->idFamilia = $idFam;

        try{
            $this->stmQuery = "DELETE FROM familia WHERE idFamilia = :idFamilia";


            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);

            $this->bind->bindParam(":idFamilia",$idEmpleado);

            $this->dataFamilia =  $this->bind->execute();

            if($this->dataFamilia == true){
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

    public function consultarFamilia($idFam){

        $this->idFamilia = $idFam;

        try{
            $this->stmQuery = "SELECT * FROM Familia WHERE idFamilia = :idFamilia";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->bindParam(":idFamilia",$this->idFamilia);
            $this->bind->execute();

            $this->dataFamilia = $this->bind->fetchAll();

            return json_encode($this->dataFamilia);

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }

    }

    public function consultarTodosFamilia()
    {
        try{

            $this->stmQuery = "SELECT idFamilia,nombreFamilia,nombreEstado,nombreAlbergue,nombrePatrocinador,nombreTipoDesastre,direccionFamilia
                                FROM Familia as F, Estado as E, Albergue as A, Patrocinador as P, DesastreNatural as DN, TipoDesastre as TD
                                WHERE F.idEstado = E.idEstado
                                AND F.idAlbergue = A.idAlbergue
                                AND F.idPatrocinador = P.idPatrocinador
                                AND F.idDesastre = DN.idDesastre
                                AND DN.idTipoDesastre = TD.idTipoDesastre
                                ORDER BY nombreTipoDesastre";

            $this->pdoConexion = $this->conexion->conectarBaseDeDatos();
            $this->bind = $this->pdoConexion->prepare($this->stmQuery);
            $this->bind->execute();

            $this->dataFamilia = $this->bind->fetchAll();

            return $this->dataFamilia;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }//end consultarTodosLosEmpleados

    public function buscarFamilia($nombre){

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

            $this->dataFamilia = $this->bind->fetchAll();

            return $this->dataFamilia;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->pdoConexion = null;
        }
    }// end buscarEmpleado
}//end Class Empleado
