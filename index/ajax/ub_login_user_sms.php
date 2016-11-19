<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();


        $postList = array("username","password","smstok","loc");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            /*
             
                ##please note##
             
                You may want to remove or rename "ub_login_user.php"
                if you plan to use this sms version [ub_login_user_sms.php]
                to prevent clever people logging in without using a sms token
                
                or you could tinker with the config file to set the login method
                in stone - if you plan to always use smstok to log users in.
                
            */
            
            //clean up data before it goes in
           
            $username   = dbase::globalMagic($_POST['username']);
            $password   = dbase::globalMagic($_POST['password']);
            $smstok     = dbase::globalMagic($_POST['smstok']);
            $loc        = dbase::globalMagic($_POST['loc']);
           
            
            
        
            $validationResponse = validateDataEdit($username,$password,$smstok);
           
            if ($validationResponse['validAck']=='ok'){
            
                  
                   $responseArray = User::loginUser($username,$password,true,$smstok,$loc);
                  
                    if($responseArray['validAck']===true){
                        
                        $dataArray = array("Ack"=>"success", "Msg"=>$responseArray['validMsg']);
                       
                    }
                    else{
                        
                        
                        
                        
                        $dataArray = array("Ack"=>"fail", "Msg"=>$responseArray['validMsg']);
                        
                    }
                
                 
                        
                   
            }
            else{
                
                
                if($validationResponse['usernameAck']=='fail'){
                    if(isset($_SESSION['session_failed_login_count'])){
                        if(intval($_SESSION['session_failed_login_count'])>=MAX_LOGIN_FAIL){
                        
                            User::failed_login($username,$password,true,$smstok,'max fail reached',$loc);
                            
                        }
                        else{
                            User::failed_login($username,$password,true,$smstok,'username check failed',$loc);
                        }
                    }
                    else{
                        User::failed_login($username,$password,true,$smstok,'username check failed',$loc);
                    }
                    
                            
                }
                
                
                $dataArray = array("Ack"=>"fail", "Msg"=>"Please check your login details and try again.");
            }
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }

echo json_encode($dataArray);

function validateDataEdit($username,$password,$smstok){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    $validArray['usernameAck'] = 'ok';
    
    $userNameResponse = validator::usernameValidate($username,2,'');
    
    if ($userNameResponse['Ack']=='fail' ){
        $validArray['validAck'] = 'fail';
        $validArray['usernameAck'] = 'fail';
    }
    
   
    

    $passwordResponse = validator::passwordValidate($password,"",1);

    if ($passwordResponse['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
    }
  
    //change this if you're smstok is set with a non-numeric value
    if (!is_numeric($smstok)){
        $validArray['validAck'] = 'fail';
    }
    
  
    
    

    
    return $validArray;
    
}

?>