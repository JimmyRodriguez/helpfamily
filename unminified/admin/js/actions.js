

/*
 
    todo: TD003JS: move all error msgs into a php file and load on request (to make it easy to translate/localise)
    todo: TD004JS: any settings such as the pagation length set via php file - making config easier once config is automagic via Control Panel UI
    
    global config settings - default settings
*/
//only effects quick view
var pagationLength_QV   =   10;
//these pagation lengths need to be both removed [not yet through as they still are needed!]
var pagtionLength       =   10;

function loadConfigFiles(){
    //future development
    //set config settings - maybe better to use jquery 'ajax' to handle lack of response?
    
    $.post("../config/config_js.php",{},function(configSettings){
        
        //process config settings in to global vars - all should have default settings in case of failure
        
        
        
    });
    
    
    //set error messages
    
    $.post("../lang/en_js.php",{},function(msgSettings){
        
        //process msg outputs in to global vars
        
    });
    
}



function swap_user_visitor_stats(){
    
    if($('#user_qstats').is(':visible')){
        $('#user_qstats').hide('slide',function(){
                            $('#visit_qstats').show('slide');
                            
                           $('#swap_txt').html('show quick stats results for registered users');
                            
        });
    }
    else{
        $('#visit_qstats').hide('slide',function(){
                            $('#user_qstats').show('slide');
                             
                             $('#swap_txt').html('show quick stats results for vistors');
                           
                            
        });
    }
    
    
}

function loadquickstats(id){
         $.post("../ajax/get_dash_data.php",{},function(dashReturn){
        
            var obj = jQuery.parseJSON(dashReturn);
              
            
            var QSdata = obj.data.statsdata;
          
            
            
            
            
            
            
            
           
           
              if (obj.data.statsdata['members']=='okay'){
                
               
                
                
                
                
                $('#rep_reg'+id).html(obj.data.statsdata['total']);
                $('#rep_visit'+id).html(obj.data.statsdata['thirty_day_visit']);
                $('#rep_30day_reg'+id).html(obj.data.statsdata['lastmonthmembers']);
                $('#rep_active'+id).html(obj.data.statsdata['activeusers']);
                $('#rep_waiting'+id).html(obj.data.statsdata['waiting']);
                $('#rep_activated'+id).html(obj.data.statsdata['active']);
                $('#rep_blocked'+id).html(obj.data.statsdata['blocked']);
                var class_colour;
                if (parseInt(obj.data.statsdata['difference'])<0){
		  class_colour='rep_colours_neg';
		}
		else if (parseInt(obj.data.statsdata['difference'])>0){
		  class_colour='rep_colours_plus';
		  obj.data.statsdata['difference'] = '+'+obj.data.statsdata['difference'];
		}
		else{
		  class_colour='rep_colours_same';
		}
		$('#rep_reg_30day'+id).html(obj.data.statsdata['difference']).addClass(class_colour);
                
                $('#rep_con_all'+id).html(obj.data.statsdata['precent_all']);
                $('#rep_con_30'+id).html(obj.data.statsdata['precent30']);
                
              
              //need a way to tell if google loaded  
                var data = new google.visualization.DataTable();
               //  alert(data);
                data.addColumn('string', 'status');
                data.addColumn('number', 'members');
                data.addRows(5);
                data.setValue(0, 0, 'activated');
                data.setValue(0, 1, parseInt(obj.data.statsdata['active']));
                data.setValue(1, 0, 'waiting');
                data.setValue(1, 1, parseInt(obj.data.statsdata['waiting']));
            
                data.setValue(2, 0, 'blocked');
                data.setValue(2, 1, parseInt(obj.data.statsdata['blocked']));
              
        
                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, {width: 300, height: 150, colors:['#00C705','#00A6C4','#DA0303']});
                
               
                
                
            }
            else{
                
                $('#rep_reg'+id).html('error');
                $('#rep_30day_reg'+id).html('error');
                $('#rep_active'+id).html('error');
                $('#rep_waiting'+id).html('error');
                $('#rep_activated'+id).html('error');
                $('#rep_blocked'+id).html('error');
                
            }
            

           
           
          
            //get help topics?
        
    });
    
    

}

function get_p(x,y){
    var z = ((parseInt(x)/parseInt(y))*100);
    z=(z<100)?z.toFixed(1):z;
    return z+'%';
}

function loadDashboard(){
    
   

     $.post("../ajax/get_dash_data.php",{},function(dashReturn){
        
            var obj = jQuery.parseJSON(dashReturn);
              
            
            var QSdata = obj.data.statsdata;
           // alert('okay');
            
            if (obj.data.statsdata['members_total']=='okay'){
              //  QSfile = QSfile.replace('##totalmembers##', obj.data.statsdata['total']);
            }
            else{
               // QSfile = QSfile.replace('##totalmembers##', '');
            }
            
	    
            if (obj.data.statsdata['qs_stats']=='okay'){
                     
                $('#ub_dash_browser').html(obj.data.statsdata['browser_name']);
                $('#ub_dash_browser_user').html(get_p(obj.data.statsdata['browser_count'],obj.data.statsdata['total']));
                
                $('#ub_dash_os').html(obj.data.statsdata['os_name']);
                $('#ub_dash_os_user').html(get_p(obj.data.statsdata['os_count'],obj.data.statsdata['total']));
                
                $('#ub_dash_language').html(obj.data.statsdata['lang_name']);
                $('#ub_dash_language_user').html(get_p(obj.data.statsdata['lang_count'],obj.data.statsdata['total']));
                
                $('#ub_dash_location').html(obj.data.statsdata['country_name']);
                $('#ub_dash_location_user').html(get_p(obj.data.statsdata['country_count'],obj.data.statsdata['total']));
                
         
            }
            else{
                
                $('#ub_dash_browser').html('failed to load');
                $('#ub_dash_browser_user').html('');
                
                $('#ub_dash_os').html('failed to load');
                $('#ub_dash_os_user').html('');
                
                $('#ub_dash_language').html('failed to load');
                $('#ub_dash_language_user').html('');
                
                $('#ub_dash_location').html('failed to load');
                $('#ub_dash_location_user').html('');
            
            }
            
            
            
            if (obj.data.statsdata['qs_stats_vs']=='okay'){
                     
               
                $('#ub_dash_browser_v').html(obj.data.statsdata['browser_name_v']);
                $('#ub_dash_browser_visit').html(get_p(obj.data.statsdata['browser_count_v'],obj.data.statsdata['total_visits']));
                
                $('#ub_dash_os_v').html(obj.data.statsdata['os_name_v']);
                $('#ub_dash_os_visit').html(get_p(obj.data.statsdata['os_count_v'],obj.data.statsdata['total_visits']));
                
                $('#ub_dash_language_v').html(obj.data.statsdata['lang_name_v']);
                $('#ub_dash_language_visit').html(get_p(obj.data.statsdata['lang_count_v'],obj.data.statsdata['total_visits']));
                
                $('#ub_dash_location_v').html(obj.data.statsdata['country_name_v']);
                $('#ub_dash_location_visit').html(get_p(obj.data.statsdata['country_count_v'],obj.data.statsdata['total_visits']));
           
            }
            else{
                
                $('#ub_dash_browser_v').html('failed to load');
                $('#ub_dash_browser_v').html('');
                
                $('#ub_dash_os_v').html('failed to load');
                $('#ub_dash_os_v').html('');
                
                $('#ub_dash_language_v').html('failed to load');
                $('#ub_dash_language_v').html('');
                
                $('#ub_dash_location_v').html('failed to load');
                $('#ub_dash_location_v').html('');
                
            }
            
            
            
           
	   
	   
	   
	   
	   
	   if (obj.data.NUAck=="success"){
                
                var NUfile = obj.data.newuserfile;
                var NUfileAlt = obj.data.newuserfile_alt;
                var NUdata = obj.data.newusers;
                var fullListNU='';
                var altflag = false;
                for(x in NUdata){
                    
                    
                    if (altflag){
                        fullListNU += NUfileAlt;
                        altflag=false;
                    }
                    else{
                        fullListNU += NUfile;
                        altflag=true;
                    }
                    
                    
                    
                    
                    fullListNU = fullListNU.replace(/##screenname##/gi, NUdata[x]['screenname']);
                    fullListNU = fullListNU.replace(/##userid##/gi, NUdata[x]['userid']);
                    fullListNU = fullListNU.replace(/##date_joined##/gi, NUdata[x]['date_joined_formatted']);
                    
                    fullListNU = fullListNU.replace(/##graveimg##/gi, NUdata[x]['graveimg']);
                    
                    //need to get author name
                }
                $('#new_users_results').html(fullListNU);
                
            }
            else{
               $('#new_users_results').html(obj.data.newusers); 
            }
	    
	    if (obj.data.alertAck=="success"){
		var login_alerts = obj.data.loginalerts, alerts_buildup_a='', alerts_buildup_u='',adminc=0,userc=0;
		for(x in login_alerts){
		    if (login_alerts[x]['loc']=='admin'){
			alerts_buildup_a += obj.data.alert_fla_file;
			alerts_buildup_a = alerts_buildup_a.replace('##refurl##',login_alerts[x]['refurl']);
			alerts_buildup_a = alerts_buildup_a.replace('##country##',login_alerts[x]['name']);
			alerts_buildup_a = alerts_buildup_a.replace('##ipad##',login_alerts[x]['ipad']);
			alerts_buildup_a = alerts_buildup_a.replace('##to##',login_alerts[x]['todate']);
			alerts_buildup_a = alerts_buildup_a.replace('##from##',login_alerts[x]['fromdate']);
			alerts_buildup_a = alerts_buildup_a.replace('##attempts##',login_alerts[x]['counter']);
			adminc++;
		    }
		    else{
			alerts_buildup_u += obj.data.alert_fla_file;
			alerts_buildup_u = alerts_buildup_u.replace('##refurl##',login_alerts[x]['refurl']);
			alerts_buildup_u = alerts_buildup_u.replace('##country##',login_alerts[x]['name']);
			alerts_buildup_u = alerts_buildup_u.replace('##ipad##',login_alerts[x]['ipad']);
			alerts_buildup_u = alerts_buildup_u.replace('##to##',login_alerts[x]['todate']);
			alerts_buildup_u = alerts_buildup_u.replace('##from##',login_alerts[x]['fromdate']);
			alerts_buildup_u = alerts_buildup_u.replace('##attempts##',login_alerts[x]['counter']);
			userc++;
		    }
		    
		  
		    
		    
		}
		if (adminc>0){
		    $('#admin_logins').html(alerts_buildup_a);
		    $('#admin_fail').show(1);
		}
		else{
		    $('#admin_fail').hide(1);
		}
		
		if (userc>0){
		    $('#user_logins').html(alerts_buildup_u);
		    $('#user_fail').show(1);
		}
		else{
		    $('#user_fail').hide(1);
		}
		$('#alertsbox').show(1);
		
	    }
	    
	    else{
		$('#alertsbox').html(obj.data.loginalerts).show(1);
	    }
	    
	    
           $('.ub_corners').corner('5px keep');
           $('.ub_corners3').corner('3px');
           
            
             $('.ub_newuser,.ub_newuser_alt').bind('mouseover',function(event){
                    
                                         $(this).css({'background-color':'#fff'});
                                                 
                     
                             });
                $('.ub_newuser,.ub_newuser_alt').bind('mouseout',function(event){
       
                            $(this).css({'background-color':'#fafafa'});
                                    
        
                });
              if (obj.data.statsdata['members']=='okay'){
                
               
                
                
                
                
                $('#rep_reg').html(obj.data.statsdata['total']);
                $('#rep_visit').html(obj.data.statsdata['thirty_day_visit']);
                $('#rep_30day_reg').html(obj.data.statsdata['lastmonthmembers']);
                $('#rep_active').html(obj.data.statsdata['activeusers']);
                $('#rep_waiting').html(obj.data.statsdata['waiting']);
                $('#rep_activated').html(obj.data.statsdata['active']);
                $('#rep_blocked').html(obj.data.statsdata['blocked']);
                var class_colour;
                if (parseInt(obj.data.statsdata['difference'])<0){
		  class_colour='rep_colours_neg';
		}
		else if (parseInt(obj.data.statsdata['difference'])>0){
		  class_colour='rep_colours_plus';
		  obj.data.statsdata['difference'] = '+'+obj.data.statsdata['difference'];
		}
		else{
		  class_colour='rep_colours_same';
		}
		$('#rep_reg_30day').html(obj.data.statsdata['difference']).addClass(class_colour);
                
                $('#rep_con_all').html(obj.data.statsdata['precent_all']);
                $('#rep_con_30').html(obj.data.statsdata['precent30']);
                $('#dashmain_ub').height(1300);
       
              //need a way to tell if google loaded  
                var data = new google.visualization.DataTable();
              
                data.addColumn('string', 'status');
                data.addColumn('number', 'members');
                data.addRows(5);
                data.setValue(0, 0, 'activated');
                data.setValue(0, 1, parseInt(obj.data.statsdata['active']));
                data.setValue(1, 0, 'waiting');
                data.setValue(1, 1, parseInt(obj.data.statsdata['waiting']));
            
                data.setValue(2, 0, 'blocked');
                data.setValue(2, 1, parseInt(obj.data.statsdata['blocked']));
              
        
                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, {width: 300, height: 150, colors:['#00C705','#00A6C4','#DA0303']});
                
		
                
                
            }
            else{
                
                $('#rep_reg').html('error');
                $('#rep_30day_reg').html('error');
                $('#rep_active').html('error');
                $('#rep_waiting').html('error');
                $('#rep_activated').html('error');
                $('#rep_blocked').html('error');
                
            }
            
	   
           
           
          
            //get help topics?
        
    });
    
   
}










function addnewgroup(){
    
    var group_name=$('#ub_add_group_title').val();
    var short_desc = $('#ub_add_group_desc').val();
    
    
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'', onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
    if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('saving user group...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
            $.post("../ajax/save_add_group.php",{short_desc:short_desc,group_name:group_name},function(dataReturn){
                
                        var obj = jQuery.parseJSON(dataReturn);
                         $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                        });
                        if (obj.Ack=="success"){
                      
                           $('#ub_add_img_group').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');
                             
			    //need to re-do lists
			    unibody_current_groups['search_list'] 	= $('#ub_search_group').val();
			    unibody_current_groups['edit_list'] 	= $('#ub_edit_group').val();
			    unibody_current_groups['add_list'] 		= $('#ub_add_group').val();
			    
			    //refresh list
			    getLists(false,false,false,false,true,true);
			    
                        }
                        else{
                            if (obj.Ack=="fail"){
                            
                            //$('#addresponse').html(obj.Msg);
                    
                        }
                        else if (obj.Ack=="validationFail"){
                    
                               // $('#saveresponse').html(obj.Msg);
                                validationData = obj.validationdata;
                                
                                if (validationData.nameAck=='fail'){
                                    $('#ub_add_img_group').attr({'title':validationData.nameMsg,'src':'../images/alert.gif'});
                                                        
                                    errorTip('ub_add_img_group');
                                }
                                else{
                                     $('#ub_add_img_group').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');

                                }
                                
                                    
                                
                               
                            }
                        }
                        
         
                        
                
            });
        });
    });
    
}



function showNewUser(){
    closeAllBox();
    
    $('#addresponse').html('');
    
    $('#add_username_responsetext').html('');
    $('#add_password_responsetext').html('');
    $('#add_email_responsetext').html('');
    
    $('#add_popup_user').css("position","absolute");
    $('#add_popup_user').css("top", ( $(window).height() - $('#add_popup_user').outerHeight() ) / 2+$(window).scrollTop() + "px");
    $('#add_popup_user').css("left", ( $(window).width() - $('#add_popup_user').outerWidth() ) / 2+$(window).scrollLeft() + "px");
    $('#add_popup_user').fadeIn(509);
}

function showGroupAdd(){
    closeAllBox();
    $('#grouptitle_add').val('');
    $('#groupshort_add').val('');
    $('#add_grouptitle_response').html('');
    $('#addresponse').html('');
    
    $('#add_popup_group').css("position","absolute");
    $('#add_popup_group').css("top", ( $(window).height() - $('#add_popup_group').outerHeight() ) / 2+$(window).scrollTop() + "px");
    $('#add_popup_group').css("left", ( $(window).width() - $('#add_popup_group').outerWidth() ) / 2+$(window).scrollLeft() + "px");
    $('#add_popup_group').fadeIn(509);
}
var group_ready_for_edit;
function showGroupEdit(id){

    group_ready_for_edit = id;
     var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('loading data...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
                $.post("../ajax/get_group_data.php",{groupid:id},function(dataReturn){
                  // alert (dataReturn);
                          
                      var obj = jQuery.parseJSON(dataReturn);
                            
                      if (obj.Ack=="success"){
                       $('#site_wide_load'+load_inline+glass).fadeOut(100);
                        //   alert('success');
                           $('#edit_group_msg').html('');
                           var dataArray = obj.data;
                           $('#ub_edit_group_title').val(dataArray['name']);
                            $('#ub_edit_group_desc').val(dataArray['descip']);
                          
                             slider_changer("edit-group","qf-pane-options-group");
                           
                           
                           

               
                           
                         
                      }
                      else{
                       //  alert('fail');
                       $('#edit_group_msg').html(obj.Msg);
                       
                       
                         group_ready_for_edit=0;
                           $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                                    });
                         
                      }
                          
                     
               
	       
	       });
        });
    });
}

var unibody_current_groups = new Array();
unibody_current_groups['search_list'] = -9;
unibody_current_groups['edit_list'] = 1;
unibody_current_groups['add_list'] = -9;
function saveEditGroup(){
    
    
    
   
    var  group_name = $('#ub_edit_group_title').val();
    var short_desc = $('#ub_edit_group_desc').val();
   
    if(group_ready_for_edit!=0){
  var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('saving changes...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
                $.post("../ajax/save_edit_group.php",{group_name:group_name,short_desc:short_desc,group_id:group_ready_for_edit},function(dataReturn){
                    
                    var obj = jQuery.parseJSON(dataReturn);
                    $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                    });
                    if (obj.Ack=="success"){
                     
                       // $('#saveresponse').html(obj.Msg);
                        $('#ub_edit_img_group').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');
                                     
                        $('#groupdesc_id_'+group_ready_for_edit).html(short_desc);
                        $('#groupname_id_'+group_ready_for_edit).html(makeTextSmall(group_name,20));
			
			
			//need to re-do lists
			
			unibody_current_groups['search_list'] = $('#ub_search_group').val();
			unibody_current_groups['edit_list'] = $('#ub_edit_group').val();
			unibody_current_groups['add_list'] = $('#ub_add_group').val();
			
			//refresh list
		
			getLists(false,false,false,false,true,true);
			
			
			
                    }
                    else{
                            if (obj.Ack=="fail"){
                                
                                //$('#saveresponse').html(obj.Msg);
                        
                            }
                            else if (obj.Ack=="validationFail"){
                        
                                //$('#saveresponse').html(obj.Msg);
                                validationData = obj.validationdata;
                                
                                if (validationData.nameAck=='fail'){
                                    
                                    $('#ub_edit_img_group').attr({'title':validationData.nameMsg,'src':'../images/alert.gif'});
                                                        
                                    errorTip('ub_edit_img_group');
                                }
                                else{
                                    $('#ub_edit_img_group').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');

                                }
                                
                                
                                
                               
                            }
                    }
                    
                    
                  
                });
       
	    });
        });
    }
    else{
        $('#saveresponse').html('no record found.');
    }
}
var group_ready_for_delete=0;
function delete_group(){
     
    
    
    var id =group_ready_for_delete;
    
    if(id!=0){
        $.post("../ajax/delete_group.php",{group_id:id},function(dataReturn){
                    var obj = jQuery.parseJSON(dataReturn);
                     
                    if (obj.Ack=="success"){
                  
			unibody_current_groups['search_list'] = $('#ub_search_group').val();
			unibody_current_groups['edit_list'] = $('#ub_edit_group').val();
			unibody_current_groups['add_list'] = $('#ub_add_group').val();
		
			//refresh list
		
			getLists(false,false,false,false,true,true);
   
                        $('#ub_group_delete_display_'+id).hide(1);
                        $('#ub_group_desc_'+id).html('group deleted');
                        $('#delete_group_msg').html(obj.Msg);
			
			//need to re-do lists
			
			
			
                    }
                    else{
                        $('#delete_group_msg').html(obj.Msg);
                    }
                    
                
     
                    
        });

    }
    
    //need to hide all info
    
}

function confirm_delete(id){
    group_ready_for_delete=id;
    showinfobox("delete_groups_loadbox");
}


function changeStatusGroup(id,newStatus){
    
    
    
    
    
    $('#itemloader_id_'+id).show(100,function(){
        $.post("../ajax/change_status_group.php",{groupId:id,status:newStatus},function(dataReturn){
                    var obj = jQuery.parseJSON(dataReturn);
                     
                    if (obj.Ack=="success"){
                     
                        $('#group_list_info_id_'+id).slideUp(100);
                        $('#groupresponse_id_'+id).html(obj.Msg);
                     
                    }
                    else{
                        $('#groupresponse_id_'+id).html(obj.Msg);
                    }
                    
                    
                    $('#itemloader_id_'+id).hide(1);
                    
        });
    });
    
    //need to hide all info
    
}

function slider_changer(id,panename){

     var $paneOptions = $('#'+panename);
     
     $paneOptions.scrollTo( '#'+id, { duration: 1000,queue:true,axis:'yx'  } );
     
     $('div.ub_input_warnings').qtip('destroy');
     $('#site_wide_msg').html('').hide(1);
   
    $('#site_wide_load').hide(1);
    $('div.ub_add_warn > img').attr('src','../images/blank.gif');
    $('div.ub_add_warn > img').attr('title','');
    
    $('div.ub_edit_warn > img').attr('src','../images/blank.gif');
    $('div.ub_edit_warn > img').attr('title','');
}

function releaseFilter(){
    $('#release_filter').hide(1);
    $('#searchBlockQuery').val('');
    $('#blocktype_search').val(1);
    searchBlock('0,'+pagtionLength,1,1)
}

function blockPagation(source){
    
   
   
    if (source==1 || source==3){
        var limiter = '0,'+pagtionLength;
        var blocktype = $('#blocktype_pagation').val();
        searchBlock(limiter,source,blocktype);
    }
    else if (source==2){
        var newLimit = $('#block_pagation').val();
        var blocktype = $('#blocktype_pagation').val();
        
        newLimit = newLimit*10;
         
        var start = newLimit;
        
        if (start<0){
            start = 0;
        }
        
        var limiter = start+',10';
        
        searchBlock(limiter,1,blocktype);
    }
   
    
    
    
    
}

function isnull(val,numflag){
	if (val==null || val == undefined || val== 'null'  || jQuery.trim(val) == ''){
            
            return 0;
            
            
            
	}
	else{
            
	
                if(isNaN(val) && numflag){
                    
                    return 0;
                
                }
                else{
                    
                    return val;
                
                }
		
            
            
	}
}

function showBlockSearch(){
   
    closeAllBox();
   
    
    $('#search_popup_block').css("position","absolute");
    $('#search_popup_block').css("top", ( $(window).height() - $('#search_popup_block').outerHeight() ) / 2+$(window).scrollTop() + "px");
    $('#search_popup_block').css("left", ( $(window).width() - $('#search_popup_block').outerWidth() ) / 2+$(window).scrollLeft() + "px");
    $('#search_popup_block').fadeIn(509);
}
inital_load_block=true;
function searchBlock(limiter,source,block_type){
    
    //need to get different types of blocks
    if (source == 2 ){
        $('#block_pagation').val(1);
        var validtype =  $('#ub_search_block_valid').val();
    }
    else{
        var validtype = -9;
    }
    //hide main search dialog
    
    var searchQuery = $('#ub_search_block').val();
  
    if (block_type=='' || block_type==undefined){
        block_type = $('#ub_search_block_type').val();
    }
   
   
  
  
    if (inital_load_block){
        var msg = 'loading userbase security area...';
        inital_load_block=false;
       }
       else{
        
        var msg = 'searching userbase security area...';
       }
        
      
     var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html(msg);
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
    
    
    $.post("../ajax/search_full_block.php",{query:searchQuery,limit:limiter,sourcer:source,blocktype:block_type,validtype:validtype},function(dataReturn){
         var obj = jQuery.parseJSON(dataReturn);
            if (obj.Ack=="success"){
            
                
                
                //$('#site_wide_msg'+load_inline).html(obj.Msg);
                            $('#site_wide_load'+load_inline+glass).fadeOut(100);
                   
                
                    $('#resultsset').html('');
                    var dataArray = obj.data;
                    var totalCount = obj.total_count;
                    var optionsBloc='';
                   
                        //build up drop down for pagation
                        pageTotals = Math.ceil((totalCount/10));
                       
                      
                        if (pageTotals==0){
                            pageTotals=1;
                        }                        
                                            
                        if (totalCount>0){
                            for (i=0;i<pageTotals;i++){
                            
                            optionsBloc += '<option value="'+i+'" > page '+Number(i+1)+'</option>' ;
                            
                            }
                          
                            if (source!=1 || limiter=='0,'+pagtionLength){
                                $('#block_pagation').html(optionsBloc);
                                $('#block_pagation').show();
                                
                            }
                            
                            
                       }
                        else{
                            $('#block_pagation').hide();
                            
                        }
                        
                    
                    
                
                    var pageBuildUp='';
                    for (x in dataArray){
                        
                        pageBuildUp += obj.repeater;
                        pageBuildUp = pageBuildUp.replace('##blockvalue##',makeTextSmall(dataArray[x]['blockvalue'],20));
                        if (dataArray[x]['description']==''){
                            pageBuildUp = pageBuildUp.replace('##blockdesc##','no description');
                        }
                        else{
                             pageBuildUp = pageBuildUp.replace('##blockdesc##',dataArray[x]['description']);
                        }
                        
                       
                        pageBuildUp = pageBuildUp.replace(/##blockid##/gi,dataArray[x]['blockid']);
                        
                        
                        if(dataArray[x]['valid']==2){
                            pageBuildUp = pageBuildUp.replace(/##colour##/gi,'DA0303');
                            pageBuildUp = pageBuildUp.replace(/##status##/gi,'inactive');
                            pageBuildUp = pageBuildUp.replace(/##status_val##/gi,1);
                            //pageBuildUp = pageBuildUp.replace(/##statusvalue##/gi,2);
                            
                        }
                        else if (dataArray[x]['valid']==1) {
                            pageBuildUp = pageBuildUp.replace(/##colour##/gi,'63d300');
                            pageBuildUp = pageBuildUp.replace(/##status##/gi,'active');
                            pageBuildUp = pageBuildUp.replace(/##status_val##/gi,2);
                           // pageBuildUp = pageBuildUp.replace(/##statusvalue##/gi,1);
                            
                        }
                        
                                 
                                    
                        
                        
                       
                        
                       
                    }
                 
                    $('#blocktype_pagation').val(block_type);
                    $('#ub_block_results').html(pageBuildUp);
                    
                    $('.ub_corners').corner('5px');
                  
                    $('#results_set').height($('#inner_float_results').height()+10);
                    
                    
               
                    
                    
                    
                    
                    
                   /* $('#countPageQuick').html(countPages);
                    if (countPages>1){
                        $('#resultsText').html(' matching pages found');
                    }
                    else{
                        $('#resultsText').html(' matching page found');
                    }*/
                
              
                
               
                
                
                
                
                
                
                
               // var obj2 = jQuery.parseJSON(dataArray);
                
               // alert(obj2.pageid[0]);
                
                //alert(dataArray[0][0]);
                
                
                
            }
            else{
                
              $('#site_wide_msg'+load_inline).html(obj.Msg);
              $('#site_wide_load'+load_inline+glass).fadeOut(100);
                //will have to do show that nothing found here
              $('#ub_group_results').html('');
              $('#qres').html('');
              $('#countPageQuick').html('');
              $('#ub_block_results').html('no results found');
             
              
            }
            if (source==2){
                $('#release_filter').show(1);
            }
            else{
                $('#release_filter').hide(1);
            }
            
                            
            
    });
    
    });

           });

}
var block_ready_to_edit;
function showEditBlock(id){
    
      
  block_ready_to_edit = id;
    //$('#ub_edit_block_type').val(-9);
   // $('#ub_edit_desc').val('');
   // $('#ub_edit_block').val('');
    


    

    
    //need to get data!
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('loading data...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
        $.post("../ajax/get_block_data.php",{blockid:id},function(dataReturn){
           
                   
               var obj = jQuery.parseJSON(dataReturn);
                     
               if (obj.Ack=="success"){
                    $('#site_wide_load'+load_inline+glass).fadeOut(100);
                    
                    var dataArray = obj.data;
                    
                    //need to get authors username + userid
                    $('#ub_edit_block_type').val(dataArray['type']);
                    $('#ub_edit_block_desc').val(dataArray['description']);
                    $('#ub_edit_block').val(dataArray['blockvalue']);
                    $('#ub_edit_xsite').val(dataArray['blockarea']);
                     
                    
                            //$('#action_area').height($('#ub-details-main').height()+30);    
                     
                   slider_changer('edit-sec','qf-pane-options-security');
                   
                    
                   
               }
               else{
                
                    $('#ub_edit_block_type').val('');
                    $('#ub_edit_block_desc').val('');
                    $('#ub_edit_block').val('');
                    
          
                    block_ready_to_edit=0;
                    $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                    });
                    
    
                    
                    
                    
    
                    
    
               }
	       
	        
                    
        });
        
        
               
     });
    });

}

function hide_gl(){
    $('#glass_loader').fadeOut(100);
    $('#site_wide_msg_x,#site_wide_okay_x').hide(1);
 
}

function editBlock(){

    
    var block = $('#ub_edit_block').val();
    var blockdesc = $('#ub_edit_block_desc').val();
    var blocktype = $('#ub_edit_block_type').val();
    var blockarea = $('#ub_edit_xsite').val();
    

   

    if (block_ready_to_edit!=0){
      
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    //$('#site_wide_okay'+load_inline).hide(1);
    $('#site_wide_load_msg'+load_inline).html('saving changes...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
      
                    $.post("../ajax/save_edit_block.php",{blockdata:block,blockdesi:blockdesc,blockt:blocktype,blockid:block_ready_to_edit,blockarea:blockarea},function(dataReturn){
                        
                                    var obj = jQuery.parseJSON(dataReturn);
                                   $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                                    });
                                    if (obj.Ack=="success"){
                                        
                                     
                                     $('#ub_edit_img_details').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');
                                     
                                     $('#ub_block_display_'+block_ready_to_edit).html(makeTextSmall(block,20));
                                  
                                     $('#ub_block_desc_display_'+block_ready_to_edit).html(blockdesc);
                                   
                                     
                                     $('#ub_block_type_display_'+block_ready_to_edit).html($("#ub_edit_block_type option:selected").text());
                                        $('#results_set').height($('#inner_float_results').height()+10);
                                       
                                    }
                                    else{
                                            if (obj.Ack=="fail"){
                                              
                                                //$('#saveresponse').html(obj.Msg);
                                        
                                            }
                                            else if (obj.Ack=="validationFail"){
                                              
                                                //$('#saveresponse').html(obj.Msg);
                                                validationData = obj.validationdata;
                                                
                                                if (validationData.blockAck=='fail'){

                                                    $('#ub_edit_img_details').attr({'title':validationData.blockMsg,'src':'../images/alert.gif'});
                                                        
                                                    errorTip('ub_edit_img_details');
                                                 
                                                }
                                                else{
                                                    $('#ub_edit_img_details').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');
                                                }
                                                /*
                                                if ((validationData.typeAck=='fail' || validationData.blockidAck=='fail')  && validationData.blockAck!='fail' ){
                                                    $('#saveresponse').html(validationData.opsMsg);
                                                }
                                                */
                                                
                                                
                                                
                                            }
                                    }
                    
                        
                    });
              });
        });
    }
    else{
        $('#saveresponse').html('record not found');
    }
    
}

