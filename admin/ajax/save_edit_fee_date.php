<?php
require_once("../../config/config_global.php");
require_once("../../includes/lightworks_functions.php");
require_once("../../includes/bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("fee","userid","date");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            $fee        = dbase::globalMagic($_POST['fee']);
            $userid     = dbase::globalMagic($_POST['userid']);
            $date       = dbase::globalMagic($_POST['date']);

            
                //validate data
            
                $validationResponse = validateDataEdit($fee,$date,$userid);
            
                //check any half fails - is comments and published data elements
                
           if ($validationResponse['validAck']=='ok'){
                if (Admin::saveNewFeeDate($userid,$fee,$date)){
                    
                    //all went well
                    $dataArray = array("Ack"=>"success", "Msg"=>"fee & renewal date updated");
                    
                }
                else{
                    
                    //all went wrong
                    //first in each json is error msg/status message
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Oops! Not sure what went wrong there. Refresh the page and try again.");
                }
            }else{
                
                $dataArray = array("Ack"=>"validationFail", "Msg"=>"- Correct the errors and try again.", "validationdata" =>$validationResponse);
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
function validateDataEdit($fee,$date,$userid){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    if (!is_numeric($userid)){
        
        $validArray['useridAck']  = "fail";
        $validArray['opsMsg']  = "Oops! Try refreshing the page and trying again.";
        $validArray['validAck'] = "fail";
        
    }
    else{
        
        $validArray['useridAck'] = "ok";
        $validArray['useridMsg'] = "ok";
        
    }
    
    if (!is_numeric($fee) ||  $fee<=0){
        
        $validArray['feeAck']  = "fail";
        $validArray['feeMsg']  = "- fee value should be numeric and greater than zero. <br/>";
        $validArray['validAck']    = "fail";
        
    }
    else{
        
        $validArray['feeAck']  = "ok";
        $validArray['feeMsg']  = "ok";
        
    }
    
    
    $dateArray = explode('/',$date);
    
    if (count($dateArray)==3){
        if (is_numeric($dateArray[0]) && is_numeric($dateArray[1]) && is_numeric($dateArray[2]))
                if (trim($date)=='' || !checkdate($dateArray[1],$dateArray[0],$dateArray[2])){
                    
                    $validArray['dateAck'] = "fail";
                    $validArray['dateMsg'] = "- date should be in DD/MM/YYYY format.<br/>";
                    $validArray['validAck'] = "fail";
                    
                }
                else{
                    
                    $validArray['dateAck'] = "ok";
                    $validArray['dateMsg'] = "ok";
                    
                }
        else{
                $validArray['dateAck'] = "fail";
                $validArray['dateMsg'] = "- date should be in DD/MM/YYYY format.<br/>";
                $validArray['validAck'] = "fail";
        }
    }
    else{
        $validArray['dateAck'] = "fail";
        $validArray['dateMsg'] = "- date should be in DD/MM/YYYY format. <br/>";
        $validArray['validAck'] = "fail";
    }
    
    return $validArray;
    
}

?>