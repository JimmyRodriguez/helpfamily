<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        

            
            
            
            
           
            
            $responseArray = Admin::getUserGroupList();
            if ($responseArray['Ack']=="success"){
                
              
                $dataArray = $responseArray;
                
            }
            else{
                
                
                $dataArray = array("Ack"=>"fail", "Msg"=>"Oops! Not sure what went wrong there. Refresh the page and try again.");
            }
    
      
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit this page");
    
}
echo json_encode($dataArray);

function validateDataEdit($menutopid){
    
   
    
  
    
    if (!is_numeric($menutopid)){
        $dataArray['menutopid'] = "fail";
    }
    else{
         $dataArray['menutopid'] = "ok";
    }
   
    
    return $dataArray;
    
}

?>

