<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("userid");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

           
            
            
  
            if(!isset($_SESSION['history'])){
                $_SESSION['history'] ='';
            }
            
            
            
            
            $userid = dbase::globalMagic($_POST['userid']);
            
            
           
            if(is_numeric($userid) &&  $userid!=0){
                $responseArray = Admin::getUserData($userid);
                if ($responseArray['Ack']=="success"){
                    
                  
                    $dataArray = $responseArray;
                    
                    if (strpos($_SESSION['history'],$userid)===false){
                        if ($_SESSION['history']=='' ){
                            $_SESSION['history'] = $userid;    
                        }
                        else{
                             $_SESSION['history'] .= ','.$userid;    
                        }
                        setcookie('history',$_SESSION['history'],time()+86400);//expire in 24 hours
                        
                    }
                    
                    
                }
                else{
                    
                    
                   
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Sorry, could not find this record.");
                
                }
            }
            else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"Sorry, could not find this record.");
            }
    
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit this page");
    
}

echo json_encode($dataArray);

function validateDataEdit($userid){
    
   
    
   
    
    if (!is_numeric($userid)){
        $dataArray['userid'] = "fail";
    }
    else{
         $dataArray['userid'] = "ok";
    }
   
    
    return $dataArray;
    
}

?>

