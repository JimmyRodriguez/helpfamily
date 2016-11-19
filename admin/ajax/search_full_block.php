<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

        $postList = array("query","limit","sourcer","blocktype","validtype");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
            //clean up data before it goes in
            $query = dbase::globalMagic($_POST['query']);

            $limit = dbase::globalMagic($_POST['limit']);
            $source = dbase::globalMagic($_POST['sourcer']);
            $blocktype = dbase::globalMagic($_POST['blocktype']);
            $validtype = dbase::globalMagic($_POST['validtype']);
            
   
            
            if ($limit == ""){
                $limit = '0,10';
            }
            
            if($source==""){
                $source=1;
            }
            
            if ($blocktype==''){
                $blocktype=-9;
            }
            
            if ($validtype==''){
                $validtype=-9;
            }
            
            
         
            
            $responseArray = Admin::getFullResultsBlock($query,$limit,$source,$blocktype,$validtype);
            
                if ($responseArray['Ack']=="success"){
                    
                 
                    $dataArray = $responseArray;
                    
                }
                else{
                    
                    
                    $dataArray = array("Ack"=>"fail", "Msg"=>"No results found.");
                }
    
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to search this area");
    
}
echo json_encode($dataArray);

function validateDataEdit($query,$blockid){
    
 


    if (is_numeric($blockid)){
        $dataArray['categoryid'] = "ok";
    }
    else{
         $dataArray['categoryid'] = "fail";
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