<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/

$openid_msg = '';
$openid_alert='hide';
if(isset($_POST['nojs_change_openid'])){
    
    $username = dbase::globalMagic($_POST['openid_ub_nojs']);
           
    $userid = dbase::globalMagic($_SESSION['userid']);
            
    $userNameResponse = validator::usernameValidate($username,0,0);
    
    if ($userNameResponse['Ack']=='fail'){
        $openid_msg = $userNameResponse['Msg'];
        $openid_alert='';
    }
    else{

        if (User::change_otf_username($username,$userid)){

            $openid_msg = "Your changes have been saved.";

        }
        else{

            $openid_msg = "Oops, try clicking save again.";
            $openid_alert='';
        }
    }
   
}

?>