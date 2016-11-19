<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/



$con_name_msg='';
$conact_msg = '';
$con_email_msg = '';
$contact_msg = '';

$con_name_alert         =   '';
$con_msg_alert          =   '';
$con_email_alert        =   '';

if(isset($_POST['nojs_contact'])){
    

   
    $contact_mail  = dbase::globalMagic($_POST['user_email_contact_nojs']);
    $contact_name  = dbase::globalMagic($_POST['user_name_contact_nojs']);
    $contact_message  = dbase::globalMagic($_POST['user_msg_contact_nojs']);
    $contact_msg = '';
    $con_email_msg = '';
 
    
    
    $userid = (isset($_SESSION['userid']))?dbase::globalMagic($_SESSION['userid']):'';
            
    $valid = validate_contact($contact_mail,$contact_message,$contact_name,$con_name_alert,$con_email_alert,$con_msg_alert);
       
    if ($valid['valid']){    
    
        User::check_user($contact_mail,$contact_name,$contact_message);
        
        $contact_msg = 'Your message has been sent.';


            //validate data
            
       
    }
    else{

        $con_name_msg=$valid['name'];
        $conact_msg = $valid['msg'];
        $con_email_msg = $valid['email'];
        $contact_msg = 'Please correct the errors and try again.';
    }




    
 


}


function validate_contact($contact_mail,$contact_message,$contact_name,&$con_name_alert,&$con_email_alert,&$con_msg_alert){
    $valid = array();
    $valid['valid']=true;
    if (filter_var($contact_mail, FILTER_VALIDATE_EMAIL)){
        $valid['email']='';
    }
    else{
        $valid['email']='Make sure the email is in the correct format.';
        $valid['valid']=false;

        $con_email_alert        =   'box-shadow: inset 0 0 2px 1px #ff9f9f;';
    }
    
    if (trim($contact_message) != ''){
        $valid['msg']='';
    }
    else{
        $valid['msg']='Make sure to enter a message.';
        $valid['valid']=false;

        $con_msg_alert          =   'box-shadow: inset 0 0 2px 1px #ff9f9f;';
    }
    
    if (trim($contact_name) != ''){
        $valid['name']='';
    }
    else{
        $valid['name']='Make sure to enter your name.';
        $valid['valid']=false;
        $con_name_alert         =   'box-shadow: inset 0 0 2px 1px #ff9f9f;';
        
        
    }
    
    return $valid;
    
    
}


?>