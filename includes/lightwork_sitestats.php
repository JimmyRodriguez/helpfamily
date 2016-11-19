<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/

class sitestats{
    
    public static function get_spark_data_24hour ($sql_trend,$days){
        global $conn;
        
        $dataPostBack =  dbase::globalQueryPlus($sql_trend,$conn,2);
        
        if ($dataPostBack[1]>0){
            $set = array();
            //$counter = 0;
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                //$counter ++;
            }
            $complete_list = '';
            $sql_results_count=0;
           
            $hour_str='';
            for($hour=0;$hour<24;$hour++) {
                //echo $sql_results_count;
                if ($sql_results_count<=($dataPostBack[1]-1)){
                    if ($hour < 10){
                        $hour_str = '0'.$hour;
                    
                    }
                    else{
                        $hour_str= ''.$hour;
                    }
                    if($set[$sql_results_count]['trend_date']==$hour_str){
                            
                           
                            $complete_list  = $complete_list.$set[$sql_results_count]['counter'].',';
                            
                            $sql_results_count++;
                    }
                    else{
                     
                            $complete_list  = $complete_list.'0,';
                    }
                }
                else{
              
                            $complete_list  = $complete_list.'0,';
                }
                
                
                
                
            }

            
            
            return $complete_list = substr($complete_list,0,strlen($complete_list)-1);
        
        }
        else{
            
            $complete_list = '';
            for($hour=0;$hour<24;$hour++) {
                $complete_list  = $complete_list.'0,';
            }
            return $complete_list = substr($complete_list,0,strlen($complete_list)-1);
           
             
        }
    
    }
      
     
     
     public static function get_spark_data ($sql_trend,$days){
         global $conn;
             $dataPostBack =  dbase::globalQueryPlus($sql_trend,$conn,2);
        if ($dataPostBack[1]>0){
            $set = array();
            //$counter = 0;
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                //$counter ++;
            }
            $complete_list = '';
            $sql_results_count=0;
            $start_date = date('Y-m-d');
       
            for($day=intval($days);$day>=0;$day--) {
                //echo $sql_results_count;
                if ($sql_results_count<=($dataPostBack[1]-1)){
                    if($set[$sql_results_count]['trend_date']==date('d/m/Y',strtotime("$start_date - $day days"))){
                            
                           
                            $complete_list  = $complete_list.$set[$sql_results_count]['counter'].',';
                            
                            $sql_results_count++;
                    }
                    else{
                     
                            $complete_list  = $complete_list.'0,';
                    }
                }
                else{
              
                            $complete_list  = $complete_list.'0,';
                }
                
                
                
                
            }
            $complete_list = substr($complete_list,0,strlen($complete_list)-1);
            
            
            return $complete_list;
        
        }
        else{
            
            $complete_list = '';
            for($day=intval($days);$day>=0;$day--) {
                $complete_list  = $complete_list.'0,';
            }
            return $complete_list = substr($complete_list,0,strlen($complete_list)-1);
           
             
        }
    
    }
    
    
    public static function get_chart_data_24hour ($sql_trend,$days){
        global $conn;
        $trend_data = array();
        $dataPostBack =  dbase::globalQueryPlus($sql_trend,$conn,2);
        
        if ($dataPostBack[1]>0){
            $set = array();
            //$counter = 0;
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                //$counter ++;
            }
           // $complete_list = '';
            $sql_results_count=0;
           
            $hour_str='';
            for($hour=0;$hour<24;$hour++) {
                //echo $sql_results_count;
                if ($hour < 10){
                    $hour_str = '0'.$hour;
                
                }
                else{
                    $hour_str= ''.$hour;
                }
                if ($sql_results_count<=($dataPostBack[1]-1)){
                    
                    if($set[$sql_results_count]['trend_date']==$hour_str){
                            
                           $trend_data[$hour]['date'] = $hour_str.":00";
                           $trend_data[$hour]['stats'] = $set[$sql_results_count]['counter'];
                           
                            //$complete_list  = $complete_list.$set[$sql_results_count]['counter'].',';
                            
                            $sql_results_count++;
                    }
                    else{
                     
                           $trend_data[$hour]['date'] = $hour_str.":00";
                           $trend_data[$hour]['stats'] = 0;
                    }
                }
                else{
              
                           $trend_data[$hour]['date'] = $hour_str.":00";
                           $trend_data[$hour]['stats'] = 0;
                }
                
                
                
                
            }

            
            
            return $trend_data;//$complete_list = substr($complete_list,0,strlen($complete_list)-1);
        
        }
        else{
            
            //$complete_list = '';
            for($hour=0;$hour<24;$hour++) {
                //echo $hour."<br>";
                if ($hour < 10){
                    $hour_str = '0'.$hour.":00";
                }
                else{
                    $hour_str= ' '.$hour.":00";
                }
                //echo $hour_str."<br>";
                $trend_data[$hour]['date'] = $hour_str;
                $trend_data[$hour]['stats'] = 0;
                
               // echo $trend_data[$hour]['date']."<br>";
                
               
            }
            return $trend_data;//return $complete_list = substr($complete_list,0,strlen($complete_list)-1);
           
             
        }
    
    }
      
     
    
    
     public static function get_chart_data ($sql_trend,$days){
        //this builds up data rather than spark line values
        
         global $conn;
         $trend_data = array();
         $start_date = date('Y-m-d');
             $dataPostBack =  dbase::globalQueryPlus($sql_trend,$conn,2);
        if ($dataPostBack[1]>0){
            $set = array();
            
            //$counter = 0;
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                //$counter ++;
            }
           // $complete_list = '';
            $sql_results_count=0;
            $sql_results_count_2=0;
       
            for($day=intval($days);$day>=0;$day--) {
               // echo $sql_results_count;
               //$daycounter = intval($day)-intval();
                if ($sql_results_count<=($dataPostBack[1]-1)){
                    $current_trend_date = date('d/m/Y',strtotime("$start_date - $day days"));
                    if($set[$sql_results_count]['trend_date']==date('d/m/Y',strtotime("$start_date - $day days"))){
                            
                           $trend_data[$sql_results_count_2]['date'] = $current_trend_date;
                           $trend_data[$sql_results_count_2]['stats'] = $set[$sql_results_count]['counter'];
                            //$complete_list  = $complete_list.$set[$sql_results_count]['counter'].',';
                            
                            $sql_results_count++;
                    }
                    else{
                     
                            //$complete_list  = $complete_list.'0,';
                            $trend_data[$sql_results_count_2]['date'] = $current_trend_date;
                           $trend_data[$sql_results_count_2]['stats'] = 0;
                    }
                }
                else{
              
                           // $complete_list  = $complete_list.'0,';
                            $trend_dat[$sql_results_count_2]['date'] = $current_trend_date;
                           $trend_data[$sql_results_count_2]['stats'] = 0;
                }
                
                
                $sql_results_count_2++;
                
            }
           // $complete_list = substr($complete_list,0,strlen($complete_list)-1);
            
            
            return $trend_data;
        
        }
        else{
               $sql_results_count_2 = 0;
            //$complete_list = '';
            for($day=intval($days);$day>=0;$day--) {
                //$complete_list  = $complete_list.'0,';
                $current_trend_date = date('d/m/Y',strtotime("$start_date - $day days"));
                 $trend_data[$sql_results_count_2]['date'] = $current_trend_date;
                $trend_data[$sql_results_count_2]['stats'] = 0;
                $sql_results_count_2++;
            }
            return $trend_data ; //= substr($complete_list,0,strlen($complete_list)-1);
              
             
        }
    
    }
    
    
    
     public static function get_graph_trend_chart ($type,$elementid,$days,$lp){
       
     //will need on version to show visits rather than registrations
     
        if ($lp!==false){
            $lp_u=" AND ut.landingpage = '$lp'";
            $lp_v=" AND vs.landingpage = '$lp' AND vs.lp_flag = 1 ";
        }
        else{
            $lp_u=" ";
            $lp_v=" AND vs.lp_flag = 1 ";
        }
       //echo $days.'----'.$type;
       $com = (is_numeric($type))?6:'date';
         
      
       if ((intval($days) == 1) || ($type==$com)){
       

            $sql_trend = "SELECT (count(ut.userid)) AS counter, DATE_FORMAT(ut.date_joined,'%H') AS trend_date "
                        ." FROM user_table AS ut "
                        ." WHERE    ut.valid IN (0,1,2)  " 
                        ." AND ut.date_joined > DATE_SUB(NOW(),INTERVAL $days DAY) "
                        ."  ##narrow_user##  $lp_u "
                        ." GROUP BY DATE_FORMAT(ut.date_joined,'%H') ORDER BY ut.date_joined ASC";
                        
            $sql_trend_vs = "SELECT (count(vs.visitid)) AS counter, DATE_FORMAT(vs.date_visited,'%H') AS trend_date  "
                        ." FROM visit_stats AS vs  "
                        ." WHERE     " 
                        ."  vs.date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) "
                        ." ##narrow_visit##  $lp_v"
                        ." GROUP BY DATE_FORMAT(vs.date_visited,'%H') ORDER BY vs.date_visited ASC";
       }
       else{
     
            $sql_trend = "SELECT (count(ut.userid)) AS counter, DATE_FORMAT(ut.date_joined,'%d/%m/%Y') AS trend_date "
                        ." FROM user_table AS ut "
                        ." WHERE    ut.valid IN (0,1,2)  " 
                        ." AND ut.date_joined > DATE_SUB(NOW(),INTERVAL $days DAY) "
                        ."  ##narrow_user##  $lp_u "
                        ." GROUP BY DATE_FORMAT(ut.date_joined,'%d/%m/%Y') ORDER BY ut.date_joined ASC";
                        
            $sql_trend_vs = "SELECT (count(vs.visitid)) AS counter, DATE_FORMAT(vs.date_visited,'%d/%m/%Y') AS trend_date  "
                        ." FROM visit_stats AS vs  "
                        ." WHERE     " 
                        ."  vs.date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) "
                        ." ##narrow_visit##  $lp_v"
                        ." GROUP BY DATE_FORMAT(vs.date_visited,'%d/%m/%Y') ORDER BY vs.date_visited ASC";
                  
       }   
 
        
        $type           = sitestats::text_to_num_mapping($type);
        
        $sql_trend      = sitestats::narrow_by($sql_trend,$type,$elementid);
   
        $sql_trend_vs   = sitestats::narrow_by($sql_trend_vs,$type,$elementid);
        if ($days==1 || $type==6){
            $trend_list     = sitestats::get_chart_data_24hour ($sql_trend,$days);
            //echo $sql_trend;
        
            $trend_list_vs  = sitestats::get_chart_data_24hour  ($sql_trend_vs,$days);
        }
        else{
            $trend_list     = sitestats::get_chart_data ($sql_trend,$days);
            //echo $sql_trend;
            $trend_list_vs  = sitestats::get_chart_data ($sql_trend_vs,$days);
        }
        
        
        return $sparks= array('Ack'=>'success','sparky'=>$trend_list,'sparky_vs'=>$trend_list_vs);
        
      
   }
    
    
    
    
    public static function get_graph_trend_mini_sparks ($type,$elementid,$days,$lp){
       
     //will need on version to show visits rather than registrations
     
        if ($lp!==false){
            $lp_u=" AND ut.landingpage = '$lp'";
            $lp_v=" AND vs.landingpage = '$lp' AND vs.lp_flag = 1 ";
        }
        else{
            $lp_u=" ";
            $lp_v=" AND vs.lp_flag = 1 ";
        }
       //echo $days.'----'.$type;
       $com = (is_numeric($type))?6:'date';
         
      
       if ((intval($days) == 1) || ($type==$com)){
       

            $sql_trend = "SELECT (count(ut.userid)*10) AS counter, DATE_FORMAT(ut.date_joined,'%H') AS trend_date "
                        ." FROM user_table AS ut "
                        ." WHERE    ut.valid IN (0,1,2)  " 
                        ." AND ut.date_joined > DATE_SUB(NOW(),INTERVAL $days DAY) "
                        ."  ##narrow_user##  $lp_u "
                        ." GROUP BY DATE_FORMAT(ut.date_joined,'%H') ORDER BY ut.date_joined ASC";
                        
            $sql_trend_vs = "SELECT (count(vs.visitid)*10) AS counter, DATE_FORMAT(vs.date_visited,'%H') AS trend_date  "
                        ." FROM visit_stats AS vs  "
                        ." WHERE     " 
                        ."  vs.date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) "
                        ." ##narrow_visit##  $lp_v"
                        ." GROUP BY DATE_FORMAT(vs.date_visited,'%H') ORDER BY vs.date_visited ASC";
       }
       else{
     
            $sql_trend = "SELECT (count(ut.userid)*10) AS counter, DATE_FORMAT(ut.date_joined,'%d/%m/%Y') AS trend_date "
                        ." FROM user_table AS ut "
                        ." WHERE    ut.valid IN (0,1,2)  " 
                        ." AND ut.date_joined > DATE_SUB(NOW(),INTERVAL $days DAY) "
                        ."  ##narrow_user##  $lp_u "
                        ." GROUP BY DATE_FORMAT(ut.date_joined,'%d/%m/%Y') ORDER BY ut.date_joined ASC";
                        
            $sql_trend_vs = "SELECT (count(vs.visitid)*10) AS counter, DATE_FORMAT(vs.date_visited,'%d/%m/%Y') AS trend_date  "
                        ." FROM visit_stats AS vs  "
                        ." WHERE     " 
                        ."  vs.date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) "
                        ." ##narrow_visit##  $lp_v"
                        ." GROUP BY DATE_FORMAT(vs.date_visited,'%d/%m/%Y') ORDER BY vs.date_visited ASC";
                  
       }   
 
        
        $type           = sitestats::text_to_num_mapping($type);
        
        $sql_trend      = sitestats::narrow_by($sql_trend,$type,$elementid);
   
        $sql_trend_vs   = sitestats::narrow_by($sql_trend_vs,$type,$elementid);
        if ($days==1 || $type==6){
            $trend_list     = sitestats::get_spark_data_24hour ($sql_trend,$days);
            //echo $sql_trend;
        
            $trend_list_vs  = sitestats::get_spark_data_24hour  ($sql_trend_vs,$days);
        }
        else{
            $trend_list     = sitestats::get_spark_data ($sql_trend,$days);
            //echo $sql_trend;
            $trend_list_vs  = sitestats::get_spark_data ($sql_trend_vs,$days);
        }
        
        
        return $sparks= array('sparky'=>$trend_list,'sparky_vs'=>$trend_list_vs);
        
      
   }
    
    public static function get_graph_trend24 ($type,$elementid,$days){
        global $conn;
     //will need on version to show visits rather than registrations
            $sql_trend = "SELECT count(ut.userid) AS counter, DATE_FORMAT(ut.date_joined,'%H') AS trend_date "
                    ." FROM user_table AS ut "
                    ." WHERE    ut.valid IN (0,1,2) "
                    ." AND ut.date_joined > DATE_SUB(NOW(),INTERVAL $days DAY) "
                    ."  ##narrow_user##  "
                    ." GROUP BY DATE_FORMAT(ut.date_joined,'%H') ORDER BY ut.date_joined ASC";
                    
            $sql_trend_vs = "SELECT count(vs.visitid) AS counter, DATE_FORMAT(vs.date_visited,'%H') AS trend_date "
                    ." FROM visit_stats AS vs "
                    ." WHERE     "
                    ."  vs.date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) AND vs.lp_flag=1"
                    ."  ##narrow_visit##  "
                    ." GROUP BY DATE_FORMAT(vs.date_visited,'%H') ORDER BY vs.date_visited ASC";
     
        //$type           = sitestats::text_to_num_mapping($type);
        $sql_trend = sitestats::narrow_by($sql_trend,$type,$elementid);
        $sql_trend_vs = sitestats::narrow_by($sql_trend_vs,$type,$elementid);
      // echo $sql_trend;
        $dataPostBack =  dbase::globalQueryPlus($sql_trend,$conn,2);
        if ($dataPostBack[1]>0){
            $set = array();
            //$counter = 0;
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                //$counter ++;
            }
            $complete_list = array();
            $sql_results_count=0;
           // $start_date = date('Y-m-d');
 
            for($hour=0;$hour<24;$hour++) {
                //echo $sql_results_count;
                if ($hour < 10){
                        $hour_str = '0'.$hour;
                    
                    }
                    else{
                        $hour_str= ''.$hour;
                }
                if ($sql_results_count<=($dataPostBack[1]-1) && isset($set[$sql_results_count]['trend_date'])){
                    if($set[$sql_results_count]['trend_date']==$hour_str){
                            
                            $complete_list[$hour]['date_val'] = $hour_str;
                            $complete_list[$hour]['reg_val']  = intval($set[$sql_results_count]['counter']);
                            
                            $sql_results_count++;
                    }
                    else{
                            $complete_list[$hour]['date_val'] = $hour_str;
                            $complete_list[$hour]['reg_val']  = 0;
                    }
                }
                else{
                            $complete_list[$hour]['date_val'] = $hour_str;
                            $complete_list[$hour]['reg_val']  = 0;
                }
                
                
                
                
            }
            //need to loop through and add blank = zero days
            
           // return $dataArray = array('data'=>$complete_list,'Ack'=>'success');
        
        }
        else{
           
           
          $complete_list = array();
            for($hour=0;$hour<24;$hour++) {
                 if ($hour < 10){
                        $hour_str = '0'.$hour;
                    
                    }
                    else{
                        $hour_str= ''.$hour;
                }
                $complete_list[$hour]['date_val'] = $hour_str;
                $complete_list[$hour]['reg_val']  = 0;
            }
            
         
           // return $dataArray = array('data'=>$complete_list,'Ack'=>'success');
        }
        
        
        
        
         
          $dataPostBack =  dbase::globalQueryPlus($sql_trend_vs,$conn,2);
         if ($dataPostBack[1]>0){
            $set = array();
            //$counter = 0;
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                //$counter ++;
            }
            $complete_list_vs = array();
            $sql_results_count=0;
            //$start_date = date('Y-m-d');
          
            for($hour=0;$hour<24;$hour++) {
                //echo $sql_results_count;
                if ($hour < 10){
                        $hour_str = '0'.$hour;
                    
                    }
                    else{
                        $hour_str= ''.$hour;
                }
                if ($sql_results_count<=($dataPostBack[1]-1) && isset($set[$sql_results_count]['trend_date'])){
                    if($set[$sql_results_count]['trend_date']==$hour_str){
                            
                            $complete_list_vs[$hour]['date_val'] = $hour_str;
                            $complete_list_vs[$hour]['reg_val']  = intval($set[$sql_results_count]['counter']);
                            
                            $sql_results_count++;
                    }
                    else{
                            $complete_list_vs[$hour]['date_val'] = $hour_str;
                            $complete_list_vs[$hour]['reg_val']  = 0;
                    }
                }
                else{
                            $complete_list_vs[$hour]['date_val'] = $hour_str;
                            $complete_list_vs[$hour]['reg_val']  = 0;
                }
                
                
                
                
            }
            //need to loop through and add blank = zero days
            
           // return $dataArray = array('data'=>$complete_list,'Ack'=>'success');
        
        }
        else{
           
           
          $complete_list_vs = array();
            for($hour=0;$hour<24;$hour++) {
                 if ($hour < 10){
                        $hour_str = '0'.$hour;
                    
                    }
                    else{
                        $hour_str= ''.$hour;
                }
                $complete_list_vs[$hour]['date_val'] = $hour_str;
                $complete_list_vs[$hour]['reg_val']  = 0;
            }
            
         
           // return $dataArray = array('data'=>$complete_list,'Ack'=>'success');
        }
        
        
       
        
        
        
        
        
        return $dataArray = array('data'=>$complete_list,'data_vs'=>$complete_list_vs,'Ack'=>'success'); 
    }
    
    
    
    public static function get_graph_trend ($type,$elementid,$days){
        global $conn;
     //will need on version to show visits rather than registrations
            $sql_trend = "SELECT count(ut.userid) AS counter, DATE_FORMAT(ut.date_joined,'%d/%m/%Y') AS trend_date "
                    ." FROM user_table AS ut "
                    ." WHERE    ut.valid IN (0,1,2) "
                    ." AND ut.date_joined > DATE_SUB(NOW(),INTERVAL $days DAY) "
                    ."  ##narrow_user##  "
                    ." GROUP BY DATE_FORMAT(ut.date_joined,'%d/%m/%Y') ORDER BY ut.date_joined ASC";
                    
            $sql_trend_vs = "SELECT count(vs.visitid) AS counter, DATE_FORMAT(vs.date_visited,'%d/%m/%Y') AS trend_date "
                    ." FROM visit_stats AS vs "
                    ." WHERE     "
                    ."  vs.date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) AND vs.lp_flag=1"
                    ."  ##narrow_visit##  "
                    ." GROUP BY DATE_FORMAT(vs.date_visited,'%d/%m/%Y') ORDER BY vs.date_visited ASC";
     
        //$type           = sitestats::text_to_num_mapping($type);
        //echo $type.'-----';
        $sql_trend = sitestats::narrow_by($sql_trend,$type,$elementid);
        //echo $sql_trend;
        $dataPostBack =  dbase::globalQueryPlus($sql_trend,$conn,2);
        if ($dataPostBack[1]>0){
            $set = array();
            //$counter = 0;
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                //$counter ++;
            }
            $complete_list = array();
         
            $sql_results_count=0;
            $start_date = date('Y-m-d');
            // loop over 365 days and look for tuesdays or wednesdays not in the excluded list
            for($day=intval($days);$day>=0;$day--) {
                //echo $sql_results_count;
                if ($sql_results_count<=($dataPostBack[1]-1) && isset($set[$sql_results_count]['trend_date'])){
                    if($set[$sql_results_count]['trend_date']==date('d/m/Y',strtotime("$start_date - $day days"))){
                            
                            $complete_list[$day]['date_val'] = date('d/m/Y',strtotime("$start_date - $day days"));
                            $complete_list[$day]['reg_val']  = $set[$sql_results_count]['counter'];
                            
                            $sql_results_count++;
                    }
                    else{
                            $complete_list[$day]['date_val'] = date('d/m/Y',strtotime("$start_date - $day days"));
                            $complete_list[$day]['reg_val']  = 0;
                    }
                }
                else{
                            $complete_list[$day]['date_val'] = date('d/m/Y',strtotime("$start_date - $day days"));
                            $complete_list[$day]['reg_val']  = 0;
                }
                
                
                
                
            }
            //need to loop through and add blank = zero days
            
           // return $dataArray = array('data'=>$complete_list,'Ack'=>'success');
        
        }
        else{
           
            $complete_list  = array();
            $start_date     = date('Y-m-d');
            
            for($day=intval($days);$day>=0;$day--) {
                
                $complete_list[$day]['date_val'] = date('d/m/Y',strtotime("$start_date - $day days"));
                $complete_list[$day]['reg_val']  = 0;
                
            }
         
            //return $dataArray = array('data'=>$complete_list,'Ack'=>'success');
        }
        
        $sql_trend_vs = sitestats::narrow_by($sql_trend_vs,$type,$elementid);
       // echo $sql_trend_vs;
      
        $dataPostBack =  dbase::globalQueryPlus($sql_trend_vs,$conn,2);
        
        if ($dataPostBack[1]>0){
            $set = array();
             
            //$counter = 0;
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                //$counter ++;
            }
    
            $complete_list_vs = array();
            $sql_results_count=0;
            $start_date = date('Y-m-d');
            // loop over 365 days and look for tuesdays or wednesdays not in the excluded list
            for($day=intval($days);$day>=0;$day--) {
                //echo $sql_results_count;
                if ($sql_results_count<=($dataPostBack[1]-1) && isset($set[$sql_results_count]['trend_date'])){
                    if($set[$sql_results_count]['trend_date']==date('d/m/Y',strtotime("$start_date - $day days"))){
                            
                            $complete_list_vs[$day]['date_val'] = date('d/m/Y',strtotime("$start_date - $day days"));
                            $complete_list_vs[$day]['reg_val']  = $set[$sql_results_count]['counter'];
                            
                            $sql_results_count++;
                    }
                    else{
                            $complete_list_vs[$day]['date_val'] = date('d/m/Y',strtotime("$start_date - $day days"));
                            $complete_list_vs[$day]['reg_val']  = 0;
                    }
                }
                else{
                            $complete_list_vs[$day]['date_val'] = date('d/m/Y',strtotime("$start_date - $day days"));
                            $complete_list_vs[$day]['reg_val']  = 0;
                }
                
                
                
                
            }
            //need to loop through and add blank = zero days
            
           // return $dataArray = array('data'=>$complete_list,'Ack'=>'success');
        
        }
        else{
           
            $complete_list_vs  = array();
            $start_date     = date('Y-m-d');
            
            for($day=intval($days);$day>=0;$day--) {
                
                $complete_list_vs[$day]['date_val'] = date('d/m/Y',strtotime("$start_date - $day days"));
                $complete_list_vs[$day]['reg_val']  = 0;
                
            }
         
           // return $dataArray = array('data'=>$complete_list,'Ack'=>'success');
        }
        
        
        return $dataArray = array('data'=>$complete_list,'data_vs'=>$complete_list_vs,'Ack'=>'success'); 
    }
    
    public static function get_stat_file($narrowby){
        if (trim($narrowby)=='' || $narrowby==0){
            $file_repeater = general::getfile('../../ajax/html/rr_data_repeater.php');
        }
        else{
            $file_repeater = general::getfile('../../ajax/html/rr_data_repeater_mini.php');
        }
       
        
        return $file_repeater;
    }
    
    
    public static function narrow_by($sql,$narrow_by,$id){
         switch($narrow_by){
            case 0:
                
                //do nothing
                $sql = str_replace('##narrow_user##','',$sql);
                $sql = str_replace('##narrow_visit##','',$sql);
                
                break;
            case 1:
                
                //narrow by OS
               
                
                $sql = str_replace('##narrow_user##'," AND ut.os = '$id' ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.os = '$id'   ",$sql);
                
                break;
            
            case 2:
                
                //narrow by loc
                
                
                $sql = str_replace('##narrow_user##'," AND ut.country = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.country = '$id'   ",$sql);
                
                break;
            
            case 3:
                
                //narrow by lang
          
                
                $sql = str_replace('##narrow_user##'," AND ut.lang = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.lang = '$id'   ",$sql);
                
                break;
            
            case 4:
                
                //narrow by url
             
                
                $sql = str_replace('##narrow_user##'," AND ut.refurl = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.refurl = '$id'   ",$sql);
                
                break;
            
            case 5:
                
                //narrow by browser
                
                
                $sql = str_replace('##narrow_user##'," AND ut.browser = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.browser = '$id'   ",$sql);
                
                break;
            
             case 6:
                
                //narrow by date - the sql will need work - date formatting etc
                
                
                $sql = str_replace('##narrow_user##'," AND DATE_FORMAT(ut.date_joined,'%d/%m/%Y') = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND DATE_FORMAT(vs.date_visited,'%d/%m/%Y') = '$id'  ",$sql);
                
                break;
            
            case 7:
                
                //narrow by domain
                
                
                $sql = str_replace('##narrow_user##'," AND ut.refdomain = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.refdomain = '$id'  ",$sql);
                
                break;
            case 8:
                
                //narrow by refid
                
                
                $sql = str_replace('##narrow_user##'," AND ut.refid = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.refid = '$id'  ",$sql);
                
                break;
            case 9:
                
                //narrow by screenres
                
                
                $sql = str_replace('##narrow_user##'," AND ut.screenres = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.screenres = '$id'  ",$sql);
                
                break;
            case 10:
                
                //narrow by search engine
                
                
                $sql = str_replace('##narrow_user##'," AND ut.searchengine = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.searchengine = '$id'  ",$sql);
                
                break;
            case 11:
                
                //narrow by keywords
                
                
                $sql = str_replace('##narrow_user##'," AND ut.searchterm = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.searchterm = '$id'  ",$sql);
                
                break;
            case 12:
                
                //narrow by lp
                
                
                $sql = str_replace('##narrow_user##'," AND ut.landingpage = '$id'  ",$sql);
                $sql = str_replace('##narrow_visit##'," AND vs.landingpage = '$id'  ",$sql);
                
                break;
            
            default:
                //narrow by nothing
                $sql = str_replace('##narrow_user##','',$sql);
                $sql = str_replace('##narrow_visit##','',$sql);
                
                break;
        }
        
        return $sql;
    }
    
    public static function get_lp_detailed_stats($url,$days,$type,$orderby){
                //could just use 'type' in the file name rather than switch
                
                $sql_get_stats = general::getFile('../../sql/sql_roarreport_'.$type.'_ss.php');
                
                global $conn;
                
                    if ($orderby=='visit'){
                        $sql_get_stats=str_replace("##order##"," t2.stat_vs DESC ", $sql_get_stats);
                    }
                    else{
                        $sql_get_stats=str_replace("##order##"," t1.stat DESC ", $sql_get_stats);
                    }
                    
                    $sql_get_stats=str_replace("##days##",$days , $sql_get_stats);
                    
                    if ($url!==false){
                        $sql_get_stats = str_replace('##narrow_user##'," AND ut.landingpage='$url' ",$sql_get_stats);
                        $sql_get_stats = str_replace('##narrow_visit##'," AND vs.landingpage='$url' ",$sql_get_stats);
                        
                    }
                    else{
                        $sql_get_stats = str_replace('##narrow_user##',"  ",$sql_get_stats);
                        $sql_get_stats = str_replace('##narrow_visit##',"  ",$sql_get_stats);
                        
                    
                    }
                    
                   //echo $sql_get_stats;
                    $dataPostBack =  dbase::globalQueryPlus($sql_get_stats,$conn,2);
                    $complete_list=array();
                    if ($dataPostBack[1]>0){
                        $set = array();
                        $counter = 0;
                        while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                            if ($type=='location'){
                                $row['name']=ucwords(strtolower(trim($row['name'])));
                            }
                           
                            
                            
                            $row['stat']    = (strtolower($row['stat'])=='null' || $row['stat']==null)?0:$row['stat'];
                            $row['stat_f']  = (strtolower($row['stat_f'])=='null' || $row['stat_f']==null)?0:$row['stat_f'];
                            
                            $row['stat_vs_f']   = (strtolower($row['stat_vs_f'])=='null' || $row['stat_vs_f']==null)?0:$row['stat_vs_f'];
                            $row['stat_vs']     = (strtolower($row['stat_vs'])=='null' || $row['stat_vs']==null)?0:$row['stat_vs'];
                            
                            $complete_list      = sitestats::get_graph_trend_mini_sparks ($type,$row['code'],$days,$url);
                            
                            
                            $row['sparky']      = $complete_list['sparky'];
                            $row['sparky_vs']   = $complete_list['sparky_vs'];
                            $set[] = $row;
                            $counter ++;
                        }
                     
                        $set = general::array_orderby($set, 'stat', SORT_DESC,'stat_vs',SORT_DESC);
                        return $dataArray = array('data'=>$set,'Ack'=>'success','count'=>$counter,'repeater'=>general::getfile('../../ajax/html/rr_data_repeater_lp.php'));
                    
                    }
                    else{
                       
                        return $dataArray = array('Ack'=>'fail');;
                    }
    }
    
    
     
    
    public static function get_global_stats($narrowby,$element,$days,$orderby,$type,$search){
         
                $sql_get_stats = general::getFile('../../sql/sql_roarreport_'.$type.'_ss.php');
                
                global $conn;
                
                    if ($orderby=='visit'){
                        $sql_get_stats=str_replace("##order##"," t2.stat_vs DESC ", $sql_get_stats);
                       
                    }
                    else{
                        $sql_get_stats=str_replace("##order##"," t1.stat DESC ", $sql_get_stats);
                       
                    }
                    
                    if (trim($search)!=''){
                      
                        switch ($type){
                            case 'url':
                                
                                $sql_get_stats=str_replace("##narrow_visit##"," ##narrow_visit## AND vs.refurl='$search' " , $sql_get_stats);
                        
                                $sql_get_stats=str_replace("##narrow_user##"," ##narrow_user## AND ut.refurl='$search' "  , $sql_get_stats);
                        
                                break;
                            case 'refid':
                                
                                $sql_get_stats=str_replace("##narrow_visit##"," ##narrow_visit## AND vs.refid='$search' " , $sql_get_stats);
                        
                                $sql_get_stats=str_replace("##narrow_user##"," ##narrow_user## AND ut.refid='$search' "  , $sql_get_stats);
                        
                                break;
                            
                            case 'searchterm':
                                $searchterm_vs = general::queryLike($search,'vs.searchterm');
                                $searchterm_ut = general::queryLike($search,'ut.searchterm');
                                $sql_get_stats=str_replace("##narrow_visit##"," ##narrow_visit## AND ( $searchterm_vs ) " , $sql_get_stats);
                        
                                $sql_get_stats=str_replace("##narrow_user##"," ##narrow_user## AND ( $searchterm_ut ) "  , $sql_get_stats);
                        
                                break;
                            
                            case 'domain':
                                
                                $sql_get_stats=str_replace("##narrow_visit##"," ##narrow_visit## AND vs.refdomain='$search' " , $sql_get_stats);
                        
                                $sql_get_stats=str_replace("##narrow_user##"," ##narrow_user## AND ut.refdomain='$search' "  , $sql_get_stats);
                        
                                break;
                            
                            case 'date':
                                
                                $sql_get_stats=str_replace("##narrow_visit##"," ##narrow_visit## AND DATE_FORMAT(vs.date_visited,'%Y-%m-%d')=STR_TO_DATE('$search','%Y-%m-%d') " , $sql_get_stats);
                        
                                $sql_get_stats=str_replace("##narrow_user##"," ##narrow_user## AND DATE_FORMAT(ut.date_joined,'%Y-%m-%d')=STR_TO_DATE('$search','%Y-%m-%d') "  , $sql_get_stats);
                        
                                break;
                            
                            
                            
                        }
                        
                    }
                    
                    $sql_get_stats=str_replace("##days##",$days , $sql_get_stats);
                    $sql_get_stats = sitestats::narrow_by($sql_get_stats,$narrowby,$element);
                   //echo $sql_get_stats;
                    $dataPostBack =  dbase::globalQueryPlus($sql_get_stats,$conn,2);
                    $complete_list=array();
                    if ($dataPostBack[1]>0){
                        $set = array();
                        $counter = 0;
                        while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                            if ($type=='location'){
                                $row['name']=ucwords(strtolower(trim($row['name'])));
                            }
                           
                            
                            
                            $row['stat']    = (strtolower($row['stat'])=='null' || $row['stat']==null)?0:$row['stat'];
                            $row['stat_f']  = (strtolower($row['stat_f'])=='null' || $row['stat_f']==null)?0:$row['stat_f'];
                            
                            $row['stat_vs_f']   = (strtolower($row['stat_vs_f'])=='null' || $row['stat_vs_f']==null)?0:$row['stat_vs_f'];
                            $row['stat_vs']     = (strtolower($row['stat_vs'])=='null' || $row['stat_vs']==null)?0:$row['stat_vs'];
                            
                            $complete_list      = sitestats::get_graph_trend_mini_sparks ($type,$row['code'],$days,false);
                            $row['sparky']      = $complete_list['sparky'];
                            $row['sparky_vs']   = $complete_list['sparky_vs'];
                            $set[] = $row;
                            $counter ++;
                        }
                     
                        $set = general::array_orderby($set, 'stat', SORT_DESC,'stat_vs',SORT_DESC);
                        return $dataArray = array('data'=>$set,'Ack'=>'success','count'=>$counter,'repeater'=>sitestats::get_stat_file($narrowby));
                    
                    }
                    else{
                       
                        return $dataArray = array('Ack'=>'fail');;
                    }
    }
    
    
      public static function text_to_num_mapping($narrow_by){
    if (!is_numeric($narrow_by)){
     switch($narrow_by){
            case '' :
                return 0;
              
       
                
                break;
            case 'os':
          
                
                return 1;
      
                
                break;
            
            case 'location' :
       
                
                //narrow by loc
                return 2;
               
                
                break;
            
            case 'lang':
                
                //narrow by lang
                return 3;
                
                
                break;
            
            case 'url':
                
                //narrow by url
                 return 4;
             
                
                break;
            
            case 'browser' :
           
                
                //narrow by browser
                
                return 5;
                
                
                break;
            
             case 'date':
                
                //narrow by date
                return 6;
                
                break;
             case 'domain':
                return 7;
               
                
                break;
            case 'refid':
                
                return 8;
                
                break;
            case 'screenres':
                
                return 9;
                
                break;
            case 'searchengine':
                
                return 10;
                
                break;
            case 'searchterm':
                
                return 11;
                
                
                break;
           
            
            
            
            default:
                return 0;
               
                
                break;
        }
        
    }
    else{
        return $narrow_by;
    }
  }

    public static function getQuickStats_lp($url_lp){
        //number of members
        //number of reg members in last month
        //number of active members
        
        //top browser for reg
        //top os for reg
        //top country for reg
        //top lang for reg
        
        //total waiting activation
        //total banned/blocked
        //total active
        
        global $conn;
        
        $returnArray = array();
        
        
        $SQL_members = " SELECT SUM(IF(last_visit>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) AS activeusers,  "
                      ." SUM(IF(date_joined>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) AS lastmonthmembers, "
                      ." SUM(IF(valid=0,1,0)) AS waiting, "
                      ." SUM(IF(valid=2,1,0)) AS blocked, "
                      ." SUM(IF(valid=1,1,0)) AS active, "
                      ." SUM(IF(valid=0 AND date_joined<DATE_SUB(NOW(),INTERVAL 7 DAY),1,0)) AS waiting_week, "
                      ." SUM(IF(valid=0 AND date_joined<DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) AS waiting_month "
                      ." FROM user_table "
                      ." WHERE landingpage = '$url_lp' ";
                      
        $SQL_members_total = " SELECT *, FORMAT(IFNULL(ut.thirty_day - ut.sixty_day,0),0) AS difference,COALESCE(ROUND(((ut.thirty_day/(vs.thirty_day_visit))*100),1),0) AS precent30,COALESCE(ROUND(((ut.total/(vs.total_visits))*100),1),0) AS precent_all  "
                            ." FROM (SELECT FORMAT(COUNT(userid),0) AS total, "
                            ." SUM(IF(date_joined>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) AS thirty_day, "
                            ." SUM(IF(date_joined>DATE_SUB(NOW(),INTERVAL 60 DAY),1,0)) AS sixty_day "
                            ." FROM user_table WHERE landingpage = '$url_lp' ) AS ut, "
                            ." (SELECT COUNT(visitid) AS total_visits,  "
                            ." SUM(IF(date_visited>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) AS thirty_day_visit FROM visit_stats WHERE landingpage = '$url_lp' AND lp_flag = 1 ) AS vs ";
                            
                          //echo $SQL_members_total;
                            
       
        
        
        
        
        $dataPostBack =  dbase::globalQuery($SQL_members,$conn,2);
      
        //echo $SQL_stats_bw;
      
        if ($dataPostBack[1]>0){
            
            $returnArray['members']             = 'okay';
            $returnArray['activeusers']         = number_format($dataPostBack[0]['activeusers']);
            $returnArray['lastmonthmembers']    = number_format($dataPostBack[0]['lastmonthmembers']);
            $returnArray['waiting']             = number_format($dataPostBack[0]['waiting']);
            $returnArray['waiting_week']        = number_format($dataPostBack[0]['waiting_week']);
            $returnArray['waiting_month']       = number_format($dataPostBack[0]['waiting_month']);
            $returnArray['blocked']             = number_format($dataPostBack[0]['blocked']);
            $returnArray['active']              = number_format($dataPostBack[0]['active']);
            
            
        }
        else{
            $returnArray['members']='fail';
        }
      
      
        $dataPostBack =  dbase::globalQuery($SQL_members_total,$conn,2);
        if ($dataPostBack[1]>0){
            
           $returnArray['members_total']        =   'okay';
           $returnArray['total']                =   number_format($dataPostBack[0]['total']);
           $returnArray['total_visits']         =   $dataPostBack[0]['total_visits'];
           $returnArray['thirty_day']           =   $dataPostBack[0]['thirty_day'];
           $returnArray['sixty_day']            =   $dataPostBack[0]['sixty_day'];
           $returnArray['difference']           =   number_format($dataPostBack[0]['difference']);
           $returnArray['thirty_day_visit']     =   number_format($dataPostBack[0]['thirty_day_visit']);
           $returnArray['precent30']            =   $dataPostBack[0]['precent30'];
           $returnArray['precent_all']          =   $dataPostBack[0]['precent_all'];
           
           
           
        }
        else{
            $returnArray['members_total']       =   'fail';
        }
        
       
        return $returnArray;
        
    
    }
    
   
   
   
   
   public static function landingpages($limiter,$days,$order,$search){
        global $conn;
        
        $sql_lp = general::getFile('../../sql/sql_site_stats_landingpage.php');
        
        $sql_lp = str_replace('##days##',$days,$sql_lp);
        if (trim($order)=='landingpage'){
            $order = $order.' ASC';
        }
        else{
            $order = $order.' DESC';
        }
        if (trim($search)!=''){
            $search_vs = " AND landingpage = '$search' ";
            $search_ut = " AND landingpage = '$search' ";
        }
        else{
            $search_vs = "  ";
            $search_ut = "  ";
        }
        
        $sql_lp = str_replace('##order##',' s.'.trim($order).' ',$sql_lp);
        $sql_lp = str_replace('##limit##',$limiter,$sql_lp);
        
        
        
        $sql_lp = str_replace('##search_vs##',$search_vs,$sql_lp);
        $sql_lp = str_replace('##search_ut##',$search_ut,$sql_lp);
        
        $sql_lpc = general::getFile('../../sql/sql_site_stats_landingpage_count.php');
        $sql_lpc = str_replace('##days##',$days,$sql_lpc);
        $sql_lpc = str_replace('##order##','',$sql_lpc);
        
        $sql_lpc = str_replace('##search_vs##',$search_vs,$sql_lpc);
        $sql_lpc = str_replace('##search_ut##',$search_ut,$sql_lpc);
        //need counter
        //echo $sql_lp;
        //$sql_pv_c = general::getFile('../../sql/sql_site_stats_landingpage_c.php');
        
        $dataPostBack =  dbase::globalQuery($sql_lpc,$conn,2);
        if ($dataPostBack[1]>0){
            $counter = $dataPostBack[0]['pagecount'];
        }
        else{
            $counter=0;
        }
        
        
        $dataPostBack =  dbase::globalQueryPlus($sql_lp,$conn,2);
        
        if ($dataPostBack[1]>0){
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
               
            }
         
            
            return $dataArray = array('data'=>$set,'Ack'=>'success','count'=>$counter,'repeater'=>general::getFile('../../ajax/html/lp_repeater.php'));
        
        }
        else{
           
            return $dataArray = array('Ack'=>'fail');;
        }
    }

    public static function pageviews($limiter,$days,$order,$search){
        
        global $conn;
        $order = ($order=='pageview')?" pageview DESC ":" landingpage ASC ";
        $search_vs = (trim($search)!='')?" AND landingpage = '$search'":"";
        
        $sql_pv = " SELECT FORMAT(pageview,0) AS pageviews, landingpage FROM (SELECT IFNULL(COUNT(landingpage),0) AS pageview, landingpage FROM visit_stats "
                 ." WHERE date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) $search_vs"
                 ." GROUP BY landingpage ) AS t1 ORDER BY $order  LIMIT $limiter ";
                 
        $sql_pvc = " SELECT COUNT(*) AS pagecount FROM( "
                  ." SELECT COUNT(landingpage) AS pagecount FROM visit_stats "
                  ." WHERE date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) $search_vs"
                  ." GROUP BY landingpage ) AS t";
       // echo $sql_pv;
        $dataPostBack =  dbase::globalQuery($sql_pvc,$conn,2);
        if ($dataPostBack[1]>0){
            $counter = $dataPostBack[0]['pagecount'];
        }
        else{
            $counter=0;
        }
        
        $dataPostBack =  dbase::globalQueryPlus($sql_pv,$conn,2);
        
        if ($dataPostBack[1]>0){
            $set = array();
        
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                
            }
         
            
            return $dataArray = array('data'=>$set,'Ack'=>'success','count'=>$counter,'repeater'=>general::getFile('../../ajax/html/pv_repeater.php'));
        
        }
        else{
           
            return $dataArray = array('Ack'=>'fail');;
        }
        
    }




    public static function refurl($limiter,$days,$order,$search){
        
        global $conn;
        $order = ($order=='pageview')?" pageview DESC ":" refurl ASC ";
        $search_vs = (trim($search)!='')?" AND refurl = '$search'":"";
        
        $sql_ref = " SELECT FORMAT(pageview,0) AS pageviews, refurl FROM (SELECT IFNULL(COUNT(refurl),0) AS pageview, refurl FROM visit_stats "
                 ." WHERE date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) $search_vs"
                 ." GROUP BY refurl ) AS t1 ORDER BY $order  LIMIT $limiter ";
                 
        $sql_refc = " SELECT COUNT(*) AS pagecount FROM( "
                  ." SELECT COUNT(refurl) AS pagecount FROM visit_stats "
                  ." WHERE date_visited > DATE_SUB(NOW(),INTERVAL $days DAY) $search_vs"
                  ." GROUP BY refurl ) AS t";
       // echo $sql_pv;
        $dataPostBack =  dbase::globalQuery($sql_refc,$conn,2);
        if ($dataPostBack[1]>0){
            $counter = $dataPostBack[0]['pagecount'];
        }
        else{
            $counter=0;
        }
        
        $dataPostBack =  dbase::globalQueryPlus($sql_ref,$conn,2);
        
        if ($dataPostBack[1]>0){
            $set = array();
        
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                
            }
         
            
            return $dataArray = array('data'=>$set,'Ack'=>'success','count'=>$counter,'repeater'=>general::getFile('../../ajax/html/refurl_repeater.php'));
        
        }
        else{
           
            return $dataArray = array('Ack'=>'fail');;
        }
        
    }








}


?>