<?php

/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/

class User{
   
   
     /*v1.3 START*/
    
 
 
     /*v1.3 END*/
     public static function get_smstok($username,$password){
         global $conn;
        //need to do final check if actual match of data
        
        //need to check if account is active
        //need to check if it's valid (not banned,blocked)
        $loginResponse = array();
        $sqlGetUser = "SELECT * FROM user_table WHERE LOWER(username)='".strtolower($username)."'"
                     ." AND (valid=1 OR valid=0) ";
                 // echo  $sqlGetUser;  
        $dataPostBack =  dbase::globalQuery($sqlGetUser,$conn,2);
      
        //make sure only one match - if more than (should not happen) then something went really wrong.
        if ($dataPostBack[1]==1){
            
            $userData = $dataPostBack[0];
            
            /*change the above SQL to allow checking
                of banned or block accounts
                if you want to show users that
               information on login failure.*/
            
            if ($userData['valid']==1){

                $salt = $userData["s_hash"];

                $encrypted = general::doubleSalt($password,$salt);
              // echo $encrypted.'--->'.$userData["p_hash"];
                if ($userData['tp_flag']==1 && $encrypted==$userData["temppass"]){
                    $passflag = true;
                    
                    /*
                        the following line will remove the temppass
                        this is means the temp pass is one use only - should tell
                        the user they must change their password on signing
                        
                        comment it out if you want the temp pass to run forever.
                        
                    */
                    //User::recoverLogin($userData['userid']);
                    //echo '1';
                }
                else if($encrypted==$userData["p_hash"]){
                    //design away you can use both password & temppass
                    $passflag = true;
                    
                    /*
                  
                     run this if you feel the temp pass should be removed on the first time
                     the correct password is entered - you should use this if you force
                     your users to change their passwords on entering via the temppass.
                    
                    */
                    //recoverLogin($userData['userid']);
                }
                else{
                    $passflag = false;
                }
                
               
                
              
                if ($passflag){
                    
                    //create session data
                    
                    
                
                    $smstok         = time();
                    
                   
                    
                    //do any other preference settings here like date formats etc
                    
                    
                    
                    $ipad = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
                    $sqlUpdateUser = "UPDATE user_table SET smstimedate=now(), smstok='$smstok', smsip='$ipad' "
                                         ." WHERE screenname='$username' ;";
                        
                    $dataPostBack =  dbase::globalQuery($sqlUpdateUser,$conn,1);
                    
                    if ($dataPostBack[1] != -1){
                      //send message to phone
                      $response = Admin::sendSMStoken($userData["mobilenum"],$userData["userid"]);
                      
                      if($response['Ack']=='success'){
                            $loginResponse['validAck']  =   true;
                            $loginResponse['validMsg']  =   'the security token has been sent to your phone.';
                        
                      }
                      else{
                            //you may want to log these issues as it could be out of credit or something else.
                            $loginResponse['validAck']  =   false;
                            $loginResponse['validMsg']  =   'Sorry, token not sent. Please try again later.';
                    
                      }
                      
                      
                    }
                    else{
                      $loginResponse['validAck']  =   false;
                      $loginResponse['validMsg']  =   'Sorry, could not send you the token. Please try again later.';
                    
                    }
                    
                }
                else{
                    
                    $loginResponse['validAck']  =   false;
                    $loginResponse['validMsg']  =   'Sorry, could not send you the token. Please check your details and try again.';
                    
                }
 
            }
            else{
                //inactive
                $loginResponse['validAck']  =   false;
                $loginResponse['validMsg']  =   'This account is awaiting activation.';
            }
 
        }
        else{
            $loginResponse['validAck']  =   false;
            $loginResponse['validMsg']  = 'Sorry, could not send you the token. Please check your details and try again.';
        }
        
        return $loginResponse;
        
    }
    
