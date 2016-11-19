<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
require_once("local_config.php");
require_once(APP_INC_PATH."bootstrap_frontend.php");
sessionsClass::sessionStart();
if (!sessionsClass::sessionStartFind($groupTest=array(1))){
    header("Location: logout.php?r=0");
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
    

    <link type="text/css" rel="stylesheet" href="css/styles_admin.css" type="text/css">

    <link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css" />

    
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.6.custom.min.js"></script>
    
    <script type="text/javascript" src="js/corners.js"></script>
    <script type="text/javascript" src="js/scroll.js"></script>
    <script type="text/javascript" src="js/scroll_int_ub.js"></script>

    <script type="text/javascript" src="js/jquery.qtip.min.js"></script>
    <script type="text/javascript" src="js/actions.js"></script>
     <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
     
      
    </script>
    
        <script>
            $(document).ready(function () {
               
                             
            
              
                  slide_unibody("dashboard");
         
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
                
                
                
                
		
            
                
               reset_bindings();
          
                
               
                
                

                
            });
            
         
        </script>


</head>
<body >
 
    <div id='model'>
        
    </div>
    <!--
    <div id='load_info' class='ub_corners hide'>
        
    </div>
    <div id='load_info_inner' class='ub_corners hide'>
    </div>
    -->
    
    
    
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
    <div class='outer-glass-load ub_corners'>
        
    </div>
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
            <div style='width:1000px; display:inline-block; text-align:left;border-left:solid 1px #4e4e4e;border-right:solid 1px #4e4e4e;'>
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
            <div style='width:1000px; display:inline-block; text-align:left; border-left:solid 1px #ebebeb;border-right:solid 1px #ebebeb;'>
            <div class='fll' id='textlinks'>
           <div id='links_functionsx' class='' style='padding:2px 0px 0px 7px; font-size:12px;' >
             <span class='txtl' >you're signed in as <span id='login_name'><?php echo $_SESSION['username'];?></span> - <a class='toplink' href='logout.php'>sign out</a></span>
               
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
                            <ul class="ub-elements" style="width:2360px; height:670px;" id='group-ul'>
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
                            <div id='edit_sec_msg'>
                                
                            </div>
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
                            <img src='images/roar_browser_images_firefox.gif' width='40px' height='40px' id='ub_gravimg_editor'/>
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
                                                            <div class=' ub_input_release_edit_user' style='width:100%' >
                                                                <select id='ub_edit_country' class='ub_select_box_small' style='width:inherit;'>
                                                                    <option value='-9'>loading...</option>
                                                                </select>
                                                                 </div>
                                                                
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class=' ub_input_release_edit_user' style='width:100%'>
                                                                <select id='ub_edit_lang' class='ub_select_box_small'  style='width:inherit;'>
                                                                  <option value='-9'>loading...</option>
                                                                </select>
                                                                </div>
                                                                
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                               <div class=' ub_input_release_edit_user' style='width:100%'>
                                                                <select id='ub_edit_os' class='ub_select_box_small' style='width:inherit;'>
                                                                   <option value='-9'>loading...</option>
                                                                </select>
                                                                
                                                                 </div>
                                                                
                                                                <div class='clearboth'></div>
                                                           </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release_edit_user' style='width:100%'>
                                                                <select id='ub_edit_browser' class='ub_select_box_small'  style='width:inherit;'>
                                                                  <option value='-9'>loading...</option>
                                                                </select>
                                                           </div>
                                                            
                                                                <div class='clearboth'></div>
                                                            
                                                            </div>
                                                        <div style='height:23px;'></div>
                                        
                                                        <div class='ub_corners ub_text_box_wraps_small'>
                                                            <div class='ub_input_release_edit_user' style='width:100%'>
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
                                                             <div class='ub_input_release_edit_user' style='width:100%'>
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
                                                            <div class='ub_input_release_edit_user' style='width:100%'>
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
                            <img src='images/roar_browser_images_firefox.gif' width='40px' height='40px' id='ub_gravimg_msg'/>
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
							<span class='ub_buttons' onclick='slider_changer("editor","qf-pane-options")' >edit user</span>
                                                         <span class='ub_buttons' onclick='slider_changer("email","qf-pane-options")'>send message</span>  <span onclick='slider_changer("user-notes","qf-pane-options"); getUserNotes();' class='ub_buttons'>user notes</span>
                                                    </div>
                                                    <div class='clb'></div>
                                                </div>
                                                 <div class='ub_corners slider_c'>
                                                   
                                                <div id='ub-details-container'>
                                                <div id='ub-details-header'>
                                                    
                                                 <div class='floatlefts ub_imgbox hide' >
                            <img id='graveimg' src='images/roar_browser_images_firefox.gif' width='40px' height='40px'/>
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
                 <div class='rep_domainname' id='rep_domain' >userbase user stats</div>
             
                
            </div>
           
            
            
            <div class='flr rep_top_stats'  >
                
                 
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
                <div  class='floatlefts rep_top_stats_boxes_last' >
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
                            <div class='ub_corners ub-quick-results-box-chart'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' id='swap_txt'  style=' margin-left:5px; text-align:center;'>
                                 showing stats for registered users:</div>
                    </div>
                                
                          
                        </div>
                        
                            
                            
                            
                       
                            
                            
                            <div id='user_qstats'>
                        <div class='ub_corners ub-quick-results-box'  style='cursor:default'>
                                <div class='inner_results_box'>
                               
                                <div class='quick_details_xyz' style=' margin-left:5px;'>
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'   >
                                           <span id='ub_dash_browser'></span>
                                          <br/>
                                           <div  style='font-size:12px;font-weight:normal; font-family:helvetica;'>
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
                               
                                <div class='quick_details_xyz' >
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'    style='cursor:default' >
                                          <span id='ub_dash_os'></span>
                                          <br/>
                                           <div  style='font-size:12px; font-weight:normal; font-family:helvetica'>
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
                                   
                                    
                                    <div class='floatlefts quick_stats_dash'    >
                                          <span id='ub_dash_location'></span>
                                          <br/>
                                           <div  style='font-size:12px; font-weight:normal;font-family:helvetica'>
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
                                           <div  style='font-size:12px; font-weight:normal;font-family:helvetica'>
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
                      </div>
                         
                       
                    
                   
                </div>
              
        </div>
        
        
      
        <div id='dashmain_ub' class='ub_corners dashmain'></div>
        
                                                </li>
                                                
                                                
                                                
                                                
                                                
                                                
                                                <li id='unibody_about'>
                                                    <div id='about_nadlabs'>
                                                        You're running nadlabs standalone userbase v1.0 under the nadlabs licence.
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