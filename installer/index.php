<?php

//check config file
$configpath = "../config/config_global.php";
$msg ='';
$msg_hide='';
if(file_exists($configpath) ){
    if (is_writable($configpath)) {
        if($fh = fopen($configpath,"r+"))
        {
            //okay
            $msg_hide='hide';
          
        }
        else{
            $msg = "Could not access the <b>config/config_global.php</b> file.";
            
        }
                    
                    
                    
                    
    }
    else{
        $msg = "I need write permissions on <b>config/config_global.php</b>.";
     
    }
    
    
}
else{
     $msg = "Could not find the <b>config/config_global.php</b> file.";

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <title>nadlabs installer</title>
        <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
         <script type="text/javascript" src="js/installer_js.js"></script>
         <script type="text/javascript" src="js/jquery.js"></script>
    <style type='text/css'>
    
    body{
        background-color:#f1f1f1;
        margin:auto;
        font-family:'PT Sans',helvetica;
    }
    #page{
        text-align:center;
       
    
    }
    #header{
        background-image:url('img/installer_slicer.gif');
        background-repeat:repeat-x;
        width:100%;
        height:130px;
        text-align:center;
        margin-bottom:60px;
    }
    #logo{
        margin:40px 0px 0px 0px;
    }
    .text_label{
        font-size:36px;
        color:#4e4e4e;
        text-align:right;
        padding-right:20px;
    }
    .fll{
        float:left;
    }
    .clb{
        clear:both;
    }
    #main_content{
        text-align:center;
        width:960px;
         display:inline-block;
         margin-left:40px;
    }
    .textbox{
        width:390px;
        border:solid 1px #c3c3c3;
        height:36px;
        font-size:34px;
        font-family:'PT Sans',helvetica;
        color:#4e4e4e;
        padding:10px;
    }
     #warn_top{
        background-color:#ff8083;
        border:solid 3px red;
        font-size:12px;
        padding:30px;

        
    }
    #warn{
        background-color:#ff8083;
        border:solid 3px red;
        font-size:12px;
        padding:30px;
        display:none;
        
    }
    #success{
        background-color:#80ff80;
        border:solid 3px green;
        font-size:12px;
        padding:30px;
        display:none;
    }
    .bigtext{
        font-size:28px;
    }
    .hide{
          display:none;}
    a{color:#333}
    </style>
    
    
</head>
<body>
    
    <div id='page'>
        <div id='header'>
    
              <img src='img/logo_installer.gif' id='logo'/>
          
        </div>
        
        <div id='main_content'>
            Please make sure your configuration file (userbase/config/config_global.php) is set to chmod 666.<br/> Once
            the installer has done it's thing you can set it to 644 or 600.
            
            <table cellspacing=10 cellpadding=0 border=0>
                <tr>
                    <td class='text_label'>
                   
                    </td>
                    <td >
                        <div id='warn_top' class='<?php echo $msg_hide;?>'>
                            <span class='bigtext'>Oops!</span><br/><br/>
                            <span id='errors'>
                                <?php echo $msg;?>
                            </span>
                        </div>
                        
                    </td>
                </tr>
                <tr>
                    <td class='text_label'>
                        db server
                    </td>
                    <td>
                         <input type='text' class='textbox' id='dbserver' />
                    </td>
                </tr>
                <tr>
                    <td class='text_label'>
                        db name
                    </td>
                    <td>
                         <input type='text' class='textbox' id='dbname' />
                    </td>
                </tr>
                <tr>
                    <td class='text_label'>
                        db username
                    </td>
                    <td>
                         <input type='text' class='textbox' id='dbusername'  />
                    </td>
                </tr>
                <tr>
                    <td class='text_label'>
                        db password
                    </td>
                    <td>
                         <input type='text' class='textbox' id='dbpassword' />
                    </td>
                </tr>
                 <tr>
                    <td class='text_label'>
                        install test data
                    </td>
                    <td>
                         <input type='checkbox' style='height:36px; width:36px;' id='dbtestdata'  />
                    </td>
                </tr>
                  <tr>
                    <td class='text_label' colspan=2>
                        get your <a style='color:#4e4e4e' href ='http://www.google.com/recaptcha'>recaptcha</a> keys
                    </td>
                    
                </tr>
                 <tr>
                    <td class='text_label'>
                        public key
                    </td>
                    <td>
                         <input type='text' class='textbox' id='recap_public' />
                    </td>
                </tr>
                <tr>
                    <td class='text_label'>
                        private key
                    </td>
                    <td>
                         <input type='text' class='textbox' id='recap_private'/>
                    </td>
                </tr>
                <tr>
                    <td style='text-align:right' colspan=2>
                        <button onclick='install()' style='font-size:36px'>install</button>
                    </td>
                   
                </tr>
                <tr>
                    <td class='text_label'>
                     
                    </td>
                    <td style='text-align:left' >
                        <div id='loading' style='display:none;'>
                            loading, saving and generally doing things...
                        </div>
                        <div id='warn'>
                            <span class='bigtext'>Oops!</span><br/><br/>
                            <span id='errors_js'>
                                
                            </span>
                        </div>
                        <div id='success'>
                            <span class='bigtext'>All Done!</span>
                            <br/><br/>
                            <p>
                            That's it, you can login as administrator using<br/>
                            username:<b>admini</b><br/>
                            password:<b>password</b><br/>
                            </p>
                            <p>
                                Login to the front end: <a href='../index/'>main/index/</a><br/>
                                *
                                and the admin area: <a href='../admin/'>main/admin/</a><br/>
                            </p>
                            
                            <h3>Facebook &amp; Twitter</h3>
                            <p> 
                            If you want to allow your users to use Twitter/Facebook<br/> to login then you will need to
                            get API keys for both those services.<br/> Once you have the API keys then head over to the
                            configuration file<br/> (/main/config/config_global.php) and type in the key values.
                            </p>
                                <h3>Extras that you should look at but are not required</h3>
                                
                            <p> 
                                <ul>
                                    <li> installing the IP-to-Country database</li>
                                    <li> have a look at the configuration settings in the config file</li>
                                </ul>
                                <br/>
                                Go to <a href='../help/getting_started.html'>this help file</a> for more information on the
                                <br/>configuration file & installing the IP-to-Country database.<br/>
                            </p>
                        </div>
                    </td>
                   
                </tr>
            </table>
            
            
        </div>
        
        
    </div>
    
    
    
    
</body>
</html>