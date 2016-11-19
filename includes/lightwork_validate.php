<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
class validator{
    
    
    public static function ip_valid($ip){
              if(filter_var($ip, FILTER_VALIDATE_IP)) {
                return true;
              }
              else {
                return false;
              }

    }
    
    public static function date_format_validate($date,$require_time){
        //function takes date/time and checks if it is correct - returns success/failure and database formatted date
        
        
        $blank_dates        = array ('00.00.0000','0000.00.00','00/00/0000','0000/00/00','00-00-0000','0000-00-00');
        $blank_date_times   = array ('00.00.0000 00:00:00','0000.00.00 00:00:00','00/00/0000 00:00:00','0000/00/00 00:00:00','00-00-0000 00:00:00','0000-00-00 00:00:00');
        
        if (strpos($date,"/")!==false){
            $seperator = '/';
        }
        else if(strpos($date,".")!==false){
            $seperator = '.';
        }
        else if(strpos($date,"-")!==false){
            $seperator = '-';
        }
        else{
            return  $responseArray = array('Ack'=>'fail','Msg'=>'date format incorrect'); 
        }
        
        
        if (strlen($date)!=10 && !$require_time){
            return  $responseArray = array('Ack'=>'fail','Msg'=>'date format incorrect'); 
        }
        else if(strlen($date)!=19 && $require_time){
            return  $responseArray = array('Ack'=>'fail','Msg'=>'date or time format incorrect'); 
        }
        else if (!$require_time && strlen($date)==10){
            if (!in_array($date,$blank_dates)){
                
                
                
                
                $date_a = explode($seperator,$date);
                
                if (count($date_a)!=3){
                    return  $responseArray = array('Ack'=>'fail','Msg'=>'date format incorrect'); 
                }
            
            
                if (checkdate($date_a[1],$date_a[0],$date_a[2])){
                    //UK style date
                    
                    return  $responseArray = array('Ack'=>'success','Msg'=>'success','dbformat'=>$date_a[2].'-'.$date_a[1].'-'.$date_a[0]." 00:00:00"); 
                }
                else if(checkdate($date_a[0],$date_a[1],$date_a[2])){
                    //US style date
                    
                    return  $responseArray = array('Ack'=>'success','Msg'=>'success','dbformat'=>$date_a[2].'-'.$date_a[0].'-'.$date_a[1]." 00:00:00"); 
                    
                }
                else if(checkdate($date_a[1],$date_a[2],$date_a[0])){
                    //International / China style date
                    
                    return  $responseArray = array('Ack'=>'success','Msg'=>'success','dbformat'=>$date_a[0].'-'.$date_a[1].'-'.$date_a[2]." 00:00:00");
                   
                }
                else{
                    return  $responseArray = array('Ack'=>'fail','Msg'=>'date format incorrect');
                }
            }
            else{
                return  $responseArray = array('Ack'=>'success','Msg'=>'success','dbformat'=>"0000-00-00 00:00:00");
            }
            
        }
        else if($require_time && strlen($date)==19){
            if (!in_array($date,$blank_date_times)){
               
                
                if (strpos($date,":")===false){
                    return  $responseArray = array('Ack'=>'fail','Msg'=>'use the : to seperate the time'); 
                }
                
                $date_main = explode(" ",$date);
                
                if (count($date_main)!=2){
                    return  $responseArray = array('Ack'=>'fail','Msg'=>'date or time format incorrect'); 
                }
                else{
                    
                    $date_a = explode($seperator,$date_main[0]);
                    if (count($date_a)!=3){
                         return  $responseArray = array('Ack'=>'fail','Msg'=>'date format incorrect'); 
                    }
                    
                    /*$date_b = explode(":",$date_main[1]);
                    if (count($date_b)!=3){
                         return  $responseArray = array('Ack'=>'fail','Msg'=>'time format incorrect'); 
                    }*/
                    if (!preg_match("/([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]/", $date_main[1])){
                        return  $responseArray = array('Ack'=>'fail','Msg'=>'time format incorrect');
                    }
                    
                }
                
                
                if (checkdate($date_a[1],$date_a[0],$date_a[2])){
                    //UK style date DD-MM-YYYY
                    
                    return  $responseArray = array('Ack'=>'success','Msg'=>'success','dbformat'=>$date_a[2].'-'.$date_a[1].'-'.$date_a[0]." ".$date_main[1]); 
                }
                else if(checkdate($date_a[0],$date_a[1],$date_a[2])){
                    //US style date MM-DD-YYYY
                    
                    return  $responseArray = array('Ack'=>'success','Msg'=>'success','dbformat'=>$date_a[2].'-'.$date_a[0].'-'.$date_a[1]." ".$date_main[1]); 
                    
                }
                else if(checkdate($date_a[1],$date_a[2],$date_a[0])){
                    //China style date YYYY-MM-DD
                    
                    return  $responseArray = array('Ack'=>'success','Msg'=>'success','dbformat'=>$date_a[0].'-'.$date_a[1].'-'.$date_a[2]." ".$date_main[1]);
                   
                }
                else{
                    return  $responseArray = array('Ack'=>'fail','Msg'=>'date format incorrect');
                }
            
            }
            else{
                return  $responseArray = array('Ack'=>'success','Msg'=>'success','dbformat'=>"0000-00-00 00:00:00");
            }
            
            
        }
        
        
        
    }
    
    
    
