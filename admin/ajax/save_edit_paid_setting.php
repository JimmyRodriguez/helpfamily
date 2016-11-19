<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("userid","paid");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

          

            
            //clean up data before it goes in
            
            
            $userid             = dbase::globalMagic($_POST['userid']);
            $paid             = dbase::globalMagic($_POST['paid']);
            
            
            if ($paid == 0 || $paid == 1){
            
                $key_values = array(
                                    "paid"=>$paid
                                    );
                
                $id_key = array(
                                "userid"=>$userid
                                );
                
                $dataArray = dbase::edit_db_item($id_key,$key_values,"user_table","Your changes have been saved","Oops, look like something went wrong! Try clicking save again.");    
                        
                    
            }
            else{
                $dataArray = array("Ack"=>"validationFail", "Msg"=>"Refresh the page and try again.");
            }
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit users.");
    
}
echo json_encode($dataArray);

function validateDataEdit($username,$password,$email,$group,$userid,$country,$lang,$status,$os,$browser,&$regdate,&$lastdate,$lastip,$regip){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    $validArray['otherAck'] = 'ok';
    $validArray['otherMsg'] = '';
    
    $reg_date_response = validator::date_format_validate($regdate,true);
    
    if ($reg_date_response['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
    }
    else{
        $regdate = $reg_date_response['dbformat'];
    }
    
    $validArray['regdateAck'] = $reg_date_response['Ack'];
    $validArray['regdateMsg'] = $reg_date_response['Msg'];
    
    if (trim($lastdate)!=''){
        $last_date_response = validator::date_format_validate($lastdate,true);
    
        if ($last_date_response['Ack']=='fail'){
            $validArray['validAck'] = 'fail';
        }
        else{
            $lastdate = $last_date_response['dbformat'];
        }
        
        $validArray['lastdateAck'] = $last_date_response['Ack'];
        $validArray['lastdateMsg'] = $last_date_response['Msg'];
    }
    else{
        //ignore as not required field
        $validArray['lastdateAck'] = 'ok';
        $validArray['lastdateMsg'] = 'ok';
    }
    /* - appears filter for ip is not working - investigate and fix*/
    /*if (trim($lastip)!=''){
        if (validator::ip_valid($lastip)){
             $validArray['lastipAck'] = 'ok';
             $validArray['lastipMsg'] = 'ok'; 
        }
        else{
            $validArray['lastipAck'] = 'fail';
            $validArray['lastipMsg'] = 'ip address format is incorrect'; 
        }

    }
    else{
        //ignore as not required field
        $validArray['lastipAck'] = 'ok';
        $validArray['lastipMsg'] = 'ok';
    }
    
    if (trim($regip)!=''){
        if (validator::ip_valid($lastip)){
             $validArray['regipAck'] = 'ok';
             $validArray['regipMsg'] = 'ok'; 
        }
        else{
            $validArray['regipAck'] = 'fail';
            $validArray['regipMsg'] = 'ip address format is incorrect'; 
        }

    }
    else{
        //ignore as not required field
        $validArray['regipAck'] = 'ok';
        $validArray['regipMsg'] = 'ok';
    }
    */
    
    $userNameResponse = validator::usernameValidate($username,1,$userid);
    
    if ($userNameResponse['Ack']=='fail' || $userid==0){
        $validArray['validAck'] = 'fail';
    }
    
    $validArray['usernameAck'] = $userNameResponse['Ack'];
    $validArray['usernameMsg'] = $userNameResponse['Msg'];
    
    if (trim($password)!='false'){
        $passwordResponse = validator::passwordValidate($password,"",1);
    
        if ($passwordResponse['Ack']=='fail'){
            $validArray['validAck'] = 'fail';
        }
        $validArray['passwordAck'] = $passwordResponse['Ack'];
        $validArray['passwordMsg'] = $passwordResponse['Msg'];
    }
    else{
        $validArray['passwordAck'] = 'ok';
        $validArray['passwordMsg'] = 'ok';
    }
    
    
    
    $emailResponse = validator::emailValidate($email,1,$userid);
    
    if ($emailResponse['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
    }
    
    $validArray['emailAck'] = $emailResponse['Ack'];
    $validArray['emailMsg'] = $emailResponse['Msg'];
    
    if (!is_numeric($group) || $group==-9){
    
       
        $validArray['validAck'] = 'fail';
        $validArray['groupAck'] = 'fail';
        $validArray['otherAck'] = 'fail';
        $validArray['otherMsg'] = 'Oops, try refreshing the page and trying again.';
        
    }
    else{
        
        $validArray['groupAck'] = 'ok';
        $validArray['groupMsg'] = 'ok';

    }
    
    if (trim($country)=='' ){
        $validArray['validAck'] = 'fail';
        $validArray['countryAck'] = 'fail';
         $validArray['otherAck'] = 'fail';
        $validArray['otherMsg'] = 'Oops, try refreshing the page and trying again.';
    }
    else{
        $validArray['countryAck'] = 'ok';
        $validArray['countryMsg'] = 'ok';
    }
    
    if (trim($lang)=='' ){
        $validArray['validAck'] = 'fail';
        $validArray['langAck'] = 'fail';
         $validArray['otherAck'] = 'fail';
        $validArray['otherMsg'] = 'Oops, try refreshing the page and trying again.';
    }
    else{
        $validArray['langAck'] = 'ok';
        $validArray['langMsg'] = 'ok';
    }
    
    if (!is_numeric($status)){
    
       
        $validArray['validAck'] = 'fail';
        $validArray['statusAck'] = 'fail';
         $validArray['otherAck'] = 'fail';
        $validArray['otherMsg'] = 'Oops, try refreshing the page and trying again.';
        
    }
    else{
        
        $validArray['statusAck'] = 'ok';
        $validArray['statusMsg'] = 'ok';

    }
    
     if (trim($os)==''){
    
       
        $validArray['validAck'] = 'fail';
        $validArray['osAck'] = 'fail';
         $validArray['otherAck'] = 'fail';
        $validArray['otherMsg'] = 'Oops, try refreshing the page and trying again.';
        
    }
    else{
        
        $validArray['osAck'] = 'ok';
        $validArray['osMsg'] = 'ok';

    }
    
     if (trim($browser)==''){
    
       
        $validArray['validAck']         = 'fail';
        $validArray['browserAck']       = 'fail';
        $validArray['otherAck']         = 'fail';
        $validArray['otherMsg']         = 'Oops, try refreshing the page and trying again.';
        
    }
    else{
        
        $validArray['browserAck'] = 'ok';
        $validArray['browserMsg'] = 'ok';

    }
   
    

    
    return $validArray;
    
}

?>