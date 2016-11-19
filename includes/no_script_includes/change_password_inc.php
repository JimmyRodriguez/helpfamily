<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/



//change password:

if(isset($_POST['nojs_change_pass'])){
    $pass_msg_p = '';
    $pass_msg_c = '';
    $pass_alert_p = '';
    $pass_alert_c = '';

    $chpass_msg = '';
    $valid = '';
    
    //new passwords
    $p1  = md5(dbase::globalMagic($_POST['p1_change_nojs']));
    $p2  = md5(dbase::globalMagic($_POST['p2_change_nojs']));
    //current password
    $p4  = md5(dbase::globalMagic($_POST['p4_change_nojs']));
    
    
    
    
    

    
    $passwordResponse = validator::passwordValidate($p1,$p2,0);
    
    if ($passwordResponse['Ack']=='fail'){
        $valid = 'fail';
        $pass_msg_p = $passwordResponse['Msg'];
        $pass_alert_p = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
    }
    
    $passwordResponse = validator::checkPasswordDB($p4,$userid);
    
    if ($passwordResponse['validAck']=='fail'){
        $valid = 'fail';
        $pass_msg_c = $passwordResponse['validMsg'];
        $pass_alert_c = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
    }
    
    if ($valid != 'fail'){
        $salt = general::generate_salt();
        $phash = general::doubleSalt($p1,$salt);
        if(User::changePassword($phash,$salt,$userid)){
            $chpass_msg =  "your password has been updated."; 
        }
        else{
           $chpass_msg = "Oops, look like something went wrong! Try it again."; 
        }
        
       
    }
    else{
        $chpass_msg = 'correct the errors and try again.';
    }
    
}
else{
    $pass_msg_p = '';
    $pass_msg_c = '';
    $pass_alert_p = '';
    $pass_alert_c = '';

    $chpass_msg = '';
}
    


?>