    public static function cookie_login(){
       global $conn;
          
          if (isset($_COOKIE['auth_ub'])){
               $now = date('Y\-m\-d h:i:s');
              
              
                    
                    
                         //login
                       
                              $cookie_array = explode('ub_ub_s',$_COOKIE['auth_ub']);
                              //1= token
                              $sql_cookie = "
                                                  SELECT *
                                                  FROM
                                                       user_table AS ut
                                                  WHERE
                                                       cookie_id='".dbase::globalMagic($cookie_array[0])."'
                                                       AND valid=1
                                             ";
                              $dataPostBack =  dbase::globalQuery($sql_cookie,$conn,2);
      
                            
                              if ($dataPostBack[1]==1){
                                   $cookie_token = hash_hmac('sha512', $cookie_array[1], $dataPostBack[0]['cookie_salt']);
                                   if($cookie_token == $cookie_array[0]){
                                        
                                        
                                        
                                        
                                        if (strtotime($dataPostBack[0]['cookie_expire'])>=$now){
                                            //echo 'yeah';
                                             //login
                                             //create session data
                                                  $_SESSION['logintype']      = $dataPostBack[0]["authentication_source"];
                                                  $_SESSION['username']       = $dataPostBack[0]["screenname"];
                                                  $_SESSION['userid']         = $dataPostBack[0]["userid"];
                                                  $_SESSION['usergroup']      = $dataPostBack[0]["usergroup"];
                                                  $_SESSION['tempsalt']       = general::generate_salt();
                                                  $_SESSION['token']          = md5($_SERVER['HTTP_USER_AGENT'].$_SESSION['tempsalt']);
                                                  $_SESSION['timeout']        = time();
                                                  $_SESSION['stale']          = time()+300;
                                                  
                                                  
                                                  //need to create remember me cookie option - need to add this to a db table
                                                  
                                                  
                                                  $token=uniqid($_SESSION['userid'] , TRUE);
                                                  $cookie_token = hash_hmac('sha512', $token, $_SESSION['tempsalt']);
                                                  
                                                  $cookie_name = 'auth_ub';
                              
                                                  $cookie_time = (3600 * 24 * REMEMBER_DURATION);
                                                  
                                                  //need to add to db_table
                                              
                                                  // check to see if user checked box
                                                  
                                                  setcookie ($cookie_name, $cookie_token.'ub_ub_s'.$token, time()+$cookie_time, '/', 'localhost'  , FALSE, TRUE);
                                                  $sqlCookie = "UPDATE user_table SET cookie_id='$cookie_token', cookie_salt='".$_SESSION['tempsalt']."', cookie_expire=date_add(now(), INTERVAL ".REMEMBER_DURATION." DAY)"
                                                              ." WHERE userid='".$_SESSION['userid']."' ;";
                                                 
                                                  $dataPostBack =  dbase::globalQuery($sqlCookie,$conn,1);
                                                  //echo $sqlCookie;
                                                  if ($dataPostBack[1] != -1){
                                                    //may want to do something here?
                                                  }
                                                  else{
                                                    //or here if you need to log anything
                                                    //but for now if this fails, it just moves on.
                                                  }
                                                  
                              
                                                  
                                                  //do any other preference settings here like date formats etc
                                                  
                                                  
                                              
                                                  
                                                  $ipad = $_SERVER['REMOTE_ADDR'];
                                                  $sqlUpdateUser = "UPDATE user_table SET last_visit=now(), lastip='$ipad'  "
                                                                       ." WHERE userid='".$dataPostBack[0]['userid']."' ;";
                                                      
                                                  $dataPostBack =  dbase::globalQuery($sqlUpdateUser,$conn,1);
                                                  
                                                  if ($dataPostBack[1] != -1){
                                                    //may want to do something here?
                                                  }
                                                  else{
                                                    //or here if you need to log anything
                                                    //but for now if this fails, it just moves on.
                                                  }
                                             
                                       
                                                  return true;
                                             
                                        }
                                        else{
                                                  //expired - not logged in - delete any reference to the cookie and delete cookie
                                                  unset($_COOKIE['auth_ub']); 
                                                  $sqlCookie = "UPDATE user_table SET cookie_id='', cookie_salt='', cookie_expire='0000-00-00 00:00:00'"
                                                       ." WHERE userid='".$dataPostBack[0]['userid']."' ;";
                        
                                                  $dataPostBack =  dbase::globalQuery($sqlCookie,$conn,1);
                                                  //echo $sqlCookie;
                                                  if ($dataPostBack[1] != -1){
                                                    //may want to do something here?
                                                  }
                                                  else{
                                                    //or here if you need to log anything
                                                    //but for now if this fails, it just moves on.
                                                  }
                                            // echo 'no expired';
                                                  return false;
                                        }
                                        
                                             
                                        
                                   
                                   }
                                   else{
                                       // echo 'no match';
                                        //may want to log suspect activity here
                                        return false;
                                   }
                              }
                              else{
                                  // echo 'no find';
                                   return false;
                              }
                              
                         
                    
                    
                    
               
          }
          else{
              // echo 'no cooike';
               //no cookie found
               return false;//essentially do nothing
          }
    }
    
    
    public static function loginUser($username,$password,$sms,$smstok,$loc,$remember){
        
        
        if(isset($_SESSION['session_failed_login_count'])){
            if(intval($_SESSION['session_failed_login_count'])>=MAX_LOGIN_FAIL){
                 $loginResponse['validAck']  =   false;
                 $loginResponse['validMsg']  = 'Sorry, could not sign you in. Please check your details and try again.';
                //note, at this point no more logins are being logged or attempted
                User::failed_login($username,$password,$sms,$smstok,'max fail reached',$loc);
                return $loginResponse;
            }
        }
        
        
        global $conn;
        //need to do final check if actual match of data
        
        //need to check if account is active
        //need to check if it's valid (not banned,blocked)
        $loginResponse = array();
        $oneuse='';
        if($sms){
            
            if (SMSTOK=='24hour'){
                $sqlGetUser = "SELECT * FROM user_table WHERE LOWER(username)='".strtolower($username)."'"
                     ." AND (valid=1 OR valid=0) AND smstok='$smstok' AND smstimedate>DATE_SUB(NOW(),INTERVAL 1 DAY)";
            }
            else{
                $sqlGetUser = "SELECT * FROM user_table WHERE LOWER(username)='".strtolower($username)."'"
                     ." AND (valid=1 OR valid=0) AND smstok='$smstok' AND oneuse=0";
                     $oneuse=',oneuse = 1';
                     
            }
            //echo $sqlGetUser;
        }
        else{
            $sqlGetUser = "SELECT * FROM user_table WHERE LOWER(username)='".strtolower($username)."'"
                         ." AND (valid=1 OR valid=0) ";
        }
                 // echo  $sqlGetUser;  
        $dataPostBack =  dbase::globalQuery($sqlGetUser,$conn,2);
      
        //make sure only one match - if more than (should not happen) then something went really wrong.
        if ($dataPostBack[1]==1){
            
            $userData = $dataPostBack[0];
            
            /*change the above SQL to allow checking
                of banned or block accounts
                if you want to show users that
               information on login failure.*/
            
            if ($userData['valid']==1){

                $salt = $userData["s_hash"];

                $encrypted = general::doubleSalt($password,$salt);
              // echo $encrypted.'--->'.$userData["p_hash"];
                if ($userData['tp_flag']==1 && $encrypted==$userData["temppass"]){
                    $passflag = true;
                    
                    /*
                        the following line will remove the temppass
                        this is means the temp pass is one use only - should tell
                        the user they must change their password on signing
                        
                        comment it out if you want the temp pass to run forever.
                        
                    */
                    //User::recoverLogin($userData['userid']);
                    //echo '1';
                }
                else if($encrypted==$userData["p_hash"]){
                    //design away you can use both password & temppass
                    $passflag = true;
                    
                    /*
                  
                     run this if you feel the temp pass should be removed on the first time
                     the correct password is entered - you should use this if you force
                     your users to change their passwords on entering via the temppass.
                    
                    */
                    //recoverLogin($userData['userid']);
                }
                else{
                    $passflag = false;
                }
               // echo $encrypted."-->".$userData['p_hash'];
               
                
              
                if ($passflag){
                    
                    
                    
                    
                    
                    //create session data
                    $_SESSION['logintype']      = $userData["authentication_source"];
                    $_SESSION['username']       = $userData["screenname"];
                    $_SESSION['userid']         = $userData["userid"];
                    $_SESSION['usergroup']      = $userData["usergroup"];
                    $_SESSION['tempsalt']       = general::generate_salt();
                    $_SESSION['token']          = md5($_SERVER['HTTP_USER_AGENT'].$_SESSION['tempsalt']);
                    $_SESSION['timeout']        = time();
                    $_SESSION['stale']          = time()+300;
                    
                    
                    //need to create remember me cookie option - need to add this to a db table
                    
                    
                    $token=uniqid($_SESSION['userid'] , TRUE);
                    $cookie_token = hash_hmac('sha512', $token, $_SESSION['tempsalt']);
                    
                    $cookie_name = 'auth_ub';

                    $cookie_time = (3600 * 24 * REMEMBER_DURATION);
                    
                    //need to add to db_table
                
                    // check to see if user checked box
                    if ($remember) {
                         setcookie ($cookie_name, $cookie_token.'ub_ub_s'.$token, time()+$cookie_time, '/', 'localhost'  , FALSE, TRUE);
                         $sqlCookie = "UPDATE user_table SET cookie_id='$cookie_token', cookie_salt='".$_SESSION['tempsalt']."', cookie_expire=date_add(now(), INTERVAL ".REMEMBER_DURATION." DAY)"
                                     ." WHERE userid='".$_SESSION['userid']."' ;";
                        
                         $dataPostBack =  dbase::globalQuery($sqlCookie,$conn,1);
                         //echo $sqlCookie;
                         if ($dataPostBack[1] != -1){
                           //may want to do something here?
                         }
                         else{
                           //or here if you need to log anything
                           //but for now if this fails, it just moves on.
                         }
                    }

                    
                    //do any other preference settings here like date formats etc
                    
                    $loginResponse['validAck']  =   true;
                    $loginResponse['validMsg']  =   'You are signed in. Transfer in progress.';
                    
                    $ipad = $_SERVER['REMOTE_ADDR'];
                    $sqlUpdateUser = "UPDATE user_table SET last_visit=now(), lastip='$ipad' $oneuse "
                                         ." WHERE userid='".$userData["userid"]."' ;";
                        
                    $dataPostBack =  dbase::globalQuery($sqlUpdateUser,$conn,1);
                    
                    if ($dataPostBack[1] != -1){
                      //may want to do something here?
                    }
                    else{
                      //or here if you need to log anything
                      //but for now if this fails, it just moves on.
                    }
                    
                }
                else{
                    
                    $loginResponse['validAck']  =   false;
                    $loginResponse['validMsg']  =   'Please check your details and try again.';
                    
                    User::failed_login($username,$password,$sms,$smstok,'password check failed',$loc);
                }
 
            }
            else{
                //inactive
                $loginResponse['validAck']  =   false;
                $loginResponse['validMsg']  =   'This account is awaiting activation.';
            }
 
        }
        else{
            $loginResponse['validAck']  =   false;
            $loginResponse['validMsg']  = 'Sorry, could not sign you in. Please check your details and try again.';
            if ($sms){
                User::failed_login($username,$password,$sms,$smstok,'username or sms check failed',$loc);
            }
            else{
                User::failed_login($username,$password,$sms,$smstok,'username check failed',$loc);
            }
            
        }
        
        
        
        
      
        return $loginResponse;
        
    }
    
