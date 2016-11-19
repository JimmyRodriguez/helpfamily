<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();


if (sessionsClass::sessionStartFind(false)){


        $postList = array("ed_new_email","ed_current_password");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
          
            $email = dbase::globalMagic($_POST['ed_new_email']);
            $password = dbase::globalMagic($_POST['ed_current_password']);
      
          
           
            
            //$userid = 172;
            $userid = dbase::globalMagic($_SESSION['userid']);
            
            
            
            //validate data
            
            $validationResponse = validateDataEdit($email,$userid,$password);
            
         
            if ($validationResponse['validAck']=='ok'){
            
                   
                  
                     
          
                    if (User::changeEmail($email,$userid)){
                        
         
                        $dataArray = array("Ack"=>"success", "Msg"=>"Your new email has been saved.");
                        
                     
                        
                    }
                    else{
                        
                      
                        $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, look like something went wrong! Try clicking save again.");
                    }
            }
            else{
                unset($validationResponse['validAck']);
                $dataArray = array("Ack"=>"fail", "Msg"=>"Correct the errors and try again.", "validationErrors" =>$validationResponse);
            }
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit this page");
    
}
echo json_encode($dataArray);

function validateDataEdit($email,$userid,$password){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
   
    $passwordResponse = validator::checkPasswordDB($password,$userid);
    
    if ($passwordResponse['validAck']=='fail'){
        $validArray['validAck'] = 'fail';
        $validArray['ed_current_password'] = $passwordResponse['validMsg'];
    }

    
    
    
    //source 0 = register 1=edit/save
    
    $emailResponse = validator::emailValidate($email,1,$userid);
    
    if ($emailResponse['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
        $validArray['ed_new_email'] = $emailResponse['Msg'];
    }
    
    
    
    
    
    

    
    return $validArray;
    
}

?>