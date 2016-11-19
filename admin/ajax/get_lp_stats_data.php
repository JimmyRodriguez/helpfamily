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

     
             $postList = array("id");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){
            

            
          
           
          
                    $url_lp = dbase::globalMagic($_POST['id']);    
           
    
            
                    $lp_response = sitestats::getQuickStats_lp($url_lp);
                    
                    
                    
                    $dataArray = array('Ack'=>'success','data'=>$lp_response);
                        
        }
        else{
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
                        
                    
           
       
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to view this data.");
    
}
echo json_encode($dataArray);



function validateDataEdit(){
    
 
   
    
}

?>