<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1,2,3))){

        $postList = array("commentid","commentnew");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

           
            
            validateDataEdit($commentid,$commentnew);
            
           
                if (Admin::createMenuItem($commentnew,$_SESSION['username'],$commentid)){
                    
               
                    $dataArray = array("Ack"=>"success", "Msg"=>"Your changes have been saved.");
                    
                }
                else{
                    
                    $dataArray = array("Ack"=>"success", "Msg"=>"Oops! Not sure what went wrong there. Refresh the page and try again.");
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


function validateDataEdit($commentid,$commentnew){
    
 
    if (!is_numeric($commentid)){
        $dataArray['commentid'] = "fail";
    }
    else{
         $dataArray['commentid'] = "ok";
    }
    
    
    if (trim($commentnew) != ""){
        $dataArray['commentnew'] = "fail";
    }
    else{
         $dataArray['commentnew'] = "ok";
    }

    return $dataArray;
    
}

?>