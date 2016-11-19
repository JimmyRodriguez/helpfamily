<?php
require_once("../../config/config_global.php");
require_once("../../includes/lightworks_functions.php");
require_once("../../includes/bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("userid","limit");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            $userid             = dbase::globalMagic($_POST['userid']);
            
            $limit              = dbase::globalMagic($_POST['limit']);

           
            
           
            $limit = (intval($limit)*5).",5";
            
            $validationResponse = validateDataEdit($userid);
            
                
                
            if ($validationResponse['validAck']=='ok'){
                $responseData = Admin::getFeeDate($userid);
                        if ($responseData==false)
                            $responseData=-9;
                            
                $paymentData = Admin::getPaymentHistory($userid,$limit,1,true);
                if ($paymentData['Ack']=='success'){
                    
                    //get payments repeater
                        $repeater = general::getFile ("payments_repeater.php");
                    
                        
                            
                        
                       
                    
                    //all went well
                        $dataArray = array("Ack"=>"success", "Msg"=>"","data"=>$paymentData['data'],"total_count"=>$paymentData['total_count'],"repeater"=>$repeater,"date_data"=>$responseData);
                    
                }
                else{
                    
                    //all went wrong
                    //first in each json is error msg/status message
                    $dataArray = array("Ack"=>"fail", "Msg"=>"No payment records found.","date_data"=>$responseData);
                }
            }else{
                
                $dataArray = array("Ack"=>"validationFail", "Msg"=>"There appears to be a problem. Try refreshing the page and trying again.", "validationdata" =>$validationResponse);
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
function validateDataEdit($userid){
    
 
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
    
 
 
    
    
    return $validArray;
    
}

?>