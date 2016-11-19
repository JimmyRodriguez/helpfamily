<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
error_reporting(0);
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");
require_once(APP_INC_PATH."recaptchalib.php");

sessionsClass::sessionStart();

    if (REGISTER_ONLINE){
        if(isset($_POST['ad_account_type']))
            $account_type   = dbase::globalMagic($_POST['ad_account_type']);
        else
            $account_type = 1;
        if(USE_CAPTCHA && $account_type==1)
            $postList = array("ad_username","ad_password","ad_password_confirm","ad_email","ad_contact_me_real","ad_tandc_real","recaptcha_response_field","recaptcha_challenge_field","ad_account_type");
        else
            $postList = array("ad_username","ad_password","ad_password_confirm","ad_email","ad_contact_me_real","ad_tandc_real","ad_account_type");


        //$postList = array("username","p1","p2","email","contact","recaptcha_challenge_field","recaptcha_response_field","account_type");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            $account_type   = dbase::globalMagic($_POST['ad_account_type']);
            //clean up data before it goes in
            $username   = dbase::globalMagic($_POST['ad_username']);
            $password   = dbase::globalMagic($_POST['ad_password']);
            $password2  = dbase::globalMagic($_POST['ad_password_confirm']);
            $email      = dbase::globalMagic($_POST['ad_email']);
            $ipad       = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
            
            $browser    = general::getBrowser();
            $os         = general::getOS();
            
            $lang       = general::getLang();
            $country    = general::getCountry();
            
            $screenres  = general::getScreenRes();
            $openid = '';
            //$referal  = general::getReferInfo();
            
            $contact    = dbase::globalMagic($_POST['ad_contact_me_real']);
            $tandc    = dbase::globalMagic($_POST['ad_tandc_real']);
            
             if(USE_CAPTCHA && $account_type ==1){
                $recaptcha_challenge_field      =   dbase::globalMagic($_POST['recaptcha_challenge_field']);
                $recaptcha_response_field       =   dbase::globalMagic($_POST['recaptcha_response_field']);
            }
            else{
                $recaptcha_challenge_field      =   '';
                $recaptcha_response_field       =   '';
            }
            
            if (isset($_SESSION['refurl'])){
                //which it should be
                $search_engine_term         =   general::get_search_term_engine(dbase::globalMagic($_SESSION['refurl']));
                
                $searchengine               =   $search_engine_term['searchengine'];
                $searchterm                 =   $search_engine_term['searchterm'];
                
            }
            else{
                $searchengine='none';
                $searchterm='---';
                
            }
            
            //should really be set by now
            if(isset($_SESSION['landingpage'])){
                $landingpage                =   dbase::globalMagic($_SESSION['landingpage']);
            }
            else{
                $landingpage='none';
            }
            
            //normal user
            $group = 4;
            
            //block user on email/domain of email/referal?/or IPAD
            
            //validate data
            
            $validationResponse = validateDataEdit($username,$password,$password2,$email,$ipad,$_SESSION['refdomain'],  $_SESSION['refurl'],$recaptcha_challenge_field,$recaptcha_response_field,$account_type,$tandc);
     
            if ($validationResponse['validAck']=='ok'){
                if ($account_type==1){
                    $salt = general::generate_salt();
                    $password_hash = general::doubleSalt($password,$salt);
                
              
                    $acti_code = time();
                    $valid=0;
               
                    $keys_values = array(
                                "userid"=>"NULL",
                                "username"=>$username,
                                "screenname"=>$username,
                                "p_hash"=>$password_hash,
                                "s_hash"=>$salt,
                                "valid"=>$valid,
                                "acti_code"=>$acti_code,
                                "ipad"=>$ipad,
                                "date_joined"=>"now()",
                                "lastip"=>"no visit",
                                "last_visit"=>"",
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
                                "refid"=>dbase::globalMagic($_SESSION['refid']),
                                "refurl"=>dbase::globalMagic($_SESSION['refurl']),
                                "refdomain"=>dbase::globalMagic($_SESSION['refdomain']),
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
                                "authentication_source"=>"userbase"
                             
                             );
                
            
    
                    if (Admin::addUser($keys_values)){
                        
                   
                        $dataArray = array("Ack"=>"success", "Msg"=>"New user account created.","captcha"=>USE_CAPTCHA,"account_type"=>1);
                        
                       
                        
                    }
                    else{
                        
                        
                        $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, not sure what went wrong there!","captcha"=>USE_CAPTCHA);
                    }
                }
                else{
                  
                    
                      //get fee + group name
                        $key_values= array(
                               "*"=>''
                               );
                
                         //your premium group id number
                        $id_key = array(
                                        "groupid"=>$account_type
                                         );
                        
            
                    $dataArray = dbase::select_db_item($id_key,$key_values,'user_groups','success','fail',false);
                   
                    if($dataArray['Ack']=='success'){
                         //check if it is a premium group - the user has selected a preimum group
                         
                         //don't worry about someone sending another group ID value through as fees/membership cost are checked based on the ID in database
                       
                        if( $dataArray['data']['group_type']==2){
                       
                            //set session and show form
                            $_SESSION['reg_check']           = md5($username.$email.$account_type.$dataArray['data']['fee'].$dataArray['data']['name']);
                            $_SESSION['username_send']       = $username;
                            $_SESSION['pw1_send']            = $password;
                            $_SESSION['account_type']        = $account_type;
                            $_SESSION['groupname_send']      = $gname = $dataArray['data']['name'];
                            $_SESSION['price_send']          = $fee   = $dataArray['data']['fee'];
                            $_SESSION['email_send']          = $email;
                            
                         
                            
                            $form=" <div>
                                 <table style='width:100%; font-size:20px;' class='table'>
                                    <tr>
                                        <td>
                                        <strong>username:</strong>
                                        </td>
                                        <td>
                                        $username
                                        </td>
                                        <td>
                                        <strong>membership:</strong>
                                        </td>
                                        <td>
                                        $gname
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                     <td>
                                        <strong>email address:</strong>
                                        </td>
                                        <td>
                                        $email
                                        </td>
                                       
                                        <td>
                                        <strong>membership fee:</strong>
                                        </td>
                                        <td>".CUR_SYM." $fee
                                        </td>
                                        
                                    </tr>
                                 </table>                                 
                                 <form name='payment_confirm' method='post' id='payment_confirm' action='send_process.php'>
                                                 
                                                 <input type='hidden' name='username_send' id='username_send' value='$username'/>
                                                 <input type='hidden' name='email_send' id='email_send' value='$email'/>
                                                 <input type='hidden' name='price_send' id='price_send' value='$fee'/>
                                                 <input type='hidden' name='group_send' id='group_send' value='$account_type'/>
                                                 <input type='hidden' name='group_name' id='group_name' value='$gname'/>
                                                 <button type='submit' class='btn' data-loading-text=\"<i class='icon-repeat'></i>\"><i class='icon-check'></i>confim & pay</button>
                                 </form>
                                                          
                             </div>";
                            
                            
                            $dataArray = array("Ack"=>"success", "Msg"=>"Please confirm the details to the left","form"=>$form,"captcha"=>false,"account_type"=>$account_type);
                           
                        }
                        else{
                            $dataArray = array("Ack"=>"fail", "Msg"=>"Sorry, looks like an internal error type 002","captcha"=>false);

                        }
                    }
                    else{
                        $dataArray = array("Ack"=>"fail", "Msg"=>"Sorry, looks like an internal error type 001","captcha"=>false);
                    }
                    
                }
            }
            else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"Correct the errors and try again.", "validationErrors" =>$validationResponse,"captcha"=>USE_CAPTCHA);
            }
            
            
            
    
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
    }
    else{
        $dataArray = array("Ack"=>"fail", "Msg"=>"New registrations are currently offline.");
    }