    public static function passwordValidate($p,$p2,$source){
        
        //password validation
     

        
        //from reg script - compare the passwords
        if ($source==0){
             
             if ($p == 'd41d8cd98f00b204e9800998ecf8427e' || $p2 =='d41d8cd98f00b204e9800998ecf8427e'){
                        
                        
                return $responseArray = array('Ack'=>'fail','Msg'=>'Enter both passwords'); 
                      
               
             }
             else{
                if ($p!==$p2){
                                return $responseArray = array('Ack'=>'fail','Msg'=>'Your passwords do not match'); 
                      
                }
                if ((trim($p)=="") || (trim($p2)=="") ){
                    //needs changing - password cannot possibly be empty at this point after being md5'd @ js level?
                    //length check needs to be send independently before md5'ing in js
                              return $responseArray = array('Ack'=>'fail','Msg'=>'Your password should be more than 6 characters long'); 
                      
                }
                else{
                              return $responseArray = array('Ack'=>'success','Msg'=>'success'); 
                }
             }
             
           
        }
        else{
             //generic tests
             
             if (trim($p)=="" || trim($p)=='d41d8cd98f00b204e9800998ecf8427e'){
                  
                        return $responseArray = array('Ack'=>'fail','Msg'=>'Your password should be more than 6 characters long'); 

             }
             else{
                        return $responseArray = array('Ack'=>'success','Msg'=>'success'); 
                
             }
             
             
             
        }
        
      
        
   }
   
   public static function userRegex($v_username) {
        return preg_match('/[^[:space:]a-zA-Z0-9]/i', $v_username) ? FALSE : TRUE;
   }
   
