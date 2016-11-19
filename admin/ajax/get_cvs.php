<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind($groupTest=array(1))){
        $postList = array("userid","username","email","group","limit","orderby","direction","country","browser","os","status","lang","lastvisit","lastip","regdate","ipad","refurl","refid","refdomain","quick","phone","contact","active");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
            //clean up data before it goes in
            $userid             = dbase::globalMagic($_POST['userid']);
            $username           = dbase::globalMagic($_POST['username']);
            $email              = dbase::globalMagic($_POST['email']);
            $group              = dbase::globalMagic($_POST['group']);
            
            $country            = dbase::globalMagic($_POST['country']);
            $browser            = dbase::globalMagic($_POST['browser']);
            $os                 = dbase::globalMagic($_POST['os']);
            $lang               = dbase::globalMagic($_POST['lang']);
            $status             = dbase::globalMagic($_POST['status']);
            
            $limit              = dbase::globalMagic($_POST['limit']);
            $orderby            = dbase::globalMagic($_POST['orderby']);
            $direction          = dbase::globalMagic($_POST['direction']);
            
            $last_visit         = dbase::globalMagic($_POST['lastvisit']);
            $lastip             = dbase::globalMagic($_POST['lastip']);
            
            $regdate            = dbase::globalMagic($_POST['regdate']);
            $regip              = dbase::globalMagic($_POST['ipad']);
            
            $refurl             = dbase::globalMagic($_POST['refurl']);
            $refid              = dbase::globalMagic($_POST['refid']);
            $refdomain          = dbase::globalMagic($_POST['refdomain']);
            $quick              = dbase::globalMagic($_POST['quick']);
            
            $phone              = dbase::globalMagic($_POST['phone']);
            $contact            = dbase::globalMagic($_POST['contact']);
            
            $active             = dbase::globalMagic($_POST['active']);
            
         
            $limitValue = intval($quick) ==1?'0,20':'0,10';
            $limit=$limit == "" ? $limit = $limitValue : $limit;
            
            
            
            $active     = $active=='' || !is_numeric($active)?        -9  :intval($active);
            $status     = $status=='' || !is_numeric($status)?        -9  :intval($status);
            $orderby    = $orderby=='' || !is_numeric($orderby) ?      0   :intval($orderby);
            $direction  = $direction=='' || !is_numeric($direction) ?    0   :intval($direction);
            $userid     = $userid=='' || !is_numeric(intval($userid)) ?    -9   :intval($userid);
        
                $response = Admin::getCSVData($userid,$username,$email,$group,$limit,$orderby,$direction,$country,$browser,$os,$lang,$status,$last_visit,$lastip,$regdate,$regip,$refid,$refurl,$refdomain,$contact,$phone,$active);
         
                if ($response!==false){
                    
                    
                    $dataArray = array("Ack"=>"success", "file"=>$response,"Msg"=>"(right click the link and select <b>save as</b> to download mailing list)");
                    
                }
                else{
                  
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Sorry, I was unable to create the mailing list.");
                }
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
        
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You do not have permission to generate mailing lists");
    
}

echo json_encode($dataArray);

?>

