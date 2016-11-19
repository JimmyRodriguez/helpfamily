<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 4:10 PM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Controlador/HISTORIAL_SOCIO_ECONOMICO.php');

switch ($_POST['seleccionarMetodo']){

    case "nuevoHistorial":

        $nuevoHis = new HISTORIAL_SOCIO_ECONOMICO();
        $respuesta = $nuevoHis->nuevoHistorialSocioEconomico($_POST["idFamilia"],$_POST["descripcionHistorial"],$_POST["fechaHistorial"],
            $_POST["casaHistorial"],$_POST["materialCasaHistorial"],$_POST["trabajaHistorial"],$_POST["salarioHistorial"],$_POST["empresaHistorial"],
            $_POST["vehiculoHistorial"]);

        echo $respuesta; //devuelve true o false

        break;

    case "eliminarHistorial":

        $eliminarHis = new HISTORIAL_SOCIO_ECONOMICO();
        $respuesta = $eliminarHis->eliminarHistorialSocioEconomico();

        echo $respuesta;
        break;

    case "actualizarHistorial":
        $actualizarHis = new HISTORIAL_SOCIO_ECONOMICO();
        $respuesta = $nuevoHis->actualizarHistorialSocioEconomico();

        break;

    case "consultarHistorial":
        $nuevoHis = new HISTORIAL_SOCIO_ECONOMICO();
        $respuesta = $nuevoHis->consultarTodosHistorialSocioEconomico();

        echo $respuesta; //se devuelve un objeto json
        break;
}


?>