echo json_encode($dataArray);

function validateDataEdit($username,$password,$password2,$email,$ipad, $domain,  $addressreferal,$recaptcha_challenge_field,$recaptcha_response_field,$account_type,$tandc){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    if(intval($tandc)!=1){
        $validArray['validAck'] = 'fail';
       
        $validArray['ad_tandc'] = 'Please read the terms and conditions';
    }
    
    
    $userNameResponse = validator::usernameValidate($username,0,0);
    
    if ($userNameResponse['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
        $validArray['ad_username'] = $userNameResponse['Msg'];
    }

    $passwordResponse = validator::passwordValidate($password,$password2,0);
    
    if ($passwordResponse['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
        $validArray['ad_password_confirm'] = $passwordResponse['Msg'];
    }

    $emailResponse = validator::emailValidate($email,0,0);
    
    if ($emailResponse['Ack']=='fail'){
        $validArray['validAck'] = 'fail';
        
        $validArray['ad_email'] = $emailResponse['Msg'];
    }
    else{
        
        //then move whole block in to validation class
        global $conn;
        $email_domain=explode("@",$email);
        $sql_where='';
        //really only the email domain area needs to be in this else statement
      /*
        types:  ip=1
                refdomain=5
                referurl=4
                email:3
                email domain:2
      
      */
        
        if(trim($addressreferal) !=''){
            $sql_where = " OR ( blockvalue = '$addressreferal' AND type=4 ) ";
        }
        
        if(trim($domain) !=''){
             $sql_where = " OR ( blockvalue = '$domain' AND type=5 ) ";
        }
        
        if(trim($email_domain[1]!='')){
            $sql_where = " OR ( blockvalue='".$email_domain[1]."' AND type=2 ) ";
        }
       
        $sqlBlock = " SELECT blockid FROM security_blocks WHERE (( blockvalue='$ipad' AND type=1 ) OR ( blockvalue='$email' AND type=3 ) $sql_where ) AND valid=1 AND blockarea IN (1,3) ";
                    
        $dataPostBack =  dbase::globalQueryPlus($sqlBlock,$conn,2);
          
       
        if ($dataPostBack[1]>0){
       
            $validArray['validAck'] = 'fail';
            $validArray['blockAck'] = 'fail';
            $validArray['blockMsg'] = 'could not register your account.';
            
        }
       
    }
    
    
    
    
   //echo "<br/><br/>".$recaptcha_challenge_field."<br/><br/>";
  //  echo $recaptcha_response_field."<br/><br/>";
    if (USE_CAPTCHA && $account_type ==1){
        $resp = recaptcha_check_answer(RECAPKEY,
                                    $_SERVER["REMOTE_ADDR"],
                                    $recaptcha_challenge_field,
                                    $recaptcha_response_field);
       // var_dump($resp);
        if (!$resp->is_valid) {
          
            $validArray['validAck'] = 'fail';
        
            $validArray['ad_captcha'] = 'You got the word wrong.';
          
        } 
    }
    

    
    return $validArray;
    
}

?>