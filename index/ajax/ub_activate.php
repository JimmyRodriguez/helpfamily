<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");
require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();


        $postList = array("ge_parta","ge_partb");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
          
            $userid = dbase::globalMagic($_POST['ge_parta']);
            $acticode = dbase::globalMagic($_POST['ge_partb']);

            //validate data
            
            $validationResponse = validateDataEdit($userid,$acticode);
         
            if ($validationResponse['validAck']=='ok'){
            
                   
                  
                     
               
                    if (User::activateUser($userid,$acticode,CONGRATS_NO_HTML)){
                        
               
                        $dataArray = array("Ack"=>"success", "Msg"=>"Your account has been activated.");
                        
                    
                        
                    }
                    else{
                        
                     
                        $dataArray = array("Ack"=>"fail", "Msg"=>"Could not activate your account. Make sure you copied the codes into the correct boxes.");
                    }
            }
            else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"Make sure you copied the codes into the correct boxes.");
            }
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }

echo json_encode($dataArray);

function validateDataEdit($userid,$acticode){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    if(trim($userid)==''){
        $validArray['validAck'] = 'fail';
    }

    if(!is_numeric(intval($acticode))){
        $validArray['validAck'] = 'fail';
    }
    
    

    
    return $validArray;
    
}

?>