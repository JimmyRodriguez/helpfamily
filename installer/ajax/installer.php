<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    Please read the full text of the nl-DFLA-mini licence for this software at
    
    http://www.nadlabs.co.uk/licence.php

*/
define ('APP_INC_PATH','../../includes/');
require_once("../../includes/lightwork_general.php");
error_reporting(0);

session_start();




        $postList = array("dbserver","dbname","dbusername","dbpassword","dbtestdata","recap_pub","recap_pri");
       
       
       
        if (general::globalIsSet($_POST,$postList)){

            $empty=false;
           $configpath = "../../config/config_global.php";
            foreach ($_POST as $key =>  $value){
                if(is_empty($value) && $key != 'dbpassword' ){
                    $empty = true;
                    break; 
                }
            }
          
            if($empty){
                $dataArray = array("Ack"=>"fail", "Msg"=>"Please enter all fields as they are all required.");
            }
            else{
                
                //add config file data
                
                //create database
                
                //inset test data if required
                
                if(file_exists($configpath) ){
                    if (is_writable($configpath)) {
                        if($fh = fopen($configpath,"r+"))
                        {
                            $contents = file_get_contents($configpath);
                            file_put_contents($configpath, "");

                            $contents = preg_replace('/##dbserver##/',$_POST['dbserver'],$contents);
                            $contents = preg_replace('/##dbname##/',$_POST['dbname'],$contents);
                            $contents = preg_replace('/##dbusername##/',$_POST['dbusername'],$contents);
                            $contents = preg_replace('/##dbpassword##/',$_POST['dbpassword'],$contents);
                            $contents = preg_replace('/##recap_pub##/',$_POST['recap_pub'],$contents);
                            $contents = preg_replace('/##recap_pri##/',$_POST['recap_pri'],$contents);
                            
                            if (fwrite($fh, $contents) === FALSE) {
                                $dataArray = array("Ack"=>"fail", "Msg"=>"Could not write to the <b>config/config_global.php</b> file.");
                            }
                            else{
                                //access database
                                $mysqli = new mysqli($_POST['dbserver'], $_POST['dbusername'], $_POST['dbpassword'], $_POST['dbname']);
                                
                                if (mysqli_connect_error()) {
                                  
                                  $dataArray = array("Ack"=>"fail", "Msg"=>"Could not access the database.");
                                }
                                else{
                                    //should really test if these things exist etc - in next version of the installer
                                        $mainsql = file_get_contents('../sql/main_sql.sql');
                            
                                        $mainsql = str_replace('##dbname##',$_POST['dbname'],$mainsql);
                                      
                                        
                                        if (!$mysqli->multi_query($mainsql)){
                                            
                                            $dataArray = array("Ack"=>"fail", "Msg"=>"Could not create database.");
                             
                                        }
                                        else{
                                          do { $mysqli->use_result(); }
                                          while( $mysqli->next_result() );
                                   
                                            if($_POST['dbtestdata']==1){
                                                
                                                
                                               $testdata = file_get_contents('../sql/ubase_test_data.sql');
                                               $testdata .= file_get_contents('../sql/site_stats_test_data.sql');
                                               $testdata = str_replace('##dbname##',$_POST['dbname'],$testdata);
                                               
                                             
                                                
                                                if (!$mysqli->multi_query($testdata)){
                                                   
                                                    $dataArray = array("Ack"=>"fail", "Msg"=>"Could not load test data.");
                                                }
                                                else{
                                                    $dataArray = array("Ack"=>"success", "Msg"=>"success");
                                                }
                                            }
                                            else{
                                                $dataArray = array("Ack"=>"success", "Msg"=>"success");
                                            }
                                        }
                                }
                                
                            }
                        }
                        else{
                            $dataArray = array("Ack"=>"fail", "Msg"=>"Could not access the <b>config/config_global.php</b> file.");
                        }
                        
                        
                        
                        
                    }
                    else{
                        $dataArray = array("Ack"=>"fail", "Msg"=>"I need write permissions on <b>config/config_global.php</b>.");
                    }
                    
                    
                }
                else{
                    $dataArray = array("Ack"=>"fail", "Msg"=>"Could not find the <b>config/config_global.php</b> file.");
                }
                
                
            }
            
            
            
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Oops. Refresh the page and try again.");
        }
  

echo json_encode($dataArray);
$mysqli->close();

function is_empty($var){
    //test for empty string - empty function not good enough
    if(trim($var)==""){
        return true;
    }
    else{
        return false;
    }
}

?>