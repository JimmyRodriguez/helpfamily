<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/

class Admin{
    
    //new for v1.3
    
    
    public static function renew_upgrade_buttons($group_array,$type){
        /*$new_str=implode(",", $group_array);
        
        $sql = "SELECT * FROM user_groups WHERE groupid IN ($new_str)";
        $dataPostBack =  dbase::globalQueryPlus($sqlGetFeeDate,$conn,2);
        */
       // if($dataPostBack[1]>0){
            $form_fee_array = array();
        //    $dataarray = dbase::loop_to_array($dataPostBack[0]);
            foreach ($group_array as $key){
                
                //get each groups fee, id and create the group buttons
                //$form_fee_array[$key."_fee"] = Admin::search_multi_array($data_array,$key);
                
                if($type=='renew'){
                     $form_fee_array[$key] =
                                "
                                <form method='post' action='renew.php' name='renew_$key'>
                                <input type='hidden' value='$key' id='renew_group' name='renew_group'/>
                                <button onclick='document.renew_$key.submit();' class='button_sum'>confirm &amp; page</button> 
                                </form>
                            ";
                    
                }
                else{
                    $form_fee_array[$key] =
                                "
                                <form method='post' action='upgrading.php' name='upgrade_$key'>
                                <input type='hidden' value='$key' id='upgrade_group' name='upgrade_group'/>
                               
                                <button onclick='document.upgrade_$key.submit();' class='button_sum'>confirm &amp; page</button>
                                
                                
                                </form>
                            ";
                }
               
                
            }
            
            return $form_fee_array;
       // }
      //  else{
      //      return false;
       // }
    }
    
    public static function search_multi_array($arr,$match){
        foreach ($arr as $key=>$value){
            if($arr[$key]['groupid'] == $match)
                return $arr[$key]['fee'];
        }
    }
    
    public static function getFeeDate($userid){
        
        global $conn;
        
        $sqlGetFeeDate = " SELECT ut.userid, ut.fee, DATE_FORMAT(ut.renew_date,'%d/%m/%Y') AS renew_date, ut.paid "
                        ." FROM user_table AS ut "
                        ." WHERE userid='$userid' LIMIT 1";
                        
        $dataPostBack =  dbase::globalQuery($sqlGetFeeDate,$conn,2);
        
        if($dataPostBack[1]==1){
            
            return $dataPostBack[0];
            
        }
        else{
            return false;
        }
        
    }
    
    public static function saveNewFeeDate($userid,$fee,$date){
        
        global $conn;
        
        $sqlUpdateFeeDate = " UPDATE user_table "
                        ." SET paid=1, fee='$fee', renew_date=DATE_FORMAT(STR_TO_DATE('$date','%d/%m/%Y'),'%Y/%m/%d') "
                        ." WHERE userid='$userid'";
                     
        $dataPostBack =  dbase::globalQuery($sqlUpdateFeeDate,$conn,3);
        
        if($dataPostBack[1]!=-1){
            
            return true;
            
        }
        else{
            return false;
        }
        
    }
    
