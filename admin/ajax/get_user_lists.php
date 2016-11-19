<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

      
        $postList = array("country","lang","os","browser","group");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){    
            
            
           
            
            $country    = $_POST['country']=='true'?true:false;
            $lang       = $_POST['lang']=='true'?true:false;
            $os         = $_POST['os']=='true'?true:false;
            $browser    = $_POST['browser']=='true'?true:false;
            $group      = $_POST['group']=='true'?true:false;

            //$validationResponse = validateDataEdit();
            
       
            
            $dataArray = Admin::getUserLists($country,$browser,$os,$lang,$group);
        }
        else{
                $dataArray = array("Ack"=>"fail", "Msg"=>"fail");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"fail");
    
}
echo json_encode($dataArray);

function validateDataEdit(){
    
 
    
    
}

?>