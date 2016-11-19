<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
>
<html lang="en">
<head>
    <title>nadlabs app login</title>

    <link rel="stylesheet" href="css/login_styles.css" type="text/css">
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
  
     <script type="text/javascript" src="js/cp_js.js"></script>
     <script type="text/javascript" src="js/corners.js"></script>
   <script>
            $(document).ready(function () {
                onLoadLogin();
                $('.ub_corners').corner('5px');
                $('.ub_corners3').corner('3px');
            });
        </script>
   
</head>
<body id=''>
    <div id='outer'>
    <div id='mainbox'>
    <div id='load_info' class='ub_corners '>
        
    </div>
    <form name='admin_login_form' id='admin_login_form' action='javascript:void(0);' onsubmit='loginUser()'>
        <div id='load_info_inner' class='ub_corners '>
            &nbsp;username:<br/>
            
            <div class='ub_text_box_wraps_small ub_corners '>
            
                <input type='text' id='username_login' class='ub_text_box_small'/>
     
              
                
           
           
           </div>
            <br/>
            &nbsp;password:<br/>
            <div class='ub_text_box_wraps_small ub_corners '>
            
                <input type='password' id='p1_login' class='ub_text_box_small'/>
     
              
                
           
           
           </div>
                     <button class='ub_buttons ub_corners3' type='submit'>login</button>
                     <img src="images/loader/login_loader.gif" id="submit_login_load" class='hide' />
                     <span class="error_red" id="submit_login_error"></span>
               
            <div class='txtr' style='position:absolute; bottom:0px; right:5px;'>
                <img src='images/powerlite.gif' />
            </div>
            
        </div>
            
    </form>  
    
    </div>
    </div>
</body>
</html>     