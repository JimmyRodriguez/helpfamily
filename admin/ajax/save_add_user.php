<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("username","password","email","status","group","contact","refid","refurl","refdomain","phone","country","lang","browser","os");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
            //clean up data before it goes in
            $username = dbase::globalMagic($_POST['username']);
            $password = dbase::globalMagic($_POST['password']);
            $email = dbase::globalMagic($_POST['email']);
            $status = dbase::globalMagic($_POST['status']);
            $group = dbase::globalMagic($_POST['group']);
            $contact = dbase::globalMagic($_POST['contact']);
            
            $refid      = dbase::globalMagic($_POST['refid']);
            $refurl     = dbase::globalMagic($_POST['refurl']);
            $refdomain  = dbase::globalMagic($_POST['refdomain']);
            $phone      = dbase::globalMagic($_POST['phone']);
            
            $country    = dbase::globalMagic($_POST['country']);
            $lang       = dbase::globalMagic($_POST['lang']);
            $browser    = dbase::globalMagic($_POST['browser']);
            $os         = dbase::globalMagic($_POST['os']);
            $openid = '';
                $screenres = 'not set';
                $searchengine = 'none';
                $searchterm = '---';
                $landingpage='admin-cp';
                
           if ($status==-9){
                //active
                $status=1;
           }
           
           if ($contact==-9){
                //no contact
                $contact=0;
           }
            
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
            
            if ($refdomain==''){
                $refdomain = 'admin-created';
            }
            if ($refurl==''){
                $refurl = 'admin-created';
            }
            
            
            //$contact = 1;
            
            
            $validationResponse = validateDataEdit($username,$password,$email,$group,$country,$lang,$status,$os,$browser);
          
            if ($validationResponse['validAck']=='ok'){
                
                
                
                $salt = general::generate_salt();
                $password_hash = general::doubleSalt($password,$salt);
                
                
                
                
                if ($status==0){
                        $acti_code = time();
                 
                }
                else if ($status==1){
                        $acti_code = 'admin-activated';
                    
                }
                else{
                        $acti_code = 'admin-banned-on-create';
                }
                
                $ipad = $_SERVER['REMOTE_ADDR'];
                
                $keys_values = array(
                                "userid"=>"NULL",
                                "username"=>$username,
                                "screenname"=>$username,
                                "p_hash"=>$password_hash,
                                "s_hash"=>$salt,
                                "valid"=>$status,
                                "acti_code"=>$acti_code,
                                "ipad"=>$ipad,
                                "date_joined"=>"now()",
                                "lastip"=>"no visit",
                                "last_visit"=>"0000-00-00 00:00:00",
                                "email"=>$email,
                                "gravtar_email"=>"",
                                "usergroup"=>$group,
                                "temppass"=>"",
                                "tpdate"=>"",
                                "tpip"=>"",
                                "tp_flag"=>0,
                                "browser"=>$browser,
                                "os"=>$os,
                                "lang"=>$lang,
                                "country"=>$country,
                                "refid"=>$refid,
                                "refurl"=>$refurl,
                                "refdomain"=>$refdomain,
                                "contact"=>$contact,
                                "fname"=>"NULL",
                                "sname"=>"NULL",
                                "mobilenum"=>"N/A",
                                "screenres"=>$screenres,
                                "searchengine"=>$searchengine,
                                "searchterm"=>$searchterm,
                                "smstok"=>"",
                                "smsip"=>"",
                                "smstimedate"=>"",
                                "oneuse"=>"",
                                "landingpage"=>$landingpage,
                                "openidurl"=>$openid,
                                "authentication_source"=>"userbase",
                                "img_url"=>DEFAULT_IMG_LOCATION,
                                "img_flag"=>"0",
                                "cookie_id"=>'none',
                                "cookie_salt"=>'none',
                                "cookie_expire"=>"now"
                             
                             );
                
    
                if (Admin::addUser($keys_values)){

                    
                   
                   
               
                    $dataArray = array("Ack"=>"success", "Msg"=>"New user account created.");
                    
             
                    
                }
                else{
                    
          
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, not sure what went wrong there!");
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
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to create new accounts");
    
}
echo json_encode($dataArray);

function validateDataEdit($username,$password,$email,$group,$country,$lang,$status,$os,$browser){
    
                        
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    $validArray['otherAck'] = 'ok';
    $validArray['otherMsg'] = '';
    
   
    
    $userNameResponse = validator::usernameValidate($username,0,0);
    
    if ($userNameResponse['Ack']=='fail'){
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
    
    
    
    $emailResponse = validator::emailValidate($email,0,0);
    
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