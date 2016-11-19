<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("group_name","short_desc","group_type","group_fee","group_expire");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            $groupName = dbase::globalMagic($_POST['group_name']);
            $groupdesc = dbase::globalMagic($_POST['short_desc']);
            $group_expire = dbase::globalMagic($_POST['group_expire']);
            $group_type = dbase::globalMagic($_POST['group_type']);
            $group_fee = dbase::globalMagic($_POST['group_fee']);
            $group_fee = (is_numeric($group_fee))?$group_fee:0;
            //validate data
            
          
            $validationResponse = validateDataEdit($groupName,$group_expire);
            
        
                
            if ($validationResponse['validAck']=='ok'){
                if (Admin::addNewGroup($groupName, $groupdesc,$group_type,$group_fee,$group_expire)){
                    
                
                    $dataArray = array("Ack"=>"success", "Msg"=>"New user group saved.");
                    
                }
                else{
                    
                
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Oops! Not sure what went wrong there. Refresh the page and try again.");
                }
            }
            else{
                
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
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit this group");
    
}
echo json_encode($dataArray);

function validateDataEdit($groupName,$group_expire){
    
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    

    if (trim($groupName) == ""){
    
       
        $validArray['validAck'] = 'fail';
        $validArray['nameAck'] = 'fail';
        $validArray['nameMsg'] = 'enter the a name for this user group.';
        
    }
    else{
        
        $validArray['nameAck'] = 'ok';
        $validArray['nameMsg'] = 'ok';

    }

    if (!is_numeric($group_expire) || $group_expire==0){
    
       
        $validArray['validAck'] = 'fail';
        $validArray['groupexpireAck'] = 'fail';
        $validArray['groupexpireMsg'] = 'Number of days should be greater than zero.';
        
    }
    else{
        
        $validArray['groupexpireAck'] = 'ok';
        $validArray['groupexpireMsg'] = 'ok';

    }
  

 
  
   
    
    return $validArray;
    
}

?>