    public static function failed_login($username,$password,$sms,$smstok,$msg,$loc){
        
        if(LOG_FAIL_LOGIN){
            global $conn;
            
            //use xml logfile or database?
            
            $ipad = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
            if(isset($_SESSION['session_failed_login_count'])){
                $_SESSION['session_failed_login_count'] = intval($_SESSION['session_failed_login_count'])+1;
            }
            else{
                $_SESSION['session_failed_login_count'] = 1;
             
            }
            
            if (!isset($_SESSION['inital_failed_login'])){
                $_SESSION['inital_failed_login']=date("Y-m-d H:i:s");  
            }
            
            $_SESSION['latest_failed_login'] = date("Y-m-d H:i:s");  
            $country = general::getCountry();
            
            if (!isset($_SESSION['setid'])){
                $setid = 0;
            }
            else{
                $setid = $_SESSION['setid'];
            }
            
            if(isset($_SESSION['refurl'])){
                $refurl = dbase::globalMagic($_SESSION['refurl']);
            }
            else{
                $refurl = 'refering url not set';
            }
            
            /*$sql_fail = " INSERT INTO failed_login VALUES (NULL,'$loc','$username','$password','$sms','$smstok','$msg', "
                       ." '".$_SESSION['inital_failed_login']."','".$_SESSION['latest_failed_login']."','$country','$setid','$ipad','$refurl' )";
            
            $dataPostBack =  dbase::globalQuery($sql_fail,$conn,1);*/
            
            
               $keys_values = array(
                    
                                "failedid"=>"NULL",
                                "loc"=>$loc,
                                "username"=>$username,
                                "password"=>$password,
                                "sms"=>$sms,
                                "smstok"=>$smstok,
                                "msg"=>$msg,
                                "inital_attempt"=>dbase::globalMagic($_SESSION['inital_failed_login']),
                                "current_attempt"=>dbase::globalMagic($_SESSION['latest_failed_login']),
                                "country"=>$country,
                                "setid"=>$setid,
                                "ipad"=>$ipad,
                                "refurl"=>$refurl

                             );
        
    
               $dataPostBack = dbase::basic_queries("failed_login",false,$keys_values,"INSERT",false);
            
            
            if ($dataPostBack[1]==1){
                if (!isset($_SESSION['setid'])){
                   $_SESSION['setid'] = $dataPostBack[0];
                   $sql_setid = "UPDATE failed_login SET setid='".$dataPostBack[0]."'  WHERE failedid='".$dataPostBack[0]."'" ;
                   $dataPostBack =  dbase::globalQuery($sql_setid,$conn,3);
                }
                else{
                    
                }
                
               
                
                //return true;
            }
            else{
                //return false;
            }
        }
        
        //table - failedid, username,password,sms,smstok,msg,failcount,initalsessionfail,currentfail,country,setid
        
    }
    
