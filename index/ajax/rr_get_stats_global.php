<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");
require_once(APP_INC_PATH."lightwork_roar_report.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind(false)){

        $postList = array("narrowby","element","blogid","type","pkey","days");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

          
            
            //clean up data before it goes in
            $blogid             = dbase::globalMagic($_POST['blogid']);
            $element            = dbase::globalMagic($_POST['element']);
            $narrowby           = dbase::globalMagic($_POST['narrowby']);
            $type               = dbase::globalMagic($_POST['type']);
            $pkey               = dbase::globalMagic($_POST['pkey']);
            $days               = dbase::globalMagic($_POST['days']);
            $orderby            = dbase::globalMagic($_POST['orderby']);
            
         
            $userid             = dbase::globalMagic($_SESSION['userid']);
            
         
           
                if(!is_numeric($narrowby)){
                        switch (strtolower($narrowby)){
                            
                            case 'main':
                                    $narrowby = 0;
                                   
                                    break;
                            case 'os':
                                    $narrowby = 1;
                                    break;
                            case 'location':
                                    $narrowby = 2;
                                    break;
                            case 'lang':
                                    $narrowby = 3;
                                    break;
                            case 'url':
                                    $narrowby = 4;
                                    break;
                            case 'browser':
                                    $narrowby = 5;
                                    break;
                            case 'date':
                                    $narrowby = 6;
                                    break;
                           case 'screenres':
                                    $narrowby = 9;
                                    break;
                            default:
                                    $narrowby = 0;
                                    break;
                    
                    }    
                }
    
            if (is_numeric($userid)  && (is_numeric($days) && $days<=365 && $days>0) && is_numeric($blogid) && (is_numeric(str_replace('-','',$pkey)) || $pkey=='false')){
                
                    $response = roar::get_global_stats($narrowby,$element,$blogid,$userid,$pkey,$days,$type,$orderby);
                    if ($response['Ack']=='success'){
                        
                   
                        $dataArray = array("Ack"=>"success", "data"=>$response);
                        
                     
                        
                    }
                    else{
                        
                     
                        if ($pkey=='false'){
                                $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, look like there is no data for this section.");
                        }
                        else{
                                $dataArray = array("Ack"=>"fail", "Msg"=>"Oops, it maybe that your partners key for this roarReport has expired.");   
                        }
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