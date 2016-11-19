<?php
//insert record as non-paid account and wait for response - this page will be blank essentially
//paid=0 - br user
//paid=2 - awaiting payment
//paid=1 - fully paid
//paid=3 - membership lapsed
//paid=4 - invalid? or just set to awaiting?
//paid=5 - suspect?

//make this page as light as possible

        $postList = array("username_send","email_send","group_send","price_send","group_name");
        $sessionList = array("username_send","email_send","account_type","price_send","groupname_send","pw1_send");
        if (general::globalIsSet($_POST,$postList) && general::globalIsSet($_SESSION,$sessionList)){
            
            
            $username   = dbase::globalMagic(trim($_SESSION['username_send']));
            $password   = dbase::globalMagic(trim($_SESSION['pw1_send']));

            $email      = dbase::globalMagic(trim($_SESSION['email_send']));
            $ipad       = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
            $group =  $account_type    = dbase::globalMagic(trim($_SESSION['account_type']));
            
            $group_name     = dbase::globalMagic(trim($_SESSION['groupname_send']));
            
            $fee = $price   = dbase::globalMagic(trim($_SESSION['price_send']));
            
            
            
            if(isset($_SESSION['reg_check']) && $group >= 4){
                //echo $username.$email.$password.$price.$earlybird.$contact.$ipad.$earlyBird_code;
               
                if($_SESSION['reg_check'] == md5($_POST['username_send'].$_POST['email_send'].$_POST['group_send'].$_POST['price_send'].$_POST['group_name'])){
                    
                   
                    
                    $browser    = general::getBrowser();
                    $os         = general::getOS();
                    
                    $lang       = general::getLang();
                    $country    = general::getCountry();
                    $screenres  = general::getScreenRes();
                    
                    if (isset($_SESSION['refurl'])){
           
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
            
                    $salt = general::generate_salt();
                    $password_hash = general::doubleSalt($password,$salt);
                    
                    $openid = '';
                        $acti_code = time();
                        $valid=0;
                        $paid=0;
                        $contact=1;
                        
                    $keys_values = array(
                                "userid"=>"NULL",
                                "username"=>$username,
                                "screenname"=>$username,
                                "p_hash"=>$password_hash,
                                "s_hash"=>$salt,
                                "valid"=>$valid,
                                "acti_code"=>$acti_code,
                                "ipad"=>$ipad,
                                "date_joined"=>"now()",
                                "lastip"=>"no visit",
                                "last_visit"=>"",
                                "email"=>$email,
                                "gravtar_email"=>"",
                                "usergroup"=>$group,
                                "temppass"=>"",
                                "tpdate"=>"",
                                "tpip"=>"",
                                "tp_flag"=>0,
                                "browser"=>$browser,
                                "os"=>$os,
                                "lang"=>$lang,
                                "country"=>$country,
                                "refid"=>dbase::globalMagic($_SESSION['refid']),
                                "refurl"=>dbase::globalMagic($_SESSION['refurl']),
                                "refdomain"=>dbase::globalMagic($_SESSION['refdomain']),
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
                                "authentication_source"=>"userbase",
                                "paid"=>$paid,
                                "send_process"=>true
                             
                             );
                   
                    //$responseVal = Admin::addUser($email,$username,$group,$password_hash,$salt,$acti_code,$valid,$ipad,$os,$browser,$lang,$country,$contact,dbase::globalMagic($_SESSION['refurl']),dbase::globalMagic($_SESSION['refdomain']),dbase::globalMagic($_SESSION['refid']),$screenres,$searchengine,$searchterm,$fee,$paid,$earlyBird_code,$earlybird,'',$landingpage);
                    $responseVal = Admin::addUser($keys_values);
                    $torf = (isset($responseVal['Ack']))?true:false;
                    if ($torf){
                        global $conn;
                        //all went well - re-direct to paypal
                        $userid = $responseVal['userid'];
                        
                        $keys_values = array(
                                             "pid"=>'NULL',
                                             "amount"=>$price,
                                             "site"=>SITE_DOMAIN,
                                             "comment"=>'paypal order started (register)',
                                             "action"=>'paypal order started',
                                             "valid"=>2,
                                             "date_time"=>'now()',
                                             "userid"=>$userid,
                                             "adminid"=>'-9',
                                             "ipad"=>$ipad,
                                             "group"=>$group,
                                             "type"=>'newreg'
                
                                             );
                        
                        
                       // $sql_update_payments = "INSERT INTO payments VALUES (NULL,'$price','yourdomain.com','paypal order started (register)','paypal order started','$userid','-9',1,2,now(),'$ipad','','','$group','newreg')";
            
                       // $dataPostBack =  dbase::globalQuery($sql_update_payments,$conn,1);
                        $dataPostBack = dbase::basic_queries("payments",false,$keys_values,"INSERT",false);
                        if($dataPostBack[1]==1){
                            $invoiceNumber = $dataPostBack[0];
                        }
                        else{
                            //failed - remove user?
                            $sql_delete_failed_user = "DELETE FROM user_table WHERE userid='$userid' LIMIT 1";
                            $dataPostBack =  dbase::globalQuery($sql_delete_failed_user,$conn,3);
                            
                            //output error - re-direct to error page
                            header("Location: error.php?q=registration_failed_05");
                            exit;
                        }
                        
                    }
                    else{
                        
                        //output error - re-direct to error page
                        header("Location: error.php?q=registration_failed_01");
                        exit;
                    }
                    
                    
                    
                }
                else{
                    //output data change error - suspect?
                    header("Location: error.php?q=registration_failed_02");
                    exit;
                }
            }
            else{
                //output error
                header("Location: error.php?q=registration_failed_03");
                exit;
            }
        }
        else{
            //output error
            header("Location: error.php?q=registration_failed_04");
            exit;
        }



?>