    public static function change_otf_username($username,$userid){
          global $conn;
        
          $sqlChangeUN = 'UPDATE user_table SET username="'.$username.'",screenname="'.$username.'"  WHERE userid='.$userid ;
          
          $dataPostBack =  dbase::globalQuery($sqlChangeUN,$conn,3);
        
          if ($dataPostBack[1]!=-1){
               $_SESSION['username'] = $username;
               return true;
          }
          else{
               return false;
          }
     
     
    }
    
    public static function changePassword($ph,$sh,$userid){
        
        global $conn;
        
        $sqlChangePs = 'UPDATE user_table SET p_hash="'.$ph.'",s_hash="'.$sh.'"  WHERE userid='.$userid ;
        

        
        $dataPostBack =  dbase::globalQuery($sqlChangePs,$conn,3);
        
        if ($dataPostBack[1]!=-1){
            
            
            
            User::recoverLogin($userid);
            
            $sqlGetUser = "SELECT userid,username,email FROM user_table WHERE userid='$userid'";
            $dataPostBack =  dbase::globalQuery($sqlGetUser,$conn,2);
           
            
            if ($dataPostBack[1]==1){
            
                $userData = $dataPostBack[0];
                
                $emailfile = (!isset($_SESSION['js_enabled']))?NOJS_PASS_CHANGE_NO_HTML:PASS_CHANGE_NO_HTML;
                $content = general::getFile($emailfile);
            
                $content = str_replace('[[username]]',$userData['username'],$content);
                $content = str_replace('[[oursite]]',SITENAME,$content);
       
                $subject = 'Your password at '.SITENAME.' has been changed.';
                
                
               
                
                general::globalEmail($userData['email'], ADMIN_EMAIL, $content, $subject);
            }
            
            return true;
        
            /*
                run the following function to remove any temp password on this account
                in case the user followed through a 'forgot password' scenario.
                
            */
            
        }
        else{
            
            return false;
            
        }
        
        
    }
    
