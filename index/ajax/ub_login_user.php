<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
    //

        $postList = array("ge_username","ge_password","ge_loc","ge_rem_real");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
    
            
            //clean up data before it goes in
           
            $username = dbase::globalMagic($_POST['ge_username']);
            $password = dbase::globalMagic($_POST['ge_password']);
            $remember = dbase::globalMagic($_POST['ge_rem_real']);
            $loc        = dbase::globalMagic($_POST['ge_loc']);
        
            
            $remember = ($remember==1)?true:false;
            
            
       
            $validationResponse = validateDataEdit($username,$password);
          
            if ($validationResponse['validAck']=='ok'){
                  
                    $responseArray = User::loginUser($username,$password,false,'',$loc,$remember);
                  
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
                        
                            User::failed_login($username,$password,false,'','max fail reached',$loc);
                            
                        }
                        else{
                            User::failed_login($username,$password,false,'','username check failed',$loc);
                        }
                    }
                    else{
                        User::failed_login($username,$password,false,'','username check failed',$loc);
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

function validateDataEdit($username,$password){
    
 
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
  
   
    
  
    
    

    
    return $validArray;
    
}

?>