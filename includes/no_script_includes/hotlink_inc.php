<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/

//hot link images
$hotlink_error='';
if(isset($_POST["hotlink_url_nojs"])){
    $hotlink_error = User::hotlink_image($_POST["hotlink_url_nojs"],$ext_allowed);
}

    


?>