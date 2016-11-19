<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){


            
                  
                     
              
                    $dashResponse = Admin::getDashData();
                    
                  
                    
                    $dataArray = array('data'=>$dashResponse);
                        
                     
                        
         
       
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to view this page.");
    
}
echo json_encode($dataArray);




?>