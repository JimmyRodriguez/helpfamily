<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("blockid");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            
            
            //clean up data before it goes in
            
            $blockid = dbase::globalMagic($_POST['blockid']);
            
            
           
                
            if(is_numeric($blockid) && $blockid!=0){
                
                $responseArray = Admin::getBlockData($blockid);
                if ($responseArray['Ack']=="success"){
                    
               
                    $dataArray = $responseArray;
                    
                }
                else{
                    
                 
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Sorry, could not find this record.");
                }
                
            }
            else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"Sorry, could not find this record.");
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

function validateDataEdit($blockid){
    
   
    
   
    
    if (!is_numeric($blockid)){
        $dataArray['blockid'] = "fail";
    }
    else{
         $dataArray['blockid'] = "ok";
    }
   
    
    return $dataArray;
    
}

?>

