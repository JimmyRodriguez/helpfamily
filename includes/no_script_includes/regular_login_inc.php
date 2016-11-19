<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/


//normal login:

if(isset($_POST['nojs_login'])){
    
    $valid = '';
    
    $username  = dbase::globalMagic($_POST['ub_login_username_nojs']);
    $password  = md5(dbase::globalMagic($_POST['ub_login_p1_nojs']));
    $pass_msg = '';
     $user_msg = '';
    $pass_alert = 'hide';
    $user_alert = 'hide';
    $login_msg ='';
   
    if(isset($_POST['ub_remember_nojs'])){
        if($_POST['ub_remember_nojs']=='yes'){
            
            $remember=true; 
        }
        else{
           $remember=false; 
        }
    }
    else{
        $remember=false;
    }
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
        $responseArray = User::loginUser($username,$password,false,'','user',$remember);
        if($responseArray['validAck']===true){
             header("Location: userarea.php");
            exit;
        }
        else{
           $login_msg = $responseArray['validMsg']; 
        }
        
       
    }
    else{
        $login_msg = 'please check your details and try again.';
    }
    
}
else{
   
    $pass_msg = '';
    $user_msg = '';
    $pass_alert = 'blank';
    $user_alert = 'blank';
    $login_msg = '';
    
}






?>