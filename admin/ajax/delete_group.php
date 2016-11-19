<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("group_id");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
    
            $groupid = dbase::globalMagic($_POST['group_id']);
            
            
            //validate data
            
            $validationResponse =  validateDataEdit($groupid);
            
          
                
            if ($validationResponse['validAck']=='ok'){
                
                $dataArray = Admin::deleteUserGroup($groupid);
                
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
function validateDataEdit($groupid){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    if (!is_numeric($groupid)){
        $validArray['groupid'] = "fail";
        $validArray['validAck'] = 'fail';
    }
    else{
         $validArray['groupid'] = "ok";
    }



   
    
  
    
    return $validArray;
    
}

?>