<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

/*
    DEAD FILE - can be removed.
*/

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind(false)){

        $postList = array("source","email");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
            //clean up data before it goes in
           
            $email = dbase::globalMagic($_POST['email']);
            $source = dbase::globalMagic($_POST['source']);
        
            //$userid = 99;
            $userid = dbase::globalMagic($_SESSION['userid']);
            
            
            
            //validate data
            
            $validationResponse = validateDataEdit($email, $userid,$source);
            
         
            if ($validationResponse['validAck']=='ok'){
            
                  
                   
                  
                     
                
                        
                
                        $dataArray = array("Ack"=>"success", "Msg"=>"Your email has been changed.");
                        
            
                        
                   
            }
            else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"Correct the errors and try again.", "validationdata" =>$validationResponse);
            }
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to use this function.");
    
}
echo json_encode($dataArray);

function validateDataEdit($email, $userid,$source){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
  
    
  
 
    
    
    
    $emailResponse = validator::emailValidate($email,$source,$userid);
    
    if ($emailResponse['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
    }
    
    $validArray['emailAck'] = $emailResponse['Ack'];
    $validArray['emailMsg'] = $emailResponse['Msg'];
    
  
    
    

    
    return $validArray;
    
}

?>