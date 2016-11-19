<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
class sessionsClass{
    

    public static function sessionReGen(){
        //need to have a look at what this is actually doing - if anything!
        if (isset($_SESSION['stale']) ){
            if ($_SESSION['stale'] < time() ){
            
                    if (session_regenerate_id(false)){
                        $_SESSION['stale'] = time()+300;
                        
                    }
                    
            }
        }
        else{
            session_regenerate_id(true);
        }
    }


  public static function sessionStart(){
    //regenerate the session id to prevent session fixation
    session_regenerate_id(true);
    
    /*
        
    -  TO ALLOW SUB-DOMAINS TO ALL SHARE ONE LOGIN UNCOMMENT THE FOLLOWING TWO LINES
    
    -  AND REPLACE THE DOMAIN WITH YOUR SITE DOMAIN - MAKE SURE TO LEAVE THE PRECEDING DOT IN THE SECOND LINE
    
    */
    //session_name("nadlabs");
    //session_set_cookie_params(0, "/", ".nadlabs.co.uk");
    
    session_start();
    
    

    
  }
  
  public static function saveReferalData(){
        if(!isset($_SESSION['refdataset'])){
            general::setReferInfo();
           
        }
        
        if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI']) ){
            $_SESSION['currentpage']=(!empty($_SERVER['HTTPS'])) ? 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        else{
            $_SESSION['currentpage']='none--';

        }
       
  }
    
    public static function sessionStartFind($grouptest){
        
        global $conn;

        
        //add anything else you want here to prefect the session checking for your needs.
        $sessionList = array('username','userid','usergroup','stale','token','tempsalt');
        //check if user is logged in
        if (general::globalIsSet($_SESSION,$sessionList)){
            
            //this should be a different test?
            if ($_SESSION['token'] == md5($_SERVER['HTTP_USER_AGENT'].$_SESSION["tempsalt"])){
                
                if ($grouptest!==false){
                    
                    if (in_array(intval($_SESSION['usergroup']),$grouptest)){
                        
                        if (isset($_SESSION['timeout'])){
                            if ((time() - intval($_SESSION['timeout'])) > (LOGIN_INACTIVE * 60)) {
                                session_unset();
                                session_destroy();
                                return false;
                            } else {
                              
                               $_SESSION['timeout'] = time();
                               
                               return true;
                                 
                            }
                        }
                        else{
                            $_SESSION['timeout'] = time();
                           
                            return true;
                        }
                        
                        
                        
                    }
                    else{
                        
                        //real user but not in required usergroup
                        return false;
                    }
                }
                else{
                    return true;
                }
            }
            else{
                return false;
            }
            
            
        }
        else{
            //not all session data present
            return false;
        }
        
    }
    
    public static function site_protection($ref_data,$block,$loggedin,$groups){
        sessionsClass::sessionStart();
     
        if($ref_data)
            sessionsClass::saveReferalData();
        
        if($block){
            if(general::block_site_access()){
                //you may want to do something a bit fancier here
                header("Location: 404.php");
                exit;
                
            }
        }
        
        if($loggedin){
            if (!sessionsClass::sessionStartFind($groups)){
                if (!User::cookie_login()){
                    $_SESSION['page_wanted']=general::get_current_url();
                    header("Location: logout.php?r=0");
                    exit;
                }
                else{
                    //echo 'logged in with a cookie';
                }
                
               
                
               
            }else{
                if (isset($_SESSION['page_wanted']) && AUTO_PAGE_WANTED_REDIRECT){
                    
                    $goto = $_SESSION['page_wanted'];
                    unset($_SESSION['page_wanted']);
                    header("Location: $goto ");
                    exit;
                }
                
                
            }
        }
        
        
    }
    
    
}
?>