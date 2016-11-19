<?php

        $postList = array("renew_group");
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){
            
            
            $username   = dbase::globalMagic(trim($_SESSION['username']));
            $userid     = dbase::globalMagic(trim($_SESSION['userid']));

           
            $ipad       = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
  

            $group      =  dbase::globalMagic(trim($_POST['renew_group']));
            $fee        =  general::globalGetOnePieceOfData('fee','user_groups','groupid='.$group);
        
            
            if(isset($_SESSION['renew_check']) && $group >= 4){
                    //echo $username.$email.$password.$price.$earlybird.$contact.$ipad.$earlyBird_code;
                
                    
                    //insert payment table or have new order table?
                   
                    //check fee against the one in database in ipn
                    $keys_values = array(
                                             "pid"=>'NULL',
                                             "amount"=>$fee,
                                             "site"=>SITE_DOMAIN,
                                             "comment"=>"paypal order started (renewing)",
                                             "action"=>'paypal order started',
                                             "valid"=>2,
                                             "date_time"=>'now()',
                                             "userid"=>$userid,
                                             "adminid"=>'-9',
                                             "ipad"=>$ipad,
                                             "group"=>$group,
                                             "type"=>'renew'
                
                                             );
               // $sql_update_payments = "INSERT INTO payments VALUES (NULL,'$fee','nadlabs.com','paypal order started (renewing)','paypal order started','$userid','-9',1,2,now(),'$ipad','','','$group','renew')";
            
               // $dataPostBack =  dbase::globalQuery($sql_update_payments,$conn,1);
               $dataPostBack = dbase::basic_queries("payments",false,$keys_values,"INSERT",false);
                if($dataPostBack[1]==1){
                     $invoiceNumber = $dataPostBack[0];
                }
                else{
                   
                    
                    //output error - re-direct to error page
                    header("Location: error.php?q=renew_failed_01");
                    exit;
                }
                      
                   
                    
                    
                    
                    
               
            }
            else{
                //output error
                header("Location: error.php?q=renew_failed_03");
                exit;
            }
        }
        else{
            //output error
            header("Location: error.php?q=renew_failed_04");
            exit;
        }


?>