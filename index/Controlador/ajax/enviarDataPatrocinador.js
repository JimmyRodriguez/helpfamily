/**
 * Created by jimmysidney on 11/4/16.
 */


function nuevoPatrocinador() {
    //declar variables que se necesitan
    var metodo = "nuevoPatrocinador";

    var idEstado = document.getElementById("idEstado").value;
    var idTipoPatrocinador = document.getElementById("idTipoPatrocinador").value;
    var idSexo = document.getElementById("idSexo").value;
    var nombrePatrocinador = document.getElementById("nombrePatrocinador").value;
    var telefonoPatrocinador = document.getElementById("telefonoPatrocinador").value;
    var emailPatrocinador = document.getElementById("emailPatrocinador").value;
    var direccionPatrocinador = document.getElementById("direccionPatrocinador").value;;
    var fechaInscripcionPatrocinador = document.getElementById("fechaInscripcionPatrocinador").value;


    console.log("variables : " + idEstado, idTipoPatrocinador, idSexo, nombrePatrocinador,
        telefonoPatrocinador, emailPatrocinador,direccionPatrocinador,fechaInscripcionPatrocinador);

    console.log("estoy antes de entrar al if");

    if(nombrePatrocinador.length == 0){

        window.alert("Ingrese un nombre de Patrocinador");

    }else if(telefonoPatrocinador.length == 0){

        window.alert("Ingrese un numero de telefono");

    }else if(emailPatrocinador.length == 0){

        window.alert("Ingrese un correo electronico");

    }else if(direccionPatrocinador.length == 0){

        window.alert("Ingrese una direccion correcta");

    }else if(fechaInscripcionPatrocinador.length == 0){

        window.alert("Ingrese una fecha valida");
    }
    else{

        console.log("entre al Else");

        //llamar la funcion crearXmlHttpRequest que me devuelva el objeto xmlhttp
        xmlhttp = crearXmlHttpRequest();

        xmlhttp.onreadystatechange = function () {

            console.log(xmlhttp.responseText);

            if(xmlhttp.readyState == 4){

                if(xmlhttp.responseText == true){

                    //document.document.href = "../../../Vista/DASHBOARD.html";
                    window.alert("El registro del Patrocinador fueron guardados satisfactoriamente");

                }else{

                    window.alert("El registro del Patrocinador no se almaceno");

                }

            }//end if
        }// end onreadystatechange


        var dataForm = "seleccionarMetodo="+metodo+"&idTipoPatrocinador="+idTipoPatrocinador+"&nombrePatrocinador="+nombrePatrocinador+
            "&idEstado="+idEstado+"&telefonoPatrocinador="+ telefonoPatrocinador+"&emailPatrocinador="+emailPatrocinador+
            "&direccionPatrocinador="+direccionPatrocinador+"&fechaInscripcionPatrocinador="+fechaInscripcionPatrocinador;

        console.log("estoy en le dataForm : " + dataForm);


        xmlhttp.open("POST","../scripts/procesarDataPatrocinador.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        console.log("estoy antes del metodo SEND");

        xmlhttp.send(dataForm);

        console.log("estoy despues del metodo send");

    }
    
}

function actualizarPatrocinador() {
    
}

function consultarPatrocinador() {
    
}

function eliminarPatrocinador() {
    
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
