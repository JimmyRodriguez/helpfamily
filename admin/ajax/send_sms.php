<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("content","phone");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            //ADMIN_EMAIL
            
            
            //clean up data before it goes in
            
    
            $content = dbase::globalMagic($_POST['content']);
            $phone = dbase::globalMagic($_POST['phone']);
            //$name = dbase::globalMagic($_POST['name']);
            
            //validate data
            
            $validationResponse = validateDataEdit($content,$phone);
            
            if ($validationResponse['validAck']=='ok'){
                

                    $dataArray = Admin::sendSMS(false,$content,$phone);
                
                    
                     
                        
                  
            }
            else{
                
                $dataArray = array("Ack"=>"validationFail", "Msg"=>"Correct the errors and try again.", "validationdata" =>$validationResponse);

            }
    
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to use the sms function");
    
}
echo json_encode($dataArray);

function validateDataEdit($content,$phone){
    
   
   
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    

    
    if (trim($phone)=='' || !is_numeric($phone)){
        $validArray['validAck'] = 'fail';
        
        
        $validArray['phoneAck'] = 'fail';
        $validArray['phoneMsg'] = 'this user does not have a valid phone number';
    }
    else{
         $validArray['phoneAck'] = 'ok';
         $validArray['phoneMsg'] = 'ok';
    }
    
    if (trim($content)==''){
        
        $validArray['validAck'] = 'fail';
        
        $validArray['contentAck'] = 'fail';
        $validArray['contentMsg'] = 'enter the message content';
    }
    else{
        $validArray['contentAck'] = 'ok';
        $validArray['contentMsg'] = 'ok';
    }
    
    

   
    
    return $validArray;
    
}

?>

