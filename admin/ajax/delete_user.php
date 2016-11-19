<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        if (ALLOW_DELETE){
                $postList = array("userid");
              
                if (general::globalIsSet($_POST,$postList)){
        
                    
                    $userid = dbase::globalMagic($_POST['userid']);
        
                    
                    
                    //validate data
                    
                    $validationResponse = validateDataEdit($userid);
                    
        
                        
                    if ($validationResponse['validAck']=='ok'){
                        if (Admin::deleteUser($userid)){
                            
                   
                            $dataArray = array("Ack"=>"success", "Msg"=>"User has been deleted.");
                            
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
                $dataArray = array("Ack"=>"fail", "Msg"=>"Deleting user accounts has been disabled by the system administrator.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to delete users");
    
}
echo json_encode($dataArray);

function validateDataEdit($userid){
    
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
 
    if (!is_numeric($userid)){
        $validArray['userid'] = "fail";
        $validArray['validAck'] = 'fail';
    }
    else{
        $validArray['userid'] = "ok";
    }
    
    
  


    
    return $validArray;
    
}

?>