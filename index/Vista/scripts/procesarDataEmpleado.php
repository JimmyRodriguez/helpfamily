<?php
/**
 * Created by PhpStorm.
 * User: jimmysidney
 * Date: 11/1/16
 * Time: 4:10 PM
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/index/Controlador/EMPLEADO.php');

    switch ($_POST['seleccionarMetodo']){

        case "nuevoEmpleado":

            $nuevoEmp = new EMPLEADO();
            $respuesta = $nuevoEmp->nuevoEmpleado($_POST['idEstado'],$_POST['idSexo'],$_POST['nombreEmpleado'],$_POST['dpiEmpleado'],
                $_POST['telefonoEmpleado'],$_POST['emailEmpleado'],$_POST['direccionEmpleado'],$_POST['fechaNacEmpleado']);

            echo $respuesta; //devuelve true o false

            break;

        case "eliminarEmpleado":
            $eliminarEmp = new EMPLEADO();
            $respuesta = $eliminarEmp->eliminarEmpleado($_POST['idEmpleado']);

            echo $respuesta;
            break;

        case "actualizarEmpleado":


            break;

        case "consultarEmpleado":
            $consultarEmp = new EMPLEADO();
            $respuesta = $consultarEmp->consultarEmpleado($_POST['idEmpleado']);

            echo $respuesta; //se devuelve un objeto json
            break;
    }



?>