<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        

            $postList = array("limit");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
            //clean up data before it goes in
            $limit = dbase::globalMagic($_POST['limit']);
         
         
           
            
            if ($limit==''){
                $limit='0,10';
            }
            
          
                
                
                 $responseArray = Admin::getFullGroupResults($limit);
           
                if ($responseArray['Ack']=="success"){
                    
                
                    $dataArray = $responseArray;
                    
                }
                else{
                    
                    $dataArray = array("Ack"=>"fail", "Msg"=>"No results found.");
                }
        }
        else{
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
        
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to edit this page");
    
}
echo json_encode($dataArray);

function validateDataEdit($query,$categoryid){
    
 
    //cat id

    if (!is_numeric($categoryid)){
        $dataArray['categoryid'] = "fail";
    }
    else{
         $dataArray['categoryid'] = "ok";
    }

    
    if (trim($query)!=''){
        $dataArray['query'] = "Enter a some text into the search box.";
    }
    else{
         $dataArray['query'] = "ok";
    }

    
    return $dataArray;
    
}

?>