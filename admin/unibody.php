<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
require_once("local_config.php");
require_once(APP_INC_PATH."bootstrap_frontend.php");

sessionsClass::site_protection(false,true,true,$groupTest=array(1));

//error_reporting(0);

if (isset($_COOKIE['history'])){
    if($_COOKIE['history']!=''){
        $_SESSION['history'] = $_COOKIE['history'];
    }
    
}

//need to 


$upgrade='hide';
if (general::is_online()){
    $latest = file_get_contents('http://support.nadlabs.co.uk/upgrade.php?v='.VERSION_NUMBER);

    if ($latest=="true"){
        $upgrade='';
    }
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <title>userbase::user management</title>
    
  
    <link type="text/css" rel="stylesheet" href="css/styles_admin.css" type="text/css">

    <link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css" />

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.6.custom.min.js"></script>
    
    <script type="text/javascript" src="js/corners.js"></script>
    <script type="text/javascript" src="js/scroll.js"></script>
    <script type="text/javascript" src="js/scroll_int_ub.js"></script>
    <script type="text/javascript" src="js/jquery.pagination.js"></script>
    <script type="text/javascript" src="js/jquery.qtip.min.js"></script>
    <script type="text/javascript" src="js/actions.js"></script>
     <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
     
      
    </script>
    
        <script>
            $(document).ready(function () {
               
                             
            
              
                  
         
                loadDashboard();
                
               $('.ub_corners').corner('5px');
               $('.ub_corners3').corner('3px');
                  $('.ub_buttons').corner('3px');
                  
               $('.t_links').live('mouseover',function(event){
                  
                                         $(this).css({'background-color':'#f3f3f3'});         
                     
                });
                
                $('.t_links').live('mouseout',function(event){
       
                           $(this).css({'background-color':'transparent'});
                                    
                });
                
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
                
                $('.lp_pv').live('mouseover',function(event){
                    
                            $(this).css({'background-color':'#fff'});
                            
                                    
        
                });
                $('.lp_pv').live('mouseout',function(event){
       
                            $(this).css({'background-color':'#f8f8f8'});
                           
                                    
        
                });
                
                
                
                
                
                
		
            
                
               reset_bindings();
          
                
               
                
                

                
            });
            
         
        </script>


</head>
<body >

    <div id='model'>
        
    </div>
   
    
    
    
    
    <!--
    
        loadbox content start    
        
    -->
    
        <div id='mass_change_loadbox' class='hide'>
                      <div id='load_info_title'>changing the user status of the current search results</div>
           
                        <div class='hrule100' style=' margin-top:3px;'></div>
                        <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:3px;'></div>
                        <DIV class='br7'></DIV>
                        <div style='font-size:12px;'>
                            Selecting to mass change the user status will effect every user in the current
                            results set - not just those shown on screen. Make sure you don't confuse your
                            'history' results with you're actual search results!
                            <DIV class='br7'></DIV>
                              <DIV class='br7'></DIV>
                            <div class='floatlefts' style='padding:6px 15px 0px 10px; font-size:13px;'>
                                         select a status value:
                            </div>
                           
                                     <div class='ub_corners ub_text_box_wraps_small_noalert floatlefts' style='text-align:left'>
                                                                       
                                                <select class='ub_select_box_small_noalert' id='mass_change_int_' >
                                                    <option value='0'>set to waiting activation</option>
                                                    <option value='1'>set to activated</option>
                                                    <option value='2'>set to blocked</option>
                                                  
                                                </select>
                                                                           
                                                                             
                            </div>
                                     <div class='clb'></div>
                                     
                            <div style='height:20px; text-align:center; margin-top:50px;'>
                                <div id='mass_change_loader_int_' class='hide'>
                                    <img src='images/loader/bar_t.gif'/><br/>
                                    updating user status...
                                </div>
                                <div class='hide' id='mass_change_msg_int_'>
                               
                                </div>
                            </div>
                        </div>
                        
                        <div style=' width:585px; font-size:13px; position:absolute; bottom:10px;'>
                            <div class='hrule100' style=' margin-top:3px;'></div>
                            <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:5px;'></div>
                            
                            <div class='fll' >
                            <span class='ub_buttons' onclick='mass_status_change()'>save changes</span> 
                            </div>
                            <div class='flr txtr' style='margin-left:5px;'>
                                 <span class='ub_buttons' onclick='hideinfobox()'>close</span>
                            </div>
                            
                            
                            <div class='clearboth'></div>
                        </div>
              
        </div>
        
        <div id='export_loadbox' class='hide'>
                      <div id='load_info_title'>exporting a mailing list from the current search results</div>
           
                        <div class='hrule100' style=' margin-top:3px;'></div>
                        <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:3px;'></div>
                        <DIV class='br7'></DIV>
                        <div style='font-size:12px;'>
                            This will allow you to export a csv file with the details of the users in the
                            current search results set. To customise the csv file please contact your
                            administartor.
                            <DIV class='br7'></DIV>
                            
                            
                            <div style='height:20px; text-align:center; margin-top:50px;'>
                                <div id='export_mail_loader_int_' class='hide'>
                                    <img src='images/loader/bar_t.gif'/><br/>
                                    exporting mailing list...
                                </div>
                                <div class='hide' id='export_msg_int_'>
                               
                                </div>
                            </div>
                                    
                        </div>
                        
                         <div style=' width:585px; font-size:13px; position:absolute; bottom:10px;'>
                            <div class='hrule100' style=' margin-top:3px;'></div>
                            <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:5px;'></div>
                            
                            <div class='floatlefts' >
                            <span class='ub_buttons' onclick='getMailingList()'>export the list</span> 
                            </div>
                           
                            
                            <div class='floatright txtr'>
                               <span class='ub_buttons' onclick='hideinfobox()'>close</span>
                            </div>
                            <div class='clb'></div>
                        </div>
              
        </div>
        <div id='delete_user_loadbox' class='hide'>
                      <div id='load_info_title'>are you sure you want to delete <span id='user_del_int_'></span>'s account?</div>
           
                        <div class='hrule100' style=' margin-top:3px;'></div>
                        <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:3px;'></div>
                        <DIV class='br7'></DIV>
                        <div style='font-size:12px;'>
                            Deleting users will remove them completely from the system.
                            <DIV class='br7'></DIV>
                            
                            <div style='height:20px; text-align:center; margin-top:50px;'>
                                <div id='delete_user_loader_int_' class='hide'>
                                    <img src='images/loader/bar_t.gif'/><br/>
                                    deleting user account...
                                </div>
                                <div class='hide' id='delete_msg_int_'>
                               
                                </div>
                            </div>
                            
                                    
                        </div>
                        
                        <div style=' width:585px; font-size:13px; position:absolute; bottom:10px;'>
                            <div class='hrule100' style=' margin-top:3px;'></div>
                            <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:5px;'></div>
                            
                            <div class='floatlefts' >
                            <span class='ub_buttons' onclick='deleteUserShow(1);'>delete this user</span> 
                            </div>
                            
                            
                            <div class='floatright txtr'>
                                <span class='ub_buttons' onclick='hideinfobox()'>close</span>
                            </div>
                            <div class='clearboth'></div>
                        </div>
              
        </div>
        <div id='clear_history_loadbox' class='hide'>
                      <div id='load_info_title'>are you sure you want to clear today's history?</div>
           
                        <div class='hrule100' style=' margin-top:3px;'></div>
                        <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:3px;'></div>
                        <DIV class='br7'></DIV>
                        <div style='font-size:12px;'>
                            Clearing the user selection history will remove all users you've viewed today
                        from this history list. There's no way back except by re-selecting them!
                            <DIV class='br7'></DIV>
                            
                            
                            <div style='height:20px; text-align:center; margin-top:50px;'>
                                <div id='clear_history_loader_int_' class='hide'>
                                    <img src='images/loader/bar_t.gif'/><br/>
                                    clearing today's history...
                                </div>
                                <div class='hide' id='clear_history_msg_int_'>
                               
                                </div>
                            </div>
                            
                            
                           
                                    
                        </div>
                        
                         <div style=' width:585px; font-size:13px; position:absolute; bottom:10px;'>
                            <div class='hrule100' style=' margin-top:3px;'></div>
                            <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:5px;'></div>
                            
                            <div class='floatlefts' >
                            <span class='ub_buttons' onclick='clear_history();'>clear history</span>
                            </div>
                            
                            
                            <div class='floatright txtr' >
                               <span class='ub_buttons' onclick='hideinfobox()'>close</span>
                            </div>
                            <div class='clearboth'></div>
                        </div>
              
        </div>
    
    
        <div id='delete_groups_loadbox' class='hide'>
                      <div id='load_info_title'>are you sure you want to delete the <span id='group_del_int_'></span> user group?</div>
           
                        <div class='hrule100' style=' margin-top:3px;'></div>
                        <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:3px;'></div>
                        <DIV class='br7'></DIV>
                        <div style='font-size:12px;'>
                            Deleting user groups will remove them completely from the system. Some groups, such as the "administrator" group, are
                            protected from being deleted or edited.
                            <DIV class='br7'></DIV>
                            <div id='delete_group_msg_int_' style='height:20px; text-align:center; margin-top:10px;'>
                                
                            </div>
                                    
                        </div>
                        
                        <div style=' margin-top:150px; font-size:13px;'>
                            <div class='hrule100' style=' margin-top:3px;'></div>
                            <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:5px;'></div>
                            
                            <div class='floatlefts' >
                            <span class='ub_buttons' onclick='delete_group();'>delete user group</span> <span class='ub_buttons' onclick='hideinfobox()'>close</span>
                            </div>
                            <div class='floatlefts facebox_options_img_loader hide' id='ub_mass_loader'>
                                 <img src='images/loader/sm_g.gif'/>
                            </div>
                            
                            <div class='floatright' id='ub_facebox_mass_msg' style='text-align:right'>
                               
                            </div>
                            <div class='clearboth'></div>
                        </div>
              
        </div>
   
    
    
    <!--
    
        loadbox content end
    
    -->
    
    <div class="fullscreen">
  

</div>
    <!--
    <div class='hide' id='glass_loader'>
        <div class='outer-glass-load ub_corners'></div>
        <div class='inner-load ub_corners'>
            <div id='site_wide_load_x' class='txtc' style='font-size:11px;padding:8px 0px 0px 0px;  '><div   id='site_wide_load_msg_x' >searching userbase...</div> <div ><img src='images/loader/bar_t.gif'/></div><div class='clb'></div> </div>
            <div id='site_wide_msg_x' class='txtc hide' style='font-size:11px; padding:10px 20px 0px 0px; '>saving changes...</div>
            <div id='site_wide_okay_x' class='txtc hide' style='font-size:11px; padding:5px 20px 0px 0px; '><a class='orangelink ' href='javascript:void(0)' onclick='hide_gl();'>okay</a></div>
               
        </div>
    </div>
    -->
    
 <div id='out' >
    <div id='top_bar'>
        <div id='unibody_blackbar'>
            <div style='width:1000px; display:inline-block; text-align:left;border-left:solid 1px #4e4e4e;border-right:solid 1px #4e4e4es;'>
            <div id='unibody_menu' class='fll txtl'>
            
           
        <div class='fll'>
             <div class='t_link_top'></div>
        <div class='fll t_link_1' onclick='slide_unibody("sec_groups");'>security & groups</div>
        </div>
         <div class='fll'>
                 <div class='t_link_top'></div>
        <div class='fll t_link_1' onclick='slide_unibody("usermanagement");'>user management</div>
        </div>
        <div class='fll'>
                <div class='t_link_top'></div>
                <div class=' t_link_1 ' onclick='slide_unibody("dashboard");'>
                    dashboard
                </div>
            </div>
        <div class='fll'>
             <div class='t_link_top'></div>
        <div class='fll t_link_1' onclick='slide_unibody("overview_ss");'>site stats overview</div>
        </div>
        <div class='fll'>
             <div class='t_link_top'></div>
        <div class='fll t_link_1' onclick='slide_unibody("detailed_ss");'>site stats detailed</div>
        </div>
        <div class='fll'>
             <div class='t_link_top'></div>
        <div class='fll t_link_1' onclick='slide_unibody("about");'>about userbase</div>
        </div>
        <div class='clb'></div>
        </div>
            <div class='flr txtr' id='unibody_power'>
                <img src='images/poweredbynadlabs.gif'/>
            </div>
            <div class='clb'></div>
            </div>
        </div>
        
        
       
        <div id='tabs'>
            
        </div>
        <div id='silver'>
            <div style='width:1000px; display:inline-block; text-align:left;border-left:solid 1px #ebebeb;border-right:solid 1px #ebebeb;'>
            <div class='fll' id='textlinks'>
           <div id='links_functionsx' class='' style='padding:2px 0px 0px 7px; font-size:12px;' >
             <span class='txtl' >you're signed in as <span id='login_name'><?php echo $_SESSION['username'];?></span> - <a class='toplink' href='logout.php'>sign out</a><span class='<?php echo $upgrade;?>'> - <span style='color:#ca0000; font-weight:bold'>upgrade:</span> a newer version of userbase available for download</span></span>
               
            </div>
           <div id='functions_dashboard' class='hide' style='padding-left:7px;' >
                <span class='' >welcome to nadlabs user management system</span>
               
            </div>
            <div id='functions_usermanagement' class='hide funcs' style='padding-left:0px;'>
                <span class='dots' >: </span>
                <span class='t_links ub_corners3' onclick='slider_changer("search-box","qf-pane-options")'>detailed search</span>
                <span class='t_links ub_corners3' onclick='slider_changer("add-new","qf-pane-options")'>add new user</span>
                <span class='t_links ub_corners3' onclick='showinfobox("export_loadbox");' >export mailing list</span>
                <span class='t_links ub_corners3' onclick='showinfobox("mass_change_loadbox");'>mass change</span>
                <span class='t_links ub_corners3' onclick='showinfobox("clear_history_loadbox");'>clear history</span>
            </div>
            <div id='functions_sec_groups' class='hide funcs'>
                    
            </div>
                
            
            </div>
            <div class='flr txtr'>
                <div id='site_wide_load' class='txtr hide' style='font-size:11px;padding:6px 0px 0px 0px;  '><div class='fll' style='padding:2px 0px 0px 0px' id='site_wide_load_msg' >searching userbase...</div> <div class='flr' style=''><img src='images/loader/bar_t.gif'/></div><div class='clb'></div> </div>
                <div id='site_wide_msg' class='txtr hide' style='font-size:11px; padding:8px 20px 0px 0px; '>saving changes...</div>
                
            </div>
            <div class='clb'></div>
            </div>
        </div>
    <div id='unibody_mid_bar_outter'>
                <div id='unibody_mid_bar_mid'>
                    <div id='unibody_mid_bar' >
             
                        user<b>base</b> dashboard
                        
                    </div>
                </div>
    
            </div>
    
    </div>
    <div id='main_zone'>
        
        <div id='unibody-main' class='ub_corners' >
                              <div id='unibody-main-float-shadow-left'></div>
                              <div id='unibody-main-float-shadow-right'></div>
                              <div id='load_info' class='ub_corners hide'></div>
                              <div id='load_info_inner' class='ub_corners hide'></div>
                              <div class='hide' id='glass_loader'>
                                
                                <div class='outer-glass-load ub_corners'></div>
                                <div class='inner-load ub_corners'>
                                    <div id='site_wide_load_x' class='txtc' style='font-size:11px;padding:8px 0px 0px 0px;  '><div   id='site_wide_load_msg_x' >searching userbase...</div> <div ><img src='images/loader/bar_t.gif'/></div><div class='clb'></div> </div>
                                    <div id='site_wide_msg_x' class='txtc hide' style='font-size:11px; padding:10px 20px 0px 0px; '>saving changes...</div>
                                    <div id='site_wide_okay_x' class='txtc hide' style='font-size:11px; padding:5px 20px 0px 0px; '><a class='orangelink ' href='javascript:void(0)' onclick='hide_gl();'>okay</a></div>   
                                </div>
                            </div>
                            <div  class="unibody-section">
		
                                <div id="unibody-pane-options" class="unibody-pane">
                                    <ul class="unibody-elements" style="width:6000px;  " id='unibody'>
                                        
                                        
                                        
                                                <li id='unibody_sec_groups'>
                                                     <div id='results_set_float' class='fll ub_corners'  >
            <div id='inner_float_results'>
 <span class='txtl' id='title-group-sec'>security management</span>          <div class='br7 '></div>
            <div class='hide' id='ub_group_container'>
                <div class='hrule100' ></div>
                <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:3px;'></div>
                    <div id='pagation_history' class='txtr'>
                        <select id='group_pagation' class='ub_select_box_small_pagation' onchange="groupPagation(2);">
                            <option>page 1</option> 
                        </select>
                    </div>
                  <div class='hrule100' style='border-color:#f8f8f8; margin-top:3px;'></div>
                <div class='hrule100' ></div>
                
                
                <DIV class='br7'></DIV>
                    <div id='ub_group_results'  style='text-shadow:none;'>
                            <center>
                          <br/>
                            searching...
                            </center>
                    </div>
            </div>
            <div id='ub_block_container'>
                <div class='hrule100' ></div>
                <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:3px;'></div>
                
                <div class=' floatlefts' style='text-align:left'>
                                                               
                                          <select class="ub_select_box_small_pagation" id="blocktype_pagation" onchange="blockPagation(3);">
                    <option value='-9'>all types</option>
                <option value='1'>IP address</option>
                <option value='2'>email domain name</option>
                <option value='3'>email address</option>
                <option value='4'>refering url address</option>
                <option value='5'>refering domain</option>
              </select>
                                                                   
                                                                     
                                </div>
                                
                
                    <div id='pagation_quick' class='floatright' style=' text-align:right'>
                                    
                                    <select id='block_pagation'  class='ub_select_box_small_pagation' onchange="blockPagation(2);">
                                        <option>page 1</option> 
                                    </select>
                    </div>
               
               
                    
                <DIV class='clb'></DIV>
                <div class='hrule100' style='border-color:#f8f8f8; margin-top:3px;'></div>
                <div class='hrule100' ></div>
                
                
                <DIV class='br7'></DIV>
                               
                    <div id='ub_block_results' >
                                <center>
                          <br/>
                            searching...
                            </center>
                    </div>
                </div>
                </div>
        </div>
        <div id='results_set' class='fll ub_corners' ></div>
        
        <div id='action_area_float' class='fll ub_corners'  >
            <div id='inner_float_actions'>
                <span class='fll txtl' style='font-size:12px;' id='sec_group_funcs'>
                    <div id='functions_sec' >
               
                        <span class='toplink' onclick='slider_changer("add-sec","qf-pane-options-security");'>add new element</span> - 
                        <span class='toplink' onclick='slider_changer("search-sec","qf-pane-options-security");'>search security</span>
                        
                    </div>
                    <div id='functions_groups' class='hide'>
                
                        <span class='toplink' onclick='slider_changer("add-group","qf-pane-options-group")'>add new group</span>
                        
                    </div>
                </span>
                <span class='flr txtr toplink' style='font-size:12px; padding-right:10px;' >
                    <span class='toplink'  onclick='swap_groups_sec();' id='show-group-sec'>manage groups</span>
                </span>
            
            <div class='br7 clb'></div>
            
           
            <div class='hrule100' ></div>
            <div class='hrule100' style='border-color:#f8f8f8;'></div>
            
                   <div id='ub-details-main' class='ub_corners floatlefts' style='overflow:hidden; overflow-x: hidden; -ms-overflow-y: hidden;'>
                             
                   <div id='security_management' class=''>
                    <div  class="ub-section">
                        <div id="qf-pane-options-security" class="gs-pane">
                            <ul class="ub-elements" style="width:2360px; height:670px;" id='sec-ul'>
                                <li id='search-sec'>
                                    <div class='sh'>
                                         <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                    <div style='padding:0px 0px 0px 0px; text-align:right;'>
                                                            <span class='ub_buttons ub_return_to_block hiddenText' onclick="slider_changer('edit-block','qf-pane-options');">return to current element</span>   <span class='ub_buttons' onclick="searchBlock('0,10',2,'');">search security</span> 
                                                    </div>
                                                    
                        </div>
                        <div class='ub_corners slider_c'>
                       
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 
                        <div class='floatlefts quick_details' style=' margin-left:10px; position:relative; width:428px;'>
                            <div class='floatlefts' style=' font-size:20px; padding-top:7px; line-height:18px;'>
                                search security elements
                                <div class='' style='font-size:12px; color:#666666; '>
                            manage your site security
                            </div>
                             
                            </div>
                            <div class='floatright' style='font-size:11px; text-align:right; color:#666666; '>
                               <div style='padding:5px 0px 7px 0px; text-align:right;'>
                                                    
                                                   </div>
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                   
                                               
                                                    <div class='floatlefts' style='font-size:13px; width:230px; margin:10px 0px 0px 5px'>
                                                            &nbsp;security element details
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_sec' >
                                                                <input type='text' id='ub_search_block' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("block")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                       </div>
                                                    <div class='floatlefts' style='margin:10px 0px 0px 15px'>
                                                         <div style='height:16px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_sec' >
                                                                <select id='ub_search_block_type' class='ub_select_box_small'>
                                                                    <option value='-9'>all types</option>
                                                                    <option value='1'>IP address</option>
                                                                    <option value='2'>email domain name</option>
                                                                    <option value='3'>email address</option>
                                                                    <option value='4'>refering url address</option>
                                                                    <option value='5'>refering domain</option>
                                                                </select>
                                                                 </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("block_type")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                                          <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_sec' >
                                                                <select id='ub_search_block_valid' class='ub_select_box_small'>
                                                                    <option value='-9'>show all</option>
                                                                    <option value='1'>active</option>
                                                                    <option value='2'>inactive</option>
                                                                  
                                                                </select>
                                                                 </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("block_valid")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:14px;'></div>
                                          <div class='clearboth'></div>
                                                           
                                                           </div>
                                                         
                                                         
                                                         
                                      
                                                    <div class='clearboth'></div>
                                                        
                                                    
                                                   <div style='padding:5px 15px 7px 0px; text-align:right;'>
                                                
                                                   </div>
                                                           
                                                  
                                                    </div>
                                                   
                                              </div>
                                       
                        </div>
                   
                   
                   
                  
                                    </div>
                                </li>
                                <li id='add-sec'>
                                     <div class='sh'>
                                          <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                    <div style='padding:0px 0px 0px 0px; text-align:right;'>
                                                            <span class='ub_buttons ub_return_to_block hiddenText' onclick="slider_changer('edit-block','qf-pane-options');">return to current block</span> <span class='ub_buttons' onclick="saveBlock();">save new element</span> 
                                                    </div>
                                                    
                        </div>
                         <div class='ub_corners slider_c'>
                         
                                
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                              
                        <div class='floatlefts quick_details' style=' margin-left:10px; position:relative; width:428px;'>
                            <div class='floatlefts' style=' font-size:20px; padding-top:7px; line-height:18px;'>
                                add security elements
                                <div class='' style='font-size:12px; color:#666666; '>
                                    add a new security element
                                </div>
                    
                            </div>
                            <div class='floatright' style='font-size:11px; text-align:right; color:#666666; '>
                                  <div style='padding:5px 0px 7px 0px; text-align:right;'>
                                                  
                                  </div>
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                   
                                                   
                                                  
                                                    
                                                        
                                                     <div class='floatlefts' style='font-size:13px; width:230px; margin:10px 0px 0px 5px'>
                                                            &nbsp;security element details
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_add_block' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_input_warnings ub_add_warn' id='ub_input_add_warnings_details' >
                                                                    <img id='ub_add_img_details'   src='images/blank.gif' />
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                            &nbsp;quick description
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_add_desc' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter' src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                       </div>
                                                    <div class='floatlefts' style='margin:10px 0px 0px 15px'>
                                                         <div style='height:16px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_x' >
                                                                <select id='ub_add_block_type' class='ub_select_box_small'>
                                                               
                                                                    <option value='1'>IP address</option>
                                                                    <option value='2'>email domain name</option>
                                                                    <option value='3'>email address</option>
                                                                    <option value='4'>refering url address</option>
                                                                    <option value='5'>refering domain</option>
                                                                </select>
                                                                 </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter' src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                          
                                          
                                          <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_x' >
                                                                <select id='ub_add_xsite' class='ub_select_box_small'>
                                                                    <option value='1'>block registration</option>
                                                                    <option value='2'>block access to site</option>
                                                                    <option value='3'>block site & registration</option>
                                                                    
                                                                    
                                                                  
                                                                </select>
                                                                 </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter' src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:14px;'></div>
                                          
                                          
                                            <div class='clearboth'></div>
                                                           
                                                           </div>
                                                         
                                                         
                                                         
                                      
                                                    <div class='clearboth'></div>
                                                        
                                                      
                                                          
                                                   <div style='padding:5px 15px 7px 0px; text-align:right;'>
                                                  
                                                   </div>
                                                    </div>
                                                   
                                              </div>
                                       
                                        
                                        
                         
                         
                         </div>

                  
                                    </div>
                                </li>
                                <li id='edit-sec'>
                               
                                     <div class='sh'>
                                             <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                    <div style='padding:0px 0px 0px 0px; text-align:right;'>
                                                              <span class='ub_buttons' onclick="editBlock();">save changes</span> 
                                                    </div>
                                                    
                        </div>
                         <div class='ub_corners slider_c'>
                            <div style='font-size:12px;'>
                                To edit a security element you must select an item from the search results on the left hand side.
                            </div>
                            <div id='edit_sec_msg'></div>
                            <div class='' id='edit_sec_area'>
                                       
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                             
                        <div class='floatlefts quick_details' style=' margin-left:10px; position:relative; width:405px;'>
                            <div class='floatlefts' style=' font-size:20px; padding-top:7px; line-height:18px;'>
                            edit security elements
                                <div class='' style='font-size:12px; color:#666666; '>
                           update this elements security setting
                            </div>
                             
                            </div>
                            <div class='floatright' style='font-size:11px; text-align:right; color:#666666; '>
                          
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                
                                                <div class='ub-details-content'>
                                                   
                                                   
                                                  
                                                
                                                        
                                                     <div class='floatlefts' style='width:230px; margin:10px 0px 0px 5px; font-size:13px;'>
                                                            &nbsp;security element details
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_edit_block' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' id='ub_input_edit_warnings_details' >
                                                                    <img id='ub_edit_img_details'   src='images/blank.gif' />
                                                                </div>
                                                              
                                                                <div class='clearboth'></div>
                                                         
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                            &nbsp;quick description
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_edit_block_desc' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/blank.gif' />
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                       </div>
                                                    <div class='floatlefts' style='margin:10px 0px 0px 15px'>
                                                         <div style='height:16px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_x' >
                                                                <select id='ub_edit_block_type' class='ub_select_box_small'>
                                                               
                                                                    <option value='1'>IP address</option>
                                                                    <option value='2'>email domain name</option>
                                                                    <option value='3'>email address</option>
                                                                    <option value='4'>refering url address</option>
                                                                    <option value='5'>refering domain</option>
                                                                </select>
                                                                 </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/blank.gif' />
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_x' >
                                                                <select id='ub_edit_xsite' class='ub_select_box_small'>
                                                                    <option value='1'>block registration</option>
                                                                    <option value='2'>block access to site</option>
                                                                    <option value='3'>block site & registration</option>
                                                                    
                                                                    
                                                                  
                                                                </select>
                                                                 </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter' src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:14px;'></div>
                                          <div class='clearboth'></div>
                                                           
                                                           </div>
                                                         
                                                         
                                                         
                                      
                                                    <div class='clearboth'></div>
                                                        
                                                    
                                                          <div style='padding:5px 15px 7px 0px; text-align:right;'>
                                                   
                                                   </div>
                                                        
                                                    </div>
                                                   
                                              </div>
                                       
                                        
                                         
                            </div>
                         </div>
                    
                                    </div>
                                
                                
                                
                                
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                   
                   </div>    
                   
                   <div class='hide' id='group_management'>
                    <div  class="ub-section">
                    <div id="qf-pane-options-group" class="gs-pane">
                        <ul class="ub-elements" style="width:2360px; height:670px;" id='group-ul'>
                            <li id='add-group'>
                    <div class='sh'>
                        
                     <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                    <div style='padding:0px 0px 0px 0px; text-align:right;'>
                                                           <span class='ub_buttons' onclick="addnewgroup();">create new group</span> 
                                                    </div>
                                                    
                        </div>
                        
                        <div class='ub_corners slider_c'>
                            
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                           
                        <div class='floatlefts quick_details' style=' margin-left:10px; position:relative; width:428px;'>
                            <div class='floatlefts' style=' font-size:24px; padding-top:7px; line-height:18px;'>
                                add user group
                            
                                <div style='font-size:12px; padding-top:3px;' >add a new user group to manage your userbase</div>
                            </div>
                            <div class='floatright' style='font-size:11px; text-align:right; color:#666666; '>
                                <div style='padding:5px 0px 7px 0px; text-align:right;'>
                                                    <span class='ub_buttons ub_return_to_group hiddenText' onclick="slider_changer('edit-group','qf-pane-options-two');">return to current group</span> 
                                  </div>
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                   
                                                   
                                                    
                                                   
                                                        
                                                     <div class='floatlefts' style='font-size:13px; width:230px; margin:10px 0px 0px 5px'>
                                                            &nbsp;user group title
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_add_group_title' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_input_warnings ub_add_warn' id='ub_input_add_warnings_group' >
                                                                    <img id='ub_add_img_group'   src='images/blank.gif' />
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                           
                                                           <div style='height:7px;'></div>
                                                       </div>
                                                    <div class='floatlefts' style='font-size:13px; margin:10px 0px 0px 15px'>
                                                        
                                                         &nbsp;quick description
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_add_group_desc' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                         
                                                            <div class='clearboth'></div>
                                                           
                                                           </div>
                                                         
                                                         
                                                         
                                      
                                                    <div class='clearboth'></div>
                                                       <div class='floatlefts' style='font-size:13px; width:230px; margin:10px 0px 0px 5px'>
                                                        &nbsp;premium or regular group
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_sec' >
                                                                <select id='ub_add_group_type' class='ub_select_box_small'>
                                                                    
                                                                    <option value='1'>regular group</option>
                                                                    <option value='2'>preimium group</option>
                                                                   
                                                                </select>
                                                                 </div>
                                                                
                                                                
                                                           </div>
                                                       </div>
                                                        <div class='floatlefts' style='font-size:13px; margin:10px 0px 0px 15px'>
                                                        
                                                         &nbsp;premium charge
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_add_group_fee' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                         
                                                            <div class='clearboth'></div>
                                                           
                                                           </div>
                                                         
                                                         
                                                         
                                      
                                                    
                                                       <div class='clearboth'></div>
                                                       
                                                        <div class='' style='font-size:13px; width:230px;  margin:15px 0px 0px 5px'>
                                                        
                                                         &nbsp;membership expires in (days)
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                <div class='floatlefts ub_input_release_x' >
                                                                    <input type='text' id='ub_add_group_expire' class='ub_text_box_small'/>
                                                                </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img id='ub_add_img_group_expire'  src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                         
                                                            <div class='clearboth'></div>
                                                           
                                                           </div>
                                                         
                                                         
                                                         
                                      
                                                    
                                                       
                                                       
                                                       <div class='clearboth'></div>
                                                          <div style='padding:5px 15px 7px 0px; text-align:right;'>
                                                   
                                                   </div>
                                                        
                                                    </div>
                                                   
                                              </div>
                        </div>
                        
                        
                  </div>
                    
                    
                        
                   </li>
                       
                            <li id='edit-group'>
                    <div class='sh'>
                        <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                    <div style='padding:0px 0px 0px 0px; text-align:right;'>
                                                           <span style='background-color:#BA211C' id='delete_group' class='ub_buttons' onclick="showinfobox('delete_groups_loadbox')();">delete group</span> <span class='ub_buttons' onclick="saveEditGroup();">save changes</span> 
                                                    </div>
                                                    
                        </div>
                        <div class='ub_corners slider_c'>
                            <div style='font-size:12px;'>
                                To edit a user group you must select an item from the search results on the left hand side.
                            </div>
                            <div id='edit_group_msg'>
                                
                            </div>
                            <div class='' id='edit_group_area'>
                                       
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                       
                        <div class='floatlefts quick_details' style=' margin-left:10px; position:relative; width:428px;'>
                            <div class='floatlefts' style=' font-size:24px; padding-top:7px; line-height:18px;'>
                            edit user groups
                                
                               
                                <div style='font-size:12px; padding-top:3px;' >administraor, moderator & assistants are protected groups</div>
                            </div>
                            <div class='floatright' style='font-size:11px; text-align:right; color:#666666; '>
                               
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                   
                                                   
                                                  
                                                   
                                                    <div class='floatlefts' style='font-size:13px; width:230px; margin:10px 0px 0px 5px'>
                                                            &nbsp;user group title
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_edit_group_title' class='ub_text_box_small'/>
                                                                 </div>
                                                               <div class='floatright ub_input_warnings ub_edit_warn' id='ub_input_edit_warnings_group' >
                                                                    <img id='ub_edit_img_group'   src='images/blank.gif' />
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                           
                                                           <div style='height:7px;'></div>
                                                       </div>
                                                    <div class='floatlefts' style='font-size:13px; margin:10px 0px 0px 15px'>
                                                        
                                                         &nbsp;quick description
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_edit_group_desc' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                         </div>
                                          <div class='clearboth'></div>
                                                            <div class='floatlefts' style='font-size:13px; width:230px; margin:10px 0px 0px 5px'>
                                                        &nbsp;premium or regular group
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_sec' >
                                                                <select id='ub_edit_group_type' class='ub_select_box_small'>
                                                                    
                                                                    <option value='1'>regular group</option>
                                                                    <option value='2'>preimium group</option>
                                                                   
                                                                </select>
                                                                 </div>
                                                                
                                                                
                                                           </div>
                                                       </div>
                                                        <div class='floatlefts' style='font-size:13px; margin:10px 0px 0px 15px'>
                                                        
                                                         &nbsp;premium charge
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_edit_group_fee' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                         
                                                            <div class='clearboth'></div>
                                                           
                                                           </div>
                                                         
                                                         
                                                         
                                      
                                                    
                                                       <div class='clearboth'></div>
                                                       
                                                  <div class='' style='font-size:13px; width:230px;  margin:15px 0px 0px 5px'>
                                                        
                                                         &nbsp;membership expires in (days)
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_x' >
                                                                <input type='text' id='ub_edit_group_expire' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img id='ub_edit_img_group_expire'  src='images/blank.gif'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                         
                                                            <div class='clearboth'></div>
                                                           
                                                           </div>       
                                                         
                                                         
                                      
                                                    <div class='clearboth'></div>
                                                        
                                                     
                                                   <div style='padding:5px 15px 7px 0px; text-align:right;'>
                                                        
                                                   </div>
                                                        
                                                    </div>
                                                   
                                              </div>
                                       
                                        
                                         
                            </div>
                        </div>
                        
                        
                        
                        
                    </div>
                        </li>
                    </ul>
                        
                     </div>
                    
                    </div>
                   
                   
                   
                   </div>
                  
                 
                 
                 
             
                
                 
            
            
            
            </div>
            </div>
        </div>
        
        
        <div id='action_area' class='fll ub_corners' ></div>
        <div class='clb'></div>
        
                                                </li>
                                                <li id='unibody_usermanagement'>
        <div id='results_set_float' class='fll ub_corners'  >
            <div id='inner_float_results'>
            <span class='fll txtl' id='title-history-results'>search results</span> <span class='flr txtr toplink' style='font-size:12px; ' onclick='swap_history_results();' id='show-history-results'>show today's history</span>
            <div class='br7 clb'></div>
            <div class='hide' id='history_block'>
                <div class='hrule100' ></div>
                <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:3px;'></div>
                    <div id='pagation_history' class='txtr'>
                        <select  class='ub_select_box_small_pagation' id='pageLimitHistory' onchange="historyPagation();">
                                  <option value='1'>page 1</option> 
                        </select>
                    </div>
                  <div class='hrule100' style='border-color:#f8f8f8; margin-top:3px;'></div>
                <div class='hrule100' ></div>
                
                
                <DIV class='br7'></DIV>
                    <div id='ub_user_results_history'  style='text-shadow:none;'>
                            <center>today's history is empty</center>
                    </div>
            </div>
            <div id='results_block'>
                <div class='hrule100' ></div>
                <div class='hrule100' style='border-color:#f8f8f8; margin-bottom:3px;'></div>
                
                <div class=' floatlefts' style='text-align:left'>
                                                               
                                        <select class='ub_select_box_small_pagation' id='orderby_quick' onchange='searchUser_QV("0,10",3);'>
                                            <option value='0'>username</option>
                                            <option value='1'>email address</option>
                                            <option value='2'>registeration date</option>
                                            <option value='3'>user id</option>
                                            <option value='4'>last visit</option>
                                            <option value='5'>country</option>
                                            <option value='6'>user group</option>
                                            <option value='7'>account status</option>
                                        </select>
                                                                   
                                                                     
                                </div>
                                <div class='floatlefts' style='text-align:left'>
                                <select class='ub_select_box_small_pagation' id='order_direction' onchange='searchUser_QV("0,10",3);'>
                                    <option value='0'>ascending</option>
                                    <option value='1'>descending</option>
                                </select>
                                </div>
                
                    <div id='pagation_quick' class='floatright' style=' text-align:right'>
                                    
                                    <select  class='ub_select_box_small_pagation' id='pageLimit' onchange="userPagation_QV(2);">
                                       
                                    </select>
                    </div>
               
               
                    
                <DIV class='clb'></DIV>
                <div class='hrule100' style='border-color:#f8f8f8; margin-top:3px;'></div>
                <div class='hrule100' ></div>
                
                
                <DIV class='br7'></DIV>
                               
                    <div id='ub_user_results' >
                                <center>
                          <br/>
                            searching...
                            </center>
                    </div>
                </div>
                </div>
         
        </div>
        <div id='results_set_ub' class='fll ub_corners' ></div>
        
        <div id='action_area_float' class='fll ub_corners'  >
            <div id='inner_float_actions'>
                
                
                <span class='flr txtr toplink' style='font-size:12px; padding-right:10px;' >
                    <span onclick='slider_changer("search-box","qf-pane-options")'>detailed search</span> -
                <span  onclick='slider_changer("add-new","qf-pane-options")'>add new user</span> -
                <span  onclick='showinfobox("export_loadbox");' >export mailing list</span> -
                <span  onclick='showinfobox("mass_change_loadbox");'>mass change</span> -
                <span onclick="showinfobox('clear_history_loadbox');">clear history</span>
             
                </span>
            
            <div class='br7 clb'></div>
            
           
            <div class='hrule100' ></div>
            <div class='hrule100' style='border-color:#f8f8f8;'></div>
            
                   <div id='ub-details-main' class='ub_corners floatlefts' style='overflow:hidden; overflow-x: hidden; -ms-overflow-y: hidden;'>
                             
                            <div  class="ub-section">
		
                                <div id="qf-pane-options" class="ub-pane">
                                    <ul class="ub-elements" style="width:2360px; height:650px;" id='one'>
                                        
                                                <li>
                                                    <div class='sh'>
                                                        
                                                    <div class='ub_corners slider_c'>
                                                   
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 
                                                   
                                                   
                                                   
                                                   
                                                   
                                                    <div class='clearboth'></div>
                                                                                
                                                                            </div>
                                                                            <div class='ub-details-content'>
                                                                              
                                                                              
                                                                               
                                                                          </div>
                                                                            </div>
                                                
                                                                  
                                              
                                       
                                                    </div>
                                       
                                                    </div>
                                        </li>
                                  
                                    
                                     
                                           
                                           
                                                   
                                                        <li id='editor'>
                                                            <div class='sh'>
                                                                 <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                    <div style='padding:0px 0px 0px 0px; text-align:right;'>
                                                    <span class='ub_buttons ub_return_to_user' onclick="return_to_user();">return to current user</span> <span class='ub_buttons' onclick="saveEditUser();">save changes</span> 
                                                    </div>
                                                    
                                                </div>
                                                            <div class='ub_corners slider_c'>
                                                  
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 <div class='floatlefts ub_imgbox hide' >
                            <img src='' width='40px' height='40px' id='ub_gravimg_editor'/>
                        </div>
                        <div class='floatlefts ' style=' margin-left:10px; position:relative; width:428px;'>
                            <div class='floatlefts' style=' font-size:24px; padding-top:5px; line-height:18px;'>
                                edit <span id='ub_edit_name_display'></span>
                                <br/>
                                <span style='font-size:14px'>
                                    edit user details & change password if required
                                </span>
                            </div>
                            <div class='floatright' style='font-size:11px; text-align:right; color:#666666; '>
                                
  
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                   
                                                   <div style='padding:5px 15px 7px 0px; text-align:right;'>
                                                   </div>
                                                   
                                                    <div class='floatlefts' style='width:230px; margin:0px 0px 0px 5px;font-size:13px;'>
                                                         
                                                            &nbsp;username
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_edit_user' >
                                                                <input type='text' id='ub_edit_username' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' id='ub_input_ub_edit_warning_username' >
                                                                    <img id='ub_input_edit_img_username'   src='images/blank.gif' />
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                     
                                                            &nbsp;email
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                <div class='floatlefts ub_input_release_edit_user' >
                                                                    <input type='text' id='ub_edit_email' class='ub_text_box_small'/>
                                                                </div>
                                                                <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_email'   src='images/blank.gif' onclick='release_filter("email")'/>
                                                                </div>
                                                                <div class='clearboth'></div>     
                                                                         
                                                            </div>
                                                            <div style='height:7px;'></div>
                                                           
                                                            &nbsp;phone number
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_edit_user' >
                                                                <input type='text' id='ub_edit_phone' class='ub_text_box_small'/>
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_phone'   src='images/blank.gif' onclick='release_filter("phone")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           
                                                           </div>
                                                            <div style='height:7px;'></div>
                                                          
                                                    
                                                            &nbsp;refering id
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                <div class='floatlefts ub_input_release_edit_user' >
                                                                    <input type='text' id='ub_edit_refid' class='ub_text_box_small'/>
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_refid'   src='images/blank.gif' onclick='release_filter("refid")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                            
                                                            </div>
                                                            <div style='height:7px;'></div>
                                                          
                                                    
                                                            &nbsp;refering url
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_edit_user' >
                                                                <input type='text' id='ub_edit_refurl' class='ub_text_box_small'/>
                                                             </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_refurl'   src='images/blank.gif' onclick='release_filter("refurl")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                            <div style='height:7px;'></div>
                                                           &nbsp;refering domain
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_edit_user' >
                                                                <input type='text' id='ub_edit_refdomain' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_refdomain'   src='images/blank.gif' onclick='release_filter("refdomain")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                             <div style='height:7px;'></div>
                                                           &nbsp;registration date 
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_edit_user' >
                                                                <input type='text' id='ub_edit_regdate' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_regdate'   src='images/blank.gif' onclick='release_filter("regdate")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                           &nbsp;registration ip address
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_edit_user' >
                                                                <input type='text' id='ub_edit_regip' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_regip'   src='images/blank.gif' onclick='release_filter("regip")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                             <div style='height:7px;'></div>
                                                          &nbsp;date of last visit 
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_edit_user' >
                                                                <input type='text' id='ub_edit_lastdate' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_lastdate'   src='images/blank.gif' onclick='release_filter("lastdate")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                      
                                                           
                                              
                                                          
                                                          
                                                          
                                                           
                                                   </div>
                                                    <div class='floatlefts' style='margin:0px 0px 0px 15px;font-size:13px;'>
                                                         <div style='height:16px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' style='width:100%' >
                                                                <select id='ub_edit_country' class='ub_select_box_small' style='width:inherit;'>
                                                                    <option value='-9'>loading...</option>
                                                                </select>
                                                                 </div>
                                                                
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' style='width:100%'>
                                                                <select id='ub_edit_lang' class='ub_select_box_small'  style='width:inherit;'>
                                                                  <option value='-9'>loading...</option>
                                                                </select>
                                                                </div>
                                                                
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                               <div class=' ub_input_release' style='width:100%'>
                                                                <select id='ub_edit_os' class='ub_select_box_small' style='width:inherit;'>
                                                                   <option value='-9'>loading...</option>
                                                                </select>
                                                                
                                                                 </div>
                                                                
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release' style='width:100%'>
                                                                <select id='ub_edit_browser' class='ub_select_box_small'  style='width:inherit;'>
                                                                  <option value='-9'>loading...</option>
                                                                </select>
                                                           </div>
                                                            
                                                                <div class='clearboth'></div>
                                                            
                                                            </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release' style='width:100%'>
                                                                <select id='ub_edit_status' class='ub_select_box_small' style='width:inherit;'>
                                                                     <option value="-9">Select Status</option>
<option value="0">Waiting Activation</option>
<option value="1">Activated</option>
<option value="2">Banned/Blocked</option>
                                                                </select>
                                                                
                                                                </div>
                                                              
                                                                <div class='clearboth'></div>
                                                                
                                                           </div>
                                                         <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                             <div class='ub_input_release' style='width:100%'>
                                                                <select id='ub_edit_contact' class='ub_select_box_small' style='width:inherit;'>
                                                                     <option value='-9'>contactable?</option>
                                                                    <option value='1'>can contact</option>
                                                                    <option value='0'>do not contact</option>
                                                                </select>
                                                                </div>
                                                            
                                                                <div class='clearboth'></div>
                                                           </div>
                                                      
                                                         <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release' style='width:100%'>
                                                                <select id='ub_edit_group' class='ub_select_box_small' style='width:inherit;'>
                                                                     <option value='-9'>loading?</option>
                                                                    
                                                                </select>
                                                             </div>
                                                         
                                                            <div class='clearboth'></div>
                                                           </div>
                                                       
                                                            <div style='height:7px;'></div>
                                                           &nbsp;ip address of last visit
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_edit_user' >
                                                                <input type='text' id='ub_edit_lastip' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_lastip'   src='images/blank.gif' onclick='release_filter("lastip")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                             <div style='height:7px;'></div>
                                                           &nbsp;change password else leave blank
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_edit_user' >
                                                                <input type='password' id='ub_edit_pass' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_edit_warn' >
                                                                    <img id='ub_input_edit_img_pass'   src='images/blank.gif' onclick='release_filter("lastip")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                           
                                                              
                                                         
                                                         
                                                         
                                        </div>
                                                    <div class='clearboth'>
                                                        

                                                           
                                                        
                                                        
                                                    </div>
                                                   
                                              </div>
                                                </div>
                                        </div>
                                                            </div>
                                        
                                         </li>
                                        
                               
                                    
                                    
                                    
                                    
                                    
                                        
                                                   
                                                   
                                                 
                                                 
                                                 
                                                   <li>
                                                    <div class='sh'>
                                                    <div class='ub_corners slider_c'>
                                                   
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 
                                                   
                                                   
                                                   
                                                   
                                                   
                                                    <div class='clearboth'></div>
                                                                                
                                                                            </div>
                                                                            <div class='ub-details-content'>
                                                                              
                                                                              
                                                                               
                                                                          </div>
                                                                            </div>
                                                
                                                                  
                                              
                                                </div>
                                       
                                        
                                                    </div>
                                                   </li>
                                  
                                    
                                     
                                           
                                        
                                        
                                        
                                            
                                            
                                                     <li>
                                                        <div class='sh'>
                                                        <div class='ub_corners slider_c'>
                                                   
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 
                                                   
                                                   
                                                   
                                                   
                                                   
                                                    <div class='clearboth'></div>
                                                                                
                                                                            </div>
                                                                            <div class='ub-details-content'>
                                                                              
                                                                              
                                                                               
                                                                          </div>
                                                                            </div>
                                                
                                                                  
                                              
                                       
                                            </div>
                                                        </div>
                                        </li>
                                  
                                    
                                     
                                        
                                        
                                        
                                        
                                            
                                            <li id='email'>
                                                <div class='sh'>
                                                    <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                    <div style='padding:0px 0px 0px 0px; text-align:right;'>
                                                    <span class='ub_buttons' onclick="swap_msg('email')">email user</span> <span class='ub_buttons' onclick="swap_msg('sms')">sms user</span> <span class='ub_buttons ub_return_to_user' onclick="return_to_user();">return to current user</span> 
                                                    
                                                    </div>
                                                    
                                                </div>
                                                    
                                                     <div class='ub_corners slider_c' >
                                                        
                                                   
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 <div class='floatlefts ub_imgbox hide' >
                            <img src='' width='40px' height='40px' id='ub_gravimg_msg'/>
                        </div>
                        <div class='floatlefts ' style=' margin-left:10px; position:relative; width:405px;'>
                            <div class='floatlefts' style=' font-size:24px; padding-top:5px; line-height:18px;'>
                                <span id='ub_username_msg'></span>
                                <br/>
                                <span style='font-size:14px;' id='ub_email_sms_info'></span>
                            </div>
                            <div class='floatright' style='font-size:11px; text-align:right; color:#666666; position:relative; height:65px; '>
                                
                               
                            
                                  
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                    
                                                 
                            
                                                   <div class='ub_title'></div>
                                                   <div id='ub-email-content'>
                                                    <div class='br7'></div>
                                                        <div class='ub_corners ub_text_box_wraps'>
                                                             <input type='text' id='ub_send_email_subject' class='ub_text_box' value='enter your subject line here'/>
                                                        </div>
                                                        <div style='height:7px;'></div>
                                                        <div class='ub_corners ub_text_area_wraps'>
                                                            <textarea id='ub_send_email_msg' class='ub_text_area'>enter your message here</textarea>
                                                        </div>
                                                      <div style='padding:7px 15px 0px 0px; text-align:right'>
                                                               <span id='email_err_msg' class='fll txtl' style='margin-left:2px; font-size:11px;'></span><span class='ub_buttons ub_return_to_user flr' onclick="sendMail();">send email</span>
                                                               <div class='clb'></div>
                                                      </div>
                                                   </div>
                                                   <div id='ub-sms-content' class='hiddenText' style='font-size:12px;'>
                                                        <div class='br7'></div>
                                 &nbsp;number must include the country code (eg UK: 447289101112) - characters(<span id='ub_send_sms_msg_charcount'></span>)
                                                        <div class='ub_corners ub_text_area_wraps'>
                                                            <textarea id='ub_send_sms_msg' class='ub_text_area' onkeyup='charCount(this);'>enter your message here</textarea>
                                                        </div>
                                                          <div style='padding:7px 15px 0px 0px; text-align:right'>
                                                                <span id='sms_err_msg' class='fll txtl' style='margin-left:2px;'></span><span class='flr ub_buttons ub_return_to_user' onclick="sendSMS();">send sms</span>
                                                                <div class='clb'></div>
                                                          </div>
                                                        
                                                   </div>
                                                   
                                              </div>
                                                </div>
                                                
                                                      </div>            
                                              
                                                </div>
                                       
                                        </li>
                                  
                                    
                                       
                                       
                                        <li id='user-details'>
                                            <div class='sh'>
                                                <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                    <div class='fll txtl'>
                                                        	
                                                    </div>
                                                    <div class='flr txtr' >
                                                        <span style='background-color:#BA211C' id='delete_user'  class="ub_buttons" onclick="showinfobox('delete_user_loadbox');">delete this user</span>
							<span class='ub_buttons' onclick='slider_changer("payments","qf-pane-options");get_payments(1,0);' >payments</span>
                                                        <span class='ub_buttons' onclick='slider_changer("editor","qf-pane-options")' >edit user</span>
                                                         <span class='ub_buttons' onclick='slider_changer("email","qf-pane-options")'>send message</span>  <span onclick='slider_changer("user-notes","qf-pane-options"); getUserNotes();' class='ub_buttons'>user notes</span>
                                                    </div>
                                                    <div class='clb'></div>
                                                </div>
                                                 <div class='ub_corners slider_c'>
                                                   
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 <div class='floatlefts ub_imgbox hide' >
                            <img id='graveimg' src='' width='40px' height='40px'/>
                        </div>
                        <div class='floatlefts ' style=' margin-left:10px; position:relative; width:428px;'>
                            <div class='floatlefts' style=' font-size:24px; padding-top:5px; line-height:18px;'>
                                <span id='ub_username_display'></span>
                                <br/>
                                <span style='font-size:14px;' >joined on <a href='javascript:void(0)' id='ub_joinedate_display'></a><span id='ub_jointime_display'></span></span>
                            </div>
                            <div class='floatright' >

                               
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                   <div class='br7'></div>
                                                   <div class='br7'></div>
                                                   <div id='left-details' class='ub_corners floatlefts'>
                                                        <div class='ub_corners user_details_out' >
                                                            <div class='floatlefts'>country:<img id='ub_rel_country' onclick='release_filter("country")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right; font-size:13px;'><a href='javascript:void(0)' id='ub_country_display'>loading...</a></div>
                                                            <div class='clb'></div>
                                                        </div>
                                                        <div class='ub_corners user_details_out' >
                                                            <div class='floatlefts'>language:<img id='ub_rel_lang' onclick='release_filter("lang")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_lang_display'>loading...</a></div>
                                                        <div class='clb'></div>
                                                        </div>
                                                        <div class='ub_corners user_details_out' >
                                                            <div class='floatlefts'>browser:<img id='ub_rel_browser' onclick='release_filter("browser")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_browser_display'>loading...</a></div>
                                                        <div class='clb'></div>
                                                        </div>
                                                        
                                                        <div class='ub_corners user_details_out' >
                                                            <div class='floatlefts'>OS:<img id='ub_rel_os' onclick='release_filter("os")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_os_display'>loading...</a></div>
                                                        <div class='clb'></div>
                                                        </div>
                                                        <div class='hrule' style=' margin:5px 0px 5px 0px; height:0px; border-color:#f3f3f3;'></div>
                                                        <div class='ub_corners user_details_out' >
                                                            <div class='floatlefts'>date joined:<img id='ub_rel_regdate' onclick='release_filter("regdate")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_date_join_display'>loading...</a><span id='ub_time_join_display'></span></div>
                                                        <div class='clb'></div>
                                                        </div>
                                                        <div class='ub_corners user_details_out' >
                                                            <div class='floatlefts'>reg ip:<img id='ub_rel_regip' onclick='release_filter("regip")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_regip_display'>loading...</a></div>
                                                        <div class='clb'></div>
                                                        </div>
                                                        <div class='hrule' style=' margin:5px 0px 5px 0px; height:0px; border-color:#f3f3f3;'></div>
                                                        <div class='ub_corners user_details_out' >
                                                            <div class='floatlefts'>last visit:<img id='ub_rel_lastdate' onclick='release_filter("lastdate")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_date_last_display'>loading...</a><span id='ub_time_last_display'></span></div>
                                                        <div class='clb'></div>
                                                        </div>
                                                        <div class='ub_corners user_details_out' >
                                                            <div class='floatlefts'>last ip:<img id='ub_rel_lastip' onclick='release_filter("lastip")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_lastip_display'>loading...</a></div>
                                                        <div class='clb'></div>
                                                        </div>
                                                        <div class='clearboth'></div>
                                                    
                                                   </div>
                                                   <div id='right-details'  class='ub_corners floatlefts'>
                                                    <div class='ub_corners user_details_out' >
                                         
                                                    <div class='floatlefts'>userid:<img id='ub_rel_userid' onclick='release_filter("userid")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div>  <div class='floatright' style='text-align:right'><span  style='color:#2b8ab2;' id='ub_userid_display'>loading...</span></div>
<div class='clb'></div>
</div>
<div class='ub_corners user_details_out' >
<div class='floatlefts'>user group:<img id='ub_rel_group' onclick='release_filter("group")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_group_display'>loading...</a></div>
<div class='clb'></div>
</div>
<div class='ub_corners user_details_out' >
<div class='floatlefts'>active:<img id='ub_rel_active' onclick='release_filter("active")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div>  <div class='floatright' style='text-align:right'><span style='color:#00c50c;'><a href='javascript:void(0)' id='ub_active_display'>loading...</a></span></div>
<div class='clb'></div>
</div>
<div class='ub_corners user_details_out' >
<div class='floatlefts'>referal id:<img id='ub_rel_refid' onclick='release_filter("refid")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div>  <div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_refid_display'>loading...</a></div>
<div class='clb'></div>
</div>
<div class='hrule' style=' margin:5px 0px 5px 0px; height:0px; border-color:#f3f3f3;'></div>
<div class='ub_corners user_details_out' >
<div class='floatlefts'>phone:<img id='ub_rel_phone' onclick='release_filter("phone")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div>  <div class='floatright' style='text-align:right'><a href='javascript:void(0)' id='ub_phone_display'>loading...</a></div>
<div class='clb'></div>
</div>
<div class='ub_corners user_details_out' >
<div class='floatlefts'>email:<img id='ub_rel_email' onclick='release_filter("email")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div> <div class='floatright' style='text-align:right'><span  style='color:#2b8ab2; font-size:12px; '><a href='javascript:void(0)' id='ub_email_display'>loading...</a></span></div>
<div class='clb'></div>
</div>
<div class='hrule' style=' margin:5px 0px 5px 0px; height:0px; border-color:#f3f3f3;'></div>
<div class='ub_corners user_details_out' >
<div class='floatlefts'>contactable:<img id='ub_rel_contact' onclick='release_filter("contact")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div><div class='floatright' style='text-align:right'><span style='color:#bc0000; '><a href='javascript:void(0)' id='ub_contact_display'>loading...</a></span></div>
<div class='clb'></div>
</div>
<div class='ub_corners user_details_out' >
<div class='floatlefts'>status:<img id='ub_rel_status' onclick='release_filter("status")' class='hide ub_release_filters' src='images/release_grey_03.gif'/></div>  <div class='floatright' style='text-align:right'><span  style='color:#2b8ab2;'><a href='javascript:void(0)' id='ub_status_display'>loading...</a></span></div>
  <div class='clb'></div>
</div>
<div class='clearboth'></div>
                        </div>
                                                   <div class='clearboth'></div>
                                                   
                                                   <div id='center-details' class='ub_corners '>
                                                   refering url			:<img id='ub_rel_refurl' onclick='release_filter("refurl")' class='hide ub_release_filters' src='images/release_grey_03.gif'/> <span  style='color:#2b8ab2; '><a href='javascript:void(0)' id='ub_url_display' >loading...</a></span><br/>
                                                    refering domain	: <img id='ub_rel_refdomain' onclick='release_filter("refdomain")' class='hide ub_release_filters' src='images/release_grey_03.gif'/> <span  style='color:#2b8ab2; '><a href='javascript:void(0)' id='ub_domain_display'>loading...</a></span><br/>
                                                   </div>
                                                    <div class='breaklines_5'></div>
                                                </div>
                                                </div>
                                                
                                                  </div>                
                                              
                                       
                                        </div>
                                        </li>
                                  
                                        <li id='search-box'>
                                            <div class='sh'>
                                                        <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                    <div style='padding:0px 0px 0px 0px; text-align:right;'>
                                                          <span class='ub_buttons ub_return_to_user' onclick="return_to_user();">return to current user</span> <span class='ub_buttons' onclick="searchUser_QV('0,10',2);">search userbase</span>
                                                    </div>
                                                    
                                                </div>
                                                 <div class='ub_corners slider_c'>
                                                  
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                            
                        <div class='floatlefts ' style=' margin-left:10px; position:relative; width:405px;'>
                            <div class='' style=' font-size:24px; padding-top:5px; line-height:18px;'>
                                search userbase
                              
                                <div class='' style='font-size:13px; color:#666666; '>
                              remember, you can use 'clickable search' to narrow down your results
                            </div>
                            </div>
                            
                     
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                   
                                                   
                                                   <div style='padding:5px 15px 7px 0px; text-align:right;'>
                                                    </div>
                                                    <div class='floatlefts' style='width:230px; margin:0px 0px 0px 5px; font-size:13px;'>
                                                            &nbsp;username
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_username' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("username")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                     
                                                            &nbsp;email
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_email' class='ub_text_box_small'/>
                                                                     </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("email")'/>
                                                                </div>
                                                                <div class='clearboth'></div>     
                                                                         
                                                            </div>
                                                            <div style='height:7px;'></div>
                                                            &nbsp;userid
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_userid' class='ub_text_box_small'/>
                                                                          </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("userid")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                            </div>
                                                            <div style='height:7px;'></div>
                                                            &nbsp;phone number
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_phone' class='ub_text_box_small'/>
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("phone")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           
                                                           </div>
                                                            <div style='height:7px;'></div>
                                                          
                                                    
                                                            &nbsp;refering id
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                <div class='floatlefts ub_input_release' >
                                                                    <input type='text' id='ub_search_refid' class='ub_text_box_small'/>
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("refid")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                            
                                                            </div>
                                                            <div style='height:7px;'></div>
                                                          
                                                    
                                                            &nbsp;refering url
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_refurl' class='ub_text_box_small'/>
                                                             </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("refurl")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                            <div style='height:7px;'></div>
                                                           &nbsp;refering domain
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_refdomain' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("refdomain")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                             <div style='height:7px;'></div>
                                                           &nbsp;registration date (dd/mm/yyyy)
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_regdate' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("regdate")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                           &nbsp;registration ip address
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_regip' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("regip")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                                    <div style='height:7px;'></div>
                                                           &nbsp;date of last visit (dd/mm/yyyy)
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_lastdate' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("lastdate")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                     
                                              
                                                          
                                                          
                                                          
                                                           
                                                   </div>
                                                    <div class='floatlefts' style='margin:0px 0px 0px 15px;font-size:13px;'>
                                                               
                                                           
                                                          
                                                          <div style='height:16px;'></div>
                                                         
                                      
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <select id='ub_search_country' class='ub_select_box_small'>
                                                                    <option value='-9'>loading...</option>
                                                                </select>
                                                                 </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("country")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                    <div style='height:22px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <select id='ub_search_lang' class='ub_select_box_small'>
                                                                  <option value='-9'>loading...</option>
                                                                </select>
                                                                </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("lang")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                               <div class='floatlefts ub_input_release' >
                                                                <select id='ub_search_os' class='ub_select_box_small'>
                                                                   <option value='-9'>loading...</option>
                                                                </select>
                                                                
                                                                 </div>
                                                                <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("os")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                          <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release'>
                                                                <select id='ub_search_browser' class='ub_select_box_small'>
                                                                  <option value='-9'>loading...</option>
                                                                </select>
                                                           </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("browser")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                            
                                                            </div>
                                                      <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release'>
                                                                <select id='ub_search_status' class='ub_select_box_small'>
                                                                     <option value="-9">Select Status</option>
<option value="0">Waiting Activation</option>
<option value="1">Activated</option>
<option value="2">Banned/Blocked</option>
                                                                </select>
                                                                
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("status")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                                
                                                           </div>
                                                    <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                             <div class='floatlefts ub_input_release'>
                                                                <select id='ub_search_contact' class='ub_select_box_small'>
                                                                     <option value='-9'>contactable?</option>
                                                                    <option value='1'>can contact</option>
                                                                    <option value='0'>do not contact</option>
                                                                </select>
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("contact")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                   <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                             <div class='floatlefts ub_input_release'>
                                                                <select id='ub_search_active' class='ub_select_box_small'>
                                                                     <option value='-9'>user active?</option>
                                                                    <option value='1'>active in last 30 days</option>
                                                                    <option value='0'>inactive in last 30 days</option>
                                                                </select>
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("active")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                 <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release'>
                                                                <select id='ub_search_group' class='ub_select_box_small'>
                                                                     <option value='-9'>loading?</option>
                                                                    
                                                                </select>
                                                             </div>
                                                          <div class='floatright ub_release_filters' >
                                                                <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("group")'/>
                                                            </div>
                                                            <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:7px;'></div>
                                                        &nbsp;ip address of last visit
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_search_lastip' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_release_filters' >
                                                                    <img title='release this filter'  src='images/release_grey_03.gif' onclick='release_filter("lastip")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                        
                                              <!-- UPGRADE TO UL based LISTs in next version for IE -->
                                                         <div class='ub_corners ub_select_box_wraps_small hiddenText'>
                                                            <div class="sample">
                                                                            
                                                                <ul class="droplist droplist-by-list"  >
                                                                        <li><a href="http://www.google.com">Google</a></li>
				<li><input type='checkbox'/><a href="http://www.yahoo.com">Yahoo</a></li>
				<li><a href="http://www.ask.com">Ask</a></li>
				<li><a href="http://www.bing.com">Bing</a></li>
				<li><a href="http://www.google.com">Google</a></li>
				<li><a href="http://www.yahoo.com">Yahoo</a></li>
				<li><a href="http://www.ask.com">Ask</a></li>
				<li><a href="http://www.bing.com">Bing</a></li>
				<li><a href="http://www.google.com">Google</a></li>
				<li><a href="http://www.yahoo.com">Yahoo</a></li>
				<li><a href="http://www.ask.com">Ask</a></li>
				<li><a href="http://www.bing.com">Bing</a></li>
				<li><a href="http://www.google.com">Google</a></li>
				<li><a href="http://www.yahoo.com">Yahoo</a></li>
				<li><a href="http://www.ask.com">Ask</a></li>
				<li><a href="http://www.bing.com">Bing</a></li>
				<li><a href="http://www.google.com">Google</a></li>
				<li><a href="http://www.yahoo.com">Yahoo</a></li>
				<li><a href="http://www.ask.com">Ask</a></li>
				<li><a href="http://www.bing.com">Bing</a></li>
				<li><a href="http://www.google.com">Google</a></li>
				<li><a href="http://www.yahoo.com">Yahoo</a></li>
				<li><a href="http://www.ask.com">Ask</a></li>
				<li><a href="http://www.bing.com">Bing</a></li>
				<li><a href="http://www.google.com">Google</a></li>
				<li><a href="http://www.yahoo.com">Yahoo</a></li>
				<li><a href="http://www.ask.com">Ask</a></li>
				<li><a href="http://www.bing.com">Bing</a></li>
				<li><a href="http://www.google.com">Google</a></li>
				<li><a href="http://www.yahoo.com">Yahoo</a></li>
				<li><a href="http://www.ask.com">Ask</a></li>
				<li><a href="http://www.bing.com">Bing</a></li>
                                                                 </ul>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class='clearboth'>
                                                         
                                               
                                                           
                                                        
                                                        
                                                    </div>
                                                   
                                                   
                                                   
                                              </div>
                                                </div>
                                        </div>
                                         
                                        </div>
                                        </li>
                                        
                                 
                                           
                                                         <li id='add-new'>
                                                            <div class='sh'>
                                                                   <div class='ub_corners slider_cx' style='margin-bottom:3px;'>
                                                                        <div style='padding:0px; text-align:right;'>
                                                                              <span class='ub_buttons ub_return_to_user' onclick="return_to_user();">return to current user</span> <span class='ub_buttons' onclick="saveNewUser();">add new user</span>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                 <div class='ub_corners slider_c'>
                                                  
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                 
                        <div class='floatlefts ' style=' margin-left:10px; position:relative; '>
                           <div class='' style=' font-size:24px; padding-top:5px; line-height:18px;'>
                                add a new user
                              
                                <div class='' style='font-size:13px; color:#666666; '>
                              username, email, user group and passowrd are the only required fields
                            </div>
                            </div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                   
                                                    <div style='padding:5px 15px 7px 0px; text-align:right;'>
                                                    </div>
                                                   
                                                    <div class='floatlefts' style='width:230px; margin:0px 0px 0px 5px; font-size:13px;'>
                                                            &nbsp;username
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_add_user' >
                                                                <input type='text' id='ub_add_username' class='ub_text_box_small'/>
                                                                 </div>
                                                              <div class='floatright ub_input_warnings ub_add_warn' id='ub_input_add_warning_username' >
                                                                    <img id='ub_input_add_img_username'   src='images/blank.gif' />
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                     
                                                            &nbsp;email
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                         <div class='floatlefts ub_input_release_add_user' >
                                                                <input type='text' id='ub_add_email' class='ub_text_box_small'/>
                                                                     </div>
                                                              <div class='floatright ub_input_warnings ub_add_warn' >
                                                                    <img id='ub_input_add_img_email'   src='images/blank.gif' onclick='release_filter("email")'/>
                                                                </div>
                                                                <div class='clearboth'></div>     
                                                                         
                                                            </div>
                                                            <div style='height:7px;'></div>
                                                              
                                                           &nbsp;user password
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_add_user' >
                                                                <input type='password' id='ub_add_pass' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_add_warn' >
                                                                    <img id='ub_input_add_img_pass'   src='images/blank.gif' onclick='release_filter("lastip")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                           <div style='height:7px;'></div>
                                                            &nbsp;phone number
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_add_user' >
                                                                <input type='text' id='ub_add_phone' class='ub_text_box_small'/>
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_add_warn' >
                                                                    <img id='ub_input_add_img_phone'   src='images/blank.gif' onclick='release_filter("phone")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           
                                                           </div>
                                                            <div style='height:7px;'></div>
                                                          
                                                    
                                                            &nbsp;refering id
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                                <div class='floatlefts ub_input_release_add_user' >
                                                                    <input type='text' id='ub_add_refid' class='ub_text_box_small'/>
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_add_warn' >
                                                                    <img id='ub_input_add_img_refid'   src='images/blank.gif' onclick='release_filter("refid")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                            
                                                            </div>
                                                            <div style='height:7px;'></div>
                                                          
                                                    
                                                            &nbsp;refering url
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_add_user' >
                                                                <input type='text' id='ub_add_refurl' class='ub_text_box_small'/>
                                                             </div>
                                                              <div class='floatright ub_input_warnings ub_add_warn' >
                                                                    <img id='ub_input_add_img_refurl'   src='images/blank.gif' onclick='release_filter("refurl")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           </div>
                                                            <div style='height:7px;'></div>
                                                           &nbsp;refering domain
                                                           <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='floatlefts ub_input_release_add_user' >
                                                                <input type='text' id='ub_add_refdomain' class='ub_text_box_small'/>
                                                            
                                                                </div>
                                                              <div class='floatright ub_input_warnings ub_add_warn' >
                                                                    <img id='ub_input_add_img_refdomain'   src='images/blank.gif' onclick='release_filter("refdomain")'/>
                                                                </div>
                                                                <div class='clearboth'></div>
                                                           
                                                           </div>
                                                             <div style='height:7px;'></div>
                                                         
                                                             
                                                           
                                              
                                                          
                                                          
                                                          
                                                           
                                                   </div>
                                                    <div class='floatlefts' style='margin:0px 0px 0px 15px'>
                                                         <div style='height:16px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release_add_user' style='width:100%'>
                                                                <select id='ub_add_country' class='ub_select_box_small' style='width:inherit;'>
                                                                    <option value='-9'>loading...</option>
                                                                </select>
                                                                 </div>
                                                                
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release_add_user' style='width:100%'>
                                                                <select id='ub_add_lang' class='ub_select_box_small' style='width:inherit;'>
                                                                  <option value='-9'>loading...</option>
                                                                </select>
                                                                </div>
                                                                
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                               <div class='ub_input_release_add_user' style='width:100%'>
                                                                <select id='ub_add_os' class='ub_select_box_small'  style='width:inherit;'>
                                                                   <option value='-9'>loading...</option>
                                                                </select>
                                                                
                                                                 </div>
                                                               
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release_add_user' style='width:100%'>
                                                                <select id='ub_add_browser' class='ub_select_box_small' style='width:inherit;'>
                                                                  <option value='-9'>loading...</option>
                                                                </select>
                                                           </div>
                                                           
                                                                <div class='clearboth'></div>
                                                            
                                                            </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release_add_user' style='width:100%'>
                                                                <select id='ub_add_status' class='ub_select_box_small' style='width:inherit;'>
                                                                     <option value="-9">Select Status</option>
<option value="0">Waiting Activation</option>
<option value="1">Activated</option>
<option value="2">Banned/Blocked</option>
                                                                </select>
                                                                
                                                                </div>
                                                             
                                                                <div class='clearboth'></div>
                                                                
                                                           </div>
                                                         <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                             <div class='ub_input_release_add_user' style='width:100%'>
                                                                <select id='ub_add_contact' class='ub_select_box_small' style='width:inherit;'>
                                                                     <option value='-9'>contactable?</option>
                                                                    <option value='1'>can contact</option>
                                                                    <option value='0'>do not contact</option>
                                                                </select>
                                                                </div>
                                                             
                                                                <div class='clearboth'></div>
                                                           </div>
                                                      
                                                         <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release_add_user' style='width:100%'>
                                                                <select id='ub_add_group' class='ub_select_box_small' style='width:inherit;'>
                                                                     <option value='-9'>loading?</option>
                                                                    
                                                                </select>
                                                             </div>
                                                          
                                                            <div class='clearboth'></div>
                                                        </div>
                                                       
                                                         
                                                           
                                                         
                                                         
                                                         
                                        </div>
                                                    <div class='clearboth'>
                                                        
                                                      
                                                           
                                                        
                                                        
                                                    </div>
                                                   
                                              </div>
                                                </div>
                                        </div>
                                                            </div>
                                         </li>
                                        
                               
                                    
                                    
                                    
                                    
                                    
                                        
                                                   
                                                   
                                                 
                                                 
                                                 
                                                   <li id='payments'>
                                            <div class='sh'>
                                                  <div class='ub_corners slider_cx' >
                                                    <div style='padding:0px; text-align:right;'>
                                                         <span class='ub_buttons ' onclick="show_membership();">membership details</span>
                                                          <span class='ub_buttons ' onclick="show_payments();">payments details</span> 
                                                       <span class='ub_buttons ub_return_to_user' onclick="return_to_user();">return to current user</span>
                                                       
                                                    </div>
                                                    
                                                </div>
                                            <div class='ub_corners slider_c' style='height:580px;'>
                                                   
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 
                        <div class='floatlefts ' style=' margin-left:10px; position:relative; width:405px;'>
                            <div class='floatlefts' style=' font-size:24px; padding-top:5px; '>
                                payments area
                                <br/>
                                <span style='font-size:14px;'>
                          
                                </span>
                         
                            </div>
                            <div class='floatright' style='font-size:11px; text-align:right; color:#666666; position:relative; height:65px; '>
                                
                               
                                    
                                  
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                    	    <div class='hiddenStuff centeralAreaStuff_id_##userid##' id='payments_id_##userid##'>
                                                                <div  class="qi-section-pay-sys" id='pay-sys-block'>
                                                                    <div id="qi-pane-options-pay-sys" class="pane-pay-sys">
                                                                        <ul class="qi-elements-pay-sys" style="width:2000px;" id='pay-sys-main-ul'>
                                                                            <li id='scroll-payments-details'>
                                                                   
                                                                            
                                                                            <div class='ub_corners' id='center-details'>
									
									     <div class="breaklines_5"></div>
									    <div class="breaklines_5"></div>
									    
                                                                            <div class='fll'>
                                                                                    &nbsp;add new payment amount
                                                                                    <div class='ub_corners ub_text_box_wraps_small'>
                                                                                        <div class='floatlefts ub_input_release_add_fee_amount' >
                                                                                            <input type='text' id='payment_amount' class='ub_text_box_small'/>
                                                                                        </div>
                                                                                        <div class='floatright ub_input_warnings ub_add_warn' id='ub_input_add_warning_fee_amount' >
                                                                                            <img id='ub_input_add_img_fee_amount'   src='images/blank.gif' />
                                                                                        </div>
                                                                                        <div class='clearboth'></div>
                                                                                  
                                                                                    </div>
                                                                             </div>
                                                                             <div class='fll' style='margin-left:5px;'>
                                                                                    &nbsp;add new payment comment                                                                                   <div class='ub_corners ub_text_box_wraps_small'>
                                                                                        <div class='floatlefts ub_input_release_add_payment_comment' >
                                                                                            <input type='text' id='payment_comment' class='ub_text_box_small'/>
                                                                                        </div>
                                                                                        <div class='floatright ub_input_warnings ub_add_warn' id='ub_input_add_warning_payment_comment' >
                                                                                            <img id='ub_input_add_img_payment_comment'   src='images/blank.gif' />
                                                                                        </div>
                                                                                        <div class='clearboth'></div>
                                                                                  
                                                                                    </div>
                                                                             </div>
                                                                        <span class ='ub_buttons fll'  onclick='add_payment()' style='margin-left:5px; margin-top:18px; display:block;'>save</span>
                                                                             <div class='clb'></div>
                                                                            
                                                                        
									 </div>
									   
									   
                                                                            
                                                                             <div class="breaklines_5"></div>
									    <div class="breaklines_5"></div>
                                                                           
                                                                           
                                                                           
                                                                            <div class='ub_corners' id='center-details'>
									    <table cellpadding='5' cellspacing='1' border='0' class='payments_table' style='width:100%' >
											       <thead id='payments_header'>
														  <tr>
																   
																     <td class='quick_res_header'>
																			amount 
																     </td>
																     <td class='quick_res_header'>
																			action
																     </td>
																     <td class='quick_res_header'>
																			date
																     </td>
																    
																     <td class='quick_res_header'>
																			comment
																     </td>
														  </tr>
											       </thead>
											       <tbody id='payments_body''>
													  <tr><td colspan='6'>loading...</td></tr>
													
											       </tbody>
									    </table>
									    </div>
									     <div style='height:15px; margin-top:10px; border-top:solid 1px #ebebeb;'></div>
                                                                           
                                                                            
                                                                            <div id="pagationBlock_pay">
                                                                                
                                                                                <div id='payments_page' class='pagination'></div>
											
											   <div class='clearboth'></div>      
									    </div>
									    
									    
									     <div class="breaklines_5"></div>
									    
                                                                            
                                                                            </li>
                                                                            <li id='scroll-membership-details'>
                                                                                <div class='ub_corners' id='center-details'>
                                                                                <div class='fll'>
                                                                                       &nbsp;set membership status
                                                                                       <div class='ub_corners ub_text_box_wraps_small'>
                                                                                           <div class=' ub_input_release' style='width:100%' >
                                                                                               <select id='paid_status' class='ub_select_box_small' style='width:inherit;'>
                                                                                                   <option value='0'>non-paying member</option>
                                                                                                   <option value='1'>paying member</option>
                                                                                               </select>
                                                                                            </div>
                                                                                           
                                                                                           <div class='clearboth'></div>
                                                                                      </div>
                                                                                </div>
                                                                                <span class ='flr ub_buttons' onclick='update_paid_status();' style='margin-left:2px; margin-top:19px; display:block;'>update</span>
                                                                                <div class='clb'></div>
                                                                            
									    </div>
											
											
									    
									  
									    
									    
									    
                                                                            
                                                                          
									    <div class='ub_corners' id='center-details'>
                                                                             <div class='fll'>
                                                                                    &nbsp;membership fee
                                                                                    <div class='ub_corners ub_text_box_wraps_small'>
                                                                                        <div class='floatlefts ub_input_release_add_fee' >
                                                                                            <input type='text' id='user_fee' class='ub_text_box_small'/>
                                                                                        </div>
                                                                                        <div class='floatright ub_input_warnings ub_add_warn' id='ub_input_add_warning_fee' >
                                                                                            <img id='ub_input_add_img_fee'   src='images/blank.gif' />
                                                                                        </div>
                                                                                        <div class='clearboth'></div>
                                                                                  
                                                                                    </div>
                                                                             </div>
                                                                             <div class='fll' style='margin-left:5px;'>
                                                                                    &nbsp;membership renewal date                                                                                    <div class='ub_corners ub_text_box_wraps_small'>
                                                                                        <div class='floatlefts ub_input_release_add_renewal_date' >
                                                                                            <input type='text' id='renewal_date' class='ub_text_box_small'/>
                                                                                        </div>
                                                                                        <div class='floatright ub_input_warnings ub_add_warn' id='ub_input_add_warning_renewal_date' >
                                                                                            <img id='ub_input_add_img_renewal_date'   src='images/blank.gif' />
                                                                                        </div>
                                                                                        <div class='clearboth'></div>
                                                                                  
                                                                                    </div>
                                                                             </div>
                                                                             <span class ='flr ub_buttons' onclick='update_fee_date();' style='margin-left:2px; margin-top:19px; display:block;'>update</span>
                                                                             <div class='clb'></div>
                                                                             <div class="breaklines_5"></div>
									    <div id='editFeeDateResponse' class='darkgrey'></div>
									    <div class="breaklines_5"></div>
									    </div>
											
											
									    
									  
									    
									    
									    
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            </li>
                                                                           
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                            <div style='height:15px; margin-top:10px; border-top:solid 1px #ebebeb;'></div>
                                                                           
                                                                          
                                                                            </div>
								
                                                
                                                
                                                
                                                </div>
                                                </div>
                                                
                                                                  
                                              </div>
                                       
                                            </div>
                                        </li>
                                  
                                  
                                    
                                     
                                       
                                       
                                         <li id='user-notes'>
                                            <div class='sh'>
                                                  <div class='ub_corners slider_cx' >
                                                    <div style='padding:0px; text-align:right;'>
                                                        <span class='ub_buttons ub_return_to_user' onclick="addUserNote()">add note</span> <span class='ub_buttons ub_return_to_user' onclick="return_to_user();">return to current user</span> 
                                                    </div>
                                                    
                                                </div>
                                            <div class='ub_corners slider_c' style='height:580px;'>
                                                   
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 
                        <div class='floatlefts ' style=' margin-left:10px; position:relative; width:405px;'>
                            <div class='floatlefts' style=' font-size:24px; padding-top:5px; line-height:18px;'>
                                <span id='ub_username_notes'></span>'s notes
                                <br/>
                                <span style='font-size:14px;'>
                                    add user support notes for other administartors to read
                                </span>
                         
                            </div>
                            <div class='floatright' style='font-size:11px; text-align:right; color:#666666; position:relative; height:65px; '>
                                
                               
                                    
                                  
                            </div>
                             <div class='clearboth'></div>
                            
                             
                        </div>
                       
                       
                       
                       
                        <div class='clearboth'></div>
                                                    
                                                </div>
                                                <div class='ub-details-content'>
                                                       <div id='note-add' class='ub_corners '>
                                                        <div class='ub_corners ub_text_box_wraps_long'>
                                                                         <div class='floatlefts ub_input_generic' >
                                                                <input type='text' id='ub_add_note' class='ub_text_box_long' value='type new note here'/>
                                                                 </div>
                                                              <div class='floatright ub_input_end_button' id='ub_input_ub_add_notes' title='add new note' onclick='addUserNote();'>
                                                                    <img id='ub_input_add_img_note'   src='images/add_note.gif' />
                                                                </div>
                                                                <div class='clearboth'></div>
                                                          
                                                        </div>
                                                  
                                                  
                                                   </div>
                                                   <div class='breaklines_5'></div>
                                                   <div id='notes_results' class='ub_corners '>
                                                        <br/>
                                                        <center>
                                                        <img src='images/loader/bl_g.gif'/><br/>
                                                        searching for notes...
                                                        </center>
                                                   </div>
                                                   
                                                   
                                                   
                                                   
                                               
                                                   
                                              </div>
                                                </div>
                                                
                                                                  
                                              </div>
                                       
                                            </div>
                                        </li>
                                  
                                    
                                      
                                        
                                         <li>
                                            <div class='sh'>
                                            <div class='ub_corners slider_c'>
                                                   
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 
                                                   
                                                   
                                                   
                                                   
                                                   
                                                    <div class='clearboth'></div>
                                                                                
                                                                            </div>
                                                                            <div class='ub-details-content'>
                                                                              
                                                                              
                                                                               
                                                                          </div>
                                                                            </div>
                                                
                                                                  
                                              </div>
                                            </div>
                                         
                                         </li>
                                  
                                    
                                     
                                           
                                   </ul>
                                </div>
                            </div>
                        </div>
                  
                 
                 
                 
             
                
                 
            
            
            
            </div>
        </div>
        <div id='action_area' class='fll ub_corners' ></div>
        <div class='clb'></div>
                                            </li>
                                                
                                                
                                                <li id='unibody_dashboard'>
                                                     <div id='dashmain_float_ub' class='ub_corners dashmain_float'>
                     <div class='ub_dash_reports ub_corners'  >
    <div style='padding:0px 0px 0px 7px;'>
      
             <div id='rep_loader_gif' class='hiddenText'><img src='images/loader/bl_w.gif'/></div> 
        
        <div class='' id='rep_quick_stats'>
            <div class='floatlefts' style='height:100%;vertical-align:middle; margin-right:25px; padding:10px 25px 0px 15px;'>
                 <div class='rep_domainname' id='rep_domain' >userbase site stats</div>
             <a onclick='slide_unibody("overview_ss");' href='javascript:void(0)' class='orangelink rep_tracking'>get detailed stats here</a>
                
            </div>
           
            
            
            <div class='flr rep_top_stats'  >
                
                 
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        overall traffic
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_visit'></b> 
                    </div>
                    <div class='rep_top_stats_tiny'>
                        total visits in 30 days
                    </div>
                </div> 
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        registered users
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_reg'></b> (<span id='rep_reg_30day' class=''></span>)
                    </div>
                    <div class='rep_top_stats_tiny'>
                        brackets: 30 day trend
                    </div>
                </div>
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        registrations in
                    </div>
                    <div class='rep_top_stats_big'>
                        <b ><span id='rep_30day_reg'></span> </b> 
                    </div>
                    <div class='rep_top_stats_tiny'>
                       the last 30 days
                    </div>
                </div>
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        active in 
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_active'></b>
                    </div>
                    <div class='rep_top_stats_tiny'>
                        the last 30 days
                    </div>
                </div>
                
                <div  class='floatlefts rep_top_stats_boxes_last' >
                    <div class='rep_top_stats_small'>
                        overall conversion 
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_con_all'></b>% (<span id='rep_con_30'></span>%)
                    </div>
                    <div class='rep_top_stats_tiny'>
                         brackets: in 30 days
                    </div>
                </div>
               <div class='clearboth'></div>
                 
                
            </div>
                  <div class='clearboth'></div>
        </div>
    </div>
                                      
 </div>
<div >
                       
                       <div class='floatlefts ub_corners' style='margin-top:10px;padding:0px 6px 10px 10px; text-align:left; border-right:solid 1px #ebebeb;'>
                        
                          
                           <div id='new_users_results'>
                              
                           </div>
                           <div class="br5 clb"></div>
                              <div class='ub_corners ub_dash_side'  style='padding:10px; text-align:left; width:520px;'>
                        
                           <span class="headings" style='font-size:13px'>userbase security alerts: <a href='login_logs.php' target='_blank' style='color:#ff6600'>view full logs</a></span>
                       
                                         <div id="alertsbox" class='hide' style='font-size:12px; padding:3px;'>
                                              
                                              
                                              <div id='admin_fail' class='hide' >
                                                <div class="br7"></div>
                                                <div class="br7"></div>
                                                login failures (admin login)
                                              <div class="br7"></div>
                                              <div id='admin_logins'></div>
                                              </div>
                                              <div id='user_fail' class='hide'>
                                                   <div class="br7"></div>
                                                    login failures (user login)
                                                <div class="br7"></div>
                                                <div id='user_logins'></div>
                                            </div>
                                        </div>
                       </div>
                       </div>
                       
                       
                       
                         <div class='floatright ub_corners'  style='padding:0px 10px 10px 7px; text-align:left;margin-top:10px; '>
                        
                          <div class='ub_corners ub-quick-results-box-chart' style='background-color:#fff' >
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px; text-align:center;'>
                                   <div id='chart_div'></div>
                                    
                                    
                                    
                           
                             
                             </div>
                    </div>
                                
                          
                        </div>
                            <div class='ub_corners ub-quick-results-box-chart' >
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' id='swap_txt' onclick='swap_user_visitor_stats();' style=' margin-left:5px; text-align:center; '>
                                 show quick stats results for vistors</div>
                    </div>
                                
                          
                        </div>
                        
                            
                            
                            
                       
                            
                            
                            <div id='user_qstats'>
                        <div class='ub_corners ub-quick-results-box'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px;'>
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'   >
                                           <span id='ub_dash_browser'></span>
                                          <br/>
                                           <div  style='font-size:12px;font-weight:normal; font-family:arial'>
                                       most popular browser
                                    </div>
                                    </div>
                                    <div   class='floatright qs_percent' id='ub_dash_browser_user' >
                                  
                                     
                                    </div>
                                  
                                    
                                    
                        
                                     <div class='clearboth'></div>
                           
                             
                             </div>
                    </div>
                                
                          
                        </div>
                        
                            
                            
                             <div class='ub_corners ub-quick-results-box'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px;'>
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'    >
                                          <span id='ub_dash_os'></span>
                                          <br/>
                                           <div  style='font-size:12px; font-weight:normal; font-family:arial'>
                                            most popular os
                                    </div>
                                    </div>
                                    <div   class='floatright qs_percent' id='ub_dash_os_user' >
                                   
                                     
                                    </div>
                                  
                                    
                                    
                        
                                     <div class='clearboth'></div>
                           
                             
                             </div>
                    </div>
                                
                          
                        </div>
                        
                           
                            
                            
                            
                            
                            
                             
                             
                              <div class='ub_corners ub-quick-results-box'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px;'>
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'  >
                                          <span id='ub_dash_location'></span>
                                          <br/>
                                           <div  style='font-size:12px; font-weight:normal;font-family:arial'>
                                       most popular location
                                    </div>
                                    </div>
                                    <div   class='floatright qs_percent' id='ub_dash_location_user' >
                                     
                                     
                                    </div>
                                  
                                    
                                    
                        
                                     <div class='clearboth'></div>
                           
                             
                             </div>
                    </div>
                                
                          
                        </div>
                        
                           
                             
                             
                             
                             
                                <div class='ub_corners ub-quick-results-box'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px;'>
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'   >
                                          <span id='ub_dash_language'></span>
                                          <br/>
                                           <div  style='font-size:12px; font-weight:normal;font-family:arial'>
                                       most popular language
                                    </div>
                                    </div>
                                    <div   class='floatright qs_percent' id='ub_dash_language_user' >
                                      
                                     
                                    </div>
                                  
                                    
                                    
                        
                                     <div class='clearboth'></div>
                           
                             
                             </div>
                    </div>
                                
                          
                        </div>
                        
                           
                             
                             
                             
                             
                           
                                        
                                        
                         
                            </div>
                        <div id='visit_qstats' class='hide'>
                            <div class='ub_corners ub-quick-results-box'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px;'>
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'    >
                                           <span id='ub_dash_browser_v'></span>
                                          <br/>
                                           <div  style='font-size:12px;font-weight:normal; font-family:arial'>
                                       most popular browser
                                    </div>
                                    </div>
                                    <div   class='floatright qs_percent' id='ub_dash_browser_visit' >
                                  
                                     
                                    </div>
                                  
                                    
                                    
                        
                                     <div class='clearboth'></div>
                           
                             
                             </div>
                    </div>
                                
                          
                        </div>
                        
                            
                            
                             <div class='ub_corners ub-quick-results-box'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px;'>
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'   >
                                          <span id='ub_dash_os_v'></span>
                                          <br/>
                                           <div  style='font-size:12px; font-weight:normal; font-family:arial'>
                                            most popular os
                                    </div>
                                    </div>
                                    <div   class='floatright qs_percent' id='ub_dash_os_visit' >
                                   
                                     
                                    </div>
                                  
                                    
                                    
                        
                                     <div class='clearboth'></div>
                           
                             
                             </div>
                    </div>
                                
                          
                        </div>
                        
                           
                            
                            
                            
                            
                            
                             
                             
                              <div class='ub_corners ub-quick-results-box'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px;'>
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'    >
                                          <span id='ub_dash_location_v'></span>
                                          <br/>
                                           <div  style='font-size:12px; font-weight:normal;font-family:arial'>
                                       most popular location
                                    </div>
                                    </div>
                                    <div   class='floatright qs_percent' id='ub_dash_location_visit'>
                                     
                                     
                                    </div>
                                  
                                    
                                    
                        
                                     <div class='clearboth'></div>
                           
                             
                             </div>
                    </div>
                                
                          
                        </div>
                        
                           
                             
                             
                             
                             
                                <div class='ub_corners ub-quick-results-box'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px;'>
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'    >
                                          <span id='ub_dash_language_v'></span>
                                          <br/>
                                           <div  style='font-size:12px; font-weight:normal;font-family:arial'>
                                       most popular language
                                    </div>
                                    </div>
                                    <div   class='floatright qs_percent' id='ub_dash_language_visit'>
                                      
                                     
                                    </div>
                                  
                                    
                                    
                        
                                     <div class='clearboth'></div>
                           
                             
                             </div>
                    </div>
                                
                          
                        </div>
                        
                           
                             
                             
                             
                             
                           
                                        
                                        
                         
                            
                        </div>
                      
                       </div>
                         
                       
                    
                   
                </div>
              
        </div>
        
        
      
        <div id='dashmain_ub' class='ub_corners dashmain'></div>
        
                                                </li>
                                                
                                                
                                                
                                                
                                                
                                                
                                                 <li id='unibody_overview_ss'>
                                                        <div id='dashmain_float_ov' class='ub_corners dashmain_float' style='padding:25px 10px 10px 13px;'>
<div >
    
    
    
       
<div >
    <div class='rep_report_links ' style='padding-top:0px;'>
        <span class='rep_links rep_main_links' id='rep_link_s_s_dashboard' onclick='slider_changer_stats("s_s_dashboard")' style='text-decoration:underline;  font-weight:bold; '>overview</span>
        <span class='rep_links rep_main_links' id='rep_link_s_s_pageviews' onclick='slider_changer_stats("s_s_pageviews")'>pageviews</span>
        <span class='rep_links rep_main_links' id='rep_link_s_s_refurl' onclick='slider_changer_stats("s_s_refurl")'>referring pages</span>
        <span class='rep_links rep_main_links' id='rep_link_s_s_landingpages' onclick='slider_changer_stats("s_s_landingpages")'>landing pages</span>

 
    </div>
</div>

                                   
                            <!--start-->                              
                                   <div  class="section_rep" style='' >
		
                    <div id="pane-options-overview" class="pane_rep" style=' '>
			<ul class="elements_rep" style="width:5000px;  ' " id='one'>
				<li id='slider_s_s_dashboard' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                                         <div class='floatlefts' >
                                                            <div class='ub_dash_reports ub_corners' style='margin:0px 0px 5px 0px;'  >
    <div style='padding:0px 0px 0px 7px;'>
      
             <div id='rep_loader_gif' class='hiddenText'><img src='images/loader/bl_w.gif'/></div> 
        
        <div class='' id='rep_quick_stats'>
            <div class='floatlefts' style='height:100%;vertical-align:middle; margin-right:25px; padding:10px 25px 0px 15px;'>
                 <div class='rep_domainname' id='rep_domain' >userbase site stats</div>
      
                
            </div>
           
            
            
            <div class='flr rep_top_stats'  >
                
                 
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        overall traffic
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_visit_ov'></b> 
                    </div>
                    <div class='rep_top_stats_tiny'>
                        total visits in 30 days
                    </div>
                </div> 
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        registered users
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_reg_ov'></b> (<span id='rep_reg_30day_ov' class=''></span>)
                    </div>
                    <div class='rep_top_stats_tiny'>
                        brackets: 30 day trend
                    </div>
                </div>
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        registrations in
                    </div>
                    <div class='rep_top_stats_big'>
                        <b ><span id='rep_30day_reg_ov'></span> </b> 
                    </div>
                    <div class='rep_top_stats_tiny'>
                       the last 30 days
                    </div>
                </div>
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        active in 
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_active_ov'></b>
                    </div>
                    <div class='rep_top_stats_tiny'>
                        the last 30 days
                    </div>
                </div>
                
                <div  class='floatlefts rep_top_stats_boxes_last' >
                    <div class='rep_top_stats_small'>
                        overall conversion 
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_con_all_ov'></b>% (<span id='rep_con_30_ov'></span>%)
                    </div>
                    <div class='rep_top_stats_tiny'>
                         brackets: in 30 days
                    </div>
                </div>
               <div class='clearboth'></div>
                 
                
            </div>
                  <div class='clearboth'></div>
        </div>
    </div>
                                      
 </div>

                                     
                                   <div class='roar_reports ub_corners3' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                            
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_overview' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_overviewd' id='rep_link_overviewd_1_days' onclick='overview_details("","1")' >24 hours</span>
                                                         <span class='rep_links rep_link_overviewd' id='rep_link_overviewd_30_days' onclick='overview_details("","30")' >30 days</span>
                                                         <span class='rep_links rep_link_overviewd' id='rep_link_overviewd_60_days' onclick='overview_details("","60")' >60 days</span>
                                                         <span class='rep_links rep_link_overviewd' id='rep_link_overviewd_365_days' onclick='overview_details("","365")' >365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                           
                                             
                                             </div>
                                                         
                                                         
                                                         
                                    
                                                    <div id='rep_overview_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_overview_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_overview' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                   
                                                    <span id='rep_pagation_main_overview'  >
                                                        
                                                    </span>
                                                    
                                                 </div>
                                                
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini' onclick='swap_charts("overview")'>show charts for :<span   id='rep_chart_overview' style='color:#ff6600;'>visitor trends</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_overview' class='ub_select_box_small100' onchange='overview_details("","")'>
                                                                  <option value='location'>stats by location</option>
                                                                 <option value='browser' selected='selected' >stats by browser</option>
                                                                  
                                                                 <option value='os' >stats by os</option>
                                                                 <option value='lang'>stats by language</option>
                                                                 <option value='screenres'>stats by screen resolution</option>
                                                                 <option value='date'>stats by date</option>
                                                                 <option value='url'>stats by refering url</option>
                                                                 <option value='refid'>stats by refering id</option>
                                                                 <option value='domain'>stats by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>stats by search engine</option>
                                                                 <option value='searchterm'>stats by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                       
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px; ' id='sparky_ut_overview_box'>
                                                 <center>
                                                    
                                                    <div class='graphholder_lp ub_corners'   id='overview_spark_ut'>
                                           <div id="over_regs"></div>
                                                       
                                                      </div>
                                                         
                                            
                                            </center>
                                                 <br/>
                                                 registration trends for the last <span  id='sparky_user_overview_days'></span> days
                                             </div>
                                             
                                            <div style='text-align:center; padding:40px 0px 15px 0px;display:none;' id='sparky_vs_overview_box'>
                                                 <center>
                                                    <div class='graphholder_lp ub_corners' id='overview_spark_vs'>
                                                      <div id="over_vs"></div>
                                                      </div>
                                                      
                                                 
                                            </center>
                                                 <br/>
                                                 visitor trends for the last <span  id='sparky_vs_lp_days'></span> days
                                             </div>
                                           
                                            
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                                 
                                                         
                                                         
                                                         
                                                         
                                    </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                        	<li id='slider_s_s_pageviews' style=''>
                               <div class='dash_slide_box less_top_space'>
                                 <div class='roar_reports ub_corners3' style='width:881px; min-height:30px; margin-bottom:7px; padding:12px 0px 10px 0px; ' >
                                        <div class='fll' style='padding:0px 0px 0px 10px;'>
                                            order by:
                                            <span class='rep_links_buttons ub_corners3 rep_link_pv_order' id='rep_link_pv_landingpage' onclick='load_pv_stats("","0,30",0," landingpage ")'>url name</span>
                                            <span class='rep_links_buttons ub_corners3 rep_link_pv_order' id='rep_link_pv_pageview' onclick='load_pv_stats("","0,30",0," pageview ")'>page views</span>
                                            
                                            <div class='br7' style='height:13px;'></div>
                                            <select id='pv_pagation' onchange="load_pv_stats('','',1);">
                                        <option value='0'>page 1</option>
                                      </select>
                                        </div>
                                        <div class='floatright txtr' style='padding:0px 10px 0px 0px;'>
                                                 
                                             
                                      
                                                         
                                                         <span class='rep_links '  style='font-size:12px;'>show stats for the last:</span>
                                                         <span class='rep_links_buttons ub_corners3  rep_link_pv' id='rep_link_pv_1_days' onclick="load_pv_stats(' 1 ','',0);" >24 hours</span>
                                                         <span class='rep_links_buttons ub_corners3  rep_link_pv' id='rep_link_pv_30_days' onclick="load_pv_stats(' 30 ','',0);" >30 days</span>
                                                         <span class='rep_links_buttons ub_corners3  rep_link_pv' id='rep_link_pv_60_days' onclick="load_pv_stats(' 60 ','',0);">60 days</span>
                                                         <span class='rep_links_buttons ub_corners3  rep_link_pv' id='rep_link_pv_365_days' onclick="load_pv_stats(' 365 ','',0);">365 days</span>
                                                                                                                   
                                                   <div class='br7'></div>
                                                   <div class='fll' style='padding:7px 7px 0px 0px;'>
                                                        search for a url:
                                                        </div>
                                                        <div class='ub_corners ub_text_box_wraps_small fll'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_stats_search_pv' class='ub_text_box_small'/>
                                                                </div>
                                                              
                                                                
                                                           
                                                           
                                                        </div>
                                                        <div class='fll' style='padding:4px 0px 0px 0px; margin-left:5px;'>
                                                            
                                                        <button class='ub_buttons_x ' onclick="load_pv_stats('','','0,30',0);">search</button>
                                                        </div>
                                                    <div class='clb'></div>
                                             
                                                 
                                                
                                        </div>
                                    
                                      <div class='clb'></div>
                                    </div>
                                      
                                      <div class='floatlefts' id='pv_results' >
                                       searching...
                                      
                                      </div>
                                </div><!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                        
                            	<li id='slider_s_s_refurl' style=''>
                               <div class='dash_slide_box less_top_space'>
                                 <div class='roar_reports ub_corners3' style='width:881px; min-height:30px; margin-bottom:7px; padding:12px 0px 10px 0px; ' >
                                        <div class='fll' style='padding:0px 0px 0px 10px;'>
                                            order by:
                                            <span class='rep_links_buttons ub_corners3 rep_link_ref_order' id='rep_link_ref_landingpage' onclick='load_ref_stats("","0,30",0," landingpage ")'>url name</span>
                                            <span class='rep_links_buttons ub_corners3 rep_link_ref_order' id='rep_link_ref_pageview' onclick='load_ref_stats("","0,30",0," pageview ")'>page views</span>
                                            
                                            <div class='br7' style='height:13px;'></div>
                                            <select id='ref_pagation' onchange="load_ref_stats('','',1);">
                                        <option value='0'>page 1</option>
                                      </select>
                                        </div>
                                        <div class='floatright txtr' style='padding:0px 10px 0px 0px;'>
                                                 
                                             
                                      
                                                         
                                                         <span class='rep_links '  style='font-size:12px;'>show stats for the last:</span>
                                                         <span class='rep_links_buttons ub_corners3  rep_link_ref' id='rep_link_ref_1_days' onclick="load_ref_stats(' 1 ','',0);" >24 hours</span>
                                                         <span class='rep_links_buttons ub_corners3  rep_link_ref' id='rep_link_ref_30_days' onclick="load_ref_stats(' 30 ','',0);" >30 days</span>
                                                         <span class='rep_links_buttons ub_corners3  rep_link_ref' id='rep_link_ref_60_days' onclick="load_ref_stats(' 60 ','',0);">60 days</span>
                                                         <span class='rep_links_buttons ub_corners3  rep_link_ref' id='rep_link_ref_365_days' onclick="load_ref_stats(' 365 ','',0);">365 days</span>
                                                                                                                   
                                                   <div class='br7'></div>
                                                   <div class='fll' style='padding:7px 7px 0px 0px;'>
                                                        search for a url:
                                                        </div>
                                                        <div class='ub_corners ub_text_box_wraps_small fll'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_stats_search_ref' class='ub_text_box_small'/>
                                                                </div>
                                                              
                                                                
                                                           
                                                           
                                                        </div>
                                                        <div class='fll' style='padding:4px 0px 0px 0px; margin-left:5px;'>
                                                            
                                                        <button class='ub_buttons_x ' onclick="load_ref_stats('','','0,30',0);">search</button>
                                                        </div>
                                                    <div class='clb'></div>
                                             
                                                 
                                                
                                        </div>
                                    
                                      <div class='clb'></div>
                                    </div>
                                      
                                      <div class='floatlefts' id='ref_results' >
                                       searching...
                                      
                                      </div>
                                </div><!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                        
                            	
                                
                                
                                <li id='slider_s_s_landingpages' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                         <div class='roar_reports ub_corners3' style='width:881px; min-height:30px; margin-bottom:7px; padding:12px 0px 10px 0px; ' >
                                        <div class='fll'  style='padding:0px 0px 0px 10px;'>
                                            order by:
                                            <span class='rep_links_buttons ub_corners3 rep_link_lp_order' id='rep_link_landingpage' onclick='load_lp_stats(" landingpage ","","0,30")'>page name</span>
                                            <span class='rep_links_buttons ub_corners3 rep_link_lp_order' id='rep_link_conversion' onclick='load_lp_stats(" conversion ","","0,30")'>conversion</span>
                                            <span class='rep_links_buttons ub_corners3 rep_link_lp_order' id='rep_link_visitors' onclick='load_lp_stats(" visitors ","","0,30")'>visitor count</span>
                                            <span class='rep_links_buttons ub_corners3 rep_link_lp_order' id='rep_link_users' onclick='load_lp_stats(" users ","","0,30")'>user count</span>
                                            <div class='br7' style='height:13px;'></div>
                                            <select id='lp_pagation' onchange='load_lp_stats("","","",1);'>
                                                <option value='0'>page 1</option>
                                            </select>
                                        </div>
                                        <div class='floatright txtr' style='padding:0px 10px 0px 0px;'>
                                                 
                                             
                                      
                                                         
                                                         <span class='rep_links' style='font-size:12px;' >show stats for the last:</span>
                                                         <span class='rep_links_buttons ub_corners3 rep_link_lp' id='rep_link_lp_1_days' onclick='load_lp_stats("","1","0,30");' >24 hours</span>
                                                         <span class='rep_links_buttons ub_corners3 rep_link_lp' id='rep_link_lp_30_days' onclick='load_lp_stats("","30","0,30");' >30 days</span>
                                                         <span class='rep_links_buttons ub_corners3 rep_link_lp' id='rep_link_lp_60_days' onclick='load_lp_stats("","60","0,30");'>60 days</span>
                                                         <span class='rep_links_buttons ub_corners3 rep_link_lp' id='rep_link_lp_365_days' onclick='load_lp_stats("","365","0,30");'>365 days</span>
                                                         
                                                   <div class='br7'></div>
                                                   <div class='fll' style='padding:7px 7px 0px 0px;'>
                                                        search for a landing page:
                                                        </div>
                                                        <div class='ub_corners ub_text_box_wraps_small fll'>
                                                            <div class='floatlefts ub_input_release' >
                                                                <input type='text' id='ub_stats_search_lp' class='ub_text_box_small'/>
                                                                </div>
                                                              
                                                                
                                                           
                                                           
                                                           </div>
                                                        <div class='fll' style='padding:4px 0px 0px 0px; margin-left:5px;'>
                                                        <button class='ub_buttons_x ' onclick="load_lp_stats('','','0,30',0);">search</button>
                                                        </div>
                                                    <div class='clb'></div>
                                             
                                                 
                                                
                                        </div>
                                      <div class='clb'></div>
                                      </div>
                                      
                                      <div class='floatlefts' id='lp_results' >
                                       searching...
                                      
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                        
                        
                              <li id='slider_s_s_landingpages_det' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports ub_corners3' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div id='lp_details_url' class='floatlefts' style='font-size:14px; color:#34A5C1; padding:7px 0px 5px 10px'>
                                                 
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_lpd' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_lpd' id='rep_link_lpd_1_days' onclick='lp_details("","1")' >24 hours</span>
                                                         <span class='rep_links rep_link_lpd' id='rep_link_lpd_30_days' onclick='lp_details("","30")' >30 days</span>
                                                         <span class='rep_links rep_link_lpd' id='rep_link_lpd_60_days' onclick='lp_details("","60")' >60 days</span>
                                                         <span class='rep_links rep_link_lpd' id='rep_link_lpd_365_days' onclick='lp_details("","365")' >365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                           
                                             
                                             </div>
                                           <div class='ub_dash_reports ub_corners' style='margin:0px 0px 7px 0px'>
                                                
    <div style="padding: 0px 0px 0px 7px;">
      
             <div id="rep_loader_gif" class="hiddenText"><img src="images/loader/bl_w.gif"></div> 
        
        <div class="" id="rep_quick_stats">
           
            
            
            <div class="txtc rep_top_stats">
                
                 
                <div class="floatlefts rep_top_stats_boxes">
                    <div class="rep_top_stats_small">
                        overall traffic
                    </div>
                    <div class="rep_top_stats_big">
                        <b id="rep_visit_lp"></b> 
                    </div>
                    <div class="rep_top_stats_tiny">
                        total visits in 30 days
                    </div>
                </div> 
                <div class="floatlefts rep_top_stats_boxes">
                    <div class="rep_top_stats_small">
                        registered users
                    </div>
                    <div class="rep_top_stats_big">
                        <b id="rep_reg_lp"></b> (<span id="rep_reg_30day_lp" class="rep_colours_plus"></span>)
                    </div>
                    <div class="rep_top_stats_tiny">
                        brackets: 30 day trend
                    </div>
                </div>
                <div class="floatlefts rep_top_stats_boxes">
                    <div class="rep_top_stats_small">
                        registrations in
                    </div>
                    <div class="rep_top_stats_big">
                        <b><span id="rep_30day_reg_lp"></span> </b> 
                    </div>
                    <div class="rep_top_stats_tiny">
                       the last 30 days
                    </div>
                </div>
                <div class="floatlefts rep_top_stats_boxes">
                    <div class="rep_top_stats_small">
                        active in 
                    </div>
                    <div class="rep_top_stats_big">
                        <b id="rep_active_lp"></b>
                    </div>
                    <div class="rep_top_stats_tiny">
                        the last 30 days
                    </div>
                </div>
                
                <div class="floatlefts rep_top_stats_boxes_last">
                    <div class="rep_top_stats_small">
                        overall conversion 
                    </div>
                    <div class="rep_top_stats_big">
                        <b id="rep_con_all_lp"></b>% (<span id="rep_con_30_lp"></span>%)
                    </div>
                    <div class="rep_top_stats_tiny">
                         brackets: in 30 days
                    </div>
                </div>
               <div class="clearboth"></div>
                 
                
            </div>
                  <div class="clearboth"></div>
        </div>
    </div>
                                      
 
                                            </div>
        
                                            <div id='rep_lp_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_lp_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_lp' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_lp'>
                                                     
                                                 </div>
                                                 </div>
                                            
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini' onclick='swap_charts("lp")'>show charts for :<span   id='rep_chart_lp' style='color:#ff6600;'>visitor trends</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_lp' class='ub_select_box_small100' onchange='lp_details("","")'>
                                                                  <option value='location'>stats by location</option>
                                                                 <option value='browser'  >stats by browser</option>
                                                                  
                                                                 <option value='os' selected='selected'>stats by os</option>
                                                                 <option value='lang'>stats by language</option>
                                                                 <option value='screenres'>stats by screen resolution</option>
                                                                 <option value='date'>stats by date</option>
                                                                 <option value='url'>stats by refering url</option>
                                                                 <option value='refid'>stats by refering id</option>
                                                                 <option value='domain'>stats by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>stats by search engine</option>
                                                                 <option value='searchterm'>stats by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                       
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px; ' id='sparky_ut_lp_box'>
                                                 <center>
                                                     <div class='graphholder_lp ub_corners'  id='lp_spark_ut'>
                                                    <div id="lp_regs"></div>
                                                      </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration trends for the last <span  id='sparky_user_lp_days'></span> days
                                             </div>
                                             
                                            <div style='text-align:center; padding:40px 0px 15px 0px;display:none;' id='sparky_vs_lp_box'>
                                                 <center>
                                                     <div class='graphholder_lp ub_corners' id='lp_spark_vs'>
                                                      <div id="lp_vs"></div>
                                                      </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 visitor trends for the last <span  id='sparky_vs_lp_days'></span> days
                                             </div>
                                           
                                            
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                        
                        
                        
                        </ul>
                    </div>
                    
                    
                    
                    
                   
                   
                
               <div>
                    </div>
                    
                    
                    
                 </div>
                 
                 
              
                       
               </div>
               
      
        </div>
        
        
      
                                                        <div id='dashmain_ov' class='ub_corners dashmain'></div>
        
        
                                                </li>
                                                
                                                <li id='unibody_detailed_ss'>
                                                    <div id='dashmain_float_det' class='ub_corners dashmain_float' style='padding:25px 10px 10px 13px;'>
                <div class='ub_dash_reports ub_corners' style='margin:10px 12px 0px 4px;' >
    <div style='padding:0px 0px 0px 7px;'>
      
             <div id='rep_loader_gif' class='hiddenText'><img src='images/loader/bl_w.gif'/></div> 
        
        <div class='' id='rep_quick_stats'>
            <div class='floatlefts' style='height:100%;vertical-align:middle; margin-right:25px; padding:10px 25px 0px 15px;'>
                 <div class='rep_domainname' id='rep_domain' >userbase site stats</div>
                 <div id='detailed_stats_loader' class='hide'>
                    <div class='fll'>
                    <img src='images/loader/lg_bb.gif'/>
                    </div>
                    <div class='fll' style='padding:2px 0px 0px 5px;'>
                    loading...
                    </div>
                    <div class='clb'></div>
                </div>
            </div>
           
            
            
            <div class='flr rep_top_stats'  >
                
                 
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        overall traffic
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_visit_dt'></b> 
                    </div>
                    <div class='rep_top_stats_tiny'>
                        total visits in 30 days
                    </div>
                </div> 
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        registered users
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_reg_dt'></b> (<span id='rep_reg_30day_dt' class=''></span>)
                    </div>
                    <div class='rep_top_stats_tiny'>
                        brackets: 30 day trend
                    </div>
                </div>
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        registrations in
                    </div>
                    <div class='rep_top_stats_big'>
                        <b ><span id='rep_30day_reg_dt'></span> </b> 
                    </div>
                    <div class='rep_top_stats_tiny'>
                       the last 30 days
                    </div>
                </div>
                <div  class='floatlefts rep_top_stats_boxes' >
                    <div class='rep_top_stats_small'>
                        active in 
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_active_dt'></b>
                    </div>
                    <div class='rep_top_stats_tiny'>
                        the last 30 days
                    </div>
                </div>
                
                <div  class='floatlefts rep_top_stats_boxes_last' >
                    <div class='rep_top_stats_small'>
                        overall conversion 
                    </div>
                    <div class='rep_top_stats_big'>
                        <b id='rep_con_all_dt'></b>% (<span id='rep_con_30_dt'></span>%)
                    </div>
                    <div class='rep_top_stats_tiny'>
                         brackets: in 30 days
                    </div>
                </div>
               <div class='clearboth'></div>
                 
                
            </div>
                  <div class='clearboth'></div>
        </div>
    </div>
                                      
 </div>
<div >
    
    
    
       
<div >
    <div class='rep_report_links '>
        <span class='rep_links rep_main_links' id='rep_link_os' onclick='load_slider_card("os",1)' style='text-decoration:underline;  font-weight:bold; '>operating system</span>
        <span class='rep_links rep_main_links' id='rep_link_location' onclick='load_slider_card("location",2)'>location</span>
        <span class='rep_links rep_main_links' id='rep_link_browser' onclick='load_slider_card("browser",3)'>browser</span>
        <span class='rep_links rep_main_links' id='rep_link_url' onclick='load_slider_card("url",4)'>refering url</span>
        <span class='rep_links rep_main_links' id='rep_link_lang' onclick='load_slider_card("lang",5)'>language</span>
        <span class='rep_links rep_main_links' id='rep_link_date' onclick='load_slider_card("date",6)'>date</span>
        <span class='rep_links rep_main_links' id='rep_link_domain' onclick='load_slider_card("domain",7)'>refering domain</span>
         <span class='rep_links rep_main_links' id='rep_link_screenres' onclick='load_slider_card("screenres",9)'>screen resolution</span>
          <span class='rep_links rep_main_links' id='rep_link_refid' onclick='load_slider_card("refid",8)'>refering id</span>
           <span class='rep_links rep_main_links' id='rep_link_searchengine' onclick='load_slider_card("searchengine",10)'>search engine</span>
            <span class='rep_links rep_main_links' id='rep_link_searchterm' onclick='load_slider_card("searchterm",11)'>keywords</span>
    </div>
</div>

                                   
                            <!--start-->                              
                                   <div  class="section_rep" style='' >
		
                    <div id="pane-options-stats" class="pane_rep" style=' '>
			<ul class="elements_rep" style="width:11000px;  ' " id='one'>
				<li id='slider_os' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Operating System Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_os' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_os' id='rep_link_os_1_days' onclick="rr_stats_collection('os', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_os' id='rep_link_os_30_days' onclick="rr_stats_collection('os', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_os' id='rep_link_os_60_days' onclick="rr_stats_collection('os', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_os' id='rep_link_os_365_days' onclick="rr_stats_collection('os', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                 select one of the operating systems below to drill down into the data. This will let you unlock a greater depth of information about the traffic from your site, the 
         quality of traffic and who you should cater for in terms of your most productive audience.
                                             </div>
                                             
                                             </div>
                                            <div id='rep_os_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_os_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_os' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_os'>
                                                     
                                                 </div>
                                                 </div>
                                          
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts' >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_os' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_os' class='ub_select_box_small100' onchange='rr_narrow_by("os")'>
                                                                  <option value='location'>narrow by location</option>
                                                                 <option value='browser' selected='selected'>narrow by browser</option>
                                                                 
                                                                 <option value='lang'>narrow by language</option>
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                                 <option value='date'>narrow by date</option>
                                                                 <option value='url'>narrow by refering url</option>
                                                                 <option value='refid'>narrow by refering id</option>
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                         <!--
                                                         <span class='rep_links rep_links_os_mini' id='rep_link_os_narrowby_location_mini' onclick="rr_stats_collection('location', 'os', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_os_mini' id='rep_link_os_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'os', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_os_mini' id='rep_link_os_narrowby_url_mini' onclick="rr_stats_collection('url', 'os', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_os_mini' id='rep_link_os_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'os', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_os_mini' id='rep_link_os_narrowby_date_mini' onclick="rr_stats_collection('date', 'os', '',1,'');">date</span>
                                                         <span class='rep_links hiddenText rep_links_os_mini' id='rep_link_os_narrowby_os_mini' onclick="rr_stats_collection('os', 'os', '',1,'');">operating system</span>
                                                         <span class='rep_links rep_links_os_mini' id='rep_link_os_narrowby_domain_mini' onclick="rr_stats_collection('domain', 'os', '',1,'');">domain</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                      <img id='rep_sparkline_chart_img_os' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                     <!-- <img id='rep_sparkline_chart_img_user_os' src='images/loader/blank.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_os' src='images/loader/bl_w.gif' class='hide'/> -->
                                                      
                                                      <div id='rep_sparkline_chart_img_user_os' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_os' class='hide'></div>
                                                      </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_os_name'></span> for the last <span  id='rep_sparkline_os_days'></span> - <span id='vs_ut_swap_os' onclick='vs_ut_chart("os");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_os_results'>
                                            
                                            
                                             </div>
                                                <div class='pagation_bar_mini ub_corners3'>
                                                   <div id='rep_pagation_mini_os'>
                                                           
                                                   </div>
                                                </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                        	<li id='slider_location' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Geo-location Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_location' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_location' id='rep_link_location_1_days' onclick="rr_stats_collection('location', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_location' id='rep_link_location_30_days' onclick="rr_stats_collection('location', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_location' id='rep_link_location_60_days' onclick="rr_stats_collection('location', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_location' id='rep_link_location_365_days' onclick="rr_stats_collection('location', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                 select one of the locations below to drill down into the data. This will let you unlock a greater depth of information about the traffic from your site, the 
         quality of traffic and who you should cater for in terms of your best and most productive audience.
                                             </div>
                                             
                                             </div>
                                            <div id='rep_location_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_location_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_location' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_location'>
                                                     
                                                 </div>
                                                 </div>
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                          <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_location' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_location' class='ub_select_box_small100' onchange='rr_narrow_by("location")'>
                                                                  
                                                                 <option value='browser' selected='selected'>narrow by browser</option>
                                                                  
                                                                 <option value='os'>narrow by os</option>
                                                                 <option value='lang'>narrow by language</option>
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                                 <option value='date'>narrow by date</option>
                                                                 <option value='url'>narrow by refering url</option>
                                                                 <option value='refid'>narrow by refering id</option>
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                         <!--<span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links hiddenText rep_links_location_mini' id='rep_link_location_narrowby_location_mini' onclick="rr_stats_collection('location', 'location', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_location_mini' id='rep_link_location_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'location', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_location_mini' id='rep_link_location_narrowby_url_mini' onclick="rr_stats_collection('url', 'location', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_location_mini' id='rep_link_location_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'location', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_location_mini' id='rep_link_location_narrowby_date_mini' onclick="rr_stats_collection('date', 'location', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_location_mini' id='rep_link_location_narrowby_os_mini' onclick="rr_stats_collection('os', 'location', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                   
                                                    
                                                        <img id='rep_sparkline_chart_img_location' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                       <!-- <img id='rep_sparkline_chart_img_user_location' src='images/loader/bl_w.gif' class='hide'/>
                                                        <img id='rep_sparkline_chart_img_vs_location' src='images/loader/bl_w.gif' class='hide'/>-->
                                                        
                                                        <div id='rep_sparkline_chart_img_user_location' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_location' class='hide'></div>
                                                        
                                                      </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_location_name'></span> for the last <span  id='rep_sparkline_location_days'></span> - <span id='vs_ut_swap_location' onclick='vs_ut_chart("location");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_location_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_location'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                        
                            	<li id='slider_browser' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Browser Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_browser' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_browser' id='rep_link_browser_1_days' onclick="rr_stats_collection('browser', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_browser' id='rep_link_browser_30_days' onclick="rr_stats_collection('browser', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_browser' id='rep_link_browser_60_days' onclick="rr_stats_collection('browser', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_browser' id='rep_link_browser_365_days' onclick="rr_stats_collection('browser', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                 select one of the browsers below to drill down into the data. This will let you unlock a greater depth of information about the traffic from your site, the 
         quality of traffic and who you should cater for in terms of your best and most productive audience.
                                             </div>
                                             
                                             </div>
                                            <div id='rep_browser_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_browser_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_browser' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_browser'>
                                                     
                                                 </div>
                                                 </div>
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_browser' style='color:#ff6600;'>operating system</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_browser' class='ub_select_box_small100' onchange='rr_narrow_by("browser")'>
                                                                  <option value='location' >narrow by location</option>
                                                                 
                                                                  
                                                                 <option value='os' selected='selected'>narrow by os</option>
                                                                 <option value='lang'>narrow by language</option>
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                                 <option value='date'>narrow by date</option>
                                                                 <option value='url'>narrow by refering url</option>
                                                                 <option value='refid'>narrow by refering id</option>
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                         <!--
                                                         <span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links rep_links_browser_mini' id='rep_link_browser_narrowby_location_mini' onclick="rr_stats_collection('location', 'browser', '',1,'');">location</span>
                                                         <span class='rep_links hiddenText rep_links_browser_mini' id='rep_link_browser_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'browser', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_browser_mini' id='rep_link_browser_narrowby_url_mini' onclick="rr_stats_collection('url', 'browser', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_browser_mini' id='rep_link_browser_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'browser', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_browser_mini' id='rep_link_browser_narrowby_date_mini' onclick="rr_stats_collection('date', 'browser', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_browser_mini' id='rep_link_browser_narrowby_os_mini' onclick="rr_stats_collection('os', 'browser', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                      
                                                      <img id='rep_sparkline_chart_img_browser' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                      <!--<img id='rep_sparkline_chart_img_user_browser' src='images/loader/bl_w.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_browser' src='images/loader/bl_w.gif' class='hide'/>
                                                      -->
                                                      
                                                      <div id='rep_sparkline_chart_img_user_browser' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_browser' class='hide'></div>
                                                      
                                                      </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_browser_name'></span> for the last <span  id='rep_sparkline_browser_days'></span> - <span id='vs_ut_swap_browser' onclick='vs_ut_chart("browser");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_browser_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_browser'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                         	<li id='slider_url' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Refering URL Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_url' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_url' id='rep_link_url_1_days' onclick="rr_stats_collection('url', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_url' id='rep_link_url_30_days' onclick="rr_stats_collection('url', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_url' id='rep_link_url_60_days' onclick="rr_stats_collection('url', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_url' id='rep_link_url_365_days' onclick="rr_stats_collection('url', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                     <div class='fll' style='padding:7px 7px 0px 0px;'>
                                                        search for a particular url:
                                                        </div>
                                                        <div class='ub_corners ub_text_box_wraps_small fll'>
                                                            <div class='floatlefts ub_rr_return_search' >
                                                                <input type='text' id='ub_stats_search_url' class='ub_text_box_small'/>
                                                                </div>
                                                              
                                                                
                                                           
                                                           
                                                           </div>
                                                        <div class='fll' style='padding:4px 0px 0px 7px;'>
                                                        <button class='ub_buttons_x' onclick="rr_stats_collection('url', 0, '',0);  ;">search</button>
                                                        </div>
                                                    <div class='clb'></div>
                                             
                                             </div>
                                             
                                             </div>
                                            <div id='rep_url_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_url_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_url' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_url'>
                                                     
                                                 </div>
                                                </div>
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                        
                                                        <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_url' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_url' class='ub_select_box_small100' onchange='rr_narrow_by("url")'>
                                                                    <option value='location' >narrow by location</option>
                                                                 <option value='browser' selected='selected'>narrow by browser</option>
                                                                
                                                                 <option value='os'>narrow by os</option>
                                                                 <option value='lang'>narrow by language</option>
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                                 <option value='date'>narrow by date</option>
                                                              
                                                                 <option value='refid'>narrow by refering id</option>
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                        
                                                         <!--
                                                         <span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links rep_links_url_mini' id='rep_link_url_narrowby_location_mini' onclick="rr_stats_collection('location', 'url', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_url_mini' id='rep_link_url_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'url', '',1,'');">browser</span>
                                                         <span class='rep_links hiddenText rep_links_url_mini' id='rep_link_url_narrowby_url_mini' onclick="rr_stats_collection('url', 'url', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_url_mini' id='rep_link_url_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'url', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_url_mini' id='rep_link_url_narrowby_date_mini' onclick="rr_stats_collection('date', 'url', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_url_mini' id='rep_link_url_narrowby_os_mini' onclick="rr_stats_collection('os', 'url', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                    
                                                      <img id='rep_sparkline_chart_img_url' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                      <!--<img id='rep_sparkline_chart_img_user_url' src='images/loader/bl_w.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_url' src='images/loader/bl_w.gif' class='hide'/>-->
                                                     <div id='rep_sparkline_chart_img_user_url' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_url' class='hide'></div> 
                                                     
                                                     </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_url_name'></span> for the last <span  id='rep_sparkline_url_days'></span> - <span id='vs_ut_swap_url' onclick='vs_ut_chart("url");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_url_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_url'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                     
                        
                          	<li id='slider_lang' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Language Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_lang' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_lang' id='rep_link_lang_1_days' onclick="rr_stats_collection('lang', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_lang' id='rep_link_lang_30_days' onclick="rr_stats_collection('lang', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_lang' id='rep_link_lang_60_days' onclick="rr_stats_collection('lang', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_lang' id='rep_link_lang_365_days' onclick="rr_stats_collection('lang', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                 select one of the languages below to drill down into the data. This will let you unlock a greater depth of information about the traffic from your site, the 
         quality of traffic and who you should cater for in terms of your best and most productive audience.
                                             </div>
                                             
                                             </div>
                                            <div id='rep_lang_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_lang_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_lang' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_lang'>
                                                     
                                                 </div>
                                                 </div>
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                        
                                                        <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_lang' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_lang' class='ub_select_box_small100' onchange='rr_narrow_by("lang")'>
                                                                    <option value='location' >narrow by location</option>
                                                                 <option value='browser' selected='selected'>narrow by browser</option>
                                                                
                                                                 <option value='os'>narrow by os</option>
                                                         
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                                 <option value='date'>narrow by date</option>
                                                                 <option value='url' >narrow by refering url</option>
                                                                 <option value='refid'>narrow by refering id</option>
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                        
                                                         <!--
                                                         <span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links rep_links_lang_mini' id='rep_link_lang_narrowby_location_mini' onclick="rr_stats_collection('location', 'lang', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_lang_mini' id='rep_link_lang_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'lang', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_lang_mini' id='rep_link_lang_narrowby_url_mini' onclick="rr_stats_collection('url', 'lang', '',1,'');">refering url</span>
                                                         <span class='rep_links hiddenText rep_links_lang_mini' id='rep_link_lang_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'lang', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_lang_mini' id='rep_link_lang_narrowby_date_mini' onclick="rr_stats_collection('date', 'lang', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_lang_mini' id='rep_link_lang_narrowby_os_mini' onclick="rr_stats_collection('os', 'lang', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                               
                                                      <img id='rep_sparkline_chart_img_lang' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                    <!--  <img id='rep_sparkline_chart_img_user_lang' src='images/loader/blank.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_lang' src='images/loader/bl_w.gif' class='hide'/> -->
                                                     
                                                     
                                                     <div id='rep_sparkline_chart_img_user_lang' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_lang' class='hide'></div> 
                                                     
                                                     </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_lang_name'></span> for the last <span  id='rep_sparkline_lang_days'></span> - <span id='vs_ut_swap_lang' onclick='vs_ut_chart("lang");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_lang_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_lang'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                        </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                     
                        
                       
                        
                           	<li id='slider_date' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Registration Date Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_date' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_date' id='rep_link_date_1_days' onclick="rr_stats_collection('date', 0, '',0,'',1);" >24 days</span>
                                                         <span class='rep_links rep_link_date' id='rep_link_date_30_days' onclick="rr_stats_collection('date', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_date' id='rep_link_date_60_days' onclick="rr_stats_collection('date', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_date' id='rep_link_date_365_days' onclick="rr_stats_collection('date', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                 <div class='fll' style='padding:7px 7px 0px 0px;'>
                                                        search for a particular date:
                                                        </div>
                                                        <div class='ub_corners ub_text_box_wraps_small fll'>
                                                            <div class='fll ub_rr_return_search' >
                                                                <input type='text' id='ub_stats_search_date' class='ub_text_box_small'/>
                                                                </div>
                                                              
                                                                
                                                           
                                                           
                                                           </div>
                                                        <div class='fll' style='padding:4px 0px 0px 7px;'>
                                                        <button class='ub_buttons_x ' onclick="rr_stats_collection('date', 0, '',0);  ;">search</button>
                                                        </div>
                                                    <div class='clb'></div>
                                             </div>
                                             
                                             </div>
                                            <div id='rep_date_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_date_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_date' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_date'>
                                                     
                                                 </div>
                                                 </div>
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                        <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_date' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_date' class='ub_select_box_small100' onchange='rr_narrow_by("date")'>
                                                                    <option value='location' >narrow by location</option>
                                                                 <option value='browser' selected='selected'>narrow by browser</option>
                                                                
                                                                 <option value='os'>narrow by os</option>
                                                                 <option value='lang'>narrow by language</option>
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                            
                                                                 <option value='url' >narrow by refering url</option>
                                                                 <option value='refid'>narrow by refering id</option>
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                         <!--
                                                         <span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links rep_links_date_mini' id='rep_link_date_narrowby_location_mini' onclick="rr_stats_collection('location', 'date', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_date_mini' id='rep_link_date_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'date', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_date_mini' id='rep_link_date_narrowby_url_mini' onclick="rr_stats_collection('url', 'date', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_date_mini' id='rep_link_date_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'date', '',1,'');">language</span>
                                                         <span class='rep_links hiddenText rep_links_date_mini' id='rep_link_date_narrowby_date_mini' onclick="rr_stats_collection('date', 'date', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_date_mini' id='rep_link_date_narrowby_os_mini' onclick="rr_stats_collection('os', 'date', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                      <img id='rep_sparkline_chart_img_date' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                     <!-- <img id='rep_sparkline_chart_img_user_date' src='images/loader/blank.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_date' src='images/loader/bl_w.gif' class='hide'/>-->
                                                     <div id='rep_sparkline_chart_img_user_date' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_date' class='hide'></div> 
                                                     
                                                     </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_date_name'></span> for the last <span  id='rep_sparkline_date_days'></span> - <span id='vs_ut_swap_date' onclick='vs_ut_chart("date");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_date_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_date'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                     
                        
                       
                        
                       
                                <li id='slider_domain' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Refering Domain Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_domain' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_domain' id='rep_link_domain_1_days' onclick="rr_stats_collection('domain', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_domain' id='rep_link_domain_30_days' onclick="rr_stats_collection('domain', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_domain' id='rep_link_domain_60_days' onclick="rr_stats_collection('domain', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_domain' id='rep_link_domain_365_days' onclick="rr_stats_collection('domain', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                 <div class='fll' style='padding:7px 7px 0px 0px;'>
                                                        search for a particular domain:
                                                        </div>
                                                        <div class='ub_corners ub_text_box_wraps_small fll'>
                                                            <div class='fll ub_rr_return_search' >
                                                                <input type='text' id='ub_stats_search_domain' class='ub_text_box_small'/>
                                                                </div>
                                                              
                                                                
                                                           
                                                           
                                                           </div>
                                                        <div class='fll' style='padding:4px 0px 0px 7px;'>
                                                        <button class='ub_buttons_x ' onclick="rr_stats_collection('domain', 0, '',0);  ;">search</button>
                                                        </div>
                                                    <div class='clb'></div>
                                             </div>
                                             
                                             </div>
                                            <div id='rep_domain_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_domain_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_domain' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_domain'>
                                                     
                                                 </div>
                                                </div>
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                        <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_domain' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_domain' class='ub_select_box_small100' onchange='rr_narrow_by("domain")'>
                                                                    <option value='location' >narrow by location</option>
                                                                 <option value='browser' selected='selected'>narrow by browser</option>
                                                                
                                                                 <option value='os'>narrow by os</option>
                                                                 <option value='lang'>narrow by language</option>
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                                 <option value='date'>narrow by date</option>
                                                                 <option value='url' >narrow by refering url</option>
                                                                 <option value='refid'>narrow by refering id</option>
                                                                
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                         <!--
                                                         <span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links rep_links_domain_mini' id='rep_link_domain_narrowby_location_mini' onclick="rr_stats_collection('location', 'domain', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_domain_mini' id='rep_link_domain_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'domain', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_domain_mini' id='rep_link_domain_narrowby_url_mini' onclick="rr_stats_collection('url', 'domain', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_domain_mini' id='rep_link_domain_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'domain', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_domain_mini' id='rep_link_domain_narrowby_date_mini' onclick="rr_stats_collection('date', 'domain', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_domain_mini' id='rep_link_domain_narrowby_os_mini' onclick="rr_stats_collection('os', 'domain', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                      <img id='rep_sparkline_chart_img_domain' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                      <!--<img id='rep_sparkline_chart_img_user_domain' src='images/loader/blank.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_domain' src='images/loader/bl_w.gif' class='hide'/>-->
                                                     <div id='rep_sparkline_chart_img_user_domain' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_domain' class='hide'></div> 
                                                     
                                                     </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_domain_name'></span> for the last <span  id='rep_sparkline_domain_days'></span> - <span id='vs_ut_swap_domain' onclick='vs_ut_chart("domain");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_domain_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_domain'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                     
                        
                       
                        
                       
                        
                        
                        
                        
                        <li id='slider_screenres' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Screen Resolution Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_screenres' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_screenres' id='rep_link_screenres_1_days' onclick="rr_stats_collection('screenres', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_screenres' id='rep_link_screenres_30_days' onclick="rr_stats_collection('screenres', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_screenres' id='rep_link_screenres_60_days' onclick="rr_stats_collection('screenres', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_screenres' id='rep_link_screenres_365_days' onclick="rr_stats_collection('screenres', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                 select one of the screen resolutions below to drill down into the data. This will let you unlock a greater depth of information about the traffic from your site, the 
         quality of traffic and who you should cater for in terms of your best and most productive audience.
                                             </div>
                                             
                                             </div>
                                            <div id='rep_screenres_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_screenres_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_screenres' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_screenres'>
                                                     
                                                 </div>
                                                 </div>
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                        <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_screenres' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_screenres' class='ub_select_box_small100' onchange='rr_narrow_by("screenres")'>
                                                                    <option value='location' >narrow by location</option>
                                                                 <option value='browser' selected='selected'>narrow by browser</option>
                                                                
                                                                 <option value='os'>narrow by os</option>
                                                                 <option value='lang'>narrow by language</option>
                                                            
                                                                 <option value='date'>narrow by date</option>
                                                                 <option value='url' >narrow by refering url</option>
                                                                 <option value='refid'>narrow by refering id</option>
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                         <!--
                                                         <span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links rep_links_screenres_mini' id='rep_link_screenres_narrowby_location_mini' onclick="rr_stats_collection('location', 'screenres', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_screenres_mini' id='rep_link_screenres_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'screenres', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_screenres_mini' id='rep_link_screenres_narrowby_url_mini' onclick="rr_stats_collection('url', 'screenres', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_screenres_mini' id='rep_link_screenres_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'screenres', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_screenres_mini' id='rep_link_screenres_narrowby_date_mini' onclick="rr_stats_collection('date', 'screenres', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_screenres_mini' id='rep_link_screenres_narrowby_os_mini' onclick="rr_stats_collection('os', 'screenres', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                      
                                                      <img id='rep_sparkline_chart_img_screenres' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                      <!--<img id='rep_sparkline_chart_img_user_screenres' src='images/loader/blank.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_screenres' src='images/loader/bl_w.gif' class='hide'/>-->
                                                     <div id='rep_sparkline_chart_img_user_screenres' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_screenres' class='hide'></div> 
                                                     
                                                     </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_screenres_name'></span> for the last <span  id='rep_sparkline_screenres_days'></span>  - <span id='vs_ut_swap_screenres' onclick='vs_ut_chart("screenres");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_screenres_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_screenres'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                     
                        
                       
                        
                       
                                <li id='slider_refid' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Refering ID Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_refid' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_refid' id='rep_link_refid_1_days' onclick="rr_stats_collection('refid', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_refid' id='rep_link_refid_30_days' onclick="rr_stats_collection('refid', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_refid' id='rep_link_refid_60_days' onclick="rr_stats_collection('refid', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_refid' id='rep_link_refid_365_days' onclick="rr_stats_collection('refid', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                  <div class='fll' style='padding:7px 7px 0px 0px;'>
                                                        search for a particular refering id:
                                                        </div>
                                                        <div class='ub_corners ub_text_box_wraps_small fll'>
                                                            <div class='fll ub_rr_return_search' >
                                                                <input type='text' id='ub_stats_search_refid' class='ub_text_box_small'/>
                                                                </div>
                                                              
                                                                
                                                           
                                                           
                                                           </div>
                                                        <div class='fll' style='padding:4px 0px 0px 7px;'>
                                                        <button class='ub_buttons_x ' onclick="rr_stats_collection('refid', 0, '',0);  ;">search</button>
                                                        </div>
                                                    <div class='clb'></div>
                                             </div>
                                             
                                             </div>
                                            <div id='rep_refid_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_refid_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_refid' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_refid'>
                                                     
                                                 </div>
                                                 </div>
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                        <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_refid' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_refid' class='ub_select_box_small100' onchange='rr_narrow_by("refid")'>
                                                                    <option value='location' >narrow by location</option>
                                                                 <option value='browser' selected='selected' selected='selected'>narrow by browser</option>
                                                                
                                                                 <option value='os'>narrow by os</option>
                                                                 <option value='lang'>narrow by language</option>
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                                 <option value='date'>narrow by date</option>
                                                                 <option value='url'>narrow by refering url</option>
                                                        
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                         <!--
                                                         <span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links rep_links_refid_mini' id='rep_link_refid_narrowby_location_mini' onclick="rr_stats_collection('location', 'refid', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_refid_mini' id='rep_link_refid_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'refid', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_refid_mini' id='rep_link_refid_narrowby_url_mini' onclick="rr_stats_collection('url', 'refid', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_refid_mini' id='rep_link_refid_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'refid', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_refid_mini' id='rep_link_refid_narrowby_date_mini' onclick="rr_stats_collection('date', 'refid', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_refid_mini' id='rep_link_refid_narrowby_os_mini' onclick="rr_stats_collection('os', 'refid', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                      <img id='rep_sparkline_chart_img_refid' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                     <!-- <img id='rep_sparkline_chart_img_user_refid' src='images/loader/blank.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_refid' src='images/loader/bl_w.gif' class='hide'/>-->
                                                     <div id='rep_sparkline_chart_img_user_refid' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_refid' class='hide'></div> 
                                                     
                                                     </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_refid_name'></span> for the last <span  id='rep_sparkline_refid_days'></span>  - <span id='vs_ut_swap_refid' onclick='vs_ut_chart("refid");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_refid_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_refid'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                     
                        
                       
                        
                       
                                <li id='slider_searchengine' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Search Engine Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_searchengine' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_searchengine' id='rep_link_searchengine_1_days' onclick="rr_stats_collection('searchengine', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_searchengine' id='rep_link_searchengine_30_days' onclick="rr_stats_collection('searchengine', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_searchengine' id='rep_link_searchengine_60_days' onclick="rr_stats_collection('searchengine', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_searchengine' id='rep_link_searchengine_365_days' onclick="rr_stats_collection('searchengine', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                 select one of the search engines below to drill down into the data. This will let you unlock a greater depth of information about the traffic from your site, the 
         quality of traffic and who you should cater for in terms of your best and most productive audience.
                                             </div>
                                             
                                             </div>
                                            <div id='rep_searchengine_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_searchengine_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_searchengine' class='rep_minibars_res'>
                                                     
                                                 </div>
                                                 <div class='pagation_bar ub_corners3'>
                                                 <div id='rep_pagation_main_searchengine'>
                                                     
                                                 </div>
                                                </div>
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                        <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_searchengine' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_searchengine' class='ub_select_box_small100' onchange='rr_narrow_by("searchengine")'>
                                                                    <option value='location' >narrow by location</option>
                                                                 <option value='browser' selected='selected'>narrow by browser</option>
                                                                
                                                                 <option value='os'>narrow by os</option>
                                                                 <option value='lang'>narrow by language</option>
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                                 <option value='date'>narrow by date</option>
                                                                 <option value='url' >narrow by refering url</option>
                                                                 <option value='refid'>narrow by refering id</option>
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                              
                                                                 <option value='searchterm'>narrow by search keywords</option>
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                         <!--
                                                         <span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links rep_links_searchengine_mini' id='rep_link_searchengine_narrowby_location_mini' onclick="rr_stats_collection('location', 'searchengine', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_searchengine_mini' id='rep_link_searchengine_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'searchengine', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_searchengine_mini' id='rep_link_searchengine_narrowby_url_mini' onclick="rr_stats_collection('url', 'searchengine', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_searchengine_mini' id='rep_link_searchengine_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'searchengine', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_searchengine_mini' id='rep_link_searchengine_narrowby_date_mini' onclick="rr_stats_collection('date', 'searchengine', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_searchengine_mini' id='rep_link_searchengine_narrowby_os_mini' onclick="rr_stats_collection('os', 'searchengine', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                      <img id='rep_sparkline_chart_img_searchengine' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                     <!-- <img id='rep_sparkline_chart_img_user_searchengine' src='images/loader/blank.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_searchengine' src='images/loader/bl_w.gif' class='hide'/> -->
                                                     
                                                     <div id='rep_sparkline_chart_img_user_searchengine' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_searchengine' class='hide'></div> 
                                                     
                                                     </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_searchengine_name'></span> for the last <span  id='rep_sparkline_searchengine_days'></span> - <span id='vs_ut_swap_searchengine' onclick='vs_ut_chart("searchengine");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_searchengine_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_searchengine'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                     
                        
                       
                        
                       
                                <li id='slider_searchterm' style=''>
                                    <div class='dash_slide_box less_top_space'>
                                        
                                      <div class='floatlefts' >
                                            <div class='roar_reports' style='width:881px; min-height:30px; margin-bottom:7px; ' >
                                          
                                             <div class='floatlefts' style='font-size:16px; padding:10px 0px 0px 10px'>
                                                 Search Keyword Report
                                             </div>
                                             <div class='floatright' style='padding:7px 10px 0px 0px; color:#018fb2'>
                                                 
                                                 <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                         
                                                         <span class='rep_links rep_link_searchterm' >show stats for the last:</span>
                                                         <span class='rep_links rep_link_searchterm' id='rep_link_searchterm_1_days' onclick="rr_stats_collection('searchterm', 0, '',0,'',1);" >24 hours</span>
                                                         <span class='rep_links rep_link_searchterm' id='rep_link_searchterm_30_days' onclick="rr_stats_collection('searchterm', 0, '',0,'',30);" >30 days</span>
                                                         <span class='rep_links rep_link_searchterm' id='rep_link_searchterm_60_days' onclick="rr_stats_collection('searchterm', 0, '',0,'',60);">60 days</span>
                                                         <span class='rep_links rep_link_searchterm' id='rep_link_searchterm_365_days' onclick="rr_stats_collection('searchterm', 0, '',0,'',365);">365 days</span>
                                                         
                                                     </div>
                                                 </div>
                                                 
                                                
                                             </div>
                                             <div class='clearboth' ></div>
                                             <div style='font-size:12px; padding:7px 0px 10px 10px; '>
                                                  <div class='fll' style='padding:7px 7px 0px 0px;'>
                                                        search for a particular keyword:
                                                        </div>
                                                        <div class='ub_corners ub_text_box_wraps_small fll'>
                                                            <div class='fll ub_rr_return_search' >
                                                                <input type='text' id='ub_stats_search_searchterm' class='ub_text_box_small'/>
                                                            </div>
                                                              
                                                                
                                                           
                                                           
                                                           </div>
                                                        <div class='fll' style='padding:4px 0px 0px 7px;'>
                                                        <button class='ub_buttons_x ' onclick="rr_stats_collection('searchterm', 0, '',0);  ">search</button>
                                                        </div>
                                                    <div class='clb'></div>
                                             </div>
                                             
                                             </div>
                                            <div id='rep_searchterm_errorbox' style='text-align:center'><br/><br/>loading report...</div>
                                            <div id='rep_searchterm_databox' class='hide'>
                                            <div class='floatlefts' >
                                                 <div id='rep_minibars_results_searchterm' class='rep_minibars_res'>
                                                     
                                                 </div>
                                              
                                                    <div class='pagation_bar ub_corners3'>
                                                        <div id='rep_pagation_main_searchterm'>
                                                            
                                                        </div>
                                                    </div>
                                                 
                                            </div>
                                            
                                           
                                           <div class='clearreports floatlefts'  >
                                        
                                             <div  style='padding:5px 10px 0px 0px; color:#018fb2;'>
                                                  <div >
                                                     <div class='rep_report_links' style='padding:0px;'>
                                                        <span class='rep_links fll' style='padding-left:5px;' id='rep_link_text_mini'>narrowed by:<span id='rep_narrow_searchterm' style='color:#ff6600;'>browser</span></span>
                                                         <div class='flr ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release' >
                                                                <select id='rr_narrow_by_sel_searchterm' class='ub_select_box_small100' onchange='rr_narrow_by("searchterm")'>
                                                                    <option value='location' >narrow by location</option>
                                                                 <option value='browser' selected='selected'>narrow by browser</option>
                                                                
                                                                 <option value='os'>narrow by os</option>
                                                                 <option value='lang'>narrow by language</option>
                                                                 <option value='screenres'>narrow by screen resolution</option>
                                                                 <option value='date'>narrow by date</option>
                                                                 <option value='url'>narrow by refering url</option>
                                                                 <option value='refid'>narrow by refering id</option>
                                                                 <option value='domain'>narrow by refering domain</option>
                                                                 
                                                                 
                                                                 <option value='searchengine'>narrow by search engine</option>
                                                                
                                                                </select>
                                                                </div>
                                                               
                                                           </div>
                                                         <div class='clb'></div>
                                                         <!--
                                                         <span class='rep_links' style='padding-left:5px;' id='rep_link_text_mini'>narrow results by:</span>
                                                         <span class='rep_links rep_links_searchterm_mini' id='rep_link_searchterm_narrowby_location_mini' onclick="rr_stats_collection('location', 'searchterm', '',1,'');">location</span>
                                                         <span class='rep_links rep_links_searchterm_mini' id='rep_link_searchterm_narrowby_browser_mini' onclick="rr_stats_collection('browser', 'searchterm', '',1,'');">browser</span>
                                                         <span class='rep_links rep_links_searchterm_mini' id='rep_link_searchterm_narrowby_url_mini' onclick="rr_stats_collection('url', 'searchterm', '',1,'');">refering url</span>
                                                         <span class='rep_links rep_links_searchterm_mini' id='rep_link_searchterm_narrowby_lang_mini' onclick="rr_stats_collection('lang', 'searchterm', '',1,'');">language</span>
                                                         <span class='rep_links rep_links_searchterm_mini' id='rep_link_searchterm_narrowby_date_mini' onclick="rr_stats_collection('date', 'searchterm', '',1,'');">date</span>
                                                         <span class='rep_links rep_links_searchterm_mini' id='rep_link_searchterm_narrowby_os_mini' onclick="rr_stats_collection('os', 'searchterm', '',1,'');">operating system</span>
                                                         -->
                                                     </div>
                                                 </div>
                                                 
                                                 
                                                 
                                             </div>
                                             
                                             <div style='text-align:center; padding:40px 0px 15px 0px;'>
                                                 <center>
                                                     <div class='graphholder ub_corners'>
                                                     <img id='rep_sparkline_chart_img_searchterm' src='images/loader/bl_w.gif' style='margin-top:30px;'/>
                                                      <!--<img id='rep_sparkline_chart_img_user_searchterm' src='images/loader/blank.gif' class='hide'/>
                                                      <img id='rep_sparkline_chart_img_vs_searchterm' src='images/loader/bl_w.gif' class='hide'/>-->
                                                     <div id='rep_sparkline_chart_img_user_searchterm' class='hide'></div>
                                                      <div id='rep_sparkline_chart_img_vs_searchterm' class='hide'></div> 
                                                     
                                                     </div>
                                                     
                                                 
                                            </center>
                                                 <br/>
                                                 registration for <span id='rep_sparkline_searchterm_name'></span> for the last <span  id='rep_sparkline_searchterm_days'></span> - <span id='vs_ut_swap_searchterm' onclick='vs_ut_chart("searchterm");' style='cursor:pointer'>show visitors chart</span>
                                             </div>
                                             <div id='rep_narrowby_searchterm_results'>
                                            
                                            
                                             </div>
                                             <div class='pagation_bar_mini ub_corners3'>
                                             <div id='rep_pagation_mini_searchterm'>
                                                     
                                             </div>
                                             </div>
                                             </div>
                                           
                                            
                                               <div class='clearboth'></div>
                                            </div>
                                      </div>
                                </div>
                            <!--end-->   
                               
                                </li>
                    
                       
                        
                        
                        
                     
                     
                        
                       
                        
                       
                        </ul>
                    </div>
                    
                    
                    
                    
                   
                   
                
               <div>
                    </div>
                    
                    
                    
                 </div>
                 
                 
              
                       
               </div>
               
      
        </div>
        
        
      
        <div id='dashmain_det' class='ub_corners dashmain'></div>
        
                                                </li>
                                                <li id='unibody_about'>
                                                    <div id='about_nadlabs'>
                                                        You're running nadlabs nerve centre (userbase + sitestats) v<?php echo VERSION_NUMBER;?> under the code canyon licence.
                                                        <br/>
                                                        &copy; 2011 nadlabs. All rights reserved.
                                                    </div>
                                                </li>
                                                </ul>
                                </div>
    </div>
                            </div>
        
    <div class='clb'></div>
    
    </div>
   
 </div>
 
</body>




</html>