    public static function changeEmail($email,$userid){
        
        
        /*
         
            if you do not want the user to reactivate then use this SQL:
            
            $sqlChangeEmail = 'UPDATE user_table SET email="'.$email.'" WHERE userid='.$userid ;
            
            and remove the emailing part of the code
        
        
        */
        global $conn;
        $acti_code = time();
        $sqlChangeEmail = "UPDATE user_table SET email='$email', valid=0,acti_code='$acti_code'  WHERE userid='$userid'" ;
        

        
        $dataPostBack =  dbase::globalQuery($sqlChangeEmail,$conn,3);
        
        if ($dataPostBack[1]!=-1){
            
                
                    
                    $userData = $dataPostBack[0];
               
                    $emailfile = (!isset($_SESSION['js_enabled']))?NOJS_EMAIL_CHANGE_NO_HTML:EMAIL_CHANGE_NO_HTML;
                    $content = general::getFile($emailfile);
                    
                    $content = str_replace('[[username]]',$_SESSION['username'],$content);
                    $content = str_replace('[[oursite]]',SITENAME,$content);
                    
                    $content = str_replace('[[actiurl-sans-code]]',ACTIURL,$content);
                    $content = str_replace('[[actiurl]]',ACTIURL.'u='.md5($_SESSION['userid']).'&a='.$acti_code,$content);
                    
                    $content = str_replace('[[parta]]',md5($_SESSION['userid']),$content);
                    $content = str_replace('[[partb]]',$acti_code,$content);
                    
                    $subject = 'Your email address at '.SITENAME.' as been updated - please verify your email address';
                    
                    
                   
                    general::globalEmail($email, REG_EMAIL, $content, $subject);
                
            
            return true;
            
        }
        else{
            
            return false;
            
        }
        
        
    }
    
