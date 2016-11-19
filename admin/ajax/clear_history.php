<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){

      

            
            
            //clean up data before it goes in
            if(!isset($_SESSION['history'])){
                $_SESSION['history'] ='';
                setcookie ("history", "", time() - 3600);
             
            }
            else{
                unset($_SESSION['history']);
                setcookie ("history", "", time() - 3600);
            }
            
            $dataArray = array("Ack"=>"success", "Msg"=>"user selection history cleared");
    
        
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to clear the history");
    
}

echo json_encode($dataArray);


?>

