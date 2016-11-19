<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("groupid");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            
            
            //clean up data before it goes in
            
            $groupId = dbase::globalMagic($_POST['groupid']);
            
            
            //validate data
            
            
                
            if(is_numeric($groupId) && $groupId!=0){
                
                $responseArray = Admin::getGroupData($groupId);
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
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit this page");
    
}
echo json_encode($dataArray);

function validateDataEdit($groupId){
    
   
    
    //page id
    
    if (!is_numeric($groupId)){
        $dataArray['groupid'] = "fail";
    }
    else{
         $dataArray['groupid'] = "ok";
    }
   
    
    return $dataArray;
    
}

?>