    public static function activateUser($userid,$activationcode,$emailfile){
        
          global $conn;
        //check activation code
        
        $sqlGetUser = "SELECT userid,username,email FROM user_table WHERE acti_code='$activationcode'";
        $dataPostBack =  dbase::globalQuery($sqlGetUser,$conn,2);
       
        
        if ($dataPostBack[1]==1){
            
            $userData = $dataPostBack[0];
            if (md5($userData['userid'])==$userid){
                $sqlActivate = "UPDATE user_table SET valid=1 WHERE userid='".$userData['userid']."' AND (valid=0 OR valid=1) AND acti_code='$activationcode'";
                $dataPostBackUpdate =  dbase::globalQuery($sqlActivate,$conn,3);
                
                if ($dataPostBackUpdate[1]==1){
                    //$content = general::getFile(CONGRATS_NO_HTML);
                    $content = general::getFile($emailfile);
                
                    $content = str_replace('[[username]]',$userData['username'],$content);
                    $content = str_replace('[[oursite]]',SITENAME,$content);
           
                    $subject = 'Account activated - '.SITENAME;
                    
                    
                   
                    
                    general::globalEmail($userData['email'], ADMIN_EMAIL, $content, $subject);
                
                    
                    
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
            
        }
        else{
            return false;
        }
        
        
    }
    
   
    
    public static function forgotPassword($emailOrUsername,$username_email){
        
        //do double md5? one to replicate js level md5?
          global $conn;
        //get userdata first, then use salt, then store data.
        
        
       
        
        if ($emailOrUsername==1){
           
            $sqlGetUser = 'SELECT * FROM user_table WHERE LOWER(email) = "'.strtolower($username_email).'"';
        }
        else{
          
            $sqlGetUser = 'SELECT * FROM user_table WHERE LOWER(screenname) = "'.strtolower($username_email).'"';
        }
        
        $dataPostBack =  dbase::globalQuery($sqlGetUser,$conn,2);
       
        
        if ($dataPostBack[1]==1){
            
                $userData = $dataPostBack[0];
                $email = $userData['email'];
                $username = $userData['screenname'];
                $salt =  $userData['s_hash'];
                
                //change temp password method as you need:
           
                
                
                $tempPass = time().str_replace('.','',$_SERVER['REMOTE_ADDR']);
                
                /*
                 
                 md5 password to replicate javascript md5'ing 
                 if you take this out remember to
                 not hash the password at js level
                 (search for hex_md5() function applied on passwords in js file).
                
                */
                $tempPass_js_md5 = md5($tempPass);
                
                
                
               // echo $tempPass;
                $tempPassEn = general::doubleSalt($tempPass_js_md5,$salt);
                
                $tpip = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
                
                if ($emailOrUsername==1){
                //if email
                    $sqlAddTempPass = "UPDATE user_table SET temppass = '$tempPassEn', tpdate=now(), tpip='$tpip', tp_flag=1 WHERE LOWER(email) = '".strtolower($username_email)."'";
                   
                }
                else{
                    $sqlAddTempPass = "UPDATE user_table SET temppass = '$tempPassEn', tpdate=now(), tpip='$tpip', tp_flag=1 WHERE LOWER(screenname) = '".strtolower($username_email)."'";
                  
                }
            
            $dataPostBackUpdate =  dbase::globalQuery($sqlAddTempPass,$conn,3);
            
            if ($dataPostBackUpdate[1]!=-1){
           
                
                
     
                $emailfile = (!isset($_SESSION['js_enabled']))?NOJS_FGPS_NO_HTML:FGPS_NO_HTML;
                $content = general::getFile($emailfile);
                
                
               // $content = general::getFile(FGPS_NO_HTML);
              
                
                $content = str_replace('[[username]]',$username,$content);
                $content = str_replace('[[oursite]]',SITENAME,$content);
                $content = str_replace('[[temppass]]',$tempPass,$content);
                $subject = 'Password Recovery - '.SITENAME;
                
                
               
                
                general::globalEmail($email, ADMIN_EMAIL, $content, $subject);
                
                
                
             
            
         
            
                return true;    
                
            }
            else{
                return false;
            }
            
            
            
            
        }
        else{
            
            return false;
            
        }
        
        
        
        
        
    }
    
    public static function recoverLogin($userid){
          global $conn;
        //called from loginUser function
        
        $sqlUpdateTempPass = "UPDATE user_table SET tp_flag=0 AND temppass='' WHERE userid='$userid' AND tp_flag=1";
        $dataPostBack =  dbase::globalQuery($sqlUpdateTempPass,$conn,3);
        
        if ($dataPostBack[1]!=-1){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    public static function check_user($contact_mail,$contact_name,$contact_message){
           if (isset($_SESSION['userid'])){
                 //we have the user
               //get user basic profile
               $userid=$_SESSION['userid'];
               $data = Admin::get_user($userid,false,'profile',true);
               $output = User::create_email($data,$contact_mail,$contact_name,$contact_message);
               
           }
           else{
   
               $emailResponse = validator::emailValidate($contact_mail,0,'');
               
               
               if ($emailResponse['Ack_2']=='success'){
                   //we have this email address for this user
                   $data = Admin::get_user($emailResponse['userid'],false,'profile',true);
                   $output = User::create_email($data,$contact_mail,$contact_name,$contact_message);
               }
               else {
                   //unregistered user
                   
                   $output = User::create_email(false,$contact_mail,$contact_name,$contact_message);
                   
               }
           }
           
           return true;
    }
    
     public static function create_email($data,$contact_mail,$contact_name,$contact_message){
          $email_temp =  general::getFile("../../ajax/html/email/contact_form_email.php");
          if ($data !== false){
                  
              
              $template = general::getFile("../../ajax/html/email/contact_form_data_email.php");
              
              $template = str_replace('##admin_path##',ADMIN_URL,$template);
              $template = str_replace('##userid##',$data['userid'],$template);
              $template = str_replace('##email##',$data['email'],$template);
              $template = str_replace('##email_contact##',$contact_mail,$template);
              $template = str_replace('##username##',$data['displayname'],$template);
              $template = str_replace('##name##',$contact_name,$template);
              
              
              $email_temp = str_replace('##name_email##','',$email_temp);
           
              
              $email_temp = str_replace('##msg##',$contact_message,$email_temp);
              $email_temp = str_replace('##data_table##',$template,$email_temp);
              
          }
          else{
               
              $email_temp = str_replace('##name_email##','message sent by <strong>'.$contact_name.'</strong> from <strong>'.$contact_mail.'</strong>',$email_temp);
              
              
              $email_temp = str_replace('##msg##',$contact_message,$email_temp);
              $email_temp = str_replace('##data_table##','',$email_temp);
          
          }
          $contact_message = $email_temp;
          //send message
          general::globalEmail(ADMIN_EMAIL,$contact_mail,  $contact_message, CONTACT_SUBJECT);
          
          return true;
     }
    
    public static function hotlink_image($file,$ext_allowed){
     
          $ext = explode('.',basename($file));
          if(isset ($ext[1])){
               if(in_array($ext[1],$ext_allowed)){
                    
                         $id_key=array(
                                        'userid'=>dbase::globalMagic($_SESSION['userid'])
                                        );
                          
                         $key_values=array(
                                        'img_flag'=>1,
                                        'img_url'=>dbase::globalMagic($file)
                                        );
                          
                         $result = dbase::edit_db_item($id_key,$key_values,'user_table','done','failed');
                          
                         if ($result['Ack']=='success'){
                              return 'File connected successfully.';
                         }
                         else{
                              return "Woops, that didnt't work properly.";
                         }
               }
               else{
                    return 'This file type is not allowed.';
               }
          }
          else{
               return 'This file type is not allowed.';
          }
     
    }
    
    public static function upload_file($file,$ext_allowed){

          $file_ext = explode('/',$file['files']['type']);
          if(in_array($file_ext[1],$ext_allowed)){
               if ($file["files"]["error"] > 0){
                    return 'There was an error uploading your file.';
               }
               else{
                    $filename = $_SESSION['userid']."_".time().'.'.$file_ext[1];
                    move_uploaded_file($file["files"]["tmp_name"],UPLOAD_PATH.$filename);
                    
                    $id_key=array(
                                  'userid'=>dbase::globalMagic($_SESSION['userid'])
                                  );
                    
                    $key_values=array(
                                  'img_flag'=>1,
                                  'img_url'=>UPLOAD_PATH.$filename
                                  );
                    
                    $result = dbase::edit_db_item($id_key,$key_values,'user_table','done','failed');
                    
                    if ($result['Ack']=='success'){
                          return 'File uploaded successfully.';
                    }
                    else{
                         return "Woops, that didnt't work properly.";
                    }
               }
          }
          else{
               return 'This file type is not allowed.';
          }
     
    }
    
   
    
   }


?>