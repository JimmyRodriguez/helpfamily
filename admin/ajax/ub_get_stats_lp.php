<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");
require_once(APP_INC_PATH."lightwork_sitestats.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("url","type","days","orderby");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

          
            
            //clean up data before it goes in
           
            $url            = dbase::globalMagic($_POST['url']);
   
            $type               = dbase::globalMagic($_POST['type']);
            $days               = dbase::globalMagic($_POST['days']);
            $orderby            = dbase::globalMagic($_POST['orderby']);
         
            if ($orderby != 'visits' || $orderby !='users')
                $orderby='visits';
            
           
                
    
            if ((is_numeric($days) && $days<=365 && $days>0) ){
                
                    $response    = sitestats::get_lp_detailed_stats($url,$days,$type,$orderby);
           
                    $sparks      = sitestats::get_graph_trend_chart (12,$url,$days,$url);
                    
                    if ($response['Ack']=='success'){
                        
                        //all went well
                        $dataArray = array("Ack"=>"success", "data"=>$response,"sparky"=>$sparks['sparky'],"sparky_vs"=>$sparks['sparky_vs']);
                        
                 
                        
                    }
                    else{
                        
                       
                                $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, look like there is no data for this section.");
                        
                        
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
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission access this feature.");
    
}
echo json_encode($dataArray);

function validateDataEdit(){
    
 
    
    
}

?>