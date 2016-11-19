<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/4/16
 * Time: 5:36 AM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/Controlador/PATROCINADOR.php');

switch ($_POST['seleccionarMetodo']){

    case "nuevoPatrocinador":

        $patrocinador = new PATROCINADOR();
        $respuesta = $patrocinador->nuevoPatrocinador($_POST['idTipoPatrocinador'],$_POST['idEstado'],$_POST['nombrePatrocinador'],
            $_POST['direccionPatrocinador'],$_POST['emailPatrocinador'],$_POST['telefonoPatrocinador'],$_POST['fechaInscripcionPatrocinador']);


        echo $respuesta; //devuelve true o false

        break;

    case "actualizarPatrocinador":
        break;

    case "eliminarPatrocinador":
        break;

    case "consultarPatrocinador":
        break;
}
