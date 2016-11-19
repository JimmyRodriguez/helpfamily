<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."bootstrap.php");

sessionsClass::sessionStart();
if (sessionsClass::sessionStartFind(false)){

        $postList = array("ed_yournewfield"); //names should match the field names in the html
        //var_dump($_POST);
        if (general::globalIsSet($_POST,$postList)){

            

            
          
                $mynewfield = dbase::globalMagic($_POST['ed_yournewfield']); //user globalMagic function to make it safe for SQL (prevent SQL injection)
                
          
                //this represents the "WHERE" part of the UPDATE SQL - left hand side is the actual database field name
                $id_key=array(
                        'userid'=>dbase::globalMagic($_SESSION['userid'])  //make sure you're connecting to the correct user record
                        );
                
                
                //this represents the "SET" part of the UPDATE SQL
                $key_values=array(
                        'mynew_field'=>$mynewfield
                        );
                
                /*
                        prarameters as follow:
                        
                                1. WHERE part
                                2. SET part
                                3. table being updated
                                4. on success message
                                5. on fail message
                */
                $result = dbase::edit_db_item($id_key,$key_values,'user_table','done','failed');
                
                if ($result['Ack']=='success'){
                        //here you can extra data to return to the javascript
                       $dataArray = array("Ack"=>"success", "Msg"=>$result['Msg']);
                }
                else{
                        //here you can extra data to return to the javascript
                        $dataArray = array("Ack"=>"fail", "Msg"=>$result['Msg']);
                }
                
                //please see documentation about the registration form to see how validation fits into this.
        }
        else{
            
            //not sent all data
            $dataArray = array("Ack"=>"fail", "Msg"=>"Please refresh the page and try again.");
        }
}
else{
    
    //not logged in
    $dataArray = array("Ack"=>"fail", "Msg"=>"You are not logged in.");
    
}
echo json_encode($dataArray);
?>