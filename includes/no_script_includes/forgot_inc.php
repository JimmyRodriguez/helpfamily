<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/



if(isset($_POST['nojs_forgot'])){
    $forgot_input_msg = '';
    
    $forgot_alert = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
    
    
    
    $username_email  = dbase::globalMagic($_POST['user_email_forgot_nojs']);
    $forgot_msg = '';
    $valid = '';
    
    $emailResponse = validator::emailValidate($username_email,2,'');
    
    if ($emailResponse['Ack']=='success'){
        
      
        if (User::forgotPassword(1,$username_email)){

            $forgot_msg = "A temporary password has been sent to your email account.";
            $forgot_alert='';

        }
        else{
             $forgot_msg = "Oops, Try clicking recover password again.";

        }
    }
    else {
        $userNameResponse = validator::usernameValidate($username_email,3,'');
    
        if ($userNameResponse['Ack']=='success' ){
            if (User::forgotPassword(0,$username_email)){
    
                $forgot_msg = "A temporary password has been sent to your email account.";
                $forgot_alert = '';
    
            }
            else{
                 $forgot_msg = "Oops, Try clicking recover password again.";
    
            }
        }
        else{
            //does not match an email or username in the system
            $forgot_msg = "Oops, could not match this username or email in our system.";
        }
    }
    
    
    
    
    
    
    
}
else{
    $forgot_input_msg = '';

    $forgot_alert = '';

    $forgot_msg = '';
    $valid = '';
}





?>