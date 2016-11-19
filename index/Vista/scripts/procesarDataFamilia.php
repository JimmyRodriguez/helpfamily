<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 4:10 PM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Controlador/FAMILIA.php');

switch ($_POST['seleccionarMetodo']){

    case "nuevoFamilia":

        $nuevoFam = new FAMILIA();
        $respuesta = $nuevoFam->nuevaFamilia();

        echo $respuesta; //devuelve true o false

        break;

    case "eliminarFamilia":
        $nuevoFam = new FAMILIA();
        $respuesta = $nuevoFam->eliminarFamilia();

        echo $respuesta;
        break;

    case "actualizarFamilia":


        break;

    case "consultarFamilia":
        $nuevoFam = new FAMILIA();
        $respuesta = $nuevoFam->consultarFamilia();

        echo $respuesta; //se devuelve un objeto json
        break;
}



?>