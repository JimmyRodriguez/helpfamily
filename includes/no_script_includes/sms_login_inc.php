<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/





 if(isset($_POST['nojs_loginsms'])){
    $pass_msg_sms = '';
    $user_msg_sms = '';
    $pass_alert_sms = 'blank';
    $user_alert_sms = 'blank';
    $login_msg_sms ='';
    

    
    $username  = dbase::globalMagic($_POST['ub_loginsms_username_nojs']);
    $password  = md5(dbase::globalMagic($_POST['ub_loginsms_p1_nojs']));
    $smstok    = dbase::globalMagic($_POST['ub_loginsms_smstok_nojs']);
    
    
    if (isset($_POST['login'])){
        
        login_nojs($username,$password,$smstok,$login_msg_sms);
    }
    else if (isset($_POST['sendsms'])){
      
        loginsmstok_nojs($username,$password,$login_msg_sms);
    }
    
 }
 else{
    $pass_msg_sms = '';
    $user_msg_sms = '';
    $pass_alert_sms = 'blank';
    $user_alert_sms = 'blank';
    $login_msg_sms ='';
    
 }

// sms login :

function login_nojs($username,$password,$smstok,&$login_msg_sms){
    $valid='';
    $userNameResponse = validator::usernameValidate($username,2,'');
    
    if ($userNameResponse['Ack']=='fail' ){
        $valid = 'fail';
        //$user_alert = 'alert';
        //$user_msg = $userNameResponse['Msg'];
    
    }
    

    $passwordResponse = validator::passwordValidate($password,"",1);

    if ($passwordResponse['Ack']=='fail'){
        $valid = 'fail';
        //$pass_alert = 'alert';
        //$pass_msg = $passwordResponse['Msg'];
    
    }
    
    if (!is_numeric($smstok)){
        $valid = 'fail';
    }
  
    
    if ($valid != 'fail'){
        $responseArray = User::loginUser($username,$password,true,$smstok,'user');
        if($responseArray['validAck']===true){
             header("Location: userarea.php");
            exit;
        }
        else{
           $login_msg_sms = $responseArray['validMsg']; 
        }
        
       
    }
    else{
        $login_msg_sms = 'please check your details and try again.';
    }
}








//send sms token:

function loginsmstok_nojs($username,$password,&$login_msg_sms){
    $valid='';
    $userNameResponse = validator::usernameValidate($username,2,'');
    
    if ($userNameResponse['Ack']=='fail' ){
        $valid = 'fail';
        //$user_alert = 'alert';
        //$user_msg = $userNameResponse['Msg'];
    
    }
    

    $passwordResponse = validator::passwordValidate($password,"",1);

    if ($passwordResponse['Ack']=='fail'){
        $valid = 'fail';
        //$pass_alert = 'alert';
        //$pass_msg = $passwordResponse['Msg'];
    
    }
    
   
    if ($valid != 'fail'){
        $responseArray = User::get_smstok($username,$password);
        if($responseArray['validAck']===true){
             
              $login_msg_sms = $responseArray['validMsg']; 
            
        }
        else{
            //you may want to do something different here
           $login_msg_sms = $responseArray['validMsg']; 
        }
        
       
    }
    else{
        $login_msg_sms = 'please check your details and try again.';
    }
}


?>