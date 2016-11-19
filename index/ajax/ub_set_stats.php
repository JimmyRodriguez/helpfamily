<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();

     /*
            This file collects all stats - not just screen res
     
     */
        if(!isset($_SESSION['js_enabled']))
            $_SESSION['js_enabled']=true;
            
        $postList = array("width","height");
        //var_dump($_POST);
        if (!general::globalIsSet($_POST,$postList)){
            $_SESSION['nl_screenres'] = 'not set';
            
        } 
            if(!isset($_SESSION['nl_screenres'])){
          
            
            
                
                //set screen res
                if (is_numeric(intval($_POST['width'])) && is_numeric(intval($_POST['height']))  ){
                    $_SESSION['nl_screenres'] = dbase::globalMagic($_POST['width']).'x'.dbase::globalMagic($_POST['height']);
                }
                else{
                    $_SESSION['nl_screenres'] = 'suspect';
                
                }
                
                //if tracking visitors put in db - but only once - not tracking pageviews
                if (TRACK_VISIT){
                    $browser    = dbase::globalMagic(general::getBrowser());
                    $os         = dbase::globalMagic(general::getOS());
                    
                    $lang       = dbase::globalMagic(general::getLang());
                    $country    = dbase::globalMagic(general::getCountry());
                    
                    $refid      = dbase::globalMagic($_SESSION['refid']);
                    $refurl     = dbase::globalMagic($_SESSION['refurl']);
                    $refdom     = dbase::globalMagic($_SESSION['refdomain']);
                    
                    if (isset($_SESSION['refurl'])){
                        //which it should be
                        $search_engine_term = general::get_search_term_engine(dbase::globalMagic($_SESSION['refurl']));
                        
                        $searchengine=$search_engine_term['searchengine'];
                        $searchterm=$search_engine_term['searchterm'];
                    }
                    else{
                        $searchengine='none';
                        $searchterm='---';
                    }
                    //should really be set by now
                    if(isset($_SESSION['landingpage'])){
                        $landingpage                =   dbase::globalMagic($_SESSION['landingpage']);
                    }
                    else{
                        $landingpage='none';
                    }
                    
                    //useful for getting more accurrate conversion figures
                    if(isset($_SESSION['userid'])){
                        $reg_flag = 1;
                    }
                    else{
                        $reg_flag = 0;
                    }
                    
                    $screenres  = $_SESSION['nl_screenres'];
                    
                    //do not send any alerts if it fails - unless you want to keep it in a log file somewhere
                    Admin::track_visitor($os,$browser,$lang,$country,$screenres,$reg_flag,$refid,$refurl,$refdom,$searchengine,$searchterm,0,$landingpage);
                    
                    
                }
                
                
               
            }
            elseif (TRACK_PAGEVIEW && isset($_SESSION['landing_id'])){
                   
                    $browser    = '';
                    $os         = '';
                    
                    $lang       = '';
                    $country    = '';
                    
                    $refid      = '';
                    $refurl     = '';
                    $refdom     = '';
                    
                   
                    $search_engine_term = '';
                    
                    $searchengine='';
                    $searchterm='';
                    
                    
                    $currentpage= $_SESSION['currentpage'];
                    
                    
                    //useful for getting more accurrate conversion figures
                    if(isset($_SESSION['userid'])){
                        $reg_flag = 1;
                    }
                    else{
                        $reg_flag = 0;
                    }
                    
                    $screenres  = '';
                    
                    //do not send any alerts if it fails - unless you want to keep it in a log file somewhere
                    Admin::track_visitor($os,$browser,$lang,$country,$screenres,$reg_flag,$refid,$refurl,$refdom,$searchengine,$searchterm,0,$currentpage);
                    
                    
            }
                
          
           
            
          
        
        

//no data sent back

?>