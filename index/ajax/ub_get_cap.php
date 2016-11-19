<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once("../local_config.php");

require_once(APP_INC_PATH."recaptchalib.php");


                                                        
                                                           
echo recaptcha_get_html(RECAPKEY_PUBLIC);



?>