    public static function getPaymentHistory($userid,$limit,$source,$admin){
        
        global $conn;
        
        
        
        
        if ($source==1){
            $select = "*,DATE_FORMAT(date_time,'%d/%m/%Y %H:%i:%S') AS date_time_formatted";
             $restricted = '';
        }
        elseif ($source==2){
            $select = "pid,action,amount,DATE_FORMAT(date_time,'%d/%m/%Y %H:%i:%S') AS date_time_formatted";
            $restricted = 'AND valid=1 AND amount>0';
        }
        
        $sqlGetPaymentHistory = " SELECT  $select FROM payments "
                               ." WHERE userid='$userid'  $restricted ORDER BY date_time ASC LIMIT $limit";
               //   echo     $sqlGetPaymentHistory;  
        $dataPostBack =  dbase::globalQueryPlus($sqlGetPaymentHistory,$conn,2);
        
        if($dataPostBack[1]>0){
            
            $sqlGetUser_count = "SELECT count(pid) AS counter FROM payments WHERE userid='$userid'  $restricted; ";
            $dataPostBack_count =  dbase::globalQuery($sqlGetUser_count,$conn,2);
            $resultsCount = $dataPostBack_count[0];
            
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
            }
            
            
           

            
            $responseArray = array('Ack'=>'success','data'=>$set,'total_count'=>$resultsCount['counter']);
            
            return $responseArray;
            
            
       
            
        }
        else{
            return false;
        }
        
    }
    
    public static function savePayment($amount,$userid,$ipad,$comment){
        
        global $conn;
        $keys_values = array(
                                             "pid"=>'NULL',
                                             "amount"=>$amount,
                                             "site"=>SITE_DOMAIN,
                                             "comment"=>$comment,
                                             "action"=>'admin-payment',
                                             "valid"=>1,
                                             "date_time"=>'now()',
                                             "userid"=>$userid,
                                             "adminid"=>$_SESSION['userid'],
                                             "ipad"=>$ipad,
                                             "group"=>'',
                                             "type"=>'admin-payment',
                                             "txn_id"=>'admin-payment',
                                             "or_invoice" =>''
                                             );
        
        $dataPostBack = dbase::basic_queries("payments",false,$keys_values,"INSERT",false);
       
       // $sqlSavePayment = "INSERT INTO payments VALUES (NULL,'$amount','$site','$comment','admin-payment','$userid','".$_SESSION['userid']."','$siteid',1,now(),'$ipad','','','','');";
       // $dataPostBack =  dbase::globalQuery($sqlSavePayment,$conn,1);
        //echo $sqlSavePayment;
        if($dataPostBack[1]==1){
            
            return true;
            
        }
        else{
            return false;
        }
    }
    
    
    public static function update_user_and_payments_ipn($data){
            
             
            global $conn;
            $amount_status =$amount= $data['amount'];
            if ($data['paid']==2){
                $amount =0;
            }
           // var_dump($data);
            
            $notpending = true;
            //need to take into account pending
            switch ($data['source']){
                case 'newreg':
                    //new register
                    //$sql_update_payments = "INSERT INTO payments VALUES (NULL,'$amount',".SITENAME.",'paypal payment (register) (".$data['status']." for - &#163;$amount_status)','paypal payment','".$data['userid']."','-9',1,1,now(),'".$data['ipad']."','".$data['txn_id']."','".$data['invoice']."','','".$data['source']."')";
                   
                   $keys_values = array(
                                             "pid"=>'NULL',
                                             "amount"=>$amount,
                                             "site"=>SITE_DOMAIN,
                                             "comment"=>"paypal payment (register) (".$data['status']." for - &#163;$amount_status)",
                                             "action"=>'paypal payment',
                                             "valid"=>1,
                                             "date_time"=>'now()',
                                             "userid"=>$data['userid'],
                                             "adminid"=>'-9',
                                             "ipad"=>$data['ipad'],
                                             "group"=>$data['group'],
                                             "type"=>$data['source'],
                                             "txn_id"=>$data['txn_id'],
                                             "or_invoice" =>$data['invoice']
                                             );
                   
                   
                    if($data['valid'] ==1){
                        //ie it's not pending
                        $sql_update_user = "UPDATE user_table SET valid='".$data['valid']."', fee='$amount', paid='".$data['paid']."',renew_date=DATE_ADD( now( ) , INTERVAL ".$data['expire']." DAY ) WHERE userid='".$data['userid']."'";
                    }
                    else{
                        //do nothing? - cant update user yet
                        $notpending=false;
                    }
                    
                    break;
                case 'upgrade':
                    //upgrade - ebird code?
                    //update group + paid + new renewal fee + renewal date + check if 
                 
                   // $sql_update_payments = "INSERT INTO payments VALUES (NULL,'$amount','".SITENAME."','paypal payment (upgrade) ('".$data['status']."' for - &#163;$amount_status)','paypal payment','".$data['userid']."','-9',1,1,now(),'$ipad','$txn_id','$invoice','','$source')";
                    
                    $keys_values = array(
                                             "pid"=>'NULL',
                                             "amount"=>$amount,
                                             "site"=>SITE_DOMAIN,
                                             "comment"=>"paypal payment (upgrade) (".$data['status']." for - &#163;$amount_status)",
                                             "action"=>'paypal payment',
                                             "valid"=>1,
                                             "date_time"=>'now()',
                                             "userid"=>$data['userid'],
                                             "adminid"=>'-9',
                                             "ipad"=>$data['ipad'],
                                             "group"=>$data['group'],
                                             "type"=>$data['source'],
                                             "txn_id"=>$data['txn_id'],
                                             "or_invoice" =>$data['invoice']
                                             );
                    
                    if($data['valid'] ==1){
                        //ie it's not pending
                   
                        $sql_update_user = "UPDATE user_table SET fee='$amount', renew_date=DATE_ADD( renew_date , INTERVAL ".$data['expire']." DAY ), paid='".$data['paid']."', usergroup ='".$data['group']."',fee='$amount' WHERE userid='".$data['userid']."'";
                    
                    }
                    else{
                        //do nothing? - cant update user yet
                        $notpending=false;
                    }
                    
                    break;
                case 'renew':
                    //renew
                    //$sql_update_payments = "INSERT INTO payments VALUES (NULL,'$amount','".SITENAME."','paypal payment (renew) ($status for - &#163;$amount_status)','paypal payment','$userid','-9',1,1,now(),'$ipad','$txn_id','$invoice','','$source')";
                    $keys_values = array(
                                             "pid"=>'NULL',
                                             "amount"=>$amount,
                                             "site"=>SITE_DOMAIN,
                                             "comment"=>"paypal payment (renew) (".$data['status']." for - &#163;$amount_status)",
                                             "action"=>'paypal payment',
                                             "valid"=>1,
                                             "date_time"=>'now()',
                                             "userid"=>$data['userid'],
                                             "adminid"=>'-9',
                                             "ipad"=>$data['ipad'],
                                             "group"=>$data['group'],
                                             "type"=>$data['source'],
                                             "txn_id"=>$data['txn_id'],
                                             "or_invoice" =>$data['invoice']
                                             );
                    if($data['valid'] ==1){
                        //ie it's not pending
                        $sql_update_user = "UPDATE user_table SET fee='$amount',renew_date=DATE_ADD( now( ) , INTERVAL ".$data['expire']." DAY ), paid='".$data['paid']."' WHERE userid='".$data['userid']."'";
                    }
                    else{
                        //do nothing? - cant update user yet
                        $notpending=false;
                    }
                    
                    break;
                
            }
            
            //echo $sql_update_user;
            //$dataPostBack =  dbase::globalQuery($sql_update_payments,$conn,1);
            $dataPostBack = dbase::basic_queries("payments",false,$keys_values,"INSERT",false);
            if($dataPostBack[1]!=-1){
                
                if ($notpending){
                    $dataPostBack =  dbase::globalQuery($sql_update_user,$conn,3);
        
                    if($dataPostBack[1]!=-1){
                        
                        return 'okay';
                        
                    }
                    else{
                        return 'failed_user';
                    }
                }
                else{
                    //essentially IPN log is done
                    return 'okay';
                }
                
            }
            else{
            
                return 'failed_payment';
            }
            
            
            
            
        
    } 
    
    
    public static function get_user($userid,$sessions,$call_type,$use_alias){
        global $user_request;
        
        $key_values = $user_request[$call_type];
        $id_key = array ("userid"=>$userid);
        
        $dataArray  = dbase::select_db_item($id_key,$key_values,'user_table','','',false);
      
        //loop for setting up alias
        if($dataArray['Ack']=='success'){
            $data = array();
            foreach ($dataArray['data'] as $key => $value){
                if (!is_numeric($key)){
                    if($use_alias && strtolower($call_type)!='all')
                        $data[$user_request[$call_type][$key]] = $value;
                    else
                        $data[$key] = $value;
                        
                    if ($sessions)
                        $_SESSION[$key] = $value;
                }
                    
            }
            return $data;
        }
        else{
            return false;
            
        }
        
        
        
    }
    
    
    public static function get_main_attempts_lf($loc,$limit){
        
        global $conn;
        if((trim($loc)!='' && $loc!='false')){
            if(trim($loc) == 'user'){
                $loc_sql = " AND loc IN ('user','usersms') ";
            }
            else{
                $loc_sql = " AND loc='$loc' ";
            }
        }
        else{
            
            $loc_sql='';
        }
       
        
        
        $sqlGetAlerts = " SELECT setid,
                                 loc,
                                 LOWER(name) AS name,
                                 DATE_FORMAT(MAX(current_attempt), '%d/%m/%Y %H:%i:%s') AS todate,
                                 DATE_FORMAT(inital_attempt, '%d/%m/%Y %H:%i:%s') AS fromdate,
         
                                 ipad,
                                 refurl,
                                 failedid,
                                 COUNT(failedid) AS counter
        
                            FROM
                            failed_login, stats_country_iso_codes
                            
                            WHERE code = country $loc_sql 
                            GROUP BY setid ORDER BY inital_attempt DESC LIMIT $limit ";



        $dataPostBack =  dbase::globalQueryPlus($sqlGetAlerts,$conn,2);
      
        
        
        if ($dataPostBack[1]>0){
         
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
            }
            
            $sql_count = " SELECT COUNT(setid) AS total_count
                            FROM
                            failed_login, stats_country_iso_codes
                            
                            WHERE code = country $loc_sql AND setid=failedid ";
                            
            $dataPostBack =  dbase::globalQuery($sql_count,$conn,2);
       
            if ($dataPostBack[1]==1){
                $total_count = $dataPostBack[0]['total_count'];
            }
            else{
                $total_count = 0;
            }
            
            $Alerts = $set;
           
            return  array("total_count"=>$total_count,"Ack"=>'success', 'data'=>$Alerts, "Msg"=>'data found','repeater'=>general::getFile('../../ajax/html/main-lf-attempts.php'));
        }
        else{
            
             return  array("Ack"=>'fail', "Msg"=>'Woops, no data found.');
        }
        
       
        
        
    }
    
    public static function get_all_attempts_lf($id){
        
        global $conn;
        $sqlGetAlerts = "(select username,LOWER(name) AS name, DATE_FORMAT(current_attempt, '%d/%m/%Y %H:%i:%s') AS current_attempt, ipad,refurl

                            FROM
                            failed_login, stats_country_iso_codes
                            
                            WHERE code = country 
                            AND setid='$id'
                            
                          )";



        $dataPostBack =  dbase::globalQueryPlus($sqlGetAlerts,$conn,2);
      
        if ($dataPostBack[1]>0){
         
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
            }
            $Alerts = $set;
           
            return  array("Ack"=>'success', 'data'=>$Alerts, "Msg"=>'data found','repeater'=>general::getFile('../../ajax/html/all-lf-attempts.php'));
        }
        else{
            
             return  array("Ack"=>'fail', "Msg"=>'Woops, no data found.');
        }
        
       
        
        
    }
    
    public static function getDashData(){
        
     
        global $conn;
        
        

       

        $sqlGetAlerts = "(select loc,LOWER(name) AS name,
                                    DATE_FORMAT(MAX(current_attempt), '%d/%m/%Y %H:%i:%s') AS todate,
                                 DATE_FORMAT(inital_attempt, '%d/%m/%Y %H:%i:%s') AS fromdate,
                            ipad,refurl,failedid,count(failedid) AS counter FROM
                            failed_login, stats_country_iso_codes
                            
                            WHERE code = country AND loc = 'admin'
                            
                            GROUP BY setid ORDER BY inital_attempt DESC LIMIT 0,5)
                            
                            UNION
                            (select loc,LOWER(name) AS name,
                            DATE_FORMAT(MAX(current_attempt), '%d/%m/%Y %H:%i:%s') AS todate,
                                 DATE_FORMAT(inital_attempt, '%d/%m/%Y %H:%i:%s') AS fromdate,
                            ipad,refurl,failedid,count(failedid) AS counter FROM
                            failed_login, stats_country_iso_codes
                            
                            WHERE code = country AND loc IN ('user','usersms')
                            
                            GROUP BY setid ORDER BY inital_attempt DESC LIMIT 0,5) ";



        $dataPostBack =  dbase::globalQueryPlus($sqlGetAlerts,$conn,2);
      

        if ($dataPostBack[1]>0){
         
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
            }
            $Alerts = $set;
            $alertsAck = 'success';
        }
        else{
            
            $Alerts = 'Phew! No login alerts found.';
            $alertsAck = 'fail';
        }
        
        $sqlGetUsersNew = "SELECT screenname, userid, email AS graveimg, DATE_FORMAT(date_joined,'%d/%m/%Y %H:%i:%S') AS date_joined_formatted, date_joined FROM user_table WHERE valid=1 OR valid=0 ORDER BY date_joined DESC LIMIT 0,10";


        $dataPostBack =  dbase::globalQueryPlus($sqlGetUsersNew,$conn,2);
      
  
        if ($dataPostBack[1]>0){
         
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
            }
            
            $increment = 0;
            foreach($set as $value){
                
                $set[$increment]['graveimg'] = md5(strtolower(trim($set[$increment]['graveimg'])));
                

                $increment++;
                
            }
            
            $newUsers = $set;
            $nuAck = 'success';
        }
        else{
            
            $newUsers = 'no users found...';
            $nuAck = 'fail';
        
        }
        
        //get files
        
     
        $filecontentFLA     = file_get_contents('../../ajax/html/alerts_login_repeater.php');
        $filecontentNU      = file_get_contents('../../ajax/html/newuser_repeater_1.php');
        $filecontentNUAlt   = file_get_contents('../../ajax/html/newuser_repeater_alt.php');
        
        $stats_data         = Admin::getQuickStats();
            
        //check 'false' status at js level
        
        
        $responseArray = array('alertAck'=>$alertsAck,'loginalerts'=>$Alerts,'alert_fla_file'=>$filecontentFLA,'NUAck'=>$nuAck,'newusers'=>$newUsers,'newuserfile'=>$filecontentNU,'newuserfile_alt'=>$filecontentNUAlt,'statsdata'=>$stats_data);
        
        
        
            
        return $responseArray;
        
        
    }
    

    
    public static function deleteUser($userid){
        
        global $conn;
        
        /*
            if you dont actually want to delete the user but prevent them listing in
            results swap with the sql code below.
            
            NOTE: Not sure if valid=3 prevents them showing up in the list anymore
        */
        //$sqlDeleteUser = "UPDATE user_table SET valid='3' WHERE userid=".$userid;
        
        $sqlDeleteUser = "DELETE FROM user_table WHERE userid='$userid' LIMIT 1";
        $dataPostBack=  dbase::globalQuery($sqlDeleteUser,$conn,3);
        if ($dataPostBack[1] > 0){
            
            return true;
            
        }
        else{
            
            return false;
            
        }
        
    }
    
    public static function changeUserStatus ($status,$userid){
        
        
        /*
            awaiting activation = 0
            valid = 1
            banned = 2
            others - defined later
        
        */
        global $conn;
        
        $sqlChangeUserStatus = "UPDATE user_table SET valid='".$status."' WHERE userid=".$userid;
        $dataPostBack =  dbase::globalQuery($sqlChangeUserStatus,$conn,3);
        
        if ($dataPostBack[1]!=-1){
            
            return true;
            
        }
        else{
            
            return false;
            
        }
    }
    
    
   
  
    public static function changeUserGroup($newGroup){
        
        
        /*
         
            presets that cannot be deleted
            
            1   = admin
            2   = moderators/editors
            3   = normal user
            
            --
            
            others set by admin
        */
        
        
        
        $sqlChangeUserGroup = "UPDATE user_table SET usergroup = $newGroup WHERE userid=".$this->userId;
        $dataPostBack =  dbase::globalQuery($sqlChangeUserGroup,$conn,3);
        
        if ($dataPostBack[1]!=-1){
            
            return true;
            
        }
        else{
            
            return false;
            
        }
        
        
    }
    
    public static function editUserGroupName($newName,$groupDesc,$groupid,$group_type,$group_fee,$group_expire){
        
        global $conn;
        
        $noDeleteEdit = array(1,2,3);
        
        if (in_array($groupid,$noDeleteEdit)){
            return false;
        }
        else{
            $sqlChangeUserGroup = "UPDATE user_groups SET expire_in_days='$group_expire', fee='$group_fee',group_type='$group_type', name = '$newName', descip='$groupDesc' WHERE groupid=".$groupid;
            
     
            $dataPostBack =  dbase::globalQuery($sqlChangeUserGroup,$conn,3);
            
            if ($dataPostBack[1]!=-1){
                
                return true;
                
            }
            else{
                
                return false;
                
            }
        }
        
        
    }
    
    public static function deleteUserGroup($groupid){
        global $conn;
        $noDeleteEdit = array(1,2,3,4);
        
        //cannot delete admin,mods,assistants 
        
        if (in_array($groupid,$noDeleteEdit)){
            return array("Ack"=>"fail", "Msg"=>"This user group cannot be deleted.");
        }
        else{
            
            $sql_check = "SELECT userid FROM user_table WHERE usergroup = '$groupid'";
            $dataPostBack =  dbase::globalQuery($sql_check,$conn,2);
          
            if ($dataPostBack[1]==0){
                
                
                $sql_delete_group = "DELETE FROM user_groups WHERE groupid=".$groupid;
                $dataPostBack =  dbase::globalQuery($sql_delete_group,$conn,3);
                //echo $sql_delete_group;
                if ($dataPostBack[1]!=-1){
                    
                    return array("Ack"=>"success", "Msg"=>"This user group has been deleted.");
                    
                }
                else{
                    
                    return array("Ack"=>"fail", "Msg"=>"Oops! Not sure what went wrong there. Refresh the page and try again.");
                    
                }
                
            }
            else{
                
                return array("Ack"=>"fail", "Msg"=>"Oops! Sorry, can't delete this group as there are users attached to this group. ");
                    
                
            }
            
        }
    }
    
    public static function editUserGroupStatus($status,$groupid){
        
        
        /*
         
            presets that cannot be deleted
            
            1= admin
            2= assistants
            3= mods
            
            --
            
            others set by admin
        */
        global $conn;
        $noDeleteEdit = array(1,2,3);
        
       
        
        if (in_array($groupid,$noDeleteEdit)){
            return false;
        }
        else{
            $sqlChangeUserGroup = "UPDATE user_groups SET valid = '$status' WHERE groupid=".$groupid;
            $dataPostBack =  dbase::globalQuery($sqlChangeUserGroup,$conn,3);
            
            if ($dataPostBack[1]!=-1){
                
                return true;
                
            }
            else{
                
                return false;
                
            }
        }
        
    }
    
    public static function addNewGroup($groupName,$groupdesc,$group_type,$group_fee,$group_expire){
        
        //global $conn;
        //$sqlInsertNewGroup = "INSERT INTO user_groups VALUES (NULL,'".$groupName."','".$groupdesc."',1);";
        //$dataPostBack =  dbase::globalQuery($sqlInsertNewGroup,$conn,1);
        
        
        $keys_values = array(
                                "groupid"=>"NULL",
                                "name"=>$groupName,
                                "descip"=>$groupdesc,
                                "valid"=>1,
                                "group_type"=>$group_type,
                                "fee"=>$group_fee,
                                "expire_in_days"=>$group_expire
                             
                             );
        
    
        $dataPostBack = dbase::basic_queries("user_groups",false,$keys_values,"INSERT",false);
        
        
        
        if ($dataPostBack[1]==1){
            return true;
        }
        else{
            return false;
        }
        
        
    }
    
    
  
   
    public static function getGroupData($groupId){
        
        global $conn;
        
        $sqlGetPage = "SELECT * FROM user_groups  WHERE groupid =".$groupId;
        $dataPostBack =  dbase::globalQuery($sqlGetPage,$conn,2);
    
        if ($dataPostBack[1]==1){
            
            
            $responseArray = array('Ack'=>'success','data'=>$dataPostBack[0]);
            
            return $responseArray;
           
            
        }
        else{
            
            return false;
            
        }
    }
   
    public static function track_visitor($os,$browser,$lang,$loc,$screenres,$reg_flag,$refid,$refurl,$refdom,$searchengine,$searchterm,$admin,$landingpage){
        global $conn;
        
        if (!isset($_SESSION['landing_id'])){
            
            $lp_id      = 0;
            $lp_flag    = 1;
            $parent_id  = 0;
            
        }
        else{
            
            $lp_id      = $_SESSION['landing_id'];
            $lp_flag    = 0;
            $parent_id  = $_SESSION['url_parentid'];
            
        }
        
        /*
        $sqlInsertVisit = "INSERT INTO visit_stats VALUES (NULL,'$reg_flag','$browser','$os','$lang','$loc',now(),'$refurl','$refdom','$refid','$screenres',0,'$searchengine','$searchterm','$admin','$landingpage','$lp_flag','$parent_id','$lp_id');";
        $dataPostBack =  dbase::globalQuery($sqlInsertVisit,$conn,1);
        */
        $keys_values = array(
                                "visitid"=>"NULL",
                                "reg_flag"=>$reg_flag,
                                "browser"=>$browser,
                                "os"=>$os,
                                "lang"=>$lang,
                                "country"=>$loc,
                                "date_visited"=>"now()",
                                "refurl"=>$refurl,
                                "refdomain"=>$refdom,
                                "refid"=>$refid,
                                "screenres"=>$screenres,
                                "userid"=>0,
                                "searchengine"=>$searchengine,
                                "searchterm"=>$searchterm,
                                "landingpage"=>$landingpage,
                                "admin_flag"=>$admin,
                                "lp_flag"=>$lp_flag,
                                "parent_id"=>$parent_id,
                                "landing_id"=>$lp_id

                             );
        
    
        $dataPostBack = dbase::basic_queries("visit_stats",false,$keys_values,"INSERT",false);
        
        




        if ($dataPostBack[1]==1){
            if (!isset($_SESSION['landing_id'])){
                $_SESSION['landing_id'] = $dataPostBack[0];
                
                $sql_lp_leader = "UPDATE visit_stats SET landing_id ='".$dataPostBack[0]."' WHERE visitid='".$dataPostBack[0]."'";
                $dataPostBack_update =  dbase::globalQuery($sql_lp_leader,$conn,1);
                if ($dataPostBack_update[1]!=-1){
                
                }
                else{
                    //log error if you want
                }
            }
            $_SESSION['url_parentid'] = $dataPostBack[0];
            
        }
        else{
            //may want to log failures?
        }
    }
    
    public static function resend_activation($useremail,$emailorusername){
        $key_values = array (
                             "username"=>'',
                             "email"=>'',
                             "acti_code"=>'',
                             "userid"=>''
                             );
        
        //1 = email
        if ($emailorusername==1)
            $id_key = array ("email"=>$useremail);
        else
            $id_key = array ("username"=>$useremail);
        
        
        $dataArray  = dbase::select_db_item($id_key,$key_values,'user_table','','',false);
        
        //loop for setting up alias
        if($dataArray['Ack']=='success'){
                if (ADMIN_ACTIVATED){
                    $emailfile = (!isset($_SESSION['js_enabled']))?NOJS_ADMINACT_NO_HTML:ADMINACT_NO_HTML;
                    $content = general::getFile($emailfile);
                  
                    
                    $content = str_replace('[[username]]',$dataArray['data']['username'],$content);
                    $content = str_replace('[[oursite]]',SITENAME,$content);
                    
                 
                    $subject = 'Welcome to '.SITENAME.' - you account has been created!';
                    
                    
                   
                    general::globalEmail($dataArray['data']['email'], REG_EMAIL, $content, $subject);
                }
                else{
                    $emailfile = (!isset($_SESSION['js_enabled']))?NOJS_ACTI_NO_HTML:ACTI_NO_HTML;
                    $content = general::getFile($emailfile);
                  
                    
                    $content = str_replace('[[username]]',$dataArray['data']['username'],$content);
                    $content = str_replace('[[oursite]]',SITENAME,$content);
                    
                    $content = str_replace('[[actiurl-sans-code]]',ACTIURL,$content);
                    $content = str_replace('[[actiurl]]',ACTIURL.'u='.md5($dataArray['data']['userid']).'&a='.$dataArray['data']['acti_code'],$content);
                    
                    $content = str_replace('[[parta]]',md5($dataArray['data']['userid']),$content);
                    $content = str_replace('[[partb]]',$dataArray['data']['acti_code'],$content);
                    
                    $subject = 'Welcome to '.SITENAME.' - you account has been registered!';
                    
                    
                   
                    general::globalEmail($dataArray['data']['email'], REG_EMAIL, $content, $subject);
                }
                return true;
        }
        else{
            return false;
            
        }
        
    }
   
    public static function addUser ($keys_values){
    
        
        //need to work out acticode and if account needs activation 0 yes, 1 active, 2 banned, ipad
        
        //global $conn;
        //$sqlInsertUser = "INSERT INTO user_table VALUES (NULL,'$username','$username','$phash','$salt','$valid','$acti_code','$ipad',now(),'no visit','','$email','','$groupid','','','','0','$browser','$os','$lang','$country','$refid','$url','$domain','$contact',NULL,NULL,'N/A','$screenres','$searchengine','$searchterm','','','','','$landingpage','$openid');";
        //$dataPostBack =  dbase::globalQuery($sqlInsertUser,$conn,1);

        /*
        
        This code is old from 1.1.5_beta onwards
        
        $keys_values = array(
                                "userid"=>"NULL",
                                "username"=>$username,
                                "screenname"=>$username,
                                "p_hash"=>$phash,
                                "s_hash"=>$salt,
                                "valid"=>$valid,
                                "acti_code"=>$acti_code,
                                "ipad"=>$ipad,
                                "date_joined"=>"now()",
                                "lastip"=>"no visit",
                                "last_visit"=>"",
                                "email"=>$email,
                                "gravtar_email"=>"",
                                "usergroup"=>$groupid,
                                "temppass"=>"",
                                "tpdate"=>"",
                                "tpip"=>"",
                                "tp_flag"=>0,
                                "browser"=>$browser,
                                "os"=>$os,
                                "lang"=>$lang,
                                "country"=>$country,
                                "refid"=>$refid,
                                "refurl"=>$url,
                                "refdomain"=>$domain,
                                "contact"=>$contact,
                                "fname"=>"NULL",
                                "sname"=>"NULL",
                                "mobilenum"=>"N/A",
                                "screenres"=>$screenres,
                                "searchengine"=>$searchengine,
                                "searchterm"=>$searchterm,
                                "smstok"=>"",
                                "smsip"=>"",
                                "smstimedate"=>"",
                                "oneuse"=>"",
                                "landingpage"=>$landingpage,
                                "openidurl"=>$openid,
                                "authentication_source"=>"userbase"
                             
                             );
        
        */
        
        $send_process = (isset($keys_values['send_process']))?true:false;
        unset($keys_values['send_process']);
        
        $dataPostBack = dbase::basic_queries("user_table",false,$keys_values,"INSERT",false);

        $username = $keys_values['username'];
        $email = $keys_values['email'];
        $acti_code = $keys_values['acti_code'];
        $valid = $keys_values['valid'];
        
        if ($dataPostBack[1]==1){
            $userid_return = $dataPostBack[2];
            //need to send email if valid=0
     
            if($valid==0){
              
                if (!$send_process){
                    if (ADMIN_ACTIVATED){
                        $emailfile = (!isset($_SESSION['js_enabled']))?NOJS_ADMINACT_NO_HTML:ADMINACT_NO_HTML;
                        $content = general::getFile($emailfile);
                      
                        
                        $content = str_replace('[[username]]',$username,$content);
                        $content = str_replace('[[oursite]]',SITENAME,$content);
                        
                     
                        $subject = 'Welcome to '.SITENAME.' - you account has been created!';
                        
                        
                       
                        general::globalEmail($email, REG_EMAIL, $content, $subject);
                    }
                    else{
                        $emailfile = (!isset($_SESSION['js_enabled']))?NOJS_ACTI_NO_HTML:ACTI_NO_HTML;
                        $content = general::getFile($emailfile);
                      
                        
                        $content = str_replace('[[username]]',$username,$content);
                        $content = str_replace('[[oursite]]',SITENAME,$content);
                        
                        $content = str_replace('[[actiurl-sans-code]]',ACTIURL,$content);
                        $content = str_replace('[[actiurl]]',ACTIURL.'u='.md5($dataPostBack[0]).'&a='.$acti_code,$content);
                        
                        $content = str_replace('[[parta]]',md5($dataPostBack[0]),$content);
                        $content = str_replace('[[partb]]',$acti_code,$content);
                        
                        $subject = 'Welcome to '.SITENAME.' - you account has been registered!';
                        
                        
                       
                       general::globalEmail($email, REG_EMAIL, $content, $subject);
                    }
                }
                else{
                    //no need to send email yet - wait till payment
                    return array('Ack'=>true,'userid'=>$userid_return);
                }
                
            }
            
            return true;
        }
        else{

            return false;
        }
        
    }
    
    
    public static function EditBlockIPDE($type,$desc,$block,$blockid,$area){
        
        
        
        global $conn;
        $sqlUpdateBlock =  "UPDATE security_blocks
                            SET blockvalue='$block',description='$desc', type ='$type', blockarea='$area'
                            WHERE blockid='$blockid'";
        $dataPostBack =  dbase::globalQuery($sqlUpdateBlock,$conn,1);
        //echo $sqlUpdateBlock;
        if ($dataPostBack[1]!=-1){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    public static function getBlockData($blockid){
        
        global $conn;
        
        $sqlGetBlock = "SELECT * FROM security_blocks  WHERE blockid =".$blockid;
        $dataPostBack =  dbase::globalQuery($sqlGetBlock,$conn,2);
       
        if ($dataPostBack[1]==1){
            
            
            $responseArray = array('Ack'=>'success','data'=>$dataPostBack[0]);
            
            return $responseArray;
           
            
        }
        else{
            
            return false;
            
        }
    }
   
    
    public static function blockIPDE($type,$desc,$block,$area){
        
        
        
        global $conn;
       // $sqlInsertNewBlock = "INSERT INTO security_blocks VALUES (NULL,'$block','$type','$desc',1,'$area');";
      //  $dataPostBack =  dbase::globalQuery($sqlInsertNewBlock,$conn,1);
        
        
        $keys_values = array(
                                "blockid"=>"NULL",
                                "blockvalue"=>$block,
                                "type"=>$type,
                                "description"=>$desc,
                                "valid"=>1,
                                "blockarea"=>$area
                               
                             
                             );
        
    
        $dataPostBack = dbase::basic_queries("security_blocks",false,$keys_values,"INSERT",false);
        
        if ($dataPostBack[1]==1){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    
    public static function getFullResultsBlock($query,$limit,$source,$type,$valid){
        
        global $conn;
        
        
        
            if (trim($query)!="" && $source !=1){
                if ($type!=-9){
                    $query_1 = " AND type='$type' AND blockvalue LIKE '%$query%' ";
                }
                else{
                    $query_1 = "  AND blockvalue LIKE '%$query%' ";
                }
                
                
            }
            else{
                if ($type!=-9){
                    $query_1 = ' AND type="'.$type.'" ';
                }
                else{
                    $query_1 = "   ";
                }
                
                
            }
            
            if ($valid==-9){
                $valid_sql = " valid<=2 ";
            }
            else{
                $valid_sql = " valid = '$valid' ";
            }
        
        
        $sqlGetBlock = "SELECT * FROM security_blocks WHERE $valid_sql $query_1 ORDER BY blockid ASC LIMIT ".$limit;
        $dataPostBack =  dbase::globalQueryPlus($sqlGetBlock,$conn,2);
       
        if ($dataPostBack[1]>0){
            
            $sqlGetBlock_count = "SELECT count(blockid) AS counter FROM security_blocks WHERE $valid_sql  $query_1";
            $dataPostBack_count =  dbase::globalQuery($sqlGetBlock_count,$conn,2);
            $resultsCount = $dataPostBack_count[0];
            
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
            }

            $repeater_file = general::getFile('../../ajax/html/block_repeater.php');
            $responseArray = array('Ack'=>'success','data'=>$set,'total_count'=>$resultsCount['counter'],'repeater'=>$repeater_file);
            
            return $responseArray;
           
            
        }
        else{
            
            return false;
            
        }
        
    }
    
    
    
    
    public static function changeStatusBlock($status,$blockid){
        
        global $conn;
        
        $sqlDelete = "UPDATE security_blocks SET  valid='$status' WHERE blockid=".$blockid;
        $dataPostBack =  dbase::globalQuery($sqlDelete,$conn,3);
        
      

        
        if ($dataPostBack[1]!=-1){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    
    public static function getUserLists($country,$browser,$os,$lang,$group){
        /*
            get all lists - country,browser,os,lang,usergroups
        */
         global $conn;
        $responseArray = array();
        $sqlGetCountries = 'SELECT * FROM stats_country_iso_codes ORDER BY name';
        $sqlGetLang = 'SELECT * FROM stats_lang ORDER BY language';
        $sqlGetOS = 'SELECT * FROM stats_os ORDER BY os_name';
        $sqlGetBrowser = 'SELECT * FROM stats_browser ORDER BY browser_name';
        $sqlGetUserGroups = 'SELECT groupid,name FROM user_groups WHERE valid=1 ORDER BY name';
        
        if ($country){
            $dataPostBack =  dbase::globalQueryPlus($sqlGetCountries,$conn,2);
        
    
    
            if ($dataPostBack[1]>0){
         
                $responseArray['countryAck'] = 'success';
                $set = array();
            
                while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                    $set[] = $row;
                    
                }
                $responseArray['countryData'] = $set;
                
               
            }
            else{
                
                $responseArray['countryAck'] = 'fail';
                $responseArray['countryData'] = 'fail';
    
            }
        }
            
        
        if ($lang){
            $dataPostBack =  dbase::globalQueryPlus($sqlGetLang,$conn,2);
    
            if ($dataPostBack[1]>0){
         
                    
                    $responseArray['langAck'] = 'success';
                    $set = array();
            
                    while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                        $set[] = $row;
                        
                    }
                    $responseArray['langData'] = $set;
            }
            else{
                    $responseArray['langAck'] = 'fail';
                    $responseArray['langData'] = 'fail';
    
    
            }
        }
        
        if ($os){
            $dataPostBack =  dbase::globalQueryPlus($sqlGetOS,$conn,2);
    
            if ($dataPostBack[1]>0){
         
       
                $responseArray['osAck'] = 'success';
                $set = array();
            
                while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                    $set[] = $row;
                    
                }
                $responseArray['osData'] = $set;
            }
            else{
    
                $responseArray['osAck'] = 'fail';
                $responseArray['osData'] = 'fail';
            }
        }
        if ($browser){
            $dataPostBack =  dbase::globalQueryPlus($sqlGetBrowser,$conn,2);
    
            if ($dataPostBack[1]>0){
         
    
                $responseArray['browserAck'] = 'success';
                $set = array();
            
                while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                    $set[] = $row;
                    
                }
                $responseArray['browserData'] = $set;
            }
            else{
    
                $responseArray['browserAck'] = 'fail';
                $responseArray['browserData'] = 'fail';
            }
        }
        
        if ($group){
            $dataPostBack =  dbase::globalQueryPlus($sqlGetUserGroups,$conn,2);
    
    
            if ($dataPostBack[1]>0){
         
    
                $responseArray['groupAck'] = 'success';
                $set = array();
            
                while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                    $set[] = $row;
                    
                }
                $responseArray['groupData'] = $set;
            }
            else{
    
                $responseArray['groupAck'] = 'fail';
                $responseArray['groupData'] = 'fail';
            }
        }
        return $responseArray;
      
        
        
    }
    
    
    public static function getUserData($userid){
        global $conn;
      
               
        $sqlGetUser = "  SELECT ug.name AS groupname, ug.groupid, ut.userid, ut.ipad, ut.screenname, ut.email, DATE_FORMAT(ut.last_visit, '%d/%m/%Y %H:%i:%s') AS last_visit, sb.browser_name, sb.browser_code, "
                    ." ut.valid AS status_valid, ut.lastip, DATE_FORMAT(ut.date_joined, '%d/%m/%Y %H:%i:%s') AS date_joined, sl.language, sl.lang_code, ut.refid,ut.refurl, so.os_code,so.os_name,"
                    ." (IF(last_visit>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) AS useractive30,"
                    ." sc.name AS conname, sc.code,ut.refdomain, ut.mobilenum AS phone, ut.contact "
                    ." FROM user_table AS ut,stats_browser AS sb,stats_os AS so,stats_lang AS sl,stats_country_iso_codes AS sc, user_groups AS ug "
                    ."  WHERE ut.userid =".$userid." AND ut.country=sc.code AND ut.browser=sb.browser_code AND ut.os=so.os_code AND ut.lang = sl.lang_code AND ug.groupid = ut.usergroup LIMIT 1";

        
        
        
        $dataPostBack =  dbase::globalQuery($sqlGetUser,$conn,2);
       
        if ($dataPostBack[1]==1){
            
            $dataPostBack[0]['conname'] = ucwords(strtolower($dataPostBack[0]['conname']));
            $responseArray = array('Ack'=>'success','data'=>$dataPostBack[0]);
            
            return $responseArray;
            
            
            
        }
        else{
            
            return false;
            
        }
    }
    
    public static function getQuickStats(){
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
                      ." FROM user_table ";
                      
        $SQL_members_total = " SELECT *, FORMAT(IFNULL(ut.thirty_day - ut.sixty_day ,0),0) AS difference,COALESCE(ROUND(((ut.thirty_day/(vs.thirty_day_visit))*100),1),0) AS precent30,COALESCE(ROUND(((ut.total/(vs.total_visits))*100),1),0) AS precent_all  "
                            ." FROM (SELECT FORMAT(IFNULL(COUNT(userid),0),0) AS total, "
                            ." SUM(IF(date_joined>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) AS thirty_day, "
                            ." SUM(IF(date_joined>DATE_SUB(NOW(),INTERVAL 60 DAY),1,0)) AS sixty_day "
                            ." FROM user_table ) AS ut, "
                            ." (SELECT COUNT(visitid) AS total_visits, SUM(IF(reg_flag=0,1,0)) AS total_visits_regflag,  "
                            ." SUM(IF(date_visited>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) AS thirty_day_visit,SUM(IF(date_visited>DATE_SUB(NOW(),INTERVAL 30 DAY),IF(reg_flag=0,1,0),0)) AS thirty_day_visit_regflag FROM visit_stats WHERE  lp_flag=1 ) AS vs ";
                            
                    
        

        
        
        $dataPostBack =  dbase::globalQuery($SQL_members,$conn,2);
      
        
      
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
           $returnArray['total']                =   str_replace(",","",$dataPostBack[0]['total']);
           $returnArray['total_visits']         =   $dataPostBack[0]['total_visits'];
           //regflag - removes registered users who visit (if signed in via cookie - not sure what impact this would have)
           $returnArray['total_visits_regflag'] =   $dataPostBack[0]['total_visits_regflag'];
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
        
        $sql_quick_stats    = general::getFile('../../sql/quick_stats_user.php');
        $sql_quick_stats_vs = general::getFile('../../sql/quick_stats.php');
        
        $dataPostBack       =  dbase::globalQuery($sql_quick_stats,$conn,2);
        $dataPostBack_vs    =  dbase::globalQuery($sql_quick_stats_vs,$conn,2);
        if ($dataPostBack[1]>0){
            
            $returnArray['browser_count']       =   $dataPostBack[0]['browser_count'];
            $returnArray['browser_name']        =   $dataPostBack[0]['browser_name'];
            $returnArray['os_count']            =   $dataPostBack[0]['os_count'];
            $returnArray['os_name']             =   $dataPostBack[0]['os_name'];
            $returnArray['lang_count']          =   $dataPostBack[0]['lang_count'];
            $returnArray['lang_name']           =   $dataPostBack[0]['lang_name'];
            $returnArray['country_count']       =   $dataPostBack[0]['country_count'];
            $returnArray['country_name']        =   $dataPostBack[0]['country_name'];
                
            
            
            
            $returnArray['qs_stats']            =   'okay';
           
            
            
        }
        else{
            $returnArray['qs_stats']            =   'fail';
            
        }
        
         if ($dataPostBack_vs[1]>0){
                $returnArray['browser_count_v']     =   $dataPostBack_vs[0]['browser_count_v'];
                $returnArray['browser_name_v']      =   $dataPostBack_vs[0]['browser_name_v'];
                $returnArray['os_count_v']          =   $dataPostBack_vs[0]['os_count_v'];
                $returnArray['os_name_v']           =   $dataPostBack_vs[0]['os_name_v'];
                $returnArray['lang_count_v']        =   $dataPostBack_vs[0]['lang_count_v'];
                $returnArray['lang_name_v']         =   $dataPostBack_vs[0]['lang_name_v'];
                $returnArray['country_count_v']     =   $dataPostBack_vs[0]['country_count_v'];
                $returnArray['country_name_v']      =   $dataPostBack_vs[0]['country_name_v'];
                
                $returnArray['qs_stats_vs']         =   'okay';
        }
        else{
            $returnArray['qs_stats_vs']             =   'fail';
        }
        
       
        return $returnArray;
        
    
    }
    
    public static function clickatell_sms($msg,$mobnumber){
        
        $mobnumber = str_replace('+','',$mobnumber);
        
        $msg = urlencode($msg);
        $data = "user=".CLICKATELLUSER."&password=".CLICKATELLPASS."&api_id=".CLICKATELLAPIID."&to=$mobnumber&text=$msg";
        
        // Send the POST request with cURL
        $ch = curl_init('http://api.clickatell.com/http/sendmsg');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); //This is the result from clickatell
        curl_close($ch);
  
        
        if($result !== false){
            
            if (strpos(strtolower($result),'err:')!==false){
                $res_arr = explode(',',$result);
                return array('Ack'=>'fail','Msg'=>$res_arr[1]);
            }
            else{
                //assuming that the message was sent as 'err:' not present in the data returned - as per clickatell support guidelines
                return array('Ack'=>'success','Msg'=>'Message sent');
            }
        }else{
            return array('Ack'=>'fail','Msg'=>'Cannot connect to messaging service provider.');
        }
    
    
    }
   
    public static function txtlocal_sms($msg,$mobnumber){
       
        
        // Configuration variables - see txtlocal.com website>developer>documentation
        $info = "0";
        $test = "0";
        $json = "1";
        
    
        $mobnumber = str_replace('+','',$mobnumber);
        
        $msg = urlencode($msg);
   
        // see config file for pass/user/site name values
        $data = "uname=".TXTLOCALUSER."&pword=".TXTLOCALPASS."&message=".$msg."&from=". SITENAME."&selectednums=".$mobnumber."&info=".$info."&test=".$test."&json=$json";
             //echo $data;
        // Send the POST request with cURL
        $ch = curl_init('http://www.txtlocal.com/sendsmspost.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); //This is the result from Txtlocal
        curl_close($ch);
        
        if($result !==false){
       
            $results_array = json_decode($result,true);
     
            if (count($results_array)>0){
                //if error is present then it failed - else it went well.
                if(isset($results_array['Error'])){
                    return array('Ack'=>'fail','Msg'=>$results_array['Error']);
                }
                else{
                    return array('Ack'=>'success','Msg'=>'Message sent');
                }
            }
            else{
                return array('Ack'=>'fail','Msg'=>'unknown messaging error.');
            }
           
         }else{
            return array('Ack'=>'fail','Msg'=>'Cannot connect to messaging service provider.');
         }
        
        
        /*
        
            // Send the POST request with Sockets
            $url = 'http://www.txtlocal.com/sendsmspost.php';
            $params = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $data));
            $ctx = stream_context_create($params);
            $fp = fopen($url, 'rb', false, $ctx);
            $response = stream_get_contents($fp);
             
            return $response;
        */
    }
   
    public static function sendSMS($serviceProvider,$msg,$mobnumber){
     
        switch($serviceProvider){
            case 'txtlocal':
                
                //txtlocal
                return Admin::txtlocal_sms($msg,$mobnumber);
                
                break;
            case 'clickatell':
                
                //clicktell
                return Admin::clickatell_sms($msg,$mobnumber);
                
                break;
            case false:
                //get global setting from config file
                
                switch(SMS_PROVIDER){
                    case 'txtlocal':
                        
                        //txtlocal
                        return Admin::txtlocal_sms($msg,$mobnumber);
                        
                        break;
                    case 'clickatell':
                        
                        //clicktell
                        return Admin::clickatell_sms($msg,$mobnumber);
                        break;
                    
                }
                
                
                break;
        }
     
        //get authorisation from config file
    }
   
    public static function sendSMStoken($mobnumber,$userid){
        
        
        //generate token
        $token = time()+$userid;
        
        
        
        $serviceProvider = 1;
        $msg = "Your 24 hour security token is: $token";
        
        return Admin::sendSMS(false,$msg,$mobnumber);
        
        
    }
   
    public static function sendEmail($subject,$content,$email){
        
        general::globalEmail($email, ADMIN_EMAIL, $content, $subject);
        
        return $responseArray = array('Ack'=>'success','Msg'=>'Your email has been sent.');
        
    }
   
   
    public static function editUser($email,$phash,$password,$salt,$groupid,$username,$userid,$country,$lang,$refid,$refurl,$status,$os,$browser,$contact,$phone,$domain,$lastip,$lastdate,$regip,$regdate){
        
        
        global $conn;
        
        if (trim($password)!='false'){
            $passsql = ",p_hash='$phash' ,s_hash='$salt'";
        }
        else{
            $passsql = "";
        }
        
        $sqlUpdateUser = " UPDATE user_table SET email='$email' $passsql ,usergroup='$groupid',screenname='$username', username='$username', country='$country',lang='$lang',refid='$refid', refurl='$refurl',valid='$status',os='$os',browser='$browser', contact='$contact', mobilenum='$phone', refdomain='$domain', ipad='$regip',date_joined='$regdate', lastip='$lastip',last_visit='$lastdate' "
                        ." WHERE userid='$userid' ; ";
                        
        $dataPostBack =  dbase::globalQuery($sqlUpdateUser,$conn,1);
       
        if ($dataPostBack[1] != -1){
            return true;
        }
        else{
            return false;
        }
        
   
    }
    
    public static function getUserResults($userid,$username,$email,$groupid,$limit,$orderby,$direction,$country,$browser,$os,$lang,$status,$last_visit,$lastip,$regdate,$regip,$refid,$refurl,$refdomain,$contact,$phone,$active,$history,$inital_load){
        
        global $conn;
        
       
   
        
        $whereSql='';
      
        
        $orderbySql='';
        $orderbySql_2='';
        
        if (trim($userid)!='' && $userid != -9){


            $whereSql .= " AND ut.userid = '$userid'";
        }
        
        if (trim($username)!=''){
           // $usernameSql = " , MATCH (screenname) AGAINST ('$username' in boolean mode) AS relevance ";
          
            $whereSql .= " AND LOWER(ut.screenname) LIKE '%".strtolower($username)."%'  ";
        }
       
        if (trim($email)!=''){

            $whereSql .= " AND LOWER(ut.email) = '".strtolower($email)."' ";
        }
        
        if (trim($groupid)!='' && $groupid!=0 && $groupid!=-9){

            $whereSql .= " AND ut.usergroup = '$groupid' ";
         
        }
        
        if (trim($country)!='' && $country!=-9){
            $whereSql .= " AND ut.country = '$country' ";
        }
        
        if (trim($browser)!='' && $browser!=-9){
            $whereSql .= " AND ut.browser = '$browser' ";
        }
        
        if (trim($lang)!='' && $lang!=-9){
            $whereSql .= " AND ut.lang = '$lang' ";
        }
        
        if (trim($os)!='' && $os!=-9){
            $whereSql .= " AND ut.os = '$os' ";
        }
        
        if (trim($status)!='' && $status!=-9){
            $whereSql .= " AND ut.valid = '$status' ";
        }
        
        if (trim($last_visit)!=''){
            $whereSql .= " AND DATE_FORMAT(ut.last_visit,'%d/%m/%Y') = DATE_FORMAT(STR_TO_DATE('$last_visit','%d/%m/%Y'),'%d/%m/%Y') ";
        }
        
        if (trim($lastip)!=''){
            $whereSql .= " AND ut.lastip = '$lastip' ";
        }
        
        if (trim($regip)!=''){
            $whereSql .= " AND ut.ipad = '$regip' ";
        }
        
        if (trim($regdate)!=''){
            $whereSql .= " AND DATE_FORMAT(ut.date_joined,'%d/%m/%Y') = DATE_FORMAT(STR_TO_DATE('$regdate','%d/%m/%Y'),'%d/%m/%Y') ";
        }
        
        if (trim($refid)!=''){
            $whereSql .= " AND ut.refid = '$refid' ";
        }
        
        if (trim($refurl)!=''){
            $whereSql .= " AND ut.refurl = '$refurl' ";
        }
        
        if (trim($refdomain)!=''){
            $whereSql .= " AND ut.refdomain = '$refdomain' ";
        }
        
        if (trim($contact)!='' && trim($contact)!=-9){
            $whereSql .= " AND ut.contact = '$contact' ";
        }
        
        if (trim($phone)!=''){
            $whereSql .= " AND ut.mobilenum = '$phone' ";
        }
        
        if (trim($active)!='' && $active!=-9){
            
            $whereSql .= " AND (IF(ut.last_visit>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) = '$active' ";
        }
     

        
        $orderbySql_2 = $direction==0?' ASC ':' DESC ';
        
        switch ($orderby){
            case 0:
                $orderbySql = ' ORDER BY ut.screenname ';
                break;
            case 1:
                $orderbySql = ' ORDER BY ut.email ';
                break;
            case 2:
                $orderbySql = ' ORDER BY ut.date_joined ';
                break;
            case 3:
                $orderbySql = ' ORDER BY ut.userid ';
                break;
            case 4:
                $orderbySql = ' ORDER BY ut.last_visit ';
                break;
            case 5:
                $orderbySql = ' ORDER BY sc.name ';
                break;
            case 6:
                $orderbySql = ' ORDER BY ug.name ';
                break;
            case 7:
                $orderbySql = ' ORDER BY ut.valid ';
                break;
            default:
                $orderbySql = ' ORDER BY ut.screenname ';
                break;
        }
        
       /* if ($groupSql_2 != '' && $emailSql_2 !=''){
            $emailSql_2 = ' AND '.$emailSql_2;
        }
        
        if ($groupSql_2 != '' && $usernameSql_2 !=''){
            $usernameSql_2 = ' AND '.$usernameSql_2;
        }
        
        if ($emailSql_2 != '' && $usernameSql_2 !=''){
                $usernameSql_2 = ' AND '.$usernameSql_2;
        }*/
        
        
        
        $detailed_view_sqlextra=', ut.refid, ut.refurl,ut.refdomain, (IF(ut.last_visit>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) AS useractive30,sb.browser_name, so.os_name, sl.language, sl.lang_code, sb.browser_code,so.os_code,ut.usergroup, ut.mobilenum AS phone, ut.contact ';
        $detailed_from_sqlextra=' stats_os AS so, stats_browser AS sb, stats_lang AS sl ';
        $detailed_where_sqlextra=' AND ut.lang = sl.lang_code AND ut.browser = sb.browser_code AND so.os_code=ut.os ';
        
        
       
        
        $sqlGetUser = "SELECT sc.name AS country,sc.code AS country_code, ut.userid,ug.name, ut.screenname,ut.email,DATE_FORMAT(ut.date_joined, '%d/%m/%Y %H:%i:%s') AS date_joined,ut.ipad,ut.lastip,DATE_FORMAT(ut.last_visit, '%d/%m/%Y %H:%i:%s') AS last_visit,ut.valid  $detailed_view_sqlextra"
                     ." FROM user_table AS ut,user_groups AS ug, stats_country_iso_codes AS sc, $detailed_from_sqlextra "
                     ." WHERE ut.usergroup=ug.groupid AND sc.code=ut.country AND ut.valid!=3  $whereSql  $detailed_where_sqlextra  $orderbySql $orderbySql_2 LIMIT $limit";
       
        $dataPostBack           =  dbase::globalQueryPlus($sqlGetUser,$conn,2);
        
      
      
        if ($dataPostBack[1]>0){
            
            $sqlGetUser_count = "SELECT count(userid) AS row_count FROM user_table AS ut,user_groups,stats_country_iso_codes, $detailed_from_sqlextra WHERE ut.usergroup=groupid AND ut.country=code  $whereSql $detailed_where_sqlextra ";
            $dataPostBack_count =  dbase::globalQuery($sqlGetUser_count,$conn,2);
            $resultsCount = $dataPostBack_count[0];
           
   
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
                
            }
            
            if($history && $inital_load!='false'){
                    $sqlGetHistory = "SELECT sc.name AS country,sc.code AS country_code, ut.userid,ug.name, ut.screenname,ut.email,DATE_FORMAT(ut.date_joined, '%d/%m/%Y %H:%i:%s') AS date_joined,ut.ipad,ut.lastip,DATE_FORMAT(ut.last_visit, '%d/%m/%Y %H:%i:%s') AS last_visit,ut.valid  $detailed_view_sqlextra"
                             ." FROM user_table AS ut,user_groups AS ug, stats_country_iso_codes AS sc, $detailed_from_sqlextra "
                             ." WHERE ut.usergroup=ug.groupid AND sc.code=ut.country AND ut.valid!=3  AND ut.userid IN (".dbase::globalMagic($_SESSION['history']).")  $detailed_where_sqlextra ";
             
                    $dataPostBackHistory    =  dbase::globalQueryPlus($sqlGetHistory,$conn,2);
                    
                    if ($dataPostBackHistory[1]>0){
                        $setH = array();
                    
                        while($rowH = mysql_fetch_array($dataPostBackHistory[0],MYSQL_ASSOC)) {
                            $setH[] = $rowH;
                            
                        }
                        $history=true;
                    }
                    else{
                        $setH=false;
                        $history=false;
                    }
            }
            else{
                $setH=false;
                $history=false;
            }
            $repeater_file = general::getFile('../../ajax/html/user_repeater_qv.php');
            
            $responseArray = array('Ack'=>'success','data'=>$set,'total_count'=>$resultsCount['row_count'],'repeater'=>$repeater_file,'history'=>$history,'hdata'=>$setH);
            
            return $responseArray;
            
            
            
        }
        else{
            
            $responseArray = array('Ack'=>'fail');
            
            return $responseArray;
            
        }
        
    }
    
    
    public static function getFullGroupResults($limit){
        global $conn;

        //match (screenname) against ('$query' in boolean mode) AS relevance
        
        $sqlGetGroup = "SELECT * FROM user_groups WHERE valid=1 ORDER BY name ASC LIMIT $limit";


        $dataPostBack =  dbase::globalQueryPlus($sqlGetGroup,$conn,2);
      
        
        if ($dataPostBack[1]>0){
            
           
            $sqlGetGroup_count = "SELECT count(groupid) AS counter FROM user_groups WHERE valid=1";
            $dataPostBack_count =  dbase::globalQuery($sqlGetGroup_count,$conn,2);
            $resultsCount = $dataPostBack_count[0];
           
           
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
            }

            $repeater_file = general::getFile('../../ajax/html/group_repeater.php');
            
            $responseArray = array('Ack'=>'success','data'=>$set,'total_count'=>$resultsCount['counter'],'repeater'=>$repeater_file);
            
            return $responseArray;
            
           
            
        }
        else{
            
            $responseArray = array('Ack'=>'fail');
            
            return $responseArray;
            
        }
    }
    
    
    
    
    
   
    
    public static function set_mass_status($userid,$username,$email,$groupid,$limit,$orderby,$direction,$country,$browser,$os,$lang,$status,$last_visit,$lastip,$regdate,$regip,$refid,$refurl,$refdomain,$contact,$phone,$active,$new_status){
        
        $whereSql='';
      
        
        $orderbySql='';
        $orderbySql_2='';
        
        if (trim($userid)!='' && $userid != -9){


            $whereSql .= " AND ut.userid = '$userid'";
        }
        
        if (trim($username)!=''){
           // $usernameSql = " , MATCH (screenname) AGAINST ('$username' in boolean mode) AS relevance ";
          
            $whereSql .= " AND LOWER(ut.screenname) LIKE '%".strtolower($username)."%'  ";
        }
       
        if (trim($email)!=''){

            $whereSql .= " AND LOWER(ut.email) = '".strtolower($email)."' ";
        }
        
        if (trim($groupid)!='' && $groupid!=0 && $groupid!=-9){

            $whereSql .= " AND ut.usergroup = '$groupid' ";
         
        }
        
        if (trim($country)!='' && $country!=-9){
            $whereSql .= " AND ut.country = '$country' ";
        }
        
        if (trim($browser)!='' && $browser!=-9){
            $whereSql .= " AND ut.browser = '$browser' ";
        }
        
        if (trim($lang)!='' && $lang!=-9){
            $whereSql .= " AND ut.lang = '$lang' ";
        }
        
        if (trim($os)!='' && $os!=-9){
            $whereSql .= " AND ut.os = '$os' ";
        }
        
        if (trim($status)!='' && $status!=-9){
            $whereSql .= " AND ut.valid = '$status' ";
        }
        
        if (trim($last_visit)!=''){
            $whereSql .= " AND DATE_FORMAT(ut.last_visit,'%d/%m/%Y') = DATE_FORMAT(STR_TO_DATE('$last_visit','%d/%m/%Y'),'%d/%m/%Y') ";
        }
        
        if (trim($lastip)!=''){
            $whereSql .= " AND ut.lastip = '$lastip' ";
        }
        
        if (trim($regip)!=''){
            $whereSql .= " AND ut.ipad = '$regip' ";
        }
        
        if (trim($regdate)!=''){
            $whereSql .= " AND DATE_FORMAT(ut.date_joined,'%d/%m/%Y') = DATE_FORMAT(STR_TO_DATE('$regdate','%d/%m/%Y'),'%d/%m/%Y') ";
        }
        
        if (trim($refid)!=''){
            $whereSql .= " AND ut.refid = '$refid' ";
        }
        
        if (trim($refurl)!=''){
            $whereSql .= " AND ut.refurl = '$refurl' ";
        }
        
        if (trim($refdomain)!=''){
            $whereSql .= " AND ut.refdomain = '$refdomain' ";
        }
        
        if (trim($contact)!='' && trim($contact)!=-9){
            $whereSql .= " AND ut.contact = '$contact' ";
        }
        
        if (trim($phone)!=''){
            $whereSql .= " AND ut.mobilenum = '$phone' ";
        }
        
        if (trim($active)!='' && $active!=-9){
            
            $whereSql .= " AND (IF(ut.last_visit>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) = '$active' ";
        }
     

        
        $orderbySql_2 = $direction==0?' ASC ':' DESC ';
        
        switch ($orderby){
            case 0:
                $orderbySql = ' ORDER BY ut.screenname ';
                break;
            case 1:
                $orderbySql = ' ORDER BY ut.email ';
                break;
            case 2:
                $orderbySql = ' ORDER BY ut.date_joined ';
                break;
            case 3:
                $orderbySql = ' ORDER BY ut.userid ';
                break;
            case 4:
                $orderbySql = ' ORDER BY ut.last_visit ';
                break;
            case 5:
                $orderbySql = ' ORDER BY sc.name ';
                break;
            case 6:
                $orderbySql = ' ORDER BY ug.name ';
                break;
            case 7:
                $orderbySql = ' ORDER BY ut.valid ';
                break;
            default:
                $orderbySql = ' ORDER BY ut.screenname ';
                break;
        }
        
       
        
        
        
        
       
        $detailed_where_sqlextra=' AND ut.lang = sl.lang_code AND ut.browser = sb.browser_code AND so.os_code=ut.os ';
        
        
        $sql_update_mass_status = " UPDATE user_table SET valid ='$new_status' WHERE userid IN ( SELECT work_around.userid FROM ( SELECT ut.userid"
                     ." FROM user_table AS ut,user_groups AS ug, stats_country_iso_codes AS sc,stats_os AS so, stats_browser AS sb, stats_lang AS sl   "
                     ." WHERE ut.usergroup=ug.groupid AND sc.code=ut.country AND ut.valid!=3  $whereSql  $detailed_where_sqlextra    ) AS work_around);";

        
        global $conn;
        
        $dataPostBack   =  dbase::globalQueryPlus($sql_update_mass_status,$conn,2);



            if ($dataPostBack[1]!=-1){
                
               
                
               
                
               
                return true;
        
            }
            else{
                return false;
            }
            
        
        
    }
    
    
    public static function getCSVData($userid,$username,$email,$groupid,$limit,$orderby,$direction,$country,$browser,$os,$lang,$status,$last_visit,$lastip,$regdate,$regip,$refid,$refurl,$refdomain,$contact,$phone,$active){
        
        $whereSql='';
      
        
        $orderbySql='';
        $orderbySql_2='';
        
        if (trim($userid)!='' && $userid != -9){


            $whereSql .= " AND ut.userid = '$userid'";
        }
        
        if (trim($username)!=''){
           // $usernameSql = " , MATCH (screenname) AGAINST ('$username' in boolean mode) AS relevance ";
          
            $whereSql .= " AND LOWER(ut.screenname) LIKE '%".strtolower($username)."%'  ";
        }
       
        if (trim($email)!=''){

            $whereSql .= " AND LOWER(ut.email) = '".strtolower($email)."' ";
        }
        
        if (trim($groupid)!='' && $groupid!=0 && $groupid!=-9){

            $whereSql .= " AND ut.usergroup = '$groupid' ";
         
        }
        
        if (trim($country)!='' && $country!=-9){
            $whereSql .= " AND ut.country = '$country' ";
        }
        
        if (trim($browser)!='' && $browser!=-9){
            $whereSql .= " AND ut.browser = '$browser' ";
        }
        
        if (trim($lang)!='' && $lang!=-9){
            $whereSql .= " AND ut.lang = '$lang' ";
        }
        
        if (trim($os)!='' && $os!=-9){
            $whereSql .= " AND ut.os = '$os' ";
        }
        
        if (trim($status)!='' && $status!=-9){
            $whereSql .= " AND ut.valid = '$status' ";
        }
        
        if (trim($last_visit)!=''){
            $whereSql .= " AND DATE_FORMAT(ut.last_visit,'%d/%m/%Y') = DATE_FORMAT(STR_TO_DATE('$last_visit','%d/%m/%Y'),'%d/%m/%Y') ";
        }
        
        if (trim($lastip)!=''){
            $whereSql .= " AND ut.lastip = '$lastip' ";
        }
        
        if (trim($regip)!=''){
            $whereSql .= " AND ut.ipad = '$regip' ";
        }
        
        if (trim($regdate)!=''){
            $whereSql .= " AND DATE_FORMAT(ut.date_joined,'%d/%m/%Y') = DATE_FORMAT(STR_TO_DATE('$regdate','%d/%m/%Y'),'%d/%m/%Y') ";
        }
        
        if (trim($refid)!=''){
            $whereSql .= " AND ut.refid = '$refid' ";
        }
        
        if (trim($refurl)!=''){
            $whereSql .= " AND ut.refurl = '$refurl' ";
        }
        
        if (trim($refdomain)!=''){
            $whereSql .= " AND ut.refdomain = '$refdomain' ";
        }
        
        if (trim($contact)!='' && trim($contact)!=-9){
            $whereSql .= " AND ut.contact = '$contact' ";
        }
        
        if (trim($phone)!=''){
            $whereSql .= " AND ut.mobilenum = '$phone' ";
        }
        
        if (trim($active)!='' && $active!=-9){
            
            $whereSql .= " AND (IF(ut.last_visit>DATE_SUB(NOW(),INTERVAL 30 DAY),1,0)) = '$active' ";
        }
     
  
        
        $orderbySql_2 = $direction==0?' ASC ':' DESC ';
        
        switch ($orderby){
            case 0:
                $orderbySql = ' ORDER BY ut.screenname ';
                break;
            case 1:
                $orderbySql = ' ORDER BY ut.email ';
                break;
            case 2:
                $orderbySql = ' ORDER BY ut.date_joined ';
                break;
            case 3:
                $orderbySql = ' ORDER BY ut.userid ';
                break;
            case 4:
                $orderbySql = ' ORDER BY ut.last_visit ';
                break;
            case 5:
                $orderbySql = ' ORDER BY sc.name ';
                break;
            case 6:
                $orderbySql = ' ORDER BY ug.name ';
                break;
            case 7:
                $orderbySql = ' ORDER BY ut.valid ';
                break;
            default:
                $orderbySql = ' ORDER BY ut.screenname ';
                break;
        }
        
       
        
        
        
        
        $detailed_from_sqlextra=' stats_os AS so, stats_browser AS sb, stats_lang AS sl ';
        $detailed_where_sqlextra=' AND ut.lang = sl.lang_code AND ut.browser = sb.browser_code AND so.os_code=ut.os ';
        
        
        $sqlGetMailingList = "SELECT ut.userid,ut.fname,ut.sname,ut.screenname,ut.email,ut.refid,IF(ut.contact=0,'NO','YES') AS contact"
                     ." FROM user_table AS ut,user_groups AS ug, stats_country_iso_codes AS sc, $detailed_from_sqlextra "
                     ." WHERE ut.usergroup=ug.groupid AND sc.code=ut.country AND ut.valid!=3  $whereSql  $detailed_where_sqlextra  $orderbySql $orderbySql_2 ";
       
        
        global $conn;
        
        $dataPostBack   =  dbase::globalQueryPlus($sqlGetMailingList,$conn,2);
        $results        = $dataPostBack[0];


            if ($dataPostBack[1]>0){
                
                $file = $_SESSION['username'].'_'.time().'.csv';
                $path = '../mailinglists/'.$file;
                $fp = @fopen($path,'w');
                
               
                
                while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {

                    @fputcsv($fp, $row,',');
                }
                
                @fclose($fp);
                 return 'mailinglists/'.$file;
        
            }
            else{
                return false;
            }
            
        
        
    }
    
    public static function addUserNote($userid,$note,$authorid){
        //global $conn;
        
        
   
        
        
        //$sqlInsertUserNote = "INSERT INTO notes VALUES (NULL, '$note', '$userid',2,$authorid,now(),1);";
        //$dataPostBack =  dbase::globalQuery($sqlInsertUserNote,$conn,1);
        
       $keys_values = array(
                                "noteid"=>"NULL",
                                "note"=>$note,
                                "elementid"=>$userid,
                                "element_type"=>2,
                                "userid"=>$authorid,
                                "dateposted"=>"now()",
                                "valid"=>1
                               
                             
                             );
        
    
        $dataPostBack = dbase::basic_queries("notes",false,$keys_values,"INSERT",false);
        
        
        if ($dataPostBack[1]==1){
            return true;
        }
        else{
            return false;
        }
    }
    
    public static function getUserNotes($userid){
         global $conn;
        $sqlGetUserNotes = "SELECT n.*, u.screenname, DATE_FORMAT(n.dateposted,'%D %M %Y (%k:%i:%s)') AS postdate FROM notes AS n, user_table AS u WHERE u.userid=n.userid AND n.valid=1 AND n.elementid='$userid' AND n.element_type=2 ORDER BY n.dateposted DESC";
        $dataPostBack =  dbase::globalQueryPlus($sqlGetUserNotes,$conn,2);
         if ($dataPostBack[1]>0){
            
            $sqlGetUserNotes_count = "SELECT COUNT(n.noteid) AS counter FROM notes AS n, user_table AS u WHERE u.userid=n.userid AND n.valid=1 AND n.elementid='$userid' AND n.element_type=2";
            $dataPostBack_count =  dbase::globalQuery($sqlGetUserNotes_count,$conn,2);
            $resultsCount = $dataPostBack_count[0];
            
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
               
            }
            //todo: can this be done inside the above loop?
            $increment = 0;
            foreach($set as $value){
                
                $set[$increment]['note'] = nl2br($set[$increment]['note']);
                

                $increment++;
                
            }
            $repeater_file = general::getFile('../../ajax/html/note_repeater.php');
            $responseArray = array('Ack'=>'success','data'=>$set,'total_count'=>$resultsCount['counter'],'note_repeater'=>$repeater_file);
            
            return $responseArray;
            
            
        }
        else{
            
            return false;
            
        }
    }
    
   
    
    
    
    //getUserGroupList? remove?
    public static function getUserGroupList(){
        
         global $conn;

        //match (screenname) against ('$query' in boolean mode) AS relevance
        
        $sqlGetGroup = "SELECT * FROM user_groups WHERE valid=1";


        $dataPostBack =  dbase::globalQueryPlus($sqlGetGroup,$conn,2);
      

        if ($dataPostBack[1]>0){
            
           
            
            $set = array();
            
            while($row = mysql_fetch_array($dataPostBack[0],MYSQL_ASSOC)) {
                $set[] = $row;
            }

            
            $responseArray = array('Ack'=>'success','data'=>$set);
            
            return $responseArray;
            
            
            
        }
        else{
            
            $responseArray = array('Ack'=>'fail');
            
            return $responseArray;
            
        }
        
    }
    
    public static function add_3rd_party_register($source,$email,$openid_url,$username_twitbook,$img_url){
            //ession_start();
            global $conn;
            $sql_check = "SELECT * FROM user_table WHERE openidurl='$openid_url' AND authentication_source='$source'";
	    
	    //if okay then update user table and create session
	    
	    
	    
	    $dataPostBack =  dbase::globalQuery($sql_check,$conn,2);
           
            
            if ($dataPostBack[1]==1){
      
                $userData = $dataPostBack[0];
		//create session data
                $_SESSION['logintype']      = $userData["authentication_source"];
		$_SESSION['username']       = $userData["screenname"];
		$_SESSION['userid']         = $userData["userid"];
		$_SESSION['usergroup']      = $userData["usergroup"];
		$_SESSION['tempsalt']       = general::generate_salt();
		$_SESSION['token']          = md5($_SERVER['HTTP_USER_AGENT'].$_SESSION['tempsalt']);
		
		$_SESSION['stale']          = time()+300;
		
		//do any other preference settings here like date formats etc
		
	       
		
		$ipad = $_SERVER['REMOTE_ADDR'];
                
		$sqlUpdateUser = "UPDATE user_table SET last_visit=now(), lastip='$ipad'  "
				     ." WHERE userid='".$userData["userid"]."' ;";
		    
		$dataPostBack =  dbase::globalQuery($sqlUpdateUser,$conn,1);
		
		if ($dataPostBack[1] != -1){
		  //may want to do something here?
		}
		else{
		  //or here if you need to log anything
		  //but for now if this fails, it just moves on.
		}
	    }
	    else{
		
	
		$ipad       = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
            
		$browser    = general::getBrowser();
		$os         = general::getOS();
		
		$lang       = general::getLang();
		$country    = general::getCountry();
		
		$screenres  = general::getScreenRes();
		$openid = '';
		//$referal  = general::getReferInfo();
		
		$contact    = 0;
		
		
		if (isset($_SESSION['refurl'])){
		    //which it should be
		    $search_engine_term         =   general::get_search_term_engine(dbase::globalMagic($_SESSION['refurl']));
		    
		    $searchengine               =   $search_engine_term['searchengine'];
		    $searchterm                 =   $search_engine_term['searchterm'];
		    
		}
		else{
		    $searchengine='none';
		    $searchterm='---';
		    
		}
		
		//should really be set by now
		if(isset($_SESSION['landingpage'])){
		    $landingpage                =   htmlentities(dbase::globalMagic($_SESSION['landingpage']));
		}
		else{
		    $landingpage='none';
		}
		
		//normal user
		$group = 4;
		$username = "guest_".rand(0,100).time();
                
                $username_twitbook = ($source=='openid')?$username:$username_twitbook;
                
		$keys_values = array(
			
			"username"=>$username,
			"screenname"=>$username_twitbook,
			"valid"=>1,
			"ipad"=>$ipad,
			"date_joined"=>"now()",
			"lastip"=>"no visit",
			"last_visit"=>"0000-00-00 00:00:00",
			"email"=>$email,
			"usergroup"=>$group,
			"tp_flag"=>0,
			"browser"=>$browser,
			"os"=>$os,
			"country"=>$country,
			"refid"=>(isset($_SESSION['refid']))?dbase::globalMagic($_SESSION['refid']):'',
			"refurl"=>(isset($_SESSION['refurl']))?dbase::globalMagic($_SESSION['refurl']):'',
			"refdomain"=>(isset($_SESSION['refdomain']))?dbase::globalMagic($_SESSION['refdomain']):'',
			"contact"=>0,
			"searchengine"=>$searchengine,
			"searchterm"=>$searchterm,
			"landingpage"=>$landingpage,
			"openidurl"=>$openid_url,
                        "authentication_source"=>$source,
                        "img_url"=>$img_url,
                        "img_flag"=>"1"
                             
		);
		
		$dataPostBack = dbase::basic_queries('user_table',false,$keys_values,'INSERT',false);
		$_SESSION['logintype']      = $source;
		$_SESSION['username']       = $username;
		$_SESSION['userid']         = $dataPostBack[0];
		$_SESSION['usergroup']      = $group;
		$_SESSION['tempsalt']       = general::generate_salt();
		$_SESSION['token']          = md5($_SERVER['HTTP_USER_AGENT'].$_SESSION['tempsalt']);
		
		$_SESSION['stale']          = time()+300;
	    }
    }
    
    

}


?>