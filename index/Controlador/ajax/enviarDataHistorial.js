
function nuevoHistorial() {

    //declar variables que se necesitan
    var metodo = "nuevoHistorial";

    var idFamilia = document.getElementById("idFamilia").value;
    var descripcionHistorial = document.getElementById("descripcionHistorial").value;
    var fechaHistorial = document.getElementById("fechaHistorial").value;
    var casaHistorial = document.getElementById("casaHistorial").value;
    var materialCasaHistorial = document.getElementById("materialCasaHistorial").value;
    var trabajaHistorial = document.getElementById("trabajaHistorial").value;
    var salarioHistorial = document.getElementById("salarioHistorial").value;;
    var empresaHistorial = document.getElementById("empresaHistorial").value;
    var vehiculoHistorial = document.getElementById("vehiculoHistorial").value;

    if(descripcionHistorial.length == 0){

        window.alert("Ingrese un una breve descripcion ");

    }else if(fechaHistorial.length == 0){

        window.alert("Seleccione un fecha");

    }else if(casaHistorial.length == 0){

        window.alert("Seleccione un valor");

    }else if(materialCasaHistorial.length == 0){

        window.alert("Seleccione un valor");

    }else if(trabajaHistorial.length == 0){

        window.alert("Seleccione un valor");

    }else if(empresaHistorial.length == 0){

        window.alert("Ingrese un valor");

    }else if(vehiculoHistorial.length == 0){

        window.alert("Seleccione un valor");
    }
    else{

        //llamar la funcion crearXmlHttpRequest que me devuelva el objeto xmlhttp
        xmlhttp = crearXmlHttpRequest();

        xmlhttp.onreadystatechange = function () {

            console.log(xmlhttp.responseText);

            if(xmlhttp.readyState == 4){

                if(xmlhttp.responseText == true){

                    //document.document.href = "../../../Vista/DASHBOARD.html";
                    window.alert("Historial SocioEconomico Guardado correctamente");

                }else{
                    window.alert("El Historial SocioEconomico no se Registro correctamente");
                }
            }
        }

        var dataForm = "seleccionarMetodo="+metodo+"&idFamilia="+idFamilia+"&descripcionHistorial="+descripcionHistorial+"&fechaHistorial="+
            fechaHistorial+"&casaHistorial="+casaHistorial+"&materialCasaHistorial="+materialCasaHistorial+"&trabajaHistorial="+
            trabajaHistorial+"&salarioHistorial="+salarioHistorial+"&empresaHistorial="+empresaHistorial+"&vehiculoHistorial="+vehiculoHistorial;

        xmlhttp.open("POST","../scripts/procesarDataHistorialSocioEconomico.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(dataForm);
    }

}//end nuevoHistorial

function actualizarHistorial(){
    var idHistorial = $("#idHistorialAct").val();

}

function consultarHistorial(idHis) {

    $("#idHistorialAct").val(idHis); //este valor se le asigna al <input type="hidden" name="idEmpleadoDel
    //declar variables que se necesitan
    var metodo = "consultarHistorial";
    var idHistorial = idHis;

    if (idHistorial > 0){
        //llamar la funcion crearXmlHttpRequest que me devuelva el objeto xmlhttp
        xmlhttp = crearXmlHttpRequest();

        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4) {

                //console.log(xmlhttp.responseText);
                /*foreach(xmlhttp.responseText in row){

                 }*/
            }
        }


        var dataForm = "seleccionarMetodo=" + metodo + "&idEmpleado=" +idEmpleado;

        xmlhttp.open("POST", "../scripts/procesarDataEmpleado.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xmlhttp.send(dataForm);

    }else{

    }
}

function eliminarHistorial() {
    //declar variables que se necesitan

    var idEmpleado = $("#idEmpleadoDel").val();
    var metodo = "eliminarEmpleado";


    if (idEmpleado > 0){
        //llamar la funcion crearXmlHttpRequest que me devuelva el objeto xmlhttp
        xmlhttp = crearXmlHttpRequest();

        xmlhttp.onreadystatechange = function () {

            console.log(xmlhttp.responseText);

            if (xmlhttp.readyState == 4) {

                if (xmlhttp.responseText == true) {

                    //document.document.href = "../../../Vista/DASHBOARD.html";
                    window.alert("El registro  se elimino correctamente");

                    $(".bd-example-modal-sm").dataset.collapse;

                } else {

                    window.alert("El registro no fue eliminado");

                }

            }
        }


        var dataForm = "seleccionarMetodo=" + metodo + "&idEmpleado=" +idEmpleado;

        xmlhttp.open("POST", "../scripts/procesarDataEmpleado.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xmlhttp.send(dataForm);

    }else{

    }

}

function pasarIdHistorial(idHistorial) {

    $("#idHistorialDel").val(idHistorial);


}

function crearXmlHttpRequest() {

    var xmlhttp;

    if (window.XMLHttpRequest){ //chrome, mozila, safari

        xmlhttp = new XMLHttpRequest();

        return xmlhttp;

    }else{

        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); //internet explorer o edge

        return xmlhttp;
    }


}//end crearXmlHttpRequest

