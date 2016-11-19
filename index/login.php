<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/ipn/local_config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/helpfamilycontrol/includes/bootstrap_frontend.php');
//require_once("../../ipn/local_config.php");
//require_once(APP_INC_PATH."../../includes/bootstrap_frontend.php");

sessionsClass::site_protection(true,true,false,false);

?>

<!DOCTYPE html>
<html lang="es" style="height: 100%">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- PACE-->
    <link rel="stylesheet" type="text/css" href="plugins/PACE/themes/blue/pace-theme-flash.css">
    <script type="text/javascript" src="plugins/PACE/pace.min.js"></script>
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Fonts-->
    <link rel="stylesheet" type="text/css" href="plugins/themify-icons/themify-icons.css">
    <!-- Primary Style-->
    <link rel="stylesheet" type="text/css" href="build/css/layout.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!-- WARNING: Respond.js doesn't work if you view the page via file://--> 
    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="background-image: url(build/images/backgrounds/cambray.jpg)" class="body-bg-full">
  <div class="text-center"><h2 class="info"></h2></div>
    <div class="container page-container">
      <div class="page-content">
        <div>
          <table class="table table-responsive">
            <tbody class="body body-bg-full">
              <tr>
                <td>
                  <img src="build/images/logo/umg.png" alt="" width="130">
                </td>
                <td>
                  <h3 class="text-white text-nowrap">UNIVERSIDAD MARIANO GALVEZ DE GUATEMALA</h3>
                </td>
              </tr>
              <tr>
                  <h1 class="text-white" style="align-content: center">SISTEMA HELP FAMILY CONTROL</h1>
              </tr>
              </tbody>
          </table>

        </div>
        <!-- FORMULARIO DEL LOGIN -->
        <form method="get" action="Vista/dashboard.php" class="form-horizontal">
          <div class="form-group">
            <div class="col-xs-12">
              <input type="text" placeholder="Usuario" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <input type="password" placeholder="Contraseña" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <div class="checkbox-inline checkbox-custom pull-left">
                <input id="exampleCheckboxRemember" type="checkbox" value="remember">
                <label for="exampleCheckboxRemember" class="checkbox-muted text-muted">Recordar</label>
              </div>
              <!--div class="pull-right"><a href="forgot-password.html" class="inline-block form-control-static">Forgot a Passowrd?</a></div-->
            </div>
          </div>
          <button type="submit" class="btn-lg btn btn-primary btn-rounded btn-block">Ingresar</button>
        </form>
        <hr>
        <!--div class="clearfix">
          <p class="text-muted mb-0 pull-left">Want new account?</p><a href="register.html" class="inline-block pull-right">Sign Up</a>
        </div-->
      </div>
    </div>
    <!-- jQuery-->
    <script type="text/javascript" src="plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap JavaScript-->
    <script type="text/javascript" src="plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Custom JS-->
    <script type="text/javascript" src="build/js/layout/extra-demo.js"></script>
    <!--the actual file required for the userBase front end to work - including stats collection-->
    <script type="text/javascript" src="js/ubf_js.1.3.js"></script>
    <!--simple function to collect stats -->
    <script>

      $(document).ready(function () {
        set_ub_stats();
      });

    </script>
  </body>
</html>