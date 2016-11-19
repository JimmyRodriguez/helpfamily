<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("userid","status");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            $userid = dbase::globalMagic($_POST['userid']);
            $status = dbase::globalMagic($_POST['status']);
            
            
            //validate data
            
            $validationResponse = validateDataEdit($userid,$status);
            
            
                
            if ($validationResponse['validAck']=='ok'){
                if (Admin::changeUserStatus($status,$userid)){
                    
                  
                    $dataArray = array("Ack"=>"success", "Msg"=>"Your changes have been saved.");
                    
                }
                else{
                    
               
             
                    $dataArray = array("Ack"=>"success", "Msg"=>"Oops! Not sure what went wrong there. Refresh the page and try again.");
                }
            }
            else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"Try refreshing the page and trying that again.", "validationdata" =>$validationResponse);
            }
    
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"success", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit this page");
    
}
echo json_encode($dataArray);

function validateDataEdit($userid,$status){
    
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
 
    if (!is_numeric($userid)){
        $validArray['userid'] = "fail";
        $validArray['validAck'] = 'fail';
    }
    else{
        $validArray['userid'] = "ok";
    }
    
    
    if (!is_numeric($status)){
        $validArray['status'] = "fail";
        $validArray['validAck'] = 'fail';
    }
    else{
        $validArray['status'] = "ok";
    }
  
    

    return $validArray;
    
}

?>