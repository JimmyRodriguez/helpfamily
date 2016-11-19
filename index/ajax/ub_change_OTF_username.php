<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind(false)){

        $postList = array("ed_username");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
          
            $newusername = dbase::globalMagic($_POST['ed_username']);
            $userid = dbase::globalMagic($_SESSION['userid']);
            
            //validate data
            
            $validationResponse = validateDataEdit($newusername);
        
            if ($validationResponse['validAck']=='ok'){
            
               
                  
                     
        
                    if (User::change_otf_username($newusername,$userid)){
                        
                  
                        $dataArray = array("Ack"=>"success", "Msg"=>"Your changes have been saved.");
                        
                    
                        
                    }
                    else{
                        
                  
                        $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, look like something went wrong! Try clicking save again.");
                    }
            }
            else{
                unset($validationResponse['validAck']);
                $dataArray = array("Ack"=>"fail", "Msg"=>"Correct the errors and try again.", "validationErrors" =>$validationResponse);
            }
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit your username.");
    
}
echo json_encode($dataArray);

function validateDataEdit($username){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
   
   $userNameResponse = validator::usernameValidate($username,0,0);
    
    if ($userNameResponse['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
        
        $validArray['ed_username'] = $userNameResponse['Msg'];
    }
    
   
    
    
    
    
    

    
    return $validArray;
    
}

?>