function errorTip(id){
	
	  $('#'+id).qtip({content: {attr: 'title'},overwrite: true,
                                                                    
                                    style:{
                                       
                                        tip: { offset: 5 }
                                     },
                                     position: {
					     at:'right top',
                                        my:'left bottom',
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }

                                     },
				      show: {
					     event: false,
					     ready: true
					  },
					  hide: false
	 });
}

function actdeBlock(id){
  
    var status = $('#ub_hidden_status_'+id).val();
        $.post("../ajax/change_status_block.php",{status:status,blockid:id},function(dataReturn){
                    
                    var obj = jQuery.parseJSON(dataReturn);
                     $('#facebox').find('#ub_loader_gif').fadeOut(1000,function(){
                                    $('#facebox').find('#ub_loader_gif_msg').html(obj.Msg);
                                     $('#facebox').find('#ub_facebox_okayclose').show();
                                    });
                    if (obj.Ack=="success"){
                        
                       
                            
                            if (status==1){
                               $('#ub_block_status_display_'+id).html('active');
                                $('#ub_block_status_display_'+id).css('color','#63d300');
                                 $('#ub_hidden_status_'+id).val(2);
                               /* $('#ub_block_status_display_'+id).unbind('click');
                                $('#ub_block_status_display_'+id).removeAttr('onclick');
                                $('#ub_block_status_display_'+id).bind('click',function(){
                                        actdeBlock(id,2);
                                        return false;
                                        });
                               */
                                
                                
                            }
                            else{
                                $('#ub_block_status_display_'+id).html('inactive');
                                $('#ub_block_status_display_'+id).css('color','#da0303');
                               /* $('#ub_block_status_display_'+id).unbind('click');
                                $('#ub_block_status_display_'+id).removeAttr('onclick');
                                $('#ub_block_status_display_'+id).bind('click',function(){
                                        actdeBlock(id,1);
                                        return false;
                                        });
                               */
                              $('#ub_hidden_status_'+id).val(1);
                                
                                
                            }
                            
                            
                      
                   
                    }
                    else{
                    
                            $('#alerts_id_'+id).html(obj.Msg);
                            
                    
                    }
                    
        });
  
}

function showBlockAdd(){
     closeAllBox();
    $('#add_popup_block').css("position","absolute");
    $('#add_popup_block').css("top", ( $(window).height() - $('#add_popup_block').outerHeight() ) / 2+$(window).scrollTop() + "px");
    $('#add_popup_block').css("left", ( $(window).width() - $('#add_popup_block').outerWidth() ) / 2+$(window).scrollLeft() + "px");
    $('#add_popup_block').fadeIn(509);
    
    $('#blockdesc_add').val('');
    $('#blocktype_add').val(1);
    $('#block_add').val('');
    
    $('#addresponse').html('');
    
    $('#add_block_response').html('');
    $('#add_blockdesc_response').html('');
}

function saveBlock(){
    
    var block =$('#ub_add_block').val();
    var blockdesc = $('#ub_add_desc').val();
    var blocktype = $('#ub_add_block_type').val();
    var blockarea = $('#ub_add_xsite').val();
    $('#addresponse').html('');
    
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('saving new security element...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
            $.post("../ajax/save_add_block.php",{blockdata:block,blockdesi:blockdesc,blockt:blocktype,blockarea:blockarea},function(dataReturn){
                
                        var obj = jQuery.parseJSON(dataReturn);
                              $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                                    });
                            if (obj.Ack=="success"){
                             
                               $('div.ub_add_warn > img').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');
                                   
                               
                            }
                            else{
                                    if (obj.Ack=="fail"){
                                        
                                      
                                
                                    }
                                    else if (obj.Ack=="validationFail"){
                                
                                        
                                        validationData = obj.validationdata;
                                        
                                        if (validationData.blockAck=='fail'){
                                            $('#ub_add_img_details').attr({'title':validationData.blockMsg,'src':'../images/alert.gif'});
                                                       
                                            errorTip('ub_add_img_details');
                                        }
                                        else{
                                            $('div.ub_add_warn > img').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');
                                        }
                                        
                                        
                                        
                                        
                                        
                                        
                                    }
                            }
                         
                
       
    });
            });
    });
}



function showUserEdit(id){
     closeAllBox();
     $('#saveresponse').html('');
     $('#edit_username_responsetext').html('');
    $('#edit_password_responsetext').html('');
    $('#edit_email_responsetext').html('');

    
    $('#quick_email_edit').val('');
                
    $('#groups_edit').val('');

    $('#quick_username_edit').val('');
    $('#quick_pass_edit').val('');
                
    $('#date_joined_edit').html();
                
    $('#userid_edit').val(0);
    
    $('#editusername').html('loading...');
                
    $('#edit_popup_user').css("position","absolute");
    $('#edit_popup_user').css("top", ( $(window).height() - $('#edit_popup_user').outerHeight() ) / 2+$(window).scrollTop() + "px");
    $('#edit_popup_user').css("left", ( $(window).width() - $('#edit_popup_user').outerWidth() ) / 2+$(window).scrollLeft() + "px");
    $('#edit_popup_user').fadeIn(509);
    
     $.post("../ajax/get_user_data.php",{userid:id},function(dataReturn){
       // alert (dataReturn);
               
           var obj = jQuery.parseJSON(dataReturn);
                 
           if (obj.Ack=="success"){
            
             //   alert('success');
             if(jQuery.trim($('#ub_user_results_history').html())=='history is empty'){
                $('#ub_user_results_history').html('');
             }
                alert($('#user_box_'+id).html());
                $('#ub_user_results_history').html($('#ub_user_results_history').html()+$('#user_box_'+id).html());
                var dataArray = obj.data;
                
                //need to get authors username + userid
                
                $('#editusername').html(dataArray['screenname']);
                
                $('#quick_email_edit').val(dataArray['email']);
                
                $('#quick_groups_edit').val(dataArray['groupid']);

                $('#quick_username_edit').val(dataArray['screenname']);
                
                $('#date_joined_edit').html(dataArray['date_joined']);
                
                $('#userid_edit').val(dataArray['userid']);
                
                $('#usergrav').attr('src', 'http://www.gravatar.com/avatar/' + hex_md5(dataArray['email'])+'.jpg');
                
                $('#quick_lang_edit').val(dataArray['lang_code']);
                
                $('#quick_status_edit').val(dataArray['status_valid']);
                
                $('#quick_refid_edit').val(dataArray['refid']);
                $('#quick_refurl_edit').val(dataArray['refurl']);
                $('#quick_os_edit').val(dataArray['os_code']);
                $('#quick_browser_edit').val(dataArray['browser_code']);
                $('#quick_country_edit').val(dataArray['code']);
                
                $('#quick_phone_edit').val(dataArray['phone']);
                $('#quick_contact_edit').val(dataArray['contact']);
         
                //date_joined
           }
           else{
            //  alert('fail');
              
                $('#editusername').html(obj.Msg);
                $('#date_joined_edit').html(' forever and ever');
                $('#userid_edit').val(0);
                

                
                
                

                

           }
                
    });
}

function swap_msg(type){
   
    
    if (type=='email'){
        if ($('#ub-email-content').is(':hidden')){
            $('#ub-sms-content').hide('slide',500,function(){
                $('#ub-email-content').show('slide',500);
                $('#ub_email_sms_info').html('email '+$('#ub_email_display').html());
            });
        }
        
    }
    else{
        if ($('#ub-sms-content').is(':hidden')){
            $('#ub-email-content').hide('slide',500,function(){
                    $('#ub-sms-content').show('slide',500);
                    $('#ub_email_sms_info').html('message '+$('#ub_phone_display').html());
            });
        }
    }
    
}


var userid_for_edit, quick_pass_edit;
var cl_regdate='', cl_regip='', cl_phone, cl_lastdate='', cl_lastip='', cl_status, cl_contact, cl_country, cl_lang, cl_os;
var cl_browser, cl_refurl, cl_refdomain,cl_refid, cl_group, cl_active;

function clickable_search(clickType,searchValue,displayName){
    
    $('#fl_'+clickType).html(displayName);
    $('#ub_rel_'+clickType).fadeIn(100);
    
    $('#ub_search_'+clickType).val(searchValue);
    
    
    /*
    switch(clickType){
        
        case 'regdate':
            cl_regdate = searchValue;
            break;
        case 'regip':
            cl_regip = searchValue;
            break;
        case 'phone':
            cl_phone = searchValue;
            break;
        case 'lastdate':
            cl_lastdate = searchValue;
            break;
        case 'lastip':
            cl_lastip = searchValue;
            break;
        case 'status':
            cl_status = searchValue;
            break;
        case 'contact':
            cl_contact = searchValue;
            break;
        case 'country':
            cl_country = searchValue;
            break;
        case 'lang':
            cl_lang = searchValue;
            break;
        case 'os':
            cl_os = searchValue;
            break;
        case 'browser':
            cl_browser = searchValue;
            break;
        case 'group':
            cl_group = searchValue;
            break;
        case 'active':
            //needs new code behind in php
            break;
        case 'refurl':
           cl_refurl = searchValue;
            break;
        case 'refdomain':
            cl_refdomain = searchValue;
            break;
        
        case 'refid':
            cl_refid = searchValue;
            break;
        
    }
    */
    
     searchUser_QV('0,'+pagationLength_QV,2);
}

function release_filter(clicktype){
     $('#fl_'+clicktype).html('');
    $('#ub_rel_'+clicktype).fadeOut(100);
    
    $('#ub_search_'+clicktype).val('');
    if (clicktype=='block' || clicktype=='block_type' || clicktype=='block_valid'){
        if(clicktype=='block_type'){
            $('#blocktype_pagation').val(-9);
        }
     
        searchBlock('0,10',2);
    }
    else{
        searchUser_QV('0,'+pagationLength_QV,2);
    }
}

function new_click_events(id,clicktype,search_value,display_text){
    
    $('#'+id).unbind('click');
    $('#'+id).removeAttr('onclick');
    //$('#ub_rel_'+clicktype).fadeIn(100);
    $('#'+id).bind('click',function(){
           
            clickable_search(clicktype,search_value,display_text);
            return false;
            });

}

function return_to_user(){
    if (userid_for_edit!=0 || userid_for_edit !=''){
        slider_changer('user-details','qf-pane-options');
        
    }
      
     
}

function swap_groups_sec(showwhat){
    $('div.ub_add_warn > img').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');
    $('div.ub_edit_warn > img').attr({'src':'../images/blank.gif','title':''}).qtip('destroy');
                                                                
    if($('#ub_group_container').is(':hidden')){
        $('#ub_block_container').hide('slide',function(){
                            $('#ub_group_container').show('slide',function(){
                                $('#results_set').height($('#inner_float_results').height()+10);    
                            });
                           
                            
        });
       
         $('#security_management').hide('slide',function(){
                                $('#group_management').show('slide');
				$('#functions_sec').hide(1,function(){
				    $('#functions_groups').show(1);
				     unibody_initalised['current_link_gs']='group';
				});
				
                            });
         
          
          $('#show-group-sec').html("manage security");
          $('#title-group-sec').html("user group management");
    }
    else {
        
        $('#ub_group_container').hide('slide',function(){
            $('#ub_block_container').show('slide',function(){
                $('#results_set').height($('#inner_float_results').height()+10);    
            });
            
             
             
            
        });
       $('#group_management').hide('slide',function(){
                                $('#security_management').show('slide');
				$('#functions_groups').hide(1,function(){
				    $('#functions_sec').show(1);
				    unibody_initalised['current_link_gs']='sec';
				});
            });
         
         
         $('#show-group-sec').html("manage groups");
            $('#title-group-sec').html("security management");
    }
    
    
    
}

function swap_history_results(showwhat){
    
    if($('#history_block').is(':visible')){
        $('#history_block ').hide('slide',200,function(){
           
            $('#results_block').show('slide',200);
            $('#show-history-results').html("show today's history");
            $('#title-history-results').html("search results");
        });
    }
    else {
        $('#results_block').hide('slide',200,function(){
            
       
            $('#history_block').show('slide',200);
            $('#show-history-results').html("show search results");
            $('#title-history-results').html("today's history");
        });
    }
}

function clear_history(){
    
    $('#clear_history_msg').html('').hide(1);
    $('#clear_history_loader').fadeIn(100,function(){
        $.post("../ajax/clear_history.php",{},function(dataReturn){
             var obj = jQuery.parseJSON(dataReturn);
                     
               if (obj.Ack=="success"){
                   
                    $('#clear_history_msg').html(obj.Msg);
                    div_counter=1;
                    array_counter=0;
                    history_array = new Array();
                    $('#ub_user_results_history').html("<center>today's history is empty</center>");
                    
               }
               else{
                    $('#clear_history_msg').html(obj.Msg);
               }
               $('#clear_history_loader').fadeOut(100,function(){
                
                    $('#clear_history_msg').show(1);
                });
        });
    });
}

var history_array = new Array(), array_counter=0, div_counter=1;

function quick_search(){
    var search = $('#qs_search').val();
    if(jQuery.trim(search) !=''){
        if(isNaN(search)){
            //assume username
            $('#ub_search_username').val(search);
            searchUser_QV('0,10',2)
        }
        else{
            //is a userid
            $('#ub_search_userid').val(search)
            searchUser_QV('0,10',2)
        }
    }
    else{
        $('#qs_search').val('enter something here!');
    }
}

function showUserEdit_QV(id){
    //to prevent accidental pswd changes
    $('#ub_edit_pass').val('');
   

    $('#quick_pass_edit').val('');
    
    $('#userid_edit').val(0);
    
    quick_pass_edit='';
    userid_for_edit=0;
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'', onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
   
    $('#site_wide_load_msg'+load_inline).html('loading user data...');
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    //$('#site_wide_okay'+load_inline).hide(1);
    
  
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
        $.post("../ajax/get_user_data.php",{userid:id},function(dataReturn){
          // alert (dataReturn);
                  
              var obj = jQuery.parseJSON(dataReturn);
                    
              if (obj.Ack=="success"){
               
                            $('#site_wide_msg'+load_inline).html(obj.Msg);
                            $('#site_wide_load'+load_inline+glass).fadeOut(100);
                   
                   var dataArray = obj.data, new_history_item = '';
                    if(jQuery.trim($('#ub_user_results_history').html())=="<center>today's history is empty</center>"){
                       $('#ub_user_results_history').html('');
                    }
                 
                   //$('#ub_user_results_history').html($('#ub_user_results_history').html()+$('#user_box_'+id).html());
                   
                   
                   userid_for_edit = dataArray['userid'];
                   if(!inArray(history_array,dataArray['userid'])){
                      
                       history_array[array_counter] = dataArray['userid'];
                       var  optionsHistory='';
                       /*
                           if empty - div =1 and arry_c = 0 - add new div then add to that div
                           else
                               add to latest div
                                   else
                                       add next div and add to that
                                       
                                       pageBuildUp += "</div><div class='hide history_page' id='history_"+div_counter+"'>";
                                               optionsHistory += '<option value="'+div_counter+'">page '+div_counter+'</options>';
                                           
                       
                       */
                       new_history_item = $('#user_box_'+id).html().replace('ub_username_results','ub_username_history');
                       if(array_counter==0 && div_counter==1){
                           $('#ub_user_results_history').html("<div class='history_page' id='history_"+div_counter+"'></div>");
                           $('#history_'+div_counter).append(new_history_item);
                           array_counter++;
                       }
                       else{
                           if ((array_counter+1)/(div_counter*10)>1){
                                          
                                               div_counter++;
                                               $('#ub_user_results_history').append("<div class='history_page hide' id='history_"+div_counter+"'></div>");
                                               $('#history_'+div_counter).append(new_history_item);
                                               array_counter++;
                                               $('#pageLimitHistory').append('<option value="'+div_counter+'">page '+div_counter+'</options>');
   
                           }
                           else{
                               $('#history_'+div_counter).append(new_history_item);
                               array_counter++;
                           }
                       }
                       
                       
                       
                       
                      // $('#ub_user_results_history').html($('#ub_user_results_history').html()+div_ends+new_history_item+div_ends_2);
                       
                       
                   }
                   
                   $('.ub_return_to_user').show(1);
                    
                   $('#ub_username_display').html(dataArray['screenname']);
                   $('#ub_username_msg').html(dataArray['screenname']);
                   
                   $('#ub_userid_display').html(dataArray['userid']);
                   $('#ub_username_notes').html(dataArray['screenname']);
                   $('#ub_joinedate_display').html(dataArray['date_joined'].substr(0,10));
                   $('#ub_edit_name_display').html(dataArray['screenname']);
               
                   $('#ub_jointime_display').html((dataArray['date_joined']).substr(10,9));
                   
                   
                   $('#ub_country_display').html(dataArray['conname']);
                   $('#ub_lang_display').html(dataArray['language']);
                   $('#ub_browser_display').html(dataArray['browser_name']);
                   $('#ub_os_display').html(dataArray['os_name']);
    
                   $('#ub_date_join_display').html(dataArray['date_joined'].substr(0,10));
                   $('#ub_time_join_display').html(dataArray['date_joined'].substr(10,9));
                   
                   $('#ub_regip_display').html(dataArray['ipad']);
                   
                   $('#ub_date_last_display').html(dataArray['last_visit'].substr(0,10));
                   $('#ub_time_last_display').html(dataArray['last_visit'].substr(10,9));
                   
                   $('#ub_lastip_display').html(dataArray['lastip']);
                   
                    if(dataArray['contact']==1){
                      $('#ub_contact_display').html('yes');
                      new_click_events('ub_contact_display','contact',dataArray['contact'],'yes');
        
                   }
                   else{
                      $('#ub_contact_display').html('no');
                      new_click_events('ub_contact_display','contact',dataArray['contact'],'no');
                      
                   }
                   
                   
                   $('#ub_group_display').html(dataArray['groupname']);
                   
                    switch (dataArray['status_valid']){
                       
                       case '0':
                        
                           $('#ub_status_display').html('awaiting activation');
                           
                            $('#ub_status_display').css('color','#00A6C4');
                            new_click_events('ub_status_display','status',dataArray['status_valid'],'awaiting activation');
                           break;
                       case '1':
                            $('#ub_status_display').html('activated');
                            $('#ub_status_display').css('color','#63D300');
                            new_click_events('ub_status_display','status',dataArray['status_valid'],'activated');
                           break;
                       case '2':
                           $('#ub_status_display').html('banned/blocked');
                            $('#ub_status_display').css('color','#DA0303');
                            new_click_events('ub_status_display','status',dataArray['status_valid'],'banned/blocked');
                           break;
                       
                       
                       default:
                            $('#ub_status_display').html('unknown');
                            $('#ub_status_display').css('color','#666666');
                            new_click_events('ub_status_display','status',dataArray['status_valid'],'unknown');
                           break;
                   }
                   if (dataArray['useractive30']==1){
                         $('#ub_active_display').html('yes');
                         $('#ub_active_display').css('color','#63D300');
                         new_click_events('ub_active_display','active',1,'yes');
                   }
                   else{
                       $('#ub_active_display').html('no');
                         $('#ub_active_display').css('color','#DA0303');
                         new_click_events('ub_active_display','active',0,'no');
                   }
                   
                   
                   
                   $('#ub_refid_display').html(dataArray['refid']);
                   $('#ub_phone_display').html(dataArray['phone']);
                   $('#ub_email_display').html(dataArray['email']);
                 
   
                   $('#ub_url_display').html(dataArray['refurl']);
                   $('#ub_domain_display').html(dataArray['refdomain']);
                   
                   /*
                    
                    these control the images on the user details tiles
                    if you want these to operate uncomment below and look for ub_imgbox
                    in user.php and take out the 'hide' class
                    
                   var gravimg = hex_md5(dataArray['email']);
                   
                   $('#graveimg').attr('src', 'http://www.gravatar.com/avatar/' +gravimg+'.jpg');
                   $('#ub_gravimg_editor').attr('src', 'http://www.gravatar.com/avatar/' +gravimg+'.jpg');
                   $('#ub_gravimg_msg').attr('src', 'http://www.gravatar.com/avatar/' +gravimg+'.jpg');
                   */
   
                   if ($('#ub-email-content').is(':hidden')){
                       $('#ub-sms-content').hide('slide',500,function(){
                           $('#ub-email-content').show('slide',500);
                           $('#ub_email_sms_info').html('email '+$('#ub_email_display').html());
                       });
                   }
                   else{
                       $('#ub_email_sms_info').html('email '+$('#ub_email_display').html());
                   }
                 
                   
                   //change click events
   
                   new_click_events('ub_joinedate_display','regdate',(dataArray['date_joined']).substr(0,10),(dataArray['date_joined']).substr(0,10));
                   new_click_events('ub_country_display','country',dataArray['code'],dataArray['conname']);
                   new_click_events('ub_lang_display','lang',dataArray['lang_code'],dataArray['language']);
                   
                   new_click_events('ub_browser_display','browser',dataArray['browser_code'],dataArray['browser_name']);
                   new_click_events('ub_os_display','os',dataArray['os_code'],dataArray['os_name']);
                   new_click_events('ub_date_join_display','regdate',(dataArray['date_joined']).substr(0,10),(dataArray['date_joined']).substr(0,10));
                   new_click_events('ub_regip_display','regip',dataArray['ipad'],dataArray['ipad']);
                   new_click_events('ub_date_last_display','lastdate',(dataArray['last_visit']).substr(0,10),(dataArray['last_visit']).substr(0,10));
                   new_click_events('ub_lastip_display','lastip',dataArray['lastip'],dataArray['lastip']);
   
                   //new_click_events('ub_contact_display','contact',dataArray['code'],dataArray['conname']);
                   new_click_events('ub_group_display','group',dataArray['groupid'],dataArray['groupname']);
                   //new_click_events('ub_status_display','status',dataArray['code'],dataArray['conname']);
                   
                   new_click_events('ub_refid_display','refid',dataArray['refid'],dataArray['refid']);
                   new_click_events('ub_phone_display','phone',dataArray['phone'],dataArray['phone']);
                   new_click_events('ub_email_display','email',dataArray['email'],dataArray['email']);
                   new_click_events('ub_url_display','refurl',dataArray['refurl'],dataArray['refurl']);
                   new_click_events('ub_domain_display','refdomain',dataArray['refdomain'],dataArray['refdomain']);
                   
                   slider_changer("user-details","qf-pane-options");
                   
                   //hide filter release not hide here
                  // $('[id^="ub_rel"]').hide(1);
                  
                   
                   //editor
                   $('#ub_edit_name_display').val(dataArray['screenname']);
                   $('#ub_edit_username').val(dataArray['screenname']);
                   
               
                   $('#ub_edit_regdate').val(dataArray['date_joined']);
                   
               
                   $('#ub_edit_lastdate').val(dataArray['last_visit']);
                   
                   
                   $('#ub_edit_country').val(dataArray['code']);
                   $('#ub_edit_lang').val(dataArray['lang_code']);
                   $('#ub_edit_browser').val(dataArray['browser_code']);
                   $('#ub_edit_os').val(dataArray['os_code']);
    
                  
                   
                   $('#ub_edit_regip').val(dataArray['ipad']);
                   
    
                   
                   $('#ub_edit_lastip').val(dataArray['lastip']);
                   
                   $('#ub_edit_contact').val(dataArray['contact']);
                 
                   
                   
                   $('#ub_edit_group').val(dataArray['groupid']);
                   $('#ub_edit_status').val(dataArray['status_valid']);
               
                   
                   
                   
                   $('#ub_edit_refid').val(dataArray['refid']);
                   $('#ub_edit_phone').val(dataArray['phone']);
                   $('#ub_edit_email').val(dataArray['email']);
                 
   
                   $('#ub_edit_refurl').val(dataArray['refurl']);
                   $('#ub_edit_refdomain').val(dataArray['refdomain']);
                   
                   
                   //$('#ub_gravimg_editor').attr('src', 'http://www.gravatar.com/avatar/' + hex_md5(dataArray['email'])+'.jpg');
   
                  
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   //need to get authors username + userid
                   /*
                   $('#quick_user_name').html(dataArray['screenname']);
                   
                   $('#quick_username_edit').val(dataArray['screenname']);
                   
                   $('#quick_email_add').html(dataArray['email']);
                   
                   
                   
                   $('#quick_email_edit').val(dataArray['email']);
                   
                   $('#quick_phone_edit').val(dataArray['phone']);
                   $('#phone_view').html(dataArray['phone']);
                   $('#phone_data').val(dataArray['phone']);
                   
                   if(dataArray['contact']==1){
                       $('#contact_view').html('yes');
        
                   }
                   else{
                       $('#contact_view').html('no');
                      
                   }
                     $('#contact_data').val(dataArray['contact']);
                   $('#quick_contact_edit').val(dataArray['contact']);
    
                   
                   $('#since_date').html(dataArray['date_joined']);
                   $('#regdate_data').val((dataArray['date_joined']).substr(0,10));
                  
                   
                   $('#quick_grav').attr('src', 'http://www.gravatar.com/avatar/' + hex_md5(dataArray['email'])+'.jpg');
   
                   $('#userid_view').html(dataArray['userid']);
                   
                   $('#userid_edit').val(dataArray['userid']);
                   
                   $('#regip_view').html(dataArray['ipad']);
                   $('#regip_data').val(dataArray['ipad']);
                   
                   //$('#regip_view_clickable').attr('onclick',"clickSearchables(7,'"+dataArray['ipad']+"','')");
               
                   //clickSearchables(7,'"+dataArray['ipad']+"','')
                   
                   
                   $('#lastvisit_view').html(dataArray['last_visit']);
                   $('#lastvisit_data').val((dataArray['last_visit']).substr(0,10));
                   
                   $('#lastip_view').html(dataArray['lastip']);
                   $('#lastip_data').val(dataArray['lastip']);
                   
                   $('#lang_view').html(dataArray['language']);
                   $('#lang_data').val(dataArray['lang_code']);
                   
                   $('#quick_lang_edit').val(dataArray['lang_code']);
                   //$('#lang_data').val(dataArray['lang_code']);
                   $('#quick_status_edit').val(dataArray['status_valid']);
                   $('#status_data').val(dataArray['status_valid']);
                   switch (dataArray['status_valid']){
                       
                       case '0':
                           $('#status_view').html('awaiting activation');
                           
                            $('#status_view').css('color','#00A6C4');
                           break;
                       case '1':
                            $('#status_view').html('activated');
                            $('#status_view').css('color','#63D300');
                           break;
                       case '2':
                           $('#status_view').html('banned/blocked');
                            $('#status_view').css('color','#DA0303');
                           break;
                       
                       
                       default:
                            $('#status_view').html('unknown');
                            $('#status_view').css('color','#666666');
                           break;
                   }
                   if (dataArray['useractive30']==1){
                         $('#active_view').html('yes');
                         $('#active_view').css('color','#63D300');
                   }
                   else{
                       $('#active_view').html('no');
                         $('#active_view').css('color','#DA0303');
                   }
                   
                   $('#group_view').html(dataArray['groupname']);
                   $('#quick_groups_edit').val(dataArray['groupid']);
                   $('#group_data').val(dataArray['groupid']);
                   $('#refid_view').html(dataArray['refid']);
                   $('#refid_data').val(dataArray['refid']);
                   
                   $('#refurl_view').html(dataArray['refurl']);
                   $('#refurl_data').val(dataArray['refurl']);
                   
                   
                   $('#refdomain_data').val(dataArray['refdomain']);
                   
                   $('#refurl_view').attr('href', dataArray['refurl']);
                   
                   $('#quick_refid_edit').val(dataArray['refid']);
                   $('#quick_refurl_edit').val(dataArray['refurl']);
                   
                   $('#os_view').html(dataArray['os_name']);
                   $('#quick_os_edit').val(dataArray['os_code']);
                   $('#os_data').val(dataArray['os_code']);
                   $('#browser_view').html(dataArray['browser_name']);
                   $('#quick_browser_edit').val(dataArray['browser_code']);
                   $('#browser_data').val(dataArray['browser_code']);
                   
                   $('#quick_country_edit').val(dataArray['code']);
                   $('#loc_view').html(nameCap(dataArray['conname']));
                   $('#country_data').val(dataArray['code']);
                   
                  $('#selectUserTitle').slideUp(400,function(){
                   $('#quickinfo').show(1);
                   $('#quickdetails').fadeIn(300);
                       $('#quickpic').fadeIn(300);
                   $('#view_quick_info').slideDown(400,function(){
                       
                       
                       $('#user_notes_info').show(1);
                       $('#seperator_notes_filter').show(1);
                       
                   });
                   
               
               
                   });
                   
                   
                   //getUserNotes();
                   $('#savenoteresponse').html('');
                   $('#note_add').val('');
                   $('#notesresults_user_quick').html('');
                   
                   //date_joined
                   
                   */
              }
              else{
               //  alert('fail');
                    
                    $('#site_wide_msg'+load_inline).html(obj.Msg);
                            $('#site_wide_load'+load_inline+glass).fadeOut(100,function(){
                                $('#site_wide_msg'+load_inline).show(1);
                            }); 
                   $('#ub_username_display').html(obj.Msg);
                   $('#ub_joinedate_display').html(' forever');
                   //$('#userid_edit').val(0);
                   userid_for_edit=0;
                   
   
                   
                   
                   
   
                   
   
              }
                   
       });
    });
    });

}

