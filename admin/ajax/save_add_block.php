<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("blockdata","blockdesi","blockt","blockarea");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            $type       = dbase::globalMagic($_POST['blockt']);
            $desc       = dbase::globalMagic($_POST['blockdesi']);
            $block      = dbase::globalMagic($_POST['blockdata']);
            $area       = dbase::globalMagic($_POST['blockarea']);
            
            //validate data
            
            $validationResponse = validateDataEdit($type,$block,$area);
            
         
                
            if ($validationResponse['validAck']=='ok'){
                if (Admin::blockIPDE($type,$desc,$block,$area)){
                    
               
                    $dataArray = array("Ack"=>"success", "Msg"=>"New security block created");
                    
                }
                else{
                    
                  
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Oops! Not sure what went wrong there. Refresh the page and try again.");
                }
            }else{
                
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
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to add new security blocks");
    
}

echo json_encode($dataArray);
function validateDataEdit($type,$block,$area){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    if (!is_numeric($type) && $type!=-9){
        
        $validArray['typeAck']  = "fail";
        $validArray['typeMsg']  = "Oops! Try refreshing the page and trying again.";
        $validArray['validAck'] = "fail";
        
    }
    else{
        
        $validArray['typeAck'] = "ok";
        $validArray['typeMsg'] = "ok";
        
    }
    
    if (!is_numeric($area) && $area!=-9){
        
        $validArray['areaAck']  = "fail";
        $validArray['areaMsg']  = "Oops! Try refreshing the page and trying again.";
        $validArray['validAck'] = "fail";
        
    }
    else{
        
        $validArray['areaAck'] = "ok";
        $validArray['areaMsg'] = "ok";
        
    }
    
    if (trim($block)==''){
        
        $validArray['blockAck'] = "fail";
        $validArray['blockMsg'] = "enter the 'block' information";
        $validArray['validAck'] = "fail";
        
    }
    else{
        
        $validArray['blockAck'] = "ok";
        $validArray['blockMsg'] = "ok";
        
    }
  
    
    return $validArray;
    
}

?>