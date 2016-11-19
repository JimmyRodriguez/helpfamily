<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("status","groupId");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            $status = dbase::globalMagic($_POST['status']);
            $groupid = dbase::globalMagic($_POST['groupId']);
            
            
            //validate data
            
            $validationResponse =  validateDataEdit($status,$groupid);
            
            
                
            if ($validationResponse['validAck']=='ok'){
                if (Admin::editUserGroupStatus($status,$groupid)){
                    
              
                    $dataArray = array("Ack"=>"success", "Msg"=>"This user group has been deleted.");
                    
                }
                else{
                    
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Oops! Not sure what went wrong there. Refresh the page and try again.");
                }
            }
            else{
               $dataArray = array("Ack"=>"fail", "Msg"=>"Oops! Try refreshing the page and trying that again.", "validationdata" =>$validationResponse); 
            }
    
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit this group");
    
}

echo json_encode($dataArray);
function validateDataEdit($status,$groupid){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    if (!is_numeric($groupid)){
        $validArray['groupid'] = "fail";
        $validArray['validAck'] = 'fail';
    }
    else{
         $validArray['groupid'] = "ok";
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