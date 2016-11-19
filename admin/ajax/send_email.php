<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("subject","content","email");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            //ADMIN_EMAIL
            
            
            //clean up data before it goes in
            
            $subject = dbase::globalMagic($_POST['subject']);
            $content = $_POST['content'];
            $email = dbase::globalMagic($_POST['email']);
            //$name = dbase::globalMagic($_POST['name']);
            
            //validate data
            
            $validationResponse = validateDataEdit($subject,$content,$email);
            
            if ($validationResponse['validAck']=='ok'){
                
                   
                    $responseArray = Admin::sendEmail($subject,$content,$email);
                    if ($responseArray['Ack']=="success"){
                        
                    
                        $dataArray = $responseArray;
                        
                    }
                    else{
                        
                        
                        $dataArray = array("Ack"=>"fail", "Msg"=>"Oops! Not sure what went wrong there. Refresh the page and try again.");
                    }
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
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to use the email function");
    
}
echo json_encode($dataArray);

function validateDataEdit($subject,$content,$email){
    
   
   
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    

    
    if (trim($subject)==''){
        $validArray['validAck'] = 'fail';
        
        
        $validArray['subjectAck'] = 'fail';
        $validArray['subjectMsg'] = 'enter the email subject line';
    }
    else{
         $validArray['subjectAck'] = 'ok';
         $validArray['subjectMsg'] = 'ok';
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
    $emailResponse = validator::emailValidate($email,2,0);
    if ($emailResponse['Ack']=='fail'){
        
        $validArray['validAck'] = 'fail';
        $validArray['emailAck'] = 'fail';
        $validArray['emailMsg'] = 'Oops, try refreshing the page and sending the email again.';
    }
    else{
        $validArray['emailAck'] = 'ok';
        $validArray['emailMsg'] = 'ok';
    }
    

   
    
    return $validArray;
    
}

?>

