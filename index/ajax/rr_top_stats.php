<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");
require_once(APP_INC_PATH."lightwork_roar_report.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind(false)){

     

            

            $postList = array("blogid","pkey");
     
        if (general::globalIsSet($_POST,$postList)){

          
            
            //clean up data before it goes in
            $blogid             = dbase::globalMagic($_POST['blogid']);

            $pkey               = dbase::globalMagic($_POST['pkey']);

            
         
            $userid             = dbase::globalMagic($_SESSION['userid']);
          
           
          
          
           
    
            
          
                        
            if (is_numeric($userid) && is_numeric($blogid) && (is_numeric(str_replace('-','',$pkey)) || $pkey=='false')){
                
                        $response = roar::get_quick_stats($blogid,$userid,$pkey);
              
                    if ($response['Ack']=='success'){
                        
                   
                        $dataArray = array("Ack"=>"success", "data"=>$response);
                        
                        
                        
                    }
                    else{
                        
                        
                        if ($pkey=='false'){
                                $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, look like there is no data for this section.");
                        }
                        else{
                                $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, it maybe that your partners key for this roarReport has expired.");   
                        }
                        
                    }
            }
            else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, look like something went wrong! Try refreshing the page and trying again.");
            }
                     
                        
                    
           
       }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to view this page.");
    
}
echo json_encode($dataArray);




?>