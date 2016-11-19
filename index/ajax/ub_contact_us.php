<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();


        $postList = array("ge_username","ge_email","ge_msg");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            $contact_mail  = dbase::globalMagic($_POST['ge_email']);
            $contact_name  = dbase::globalMagic($_POST['ge_username']);
            $contact_message  = $_POST['ge_msg'];
            $valid = validateDataEdit($contact_mail,$contact_message,$contact_name);
                   
            if ($valid['validAck']!='fail'){  
                User::check_user($contact_mail,$contact_name,$contact_message);
                $dataArray = array("Ack"=>"success", "Msg"=>"Your message has been sent.");
            }
            else{
                unset($valid['validAck']);
                $dataArray = array("Ack"=>"fail", "Msg"=>"Correct the errors and try again.", "validationErrors" =>$valid);
            }
           
            
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }

echo json_encode($dataArray);

function validateDataEdit($contact_mail,$contact_message,$contact_name){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
   
   
  
    if (filter_var($contact_mail, FILTER_VALIDATE_EMAIL)){
        
        $validArray['emailAck'] = 'ok';
    }
    else{
        $validArray['validAck'] = 'fail';
       
        $validArray['ge_email']='Make sure the email is in the correct format.';
 
    }
    
    if (trim($contact_message) != ''){
        $validArray['msgAck'] = 'ok';
    }
    else{
        $validArray['validAck'] = 'fail';
    
        $validArray['ge_msg']='Make sure to enter your message.';
 
    }
    
    if (trim($contact_name) != ''){
         $validArray['nameAck'] = 'ok';
    }
    else{
        $validArray['validAck'] = 'fail';
       
        $validArray['ge_username']='Make sure to enter your name.';
 
    }
    
   
    
    

    
    return $validArray;
    
}

?>