function getLists(country,browser,os,lang,group,refresh){
    
    country     = country?true:false;
    browser     = browser?true:false;
    os          = os?true:false;
    lang        = lang?true:false;
    group       = group?true:false;
    
     $.post("../ajax/get_user_lists.php",{country:country,
                                          browser:browser,
                                          os:os,
                                          lang:lang,
                                          group:group},function(dataReturn){
                            
                            
            var obj = jQuery.parseJSON(dataReturn);
            
            if (obj.countryAck=='success'){
                //need to get array out and loop through
                
                var countryArray = obj.countryData;
                var countrySelect = '<option value="-9">Select Country</option>';

                for (x in countryArray){
                    
                    
                    countrySelect += '<option value="'+countryArray[x]['code']+'">'+nameCap(countryArray[x]['name'])+'</option>\n';
                    
                }
                $('#ub_search_country').html(countrySelect);
                $('#ub_edit_country').html(countrySelect);
                $('#ub_add_country').html(countrySelect);
            }
            else{
		if(refresh==undefined || refresh == false || jQuery.trim(refresh) ==''){
		    $('#ub_search_country').html('<option value="-9">error loading list</option>');
		    $('#ub_edit_country').html('<option value="-9">error loading list</option>');
		    $('#ub_add_country').html('<option value="-9">error loading list</option>');
		}
                //$('#lists_country').html(': error loading list');
            }
                
                
            if (obj.browserAck=='success'){
                var browserArray = obj.browserData;
                var browserSelect = '<option value="-9">Select Browser</option>';
                for (x in browserArray){
                    
                    browserSelect += '<option value="'+browserArray[x]['browser_code']+'">'+browserArray[x]['browser_name']+'</option>\n';
                    
                }
                
                $('#ub_search_browser').html(browserSelect);
                $('#ub_edit_browser').html(browserSelect);
                $('#ub_add_browser').html(browserSelect);
            }
            else{
		if(refresh==undefined || refresh == false || jQuery.trim(refresh) ==''){
		    $('#ub_search_browser').html('<option value="-9">error loading list</option>');
		    $('#ub_edit_browser').html('<option value="-9">error loading list</option>');
		    $('#ub_add_browser').html('<option value="-9">error loading list</option>');
		}
                 //$('#lists_browser').html(': error loading list');
            }
            
            if (obj.osAck=='success'){
                var osArray = obj.osData;
                var osSelect = '<option value="-9">Select OS</option>';
                for (x in osArray){
                    
                    osSelect += '<option value="'+osArray[x]['OS_code']+'">'+osArray[x]['OS_name']+'</option>\n';
                    
                }
                $('#ub_search_os').html(osSelect);
                $('#ub_edit_os').html(osSelect);
                $('#ub_add_os').html(osSelect);
             }
             else{
		if(refresh==undefined || refresh == false || jQuery.trim(refresh) ==''){
		    $('#ub_search_os').html('<option value="-9">error loading list</option>');
		    $('#ub_edit_os').html('<option value="-9">error loading list</option>');
		    $('#ub_add_os').html('<option value="-9">error loading list</option>');
		}
               // $('#lists_os').html(': error loading list');
             }
             
            if (obj.langAck=='success'){
                var langArray = obj.langData;
                var langSelect = '<option value="-9">Select Language</option>';
                for (x in langArray){
                    
                    langSelect += '<option value="'+langArray[x]['lang_code']+'">'+langArray[x]['language']+'</option>\n';
                    
                }
                $('#ub_search_lang').html(langSelect);
                $('#ub_edit_lang').html(langSelect);
                $('#ub_add_lang').html(langSelect);
             }
             else{
		if(refresh==undefined || refresh == false || jQuery.trim(refresh) ==''){
		    $('#ub_search_lang').html('<option value="-9">error loading list</option>');
		    $('#ub_edit_lang').html('<option value="-9">error loading list</option>');
		    $('#ub_add_lang').html('<option value="-9">error loading list</option>');
		}
                //$('#lists_lang').html(': error loading list');
             }
             
             if (obj.groupAck=='success'){
                var groupArray = obj.groupData;
                var groupSelect = '<option value="-9">Select usergroup</option>';
                var groupSelect_add_edit = '';
                for (x in groupArray){
                    groupSelect_add_edit += '<option value="'+groupArray[x]['groupid']+'">'+groupArray[x]['name']+'</option>\n';
                    groupSelect += '<option value="'+groupArray[x]['groupid']+'">'+nameCap(groupArray[x]['name'])+'</option>\n';
                    
                }
         
                $('#ub_search_group').html(groupSelect);
                $('#ub_edit_group').html(groupSelect_add_edit);
                $('#ub_add_group').html(groupSelect_add_edit);
		
		//need to keep current selections
		if(refresh){
		    $('#ub_search_group').val(unibody_current_groups['search_list']);
		    $('#ub_edit_group').val(unibody_current_groups['edit_list']);
		    $('#ub_add_group').val(unibody_current_groups['add_list']);
		}
		
                //$('#groups_add').html(groupSelect_add_edit);
             }else{
		if(refresh==undefined || refresh == false || jQuery.trim(refresh) ==''){
		    $('#ub_search_group').html('<option value="-9">error loading list</option>');
		    $('#ub_edit_group').html('<option value="-9">error loading list</option>');
		    $('#ub_add_group').html('<option value="-9">error loading list</option>');
		}
                
                //$('#quick_groups_edit').html('<option value="-9">error loading list</option>');
                //$('#groups_add').html('<option value="-9">error loading list</option>');
               // $('#lists_groups').html(': error loading list');
             }
            
            
            
                        
     });
    
}






function saveEditUser(){
    
    var regip,regdate,lastdate,lastip,refdomaineditid,emailedit,groupsedit,usernameedit,passwordedit, countryedit,languageedit,statusedit,refidedit,refurledit,osedit,browseredit, phoneedit, contactedit;
    $('div.ub_input_warnings').qtip('destroy');
    $('#saveresponse').html('');
    
    
    id              = userid_for_edit;
    
    emailedit       = $('#ub_edit_email').val();

    groupsedit      = $('#ub_edit_group').val();

    usernameedit    = $('#ub_edit_username').val();
  
    passwordedit    = $('#ub_edit_pass').val();
  
    countryedit     = $('#ub_edit_country').val();
  
    languageedit    = $('#ub_edit_lang').val();
  
    statusedit      = $('#ub_edit_status').val();
  
    refidedit       = $('#ub_edit_refid').val();
  
    refurledit      = $('#ub_edit_refurl').val();
    
        refdomainedit   = $('#ub_edit_refdomain').val();
    
        regip           = $('#ub_edit_regip').val();
    
        regdate         = $('#ub_edit_regdate').val();
        
        lastip          = $('#ub_edit_lastip').val();
    
        lastdate        = $('#ub_edit_lastdate').val();
    
    browseredit     = $('#ub_edit_browser').val();
  
    osedit          = $('#ub_edit_os').val();
    
    phoneedit       = $('#ub_edit_phone').val();
  
    contactedit     = $('#ub_edit_contact').val();
    
    

    
    if (passwordedit==''){
        passwordedit='false';
       
    }
    else{
        passwordedit = hex_md5(passwordedit) ; //hash this with hex
    }
    
    if (id!=0){
      var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    //$('#site_wide_okay'+load_inline).hide(1);
    $('#site_wide_load_msg'+load_inline).html('saving changes...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
                
            
           
           
                    $.post("../ajax/save_edit_user.php",{userid:id,
                                                         username:usernameedit,
                                                         group:groupsedit,
                                                         email:emailedit,
                                                         password:passwordedit,
                                                         country:countryedit,
                                                         status:statusedit,
                                                         lang:languageedit,
                                                         refid:refidedit,
                                                         refurl:refurledit,
                                                         os:osedit,
                                                         browser:browseredit,
                                                         contact:contactedit,
                                                         phone:phoneedit,
                                                         refdomain:refdomainedit,
                                                         regip:regip,
                                                         regdate:regdate,
                                                         lastip:lastip,
                                                         lastdate:lastdate
                                                         },function(dataReturn){
                            
                            
                            
                            var obj = jQuery.parseJSON(dataReturn);
                                   // alert(obj.Msg);
                                   
                                  $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                                    });
                                   
                                  
                                   
                                   
                            if (obj.Ack=="success"){
                              
                                 
                              
                                 //$('#saveresponse').html(obj.Msg);
                                //$("#quick_groups_edit option:selected").text()
                                 $('div.ub_edit_warn > img').attr('src','../images/blank.gif');
                                 $('div.ub_edit_warn > img').attr('title','');
                                    
                                
                                    
                                //need to reset all details changed  + usernames + in results box
                                
                                //$('#ub_username_display_'+userid_for_edit).html(makeTextSmall(usernameedit,18));
                                $('#ub_username_results_'+userid_for_edit).html(makeTextSmall(usernameedit,18));
                                $('#ub_username_history_'+userid_for_edit).html(makeTextSmall(usernameedit,18));
				

				//$('#ub_username_qtipx_'+userid_for_edit).html(usernameedit);
                            $('#ub_regdate_display_'+userid_for_edit).html(regdate.substr(0,10));
                                
                            
                                $('#ub_reg_time_display_'+userid_for_edit).html((regdate).substr(10,9));
                                $('#ub_regip_display_'+userid_for_edit).html(regip);
                                $('#ub_lastip_display_'+userid_for_edit).html(lastip);
                                
                                $('#ub_lastdate_display_'+userid_for_edit).html(lastdate.substr(0,10));
                                
                            
                                $('#ub_last_time_display_'+userid_for_edit).html((lastdate).substr(10,9));
                                
                                $('#ub_country_display_'+userid_for_edit).html($("#ub_edit_country option:selected").text());
                                $('#ub_country_'+userid_for_edit).html($("#ub_edit_country option:selected").text());
                                
                                
                                
                                
                                $('#ub_username_display').html(usernameedit);
                               $('#ub_edit_name_display').html(usernameedit);
                                $('#ub_username_msg').html(usernameedit);
                                $('#ub_joinedate_display').html(regdate.substr(0,10));
                                
                            
                                $('#ub_jointime_display').html((regdate).substr(10,9));
                                
                                
                                $('#ub_country_display').html($("#ub_edit_country option:selected").text());
                                
                                $('#ub_lang_display').html($("#ub_edit_lang option:selected").text());
                                $('#ub_browser_display').html($("#ub_edit_browser option:selected").text());
                                $('#ub_os_display').html($("#ub_edit_os option:selected").text());
                 
                                $('#ub_date_join_display').html(regdate.substr(0,10));
                                $('#ub_time_join_display').html(regdate.substr(10,9));
                                
                                $('#ub_regip_display').html(regip);
                                
                                $('#ub_date_last_display').html(lastdate.substr(0,10));
                                $('#ub_time_last_display').html(lastdate.substr(10,9));
                                
                                $('#ub_lastip_display').html(lastip);
                          
                                 if(contactedit==1){
                                   $('#ub_contact_display').html('yes');
                                   new_click_events('ub_contact_display','contact',contactedit,'yes');
                     
                                }
                                else{
                                   $('#ub_contact_display').html('no');
                                   new_click_events('ub_contact_display','contact',contactedit,'no');
                                   
                                }
                                
                          
                                $('#ub_group_display').html($("#ub_edit_group option:selected").text());
                                
                                 switch (statusedit){
                                    
                                    case '0':
                                     
                                        $('#ub_status_display').html('awaiting activation');
                                        
                                         $('#ub_status_display').css('color','#00A6C4');
                                         new_click_events('ub_status_display','status',statusedit,'awaiting activation');
                                        break;
                                    case '1':
                                         $('#ub_status_display').html('activated');
                                         $('#ub_status_display').css('color','#63D300');
                                         new_click_events('ub_status_display','status',statusedit,'activated');
                                        break;
                                    case '2':
                                        $('#ub_status_display').html('banned/blocked');
                                         $('#ub_status_display').css('color','#DA0303');
                                         new_click_events('ub_status_display','status',statusedit,'banned/blocked');
                                        break;
                                    
                                    
                                    default:
                                         $('#ub_status_display').html('unknown');
                                         $('#ub_status_display').css('color','#666666');
                                         new_click_events('ub_status_display','status',statusedit,'unknown');
                                        break;
                                }
                                
                                
                                
                                
                                $('#ub_refid_display').html(refidedit);
                                $('#ub_phone_display').html(phoneedit);
                                $('#ub_email_display').html(emailedit);
                              
                
                                $('#ub_url_display').html(refurledit);
                                $('#ub_domain_display').html(refdomainedit);
                                /*
				 changing images not used anymore - refresh hack didn't work
                                //var timestamp = new Date().getTime();
     		
                                var gravimg = hex_md5(dataArray['email']);
           
                                $('#graveimg').attr('src', 'http://www.gravatar.com/avatar/' +gravimg+'.jpg');
                                $('#ub_gravimg_editor').attr('src', 'http://www.gravatar.com/avatar/' +gravimg+'.jpg');
                                $('#ub_gravimg_msg').attr('src', 'http://www.gravatar.com/avatar/' +gravimg+'.jpg');
                                
                                //$('#graveimg').attr('src', 'http://www.gravatar.com/avatar/' + hex_md5(emailedit)+'.jpg');
				*/
                                if ($('#ub-email-content').is(':hidden')){
                                    $('#ub-sms-content').hide('slide',500,function(){
                                        $('#ub-email-content').show('slide',500);
                                        $('#ub_email_sms_info').html('email '+$('#ub_email_display').html());
                                    });
                                }
                                else{
                                    $('#ub_email_sms_info').html('email '+$('#ub_email_display').html());
                                }
                              
                                
                                //change click events
                
                                new_click_events('ub_joinedate_display','regdate',(regdate).substr(0,10),(regdate).substr(0,10));
                                new_click_events('ub_country_display','country',countryedit,$("#ub_edit_country option:selected").text());
				
                                new_click_events('ub_lang_display','lang',languageedit,$("#ub_edit_lang option:selected").text());
                                
                                new_click_events('ub_browser_display','browser',browseredit,$("#ub_edit_browser option:selected").text());
                                new_click_events('ub_os_display','os',osedit,$("#ub_edit_os option:selected").text());
                                new_click_events('ub_date_join_display','regdate',(regdate).substr(0,10),(regdate).substr(0,10));
                                new_click_events('ub_regip_display','regip',regip,regip);
                                new_click_events('ub_date_last_display','lastdate',(lastdate).substr(0,10),(lastdate).substr(0,10));
                                new_click_events('ub_lastip_display','lastip',lastip,lastip);
                
                                //new_click_events('ub_contact_display','contact',dataArray['code'],dataArray['conname']);
                                new_click_events('ub_group_display','group',groupsedit,$("#ub_edit_group option:selected").text());
                                //new_click_events('ub_status_display','status',dataArray['code'],dataArray['conname']);
                                
                                new_click_events('ub_refid_display','refid',refidedit,refidedit);
                                new_click_events('ub_phone_display','phone',phoneedit,phoneedit);
                                new_click_events('ub_email_display','email',emailedit,emailedit);
                                new_click_events('ub_url_display','refurl',refurledit,refurledit);
                                new_click_events('ub_domain_display','refdomain',refdomainedit,refdomainedit);
                                
                                 
                                
                           
                            }
                            else{
                                
                                 if (obj.Ack=="fail"){
                            
                                    //$('ub_save_edit_button').attr('title',obj.Msg);
                                     
                                 
                                 
                                }
                                else if (obj.Ack=="validationFail"){
                                      
                                    var valdata = obj.validationdata, otherflag=false;;
                                    
                                    if (valdata.usernameAck=='fail'){
                                        $('#ub_input_edit_img_username').attr('src','../images/alert.gif');
                                        $('#ub_input_edit_img_username').parent('.ub_input_warnings').attr('title',valdata.usernameMsg);
                                        otherflag=true;
                                    }
                                    else{
                                        $('#ub_input_edit_img_username').attr('src','../images/blank.gif');
                                        $('#ub_input_edit_img_username').parent('.ub_input_warnings').attr('title','');
                                    }
                                    
                                    if (valdata.emailAck=='fail'){
                                        $('#ub_input_edit_img_email').attr('src','../images/alert.gif');
                                        $('#ub_input_edit_img_email').parent('.ub_input_warnings').attr('title',valdata.emailMsg);
                                        otherflag=true;
                                    }
                                    else{
                                        $('#ub_input_edit_img_email').attr('src','../images/blank.gif');
                                        $('#ub_input_edit_img_email').parent('.ub_input_warnings').attr('title','');
                                    }
                                    
                                    if (valdata.regdateAck=='fail'){
                                        $('#ub_input_edit_img_regdate').attr('src','../images/alert.gif');
                                        $('#ub_input_edit_img_regdate').parent('.ub_input_warnings').attr('title',valdata.regdateMsg);
                                        otherflag=true;
                                    }
                                    else{
                                        $('#ub_input_edit_img_regdate').attr('src','../images/blank.gif');
                                        $('#ub_input_edit_img_regdate').parent('.ub_input_warnings').attr('title','');
                                    }
                                    
                                    if (valdata.lastdateAck=='fail'){
                                        $('#ub_input_edit_img_lastdate').attr('src','../images/alert.gif');
                                        $('#ub_input_edit_img_lastdate').parent('.ub_input_warnings').attr('title',valdata.lastdateMsg);
                                        otherflag=true;
                                    }
                                    else{
                                        $('#ub_input_edit_img_lastdate').attr('src','../images/blank.gif');
                                        $('#ub_input_edit_img_lastdate').parent('.ub_input_warnings').attr('title','');
                                    }
                                    
                                    if (!otherflag && valdata.otherAck=='fail' ){
                                        //need to change button types as per design
                                        
                                        $('#ub_save_edit_button').attr('title',valdata.otherMsg);
                                      
                                        
                                        
                                    }
                                    
                                  
                                    $('div.ub_input_warnings').qtip({content: {attr: 'title'},
                                                                    
                                    style:{
                                        
                                        tip: { offset: 5 }
                                     },
                                     position: {
                                     
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
				      show: {
					     event: false,
					     ready: true
					  },
					  hide: false
                                     });
                                   
                                   
                                   
                                }
                            }
                           
                           
                            
                    
                    });
 
             });
     });
    }
    else{
        $('#saveresponse').html('no record found');
    }
}




function addUserNote_QV(){
    
    var notes = $('#note_add').val();
    var id = $('#userid_edit').val();

    if (id!=0){

            $('#small_note_loader').fadeIn(100, function(){
                
                $.post("../ajax/save_add_notes.php",{note:notes,userid:id} , function(dataReturn){
                    
                    var obj = jQuery.parseJSON(dataReturn);
                             
                         
                             
                        if (obj.Ack=="success"){
                           
                            $('#savenoteresponse').html(obj.Msg);
                            getUserNotes();
                            //make new note hidden till show?
                        }
                        else{
                            var validationData = obj.validationdata;
                            if (validationData.noteAck=='fail'){
                                $('#savenoteresponse').html(validationData.noteMsg);
                            }
                            else if(validationData.useridAck=='fail') {
                                $('#savenoteresponse').html(validationData.useridMsg);
                            }
                            else{
                                $('#savenoteresponse').html(obj.Msg);
                            }
                        }
                        
                        $('#small_note_loader').fadeOut(100);
                
                });
                
            });
            
       
    }
    else{
        $('#savenoteresponse').html('page to attach this note not found');
    }
    
}

function addUserNote(){
    
    
    
   

    var notes = $('#ub_add_note').val();
    
    if (notes==''){
        //do nothing
        return false;
    }

    if (userid_for_edit!=0){

            
                
                $.post("../ajax/save_add_notes.php",{note:notes,userid:userid_for_edit} , function(dataReturn){
                    
                    var obj = jQuery.parseJSON(dataReturn);
                             
                         
                             
                        if (obj.Ack=="success"){
                           
                            
                            getUserNotes();
                            //make new note hidden till show?
                        }
                        else{
                            //meh, do anything here?
                            
                            
                        }
                        
                        
                
                });
                
          
            
       
    }
    else{
        //do nothing
    }
    
}

function deleteUserShow(response){
    
    
    
    var id = userid_for_edit;
   if (userid_for_edit!=0){
    $('#delete_msg').html('').hide(1);
    $('#delete_user_loader').fadeIn(100,function(){
    
                    $.post("../ajax/delete_user.php",{userid:id} , function(dataReturn){
                        
                                var obj = jQuery.parseJSON(dataReturn);
                                
                                  
                                if (obj.Ack=="success"){
                                    
                                     $('#delete_msg').html(obj.Msg);
                                     $('#delete_user_'+id).hide(1);
				     userid_for_edit=0;
                                }
                                else{
                                     $('#delete_msg').html(obj.Msg);
                                }
                              $('#delete_user_loader').fadeOut(100,function(){
                                $('#delete_msg').show(1);
                                });
                               //$.facebox.close();
                    });
         });   
      
   }
    
}

function showUserFilters(){
       
       if($('#show_filters_block_detailed').is(':hidden')){
        
            $('#show_filters_block_detailed').slideDown(400);
            $('#showfilters').html('hide search filters');
       }
       else{
            $('#show_filters_block_detailed').slideUp(400);
            $('#showfilters').html('show search filters');
       }
       

}

function showUserNotes(id){
    closeAllBox();
        $('#view_notes_user').css("position","absolute");
        $('#view_notes_user').css("top", ( $(window).height() - $('#view_notes_user').outerHeight() ) / 2+$(window).scrollTop() + "px");
        $('#view_notes_user').css("left", ( $(window).width() - $('#view_notes_user').outerWidth() ) / 2+$(window).scrollLeft() + "px");
        $('#view_notes_user').fadeIn(509);
        $('#savenoteresponse').html('');
        getUserNotes(id);
}


function scrollTrack(){
    if ($(window).scrollTop()>50){
        return true;
    }
    else{
        return false;
    }
}



