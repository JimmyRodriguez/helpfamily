<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();


        $postList = array("username","password");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
            //clean up data before it goes in
           
            $username = dbase::globalMagic($_POST['username']);
            $password = dbase::globalMagic($_POST['password']);
        
            
           
            
            
      
            $validationResponse = validateDataEdit($username,$password);
          
            if ($validationResponse['validAck']=='ok'){
            
                  
                   $responseArray = User::get_smstok($username,$password);
                  
                    if($responseArray['validAck']===true){
                        
                        $dataArray = array("Ack"=>"success", "Msg"=>$responseArray['validMsg']);
                       
                    }
                    else{
                        
                        $dataArray = array("Ack"=>"fail", "Msg"=>$responseArray['validMsg']);
                        
                    }
                
                       
                        
                   
            }
            else{
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
    
    $userNameResponse = validator::usernameValidate($username,2,'');
    
    if ($userNameResponse['Ack']=='fail' ){
        $validArray['validAck'] = 'fail';
    }
    
   
    

    $passwordResponse = validator::passwordValidate($password,"",1);

    if ($passwordResponse['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
    }
  
    
    return $validArray;
    
}

?>