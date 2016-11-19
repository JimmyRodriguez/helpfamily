<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("id","type");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

           
           
            
            
            
            
            $id         = dbase::globalMagic($_POST['id']);
            $type       = dbase::globalMagic($_POST['type']);
            
            //validate data
            
            if((is_numeric($id)) &&  ($id!=0)){
                $responseArray = Admin::get_all_attempts_lf($id);
                if ($responseArray['Ack']=="success"){
                    
                   
                    $dataArray = $responseArray;
                    
                    
                    
                    
                }
                else{
                   
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Woops, no data found.");
                
                }
            }
            else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"Woops, no data found.");
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

function validateDataEdit($userid){
    
   
    
    //page id
    
    if (!is_numeric($userid)){
        $dataArray['userid'] = "fail";
    }
    else{
         $dataArray['userid'] = "ok";
    }
   
    
    return $dataArray;
    
}

?>

