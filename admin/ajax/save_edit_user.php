<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("refdomain","regip","regdate","lastdate","lastip","username","password","email","group","userid","country","lang","refid","refurl","status","os","browser","contact","phone");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

          

            
            //clean up data before it goes in
            $username           = dbase::globalMagic($_POST['username']);
            $password           = dbase::globalMagic($_POST['password']);
            $email              = dbase::globalMagic($_POST['email']);
          
            $groupid            = dbase::globalMagic($_POST['group']);
            
            $userid             = dbase::globalMagic($_POST['userid']);
            
            $country            = dbase::globalMagic($_POST['country']);
            $lang               = dbase::globalMagic($_POST['lang']);
            $browser            = dbase::globalMagic($_POST['browser']);
            $os                 = dbase::globalMagic($_POST['os']);
            
            $regip              = dbase::globalMagic($_POST['regip']);
            $regdate            = dbase::globalMagic($_POST['regdate']);
            $lastdate           = dbase::globalMagic($_POST['lastdate']);
            $lastip             = dbase::globalMagic($_POST['lastip']);
            
          // var_dump(validator::date_format_validate($regdate,true));
            
            $refid              = dbase::globalMagic($_POST['refid']);
            $refurl             = dbase::globalMagic($_POST['refurl']);
            $domain             = dbase::globalMagic($_POST['refdomain']);
            
            //give admin more control else use below
            //$domain             = general::getDomain($refurl);
            
            $status             = dbase::globalMagic($_POST['status']);
            
            $phone              = dbase::globalMagic($_POST['phone']);
            $contact            = dbase::globalMagic($_POST['contact']);
            
            if ($status==-9){
                //active
                $status=1;
            }
            
            //set unknowns if user does not select a setting
            if ($country==-9){
                $country='ZZ';
            }
            
            if ($lang==-9){
                $lang='ool';
            }
            
            if ($browser==-9){
                $browser='OBW';
            }
            
            if ($os==-9){
                $os='OOS';
            }
            
            if (trim($phone)==''){
                $phone = 'N/A';
            }
            
            
            //validate data
            
            $validationResponse = validateDataEdit($username,$password,$email,$groupid,$userid,$country,$lang,$status,$os,$browser,$regdate,$lastdate,$lastip,$regip);
            
            
            if ($validationResponse['validAck']=='ok'){
            
                if (trim($password)!='false'){
                        $salt = general::generate_salt();
                        $phash = general::doubleSalt($password,$salt);
                }
                else{
                        $salt = '';
                        $phash = ''; 
                }
                  
                     
                
                    if (Admin::editUser($email,$phash,$password,$salt,$groupid,$username,$userid,$country,$lang,$refid,$refurl,$status,$os,$browser,$contact,$phone,$domain,$lastip,$lastdate,$regip,$regdate)){
                        
                    
                        $dataArray = array("Ack"=>"success", "Msg"=>"Your changes have been saved.");
                        
                      
                        
                    }
                    else{
                        
                       
                        $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, look like something went wrong! Try clicking save again.");
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