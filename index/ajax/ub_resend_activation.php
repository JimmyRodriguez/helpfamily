<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();


        $postList = array("ge_username_email");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
          
            $useremail = dbase::globalMagic($_POST['ge_username_email']);


            //validate data
            
            $validationResponse = validateDataEdit($useremail);
         
            if ($validationResponse['validAck']=='ok'){
            
                   
                  
                     
               
                    if (Admin::resend_activation($useremail,$validationResponse['emailorusername'])){
                        
               
                        $dataArray = array("Ack"=>"success", "Msg"=>"Your activation email has been resent.");
                        
                    
                        
                    }
                    else{
                        
                     
                        $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, refresh the page and try again.");
                    }
            }
            else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"Could not match this email or username with our records.");
            }
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }

echo json_encode($dataArray);

function validateDataEdit($username_email){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    
    $emailResponse = validator::emailValidate($username_email,2,'');
    
    if ($emailResponse['Ack']=='success'){
        
        $validArray['emailorusername'] = 1;
    }
    else {
        $userNameResponse = validator::usernameValidate($username_email,3,'');
    
        if ($userNameResponse['Ack']=='success' ){
            $validArray['emailorusername'] = 0;
        }
        else{
            //does not match an email or username in the system
            $validArray['validAck'] = 'fail';
        }
    }
    
    return $validArray;
    
}

?>