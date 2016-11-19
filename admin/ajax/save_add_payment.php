<?php
require_once("../../config/config_global.php");
require_once("../../includes/lightworks_functions.php");
require_once("../../includes/bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("amount","userid","comment");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            
            $amount             = dbase::globalMagic($_POST['amount']);
            $userid             = dbase::globalMagic($_POST['userid']);
            $comment            = dbase::globalMagic($_POST['comment']);
            
     
            
            $ipad               = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
            //$site               = 'nadlabs';
            //$siteid             = 1;
                //validate data
            
                $validationResponse = validateDataEdit($amount,$userid);
            
                //check any half fails - is comments and published data elements
                
           if ($validationResponse['validAck']=='ok'){
                if (Admin::savePayment($amount,$userid,$ipad,$comment)){
                    
                    //all went well
                    $dataArray = array("Ack"=>"success", "Msg"=>"new payment data added.");
                    
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
function validateDataEdit($amount,$userid){
    
 
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
    
    
    if (!is_numeric($amount)){
        
        $validArray['amountAck']  = "fail";
        $validArray['amountMsg']  = "- payment value should be numeric. <br/>";
        $validArray['validAck']    = "fail";
        
    }
    else{
        
        $validArray['amountAck']  = "ok";
        $validArray['amountMsg']  = "ok";
        
    }
    
    
    return $validArray;
    
}

?>