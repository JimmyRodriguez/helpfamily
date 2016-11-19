<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("userid","note");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            $userid = dbase::globalMagic($_POST['userid']);
            $note = dbase::globalMagic($_POST['note']);
            $authorid = dbase::globalMagic($_SESSION['userid']);
            
            //validate data
            
            $validationResponse = validateDataEdit($userid,$note);
            

                
            if ($validationResponse['validAck']=='ok'){
                if (Admin::addUserNote($userid,$note,$authorid)){
                    
           
                    $dataArray = array("Ack"=>"success", "Msg"=>"Your note has been added.");
                  
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
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to add new notes");
    
}

echo json_encode($dataArray);
function validateDataEdit($userid,$note){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    if (!is_numeric($userid)){
        
        $validArray['useridAck']  = "fail";
        $validArray['useridMsg']  = "Oops! Try refreshing the page and trying again.";
        $validArray['validAck'] = "fail";
        
    }
    else{
        
        $validArray['useridAck'] = "ok";
        $validArray['useridMsg'] = "ok";
        
    }
    
    
    if (trim($note)==''){
        
        $validArray['noteAck'] = "fail";
        $validArray['noteMsg'] = "enter the note content.";
        $validArray['validAck'] = "fail";
        
    }
    else{
        
        $validArray['noteAck'] = "ok";
        $validArray['noteMsg'] = "ok";
        
    }
  
    
    return $validArray;
    
}

?>