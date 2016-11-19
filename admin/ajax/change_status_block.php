<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("status","blockid");

        if (general::globalIsSet($_POST,$postList)){

            
            
            
            //clean up data before it goes in
            
            $blockid = dbase::globalMagic($_POST['blockid']);
            $status = dbase::globalMagic($_POST['status']);
            
            
   
            
            $validationResponse = validateDataEdit($status,$blockid);
            
          
                
            if ($validationResponse['validAck']=='ok'){
                if (Admin::changeStatusBlock($status,$blockid)){
                    
                    if($status==1){
                        $msg = "this block has been activated.";
                    }
                    else {
                        $msg = "this block has been deactivated.";
                    }
              
                    $dataArray = array("Ack"=>"success", "Msg"=>$msg);
                    
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
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit this block");
    
}

echo json_encode($dataArray);


function validateDataEdit($status,$blockid){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    if (!is_numeric($blockid)){
        $validArray['blockid'] = "fail";
        $validArray['validAck'] = 'fail';
    }
    else{
         $validArray['blockid'] = "ok";
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