   public static function usernameValidate($u,$source,$userid){
        
        //if empty
        //if regex
        //if length
        //if exist
             //if from login then exist good else bad
        
     
        global $conn;
        //from reg script 
       
             //generic tests
             
             if (trim($u)==""){
                  
                  
                return $responseArray = array('Ack'=>'fail','Msg'=>'please enter a username');
                  
             }
             else{
                  
                  if (validator::userRegex($u)){
                       
                       if ((strlen($u)<=3) || (strlen($u) > 60)){
                        
                                return $responseArray = array('Ack'=>'fail','Msg'=>'username should be between 3-60 characters long');
                            
                            
                       }
                       else{
                            
                            //do data base check?
                            
                           //no leave it in calling page - but for reg then yes
                           
                           if ($source == 0){
                            
                            //reg proc
                            //check if exiists
                                
                                $sqlCheckUsername = "SELECT userid FROM user_table WHERE LOWER(screenname)='".strtolower($u)."'";
                            
                                
                                $dataPostBack = dbase::globalQuery($sqlCheckUsername,$conn,2);
                                //username exists
                                if ($dataPostBack[1]==0){
                                      
                                      
                                      return $responseArray = array('Ack'=>'success','Msg'=>'success');
                                      
                                }
                                else{
                                        
                                        return $responseArray = array('Ack'=>'fail','Msg'=>'username already in use');
                                      
                                }
                            
                           }
                           else if ($source==1){
                                //edit checker
                               
                                $sqlCheckUsername = "SELECT userid FROM user_table WHERE LOWER(screenname)='".strtolower($u)."' AND userid!='$userid'";
                            
                                
                                $dataPostBack = dbase::globalQuery($sqlCheckUsername,$conn,2);
                                //username exists
                                if ($dataPostBack[1]==0){
                                      
                                      
                                      return $responseArray = array('Ack'=>'success','Msg'=>'success');
                                      
                                }
                                else{
                                        
                                        return $responseArray = array('Ack'=>'fail','Msg'=>'username already in use');
                                      
                                }
                           }
                           else if($source==2){
                          
                                $sqlCheckUsername = "SELECT userid FROM user_table WHERE LOWER(screenname)='".strtolower($u)."' AND userid!='$userid'";
                            
                                
                                $dataPostBack = dbase::globalQuery($sqlCheckUsername,$conn,2);
                                //username exists
                                if ($dataPostBack[1]==1){
                                      
                                      
                                      return $responseArray = array('Ack'=>'success','Msg'=>'success');
                                      
                                }
                                else{
                                        
                                        return $responseArray = array('Ack'=>'fail','Msg'=>'fail');
                                      
                                }
                           }
                           else if ($source==3){
                                $sqlCheckUsername = "SELECT userid FROM user_table WHERE LOWER(screenname)='".strtolower($u)."'";
                            
                                
                                $dataPostBack = dbase::globalQuery($sqlCheckUsername,$conn,2);
                                //username exists
                                if ($dataPostBack[1]==1){
                                      
                                      
                                      return $responseArray = array('Ack'=>'success','Msg'=>'success');
                                      
                                }
                                else{
                                        
                                        return $responseArray = array('Ack'=>'fail','Msg'=>'fail');
                                      
                                }
                           }
                       }
                       
                       
                  }
                  else{
                        
                        return $responseArray = array('Ack'=>'fail','Msg'=>'username should be only contain a-z 0-9 characters');
                       
                  }
                  
                  
             }
             
             
             
    
        
        
        
        
   }
   
