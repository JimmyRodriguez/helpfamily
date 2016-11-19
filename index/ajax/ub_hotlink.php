<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind(false)){

        $postList = array("ed_avatar_link");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
          
            $hotlink = htmlentities(dbase::globalMagic($_POST['ed_avatar_link']));
      
          
 
            
       
        
            if (trim($hotlink)!=''){
            
                
                
                    $hotlink_error = User::hotlink_image($hotlink,$ext_allowed);
                    $dataArray = array("Ack"=>"success","Msg"=>$hotlink_error);
                
            }
            else{
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Enter the URL to your profile image.");
            }
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You are not logged in.");
    
}
echo json_encode($dataArray);
?>