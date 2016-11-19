<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/



$parts_alerts='';
 
$activate_msg='';
if(isset($_POST['nojs_activate'])){
    $postList = array("parta_activate_nojs","parta_activate_nojs");
    
    if (general::globalIsSet($_POST,$postList)){
        $userid = dbase::globalMagic($_POST['parta_activate_nojs']);
        $acticode = dbase::globalMagic($_POST['partb_activate_nojs']);
        $dataArray = activate($userid,$acticode);
        
        if ($dataArray['Ack']!='success'){
     
            $parts_alerts = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
            $activate_msg="Hmm. Looks like that didn't work. Make sure you copied the both parts from the email.";
        }
        
    }
    else{
     
        $activate_msg="Hmm. Looks like that didn't work. Make sure you copied the both parts from the email.";
        $dataArray = array("Ack"=>"fail",'hideshow'=>'','QuickMsg'=>'Oops, looks like that was a bit of a flop', "Msg"=>"<br/><br/>It may be that your account is already active. Try logging in.<br/><br/>If not then make sure you enter both parts of the code from the activation email.");
    }
}
else{
    $postList = array("u","a");

    if (general::globalIsSet($_GET,$postList)){
        $userid = dbase::globalMagic($_GET['u']);
        $acticode = dbase::globalMagic($_GET['a']);
        $dataArray = activate($userid,$acticode);
    }
    else{

        $dataArray = array("Ack"=>"fail",'hideshow'=>'','QuickMsg'=>'Oops, looks like that was a bit of a flop', "Msg"=>"<br/><br/>It may be that your account is already active. Try logging in.<br/><br/>If not then make sure you copied the whole URL from the email into the address bar or you can enter both parts of the activation code into the boxes below");
    }
 }
 


function activate($userid,$acticode)
{ 
          
    

  
    
    $validationResponse = validateDataEdit($userid,$acticode);
    
    
    if ($validationResponse['validAck']=='ok'){
    
           
          
             
        //work out what response is saying
            if (User::activateUser($userid,$acticode,NOJS_CONGRATS_NO_HTML)){
                
               
                $dataArray = array("Ack"=>"success",'hideshow'=>'hide','QuickMsg'=>'Wahooo, your account has been activated', "Msg"=>"<br/><br/>Congratulations, your account has been activated. Use the login box above to get in and access our site.");
                
               
                
            }
            else{
                
             
                $dataArray = array("Ack"=>"fail",'hideshow'=>'','QuickMsg'=>'Oops, looks like that was a bit of a flop', "Msg"=>"<br/><br/>It may be that your account is already active. Try logging in.<br/><br/>If not then make sure you copied the whole URL from the email into the address bar or you can enter both parts of the activation code into the boxes below.");
            }
    }
    else{
        $dataArray = array("Ack"=>"validationFail",'hideshow'=>'','QuickMsg'=>'Oops, looks like that was a bit of a flop', "Msg"=>"<br/><br/>It may be that your account is already active. Try logging in.<br/><br/>If not then make sure you copied the whole URL from the email into the address bar or you can enter both parts of the activation code into the boxes below");
    }
    return $dataArray;
}



function validateDataEdit($userid,$acticode){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    if(trim($userid)==''){
        $validArray['validAck'] = 'fail';
    }

    if(!is_numeric(intval($acticode))){
        $validArray['validAck'] = 'fail';
    }
    
    

    
    return $validArray;
    
}





?>