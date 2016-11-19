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

        $postList = array("narrowby","element","type","days","orderby","search");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

          
            
            //clean up data before it goes in
           
            $element            = dbase::globalMagic($_POST['element']);
            $narrowby           = dbase::globalMagic($_POST['narrowby']);
            $type               = dbase::globalMagic($_POST['type']);
            $days               = dbase::globalMagic($_POST['days']);
            $orderby            = dbase::globalMagic($_POST['orderby']);
            $search             = dbase::globalMagic($_POST['search']);
         
            if ($orderby != 'visits' || $orderby !='users')
                $orderby='visits';
            
           
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
                                case 'domain':
                                        $narrowby = 7;
                                        break;
                                case 'refid':
                                        $narrowby = 8;
                                        break;
                                case 'screenres':
                                        $narrowby = 9;
                                        break;
                                case 'searchengine':
                                        $narrowby = 10;
                                        break;
                                case 'searchterm':
                                        $narrowby = 11;
                                        break;
                                default:
                                        $narrowby = 0;
                                        break;
                    
                    }    
                }
    
          
    
    
            if ((is_numeric($days) && $days<=365 && $days>0) ){
                
                    if (trim($type)=='date' && trim($search)!=''){
                        $search_res = validator::date_format_validate($search,false);
                    
                        if ($search_res['Ack']=='fail'){
                            $search = 'format wrong';
                        }
                        else{
                            $search = $search_res['dbformat'];
                        }
                        
                       
                    }
                    
                
                
                
                    $response = sitestats::get_global_stats($narrowby,$element,$days,$orderby,$type,$search);
             
                    if ($response['Ack']=='success'){
                        
                        //all went well
                        $dataArray = array("Ack"=>"success", "data"=>$response);
                        
                 
                        
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