
function nuevoEmpleado() {

    //declar variables que se necesitan
    var metodo = "nuevoEmpleado";

    var idEstado = document.getElementById("idEstado").value;
    var idSexo = document.getElementById("idSexo").value;
    var nombreEmpleado = document.getElementById("nombreEmpleado").value;
    var dpiEmpleado = document.getElementById("dpiEmpleado").value;
    var telefonoEmpleado = document.getElementById("telefonoEmpleado").value;
    var emailEmpleado = document.getElementById("emailEmpleado").value;
    var direccionEmpleado = document.getElementById("direccionEmpleado").value;;
    var fechaNacEmpleado = document.getElementById("fechaNacEmpleado").value;

    if(nombreEmpleado.length == 0){

        window.alert("Ingrese un nombre de empleado");

    }else if(dpiEmpleado.length == 0){

        window.alert("Ingrese un numero de dpi");

    }else if(telefonoEmpleado.length == 0){

        window.alert("Ingrese un numero de telefono");

    }else if(emailEmpleado.length == 0){

        window.alert("Ingrese un correo electronico");

    }else if(direccionEmpleado.length == 0){

        emailEmpleado = null;

        //window.alert("Ingrese una direccion correcta");

    }else if(fechaNacEmpleado.length == 0){

         window.alert("Ingrese una fecha valida");
    }
    else{

        //llamar la funcion crearXmlHttpRequest que me devuelva el objeto xmlhttp
        xmlhttp = crearXmlHttpRequest();

        xmlhttp.onreadystatechange = function () {

            console.log(xmlhttp.responseText);

            if(xmlhttp.readyState == 4){

                if(xmlhttp.responseText == true){

                    //document.document.href = "../../../Vista/DASHBOARD.html";
                    window.alert("El registro del empleado fueron guardados satisfactoriamente");

                }else{
                    window.alert("El registro del empleado no se almaceno");
                }
            }
        }

        var dataForm = "seleccionarMetodo="+metodo+"&idEstado="+idEstado+"&idSexo="+idSexo+"&nombreEmpleado="+
                        nombreEmpleado+"&dpiEmpleado="+dpiEmpleado+"&telefonoEmpleado="+
                        telefonoEmpleado+"&emailEmpleado="+emailEmpleado+"&direccionEmpleado="+direccionEmpleado+"&fechaNacEmpleado="+fechaNacEmpleado;

        xmlhttp.open("POST","../scripts/procesarDataEmpleado.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(dataForm);
    }

}//end nuevoEmpleado

function actualizarEmpleado(){
    var idEmpleado = $("#idEmpleadoAct").val();


}

function consultarEmpleado(idEmp) {

    $("#idEmpleadoAct").val(idEmp); //este valor se le asigna al <input type="hidden" name="idEmpleadoDel
    //declar variables que se necesitan
    var metodo = "consultarEmpleado";
    var idEmpleado = idEmp

    if (idEmpleado > 0){
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

function eliminarEmpleado() {
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

function pasarIdEmpleado(idEmpleado) {

    $("#idEmpleadoDel").val(idEmpleado);

    
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

