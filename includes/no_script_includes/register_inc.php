<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/


//register:
/*
 set up cheapo captcha as re-captcha looks bad in non-js mode (default styling). You may want to change this to
 something a little more robust or play with re-captcha to make it look nicer
*/
    if (!isset($_SESSION['ub_rand1_nojs'])){
        setcaptcha();
    }
function setcaptcha(){

$_SESSION['ub_rand1_nojs'] = mt_rand(10, 100);
$_SESSION['ub_rand2_nojs'] = mt_rand(10, 100);

$rand_operator = mt_rand(1,8);

switch ($rand_operator){
    //left out divide & multiply as that may get a bit difficult and prevent registrations
    case 1:
        $_SESSION['ub_op_nojs_txt'] = 'minus';
        $_SESSION['ub_op_nojs_val'] = 1;
        break;
    case 2:
        $_SESSION['ub_op_nojs_txt'] = 'subtract';
        $_SESSION['ub_op_nojs_val'] = 1;
        break;
    case 3:
        $_SESSION['ub_op_nojs_txt'] = 'take away';
        $_SESSION['ub_op_nojs_val'] = 1;
        break;
    case 4:
        $_SESSION['ub_op_nojs_txt'] = '-';
        $_SESSION['ub_op_nojs_val'] = 1;
        break;
    case 5:
        $_SESSION['ub_op_nojs_txt'] = 'add';
        $_SESSION['ub_op_nojs_val'] = 2;
        break;
    case 6:
        $_SESSION['ub_op_nojs_txt'] = 'sum';
        $_SESSION['ub_op_nojs_val'] = 2;
        break;
    case 7:
        $_SESSION['ub_op_nojs_txt'] = 'plus';
        $_SESSION['ub_op_nojs_val'] = 2;
        break;
    case 8:
        $_SESSION['ub_op_nojs_txt'] = '+';
        $_SESSION['ub_op_nojs_val'] = 2;
    
        break;
    
    
    /*
    
    case 9:
        $_SESSION['ub_op_nojs_txt'] = 'times';
        $_SESSION['ub_op_nojs_val'] = 3;
        break;
    case 10:
        $_SESSION['ub_op_nojs_txt'] = 'multiply';
        $_SESSION['ub_op_nojs_val'] = 3;
        break;
    case 11:
        $_SESSION['ub_op_nojs_txt'] = 'x';
        $_SESSION['ub_op_nojs_val'] = 3;
        break;
    case 12:
        $_SESSION['ub_op_nojs_txt'] = 'divide';
        $_SESSION['ub_op_nojs_val'] = 4;
        break;
    case 13:
        $_SESSION['ub_op_nojs_txt'] = '/';
        $_SESSION['ub_op_nojs_val'] = 4;
        break;
 
    */
   
}



}

