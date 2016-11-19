<?php

/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 9:26 AM
 */

class BASE_DE_DATOS
{

    private $DB_HOSTNAME = null;
    private $DB_DATABASE = null;
    private $DB_USER = null;
    private $DB_PASSWORD = null;

    private $conexion;


    public function __construct() //el constructor se inicializa de manera automatica cada vez que yo instacie la clase y cree un objeto de dicha clase
    {

        $this->DB_HOSTNAME = "localhost";//"mysql.hostinger.mx";
        $this->DB_DATABASE = "dbDesastreNatural";//"u486432772_umgdn";
        $this->DB_USER = "root" ;//"u486432772_root";
        $this->DB_PASSWORD = "amberley4";


    }//end Constructor

    public function conectarBaseDeDatos(){

        try{

            $this->conexion = new PDO("mysql:host=$this->DB_HOSTNAME;dbname=$this->DB_DATABASE;charset=utf8", $this->DB_USER, $this->DB_PASSWORD);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


            return $this->conexion;

        }catch (PDOException $ex){

            return $ex->getMessage();

        }finally{

            $this->conexion = null; //cierro la conexion


        }

    }//end conectaBaseDeDatos


}