function getUserNotes(){
    
    
    
                
                
       
        
        
     
       
    
    
    
    $('#notes_results').html("<br/><center><img src='../images/loader/bl_g.gif'/><br/>searching for notes...</center>");
    
    
                $.post("../ajax/get_note_data.php",{userid:userid_for_edit} , function(dataReturn){
                
                        var obj = jQuery.parseJSON(dataReturn);
                             
                         
                             
                        if (obj.Ack=="success"){
                           
                            
                            
                    
                                
                                var dataArray = obj.data;
                                var pageBuildUp = '';
                               
                                for (x in dataArray){
                                   
                                    pageBuildUp += obj.note_repeater;
                                    pageBuildUp = pageBuildUp.replace(/##screenname##/gi,dataArray[x]['screenname']);
                                    pageBuildUp = pageBuildUp.replace(/##dateposted##/gi,dataArray[x]['postdate']);
                                    pageBuildUp = pageBuildUp.replace('##notecontent##',dataArray[x]['note']);
                                    pageBuildUp = pageBuildUp.replace(/##noteid##/gi,dataArray[x]['noteid']);
                                    
                                    
                                    
                                   
                                }
                               
                                    $('#notes_results').html(pageBuildUp);
                                 
                                    $('.ub_corners').corner('5px');
                                       $('#notes_results').fadeIn(500);
                               $('.notes').bind('mouseover',function(event){
                    
                                         $(this).css({'background-color':'#fff'});
                                                 
                     
                             });
                             $('.notes').bind('mouseout',function(event){
                    
                                         $(this).css({'background-color':'#fAFAFA'});
                                                 
                     
                             });
                                
                                
                           
                           
                            
                            
                        }else{
                            $('#notes_results').html('<br/><center>'+obj.Msg+'</center>');
                            
                            
                        }
                        
                });
    

}



function getUserNotes_QV(){
   
    $('#notesresults_user_quick').html('loading...');
    var id = $('#userid_edit').val();
    
        $('#small_note_loader').fadeIn(100, function(){
                    $.post("../ajax/get_note_data.php",{userid:id} , function(dataReturn){
                    
                            var obj = jQuery.parseJSON(dataReturn);
                                 
                             
                                 
                            if (obj.Ack=="success"){
                               
                                
                                
                                $.post("../ajax/note_repeater.php",{pageid:id} , function(pageRepeater){
                                    
                                    var dataArray = obj.data;
                                    var pageBuildUp = '';
                                    var countPages = 0;
                                    for (x in dataArray){
                                        
                                        pageBuildUp += pageRepeater;
                                        pageBuildUp = pageBuildUp.replace(/##screenname##/gi,dataArray[x]['screenname']);
                                        pageBuildUp = pageBuildUp.replace(/##dateposted##/gi,dataArray[x]['postdate']);
                                        pageBuildUp = pageBuildUp.replace('##notecontent##',dataArray[x]['note']);
                                        pageBuildUp = pageBuildUp.replace(/##noteid##/gi,dataArray[x]['noteid']);
                                        
                                        
                                        
                                        countPages++;
                                    }
                                    $('#notesresults_user_quick').fadeOut(500,function(){
                                        $('#notesresults_user_quick').html(pageBuildUp);
                                        $('#notesresults_user_quick').fadeIn(500);
                                    });
                                    
                                    
                                });
                               
                                
                                
                            }else{
                                $('#notesresults_user_quick').html(obj.Msg);
                                
                                
                            }
                            //$('#notes_pageid').val(id);
                           $('#small_note_loader').fadeOut(100);
                    });
        
        });
        
}
function userPagation_QV (source){
    //need a way to know what the search criteria was
    if (source==1){
        var limiter = '0,'+pagationLength_QV;
    }
    else{
        var newLimit = $('#pageLimit').val();
        // $('#pageLimit').val(Number(newLimit)+1);
         //alert(newLimit);
         newLimit = newLimit*10;
         
         var start = (newLimit-1)+1;
         
         if (start<0){
             start = 0;
         }
         
         var limiter = start+',10';
    }
    
    //alert(limiter);
    searchUser_QV(limiter,1);
    
    
    //get search criteria
    
    
}


var filterFlag = false;
function releaseUserFilter_QV(searchType){
    

    
   
    
    $('#quick_search_usergroup').val(-9);
    $('#quick_search_country').val(-9);
    $('#quick_search_browser').val(-9);
    $('#quick_search_os').val(-9);
    $('#quick_search_status').val(-9);
    $('#quick_search_language').val(-9);
    $('#orderby_quick').val(0);
    
    $('#order_direction').val(0);
    $('#quick_search_username').val('');
    $('#quick_search_userid').val('');
    //when someone clicks through from dashboard - then releases the filter
    specialUserIDFilter=2;
    
    $('#quick_search_email').val('');
    
    $('#quick_search_ipad').val('');
    $('#quick_search_lastvisit').val('');
    $('#quick_search_lastip').val('');
    $('#quick_search_regdate').val('');
    $('#quick_search_refurl').val('');
    $('#quick_search_refid').val('');
    $('#quick_search_refdomain').val('');
    
    $('#quick_search_phone').val('');
    $('#quick_search_contact').val(-9);
    //todo: use better jquery selector to make this easier
    
    $('span[id$="filter_text"]').html('');
    $('a[id$="filter_release"]').hide(0);
    $('a[id$="filter_release"]').css('display','none');
    //hide the release texts too!
    
    $('#release_filter').fadeOut(100);
   
    filterFlag = false;
     if (searchType==1){
        searchUser('0,'+pagtionLength,1);
    }
    else{
        searchUser_QV('0,'+pagationLength_QV,1);
    }
    
    
}

function releaseIndividualFilters(filterNumber,searchType){
    var source;
    switch (filterNumber){
        
        case 1:
            //country
            $('#quick_search_country').val(-9);
            $('#country_filter_text').html('');
            $('#country_filter_release').hide(1);
            break;
        case 2:
            $('#quick_search_usergroup').val(-9);
            $('#group_filter_text').html('');
            $('#group_filter_release').hide(1);
            break;
        case 3:
            $('#quick_search_browser').val(-9);
            $('#browser_filter_text').html('');
            $('#browser_filter_release').hide(1);
            break;
        case 4:
            $('#quick_search_os').val(-9);
            $('#os_filter_text').html('');
            $('#os_filter_release').hide(1);
            break;
        case 5:
            $('#quick_search_status').val(-9);
            $('#status_filter_text').html('');
            $('#status_filter_release').hide(1);
            break;
        case 6:
            $('#quick_search_language').val(-9);
            $('#lang_filter_text').html('');
            $('#lang_filter_release').hide(1);
            break;
        case 7:
            $('#quick_search_ipad').val('');
            $('#regip_filter_text').html('');
            $('#regip_filter_release').hide(1);
            break;
        case 8:
            $('#quick_search_lastvisit').val('');
            $('#lastdate_filter_text').html('');
            $('#lastdate_filter_release').hide(1);
            
            break;
        case 9:
            $('#quick_search_regdate').val('');
            $('#regdate_filter_text').html('');
            $('#regdate_filter_release').hide(1);
            break;
        case 10:
            $('#quick_search_refurl').val('');
            $('#refurl_filter_text').html('');
            $('#refurl_filter_release').hide(1);
            break;
        case 11:
            $('#quick_search_refid').val('');
            $('#refid_filter_text').html('');
            $('#refid_filter_release').hide(1);
            break;
        case 12:
            $('#quick_search_lastip').val('');
            $('#lastip_filter_text').html('');
            $('#lastip_filter_release').hide(1);
            break;
        case 13:
            $('#quick_search_username').val('');
            $('#username_filter_text').html('');
            $('#username_filter_release').hide(1);
            break;
        case 14:
            $('#quick_search_email').val('');
            $('#email_filter_text').html('');
            $('#email_filter_release').hide(1);
            break;
         case 15:
            $('#quick_search_refdomain').val('');
            $('#refdomain_filter_text').html('');
            $('#refdomain_filter_release').hide(1);
            break;
        case 16:
            $('#quick_search_userid').val('');
            $('#userid_filter_text').html('');
            $('#userid_filter_release').hide(1);
            specialUserIDFilter=2;
           
           
            break;
        case 17:
            $('#quick_search_phone').val('');
            $('#phone_filter_text').html('');
            $('#phone_filter_release').hide(1);
            break;
        case 18:
            $('#quick_search_contact').val(-9);
            $('#contact_filter_text').html('');
            $('#contact_filter_release').hide(1);
            break;
        default:
        
         
            //put everything to blank?
            $('#quick_search_usergroup').val(-9);
            $('#quick_search_country').val(-9);
            $('#quick_search_browser').val(-9);
            $('#quick_search_os').val(-9);
            $('#quick_search_status').val(-9);
            $('#quick_search_language').val(-9);
            $('#orderby_quick').val(0);
            
            $('#order_direction').val(0);
            
            $('#quick_search_userid').val('');
            specialUserIDFilter = 2;
            $('#quick_search_username').val('');
            
            $('#quick_search_email').val('');
            
            $('#quick_search_ipad').val('');
            $('#quick_search_lastvisit').val('');
            $('#quick_search_lastip').val('');
            $('#quick_search_regdate').val('');
            $('#quick_search_refurl').val('');
            $('#quick_search_refid').val('');
            
            $('#quick_search_phone').val('');
            $('#quick_search_contact').val(-9);
            
            
            $('#release_filter').hide(1);
          
            break;
        
    }
    
    
    
    if ($('a[id$="filter_release"]:hidden').length+1 == $('a[id$="filter_release"]').length){
        $('#release_filter').hide(1);
        source=1;
       
    }
    else{
        source=2;
    }
    
    if (searchType==1){
        searchUser('0,'+pagtionLength,source);
    }
    else{
        searchUser_QV('0,'+pagationLength_QV,source);
    }
    
}




function clickSearchables(clickType,searchValue,displayName){
    //change clickType in to normal text eg '1' = 'country' for easier programming.
    switch (clickType){
        
        case 1:
            //country
            $('#quick_search_country').val(searchValue);
            $('#country_filter_text').html(displayName);
            $('#country_filter_release').show(1);
            break;
        case 2:
            $('#quick_search_usergroup').val($('#group_data').val());
            $('#group_filter_text').html($('#group_data').val());
            $('#group_filter_release').show(1);
            break;
        case 3:
            $('#quick_search_browser').val($('#browser_data').val());
            $('#browser_filter_text').html($('#browser_data').val());
            $('#browser_filter_release').show(1);
            break;
        case 4:
            //alert($('#os_data').val());
            $('#quick_search_os').val($('#os_data').val());
            $('#os_filter_text').html($('#os_data').val());
            $('#os_filter_release').show(1);
            break;
        case 5:
            $('#quick_search_status').val(searchValue);
            $('#status_filter_text').html(searchValue);
            $('#status_filter_release').show(1);
            break;
        case 6:
            $('#quick_search_language').val($('#lang_data').val());
            $('#lang_filter_text').html($('#lang_data').val());
            $('#lang_filter_release').show(1);
            break;
        case 7:
           
            //todo: workout why changing attr 'onclick' in jquery would not work/function 
            $('#quick_search_ipad').val($('#regip_data').val());
            $('#regip_filter_text').html($('#regip_data').val());
            $('#regip_filter_release').show(1);
            
              
            
            break;
        case 8:
            $('#quick_search_lastvisit').val(searchValue);
            $('#lastdate_filter_text').html(searchValue);
            $('#lastdate_filter_release').show(1);
            break;
        case 9:
            $('#quick_search_regdate').val($('#regdate_data').val());
            $('#regdate_filter_text').html($('#regdate_data').val());
            $('#regdate_filter_release').show(1);
            break;
        case 10:
            $('#quick_search_refurl').val($('#refurl_data').val());
            $('#refurl_filter_text').html(($('#refurl_data').val()).substr(0,15));
            $('#refurl_filter_text').attr('title',$('#refurl_data').val());
            $('#refurl_filter_release').show(1);
            
            break;
        case 11:
            $('#quick_search_refid').val($('#refid_data').val());
            $('#refid_filter_text').html($('#refid_data').val());
            $('#refid_filter_release').show(1);
            break;
        case 12:
            $('#quick_search_lastip').val(searchValue);
            $('#lastip_filter_text').html(searchValue);
            $('#lastip_filter_release').show(1);
            break;
        case 13:
            $('#quick_search_lastvisit').val($('#lastvisit_data').val());
            $('#lastdate_filter_text').html($('#lastvisit_data').val());
            $('#lastdate_filter_release').show(1);
            break;
        case 14:
            $('#quick_search_lastip').val($('#lastip_data').val());
            $('#lastip_filter_text').html($('#lastip_data').val());
            $('#lastip_filter_release').show(1);
            break;
        case 15:
            $('#quick_search_status').val($('#status_data').val());
            $('#status_filter_text').html($('#status_data').val());
            $('#status_filter_release').show(1);
            break;
         case 16:
   
            $('#quick_search_country').val($('#country_data').val());
            $('#country_filter_text').html($('#country_data').val());
            $('#country_filter_release').show(1);
            break;
        case 17:
            $('#quick_search_refdomain').val($('#refdomain_data').val());
            $('#refdomain_filter_text').html($('#refdomain_data').val());
            $('#refdomain_filter_release').show(1);
            
            break;
        case 18:
            $('#quick_search_phone').val($('#phone_data').val());
            $('#phone_filter_text').html($('#phone_data').val());
            $('#phone_filter_release').show(1);
            
            break;
        case 19:
            $('#quick_search_contact').val($('#contact_data').val());
            $('#contact_filter_text').html($('#contact_view').html());
            $('#contact_filter_release').show(1);
            
            break;
        default:
            //put everything to blank?
            $('#quick_search_usergroup').val(-9);
            $('#quick_search_country').val(-9);
            $('#quick_search_browser').val(-9);
            $('#quick_search_os').val(-9);
            $('#quick_search_status').val(-9);
            $('#quick_search_language').val(-9);
            $('#quick_search_contact').val(-9);
            $('#orderby_quick').val(0);
            
            $('#order_direction').val(0);
            
            $('#quick_search_username').val('');
            $('#quick_search_phone').val('');
            
            $('#quick_search_email').val('');
            $('#quick_search_userid').val('');
            $('#quick_search_ipad').val('');
            $('#quick_search_lastvisit').val('');
            $('#quick_search_lastip').val('');
            $('#quick_search_regdate').val('');
            $('#quick_search_refurl').val('');
            $('#quick_search_refid').val('');
            
            $('#release_filter').hide(1);
          
            break;
        
    }
   
    searchUser_QV('0,'+pagationLength_QV,2);
    
    
}
var user_ready_for_delete=0;
function delete_user_confirm(id){

    user_ready_for_delete=id;
    jQuery.facebox({ div: "#delete_user_choice" });

}
var inital_load=true;
function historyPagation(){
    var currentpage = $('#pageLimitHistory').val();
    $('.history_page').hide(1,function(){
        $('#history_'+currentpage).show(1);
            
    });
}
function searchUser_QV(limiter,source){
    
    /*
        source =1 - pagation controls
        source =2 - search controls
        source =3 - ordering controls
        
    */
  
    var usernamesearch,active,emailsearch,groupsearch,country,browser,os,status,language,orderby,direction,ipad,lastvisit,lastip,regdate,refid,refurl,refdomain,phone,contact;
    
    if (source == 2 || source ==3 || filterFlag){
        
        if(!filterFlag){
            $('#pageLimit').val(1);
        }
        

        groupsearch     = $('#ub_search_group').val();
        if (groupsearch!=-9) $('#ub_rel_group').show(1); else $('#ub_rel_group').hide(1);
            
      
        country         = $('#ub_search_country').val();
        if (country!=-9) $('#ub_rel_country').show(1); else $('#ub_rel_country').hide(1);
       
       
        browser         = $('#ub_search_browser').val();
        if (browser!=-9) $('#ub_rel_browser').show(1); else $('#ub_rel_browser').hide(1); 
        
	
        os              = $('#ub_search_os').val();
        if (os!=-9) $('#ub_rel_os').show(1); else $('#ub_rel_os').hide(1);
        
        status          = $('#ub_search_status').val();
        if (status!=-9) $('#ub_rel_status').show(1); else $('#ub_rel_status').hide(1);
        
        contact          = $('#ub_search_contact').val();
        if (contact!=-9) $('#ub_rel_contact').show(1); else $('#ub_rel_contact').hide(1);
           
        language        = $('#ub_search_lang').val();
        if (language!=-9) $('#ub_rel_lang').show(1); else $('#ub_rel_lang').hide(1);
        
        usernamesearch  = $('#ub_search_username').val();
        if (jQuery.trim(usernamesearch)!='') $('#ub_rel_username').show(1); else $('#ub_rel_username').hide(1);
        
        emailsearch     = $('#ub_search_email').val(); 
        if (jQuery.trim(emailsearch)!='') $('#ub_rel_email').show(1); else $('#ub_rel_email').hide(1);
        
        
        userid     = $('#ub_search_userid').val();
        if (jQuery.trim(userid)!='') $('#ub_rel_userid').show(1); else $('#ub_rel_userid').hide(1);
        
        
        phone     = $('#ub_search_phone').val();
        if (jQuery.trim(phone)!='') $('#ub_rel_phone').show(1); else $('#ub_rel_phone').hide(1);
        
        
        active     = $('#ub_search_active').val();
        if (jQuery.trim(active)!=-9) $('#ub_rel_active').show(1); else $('#ub_rel_active').hide(1);
        
        
        
        ipad        =   $('#ub_search_regip').val();
	if (jQuery.trim(ipad)!='') $('#ub_rel_regip').show(1); else $('#ub_rel_regip').hide(1);
	
        lastvisit   =   $('#ub_search_lastdate').val();
	if (jQuery.trim(lastvisit)!='') $('#ub_rel_lastdate').show(1); else $('#ub_rel_lastdate').hide(1);
	
        lastip      =   $('#ub_search_lastip').val();
	if (jQuery.trim(lastip)!='') $('#ub_rel_lastip').show(1); else $('#ub_rel_lastip').hide(1);
	
        regdate     =   $('#ub_search_regdate').val();
	if (jQuery.trim(regdate)!='') $('#ub_rel_regdate').show(1); else $('#ub_rel_regdate').hide(1);
	
        refurl      =    $('#ub_search_refurl').val();
	if (jQuery.trim(refurl)!='') $('#ub_rel_refurl').show(1); else $('#ub_rel_refurl').hide(1);
	
        refid       =    $('#ub_search_refid').val();
	if (jQuery.trim(refid)!='') $('#ub_rel_refid').show(1); else $('#ub_rel_refid').hide(1);
	
        refdomain   =    $('#ub_search_refdomain').val();
	if (jQuery.trim(refdomain)!='') $('#ub_rel_refdomain').show(1); else $('#ub_rel_refdomain').hide(1);
	
        
        if (source==2){
            filterFlag= true;
        }
        
    }
    else{
        groupsearch     = '';
        country         = '';
        browser         = '';
        os              = '';
        status          = '';
        language        = '';
        usernamesearch  = '';
        emailsearch     = '';
        userid          = '';
        
        phone           =  '';
        contact         =  '';
        
        ipad            =  '';
        lastvisit       =  '';
        lastip          =  '';
        regdate         =  '';
        refurl          =  '';
        refid           =  '';
        refdomain       =  '';
        
        active       =  '';
        
        
    }
    
    
    
    
   
    orderby = $('#orderby_quick').val();
    
    direction= $('#order_direction').val();
    
   // $('#small_search_loader').fadeIn(100,function(){
       // $('#large_search_loader').fadeIn(100,function(){
       
       
         var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'', onefunrun=true, onefunrun_2=true;
    if (inital_load){
        $('#site_wide_load_msg'+load_inline).html('loading userbase...');
        
       }
       else{
        $('#site_wide_load_msg'+load_inline).html('searching userbase...');
       }
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    //$('#site_wide_okay'+load_inline).hide(1);
    
  
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
            
            $.post("../ajax/search_full_user.php",{userid:userid,
                                                   username:usernamesearch,
                                                   group:groupsearch,
                                                   email:emailsearch,
                                                   limit:limiter,
                                                   orderby:orderby,
                                                   direction:direction,
                                                   country:country,
                                                   browser:browser,
                                                   os:os,
                                                   lang:language,
                                                   status:status,
                                                   lastvisit:lastvisit,
                                                   lastip:lastip,
                                                   ipad:ipad,
                                                   regdate:regdate,
                                                   refurl:refurl,
                                                   refid:refid,
                                                   refdomain:refdomain,
                                                   quick:1,
                                                   phone:phone,
                                                   contact:contact,
                                                   active:active,
                                                   inital_load:inital_load //for loading/checking history
                                                   },function(dataReturn){
                    
                  //alert(dataReturn);
                
                           inital_load=false; 
                   var obj = jQuery.parseJSON(dataReturn);
                         
                   if (obj.Ack=="success"){
                    
                    //hide popup and show the actual results
                    
                 
                           
                        
                            $('#resultsset').html('');
                            var dataArray = obj.data, pageData=obj.repeater, history_data = obj.hdata;
                            var totalCount = obj.total_count;
                            var optionsBloc='';
                            // todo: workout why this conditional statement is here?! and then remove
                            // are there more then 3 sources?
                            if (source == 2 || source == 1 || source==3){
                                //build up drop down for pagation
                                
                                pageTotals = Math.ceil((totalCount/10));
                               
                              
                                if (pageTotals==0){
                                    pageTotals=1;
                                }                        
                                                     
                                if (totalCount>0){
                                    for (i=0;i<pageTotals;i++){
                                    
                                    optionsBloc += '<option value="'+i+'" > page '+Number(i+1)+'</option>' ;
                                    
                                    }
                                    if (source!=1 || limiter=='0,'+pagationLength_QV){
                                        $('#pageLimit').html(optionsBloc);
                                        $('#pagationBlock').show();
                                    }
                                    
                                    
                                }
                                else{
                                    $('#pagationBlock').hide();
                                }
                                
                            }
            
            
                      // alert(totalCount);
                            var fullset = '',pageBuildUp='',firstUserid='',last_visit,alt_flag=false;
                            
                            countUser=0;
                        
                            for (x in dataArray){
                                
                                pageBuildUp += pageData;
                                pageBuildUp = pageBuildUp.replace(/##resorhis##/gi,'results');
                                if (alt_flag){
                                    pageBuildUp = pageBuildUp.replace(/##altbox##/gi,'-alt');
                                    alt_flag=false;
                                }
                                else{
                                    pageBuildUp = pageBuildUp.replace(/##altbox##/gi,'');
                                    alt_flag=true;
                                }
                                
                                
                            
                                
                                last_visit_date = dataArray[x]['last_visit'].substr(0,10);
                                last_visit_time = dataArray[x]['last_visit'].substr(10,9);
                                date_joined = dataArray[x]['date_joined'].substr(0,10);
                                date_joined_time = dataArray[x]['date_joined'].substr(10,9);
                                
                                pageBuildUp = pageBuildUp.replace(/##last_visit_date##/gi,last_visit_date);
                                pageBuildUp = pageBuildUp.replace(/##last_visit_time##/gi,last_visit_time);
                               
                                pageBuildUp = pageBuildUp.replace(/##lastip##/gi,dataArray[x]['lastip']);
                                pageBuildUp = pageBuildUp.replace(/##regip##/gi,dataArray[x]['ipad']);
                                //alert(dataArray[x]['valid']+'----'+dataArray[x]['screenname']);
                                switch (dataArray[x]['valid']){
                                    
                                    case '0':
                                        pageBuildUp = pageBuildUp.replace('##status_colour##','blue');
                                        pageBuildUp = pageBuildUp.replace(/##tooltip##/gi,'awaiting activation');
                               
                                        break;
                                    case '1':
                                        
                                        pageBuildUp = pageBuildUp.replace('##status_colour##','green');
                                        pageBuildUp = pageBuildUp.replace(/##tooltip##/gi,'activated');
                                        
                                       
                                       
                                        break;
                                    case '2':
                                        pageBuildUp = pageBuildUp.replace('##status_colour##','red');
                                        pageBuildUp = pageBuildUp.replace(/##tooltip##/gi,'banned/blocked');
                                        
                                        break;
                                    
                                }
                                
                               
                                pageBuildUp = pageBuildUp.replace('##gravimg##','http://www.gravatar.com/avatar/' + hex_md5(dataArray[x]['email'])+'.jpg');
                                pageBuildUp = pageBuildUp.replace(/##screenname##/gi,makeTextSmall(dataArray[x]['screenname'],18));
                               // pageBuildUp = pageBuildUp.replace('##screenname_email##',dataArray[x]['screenname']);
                                pageBuildUp = pageBuildUp.replace('##screenname_full##',dataArray[x]['screenname']);
                                pageBuildUp = pageBuildUp.replace('##groupname##',dataArray[x]['name']);
                                pageBuildUp = pageBuildUp.replace(/##userid##/gi,dataArray[x]['userid']);
                                if (x==0){
                                    firstUserid = dataArray[x]['userid'];
                                }
                                
                                pageBuildUp = pageBuildUp.replace(/##date_joined##/gi,date_joined);
                                pageBuildUp = pageBuildUp.replace(/##date_joined_time##/gi,date_joined_time);
                               // pageBuildUp = pageBuildUp.replace(/##email##/gi,dataArray[x]['email']);
                               // pageBuildUp = pageBuildUp.replace(/##email_text##/gi,makeTextSmall(dataArray[x]['email'],15));
                                pageBuildUp = pageBuildUp.replace(/##country_code##/gi,dataArray[x]['country_code']);
                                //something in nameCap causing problems - country must always be last to be swapped until investigated
                                pageBuildUp = pageBuildUp.replace(/##country##/gi,nameCap(dataArray[x]['country']));
                                
                                
                                //gravatar//
                                //pageBuildUp = pageBuildUp.replace(/##gravatar##/gi,'http://www.gravatar.com/avatar/' + hex_md5((dataArray[x]['email']))+'.jpg');
                                

                                
                                //pageBuildUp = pageBuildUp.replace(/##ipad##/gi,dataArray[x]['ipad']);
                                
                                
                                //pageBuildUp = pageBuildUp.replace('##usergroup##',dataArray[x]['name']);
                                
                                
        
                                countUser++;
                            }
                            
                            
                            
                           // 
                            $('#ub_user_results').html(pageBuildUp);
                            
                            if (obj.history===true){
                               var  optionsHistory='<option value="1">page 1</options>';
                                pageBuildUp='<div id="history_1" class="history_page">';
                                for (x in history_data){
                                    if ((array_counter+1)/(div_counter*10)>1){
                                       
                                            div_counter++;
                                            pageBuildUp += "</div><div class='hide history_page' id='history_"+div_counter+"'>";
                                            optionsHistory += '<option value="'+div_counter+'">page '+div_counter+'</options>';
                                        
                                    }
                                        pageBuildUp += pageData;
                                        pageBuildUp = pageBuildUp.replace(/##resorhis##/gi,'history');
                                        
                                        
                                        history_array[x]=history_data[x]['userid'];
                                        array_counter++;
                                        
                                        if (alt_flag){
                                            pageBuildUp = pageBuildUp.replace(/##altbox##/gi,'-alt');
                                            alt_flag=false;
                                        }
                                        else{
                                            pageBuildUp = pageBuildUp.replace(/##altbox##/gi,'');
                                            alt_flag=true;
                                        }
                                        
                                        
                                    
                                        
                                        last_visit_date = history_data[x]['last_visit'].substr(0,10);
                                        last_visit_time = history_data[x]['last_visit'].substr(10,9);
                                        date_joined = history_data[x]['date_joined'].substr(0,10);
                                        date_joined_time = history_data[x]['date_joined'].substr(10,9);
                                        
                                        pageBuildUp = pageBuildUp.replace(/##last_visit_date##/gi,last_visit_date);
                                        pageBuildUp = pageBuildUp.replace(/##last_visit_time##/gi,last_visit_time);
                                       
                                        pageBuildUp = pageBuildUp.replace(/##lastip##/gi,history_data[x]['lastip']);
                                        pageBuildUp = pageBuildUp.replace(/##regip##/gi,history_data[x]['ipad']);
                                        //alert(history_data[x]['valid']+'----'+history_data[x]['screenname']);
                                        switch (history_data[x]['valid']){
                                            
                                            case '0':
                                                pageBuildUp = pageBuildUp.replace('##status_colour##','blue');
                                                pageBuildUp = pageBuildUp.replace(/##tooltip##/gi,'awaiting activation');
                                       
                                                break;
                                            case '1':
                                                
                                                pageBuildUp = pageBuildUp.replace('##status_colour##','green');
                                                pageBuildUp = pageBuildUp.replace(/##tooltip##/gi,'activated');
                                                
                                               
                                               
                                                break;
                                            case '2':
                                                pageBuildUp = pageBuildUp.replace('##status_colour##','red');
                                                pageBuildUp = pageBuildUp.replace(/##tooltip##/gi,'banned/blocked');
                                                
                                                break;
                                            
                                        }
                                        
                                       
                                        pageBuildUp = pageBuildUp.replace('##gravimg##','http://www.gravatar.com/avatar/' + hex_md5(history_data[x]['email'])+'.jpg');
                                        pageBuildUp = pageBuildUp.replace(/##screenname##/gi,makeTextSmall(history_data[x]['screenname'],18));
                                       // pageBuildUp = pageBuildUp.replace('##screenname_email##',history_data[x]['screenname']);
                                        pageBuildUp = pageBuildUp.replace('##screenname_full##',history_data[x]['screenname']);
                                        pageBuildUp = pageBuildUp.replace('##groupname##',history_data[x]['name']);
                                        pageBuildUp = pageBuildUp.replace(/##userid##/gi,history_data[x]['userid']);
                                        if (x==0){
                                            firstUserid = history_data[x]['userid'];
                                        }
                                        
                                        pageBuildUp = pageBuildUp.replace(/##date_joined##/gi,date_joined);
                                        pageBuildUp = pageBuildUp.replace(/##date_joined_time##/gi,date_joined_time);
                                       // pageBuildUp = pageBuildUp.replace(/##email##/gi,history_data[x]['email']);
                                       // pageBuildUp = pageBuildUp.replace(/##email_text##/gi,makeTextSmall(history_data[x]['email'],15));
                                        pageBuildUp = pageBuildUp.replace(/##country_code##/gi,history_data[x]['country_code']);
                                        //something in nameCap causing problems - country must always be last to be swapped until investigated
                                        pageBuildUp = pageBuildUp.replace(/##country##/gi,nameCap(history_data[x]['country']));
                                        
                                        
                                        //gravatar//
                                        //pageBuildUp = pageBuildUp.replace(/##gravatar##/gi,'http://www.gravatar.com/avatar/' + hex_md5((history_data[x]['email']))+'.jpg');
                                        
        
                                        
                                        //pageBuildUp = pageBuildUp.replace(/##ipad##/gi,history_data[x]['ipad']);
                                        
                                        
                                        //pageBuildUp = pageBuildUp.replace('##usergroup##',history_data[x]['name']);
                                        
                                        
                
                                        countUser++;
                                    }
                                    
                                    
                                   
                                   
                                   $('#pageLimitHistory').html(optionsHistory);
                                   pageBuildUp += '</div>';
                                    $('#ub_user_results_history').html(pageBuildUp);
                                    
                            }
                            
                            
                            
                            
                            
                            //if you want automatic loading of the first record into the side bar uncomment below:
                            //showUserEdit_QV(firstUserid);
                            
                            $('span.ub_repeater_tooltip').each(function() {

				$(this).qtip({content: $(this).children('.hiddenInfo'),
                                                                    
                                    style:{
                                        classes: 'ui-tooltip-light  ui-tooltip-microblog ui-tooltip-ub', 
                                        tip: { offset: 5 },
                                        width:300
                                     },
                                     position: {
                                        at:'bottom center',
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
                                     show:{
                                        solo:true
                                        },
                                      hide: {
					
                                            event: 'unfocus',
					    inactive:2000
                                            
					    }

                                     });
			
			});
                             
                          /*   $('div.repeater_username').qtip({content: {attr: 'title'},
                                                                    
                                    style:{
                                        classes: 'ui-tooltip-tipsy ui-tooltip-shadow ui-tooltip-microblog', 
                                        tip: { offset: 5 }
                                     },
                                     position: {
                                        at:'bottom left',
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
                                      hide: {
                                            event: 'unfocus',
                                            inactive:1000

                                         }

                                     });
                             
                          */
                             $('.ub_corners3').corner('3px');
                            $('.ub_corners').corner('3px');
                           
                            $('#results_set_ub').height($('#results_block').outerHeight()+45);
                            
                           /* $('#countPageQuick').html(countPages);
                            if (countPages>1){
                                $('#resultsText').html(' matching pages found');
                            }
                            else{
                                $('#resultsText').html(' matching page found');
                            }*/
                        
                       
                    
                   }
                   else{
                        //no results found
                        $('#ub_user_results').html('<tr><td>No results found</td></tr>');
                         $('#pagationBlock').hide();
                        
                   }
                   
                   //todo: need better filter release management - use hidden field or global var
                    if (source==2){
                        $('#release_filter').show(1);
                    }
                    else if (source!=3 && !filterFlag  ){
                        $('#release_filter').hide(1);
                    }
                    
                 $('#site_wide_load'+load_inline+glass).fadeOut(100);
                    
            
            });
        });
    });
    
    
}



function changeStatusUser(id){
    
    
    
    
    var newStatus = $('#status_id_'+id).val();
    
    $('#itemloader_id_'+id).fadeIn(100,function(){
        
        $.post("../ajax/change_status_user.php",{userid:id,status:newStatus},function(dataReturn){
            
                   
                    var obj = jQuery.parseJSON(dataReturn);
                     
               if (obj.Ack=="success"){
                    
                    if (newStatus==0){
                        $('#ban_user_text_id_'+id).html('activate');
                        $('#ban_user_text_id_'+id).css("color","#63d300");
                        $('#status_id_'+id).val(1);
                        $('#status_main_id_'+id).html('awaiting activation');
                        $('#status_main_id_'+id).css("color","#00a6c4");
                        //63d300
                        //status_main_id_
                    }
                    else if (newStatus==1){
                        $('#ban_user_text_id_'+id).html('ban user');
                        $('#ban_user_text_id_'+id).css("color","#da0303");
                        $('#status_id_'+id).val(2);
                        $('#status_main_id_'+id).html('activated');
                        $('#status_main_id_'+id).css("color","#63d300");
                        //da0303
                    }
                    else{
                        $('#ban_user_text_id_'+id).html('deactivate');
                        $('#ban_user_text_id_'+id).css("color","#00a6c4");
                        $('#status_id_'+id).val(0);
                        $('#status_main_id_'+id).html('banned/blocked');
                        $('#status_main_id_'+id).css("color","#da0303");
                    }
                    $('#status_data_id_'+id).val(newStatus);
                   
               }
               else{
                    $('#userresponse_id_'+id).html(obj.Msg);
               }
              $('#itemloader_id_'+id).hide(1);
        });
        
    });
   
    
}





function charCount(element){
  
    $('#'+element.id+'_charcount').html(element.value.length);
}
function sendSMS(){
    
    $('#emailresponse').html('');
    $('#sms_err_msg').html('');
    var contentText = $('#ub_send_sms_msg').val();

    var phoneEmail = jQuery.trim($('#ub_phone_display').html());
    
    
   
    //email_user_hidden
      var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    //$('#site_wide_okay'+load_inline).hide(1);
    $('#site_wide_load_msg'+load_inline).html('sending message...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
        
       
        $.post("../ajax/send_sms.php",{content:contentText,phone:phoneEmail},function(dataReturn){
               
                   
                var obj = jQuery.parseJSON(dataReturn);
                     $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                                    });
                if (obj.Ack=="success"){
                     
                  $('#sms_err_msg').html(obj.Msg);
                     
                     
                     
                }
                else{
                    
                     if (obj.Ack=="fail"){
                            
			$('#sms_err_msg').html(obj.Msg);
                            
                     }
                     else if (obj.Ack=="validationFail"){
                        
                       
                        
                        validationData = obj.validationdata;
                        
                        
                        if (validationData.contentAck=='fail'){
			     $('#sms_err_msg').append(validationData.contentMsg+'<br/>');
                        }
                        
                        if (validationData.phonetAck=='fail'){
                            $('#sms_err_msg').append(validationData.phoneMsg+'<br/>');
                        }
                      
                       
			
                        
                        
                     }
                     
                     
                    
                }
                
        });
        
    });
    
    });
    
    
}



function sendMail(){
    
    $('#emailresponse').html('');
    $('#email_err_msg').html('');
    
    var subjectText = $('#ub_send_email_subject').val();
    var contentText = $('#ub_send_email_msg').val();
    var userEmail = jQuery.trim($('#ub_email_display').html());
    
    
   
    //email_user_hidden
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
   
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    //$('#site_wide_okay'+load_inline).hide(1);
    $('#site_wide_load_msg'+load_inline).html('sending message...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
       
        $.post("../ajax/send_email.php",{subject:subjectText,content:contentText,email:userEmail},function(dataReturn){
            
                   
                var obj = jQuery.parseJSON(dataReturn);
                       $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                                    });
                      
                if (obj.Ack=="success"){
                      
                    
                     $('#email_err_msg').html(obj.Msg);
                     
                     
                }
                else{
                    
                     if (obj.Ack=="fail"){
                           $('#email_err_msg').html(obj.Msg);
                      
                            
                     }
                     else if (obj.Ack=="validationFail"){
                        
                        
                        
                        validationData = obj.validationdata;
                        
                        
                        if (validationData.contentAck=='fail'){
                            $('#email_err_msg').append(validationData.contentMsg+'<br/>');
                        }
                        
                        if (validationData.subjectAck=='fail'){
                            $('#email_err_msg').append(validationData.subjectMsg+'<br/>');
                        }
                        
                  
                       
                        
                        
                        
                     }
                     
                     
                    
                }
                
        });
    });
    });
    
    
}










function reset_bindings(){
    
     $('.ub_buttons').live('mouseover',function(event){
                    
                                         $(this).css({'background-color':'#535353'});
                                                 
                     
                             });
                $('.ub_buttons').live('mouseout',function(event){
       
                            $(this).css({'background-color':'#7f7f7f'});
                                    
        
                });
     $('#delete_user, #delete_group').live('mouseover',function(event){
                    
                                         $(this).css({'background-color':'#535353'});
                                                 
                     
                             });
                $('#delete_user, #delete_group').live('mouseout',function(event){
       
                            $(this).css({'background-color':'#BA211C'});
                                    
        
                });
    
     $('.ub_text_box_wraps_small, .ub_select_box_wraps_small').live('mouseover',function(event){
                    
                                         $(this).css({'background-color':'#fff'});
					 $(this).children().children().css({'background-color':'#fff'});
                                   
                     
                             });
                $('.ub_text_box_wraps_small, .ub_select_box_wraps_small').live('mouseout',function(event){
       
                            $(this).css({'background-color':'#FAFAFA'});
			    $(this).children().children().css({'background-color':'#FAFAFA'});
                                    
        
                });
                $('.ub_text_box_small, .ub_select_box_small').live('focus mouseover',function(event){
                    
                                         $(this).parent().parent().css({'background-color':'#fff'});
					 $(this).css({'background-color':'#fff'});
                                                 
                     
                             });
                $('.ub_text_box_small, .ub_select_box_small').live('blur mouseout',function(event){
       
                           $(this).parent().parent().css({'background-color':'#FAFAFA'});
			   $(this).css({'background-color':'#FAFAFA'});
                                    
        
                });
                
                $('.ub_select_box_small_noalert').live('focus mouseover',function(event){
					
                                         $(this).parent().css({'background-color':'#fff'});
					  $(this).css({'background-color':'#fff'});
                                                 
                     
                             });
                $('.ub_select_box_small_noalert').live('blur mouseout',function(event){
			
                           $(this).parent().css({'background-color':'#FAFAFA'});
			    $(this).css({'background-color':'#FAFAFA'});
                                    
        
                });
                
                $('.ub_text_box_wraps_small_noalert').live('mouseover',function(event){
                    
                                         $(this).css({'background-color':'#fff'});
					 $(this).children().css({'background-color':'#fff'});
                                   
                     
                             });
                $('.ub_text_box_wraps_small_noalert').live('mouseout',function(event){
       
                            $(this).css({'background-color':'#FAFAFA'});
			    $(this).children().css({'background-color':'#FAFAFA'});
                                    
        
                });
                
                
                
                
                
                $('.user_details_out').live('mouseover',function(event){
                    
                                         $(this).css({'background-color':'#e6e6e6'});
                                                 
                     
                             });
                $('.user_details_out').live('mouseout',function(event){
       
                           $(this).css({'background-color':'#FAFAFA'});
                                    
        
	
                });
		
                $('.ub-quick-results-box').live('mouseout',function(event){
            
                                $(this).css({'background-color':'#fafafa'});
                                        
            
                    });
                    
                    $('.ub-quick-results-box').live('mouseover',function(event){
           
                                $(this).css({'background-color':'#fff'});
                                        
            
                    });
		    $('.ub-quick-results-box-user').live('mouseout',function(event){
            
                                $(this).css({'background-color':'#fafafa'});
                                        
            
                    });
                    
                    $('.ub-quick-results-box-user').live('mouseover',function(event){
           
                                $(this).css({'background-color':'#f8f8f8'});
                                        
            
                    });
                
                
               
}




var unibody_initalised = new Array();
unibody_initalised['usermanagement']=false;
unibody_initalised['sec_groups']=false;
unibody_initalised['dashboard']=true;
unibody_initalised['overview_ss']=false;
unibody_initalised['detailed_ss']=false;
unibody_initalised['about_ss']=false;
unibody_initalised['current_funcs']='dashboard';
unibody_initalised['current_link_gs']='sec';

function slide_unibody(id){
     var $paneOptionsOuter = $('#unibody-pane-options');


    switch(id){
	case 'usermanagement':
	    if(!unibody_initalised['usermanagement']){
		userPagation_QV(1);
		getLists(true,true,true,true,true);
		  $("#ub_add_note").keypress(function(event) {
                    if ( event.which == 13 ) {
                       addUserNote();
                     }
                     
                  });
		//allow search by hitting return key on search inputs
		$("div.ub_input_release > input").keypress(function(event) {
		       if ( event.which == 13 ) {
			  searchUser_QV('0,10',2);
			}
			
		     });
		//reset_bindings();
		
		var $paneOptions = $('#qf-pane-options');
		$paneOptions.scrollTo( 'ul#one li#search-box', { duration: 1  } );
		$paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
		unibody_initalised['usermanagement']=true;
		
		
		$('#links_functions').html($('#functions_'+id).html());
		
	    }
	    else{
		
		
		$paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
	    }
	    $('#unibody_mid_bar').html('user<b>base</b> user management');
	    $('#links_functions').html($('#functions_'+id).html());
	    break;
	case 'sec_groups':
	    if(!unibody_initalised['sec_groups']){
		groupPagation(1);
                blockPagation(1);
                
                $('.ub_corners').corner('5px','keep');
                $('.ub_corners_top').corner('5px keep top');
                
                $('.ub_buttons').corner('3px');
                $('.ub_corners_left').corner('5px keep left');
                
                $('.input_corners_qf').corner('5px keep');
                
               
                $('.ub_corners').corner('5px');
                $('.ub_buttons').corner('3px');
                
                $("div.ub_input_release_sec > input").keypress(function(event) {
		       if ( event.which == 13 ) {
			  searchBlock('0,10',2,'');
			}
			
		     });
		$paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
		unibody_initalised['sec_groups']=true;
		$('#links_functions').html($('#functions_'+id).html());
	    }else{
		$paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
	    }
	    $('#unibody_mid_bar').html('security & user group management');
	    
	   
	    $('#links_functions').html($('#functions_'+id).html());
	    if (unibody_initalised['current_link_gs']!='sec'){
		$('#functions_sec').hide(1,function(){
		    $('#functions_groups').show(1);
		});
	    }
	  
	    
	    break;
	
    
    
    
	case 'overview_ss':
	    if(!unibody_initalised['overview_ss']){
		$('.ub_corners3').corner('3px');
                $('.ub_corners').corner('5px');
                $('.ub_buttons').corner('3px');
                $('.ub_buttons_x').corner('3px');
                  
               loadquickstats('_ov');
               overview_details("browser","365");
                //load_site_stat_report();
    
    
                $('.rep_corners').corner('5px');
                $('.roar_reports').corner('5px','keep');
                $('.roar_reports_minibars').corner('5px','keep');
                $('.clearreports').corner('5px','keep');

                        
		
                
               //reset_bindings();
	       $paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
	       unibody_initalised['overview_ss']=true;
	        $('#links_functions').html('');
	    }
	    else{
		$paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
	    }
	    $('#unibody_mid_bar').html('site<b>stats</b> dashboard');
	    break;
	case 'detailed_ss':
	    if(!unibody_initalised['detailed_ss']){
		$('.ub_corners').corner('5px');
                $('.ub_buttons').corner('3px');
                  $('.ub_buttons_x').corner('3px');
                  
               loadquickstats('_dt');
               
                load_site_stat_report();
    
    
                   $('.rep_corners').corner('5px');
               $('.roar_reports').corner('5px','keep');
                $('.roar_reports_minibars').corner('5px','keep');
                $('.clearreports').corner('5px','keep');
               
          
    
	        $("#ub_stats_search_date").keypress(function(event) {if ( event.which == 13 ) rr_stats_collection('date', 0, '',0);});
		$("#ub_stats_search_url").keypress(function(event) {if ( event.which == 13 ) rr_stats_collection('url', 0, '',0);});
                $("#ub_stats_search_domain").keypress(function(event) {if ( event.which == 13 ) rr_stats_collection('domain', 0, '',0);});
		$("#ub_stats_search_refid").keypress(function(event) {if ( event.which == 13 ) rr_stats_collection('refid', 0, '',0);});
		$("#ub_stats_search_searchterm").keypress(function(event) {if ( event.which == 13 ) rr_stats_collection('searchterm', 0, '',0);});
                
              
	       $paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
	       unibody_initalised['detailed_ss']=true;
	       $('#links_functions').html('');
	    }
	    else{
		$paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
	    }
	    $('#unibody_mid_bar').html('site<b>stats</b>: detailed traffic');
	    break;
	case 'dashboard':
	    $paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
	    $('#links_functions').html($('#functions_'+id).html());
	    $('#unibody_mid_bar').html('user<b>base</b> dashboard');
	    break;
	case 'about':
	    $paneOptionsOuter.scrollTo( '#unibody_'+id, { duration: 1000} );
	    $('#unibody_mid_bar').html('about user<b>base</b>');
	    $('#links_functions').html();
	    break;
    }
    
	 
    
}

var user_ready_for_delete
function showinfobox(id){
    
    
    var content = $('#'+id).html().replace(/_int_/gi,'');
    $('#load_info_inner').html(content);
    if (id==''){
        
        
    }
    
    
    switch (id){
        case 'delete_user_loadbox':
           
            $('#user_del').html($('#ub_username_'+userid_for_edit).html());
            break;
        
        case 'delete_groups_loadbox':
            
            group_ready_for_delete=group_ready_for_edit;
            $('#group_del').html($('#ub_group_name_'+group_ready_for_edit).html());
            break;
        
    }
    //reset_bindings();
    $('#load_info, #load_info_inner').fadeIn(50);
    
}

function hideinfobox(){
    
    $('#load_info, #load_info_inner').fadeOut(100);
}



function mass_status_change(){
    
     var limiter,new_status,active,userid,usernamesearch,emailsearch,groupsearch,country,browser,os,status,language,orderby,direction,ipad,lastvisit,lastip,regdate,refid,refurl,refdomain,contact,phone;
    //limiter needed for later developement (for ajax'd looping of large mailing lists)
    limiter='';
    new_status=$('#mass_change').val();
    
    if (filterFlag){
   
        
        //todo: need a way to reduce code base here
        groupsearch     = $('#ub_search_group').val();
       
        country         = $('#ub_search_country').val();
        
       
        browser         = $('#ub_search_browser').val();
       
        os              = $('#ub_search_os').val();
      
        status          = $('#ub_search_status').val();
       
        language        = $('#ub_search_lang').val();
        
        
        contact        = $('#ub_search_contact').val();
        
        usernamesearch  = $('#ub_search_username').val();
       
        emailsearch     = $('#ub_search_email').val();
        
        
        userid     = $('#ub_search_userid').val();
        
        
        phone     = $('#ub_search_phone').val();
        
        active = $('#ub_search_active').val();
        
        ipad        =    $('#ub_search_regip').val();
        lastvisit   =    $('#ub_search_lastdate').val();
        lastip      =    $('#ub_search_lastip').val();
        regdate     =    $('#ub_search_regdate').val();
        refurl      =    $('#ub_search_refurl').val();
        refid       =    $('#ub_search_refid').val();
        refdomain   =    $('#ub_search_refdomain').val();
       
        
    }
    else{
        groupsearch     = '';
        country         = '';
        browser         = '';
        os              = '';
        status          = '';
        language        = '';
        usernamesearch  = '';
        emailsearch     = '';
        userid          = '';
        
        ipad            =  '';
        lastvisit       =  '';
        lastip          =  '';
        regdate         =  '';
        refurl          =  '';
        refid           =  '';
        refdomain       =  '';
        
        phone           = '';
        contact         = '';
        active          = '';
        
    }
    orderby = $('#orderby_quick').val();
    
    direction= $('#order_direction').val();
        $('#mass_change_msg').html('').hide(1);
        $('#mass_change_loader').fadeIn(100,function(){
 
            $.post("../ajax/ub_set_status_enmass.php",{         userid:userid,
                                                   username:usernamesearch,
                                                   group:groupsearch,
                                                   email:emailsearch,
                                                   limit:limiter,
                                                   orderby:orderby,
                                                   direction:direction,
                                                   country:country,
                                                   browser:browser,
                                                   os:os,
                                                   lang:language,
                                                   status:status,
                                                   lastvisit:lastvisit,
                                                   lastip:lastip,
                                                   ipad:ipad,
                                                   regdate:regdate,
                                                   refurl:refurl,
                                                   refid:refid,
                                                   refdomain:refdomain,
                                                   quick:0,
                                                   phone:phone,
                                                   contact:contact,
                                                   active:active,
                                                   new_status:new_status
                                                   },function(dataReturn){
                    
                  //alert(dataReturn);
                   
                   var obj = jQuery.parseJSON(dataReturn);
                         
                   if (obj.Ack=="success"){
                    
                       //$('#mailingList').html('<a target="_blank" href="'+obj.file+'">download mailing list</a> '+obj.Msg);
                       
                        $('#mass_change_msg').html(obj.Msg);
                    
                   }
                   else{
                    
                         $('#mass_change_msg').html(obj.Msg);
                         
              
                   }
                    $('#mass_change_loader').fadeOut(100,function(){
                        $('#mass_change_msg').show(1);
                    
                    });
            
            });

    
    
  

        
        });

}

function getMailingList(){
    
     var limiter,active,userid,usernamesearch,emailsearch,groupsearch,country,browser,os,status,language,orderby,direction,ipad,lastvisit,lastip,regdate,refid,refurl,refdomain,contact,phone;
    //limiter needed for later developement (for ajax'd looping of large mailing lists)
    limiter='';
    
    if (filterFlag){
   
        
        //todo: need a way to reduce code base here
        groupsearch     = $('#ub_search_group').val();
       
        country         = $('#ub_search_country').val();
        
       
        browser         = $('#ub_search_browser').val();
       
        os              = $('#ub_search_os').val();
      
        status          = $('#ub_search_status').val();
       
        language        = $('#ub_search_lang').val();
        
        
        contact        = $('#ub_search_contact').val();
        
        usernamesearch  = $('#ub_search_username').val();
       
        emailsearch     = $('#ub_search_email').val();
        
        
        userid     = $('#ub_search_userid').val();
        
        
        phone     = $('#ub_search_phone').val();
        
        active = $('#ub_search_active').val();
        
        ipad        =    $('#ub_search_regip').val();
        lastvisit   =    $('#ub_search_lastdate').val();
        lastip      =    $('#ub_search_lastip').val();
        regdate     =    $('#ub_search_regdate').val();
        refurl      =    $('#ub_search_refurl').val();
        refid       =    $('#ub_search_refid').val();
        refdomain   =    $('#ub_search_refdomain').val();
       
        
    }
    else{
        groupsearch     = '';
        country         = '';
        browser         = '';
        os              = '';
        status          = '';
        language        = '';
        usernamesearch  = '';
        emailsearch     = '';
        userid          = '';
        
        ipad            =  '';
        lastvisit       =  '';
        lastip          =  '';
        regdate         =  '';
        refurl          =  '';
        refid           =  '';
        refdomain       =  '';
        
        phone           = '';
        contact         = '';
        active          = '';
        
    }
    orderby = $('#orderby_quick').val();
    
    direction= $('#order_direction').val();
    $('#export_msg').html('').hide(1);
    $('#export_mail_loader').fadeIn(100,function(){
            $.post("../ajax/get_cvs.php",{         userid:userid,
                                                   username:usernamesearch,
                                                   group:groupsearch,
                                                   email:emailsearch,
                                                   limit:limiter,
                                                   orderby:orderby,
                                                   direction:direction,
                                                   country:country,
                                                   browser:browser,
                                                   os:os,
                                                   lang:language,
                                                   status:status,
                                                   lastvisit:lastvisit,
                                                   lastip:lastip,
                                                   ipad:ipad,
                                                   regdate:regdate,
                                                   refurl:refurl,
                                                   refid:refid,
                                                   refdomain:refdomain,
                                                   quick:0,
                                                   phone:phone,
                                                   contact:contact,
                                                   active:active
                                                   },function(dataReturn){
                    
                  //alert(dataReturn);
                   
                   var obj = jQuery.parseJSON(dataReturn);
                         
                   if (obj.Ack=="success"){
                   
                        $('#export_msg').html('<a class="orangelink" target="_blank" href="'+obj.file+'">download mailing list</a> '+obj.Msg);
                       
                        
                    
                   }
                   else{
                    
                        $('#export_msg').html(obj.Msg);
                         
              
                   }
                    $('#export_mail_loader').fadeOut(100,function(){
                        $('#export_msg').show(1);
                    
                    });
            
            });
    });
    
    
}



function saveNewUser(){
    
    $('.ub_input_warnings').qtip('destroy');
   
    var emailadd        = $('#ub_add_email').val();

    var groupsadd       = $('#ub_add_group').val();

    var usernameadd     = $('#ub_add_username').val();
    
    var passwordadd     = $('#ub_add_pass').val();
    
    var phoneadd        = $('#ub_add_phone').val();
    
    var refidadd        = $('#ub_add_refid').val();
    var refdomainadd    = $('#ub_add_refdomain').val();
    var refurladd       = $('#ub_add_refurl').val();
    
    var countryadd      = $('#ub_add_country').val();
    var browseradd     = $('#ub_add_browser').val();
    var osadd           = $('#ub_add_os').val();
    var langadd         = $('#ub_add_lang').val();
    
    var contactadd      = $('#ub_add_contact').val();
    var statusadd       = $('#ub_add_status').val();
    
   
    
   // var activationadd   =$('#activation_add').is(':checked');
   // var contactadd      =$('#contact_add').is(':checked');
    
    
    /* old system - remove once tested
    if(activationadd==false){
        activationadd=0;
    }
    else{
         activationadd=1;
    }
    
    if(contactadd==false){
        contactadd=0;
    }
    else{
         contactadd=1;
    }*/
    

    passwordadd = hex_md5(passwordadd) ; //hash this with md5
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('adding new user account...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
            $.post("../ajax/save_add_user.php",{username:usernameadd,
                                                group:groupsadd,
                                                email:emailadd,
                                                password:passwordadd,
                                                refid:refidadd,
                                                refurl:refurladd,
                                                refdomain:refdomainadd,
                                                phone:phoneadd,
                                                country:countryadd,
                                                browser:browseradd,
                                                os:osadd,
                                                lang:langadd,
                                                contact:contactadd,
                                                status:statusadd
                                             
                                                },function(dataReturn){
                    
                   
                   
                   var obj = jQuery.parseJSON(dataReturn);
                  
                   $('#site_wide_load'+load_inline).fadeOut(100,function(){
                                            $('#site_wide_msg'+load_inline).html(obj.Msg).show(1);
                                            $('#site_wide_okay'+load_inline).show(1);
                                    });
                         
                   if (obj.Ack=="success"){
                    
                        $('div.ub_add_warn > img').attr('src','../images/blank.gif');
                        $('div.ub_add_warn > img').attr('title','');
                        
                       
                   }
                   else{
                    
                        if (obj.Ack=="fail"){
                            
                          
                            
                        }
                        else if (obj.Ack=="validationFail"){
                           
                     
                            
                           var valdata = obj.validationdata, otherflag=false;;
                                    
                                    if (valdata.usernameAck=='fail'){
                                        $('#ub_input_add_img_username').attr('src','../images/alert.gif');
                                        $('#ub_input_add_img_username').parent('.ub_input_warnings').attr('title',valdata.usernameMsg);
                                        otherflag=true;
                                    }
                                    else{
                                        $('#ub_input_add_img_username').attr('src','../images/blank.gif');
                                        $('#ub_input_add_img_username').parent('.ub_input_warnings').attr('title','');
                                    }
                                    
                                    if (valdata.emailAck=='fail'){
                                        $('#ub_input_add_img_email').attr('src','../images/alert.gif');
                                        $('#ub_input_add_img_email').parent('.ub_input_warnings').attr('title',valdata.emailMsg);
                                        otherflag=true;
                                    }
                                    else{
                                        $('#ub_input_add_img_email').attr('src','../images/blank.gif');
                                        $('#ub_input_add_img_email').parent('.ub_input_warnings').attr('title','');
                                    }
                                    
                                    if (valdata.passwordAck=='fail'){
                                        $('#ub_input_add_img_pass').attr('src','../images/alert.gif');
                                        $('#ub_input_add_img_pass').parent('.ub_input_warnings').attr('title',valdata.passwordMsg);
                                        otherflag=true;
                                    }
                                    else{
                                        $('#ub_input_add_img_pass').attr('src','../images/blank.gif');
                                        $('#ub_input_add_img_pass').parent('.ub_input_warnings').attr('title','');
                                    }
                                   
                                    
                                    if (!otherflag && valdata.otherAck=='fail' ){
                                        //need to change button types as per design
                                        
                                        $('#ub_save_edit_button').attr('title',valdata.otherMsg);
                                        
                                        
                                    }
                                    
                                  
                                    $('div.ub_input_warnings').qtip({content: {attr: 'title'},
                                                                    
                                    style:{
                                         
                                        tip: { offset: 5 }
                                     },
                                     position: {
                                     
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
                                     show: {
					     event: false,
					     ready: true
					  },
                                          hide: false
                                     });
                            
                            
                        }
                        
                   }
                    
                    
                   
            
            });
        });
 });
    
}



function showSearchUser(){
    closeAllBox();
    $('#large_search_loader').hide(1);
    $('#small_search_loader').hide(1);
    $('#username_search').val('');
    $('#email_search').val('');
    
    $('#search_popup_user').css("position","absolute");
   
    $('#search_popup_user').css("top", ( $(window).height() - $('#search_popup_user').outerHeight() ) / 2+$(window).scrollTop() + "px");
    $('#search_popup_user').css("left", ( $(window).width() - $('#search_popup_user').outerWidth() ) / 2+$(window).scrollLeft() + "px");
    $('#search_popup_user').fadeIn(509);
    

  
}

function releaseUserFilter(){
    
    $('#username_search').val('');
    $('#email_search').val('');
    $('#groups_search').val(0);
    $('#release_filter').hide(1);
    searchUser('0,'+pagtionLength,1);
    
}



function userPagation (source){
    //need a way to know what the search criteria was
    if (source==1){
        var limiter = '0,'+pagtionLength;
    }
    else{
        var newLimit = $('#pageLimit').val();
        //$('#pageLimit').val(Number(newLimit)+1);
         //alert(newLimit);
         newLimit = newLimit*10;
         
         var start = (newLimit-1)+1;
         
         if (start<0){
             start = 0;
         }
         
         var limiter = start+',10';
    }
    
    //alert(limiter);
    searchUser(limiter,1);
    
    
    
    //get search criteria
    
    
}

function clickSearchablesReg(id,clickType,searchValue,displayName){



    //todo: must take out QV duplicates - ie those not needed in 'detailed' version todo code: TD002JS
    switch (clickType){
        
        case 1:
            //country
            
            $('#quick_search_country').val($('#country_data_id_'+id).val());
            $('#country_filter_text').html($('#user_country_id_'+id).html());
            $('#country_filter_release').show(1);
            break;
        case 2:
            $('#quick_search_usergroup').val($('#group_data_id_'+id).val());
            $('#group_filter_text').html($('#usergroup_id_'+id).html());
            $('#group_filter_release').show(1);
            break;
        case 3:
            $('#quick_search_browser').val($('#browser_data_id_'+id).val());
            $('#browser_filter_text').html($('#user_browser_id_'+id).html());
            $('#browser_filter_release').show(1);
            break;
        case 4:
            $('#quick_search_os').val($('#os_data_id_'+id).val());
            $('#os_filter_text').html($('#user_os_id_'+id).html());
            $('#os_filter_release').show(1);
            break;
        case 5:
            $('#quick_search_status').val($('#status_data_id_'+id).val());
            $('#status_filter_text').html($('#status_main_id_'+id).html());
            $('#status_filter_release').show(1);
            break;
        case 6:

            $('#quick_search_language').val($('#lang_data_id_'+id).val());
            $('#lang_filter_text').html($('#user_lang_id_'+id).html());
            $('#lang_filter_release').show(1);
            break;
        case 7:
           
           
            $('#quick_search_ipad').val(searchValue);
            $('#regip_filter_text').html(displayName);
            $('#regip_filter_release').show(1);
            
              
            
            break;
        case 8:
            $('#quick_search_lastvisit').val(searchValue);
            $('#lastdate_filter_text').html(searchValue);
            $('#lastdate_filter_release').show(1);
            break;
        case 9:
            $('#quick_search_regdate').val(searchValue);
            $('#regdate_filter_text').html(displayName);
            $('#regdate_filter_release').show(1);
            break;
        case 10:
            $('#quick_search_refurl').val($('#refurl_data_id_'+id).val());
            $('#refurl_filter_text').html(($('#refurl_data_id_'+id).val()).substr(0,15));
            $('#refurl_filter_text').attr('title',displayName);
            $('#refurl_filter_release').show(1);
            
            break;
        case 11:
            $('#quick_search_refid').val($('#refid_data_id_'+id).val());
            $('#refid_filter_text').html($('#user_referid_id_'+id).html());
            $('#refid_filter_release').show(1);
            break;
        case 12:
            $('#quick_search_lastip').val(searchValue);
            $('#lastip_filter_text').html(searchValue);
            $('#lastip_filter_release').show(1);
            break;
        case 13:
            $('#quick_search_lastvisit').val(searchValue);
            $('#lastdate_filter_text').html(displayName);
            $('#lastdate_filter_release').show(1);
            break;
        case 14:
            $('#quick_search_lastip').val(searchValue);
            $('#lastip_filter_text').html(displayName);
            $('#lastip_filter_release').show(1);
            break;
        case 15:
            $('#quick_search_status').val($('#status_data_id_'+id).val());
            $('#status_filter_text').html($('#status_main_id_'+id).html());
            $('#status_filter_release').show(1);
            break;
         case 16:
   
            $('#quick_search_country').val($('#country_data_id_'+id).val());
            $('#country_filter_text').html($('#user_country_id_'+id).html());
            $('#country_filter_release').show(1);
            break;
        case 17:
            $('#quick_search_refdomain').val($('#refdomain_data_id_'+id).val());
            $('#refdomain_filter_text').html($('#refdomain_data_id_'+id).val());
            $('#refdomain_filter_release').show(1);
            
            break;
         case 18:
            $('#quick_search_phone').val($('#phone_data_id_'+id).val());
            $('#phone_filter_text').html($('#phone_data_id_'+id).val());
            $('#phone_filter_release').show(1);
            
            break;
         case 19:
            $('#quick_search_contact').val($('#contact_data_id_'+id).val());
            $('#contact_filter_text').html($('#user_contact_id_'+id).html());
            $('#contact_filter_release').show(1);
            
            break;
        default:
            //put everything to blank?
            $('#quick_search_usergroup').val(-9);
            $('#quick_search_country').val(-9);
            $('#quick_search_browser').val(-9);
            $('#quick_search_os').val(-9);
            $('#quick_search_status').val(-9);
            $('#quick_search_language').val(-9);
            $('#orderby_quick').val(0);
            
            $('#order_direction').val(0);
            
            $('#quick_search_username').val('');
            $('#quick_search_userid').val('');
            
            $('#quick_search_email').val('');
            
            $('#quick_search_ipad').val('');
            $('#quick_search_lastvisit').val('');
            $('#quick_search_lastip').val('');
            $('#quick_search_regdate').val('');
            $('#quick_search_refurl').val('');
            $('#quick_search_refid').val('');
            
            $('#quick_search_phone').val('');
            $('#quick_search_contact').val(-9);
            
            $('#release_filter').hide(1);
          
            break;
        
    }
 
    searchUser('0,'+pagtionLength,2);
   
    
}

var specialUserIDFilter = 0;

function searchUser(limiter,source){
    
    var getStr,userid,usernamesearch,emailsearch,groupsearch,country,browser,os,status,language,orderby,direction,ipad,lastvisit,lastip,regdate,refid,refurl,refdomain,contact,phone;
    
    
    //see if special userid filter from dashboard 'new users' is set
    
    //todo:TD006JS:update to $.query.get();
    
    getStr = window.location.href;
 
    if (getStr.indexOf('userid')>0 && specialUserIDFilter != 2){
        specialUserIDFilter = 1;
        //do processing here
        filterFlag = true;
        $('#quick_search_userid').val(getStr.substr(getStr.indexOf('userid=')+7));
        $('#userid_filter_text').html($('#quick_search_userid').val());
        $('#userid_filter_release').show(1);
        $('#release_filter').show(1);
    }
   
    
    
    if (source == 2 || source ==3 || filterFlag){
        if(!filterFlag){
            $('#pageLimit').val(0);
        }
        
        //todo: need a way to reduce code base here
        groupsearch     = $('#quick_search_usergroup').val();
        if (groupsearch!=-9){
            
            $('#group_filter_text').html($('#quick_search_usergroup :selected').text());
            $('#group_filter_release').show(1);
        }
        country         = $('#quick_search_country').val();
        
        if (country!=-9){
            
            $('#country_filter_text').html($('#quick_search_country :selected').text());
            $('#country_filter_release').show(1);
        }
        browser         = $('#quick_search_browser').val();
        if (browser!=-9){
            
            $('#browser_filter_text').html($('#quick_search_browser :selected').text());
            $('#browser_filter_release').show(1);
        }
        os              = $('#quick_search_os').val();
        if (os!=-9){
            
            $('#os_filter_text').html($('#quick_search_os :selected').text());
            $('#os_filter_release').show(1);
        }
        status          = $('#quick_search_status').val();
        if (status!=-9){
            
            $('#status_filter_text').html($('#quick_search_status :selected').text());
            $('#status_filter_release').show(1);
        }
        language        = $('#quick_search_language').val();
        if (language!=-9){
            
            $('#lang_filter_text').html($('#quick_search_language :selected').text());
            $('#lang_filter_release').show(1);
        }
        
        contact        = $('#quick_search_contact').val();
        if (contact!=-9){
            
            $('#contact_filter_text').html($('#quick_search_contact :selected').text());
            $('#contact_filter_release').show(1);
        }
        usernamesearch  = $('#quick_search_username').val();
        if (usernamesearch!=''){
            
            $('#username_filter_text').html($('#quick_search_username').val());
            $('#username_filter_release').show(1);
        }
        emailsearch     = $('#quick_search_email').val();
        
        if (emailsearch!=''){
            
            $('#email_filter_text').html($('#quick_search_email').val());
            $('#email_filter_release').show(1);
        }
        userid     = $('#quick_search_userid').val();
        if (userid!=''){
            
            $('#userid_filter_text').html($('#quick_search_userid').val());
            $('#userid_filter_release').show(1);
        }
        
        phone     = $('#quick_search_phone').val();
        if (phone!=''){
            
            $('#phone_filter_text').html($('#quick_search_phone').val());
            $('#phone_filter_release').show(1);
        }
        
        ipad        =    $('#quick_search_ipad').val();
        lastvisit   =    $('#quick_search_lastvisit').val();
        lastip      =    $('#quick_search_lastip').val();
        regdate     =    $('#quick_search_regdate').val();
        refurl      =    $('#quick_search_refurl').val();
        refid       =    $('#quick_search_refid').val();
        refdomain   =    $('#quick_search_refdomain').val();
        
        if (source==2){
            filterFlag= true;
        }
        
    }
    else{
        groupsearch     = '';
        country         = '';
        browser         = '';
        os              = '';
        status          = '';
        language        = '';
        usernamesearch  = '';
        emailsearch     = '';
        userid          = '';
        
        ipad            =  '';
        lastvisit       =  '';
        lastip          =  '';
        regdate         =  '';
        refurl          =  '';
        refid           =  '';
        refdomain       =  '';
        
        phone           = '';
        contact         = '';
        
        
    }
    orderby = $('#orderby_quick').val();
    
    direction= $('#order_direction').val();
    
   // $('#small_search_loader').fadeIn(100,function(){
       // $('#large_search_loader').fadeIn(100,function(){
            $.post("../ajax/search_full_user.php",{userid:userid,
                                                   username:usernamesearch,
                                                   group:groupsearch,
                                                   email:emailsearch,
                                                   limit:limiter,
                                                   orderby:orderby,
                                                   direction:direction,
                                                   country:country,
                                                   browser:browser,
                                                   os:os,
                                                   lang:language,
                                                   status:status,
                                                   lastvisit:lastvisit,
                                                   lastip:lastip,
                                                   ipad:ipad,
                                                   regdate:regdate,
                                                   refurl:refurl,
                                                   refid:refid,
                                                   refdomain:refdomain,
                                                   quick:0,
                                                   phone:phone,
                                                   contact:contact
                                                   },function(dataReturn){
                    
                  //alert(dataReturn);
                   
                   var obj = jQuery.parseJSON(dataReturn);
                         
                   if (obj.Ack=="success"){
                    
                    //hide popup and show the actual results
                    
                    $.post("../ajax/user_repeater.php",function(pageData){
                           
                        
                            $('#resultsset').html('');
                            var dataArray = obj.data;
                            var totalCount = obj.total_count;
                            var optionsBloc='';
                            if (source == 2 || source == 1 || source==3){
                                //build up drop down for pagation
                                pageTotals = Math.ceil((totalCount/10));
                               
                              
                                if (pageTotals==0){
                                    pageTotals=1;
                                }                        
                                //alert(pageTotals+'----'+totalCount);                     
                                if (totalCount>0){
                                    for (i=0;i<pageTotals;i++){
                                    
                                    optionsBloc += '<option value="'+i+'" >'+Number(i+1)+'</option>' ;
                                    
                                    }
                                    if (source!=1 || limiter=='0,'+pagtionLength){
                                        $('#pageLimit').html(optionsBloc);
                                        $('#pagationBlock').show();
                                    }
                                    
                                    
                                }
                                else{
                                    $('#pagationBlock').hide();
                                }
                                
                            }
            
            
                      // alert(totalCount);
                            var fullset = '';
                            var pageBuildUp='';
                            countUser=0;
                            for (x in dataArray){
                                
                                /*
                                    may change to a DOM based system - no, it's harder to develop templates
                                */
                                
                                pageBuildUp += pageData;
                                /*
                                    not using regexp for user inputed text because of IE7-8 issue with
                                    replacing text with $_ in the text(username in this case) (very ugly issue!)
                                    
                                    to do: figure out what is going on and change back
                                */
                                pageBuildUp = pageBuildUp.replace(/##screenname##/gi,dataArray[x]['screenname']);
                                pageBuildUp = pageBuildUp.replace('##screenname_email##',dataArray[x]['screenname']);
                                pageBuildUp = pageBuildUp.replace(/##userid##/gi,dataArray[x]['userid']);
                                pageBuildUp = pageBuildUp.replace(/##date_joined##/gi,dataArray[x]['date_joined']);
                                pageBuildUp = pageBuildUp.replace(/##email##/gi,dataArray[x]['email']);
                                //gravatar
                                pageBuildUp = pageBuildUp.replace(/##gravatar##/gi,'http://www.gravatar.com/avatar/' + hex_md5((dataArray[x]['email']))+'.jpg');
                                

                                
                                pageBuildUp = pageBuildUp.replace(/##ipad##/gi,dataArray[x]['ipad']);
                                pageBuildUp = pageBuildUp.replace(/##last_visit##/gi,dataArray[x]['last_visit']);
                                pageBuildUp = pageBuildUp.replace(/##lastip##/gi,dataArray[x]['lastip']);

                                pageBuildUp = pageBuildUp.replace('##usergroup##',dataArray[x]['name']);
                                pageBuildUp = pageBuildUp.replace('##usergroup_displayname##',dataArray[x]['name']);
                                pageBuildUp = pageBuildUp.replace(/##usergroup_code##/gi,dataArray[x]['usergroup']);
                                
                                pageBuildUp = pageBuildUp.replace(/##valid_code##/gi,dataArray[x]['valid']);
                                switch (dataArray[x]['valid']){
                                    
                                    case '1':
                                        
                                        pageBuildUp = pageBuildUp.replace(/##validcolor##/gi,'greentext');
                                        pageBuildUp = pageBuildUp.replace(/##valid##/gi,'activated');
                                        pageBuildUp = pageBuildUp.replace(/##statusvalue##/gi,'2');
                                        pageBuildUp = pageBuildUp.replace(/##banacttext##/gi,'ban user');
                                        pageBuildUp = pageBuildUp.replace(/##banactcolor##/gi,'reddeletetext');
                                       
                                        break;
                                    case '2':
                                        pageBuildUp = pageBuildUp.replace(/##validcolor##/gi,'redtext');
                                        pageBuildUp = pageBuildUp.replace(/##valid##/gi,'banned/blocked');
                                        pageBuildUp = pageBuildUp.replace(/##statusvalue##/gi,'1');
                                        pageBuildUp = pageBuildUp.replace(/##banacttext##/gi,'activate');
                                        pageBuildUp = pageBuildUp.replace(/##banactcolor##/gi,'greentextbold');
                                        break;
                                    case '0':
                                        pageBuildUp = pageBuildUp.replace(/##validcolor##/gi,'bluetext');
                                        pageBuildUp = pageBuildUp.replace(/##valid##/gi,'awaiting activation');
                                        pageBuildUp = pageBuildUp.replace(/##statusvalue##/gi,'1');
                                        pageBuildUp = pageBuildUp.replace(/##banacttext##/gi,'activate');
                                        pageBuildUp = pageBuildUp.replace(/##banactcolor##/gi,'greentextbold');
                                        break;
                                }
                                switch (dataArray[x]['useractive30']){
                                    
                                    case '0':
                                        
                                        pageBuildUp = pageBuildUp.replace(/##30daycolor##/gi,'redtext');
                                        pageBuildUp = pageBuildUp.replace(/##useractive##/gi,'no');
                                       
                                       
                                        break;
                                    case '1':
                                        
                                        pageBuildUp = pageBuildUp.replace(/##30daycolor##/gi,'greentext');
                                        pageBuildUp = pageBuildUp.replace(/##useractive##/gi,'yes');
                                       
                                       
                                        break;
                                    
                                   
                                }
                                
                                if (dataArray[x]['contact']=='1'){
                                    pageBuildUp = pageBuildUp.replace(/##contact##/gi,'yes');
                                   
                                }
                                else{
                                    pageBuildUp = pageBuildUp.replace(/##contact##/gi,'no');
                                  
                                }
                                pageBuildUp = pageBuildUp.replace(/##contact_code##/gi,dataArray[x]['contact']);
                                pageBuildUp = pageBuildUp.replace(/##phone##/gi,dataArray[x]['phone']);
                                
                                pageBuildUp = pageBuildUp.replace(/##refid##/gi,dataArray[x]['refid']);
                                pageBuildUp = pageBuildUp.replace(/##refurl##/gi,makeTextSmall(dataArray[x]['refurl'],65));

                                
                                if(dataArray[x]['refurl']!='type-in-traffic' && dataArray[x]['refurl'] != 'admin-created'){
                                   
                                    pageBuildUp = pageBuildUp.replace(/##refurl_href##/gi,dataArray[x]['refurl']);
                                }
                                else{
                                    pageBuildUp = pageBuildUp.replace(/##refurl_href##/gi,'#');
                                }
                                
                                pageBuildUp = pageBuildUp.replace(/##refdomain##/gi,dataArray[x]['refdomain']);
                                pageBuildUp = pageBuildUp.replace(/##os##/gi,dataArray[x]['os_name']);
                                pageBuildUp = pageBuildUp.replace(/##os_code##/gi,dataArray[x]['os_code']);
                                pageBuildUp = pageBuildUp.replace(/##browser##/gi,dataArray[x]['browser_name']);
                                pageBuildUp = pageBuildUp.replace(/##browser_code##/gi,dataArray[x]['browser_code']);
                                pageBuildUp = pageBuildUp.replace(/##lang##/gi,dataArray[x]['language']);
                                pageBuildUp = pageBuildUp.replace(/##lang_code##/gi,dataArray[x]['lang_code']);
                                pageBuildUp = pageBuildUp.replace(/##country_code##/gi,dataArray[x]['country_code']);
                                pageBuildUp = pageBuildUp.replace(/##country##/gi,nameCap(dataArray[x]['country']));
                                
                                countUser++;
                            }
                            
                           
                            $('#resultsset').html(pageBuildUp);
                            
                            
                            
                            
                           /* $('#countPageQuick').html(countPages);
                            if (countPages>1){
                                $('#resultsText').html(' matching pages found');
                            }
                            else{
                                $('#resultsText').html(' matching page found');
                            }*/
                        
                        });
                    
                   }
                   else{
                        //no results found
                        $('#resultsset').html('No results found');
                         $('#pagationBlock').hide();
                        
                   }
                    if (source==2){
                        $('#release_filter').show(1);
                    }
                    else if (source!=3 && !filterFlag  ){
                        $('#release_filter').hide(1);
                    }
                   closeAllBoxNoModel();
                 //   $('#small_search_loader').hide(1);
                 //   $('#large_search_loader').hide(1);
                    
            
            });
       // });
  //  });
    
    
}





/*site stats reports */


var overview_details_current_days = '365', overview_current_type = 'os';
function overview_details(type,days){
    overview_details_current_days = days = (days==undefined || days=='')?overview_details_current_days:days;
    overview_current_type = type = (type==undefined || type=='')?$('#rr_narrow_by_sel_overview').val():type;
    var overview='overview';//lazy hack
    $('#sparky_user_overview_days,#sparky_vs_overview_days').html(days);
        	
    $('.rep_link_overviewd').css({'font-weight':'normal','text-decoration':'none','color':'#535353'});

    $('#rep_link_overviewd_'+days+'_days').css({'font-weight':'bold','text-decoration':'underline','color':'#FF6600'});
	
   var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('loading report...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
           
    $.post("../ajax/ub_get_stats_overview.php",{type:type,
					    days:days,orderby:'users'},function(dataReturn){
                                              
            //if fail but message in rep_overview_errorbox
            var obj = jQuery.parseJSON(dataReturn);
            $('#site_wide_load'+load_inline+glass).fadeOut(100);
            if (obj.Ack=="success"){
		   var width100='',total=0,colorclass='', tracker=0,total=0,total_vs=0,conversion=0; altflag = false, countRows = parseInt(obj.data.count),repeater = obj.data.repeater, data = obj.data.data, stat_table_buildup='';
		
		   //alert(0);
		   /*
			var data_new = new google.visualization.DataTable();
			data_new.addColumn('string', obj.data.column1);
			data_new.addColumn('number', obj.data.column2);
			data_new.addRows(obj.data.count);
			
			  //stat_table_buildup += '<tr><td>'+obj.data.column1+'</td><td>'+obj.data.column2+'</td><td>Precent</td></tr>';
			 */
			   
		 
			for (x=0;x<countRows;x++){
				
				
					
					//data_new.setValue(x, 0, String(data[x]['name']));
					//data_new.setValue(x, 1, parseInt(data[x]['stat']));
					
					total = total + parseInt(isnull(data[x]['stat'],true));
                                        total_vs = total_vs + parseInt(isnull(data[x]['stat_vs'],true));
                                        
				tracker ++;
			
			}
                       // alert(total_vs +'--'+total);
			//
			//x=0;x<10 && x<countRows;x++
			var big_data_hider='',runid=0,first_set=true,result_count=1,results_counter2=1,mini_main_limit;
			
			
			mini_main_limit=10;
			
                        //debig='';
                      
			
			for (x in data){
                            /*
                                this should never set to unknown unless the data was input
                                manually and incorrectly ie missing ID values in country/browser etc
                                which if where known to the system would have correct unknown values
                                
                            */
                            data[x]['name'] = (isset_zero(data[x]['name'],false))?data[x]['name']:'unknown';
                            data[x]['code'] = (isset_zero(data[x]['code'],false))?data[x]['code']:'';
                            //-------------------------------------------------------------------------------------
                              
				if (result_count<=mini_main_limit){
				    result_count++;
				    stat_table_buildup +=repeater;
				}
				else{
				    
				    result_count=1;
				    
				      if (first_set){
					     
						      big_data_hider += '<div class="rep_page_'+overview+'" id="rep_pagation_block_'+overview+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					    
					    
					     first_set=false;
					}
					else{
					    
						      big_data_hider += '<div class="rep_page_'+overview+' hiddenText" id="rep_pagation_block_'+overview+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ;
					     
					     
					     
					}
				    stat_table_buildup  = repeater;
				    results_counter2++;
				    result_count++;
				    
				}
				
				stat_table_buildup = stat_table_buildup.replace(/##runid##/gi,runid);
				runid++;
				
				if (altflag){
					
					stat_table_buildup = stat_table_buildup.replace(/##alt##/gi,'_alt');
					altflag = false;
				}
				else{
					stat_table_buildup = stat_table_buildup.replace(/##alt##/gi,'');
					altflag = true;
				}
				
				
				if (x==0){
				    stat_table_buildup = stat_table_buildup.replace("##rep_first_minibar##",'rep_element_name_top');
				    colorclass='rep_element_name_top';
				    
				    
				}
				else{
				    colorclass='rep_element_name';
				    stat_table_buildup = stat_table_buildup.replace("##rep_first_minibar##",'rep_element_name');
				}
                                
                                if (jQuery.trim(data[x]['name'])!=''){
                                    switch (type){
                                        
                                        case 'url':
                                           
					   
							if (data[x]['name'].length >25){
								
								stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'<a class="'+colorclass+'" style="font-size:12px; padding-left:0px;" href="'+data[x]['name']+'" target="_blank" >'+makeTextSmall(data[x]['name'],25)+'</a>');
								stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
								
							}
							else{
								
								stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'<a class="'+colorclass+'" style="font-size:12px; padding-left:0px;" href="'+data[x]['name']+'" target="_blank" >'+data[x]['name']+'</a>');  
								stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
								
							}
							    
						   
					    
                                            break;
                                        case 'location':
                                            
                                                if (data[x]['name'].length >20){
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,makeTextSmall(data[x]['name'],20)); 
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
                                                }else{
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
                                                }
                                            
                                            break;
                                        default:
                                            
                                                if (data[x]['name'].length >20){
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,makeTextSmall(data[x]['name'],20)); 
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
                                                }else{
                                                     stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
                                                }
                                            
    
                                        break;
                                        
                                       
                                    }
                                    
                                    
                                   
                                    
                                }
                                else{
                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'--none--');
                                }
                               // stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);
                               stat_table_buildup = stat_table_buildup.replace("##data_type##",overview);
                                stat_table_buildup = stat_table_buildup.replace("##type##",type);
				stat_table_buildup = stat_table_buildup.replace("##count##",x);
				stat_table_buildup = stat_table_buildup.replace("##user_spark##",data[x]['sparky']);
				stat_table_buildup = stat_table_buildup.replace("##visitor_spark##",data[x]['sparky_vs']);
                                if(data[x]['code']==''){
                                    stat_table_buildup = stat_table_buildup.replace(/##content_code##/gi,'--none--');
                                }
				else{
                                    stat_table_buildup = stat_table_buildup.replace(/##content_code##/gi,(data[x]['code']));
                                }
				stat_table_buildup = stat_table_buildup.replace(/##users##/gi,isnull(data[x]['stat_f'],false));
                                stat_table_buildup = stat_table_buildup.replace("##visit##",isnull(data[x]['stat_vs_f'],false));
				
                                if (parseInt(data[x]['stat'])){
                                    if((((parseInt(isnull(data[x]['stat'],true))/total)*100).toFixed(1))==100.0){
                                        //alert('100');
                                        width100 = 'width:45px';
                                    }
                                    else{
                                        //alert('<100');
                                        width100 = 'width:40px;'
                                    }
                                    	stat_table_buildup = stat_table_buildup.replace(/##precent##/gi,(((parseInt(isnull(data[x]['stat'],true))/total)*100).toFixed(1)));

                                }
                                else{
                                    	stat_table_buildup = stat_table_buildup.replace(/##precent##/gi,'0.0');

                                }
                                //alert('os: '+data[x]['name']+' - total:'+total_vs);
				if (parseInt(total_vs)!=0){
                                    
                                    if((((parseInt(isnull(data[x]['stat_vs'],true))/total_vs)*100).toFixed(1))==100.0){
                                        //alert('100');
                                        stat_table_buildup = stat_table_buildup.replace("##width100##",'width:45px');
                                    }
                                    else{
                                        //alert('<100');
                                        stat_table_buildup = stat_table_buildup.replace("##width100##",'width:40px');
                                    }
                                    	stat_table_buildup = stat_table_buildup.replace("##precent_vs##",(((parseInt(isnull(data[x]['stat_vs'],true))/total_vs)*100).toFixed(1)));

                                }
                                else{
                                    	stat_table_buildup = stat_table_buildup.replace("##precent_vs##",'0.0');

                                }
                                conversion = (((parseInt(isnull(data[x]['stat'],true))/parseInt(isnull(data[x]['stat_vs'],true)))*100).toFixed(1));
                                if (conversion=='Infinity'){
                                    conversion='0.0';
                                }
                                stat_table_buildup = stat_table_buildup.replace("##conversion##",isnull(conversion,false));
                                
				
				
				
				
			
			}
			
			
			
			
			
			   stat_table_buildup = stat_table_buildup.replace('##width100##',width100);
                           
                                        if (first_set){
					     
						      big_data_hider += '<div class="rep_page_'+overview+'" id="rep_pagation_block_'+overview+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					     
					    
					     first_set=false;
					}
					else{
					     
						      big_data_hider += '<div class="rep_page_'+overview+' hiddenText" id="rep_pagation_block_'+overview+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ;
					     
					     
					     
					}
			
		
			
			
			
				
		
			
			   $('#rep_minibars_results_'+overview).html(big_data_hider);
				
				
				
				    var pageTotals = Math.ceil((countRows/mini_main_limit));
				    var optionsBloc ='';
				  
				     if (pageTotals==0){
					 pageTotals=1;
				     }                        
							  
				     if (countRows>0){
					 for (i=0;i<pageTotals;i++){
					 
						    optionsBloc += '<option value="'+(i+1)+'" >'+Number(i+1)+'</option>' ;
					    
					    
					 
					 }
					 
					 optionsBloc = '<select id="rep_pagation_select_'+overview+'">'+optionsBloc+'</select>';
				      
					  //$('#rep_pagation_main_'+overview).html(optionsBloc).show(); 
				      
					  
					 
				
					 
					 
				     }
				     else{
					 $('#rep_pagation_main_'+overview).hide();
				     }
				    
				       $('#rep_pagation_main_'+overview).html(optionsBloc).show();
				       $('#rep_pagation_select_'+overview).unbind('change');
				       $('#rep_pagation_select_'+overview).bind('change',function(event){
						      
                                        $('.rep_page_overview').hide(1);
                                        $('#rep_pagation_block_overview_'+$('#rep_pagation_select_overview').val()).show(1);
	  
                                                      
						
							      
				  
				       });
				    
				
				 
				 
				
			
			$('.rep_reports_minibars').corner('5px','keep');
			$('.rep_reports_minibars').bind('mouseover',function(event){
               
				    $(this).css({'background-color':'#fff'});
                                            
                
		        });
			$('.rep_reports_minibars').bind('mouseout',function(event){
               
				    $(this).css({'background-color':'#fafafa'});
                                            
                
		        });
                        
                       
                        
                        //change heights
                        //dashmain_float
			
			
		$('.corners').corner('5px');
                
                $('div.stats_result').each(function() {

				$(this).qtip({content: $(this).children('.detailed_stats'),
                                                                    
                                    style:{
                                        classes: 'ui-tooltip-light ui-tooltip-shadow ui-tooltip-microblog ui-tooltip-roar', 
                                        tip: { offset: 5 },
                                        width:500
                                     },
                                     position: {
                                        at:'right center',
                                        my:'left center',
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
                                     show:{
                                        solo:true
                                        },
                                      hide: {
                                            event: 'unfocus'
					    }

                                     });
			
		    });
                             
                         
		     
                $('.content_qtip').qtip({content: {attr: 'title'},
                                                                    
                                    style:{
                                        classes: 'ui-tooltip-tipsy ui-tooltip-shadow ui-tooltip-microblog', 
                                        tip: { offset: 5 },
                                        width:300
                                     },
                                     position: {
                                        at:'bottom center',
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
                                     show:{
                                        solo:true
                                        },
                                      hide: {
                                            event: 'mouseout'
                                            
					    }

                                     });
			
		  
		 //need to do grpahs
                 $('#overview_spark_ut').html('<img src="https://chart.googleapis.com/chart?cht=ls&chs=505x230&chco=FF6600&chd=t:'+obj.sparky+'" />');
                 $('#overview_spark_vs').html('<img src="https://chart.googleapis.com/chart?cht=ls&chs=505x230&chco=34A5C1&chd=t:'+obj.sparky_vs+'" />');
                 
                  $('#rep_'+overview+'_errorbox').html('<br/><br/>loading report...').hide(1);
                   $('#rep_'+overview+'_databox').fadeIn(500);
                   
                        
		}
		
            else{
               $('#rep_'+overview+'_databox').hide(1);
               $('#rep_'+overview+'_errorbox').html('<center><br/><br/>'+obj.Msg+'<br/><br/></center>').show(1);
                        
                
            }
	    if ($('#dashmain_ov').height()!=$('#dashmain_float_ov').outerHeight()){
		 $('#dashmain_ov').height($('#dashmain_float_ov').outerHeight());
	    }
           
            
    
	   });
	});
    });
   
}

var current_lf_loc='false';
function lf_list(loc,limiter,source){
    $('#lf_main').html('loading logs...');
    var type='login' ;
    current_lf_loc = loc = (loc==undefined || jQuery.trim(loc)=='')?current_lf_loc:loc;
    $('.rep_links_buttons').css({'background-color':'transparent','color':'#333'});
    $('#login_links_'+jQuery.trim(loc)).css({'background-color':'#7F7F7F','color':'#fff'});
    
    
    if(limiter==undefined || jQuery.trim(limiter)==''){
	    $('#lf_log_pagation').val()
	
	    limiter = parseInt($('#lf_log_pagation').val())*10;

	    if (limiter<0){
		limiter = 0;
	    }
         
	    limiter += ',10';
    }
    
    else{
	limiter;
    }
    
    
      
     var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('loading report...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
    $.post("../ajax/ub_get_main_attempts.php",{type:type,loc:current_lf_loc,limit:limiter},function(dataReturn){
	var obj = jQuery.parseJSON(dataReturn);
	var data = obj.data;
	$('#site_wide_load'+load_inline+glass).fadeOut(100);
	if (obj.Ack=="success"){
	    var buildup='',totalCount = obj.total_count,optionsBloc='';
	  
	
	   if(source==1){
	  
		var pageTotals = Math.ceil((totalCount/10));
		
		if (pageTotals==0){
			    pageTotals=1;
		}
		
		if (totalCount>0){
			    for (i=0;i<pageTotals;i++){
			    
				optionsBloc += '<option value="'+i+'" > page '+Number(i+1)+'</option>' ;
			    
			    }
			    
		}
	      
		$('#lf_log_pagation').html(optionsBloc);
	   }
	  
	    for (x in data){
		
		buildup += obj.repeater;
		buildup = buildup.replace('##attempts##',data[x]['counter']);
		buildup = buildup.replace('##ipad##',data[x]['ipad']);
		
		buildup = buildup.replace(/##setid##/g,data[x]['setid']);
	
		buildup = buildup.replace('##todate##',data[x]['todate']);
		buildup = buildup.replace('##fromdate##',data[x]['fromdate']);
		buildup = buildup.replace('##refurl##',data[x]['refurl']);
		buildup = buildup.replace('##location##',data[x]['name']);
		buildup = buildup.replace('##loc_class##',data[x]['loc']);
		
	    }
	    
	    $('#lf_main').html(buildup).slideDown(400);
	    $('.ub_corners3').corner('3px');
	    
	}
	else{
	    $('#lf_main').html(obj.Msg);
	}
    });
     });
     });
}

function showattempts(type,id){
    switch (type){
	case 'login':
	    if($('#login-all-attempts-'+id).is(':hidden')){
		if(jQuery.trim($('#login-all-attempts-'+id).html())==''){
		    
		    //get data
		    //id value must be set parent id value
		    $('#login-load-msg-'+id).show(1,function(){
			
			$.post("../ajax/ub_get_all_attempts.php",{id:id,type:type},function(dataReturn){
				var obj = jQuery.parseJSON(dataReturn);
				var data = obj.data;
				if (obj.Ack=="success"){
				    var buildup='';
				  
				    for (x in data){
					
					buildup += obj.repeater;
					
					buildup = buildup.replace('##ipad##',data[x]['ipad']);
					
					buildup = buildup.replace('##name##',data[x]['username']);
				
					//buildup = buildup.replace('##phash##',data[x]['password']);
					buildup = buildup.replace('##current_attempt##',data[x]['current_attempt']);
					buildup = buildup.replace('##refurl##',data[x]['refurl']);
					buildup = buildup.replace('##location##',data[x]['name']);
					
				    }
				    
				    $('#login-all-attempts-'+id).html(buildup).slideDown(400);
				    $('.ub_corners3').corner('3px');
				    $('#login-load-msg-'+id).hide(1);
				}
				else{
				    $('#login-load-msg-'+id).hide(1);
				}
				
				
			});
			
			
			
		    });
		    
		}
		else{
		    $('#login-all-attempts-'+id).slideDown(400);
		}
	    }
	    else{
		$('#login-all-attempts-'+id).slideUp(400);
	    }
	    break;
	case 'dos':
	    break;
	case 'sql':
	    break;
	case 'xss':
	    break;
    }
}


var lp_details_current_days = '365', lp_current_type = 'os';
function lp_details(type,days){
    lp_details_current_days = days = (days==undefined || days=='')?lp_details_current_days:days;
    lp_current_type = type = (type==undefined || type=='')?$('#rr_narrow_by_sel_lp').val():type;
    var lp='lp';//lazy hack
    $('#sparky_user_lp_days,#sparky_vs_lp_days').html(days);
        	
    $('.rep_link_lpd').css({'font-weight':'normal','text-decoration':'none','color':'#535353'});

    $('#rep_link_lpd_'+days+'_days').css({'font-weight':'bold','text-decoration':'underline','color':'#FF6600'});
	
    
   var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('loading report...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
           
    $.post("../ajax/ub_get_stats_lp.php",{type:type,
					    days:days,url:lp_current_url,orderby:'users'},function(dataReturn){
                                              
            //if fail but message in rep_lp_errorbox
            var obj = jQuery.parseJSON(dataReturn);
             $('#site_wide_load'+load_inline+glass).fadeOut(100);
            if (obj.Ack=="success"){
		   var width100='',total=0,colorclass='', tracker=0,total=0,total_vs=0,conversion=0; altflag = false, countRows = parseInt(obj.data.count),repeater = obj.data.repeater, data = obj.data.data, stat_table_buildup='';
		
		   //alert(0);
		   /*
			var data_new = new google.visualization.DataTable();
			data_new.addColumn('string', obj.data.column1);
			data_new.addColumn('number', obj.data.column2);
			data_new.addRows(obj.data.count);
			
			  //stat_table_buildup += '<tr><td>'+obj.data.column1+'</td><td>'+obj.data.column2+'</td><td>Precent</td></tr>';
			 */
			   
		 
			for (x=0;x<countRows;x++){
				
				
					
					//data_new.setValue(x, 0, String(data[x]['name']));
					//data_new.setValue(x, 1, parseInt(data[x]['stat']));
					
					total = total + parseInt(isnull(data[x]['stat'],true));
                                        total_vs = total_vs + parseInt(isnull(data[x]['stat_vs'],true));
                                        
				tracker ++;
			
			}
                       // alert(total_vs +'--'+total);
			//
			//x=0;x<10 && x<countRows;x++
			var big_data_hider='',runid=0,first_set=true,result_count=1,results_counter2=1,mini_main_limit;
			
			
			mini_main_limit=10;
			
                        //debig='';
                      
			
			for (x in data){
                            /*
                                this should never set to unknown unless the data was input
                                manually and incorrectly ie missing ID values in country/browser etc
                                which if where known to the system would have correct unknown values
                                
                            */
                            data[x]['name'] = (isset_zero(data[x]['name'],false))?data[x]['name']:'unknown';
                            data[x]['code'] = (isset_zero(data[x]['code'],false))?data[x]['code']:'';
                            //-------------------------------------------------------------------------------------
                              
				if (result_count<=mini_main_limit){
				    result_count++;
				    stat_table_buildup +=repeater;
				}
				else{
				    
				    result_count=1;
				    
				      if (first_set){
					     
						      big_data_hider += '<div class="rep_page_'+lp+'" id="rep_pagation_block_'+lp+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					    
					    
					     first_set=false;
					}
					else{
					    
						      big_data_hider += '<div class="rep_page_'+lp+' hiddenText" id="rep_pagation_block_'+lp+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ;
					     
					     
					     
					}
				    stat_table_buildup  = repeater;
				    results_counter2++;
				    result_count++;
				    
				}
				
				stat_table_buildup = stat_table_buildup.replace(/##runid##/gi,runid);
				runid++;
				
				if (altflag){
					
					stat_table_buildup = stat_table_buildup.replace(/##alt##/gi,'_alt');
					altflag = false;
				}
				else{
					stat_table_buildup = stat_table_buildup.replace(/##alt##/gi,'');
					altflag = true;
				}
				
				
				if (x==0){
				    stat_table_buildup = stat_table_buildup.replace("##rep_first_minibar##",'rep_element_name_top');
				    
				    colorclass='rep_element_name_top';
				    
				}
				else{
				    colorclass='rep_element_name';
				    stat_table_buildup = stat_table_buildup.replace("##rep_first_minibar##",'rep_element_name');
				}
                                
                                if (jQuery.trim(data[x]['name'])!=''){
                                    switch (type){
                                        
                                        case 'url':
                                           
					   
							if (data[x]['name'].length >25){
								
								stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'<a class="'+colorclass+'" style="font-size:12px; padding-left:0px;" href="'+data[x]['name']+'" target="_blank" >'+makeTextSmall(data[x]['name'],25)+'</a>');
								stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
								
							}
							else{
								
								stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'<a  href="'+data[x]['name']+'" target="_blank" class="'+colorclass+'" style="font-size:12px; padding-left:0px;">'+data[x]['name']+'</a>');  
								stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
								
							}
							    
						   
					    
                                            break;
                                        case 'location':
                                            
                                                if (data[x]['name'].length >20){
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,makeTextSmall(data[x]['name'],20)); 
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
                                                }else{
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
                                                }
                                            
                                            break;
                                        default:
                                            
                                                if (data[x]['name'].length >20){
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,makeTextSmall(data[x]['name'],20)); 
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
                                                }else{
                                                     stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
                                                }
                                            
    
                                        break;
                                        
                                       
                                    }
                                    
                                    
                                   
                                    
                                }
                                else{
                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'--none--');
                                }
                               // stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);
                               stat_table_buildup = stat_table_buildup.replace("##data_type##",lp);
                                stat_table_buildup = stat_table_buildup.replace("##type##",type);
				stat_table_buildup = stat_table_buildup.replace("##count##",x);
				stat_table_buildup = stat_table_buildup.replace("##user_spark##",data[x]['sparky']);
				stat_table_buildup = stat_table_buildup.replace("##visitor_spark##",data[x]['sparky_vs']);
                                if(data[x]['code']==''){
                                    stat_table_buildup = stat_table_buildup.replace(/##content_code##/gi,'--none--');
                                }
				else{
                                    stat_table_buildup = stat_table_buildup.replace(/##content_code##/gi,(data[x]['code']));
                                }
				stat_table_buildup = stat_table_buildup.replace(/##users##/gi,isnull(data[x]['stat_f'],false));
                                stat_table_buildup = stat_table_buildup.replace("##visit##",isnull(data[x]['stat_vs_f'],false));
				
                                if (parseInt(data[x]['stat'])){
                                    if((((parseInt(isnull(data[x]['stat'],true))/total)*100).toFixed(1))==100.0){
                                        //alert('100');
                                        width100 = 'width:45px';
                                    }
                                    else{
                                        //alert('<100');
                                        width100 = 'width:40px;'
                                    }
                                    	stat_table_buildup = stat_table_buildup.replace(/##precent##/gi,(((parseInt(isnull(data[x]['stat'],true))/total)*100).toFixed(1)));

                                }
                                else{
                                    	stat_table_buildup = stat_table_buildup.replace(/##precent##/gi,'0.0');

                                }
                                //alert('os: '+data[x]['name']+' - total:'+total_vs);
				if (parseInt(total_vs)!=0){
                                    
                                    if((((parseInt(isnull(data[x]['stat_vs'],true))/total_vs)*100).toFixed(1))==100.0){
                                        //alert('100');
                                        stat_table_buildup = stat_table_buildup.replace("##width100##",'width:45px');
                                    }
                                    else{
                                        //alert('<100');
                                        stat_table_buildup = stat_table_buildup.replace("##width100##",'width:40px');
                                    }
                                    	stat_table_buildup = stat_table_buildup.replace("##precent_vs##",(((parseInt(isnull(data[x]['stat_vs'],true))/total_vs)*100).toFixed(1)));

                                }
                                else{
                                    	stat_table_buildup = stat_table_buildup.replace("##precent_vs##",'0.0');

                                }
                                conversion = (((parseInt(isnull(data[x]['stat'],true))/parseInt(isnull(data[x]['stat_vs'],true)))*100).toFixed(1));
                                if (conversion=='Infinity'){
                                    conversion='0.0';
                                }
                                stat_table_buildup = stat_table_buildup.replace("##conversion##",isnull(conversion,false));
                                
				
				
				
				
			
			}
			
			
			
			
			
			   stat_table_buildup = stat_table_buildup.replace('##width100##',width100);
                           
                                        if (first_set){
					     
						      big_data_hider += '<div class="rep_page_'+lp+'" id="rep_pagation_block_'+lp+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					     
					    
					     first_set=false;
					}
					else{
					     
						      big_data_hider += '<div class="rep_page_'+lp+' hiddenText" id="rep_pagation_block_'+lp+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ;
					     
					     
					     
					}
			
		
			
			
			
				
		
			
			   $('#rep_minibars_results_'+lp).html(big_data_hider);
				
				
				
				    var pageTotals = Math.ceil((countRows/mini_main_limit));
				    var optionsBloc ='';
				  
				     if (pageTotals==0){
					 pageTotals=1;
				     }                        
							  
				     if (countRows>0){
					 for (i=0;i<pageTotals;i++){
					 
						    optionsBloc += '<option value="'+(i+1)+'" >'+Number(i+1)+'</option>' ;
					    
					    
					 
					 }
					 
					 optionsBloc = '<select id="rep_pagation_select_'+lp+'">'+optionsBloc+'</select>';
				      
					  //$('#rep_pagation_main_'+lp).html(optionsBloc).show(); 
				      
					  
					 
				
					 
					 
				     }
				     else{
					 $('#rep_pagation_main_'+lp).hide();
				     }
				    
				       $('#rep_pagation_main_'+lp).html(optionsBloc).show();
				       $('#rep_pagation_select_'+lp).unbind('change');
				       $('#rep_pagation_select_'+lp).bind('change',function(event){
						      
                                        $('.rep_page_lp').hide(1);
                                        $('#rep_pagation_block_lp_'+$('#rep_pagation_select_lp').val()).show(1);
	  
                                                      
						
							      
				  
				       });
				    
				
				 
				 
				
			
			$('.rep_reports_minibars').corner('5px','keep');
			$('.rep_reports_minibars').bind('mouseover',function(event){
               
				    $(this).css({'background-color':'#fff'});
                                            
                
		        });
			$('.rep_reports_minibars').bind('mouseout',function(event){
               
				    $(this).css({'background-color':'#fafafa'});
                                            
                
		        });
                        
                       
                        
                        //change heights
                        //dashmain_float
                        $('#dashmain').height($('#dashmain_float').outerHeight());
			
		$('.corners').corner('5px');
                
                $('div.stats_result').each(function() {

				$(this).qtip({content: $(this).children('.detailed_stats'),
                                                                    
                                    style:{
                                        classes: 'ui-tooltip-light ui-tooltip-shadow ui-tooltip-microblog ui-tooltip-roar', 
                                        tip: { offset: 5 },
                                        width:500
                                     },
                                     position: {
                                        at:'right center',
                                        my:'left center',
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
                                     show:{
                                        solo:true
                                        },
                                      hide: {
                                            event: 'unfocus'
					    }

                                     });
			
		    });
                             
                         
		     
                $('.content_qtip').qtip({content: {attr: 'title'},
                                                                    
                                    style:{
                                        classes: 'ui-tooltip-tipsy ui-tooltip-shadow ui-tooltip-microblog', 
                                        tip: { offset: 5 },
                                        width:300
                                     },
                                     position: {
                                        at:'bottom center',
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
                                     show:{
                                        solo:true
                                        },
                                      hide: {
                                            event: 'mouseout'
                                            
					    }

                                     });
			
		  
		 //need to do grpahs
                 $('#lp_spark_ut').html('<img src="https://chart.googleapis.com/chart?cht=ls&chs=505x230&chco=FF6600&chd=t:'+obj.sparky+'" />');
                 $('#lp_spark_vs').html('<img src="https://chart.googleapis.com/chart?cht=ls&chs=505x230&chco=34A5C1&chd=t:'+obj.sparky_vs+'" />');
                 
                  $('#rep_'+lp+'_errorbox').html('<br/><br/>loading report...').hide(1);
                   $('#rep_'+lp+'_databox').fadeIn(500);
                   
                        
		}
		
            else{
               $('#rep_'+lp+'_databox').hide(1);
               $('#rep_'+lp+'_errorbox').html('<center><br/><br/>'+obj.Msg+'<br/><br/></center>').show(1);
                        
                
            }
            if ($('#dashmain_ov').height()!=$('#dashmain_float_ov').outerHeight()){
		 $('#dashmain_ov').height($('#dashmain_float_ov').outerHeight());
	    }
            
    
    });
    
    
    });
    
});
    

}

function swap_charts(type){
    
    if ($('#sparky_vs_'+type+'_box').is(':hidden')){
        $('#sparky_ut_'+type+'_box').fadeOut(100,function(){
            $('#sparky_vs_'+type+'_box').fadeIn(100);
            $('#rep_chart_'+type).html('registration trends');
        });
            
        
    }
    else{
        $('#sparky_vs_'+type+'_box').fadeOut(100,function(){
            $('#sparky_ut_'+type+'_box').fadeIn(100);
            $('#rep_chart_'+type).html('visitor trends');
        });
    }
}

function lp_quick_stats(id){
   
         $.post("../ajax/get_lp_stats_data.php",{id:id},function(dashReturn){
     
            var obj = jQuery.parseJSON(dashReturn);
              
            
           
            
            
            
            
            
            
            
           
           
              if (obj.data['members']=='okay'){
                
            
                
                
                
                
                $('#rep_reg_lp').html(obj.data['total']);
                $('#rep_visit_lp').html(obj.data['thirty_day_visit']);
                $('#rep_30day_reg_lp').html(obj.data['lastmonthmembers']);
                $('#rep_active_lp').html(obj.data['activeusers']);
                //$('#rep_waiting_lp').html(obj.data.statsdata['waiting']);
               // $('#rep_activated_lp').html(obj.data.statsdata['active']);
               // $('#rep_blocked_lp').html(obj.data.statsdata['blocked']);
                var class_colour;
                if (parseInt(obj.data['difference'])<0){
		  class_colour='rep_colours_neg';
		}
		else if (parseInt(obj.data['difference'])>0){
		  class_colour='rep_colours_plus';
		  obj.data['difference'] = '+'+obj.data['difference'];
		}
		else{
		  class_colour='rep_colours_same';
		}
		$('#rep_reg_30day_lp').html(obj.data['difference']).addClass(class_colour);
                
                $('#rep_con_all_lp').html(obj.data['precent_all']);
                $('#rep_con_30_lp').html(obj.data['precent30']);
                
              
              
                
                
            }
            else{
                
                $('#rep_reg_lp').html('error');
                $('#rep_30day_reg_lp').html('error');
                $('#rep_active_lp').html('error');
                $('#rep_waiting_lp').html('error');
                $('#rep_activated_lp').html('error');
                $('#rep_blocked_lp').html('error');
                
            }
            

           
           
          
            //get help topics?
        
    });
    
    

}




var pv_done = false, lp_done = false, lp_current_url='';
function slider_changer_stats(type,elementid){
    if (elementid!='not-set'){
            var $paneOptions = $('#pane-options-overview');
           $('.rep_main_links').css({'font-weight':'normal','text-decoration':'none'});
           $('#rep_link_'+type).css({'font-weight':'bold','text-decoration':'underline'});
           
                
           $paneOptions.scrollTo( '#slider_'+type, { duration: 1000} );
           
           switch (type){
               case 's_s_pageviews':
                   //only load once
                   if (!pv_done){
                       load_pv_stats('','0,30',0);
                       pv_done=true;
                   }
                   
                   
                   break;
               case 's_s_landingpages':
                   if (!lp_done){
                       load_lp_stats('','','0,30',0);
                       lp_done=true;
                   }
                   
                   break;
               case 's_s_landingpages_det':
                   //details
                   if (lp_current_url!=elementid){
                        lp_current_url=elementid;
                   
                       $('#lp_details_url').html(elementid);
                       lp_quick_stats(elementid);
                       lp_details('os','365');
                   }
                   
                   
                   
                   break;
               
           }
     }
    
}

var pv_current_days = ' 365 ', pv_current_order=' pageview ';
function load_pv_stats(days,limit,source,order){
    
    
    
    //allow asc/desc control?
    pv_current_order = order = (order==undefined || jQuery.trim(order)=='')?pv_current_order:order;
    $('.rep_link_pv_order').css({'background-color':'transparent','color':'#333'});
    $('#rep_link_pv_'+jQuery.trim(order)).css({'background-color':'#7F7F7F','color':'#fff'});

    pv_current_days = days = (days==undefined || days=='')?pv_current_days:days;
    $('.rep_link_pv').css({'background-color':'transparent','color':'#333'});
    
    $('#rep_link_pv_'+jQuery.trim(days)+'_days').css({'background-color':'#7F7F7F','color':'#fff'});
    
    if (limit==undefined || limit==''){
        
        var newLimit =  $('#pv_pagation').val();
       
       
         newLimit = newLimit*15;
         
         var start = (newLimit-1)+1;
         
         if (start<0){
             start = 0;
         }
         
          limit = start+',15';
       
    }
    else{
        limit = '0,15';
    }
    
    
    
   var search = $('#ub_stats_search_pv').val();
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('loading report...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
    
    $.post("../ajax/site_stats_get_pv.php",{order:order,
					    days:days,
					    limit:limit,search:search
					    },function(dataReturn){
						
            var obj = jQuery.parseJSON(dataReturn);
               $('#site_wide_load'+load_inline+glass).fadeOut(100);
            if (obj.Ack=="success"){
                
		var data = obj.data,buildup='', users=0,visitors=0,url='',conv=0;
                
                if (source!=1){
                   
                    var totalCount = obj.total_count;
                    var optionsBloc='';
                    
                    var pageTotals = Math.ceil((totalCount/15));
                    
                    if (pageTotals==0){
                                pageTotals=1;
                    }
                    
                    if (totalCount>0){
                                for (i=0;i<pageTotals;i++){
                                
                                    optionsBloc += '<option value="'+i+'" > page '+Number(i+1)+'</option>' ;
                                
                                }
                                
                    }
                  
                    $('#pv_pagation').html(optionsBloc);
                }
                
                
                for (x in data){
                    
                    buildup += obj.repeater;
                    
                    
                    buildup = buildup.replace('##url##',data[x]['landingpage']);
                    buildup = buildup.replace('##pageviews##',data[x]['pageviews']);
                   
                }
                
                $('#pv_results').html(buildup);
		$('.ub_corners3').corner('3px');
            }
            else{
             $('#pv_results').html('<center>'+obj.Msg+'</center>');
            }
            
            if ($('#dashmain_ov').height()!=$('#dashmain_float_ov').outerHeight()){
		 $('#dashmain_ov').height($('#dashmain_float_ov').outerHeight());
	    }
	});
     });
     });
    
}

var lp_current_order=' users ', lp_current_days='365';
function load_lp_stats(order,days,limit,source){
    
    
    lp_current_order = order = (order==undefined || order=='')?lp_current_order:order;
  
	
    $('.rep_link_lp_order').css({'background-color':'transparent','color':'#333'});
    $('#rep_link_'+jQuery.trim(order)).css({'background-color':'#7F7F7F','color':'#fff'});
	

    lp_current_days = days = (days==undefined || days=='')?lp_current_days:days;
    
    
    $('.rep_link_lp').css({'background-color':'transparent','color':'#333'});
    $('#rep_link_lp_'+jQuery.trim(days)+'_days').css({'background-color':'#7F7F7F','color':'#fff'});
   
   
   
    var search = $('#ub_stats_search_lp').val();
    
    if (limit==undefined || limit==''){
        
        var newLimit =  $('#lp_pagation').val();
       
       
         newLimit = newLimit*15;
         
         var start = (newLimit-1)+1;
         
         if (start<0){
             start = 0;
         }
         
          limit = start+',15';
       
    }
    else{
        limit = '0,15';
    }
    

    
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('loading report...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
   
    $.post("../ajax/site_stats_get_lp.php",{
					    order:order,
					    days:days,
					    limit:limit,
					    search:search
					    },function(dataReturn){
						
            var obj = jQuery.parseJSON(dataReturn);
              $('#site_wide_load'+load_inline+glass).fadeOut(100);
            if (obj.Ack=="success"){
                
                var data = obj.data,buildup='', users=0,visitors=0,url='',conv=0;
                
                if (source!=1){
                   
                    var totalCount = obj.total_count;
                    var optionsBloc='';
                    
                    var pageTotals = Math.ceil((totalCount/15));
                    
                    if (pageTotals==0){
                                pageTotals=1;
                    }
                    
                    if (totalCount>0){
                                for (i=0;i<pageTotals;i++){
                                
                                    optionsBloc += '<option value="'+i+'" > page '+Number(i+1)+'</option>' ;
                                
                                }
                                
                    }
                   
                    $('#lp_pagation').html(optionsBloc);
                }
                
                
                for (x in data){
                    
                    buildup += obj.repeater;
                   
                    
                    buildup = buildup.replace(/##url##/gi,data[x]['landingpage']);
                    buildup = buildup.replace('##users##',data[x]['users']);
                    buildup = buildup.replace('##visitors##',data[x]['visitors']);
                    buildup = buildup.replace('##conversion##',data[x]['conversion']);
                }
                
                $('#lp_results').html(buildup);
		$('.ub_corners3').corner('3px');
            }
            else{
                $('#lp_results').html('<center>'+obj.Msg+'</center>');
            }
            if ($('#dashmain_ov').height()!=$('#dashmain_float_ov').outerHeight()){
		 $('#dashmain_ov').height($('#dashmain_float_ov').outerHeight());
	    }
            
	});
    });
    });
    
}

var current_slider=0;
function load_slider_card(type,slider_num){
	 
	 
	 var $paneOptions = $('#pane-options-stats');
	 $('.rep_main_links').css({'font-weight':'normal','text-decoration':'none'});
	 $('#rep_link_'+type).css({'font-weight':'bold','text-decoration':'underline'});
	 if (jQuery.trim($('#rep_minibars_results_'+type).html())==''){
		rr_stats_collection(type, 0, '',0);  
	 }
	 
	 $paneOptions.scrollTo( '#slider_'+type, { duration: 1000,easing:'easeOutQuad' } );
         
         
}



var stats_globals = new Array(), narrow_by = new Array(),narrow_by_x = new Array(),narrow_by_xy = new Array();

//same for 'type' parameter number-to-name mapping
narrow_by[0]='main';
narrow_by[1]='os';
narrow_by[2]='location';
narrow_by[3]='lang';
narrow_by[4]='url';
narrow_by[5]='browser';
narrow_by[6]='date';
narrow_by[7]='domain';
narrow_by[8]='refid';
narrow_by[9]='screenres';
narrow_by[10]='searchengine';
narrow_by[11]='searchterm';

narrow_by_xy['main']='main';
narrow_by_xy['os']='operating system';
narrow_by_xy['location']='location';
narrow_by_xy['lang']='language';
narrow_by_xy['url']='refering url';
narrow_by_xy['browser']='browser';
narrow_by_xy['date']='date';
narrow_by_xy['domain']='refering domain';
narrow_by_xy['refid']='refering id';
narrow_by_xy['screenres']='screen resolution';
narrow_by_xy['searchengine']='search engine';
narrow_by_xy['searchterm']='search keywords';

narrow_by_x[0]='main';
narrow_by_x[1]='operating system';
narrow_by_x[2]='location';
narrow_by_x[3]='language';
narrow_by_x[4]='refering url';
narrow_by_x[5]='browser';
narrow_by_x[6]='date';
narrow_by_x[7]='refering domain';
narrow_by_x[8]='refering id';
narrow_by_x[9]='screen resolution';
narrow_by_x[10]='search engine';
narrow_by_x[11]='search keywords';


function isset_zero(test_var,zero){
	 
	 if (test_var==undefined || jQuery.trim(test_var.toString())==''){
		  return false;
	 }
	 else{
		  if (zero){
			  if(test_var==0){
			   //alert('zerofalse');
			   return false;
			   
		         }
			 else{
			   //alert('zerotrue');
			   return true;
			 }
		  }
		  else{
			   return true;
		  }
		  
	 }
}
function vs_ut_chart(type){
    
    $('#rep_sparkline_chart_img_'+type).hide(1,function(){
	if($('#rep_sparkline_chart_img_user_'+type).is(':hidden')){
	    
	    $('#rep_sparkline_chart_img_vs_'+type).fadeOut(100,function(){
		$('#rep_sparkline_chart_img_user_'+type).fadeIn(100);
		$('#vs_ut_swap_'+type).html('show visitors chart');
	    });
	    
	}
	else{
	    $('#rep_sparkline_chart_img_user_'+type).fadeOut(100,function(){
		$('#rep_sparkline_chart_img_vs_'+type).fadeIn(100);
		$('#vs_ut_swap_'+type).html('show registrations chart');
		
	    });
	}
    });
}

function rr_get_reg_trend(type,elementid,days){
	$('#vs_ut_swap_'+type).html('show registrations chart');
   $('#rep_sparkline_chart_img_vs_'+type).hide(1,function(){
    $('#rep_sparkline_chart_img_user_'+type).hide(1,function(){
	  $('#rep_sparkline_chart_img_'+type).fadeIn(100,function(){
	  $.post("../ajax/site_stats_get_top_trend.php",{type:type,
						 elementid:elementid,
						 days:days},function(dataReturn){
						
            var obj = jQuery.parseJSON(dataReturn);
              
            if (obj.Ack=="success"){
                var chart_str='',chart_str_vs='',top_score_vs=0,top_score=0;
		//alert('zzzz');
		/*var data = new google.visualization.DataTable();
		data.addColumn('string', 'date');
		data.addColumn('number', 'registrations');
		
		
		data.addRows(days+1);
		
		*/
		
		/*
		 
		  obj.data[x]['date_val'] contains dates if you want to change the graph to something more detailed
		  
		*/
		var xplus=0;
		
		if (days==1 || type=='date'){
		    //24 hours
		    for (x=0;x<=23;x++){
		   
		    
			 chart_str += (parseInt(obj.data[x]['reg_val'])*10)+',';
			 top_score = (parseInt(obj.data[x]['reg_val'])>top_score)?parseInt(obj.data[x]['reg_val']):top_score;
		    
		    
			chart_str_vs += (parseInt(obj.data_vs[x]['reg_val'])*10)+',';
			 top_score_vs = (parseInt(obj.data_vs[x]['reg_val'])>top_score)?parseInt(obj.data_vs[x]['reg_val']):top_score;
		     
		    
		    
		    }
		}
		else{
		   
		    for (x=days;x>=0;x--){
			// alert(obj.data[x]['reg_val']);
			     /*data.setValue(xplus, 0, (obj.data[x]['date_val']).toString());
			     data.setValue(xplus, 1, parseInt(obj.data[x]['reg_val']));
			     xplus++;*/
			 
			 //users
			 chart_str += (parseInt(obj.data[x]['reg_val'])*10)+',';
			 top_score = (parseInt(obj.data[x]['reg_val'])>top_score)?parseInt(obj.data[x]['reg_val']):top_score;
		     //alert(obj.data_vs[x]['reg_val']);
			 //visitors
			
			 chart_str_vs += (parseInt(obj.data_vs[x]['reg_val'])*10)+',';
			 top_score_vs = (parseInt(obj.data_vs[x]['reg_val'])>top_score)?parseInt(obj.data_vs[x]['reg_val']):top_score;
		     
		     
		     }
		}
		//alert('22');
		
		/* new google.visualization.BarChart(document.getElementById('visualization')).draw(data,
			 {title:"",
			  width:600, height:400,
			  vAxis: {title: "Year"},
			  hAxis: {title: "Cups"}
			
			  
			 }
		    );*/
		
		
		chart_str=chart_str.substr(0,chart_str.length-1)+'';
		chart_str_vs=chart_str_vs.substr(0,chart_str_vs.length-1)+'';
		//$('#dataout').html(chart_str + '--' +top_score);
		$('#rep_sparkline_chart_img_'+type).fadeOut(100,function(){
		    $('#rep_sparkline_chart_img_user_'+type).attr('src','https://chart.googleapis.com/chart?cht=ls&chs=500x140&chco=ff6600&chd=t:'+chart_str+'').fadeIn(100);
		      
		    $('#rep_sparkline_chart_img_vs_'+type).attr('src','https://chart.googleapis.com/chart?cht=ls&chs=500x140&chco=34A5C1&chd=t:'+chart_str_vs+'');
		});
		//rep_sparkline_chart_img_os
		//<img id='rep_sparkline_chart_img_os' src='https://chart.googleapis.com/chart?cht=lc&chs=250x150&chco=ff6600&chd=t:27,25,60,31,25,39,25,31,26,28,80,28,27,31,27,29,26,35,70,25&chxt=y&chxl=1:3||50+Kb'/>
             //   alert(obj.Ack);
		
            }
            else{
             //   alert(obj.Msg);
            }
            
            
	});
	  
	  });
    });
    });
}

function rr_narrow_by(id){
    var nval = $('#rr_narrow_by_sel_'+id).val();
    rr_stats_collection(nval, id, '',1,'');
}

var inital_load=true,repeater_once,debig;
function rr_stats_collection(type, narrowby, element,source,details_id,days,bar_runid){
	 //get the correct report type on screen
	 var type_original=type, element_change=false,narrow_original=narrowby,limiter='0,2',change_e_flag=false;;
	 var data_type = (!isset_zero(narrowby,true))?type:narrowby , narrow_txt;
	
		  
	if (!isset_zero(days,false) && stats_globals[data_type+'_days']==undefined){
	
		  stats_globals[data_type+'_days']=365;
		  days=365;
	
		  $('#rep_link_'+data_type+'_365_days').css({'font-weight':'bold','text-decoration':'underline','color':'#FF6600'});
		 
	}
	else if (!isset_zero(days,false) && stats_globals[data_type+'_days']!=undefined) {
		  days = stats_globals[data_type+'_days'];
	}
	else{
		  stats_globals[data_type+'_days'] = days;
		  $('.rep_link_'+data_type).css({'font-weight':'normal','text-decoration':'none','color':'#535353'});
		  $('#rep_link_'+data_type+'_'+days+'_days').css({'font-weight':'bold','text-decoration':'underline','color':'#FF6600'});
		  
		  
	}
	/* - 
	if (source!=1 && inital_load){
		  //inital load and not narrow search
		  inital_load=false;
		  
	}
	else if (source!=1 && !inital_load){
		  // not narrow search
	 
	}
	else{
		  //narrow search
	 
	}
	*/
	
	if (!isset_zero(narrowby,true) && stats_globals[data_type+'_mini']==undefined){
	
		  //defult global settings
		  stats_globals[data_type+'_mini']=narrowby;
		  
		  
		  if (data_type != 'browser'){
			   stats_globals[data_type+'_mini_type']='browser';
			$('#rep_link_'+data_type+'_narrowby_browser_mini').css({'font-weight':'bold','text-decoration':'underline','color':'#FF6600'});
		     $('#rep_narrow_'+data_type).html('browser');
		  }	   
		  else{
			   stats_globals[data_type+'_mini_type']='os';
			 $('#rep_link_'+data_type+'_narrowby_os_mini').css({'font-weight':'bold','text-decoration':'underline','color':'#FF6600'});
		       $('#rep_narrow_'+data_type).html('operating system');
		  }
		  //alert(1);
		  
		  
		  
	}
	else if (!isset_zero(narrowby,true) && stats_globals[data_type+'_mini']!=undefined) {
		
		  narrowby = stats_globals[data_type+'_mini'];
		 // stats_globals[data_type+'_mini_type']=type;
		 
		  //make sure not narrowing by its own category
		  narrowby = (narrowby==type)?0:narrowby;
			//alert(2);
		 
		
	}
	else{
		  stats_globals[data_type+'_mini'] = narrowby;
		
		 
		  stats_globals[data_type+'_mini_type'] = type = (!isset_zero(type,true))?stats_globals[data_type+'_mini_type']:type;
		
		  if (isset_zero(element,false)){
			   //workout if side minibar is clicked (picking a different element)
			   //- if so you'll need to reload the trends chart at the end of this function
                           if (element=='--none--'){
                            element='';
                           }
			   element_change = (stats_globals[data_type+'_mini_id']!=element)?true:false;
			   change_e_flag=true;
			   
			   stats_globals[data_type+'_mini_id']=element; 
		  }
		  else{
			   element = stats_globals[data_type+'_mini_id'];
                           change_e_flag=false;
		  }
		 // alert(3);
		  narrow_txt = (isNaN(type))?type:narrow_by[type];
                  narrow_txt_x = (isNaN(type))?narrow_by_xy[type]:narrow_by_x[type];
		
		  $('.rep_links_'+data_type+'_mini').css({'font-weight':'normal','text-decoration':'none','color':'#535353'});
		  $('#rep_link_'+data_type+'_narrowby_'+narrow_txt+'_mini').css({'font-weight':'bold','text-decoration':'underline','color':'#FF6600'});
                  $('#rep_narrow_'+data_type).html(narrow_txt_x);
		  
		  
	}

	if (bar_runid==undefined){
		  bar_runid=0;
		 }

	if (data_type=='url' || data_type=='date' || data_type=='domain' || data_type=='searchterm' || data_type=='refid'){
	    var search = $('#ub_stats_search_'+data_type).val();
	}
	else{
	    var search = '';
	}
	
	
	//this pagation thing no longer needed
	
	if ($('#rep_pagation_select_'+data_type).val()!=undefined && source != 1){
		
		var newLimit = parseInt($('#rep_pagation_select_'+data_type).val());

		newLimit = newLimit*2;
		 //-1 then +1? lol
		var start = (newLimit-1)+1;
		
		if (start<0){
		    start = 0;
		}
		
		 limiter = start+',2';
		
	}
	var orderby = 'users';
	var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('loading report...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
	$.post("../ajax/ub_site_stat_get_stats.php",{
					   narrowby:narrowby,
					   element:element,
					   type:type,
					   days:days,
					   limiter:limiter,
                                           orderby:orderby,
					   search:search
						    },function(dataReturn){
		
		var obj = jQuery.parseJSON(dataReturn)   ;
		 $('#site_wide_load'+load_inline+glass).fadeOut(100);
		if(change_e_flag){
                            stats_globals[data_type+'_mini_txt']=$('#runid_'+data_type+'_'+bar_runid).html();
                        }
			
			$('#rep_sparkline_'+data_type+'_name').html(stats_globals[data_type+'_mini_txt']);
			$('#rep_sparkline_'+data_type+'_days').html($('#rep_link_'+data_type+'_'+days+'_days').html());
		
		//should return blog id rather than domain - then find domain from that
                //alert(obj.Ack);
		if (obj.Ack=="success"){
		   var width100='',total=0, tracker=0,total=0,total_vs=0,conversion=0; altflag = false, countRows = parseInt(obj.data.count),repeater = obj.data.repeater, data = obj.data.data, stat_table_buildup='';
		
		   //alert(0);
		   /*
			var data_new = new google.visualization.DataTable();
			data_new.addColumn('string', obj.data.column1);
			data_new.addColumn('number', obj.data.column2);
			data_new.addRows(obj.data.count);
			
			  //stat_table_buildup += '<tr><td>'+obj.data.column1+'</td><td>'+obj.data.column2+'</td><td>Precent</td></tr>';
			 */
			   
		   
			for (x=0;x<countRows;x++){
				
				
					
					//data_new.setValue(x, 0, String(data[x]['name']));
					//data_new.setValue(x, 1, parseInt(data[x]['stat']));
					
					total = total + parseInt(isnull(data[x]['stat'],true));
                                        total_vs = total_vs + parseInt(isnull(data[x]['stat_vs'],true));
                                        
				tracker ++;
			
			}
                       // alert(total_vs +'--'+total);
			//
			//x=0;x<10 && x<countRows;x++
			var big_data_hider='',colorclass='',runid=0,first_set=true,result_count=1,results_counter2=1,mini_main_limit;
			
			if (source==1){
			   mini_main_limit=5;
			}
			else{
			   mini_main_limit=10;
			}
                
			for (x in data){
                            /*
                                this should never set to unknown unless the data was input
                                manually and incorrectly ie missing ID values in country/browser etc
                                which if where known to the system would have correct unknown values
                                
                            */
                            data[x]['name'] = (isset_zero(data[x]['name'],false))?data[x]['name']:'unknown';
                            data[x]['code'] = (isset_zero(data[x]['code'],false))?data[x]['code']:'';
                            //-------------------------------------------------------------------------------------
                              
				if (result_count<=mini_main_limit){
				    result_count++;
				    stat_table_buildup +=repeater;
				}
				else{
				    
				    result_count=1;
				    
				      if (first_set){
					     if (source==1){
						      big_data_hider += '<div class="rep_page_mini_'+data_type+'" id="rep_pagation_block_mini_'+data_type+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					     }
					     else{
						      big_data_hider += '<div class="rep_page_'+data_type+'" id="rep_pagation_block_'+data_type+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					     }
					    
					     first_set=false;
					}
					else{
					     if (source==1){
						      big_data_hider += '<div class="rep_page_mini_'+data_type+' hiddenText" id="rep_pagation_block_mini_'+data_type+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					     }
					     else{
						      big_data_hider += '<div class="rep_page_'+data_type+' hiddenText" id="rep_pagation_block_'+data_type+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ;
					     }
					     
					     
					}
				    stat_table_buildup  = repeater;
				    results_counter2++;
				    result_count++;
				    
				}
				
				stat_table_buildup = stat_table_buildup.replace(/##runid##/gi,runid);
				runid++;
				
				if (altflag){
					
					stat_table_buildup = stat_table_buildup.replace(/##alt##/gi,'_alt');
					altflag = false;
				}
				else{
					stat_table_buildup = stat_table_buildup.replace(/##alt##/gi,'');
					altflag = true;
				}
				
				
				if (x==0){
				    stat_table_buildup = stat_table_buildup.replace("##rep_first_minibar##",'rep_element_name_top');
				    
				    // get the id of the first result but only if not a narrow by search request
				    // should really have narrow by flag
				    if (!isset_zero(narrowby,true)){
					stats_globals[data_type+'_mini_id']=data[x]['code'];
					rr_stats_collection(0, data_type, data[x]['code'],1,'');
					
				    }
				    colorclass='rep_element_name_top';
				    
				}
				else{
				    colorclass='rep_element_name';
				    stat_table_buildup = stat_table_buildup.replace("##rep_first_minibar##",'rep_element_name');
				}
                                
                                if (jQuery.trim(data[x]['name'])!=''){
                                    switch (type){
                                        
                                        case 'url':
                                            if (source==1){
							if (data[x]['name'].length >35){
								
								stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'<a style="font-size:12px;padding-left:0px;" href="'+data[x]['name']+'" target="_blank" class="'+colorclass+'">'+makeTextSmall(data[x]['name'],35)+'</a>');   
								stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
							
							}
							else{
								
								stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'<a style="font-size:12px;padding-left:0px;" href="'+data[x]['name']+'" target="_blank" class="'+colorclass+'">'+data[x]['name']+'</a>');  
								stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
							
							}
                                            }
                                            else{
					   
							if (data[x]['name'].length >25){
								
								stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'<a style="font-size:12px;padding-left:0px;" href="'+data[x]['name']+'" target="_blank" class="'+colorclass+'">'+makeTextSmall(data[x]['name'],25)+'</a>');
								stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
								
							}
							else{
								
								stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'<a style="font-size:12px;padding-left:0px;" href="'+data[x]['name']+'" target="_blank" class="'+colorclass+'">'+data[x]['name']+'</a>');  
								stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
								
							}
							    
						   
					    }
                                            break;
                                        case 'location':
                                            if (source!=1){
                                                if (data[x]['name'].length >19){
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,makeTextSmall(data[x]['name'],19));
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
                                                }
                                                else{
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);  
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
                                                }
                                            }
                                            else{
                                                if (data[x]['name'].length >25){
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,makeTextSmall(data[x]['name'],25)); 
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
                                                }else{
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
                                                }
                                            }
                                            break;
                                        default:
                                            if (source!=1){
                                                if (data[x]['name'].length >17){
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,makeTextSmall(data[x]['name'],17));  
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
                                                }
                                                else{
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);  
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
                                                }
                                            }
                                            else{
                                                if (data[x]['name'].length >25){
                                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,makeTextSmall(data[x]['name'],25)); 
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",data[x]['name']);
                                                }else{
                                                     stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);
                                                    stat_table_buildup = stat_table_buildup.replace("##fullcontent##",'');
                                                }
                                            }
    
                                        break;
                                        
                                       
                                    }
                                    
                                    
                                   
                                    
                                }
                                else{
                                    stat_table_buildup = stat_table_buildup.replace(/##content##/gi,'--none--');
                                }
                               // stat_table_buildup = stat_table_buildup.replace(/##content##/gi,data[x]['name']);
                               stat_table_buildup = stat_table_buildup.replace("##data_type##",data_type);
                                stat_table_buildup = stat_table_buildup.replace("##type##",type);
				stat_table_buildup = stat_table_buildup.replace("##count##",x);
				stat_table_buildup = stat_table_buildup.replace("##user_spark##",data[x]['sparky']);
				stat_table_buildup = stat_table_buildup.replace("##visitor_spark##",data[x]['sparky_vs']);
                                if(data[x]['code']==''){
                                    stat_table_buildup = stat_table_buildup.replace(/##content_code##/gi,'--none--');
                                }
				else{
                                    stat_table_buildup = stat_table_buildup.replace(/##content_code##/gi,(data[x]['code']));
                                }
				stat_table_buildup = stat_table_buildup.replace(/##users##/gi,isnull(data[x]['stat_f'],false));
                                stat_table_buildup = stat_table_buildup.replace("##visit##",isnull(data[x]['stat_vs_f'],false));
				/*var precent_int = (((parseInt(data[x]['stat'])/total)*100).toFixed(1));
				//alert(precent_int.substr(precent_int.toString().indexOf('.')+1,1))
				if( precent_int.substr(precent_int.toString().indexOf('.')+1,1)=='0')
				{
				    stat_table_buildup = stat_table_buildup.replace(/##precent##/gi,(((parseInt(data[x]['stat'])/total)*100).toFixed(1)));
				}
				else{
				    stat_table_buildup = stat_table_buildup.replace(/##precent##/gi,(((parseInt(data[x]['stat'])/total)*100).toFixed(1)));
				}*/
                                if (parseInt(data[x]['stat'])){
                                    if((((parseInt(isnull(data[x]['stat'],true))/total)*100).toFixed(1))==100.0){
                                        //alert('100');
                                        width100 = 'width:45px';
                                    }
                                    else{
                                        //alert('<100');
                                        width100 = 'width:40px;'
                                    }
                                    	stat_table_buildup = stat_table_buildup.replace(/##precent##/gi,(((parseInt(isnull(data[x]['stat'],true))/total)*100).toFixed(1)));

                                }
                                else{
                                    	stat_table_buildup = stat_table_buildup.replace(/##precent##/gi,'0.0');

                                }
                                //alert('os: '+data[x]['name']+' - total:'+total_vs);
				if (parseInt(total_vs)!=0){
                                    
                                    if((((parseInt(isnull(data[x]['stat_vs'],true))/total_vs)*100).toFixed(1))==100.0){
                                        //alert('100');
                                        stat_table_buildup = stat_table_buildup.replace("##width100##",'width:45px');
                                    }
                                    else{
                                        //alert('<100');
                                        stat_table_buildup = stat_table_buildup.replace("##width100##",'width:40px');
                                    }
                                    	stat_table_buildup = stat_table_buildup.replace("##precent_vs##",(((parseInt(isnull(data[x]['stat_vs'],true))/total_vs)*100).toFixed(1)));

                                }
                                else{
                                    	stat_table_buildup = stat_table_buildup.replace("##precent_vs##",'0.0');

                                }
                                conversion = (((parseInt(isnull(data[x]['stat'],true))/parseInt(isnull(data[x]['stat_vs'],true)))*100).toFixed(1));
                                if (conversion=='Infinity'){
                                    conversion='0.0';
                                }
                                stat_table_buildup = stat_table_buildup.replace("##conversion##",isnull(conversion,false));
                                
				
				
				/*
				//stat_table_buildup += details;
				stat_table_buildup = stat_table_buildup.replace(/##narrowby##/gi,obj.type_details);
				stat_table_buildup = stat_table_buildup.replace(/##element_code##/gi,data[x]['code']);
				stat_table_buildup = stat_table_buildup.replace(/##element_name##/gi,type);
				stat_table_buildup = stat_table_buildup.replace(/##id##/gi,x);
				
				stat_table_buildup = stat_table_buildup.replace("##precentage_"+data[x]['name']+"##",(((parseInt(data[x]['stat'])/total)*100).toFixed(1))+'%');
				
				*/
				
			
			}
			
			
			
			
			
			
			   stat_table_buildup = stat_table_buildup.replace('##width100##',width100);
                          
					if (first_set){
					     if (source==1){
						      big_data_hider += '<div class="rep_page_mini_'+data_type+'" id="rep_pagation_block_mini_'+data_type+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					     }
					     else{
						      big_data_hider += '<div class="rep_page_'+data_type+'" id="rep_pagation_block_'+data_type+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					     }
					    
					     first_set=false;
					}
					else{
					     if (source==1){
						      big_data_hider += '<div class="rep_page_mini_'+data_type+' hiddenText" id="rep_pagation_block_mini_'+data_type+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ; 
					     }
					     else{
						      big_data_hider += '<div class="rep_page_'+data_type+' hiddenText" id="rep_pagation_block_'+data_type+'_'+results_counter2+'">'+stat_table_buildup+'</div>' ;
					     }
					     
					     
					}
			
			//stats_globals[data_type+'_mini_id']
			
			 
			
				
		
			if (source != 1){
			   $('#rep_minibars_results_'+data_type).html(big_data_hider);
				
				
				
				    var pageTotals = Math.ceil((countRows/mini_main_limit));
				    var optionsBloc ='';
				  
				     if (pageTotals==0){
					 pageTotals=1;
				     }                        
							  
				     if (countRows>0){
					 for (i=0;i<pageTotals;i++){
					 
						    optionsBloc += '<option value="'+(i+1)+'" >'+Number(i+1)+'</option>' ;
					    
					    
					 
					 }
					 
					 optionsBloc = '<select id="rep_pagation_select_'+data_type+'">'+optionsBloc+'</select>';
				      
					  //$('#rep_pagation_main_'+data_type).html(optionsBloc).show(); 
				      
					  
					 
				
					 
					 
				     }
				     else{
					 $('#rep_pagation_main_'+data_type).hide();
				     }
				    
				       $('#rep_pagation_main_'+data_type).html(optionsBloc).show();
				       $('#rep_pagation_select_'+data_type).unbind('change');
				       $('#rep_pagation_select_'+data_type).bind('change',function(event){
						      
						     rr_main_pagation(data_type,''); 
						//   rr_stats_collection(data_type, 0, '',0,'');
							      
				  
				       });
				    
				
				 
				 
				
			
			}
			else{
			   
			   //narrow by request
			       $('#rep_narrowby_'+data_type+'_results').html(big_data_hider);
			       
				    var pageTotals = Math.ceil((countRows/mini_main_limit));
				    var optionsBloc ='';
				  
				     if (pageTotals==0){
					 pageTotals=1;
				     }                        
							  
				     if (countRows>0){
					 for (i=0;i<pageTotals;i++){
					 
						    optionsBloc += '<option value="'+(i+1)+'" >'+Number(i+1)+'</option>' ;
					    
					    
					 
					 }
					 
					 optionsBloc = '<select id="rep_pagation_select_mini_'+data_type+'">'+optionsBloc+'</select>';
				      
					  //$('#rep_pagation_main_'+data_type).html(optionsBloc).show(); 
				      
					  
					 
				
					 
					 
				     }
				     else{
					 $('#rep_pagation_mini_'+data_type).hide();
				     }
				    
				       $('#rep_pagation_mini_'+data_type).html(optionsBloc).show();
				       $('#rep_pagation_select_mini_'+data_type).unbind('change');
				       $('#rep_pagation_select_mini_'+data_type).bind('change',function(event){
						      
						     rr_main_pagation(data_type,'mini_'); 
						//   rr_stats_collection(data_type, 0, '',0,'');
							      
				  
				       });
				    
				
				
				
			}
                        
                        
			
			$('.rep_reports_minibars,.rep_reports_minibars_mini').corner('5px','keep');
			$('.rep_reports_minibars').bind('mouseover',function(event){
               
				    $(this).css({'background-color':'#fff'});
                                            
                
		        });
			$('.rep_reports_minibars').bind('mouseout',function(event){
               
				    $(this).css({'background-color':'#fafafa'});
                                            
                
		        });
                        
                        $('.rep_reports_minibars_mini').bind('mouseover',function(event){
               
				    $(this).css({'background-color':'#fafafa'});
                                            
                
		        });
			$('.rep_reports_minibars_mini').bind('mouseout',function(event){
               
				    $(this).css({'background-color':'#fff'});
                                            
                
		        });
                        
                        //change heights
                        //dashmain_float
                        $('#dashmain').height($('#dashmain_float').outerHeight());
			
		$('.corners').corner('5px');
                
                $('div.stats_result').each(function() {

				$(this).qtip({content: $(this).children('.detailed_stats'),
                                                                    
                                    style:{
                                        classes: 'ui-tooltip-light ui-tooltip-shadow ui-tooltip-microblog ui-tooltip-roar', 
                                        tip: { offset: 5 },
                                        width:500
                                     },
                                     position: {
                                        at:'right center',
                                        my:'left center',
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
                                     show:{
                                        solo:true
                                        },
                                      hide: {
                                            event: 'unfocus'
					    }

                                     });
			
		    });
                             
                         
		     
                $('.content_qtip').qtip({content: {attr: 'title'},
                                                                    
                                    style:{
                                        classes: 'ui-tooltip-tipsy ui-tooltip-shadow ui-tooltip-microblog', 
                                        tip: { offset: 5 },
                                        width:300
                                     },
                                     position: {
                                        at:'bottom center',
                                        viewport: $(window),
                                        adjust: {
                                           method: 'shift',
                                           x: parseInt(0, 10) || 0,
                                           y: parseInt(0, 10) || 0
                                        }
                                     },
                                     show:{
                                        solo:true
                                        },
                                      hide: {
                                            event: 'mouseout'
                                            
					    }

                                     });
			
		  
		 if(source!=1 || element_change ){
                   
			   if (isset_zero(type_original,true)){
			
				   rr_get_reg_trend(type,stats_globals[data_type+'_mini_id'],days);   
			   }
			   else{
				    rr_get_reg_trend(narrow_original,stats_globals[data_type+'_mini_id'],days);  
			   }
		  }
                  $('#rep_'+data_type+'_errorbox').html('<br/><br/>loading report...').hide(1);
                   $('#rep_'+data_type+'_databox').fadeIn(500);
                   
                         
		}
		else{
		  
                    if (source!=1){
                   
                        $('#rep_'+data_type+'_databox').hide(1);
                        $('#rep_'+data_type+'_errorbox').html('<center><br/><br/>'+obj.Msg+'<br/><br/></center>').show(1);
                        
                    }
                    else{
                          $('#rep_narrowby_'+data_type+'_results').html('<center>'+obj.Msg+'<br/><br/></center>');
                          $('#rep_pagation_mini_'+data_type).hide();
                    }
		
		}
		
		if ($('#dashmain_det').height()!=$('#dashmain_float_det').outerHeight()){
		    $('#dashmain_det').height($('#dashmain_float_det').outerHeight());
		}
	
	
	});
	
	
	

});
    });


}

function  rr_main_pagation(data_type,mini){
	 
	 
	 $('.rep_page_'+mini+''+data_type).hide(1);
	 $('#rep_pagation_block_'+mini+''+data_type+'_'+$('#rep_pagation_select_'+mini+''+data_type).val()).show(1);
	 
	
}

function load_site_stat_report(){
	
	
	 
	//loadUserArea();
	
	//need to work get rid of source - it's always zero now
	
	var report = (window.location.hash).replace('#',''),source;
	
		switch (report){
			
			case 'trend':
				source=0;
				report = 'date';
				break;
			case '':
				
				report = 'os';
				break;
			default:
				
				report = 'os';
				break;
		}
		
	
	
	rr_stats_collection(report, 0, '',0);
	
	//alert('Yo');
	
}







function groupPagation(source){
    //need a way to know what the search criteria was
    if (source==1){
        var limiter = '0,'+pagtionLength;
    }
    else{
        var newLimit = $('#group_pagation').val();
        // $('#pageLimit').val(Number(newLimit)+1);
         //alert(newLimit);
         newLimit = newLimit*10;
         
         var start = (newLimit-1)+1;
         
         if (start<0){
             start = 0;
         }
         
         var limiter = start+',10';
    }
    
    //alert(limiter);
    searchFullGroup(limiter,1);
}

function searchFullGroup(limiter,source){
    
    //just list it all out
    if (source == 2){
        $('#group_pagation').val(1);
    }
    
    var load_inline = (scrollTrack())?'_x':'';
    var glass = (load_inline=='_x')?',#glass_loader':'',onefunrun=true, onefunrun_2=true;
    //alert(load_inline);
    $('#site_wide_msg'+load_inline+',#site_wide_okay'+load_inline).hide(1,function(){
        if (!onefunrun_2){return true;}else{onefunrun_2=false;}
    $('#site_wide_load_msg'+load_inline).html('searching user groups...');
    $('#site_wide_load'+load_inline+glass).fadeIn(1,function(){
        if (!onefunrun){return true;}else{onefunrun=false;}
        $.post("../ajax/search_for_group.php",{limit:limiter},function(dataReturn){
            
          //alert(dataReturn);
           
           var obj = jQuery.parseJSON(dataReturn);
                 
           if (obj.Ack=="success"){
            
            //hide popup and show the actual results
            
          //$('#site_wide_msg'+load_inline).html(obj.Msg);
                            $('#site_wide_load'+load_inline+glass).fadeOut(100);
                   
                
                    $('#resultsset').html('');
                    var dataArray = obj.data;
                    var totalCount = obj.total_count;
                    var optionsBloc='';
                    if (source == 2 || source == 1){
                        //build up drop down for pagation
                        pageTotals = Math.ceil((totalCount/10));
                       
                      
                        if (pageTotals==0){
                            pageTotals=1;
                        }                        
                                             
                        if (totalCount>0){
                            for (i=0;i<pageTotals;i++){
                            
                            optionsBloc += '<option value="'+i+'" > page '+Number(i+1)+'</option>' ;
                            
                            }
                            if (source!=1 || limiter=='0,'+pagtionLength){
                                $('#group_pagation').html(optionsBloc);
                                $('#group_pagation').show();
                            }
                            
                            
                        }
                        else{
                            $('#group_pagation').hide();
                        }
                        
                    }
    
    
              // alert(totalCount);
                   
                    var pageBuildUp='';
                    
                    for (x in dataArray){
                        
                        pageBuildUp += obj.repeater;
                        pageBuildUp = pageBuildUp.replace(/##groupname##/gi,makeTextSmall(dataArray[x]['name'],20));
                        pageBuildUp = pageBuildUp.replace('##groupdesc##',dataArray[x]['descip']);
                        pageBuildUp = pageBuildUp.replace(/##gid##/gi,dataArray[x]['groupid']);
                       
                        
                        
                        

                     
                    }
                    
                   
                    $('#ub_group_results').html(pageBuildUp);
                  
                
                $('.ub_corners').corner('5px','keep');
              
              $('.ub-quick-results-box').bind('mouseover',function(event){
                    
                                         $(this).css({'background-color':'#fafafa'});
                                                 
                     
                             });
                             $('.ub-quick-results-box').bind('mouseout',function(event){
                    
                                         $(this).css({'background-color':'#f8f8f8'});
                                                 
                     
                             });
            
           }
           else{
                //no results found
                $('#site_wide_msg'+load_inline).html(obj.Msg);
                $('#site_wide_load'+load_inline+glass).fadeOut(100);
                $('#ub_group_results').html('');
                 $('#pagationBlock').hide();
                
           }
    
    
    });
    
    
    

    
    });
});
}







//==============
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

//==============
/*
 * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
 * Digest Algorithm, as defined in RFC 1321.
 * Version 2.1 Copyright (C) Paul Johnston 1999 - 2002.
 * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
 * Distributed under the BSD License
 * 
 */

/*
 * Configurable variables. You may need to tweak these to be compatible with
 * the server-side, but the defaults work in most cases.
 */
var hexcase = 0;  /* hex output format. 0 - lowercase; 1 - uppercase        */
var b64pad  = ""; /* base-64 pad character. "=" for strict RFC compliance   */
var chrsz   = 8;  /* bits per input character. 8 - ASCII; 16 - Unicode      */

/*
 * These are the functions you'll usually want to call
 * They take string arguments and return either hex or base-64 encoded strings
 */
function hex_md5(s){ return binl2hex(core_md5(str2binl(s), s.length * chrsz));}
function b64_md5(s){ return binl2b64(core_md5(str2binl(s), s.length * chrsz));}
function str_md5(s){ return binl2str(core_md5(str2binl(s), s.length * chrsz));}
function hex_hmac_md5(key, data) { return binl2hex(core_hmac_md5(key, data)); }
function b64_hmac_md5(key, data) { return binl2b64(core_hmac_md5(key, data)); }
function str_hmac_md5(key, data) { return binl2str(core_hmac_md5(key, data)); }

/*
 * Perform a simple self-test to see if the VM is working
 */
function md5_vm_test()
{
  return hex_md5("abc") == "900150983cd24fb0d6963f7d28e17f72";
}

/*
 * Calculate the MD5 of an array of little-endian words, and a bit length
 */
function core_md5(x, len)
{
  /* append padding */
  x[len >> 5] |= 0x80 << ((len) % 32);
  x[(((len + 64) >>> 9) << 4) + 14] = len;

  var a =  1732584193;
  var b = -271733879;
  var c = -1732584194;
  var d =  271733878;

  for(var i = 0; i < x.length; i += 16)
  {
    var olda = a;
    var oldb = b;
    var oldc = c;
    var oldd = d;

    a = md5_ff(a, b, c, d, x[i+ 0], 7 , -680876936);
    d = md5_ff(d, a, b, c, x[i+ 1], 12, -389564586);
    c = md5_ff(c, d, a, b, x[i+ 2], 17,  606105819);
    b = md5_ff(b, c, d, a, x[i+ 3], 22, -1044525330);
    a = md5_ff(a, b, c, d, x[i+ 4], 7 , -176418897);
    d = md5_ff(d, a, b, c, x[i+ 5], 12,  1200080426);
    c = md5_ff(c, d, a, b, x[i+ 6], 17, -1473231341);
    b = md5_ff(b, c, d, a, x[i+ 7], 22, -45705983);
    a = md5_ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
    d = md5_ff(d, a, b, c, x[i+ 9], 12, -1958414417);
    c = md5_ff(c, d, a, b, x[i+10], 17, -42063);
    b = md5_ff(b, c, d, a, x[i+11], 22, -1990404162);
    a = md5_ff(a, b, c, d, x[i+12], 7 ,  1804603682);
    d = md5_ff(d, a, b, c, x[i+13], 12, -40341101);
    c = md5_ff(c, d, a, b, x[i+14], 17, -1502002290);
    b = md5_ff(b, c, d, a, x[i+15], 22,  1236535329);

    a = md5_gg(a, b, c, d, x[i+ 1], 5 , -165796510);
    d = md5_gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
    c = md5_gg(c, d, a, b, x[i+11], 14,  643717713);
    b = md5_gg(b, c, d, a, x[i+ 0], 20, -373897302);
    a = md5_gg(a, b, c, d, x[i+ 5], 5 , -701558691);
    d = md5_gg(d, a, b, c, x[i+10], 9 ,  38016083);
    c = md5_gg(c, d, a, b, x[i+15], 14, -660478335);
    b = md5_gg(b, c, d, a, x[i+ 4], 20, -405537848);
    a = md5_gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
    d = md5_gg(d, a, b, c, x[i+14], 9 , -1019803690);
    c = md5_gg(c, d, a, b, x[i+ 3], 14, -187363961);
    b = md5_gg(b, c, d, a, x[i+ 8], 20,  1163531501);
    a = md5_gg(a, b, c, d, x[i+13], 5 , -1444681467);
    d = md5_gg(d, a, b, c, x[i+ 2], 9 , -51403784);
    c = md5_gg(c, d, a, b, x[i+ 7], 14,  1735328473);
    b = md5_gg(b, c, d, a, x[i+12], 20, -1926607734);

    a = md5_hh(a, b, c, d, x[i+ 5], 4 , -378558);
    d = md5_hh(d, a, b, c, x[i+ 8], 11, -2022574463);
    c = md5_hh(c, d, a, b, x[i+11], 16,  1839030562);
    b = md5_hh(b, c, d, a, x[i+14], 23, -35309556);
    a = md5_hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
    d = md5_hh(d, a, b, c, x[i+ 4], 11,  1272893353);
    c = md5_hh(c, d, a, b, x[i+ 7], 16, -155497632);
    b = md5_hh(b, c, d, a, x[i+10], 23, -1094730640);
    a = md5_hh(a, b, c, d, x[i+13], 4 ,  681279174);
    d = md5_hh(d, a, b, c, x[i+ 0], 11, -358537222);
    c = md5_hh(c, d, a, b, x[i+ 3], 16, -722521979);
    b = md5_hh(b, c, d, a, x[i+ 6], 23,  76029189);
    a = md5_hh(a, b, c, d, x[i+ 9], 4 , -640364487);
    d = md5_hh(d, a, b, c, x[i+12], 11, -421815835);
    c = md5_hh(c, d, a, b, x[i+15], 16,  530742520);
    b = md5_hh(b, c, d, a, x[i+ 2], 23, -995338651);

    a = md5_ii(a, b, c, d, x[i+ 0], 6 , -198630844);
    d = md5_ii(d, a, b, c, x[i+ 7], 10,  1126891415);
    c = md5_ii(c, d, a, b, x[i+14], 15, -1416354905);
    b = md5_ii(b, c, d, a, x[i+ 5], 21, -57434055);
    a = md5_ii(a, b, c, d, x[i+12], 6 ,  1700485571);
    d = md5_ii(d, a, b, c, x[i+ 3], 10, -1894986606);
    c = md5_ii(c, d, a, b, x[i+10], 15, -1051523);
    b = md5_ii(b, c, d, a, x[i+ 1], 21, -2054922799);
    a = md5_ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
    d = md5_ii(d, a, b, c, x[i+15], 10, -30611744);
    c = md5_ii(c, d, a, b, x[i+ 6], 15, -1560198380);
    b = md5_ii(b, c, d, a, x[i+13], 21,  1309151649);
    a = md5_ii(a, b, c, d, x[i+ 4], 6 , -145523070);
    d = md5_ii(d, a, b, c, x[i+11], 10, -1120210379);
    c = md5_ii(c, d, a, b, x[i+ 2], 15,  718787259);
    b = md5_ii(b, c, d, a, x[i+ 9], 21, -343485551);

    a = safe_add(a, olda);
    b = safe_add(b, oldb);
    c = safe_add(c, oldc);
    d = safe_add(d, oldd);
  }
  return Array(a, b, c, d);

}

/*
 * These functions implement the four basic operations the algorithm uses.
 */
function md5_cmn(q, a, b, x, s, t)
{
  return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s),b);
}
function md5_ff(a, b, c, d, x, s, t)
{
  return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t);
}
function md5_gg(a, b, c, d, x, s, t)
{
  return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t);
}
function md5_hh(a, b, c, d, x, s, t)
{
  return md5_cmn(b ^ c ^ d, a, b, x, s, t);
}
function md5_ii(a, b, c, d, x, s, t)
{
  return md5_cmn(c ^ (b | (~d)), a, b, x, s, t);
}

/*
 * Calculate the HMAC-MD5, of a key and some data
 */
function core_hmac_md5(key, data)
{
  var bkey = str2binl(key);
  if(bkey.length > 16) bkey = core_md5(bkey, key.length * chrsz);

  var ipad = Array(16), opad = Array(16);
  for(var i = 0; i < 16; i++)
  {
    ipad[i] = bkey[i] ^ 0x36363636;
    opad[i] = bkey[i] ^ 0x5C5C5C5C;
  }

  var hash = core_md5(ipad.concat(str2binl(data)), 512 + data.length * chrsz);
  return core_md5(opad.concat(hash), 512 + 128);
}

/*
 * Add integers, wrapping at 2^32. This uses 16-bit operations internally
 * to work around bugs in some JS interpreters.
 */
function safe_add(x, y)
{
  var lsw = (x & 0xFFFF) + (y & 0xFFFF);
  var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
  return (msw << 16) | (lsw & 0xFFFF);
}

/*
 * Bitwise rotate a 32-bit number to the left.
 */
function bit_rol(num, cnt)
{
  return (num << cnt) | (num >>> (32 - cnt));
}

/*
 * Convert a string to an array of little-endian words
 * If chrsz is ASCII, characters >255 have their hi-byte silently ignored.
 */
function str2binl(str)
{
  var bin = Array();
  var mask = (1 << chrsz) - 1;
  for(var i = 0; i < str.length * chrsz; i += chrsz)
    bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (i%32);
  return bin;
}

/*
 * Convert an array of little-endian words to a string
 */
function binl2str(bin)
{
  var str = "";
  var mask = (1 << chrsz) - 1;
  for(var i = 0; i < bin.length * 32; i += chrsz)
    str += String.fromCharCode((bin[i>>5] >>> (i % 32)) & mask);
  return str;
}

/*
 * Convert an array of little-endian words to a hex string.
 */
function binl2hex(binarray)
{
  var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i++)
  {
    str += hex_tab.charAt((binarray[i>>2] >> ((i%4)*8+4)) & 0xF) +
           hex_tab.charAt((binarray[i>>2] >> ((i%4)*8  )) & 0xF);
  }
  return str;
}

/*
 * Convert an array of little-endian words to a base-64 string
 */
function binl2b64(binarray)
{
  var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i += 3)
  {
    var triplet = (((binarray[i   >> 2] >> 8 * ( i   %4)) & 0xFF) << 16)
                | (((binarray[i+1 >> 2] >> 8 * ((i+1)%4)) & 0xFF) << 8 )
                |  ((binarray[i+2 >> 2] >> 8 * ((i+2)%4)) & 0xFF);
    for(var j = 0; j < 4; j++)
    {
      if(i * 8 + j * 6 > binarray.length * 32) str += b64pad;
      else str += tab.charAt((triplet >> 6*(3-j)) & 0x3F);
    }
  }
  return str;
}

function nameCap(str){
    var strLower = str.toLowerCase();
    var newStr = strLower.split(" ");
    for (x in newStr){
        //may need to check for 'AND' and not upper case that
        newStr[x] = (newStr[x].substr(0,1)).toUpperCase()+newStr[x].substr(1);
    }
    return newStr.join(" ");
}

function makeTextSmall(str,len){
    len = len==''?15:len;
    if (str!=null && str!=''){
        if (str.length > len){
            str = str.substr(0,len-7)+'...'+str.substr((str.length-3),3);
        }
        return str;
    }
    else{
        return '';
    }
}


function linkify(inputText) {
	var replaceText, replacePattern1, replacePattern2, replacePattern3;

	
	replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
	replacedText = inputText.replace(replacePattern1, '<a rel="nofollow" href="$1" target="_blank">$1</a>');

	replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
	replacedText = replacedText.replace(replacePattern2, '$1<a rel="nofollow" href="http://$2" target="_blank">$2</a>');
	
	return replacedText
}

function URLShort(inputString,StrLength){
	
	if (StrLength==undefined || StrLength ==''){
		StrLength==25;
	}
	if (inputString.length>StrLength){
		inputString = inputString.substr(0,StrLength)+'...'+inputString.substr(-10);
	}
	return inputString;
	
}

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


function formatCurrency(num) {
    num = isNaN(num) || num === '' || num === null ? 0.00 : num;
    return parseFloat(num).toFixed(2);
}

function inArray(a, obj) {
    var i = a.length;
    while (i--) {
       if (a[i] === obj) {
           return true;
       }
    }
    return false;
}

