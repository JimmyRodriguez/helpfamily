<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/

//change email:


if(isset($_POST['nojs_change_email'])){
    $pass_msg = '';
    $email_msg = '';
    $pass_alert = '';
    $email_alert = '';
    $chemail_msg = '';
    $valid = '';
    $email  = dbase::globalMagic($_POST['email_change_nojs']);
    $password  = dbase::globalMagic(md5($_POST['ub_ch_p3_nojs']));
    
    $passwordResponse = validator::checkPasswordDB($password,$userid);
    
    if ($passwordResponse['validAck']=='fail'){
        $valid = 'fail';
        $pass_msg = $passwordResponse['validMsg'];
        $pass_alert = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
    }
    
    
    
    

    
    $emailResponse = validator::emailValidate($email,1,$userid);
    
    if ($emailResponse['Ack']=='fail'){
        $valid = 'fail';
        $email_msg = $emailResponse['Msg'];
        $email_alert = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
    }
    
    if ($valid != 'fail'){

        if(User::changeEmail($email,$userid)){
            $chemail_msg =  "your email has been updated."; 
        }
        else{
           $chemail_msg = "Oops, look like something went wrong! Try it again."; 
        }
        
       
    }
    else{
        $chemail_msg = 'correct the errors and try again.';
    }
    
}
else{
    $pass_msg = '';
    $email_msg = '';
    $pass_alert = '';
    $email_alert = '';
    $chemail_msg = '';
}


?>