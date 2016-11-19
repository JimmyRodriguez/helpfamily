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

        $postList = array("type","elementid","days");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

          
            
            //clean up data before it goes in
            $type             = dbase::globalMagic($_POST['type']);
            $elementid        = dbase::globalMagic($_POST['elementid']);
             $days             = dbase::globalMagic($_POST['days']);


                
        $type=sitestats::text_to_num_mapping($type);
                
              
            
    
            if ((is_numeric($days) && $days<=365 && $days>0) ){
              
               $response = sitestats::get_graph_trend_chart($type,$elementid,$days,false);
               
               
              //$response = sitestats::get_graph_trend_mini_sparks($type,$elementid,false);
                    if ($response['Ack']=='success'){
                        
                        //all went well
                        $dataArray = $response;
                        
                     
                        
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