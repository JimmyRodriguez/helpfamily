<?php
// do a check here to see if user is loged in and if usergroup is 1 or 2
require_once("local_config.php");
require_once(APP_INC_PATH."bootstrap_frontend.php");
sessionsClass::sessionStart();
if (!sessionsClass::sessionStartFind($groupTest=array(1,2))){
    header("Location: logout.php?r=0");
    exit;
   
}
else if (!sessionsClass::sessionStartFind($groupTest=array(1))){
    header("Location: accessdenied.php");
    exit;
}

if (isset($_COOKIE['history'])){
    if($_COOKIE['history']!=''){
        $_SESSION['history'] = $_COOKIE['history'];
    }
    
}




//var_dump($_COOKIE['history']);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <title>userbase::user management</title>
    
    <link type="text/css" href="css/jquery-ui-1.8.6.custom.css" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="css/styles_admin.css" type="text/css">
    <link type="text/css" rel="stylesheet" href="css/styles_x.css" type="text/css">
    <link type="text/css" rel="stylesheet" href="css/temp_f_styles_x.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="../droplist/_css/droplist.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css" />
    <link rel="stylesheet" href="css/facebox.css" type="text/css">
    
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.6.custom.min.js"></script>
    
    <script type="text/javascript" src="js/corners.js"></script>
    <script type="text/javascript" src="js/scroll.js"></script>
    <script type="text/javascript" src="js/scroll_int_ub.js"></script>
    <script type="text/javascript" src="js/facebox.js"></script>
    <script type="text/javascript" src="js/jquery.qtip.min.js"></script>
    <script type="text/javascript" src="js/actions.js"></script>
    
        <script>
            $(document).ready(function () {
               
                             
            
               
               $('.ub_corners').corner('5px');
               $('.ub_corners3').corner('3px');
                  $('.ub_buttons').corner('3px');
                 lf_list('','0,10',1);
                 $('.t_link_1').bind('mouseover',function(event){
                    
                            $(this).css({'background-color':'#4C4C4C'});
                            $(this).siblings().css({'background-color':'#EB8114'});
                                    
        
                });
                $('.t_link_1').bind('mouseout',function(event){
       
                            $(this).css({'background-color':'#2D2D2D'});
                            $(this).siblings().css({'background-color':'#2D2D2D'});
                                    
        
                });
                
                $('.rep_links_buttons').live('click',function(event){
                    
                            $(this).css({'background-color':'#7F7F7F','color':'#fff'});
                        
                                    
        
                });

                
            });
            
           
        </script>


</head>
<body >
 
    <div id='model'>
        
    </div>
    <div id='load_info' class='ub_corners hide'>
        
    </div>
    <div id='load_info_inner' class='ub_corners hide'>
    </div>
    
    
    
    
    <!--
    
        loadbox content start    
        
    -->
    
    <!--
    
        loadbox content end
    
    -->
    
    <div class="fullscreen">
  

</div>
    <div class='hide' id='glass_loader'>
    <div class='outer-glass-load ub_corners'>
        
    </div>
    <div class='inner-load ub_corners'>
        <div id='site_wide_load_x' class='txtc' style='font-size:11px;padding:8px 0px 0px 0px;  '><div   id='site_wide_load_msg_x' ></div> <div ><img src='images/loader/bar_t.gif'/></div><div class='clb'></div> </div>
        <div id='site_wide_msg_x' class='txtc hide' style='font-size:11px; padding:10px 20px 0px 0px; '></div>
        <div id='site_wide_okay_x' class='txtc hide' style='font-size:11px; padding:5px 20px 0px 0px; '></div>
           
    </div>
    </div>
    
    
    <div id='outer_container' >
    <div id='top_bar'>
        <div id='unibody_blackbar'>
            <div id='unibody_menu' class='fll txtl'>
            <div class='fll'>
                <div class='t_link_top'></div>
                <div class=' t_link_1 ' onclick='window.location = "unibody.php";'>
                    << back to the nerve centre
                </div>
            </div>
          <div class='clb'></div>
        </div>
            <div class='flr txtr' id='unibody_power'>
                <img src='images/poweredbynadlabs.gif'/>
            </div>
            <div class='clb'></div>
        </div>
        
        
        <div class='clb'></div>
        <div id='tabs'>
            
        </div>
        <div id='silver'>
            <div class='fll' id='textlinks'>
                <div id='links_functions' class='' style='padding-left:7px;font-size:12px;' >
                   <span class='txtl' >you're signed in as <span id='login_name'><?php echo $_SESSION['username'];?></span> - <a class='toplink' href='logout.php'>sign out</a></span>
                    
                </div>
           
            
            </div>
            <div class='flr txtr'>
                <div id='site_wide_load' class='txtr hide' style='font-size:11px;padding:8px 0px 0px 0px;  '><div class='fll' style='padding:2px 0px 0px 0px' id='site_wide_load_msg' >searching userbase...</div> <div class='flr' style=''><img src='images/loader/bar_t.gif'/></div><div class='clb'></div> </div>
                <div id='site_wide_msg' class='txtr hide' style='font-size:11px; padding:10px 20px 0px 0px; '>saving changes...</div>
                
            </div>
            <div class='clb'></div>
        </div>
    <div id='unibody_mid_bar' >
            <div class='fll'>
            user<b>base</b> login failure logs
            </div>
            <div id='qs' class='flr ub_corners hide'>
            <div class=''>
                <input type='text' id='qs_search' value='enter a username or userid in here to do a quick search'/>
                <span id='search_button' onclick='quick_search()'>search</span>
            </div>
        </div>
             <div class='clb'></div>
    
    </div>
    
    </div>
    <div id='main_zone_logs'>
        
        <div id='list_main_lf'>
            
           <div style='font-size:11px; padding-left:10px;' class='fll txtl'>
            <span class='rep_links_buttons ub_corners3' id='login_links_admin' onclick='lf_list("admin","0,10",1);'>admin login fails</span>
            <span class='rep_links_buttons ub_corners3' id='login_links_user'onclick='lf_list("user","0,10",1);'>user login fails</span>
            <span class='rep_links_buttons ub_corners3' id='login_links_false' onclick='lf_list("false","0,10",1);'>show all</span>
           </div>
            <div class='flr txtr' style='font-size:11px; padding-right:10px; margin:0px 0px 10px 0px;'>
                <span class='pagation_wrapper ub_corners3'>
                    <select id='lf_log_pagation' onchange='lf_list("","",2);'>
                        <option value='0'>page 1</option>
                    </select>
                </span>
            </div>
            
            <div class='clb'></div>
            <div id='lf_main' class='txtc'>loading...</div>
            
        </div>
        
    </div>
   
</div>


</body>

</html>