if(isset($_POST['nojs_register'])){
    $pass_msg_reg = '';
    $user_msg_reg = '';
    $email_msg_reg = '';
    $captcha_msg_reg = '';
    $pass_alert_reg = '';
    $user_alert_reg = '';
    $email_alert_reg = '';
    $captcha_alert_reg = '';
    $reg_msg = '';
    
    $valid = '';
    if (REGISTER_ONLINE){  
        $username       = dbase::globalMagic($_POST['username_register_nojs']);
        $email          = dbase::globalMagic($_POST['email_register_nojs']);
        $password       = dbase::globalMagic(md5($_POST['p1_register_nojs']));
        $password2      = dbase::globalMagic(md5($_POST['p2_register_nojs']));
        
        $captcha_answer = dbase::globalMagic($_POST['captcha_register_nojs']);
        if(isset($_POST['contact_register_nojs'])){
            $contact        = (dbase::globalMagic($_POST['contact_register_nojs'])===false || dbase::globalMagic($_POST['contact_register_nojs'])=='false' )?0:1;
        
        }
        else{
            $contact=0;
        }
        
        
        /* stats data - please note: visitor tracking won't work without js enabled*/
        
        $ipad       = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
                
        $browser    = general::getBrowser();
        $os         = general::getOS();
        
        $lang       = general::getLang();
        $country    = general::getCountry();
        
        $screenres  = general::getScreenRes();
        
        if (isset($_SESSION['refurl'])){
           
            $search_engine_term         =   general::get_search_term_engine(dbase::globalMagic($_SESSION['refurl']));
            
            $searchengine               =   $search_engine_term['searchengine'];
            $searchterm                 =   $search_engine_term['searchterm'];
            
            $addressreferal = $_SESSION['refurl'];
            $domain = $_SESSION['refdomain'];
            
        }
        else{
            $searchengine='none';
            $searchterm='---';
            
            $addressreferal = '';
            $domain = '';
            
        }
        
        //should really be set by now
        if(isset($_SESSION['landingpage'])){
            $landingpage                =   htmlentities(dbase::globalMagic($_SESSION['landingpage']));
        }
        else{
            $landingpage='none';
        }
        
        
        $group = 4;
        
        
        if (USE_CAPTCHA){
            switch ($_SESSION['ub_op_nojs_val']){
                case 1:
                    if(($_SESSION['ub_rand1_nojs'] - $_SESSION['ub_rand2_nojs'])!=$captcha_answer){
                        
                        $valid = 'fail';
                        $captcha_alert_reg = '';
                        $captcha_msg_reg = "maybe time to get that calculator out";
                    }
                    break;
                case 2:
                    if(($_SESSION['ub_rand1_nojs'] + $_SESSION['ub_rand2_nojs'])!=$captcha_answer){
                        
                        $valid = 'fail';
                        $captcha_alert_reg = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
                        $captcha_msg_reg = "maybe time to get that calculator out";
                    }
                    break;
            }
        }
        
        $userNameResponse = validator::usernameValidate($username,0,0);
        
        if ($userNameResponse['Ack']=='fail'){
            $valid = 'fail';
            $user_alert_reg = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
            $user_msg_reg = $userNameResponse['Msg'];
        }
        
      
        $passwordResponse = validator::passwordValidate($password,$password2,0);
        
        if ($passwordResponse['Ack']=='fail'){
            $valid = 'fail';
            $pass_alert_reg = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
            $pass_msg_reg = $passwordResponse['Msg'];
        }
        
        $emailResponse = validator::emailValidate($email,0,0);
        
        if ($emailResponse['Ack']=='fail'){
            $valid = 'fail';
            $email_alert_reg = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
            $email_msg_reg = $emailResponse['Msg'];
      
        }
        else{
            //need to do check against blocks
            //refer needs to be refined so user can select if referal or domain referal
            
            //need to break down the email into domain and referal in to add/domain referal values
            
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
             
                $valid = 'fail';
           
                $reg_msg = 'could not register your account.';
                
            }
           
        }
        
        if ($valid !='fail' && trim($reg_msg)==''){
            //we can add
            $salt = general::generate_salt();
            $password_hash = general::doubleSalt($password,$salt);
    
            $acti_code = time();
            $valid=0;
            $openid = 'userbase';
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
                        
                
                header('Location: ' . 'thankyou.php');
                //$reg_msg='New user account created.';
               
             
                
            }
            else{
                
                $reg_msg='Oops, not sure what went wrong there!';
               
        
            }
            
        }
        else{
            if(trim($reg_msg)==''){
               $reg_msg='please correct the errors and try again.';
             
            }
        }
        
         setcaptcha();
    }
    else{
        $reg_msg = 'New registrations are currently off line.';
    }
    
}else{
    $pass_msg_reg = '';
    $user_msg_reg = '';
    $email_msg_reg = '';
    $captcha_msg_reg = '';
    $pass_alert_reg = '';
    $user_alert_reg = '';
    $email_alert_reg = '';
    $captcha_alert_reg = '';
    
    $reg_msg = '';
    
     setcaptcha();
     
}

?>