   public static function emailValidate($e,$source,$userid){
     
        //if empty
        //if regex
        //if length
        //if exist
             //if from login then exist good else bad
        
          $errorMan = 0;
        
        //from reg script 
      
             //generic tests
             
             if (trim($e)==""){
                
                return $responseArray = array('Ack'=>'fail','Msg'=>'enter your email address','Ack_2'=>'fail');
                  
                   
   
             }
             else{
                
                  
                  if (filter_var($e, FILTER_VALIDATE_EMAIL)){
                       
                       if ((strlen($e)<6)){
                        
                            return $responseArray = array('Ack'=>'fail','Msg'=>'email is in the incorrect format','Ack_2'=>'fail');
                            
                            
                       }
                       else{
                            
                            //do data base check?
                            
                           //no leave it in calling page - but for reg then yes
                           
                             if ($source==0){
                                
                                global $conn;
                                 
                                
                                $sqlCheckEmail = "SELECT userid FROM user_table WHERE LOWER(email)='".strtolower($e)."'";
                                $dataPostBack = dbase::globalQuery($sqlCheckEmail,$conn,2);
                               // echo $sqlPostBack;
                                //username exists
                                if ($dataPostBack[1]==0){
                                      
                                      return $responseArray = array('Ack'=>'success','Msg'=>'success','Ack_2'=>'fail');
                            
                                      
                                }
                                else{
                                     //Ack_2 success for contact form.
                                     return $responseArray = array('Ack'=>'fail','Msg'=>'email is already in use','Ack_2'=>'success','userid'=>$dataPostBack[0]['userid']);
                            
   
                                 
                                }
                              }
                              else if ($source==1){
                                        //if editing - make sure do not check against own existing email
                                        global $conn;
                                 
                                
                                        $sqlCheckEmail = "SELECT userid FROM user_table WHERE LOWER(email)='".strtolower($e)."' AND userid != '$userid'";
                                        $dataPostBack = dbase::globalQuery($sqlCheckEmail,$conn,2);
                                       // echo $sqlCheckEmail;
                                        //username exists
                                        if ($dataPostBack[1]==0){
                                              
                                              return $responseArray = array('Ack'=>'success','Msg'=>'success');
                                    
                                              
                                        }
                                        else{
                                             
                                             return $responseArray = array('Ack'=>'fail','Msg'=>'email is already in use','Ack_2'=>'fail');
                                    
           
                                         
                                        }
                              }
                              else if ($source==2){
                                        global $conn;
                                         
                                        
                                        $sqlCheckEmail = "SELECT userid FROM user_table WHERE LOWER(email)='".strtolower($e)."'";
                                        $dataPostBack = dbase::globalQuery($sqlCheckEmail,$conn,2);
                                       // echo $sqlPostBack;
                                        //username exists
                                        if ($dataPostBack[1]==0){
                                              
                                              return $responseArray = array('Ack'=>'fail','Msg'=>'no such email');
                                    
                                              
                                        }
                                        else{
                                             
                                             return $responseArray = array('Ack'=>'success','Msg'=>'email found');
                                    
           
                                         
                                        }
                              }
                           
                            
                       }
                       
                       
                  }
                  else{
                        
                       return $responseArray = array('Ack'=>'fail','Msg'=>'email is in the incorrect format');
                            
   
                  }
                  
                  
             }
             
             
             
        
        

        
        
   }
   
   public static function checkPasswordDB($password,$userid){

        
        
        global $conn;
       
        $passCheckResponse = array();
        $sqlGetUser = "SELECT * FROM user_table WHERE userid='$userid'"
                     ." AND (valid=1 OR valid=0) ";
                 // echo  $sqlGetUser;  
        $dataPostBack =  dbase::globalQuery($sqlGetUser,$conn,2);
      
        //make sure only one match - if more than (should not happen) then something went really wrong.
        if ($dataPostBack[1]==1){
            
            $userData = $dataPostBack[0];
            
         
            
            if ($userData['valid']==1){

                $salt = $userData["s_hash"];

                $encrypted = general::doubleSalt($password,$salt);
              // echo $encrypted.'--->'.$userData["p_hash"];
                if ($userData['tp_flag']==1 && $encrypted==$userData["temppass"]){
                    $passflag = true;
                    
                
                }
                else if($encrypted==$userData["p_hash"]){
                    //design away you can use both password & temppass
                    $passflag = true;
                    
                 
                }
                else{
                    $passflag = false;
                }
                
               
                
              
                if ($passflag){
                    
                    //create session data
                    
                   
                    
                    //do any other preference settings here like date formats etc
                    
                    $passCheckResponse['validAck']  =   'sucess';
                    $passCheckResponse['validMsg']  =   'success';
                    
                }
                else{
                    
                    $passCheckResponse['validAck']  =   'fail';
                    $passCheckResponse['validMsg']  =   'Your current password is incorrect.';
                    
                }
 
            }
            else{
                //inactive
                $passCheckResponse['validAck']  =   'fail';
                //not really true but should never really hit this point
                $passCheckResponse['validMsg']  =   'Your current password is incorrect.';
            }
 
        }
        else{
            $passCheckResponse['validAck']  =   'fail';
            //not really true but should never really hit this point
            $passCheckResponse['validMsg']  = 'Your current password is incorrect.';
        }
        
        return $passCheckResponse;
        
   }
       
    



}




?>