<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/


if(isset($_POST['nojs_react'])){
    $react_input_msg = '';

    $react_alert = '';
    
    
    $useremail  = dbase::globalMagic($_POST['user_email_react_nojs']);
    $react_msg = '';
    $valid = '';
    



            //validate data
            
            $validationResponse = validateDataEdit($useremail);
         
            if ($validationResponse['validAck']=='ok'){
            
                   
                  
                     
               
                    if (Admin::resend_activation($useremail,$validationResponse['emailorusername'])){
                        
               
                        $react_msg = "Your activation email has been resent.";
                        
                    
                        
                    }
                    else{
                        $react_alert = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
                     
                        $react_msg = "Oops, refresh the page and try again.";
                    }
            }
            else{
                $react_alert = 'box-shadow: inset 0 0 2px 1px #ff9f9f;';
                $react_msg="Could not match this email or username with our records.";
            }
       




    
 


}
else{
    $react_input_msg = '';

    $react_alert = '';

    $react_msg = '';
    $valid = '';
}


function validateDataEdit($username_email){
    
 
    $validArray = array();
    
    $validArray['validAck'] = 'ok';
    
    
    $emailResponse = validator::emailValidate($username_email,2,'');
    
    if ($emailResponse['Ack']=='success'){
        
        $validArray['emailorusername'] = 1;
    }
    else {
        $userNameResponse = validator::usernameValidate($username_email,3,'');
    
        if ($userNameResponse['Ack']=='success' ){
            $validArray['emailorusername'] = 0;
        }
        else{
            //does not match an email or username in the system
            $validArray['validAck'] = 'fail';
        }
    }
    
    return $validArray;
    
}



?>