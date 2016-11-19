/*
nadlabs userbase v1.3 - copyright (c) 2013 nadlabs - all rights reserved
*/


/*

    #on load functions#
*/

function onDocReady(){
    set_ub_stats();
    $('.btn').button('reset');
    
    $('#ge_login_form').submit(function(){
	post_data('get_login');
	return false;
	});
    $('#signin_btn').on('click', function() {
                        //post_data('get_login');
                        
                    });
    
    
    $('#ad_register_form').submit(function(){
	post_data('new_register');
	return false;
	});
    $('#register_btn').on('click', function() {
                       // post_data('new_register');
                       
                    });
    
    $('#ad_register_p_form').submit(function(){
	post_data('new_register_p');
	return false;
	});
    $('#register_p_btn').on('click', function() {
                      //  post_data('new_register_p');
                       
                    });
    
    
    $('#ge_forgot_form').submit(function(){
	post_data('get_forgot');
	return false;
	});
    $('#remember_btn').on('click', function() {
                      //  post_data('get_forgot');
                       
                    });
    
    
    $('#ge_reactivate_form').submit(function(){
	post_data('get_reactivate');
	return false;
	});
    $('#reactivate_btn').on('click', function() {
                      //  post_data('get_reactivate');
                       
                    });
    
    
    $('#ge_activate_form').submit(function(){
	post_data('get_activate');
	return false;
	});
    $('#activate_btn').on('click', function() {
                      //  post_data('get_activate');
                        
                    });
    
    
    $('#ed_update_avatar_hotlink_form').submit(function(){
	post_data('edit_update_avatar');
	return false;
	});
    $('#update_avatar_hotlink_btn').on('click', function() {
                       // post_data('edit_update_avatar');
                        
                    });
    
    
    
    $('#ed_change_password_form').submit(function(){
	post_data('edit_change_password');
	return false;
	});
    $('#update_password_btn').on('click', function() {
                       // post_data('edit_change_password');
		       
                       //$('#ed_change_password_form').submit();
                    });
    
    
    
    $('#ed_change_email_form').submit(function(){
	post_data('edit_change_email');
	return false;
	});
    $('#update_email_btn').on('click', function() {
                       // post_data('edit_change_email');
                       
                    });
    
    
    
    
    $('#ge_contact_us_form').submit(function(){
	post_data('get_contact_us');
	return false;
	});
    $('#contact_btn').on('click', function() {
                       // post_data('get_contact_us');
                       
                    });
    
    
    
    $('#ed_change_username_form').submit(function(){
	post_data('edit_change_username');
	return false;
    });
    
    $('#change_username_btn').on('click', function() {
                       // post_data('edit_change_username');
                       
    });
    
    
    
   
    $('#ad_register_form').find('#ad_username').on('blur', function() {
                        post_data('get_check_username');
                       
    });
    
    
    
   
    $('#ad_register_form').find('#ad_email').on('blur', function() {
                        post_data('get_check_email');
                       
                    });
}

/*
    # ALL GLOBAL SETTINGS#
*/
var action_arr =new Array();
action_arr['get_login_script'] 		=  "ajax/ub_login_user.php";
action_arr['get_login_form'] 		=  "ge_login_form";
action_arr['get_login_msgbox'] 		=  "ge_login_msgbox";
action_arr['get_login_loader'] 		=  true;
action_arr['get_login_btn'] 		=  "signin_btn";
//action_arr['get_login_output_container']=  "ge_login_container";

action_arr['get_login_req_temp'] 	=  false;
action_arr['get_login_req_msg'] 	=  true;
action_arr['get_login_req_err'] 	=  true;
action_arr['get_login_valid_err'] 	=  false;


action_arr['new_register_script'] 		                =  "ajax/ub_register_user.php";
action_arr['new_register_form'] 		                =  "ad_register_form";
action_arr['new_register_msgbox'] 		                =  "ad_register_msgbox";
action_arr['new_register_loader'] 		                =  "ad_register_loader";
action_arr['new_register_btn']	 		                =  "register_btn";
//action_arr['new_register_output_container']	=  false;
action_arr['new_register_req_temp'] 		                =  false;
action_arr['new_register_req_msg'] 		                =  true;
action_arr['new_register_req_err'] 		                =  true;
action_arr['new_register_valid_err'] 		                =  true;


action_arr['new_register_p_script'] 		                =  "ajax/ub_register_user.php";
action_arr['new_register_p_form'] 		                =  "ad_register_p_form";
action_arr['new_register_p_msgbox'] 		                =  "ad_register_p_msgbox";
action_arr['new_register_p_loader'] 		                =  "ad_register_p_loader";
action_arr['new_register_p_btn']	 		                =  "register_p_btn";
//action_arr['new_register_p_output_container']	=  false;
action_arr['new_register_p_req_temp'] 		                =  false;
action_arr['new_register_p_req_msg'] 		                =  true;
action_arr['new_register_p_req_err'] 		                =  true;
action_arr['new_register_p_valid_err'] 		                =  true;

action_arr['get_activate_script'] 		                =  "ajax/ub_activate.php";
action_arr['get_activate_form'] 		                =  "ge_activate_form";
action_arr['get_activate_msgbox'] 		                =  "ge_activate_msgbox";
action_arr['get_activate_loader'] 		                =  "ge_activate_loader";
action_arr['get_activate_btn'] 		                	=  "activate_btn";
//action_arr['get_activate_output_container']	=  false;
action_arr['get_activate_req_temp'] 		                =  false;
action_arr['get_activate_req_msg'] 		                =  true;
action_arr['get_activate_req_err'] 		                =  true;
action_arr['get_activate_valid_err'] 		                =  true;

action_arr['get_reactivate_script'] 		                =  "ajax/ub_resend_activation.php";
action_arr['get_reactivate_form'] 		                =  "ge_reactivate_form";
action_arr['get_reactivate_msgbox'] 		                =  "ge_reactivate_msgbox";
action_arr['get_reactivate_loader'] 		                =  "ge_reactivate_loader";
action_arr['get_reactivate_btn'] 		                =  "reactivate_btn";
//action_arr['get_reactivate_output_container']	=  false;
action_arr['get_reactivate_req_temp'] 		                =  false;
action_arr['get_reactivate_req_msg'] 		                =  true;
action_arr['get_reactivate_req_err'] 		                =  true;
action_arr['get_reactivate_valid_err'] 		                =  true;

action_arr['get_forgot_script'] 		                =  "ajax/ub_forgot_ps.php";
action_arr['get_forgot_form'] 		                        =  "ge_forgot_form";
action_arr['get_forgot_msgbox'] 		                =  "ge_forgot_msgbox";
action_arr['get_forgot_loader'] 		                =  "ge_forgot_loader";
action_arr['get_forgot_btn'] 		                	=  "remember_btn";
//action_arr['get_forgot_output_container']	=  false;
action_arr['get_forgot_req_temp'] 		                =  false;
action_arr['get_forgot_req_msg'] 		                =  true;
action_arr['get_forgot_req_err'] 		                =  true;
action_arr['get_forgot_valid_err'] 		                =  true;

action_arr['get_check_email_script'] 		                =  "ajax/ub_check_email_valid.php";
action_arr['get_check_email_form'] 		                =  "ge_check_email_form";
action_arr['get_check_email_msgbox'] 		                =  "ge_check_email_msgbox";
action_arr['get_check_email_loader'] 		                =  "ge_check_email_loader";
action_arr['get_check_email_btn'] 		                =  "update_email_btn";
//action_arr['get_check_email_output_container']	=  false;
action_arr['get_check_email_req_temp'] 		                =  false;
action_arr['get_check_email_req_msg'] 		                =  false;
action_arr['get_check_email_req_err'] 		                =  false;
action_arr['get_check_email_valid_err'] 		        =  false;

action_arr['get_check_username_script'] 		        =  "ajax/ub_check_username_valid.php";
action_arr['get_check_username_form'] 		                =  "ge_check_username_form";
action_arr['get_check_username_msgbox'] 		        =  "ge_check_username_msgbox";
action_arr['get_check_username_loader'] 		        =  "ge_check_username_loader";
//action_arr['get_check_username_output_container']	=  false;
action_arr['get_check_username_req_temp'] 		        =  false;
action_arr['get_check_username_req_msg'] 		        =  false;
action_arr['get_check_username_req_err'] 		        =  false;
action_arr['get_check_username_valid_err'] 		        =  false;


action_arr['edit_change_email_script'] 		                =  "ajax/ub_save_edit_email.php";
action_arr['edit_change_email_form'] 		                =  "ed_change_email_form";
action_arr['edit_change_email_msgbox'] 		                =  "ed_change_email_msgbox";
action_arr['edit_change_email_loader'] 		                =  "ed_change_email_loader";
//action_arr['edit_change_email_output_container']	=  false;
action_arr['edit_change_email_req_temp'] 		                =  false;
action_arr['edit_change_email_req_msg'] 		                =  true;
action_arr['edit_change_email_req_err'] 		                =  true;
action_arr['edit_change_email_valid_err'] 		                =  true;

action_arr['edit_change_password_script'] 		                =  "ajax/ub_save_edit_ps.php";
action_arr['edit_change_password_form'] 		                =  "ed_change_password_form";
action_arr['edit_change_password_msgbox'] 		                =  "ed_change_password_msgbox";
action_arr['edit_change_password_loader'] 		                =  "ed_change_password_loader";
action_arr['edit_change_password_btn'] 		                	=  "update_password_btn";
//action_arr['edit_change_password_output_container']	=  false;
action_arr['edit_change_password_req_temp'] 		                =  false;
action_arr['edit_change_password_req_msg'] 		                =  true;
action_arr['edit_change_password_req_err'] 		                =  true;
action_arr['edit_change_password_valid_err'] 		                =  true;

action_arr['edit_update_avatar_script'] 		                =  "ajax/ub_hotlink.php";
action_arr['edit_update_avatar_form'] 		                        =  "ed_update_avatar_hotlink_form";
action_arr['edit_update_avatar_msgbox'] 		                =  "ed_update_avatar_hotlink_msgbox";
action_arr['edit_update_avatar_loader'] 		                =  "ed_update_avatar_hotlink_loader";
action_arr['edit_update_avatar_btn'] 		                	=  "update_avatar_hotlink_btn";
//action_arr['edit_update_avatar_output_container']	=  false;
action_arr['edit_update_avatar_req_temp'] 		                =  false;
action_arr['edit_update_avatar_req_msg'] 		                =  true;
action_arr['edit_update_avatar_req_err'] 		                =  true;
action_arr['edit_update_avatar_valid_err'] 		                =  true;

action_arr['edit_change_username_script'] 		                =  "ajax/ub_change_OTF_username.php";
action_arr['edit_change_username_form'] 		                =  "ed_change_username_form";
action_arr['edit_change_username_msgbox'] 		                =  "ed_change_username_msgbox";
action_arr['edit_change_username_loader'] 		                =  "ed_change_username_loader";
action_arr['edit_change_username_btn'] 		                	=  "change_username_btn";
//action_arr['edit_change_username_output_container']	=  false;
action_arr['edit_change_username_req_temp'] 		                =  false;
action_arr['edit_change_username_req_msg'] 		                =  true;
action_arr['edit_change_username_req_err'] 		                =  true;
action_arr['edit_change_username_valid_err'] 		                =  true;

action_arr['get_contact_us_script'] 		                =  "ajax/ub_contact_us.php";
action_arr['get_contact_us_form'] 		                =  "ge_contact_us_form";
action_arr['get_contact_us_msgbox'] 		                =  "ge_contact_us_msgbox";
action_arr['get_contact_us_loader'] 		                =  "ge_contact_us_loader";
action_arr['get_contact_us_btn'] 		                =  "contact_btn";
//action_arr['get_contact_us_output_container']	=  false;
action_arr['get_contact_us_req_temp'] 		                =  false;
action_arr['get_contact_us_req_msg'] 		                =  true;
action_arr['get_contact_us_req_err'] 		                =  true;
action_arr['get_contact_us_valid_err'] 		                =  true;


//error/success msg function

function err_msg(action,obj){
    
    /*
	error messages
	fields themselves
	output box
	
	arr_vars,msg_box
	
    */
   
    if(!action_arr[action+'_valid_err']){
	if(action_arr[action+'_req_msg'])
	    $('#'+action_arr[action+'_msgbox']).html(obj.Msg);
    }
    else{
	
	if(obj.validationErrors!=undefined){
	    var err_obj = obj.validationErrors;
	    var err_buildup='';
	    

	    $.each(err_obj, function(property, value) {
		
		if (property == 'withheld_general_error'){
		    err_buildup += "<b>other info</b>: "+value+"<br/>";
                    //this is when the system outputs an error for background data - not currently used in v1.3 of userbase
                }else{
		    
                    $('#'+action_arr[action+'_form']).find('#'+property+'_errmsg').html(value).show(1);
		    $('#'+action_arr[action+'_form']).find('#'+property+'_errmsg').parent().show(1);
		  //  alert($('#'+action_arr[action+'_form']).find('#'+property+'_errmsg').html());
                }
                    
		   // err_buildup += "<b>"+property+"</b>: "+value+"<br/>";
	    });
	
	    //$('#'+action_arr[action+'_msgbox']).html(err_buildup);
	}
	else{
	    $('#'+action_arr[action+'_msgbox']).html(obj.Msg);
	}
    }
    
}

//speicals before & after
function special_before(action){
     switch(action){
        
      
        
        case 'get_login':
            
           
            $('#'+action_arr[action+'_form']).find('#ge_password').val( hex_md5($('#'+action_arr[action+'_form']).find('#ge_password').val()));
            var remember = ($('#'+action_arr[action+'_form']).find('#ge_remember_me').is(':checked'))?1:0;
            $('#'+action_arr[action+'_form']).find('#ge_rem_real').val(remember);
            
            break;
        
        case 'new_register':
            
           
            $('#'+action_arr[action+'_form']).find('#ad_password').val( hex_md5($('#'+action_arr[action+'_form']).find('#ad_password').val()));
            $('#'+action_arr[action+'_form']).find('#ad_password_confirm').val( hex_md5($('#'+action_arr[action+'_form']).find('#ad_password_confirm').val()));
            
            var contact = ($('#'+action_arr[action+'_form']).find('#ad_contact_me').is(':checked'))?1:0;
            $('#'+action_arr[action+'_form']).find('#ad_contact_me_real').val(contact);
            
            var tandc = ($('#'+action_arr[action+'_form']).find('#ad_tandc').is(':checked'))?1:0;
            $('#'+action_arr[action+'_form']).find('#ad_tandc_real').val(tandc);
            
            break;
	
    case 'new_register_p':
            
           
            $('#'+action_arr[action+'_form']).find('#ad_password').val( hex_md5($('#'+action_arr[action+'_form']).find('#ad_password').val()));
            $('#'+action_arr[action+'_form']).find('#ad_password_confirm').val( hex_md5($('#'+action_arr[action+'_form']).find('#ad_password_confirm').val()));
            
            var contact = ($('#'+action_arr[action+'_form']).find('#ad_contact_me').is(':checked'))?1:0;
            $('#'+action_arr[action+'_form']).find('#ad_contact_me_real').val(contact);
            
            var tandc = ($('#'+action_arr[action+'_form']).find('#ad_tandc').is(':checked'))?1:0;
            $('#'+action_arr[action+'_form']).find('#ad_tandc_real').val(tandc);
            
            break;
        
        case 'get_check_username':
            $('#'+action_arr[action+'_form']).find('#ge_username').val($('#ad_register_form').find('#ad_username').val());
            break;
        
        case 'get_check_email':
            $('#'+action_arr[action+'_form']).find('#ge_email').val($('#ad_register_form').find('#ad_email').val());
            break;
        
        
        case 'edit_change_password':
            
           
            $('#'+action_arr[action+'_form']).find('#ed_current_password').val( hex_md5($('#'+action_arr[action+'_form']).find('#ed_current_password').val()));
            
            $('#'+action_arr[action+'_form']).find('#ed_new_password').val( hex_md5($('#'+action_arr[action+'_form']).find('#ed_new_password').val()));
            
            $('#'+action_arr[action+'_form']).find('#ed_new_confirm_password').val( hex_md5($('#'+action_arr[action+'_form']).find('#ed_new_confirm_password').val()));
            
            
            break;
        
         case 'edit_change_email':
            
           
            $('#'+action_arr[action+'_form']).find('#ed_current_password').val( hex_md5($('#'+action_arr[action+'_form']).find('#ed_current_password').val()));
            
            
    }
}

function special_after(action,obj,option){
    
    switch(action){
        
	case 'new_register_p':
	case 'new_register':   
	    if(obj.account_type==1){
		if (obj.captcha=="true"){
		    javascript:Recaptcha.reload();
		}
	    }
	    else{
		//alert('hekje');
		$('#confirm_form').html(obj.form);
		//alert('hekje2');
	    }
            break;
	
        case 'get_login':
            if (obj.Ack=="success"){
		window.location = 'userarea.php';
            }
            break;
        
        case 'get_check_username':
            
            if (obj.Ack=="success"){
		$('#ad_register_form').find('#ad_username_errmsg').html('');
		$('#ad_register_form').find('#ad_username_errmsg').parent().hide(1);
            }
            else{
		
		var errs = obj.validationErrors;
		
                $('#ad_register_form').find('#ad_username_errmsg').html(errs.ad_username).show(1);
		$('#ad_register_form').find('#ad_username_errmsg').parent().show(1);
            }
            break;
        
        case 'get_check_email':
            if (obj.Ack=="success"){
		$('#ad_register_form').find('#ad_email_errmsg').html('');
		$('#ad_register_form').find('#ad_email_errmsg').parent().hide(1);
            }
            else{
		var errs = obj.validationErrors;
                $('#ad_register_form').find('#ad_email_errmsg').html(errs.ad_email).show(1);
		$('#ad_register_form').find('#ad_email_errmsg').parent().show(1);
            }
         
            break;
    }
    
}



//post function

function post_data(action,option){
    
    $('#'+action_arr[action+'_form']).find('.alert').hide();
   
    /*
	current obecjt/element should be in the form itself

    */
    special_before(action);
    option = (option == undefined)?0:option;
  
    var script = action_arr[action+'_script'];
   
    var form_name = action_arr[action+'_form'];
    
    if(action_arr[action+'_msgbox']!='global_msgbox')
                  $('#'+action_arr[action+'_msgbox']).html('');
    else
                  $('#gmbox_content').html('');
    
    /*var fire_once = true; 
 
    
   
        if (!fire_once)
             return 'fire_once';
                           
        fire_once=false;*/
    
    $('#'+action_arr[action+'_btn']).button('loading');
    
	$.post(script, $("#"+form_name).serialize(), function(dataReturn) {
	
		$('#'+action_arr[action+'_loader']).hide();
	
		var obj = jQuery.parseJSON(dataReturn);
                if(action_arr[action+'_req_msg'])
                        if(action_arr[action+'_msgbox']!='global_msgbox'){
                                $('#'+action_arr[action+'_output_container']).html('');
                                $('#'+action_arr[action+'_msgbox']).html(obj.Msg);
                                 
                        }
                        else{
                               
                                 if (obj.Ack=="success"){
                                          $('#'+action_arr[action+'_msgbox']).css({'background-color':'#BA211C'});
                                 }
                                 else{
                                          $('#'+action_arr[action+'_msgbox']).css({'background-color':'#BA211C'});
                                 }
                                
                                $('#gmbox_content').html(obj.Msg);
                                $('#'+action_arr[action+'_msgbox']+', #shade').fadeIn(300);   
                        }
		if (obj.Ack=="success"){
		  
		   
		    
		    if(action_arr[action+'_req_temp'])
			template(action,obj);
		    
		    
		}
		else{
		    if(action_arr[action+'_req_err'] && action_arr[action+'_msgbox']!='global_msgbox')
			err_msg(action,obj);
		}
                special_after(action,obj,option);
		$('#'+action_arr[action+'_btn']).button('reset');
	});
  
    
}


//js end of the template engine

function template(action,obj){
    
    var template 		= obj.template;
    //template instructions for temp engine
    var temp_inst	 	= obj.temp_inst;
    var data			= obj.data;
    var template_buildup	= '';
    var alt = false;
    var counter_flag = 0;
    for (x in data){
	counter_flag++;
	template_buildup += template;
	switch (action){
            case 'get_projects_search':
                
                if(counter_flag==3 && $('#get_projects_search_form').find('#ge_proj_container').val()!='table'){
                    template_buildup += "<div class='clb'></div>";
                    counter_flag=0;
                }
                
                break;
            case 'get_projects_search_con':
                
                if(counter_flag==3){
                    template_buildup += "<div class='clb'></div>";
                    counter_flag=0;
                }
                
                break;
        }
        //alert(obj.data.cur_symbol);
        if(cur_symbol != undefined){
            template_buildup = template_buildup.replace(/##cur_symbol##/gi,cur_symbol);
            
        }
        else{
            template_buildup = template_buildup.replace(/##cur_symbol##/gi,"$");
        }
	for (y in data[x]){
	//alert(y);
	var regExp = new RegExp('##'+y+'##',"gi");
        data[x][y] = (data[x][y]==null || data[x][y]=='null')?0:data[x][y];
        
        if(action != 'get_user' && action !='get_clients_dash' )
            data[x][y] = (isNumber(data[x][y]))?numberWithCommas(data[x][y]):data[x][y];
            
	    if(temp_inst[y]!=undefined){
		switch(temp_inst[y]['instructions']){
		    
		    case 'min':
			//make shorter to fit design
			template_buildup = template_buildup.replace(regExp,StrShort(data[x][y],parseInt(temp_inst[y]['minlen'])));
			break;
		    case 'link':
			//turn into a link on the fly
                        if(action=='get_discuss_coms' || action=='get_comments'){
                            data[x][y]=nl2br(data[x][y]);
                            
                        }
                            
			template_buildup = template_buildup.replace(regExp,linkify(data[x][y]));
			break;
		    default:
			template_buildup = template_buildup.replace(regExp,data[x][y]);
			break;
		    
		}
	    }
	    else{
		template_buildup = template_buildup.replace(regExp,data[x][y]);
	    }
	    
	    
	    
	}
	if (alt){
	    template_buildup = template_buildup.replace('##alt##',' alt ');
	    alt = false;
	    //console.log('alt - true');
	}
	else{
	    template_buildup = template_buildup.replace('##alt##','');
	    alt= true;
	    //console.log('alt - false');
		
	}
	
    }
    
    switch (action){
            case 'get_projects_search':
                
                if(counter_flag!=3){
                    template_buildup += "<div class='clb'></div>";
                
                }
                
                break;
            case 'get_projects_search_con':
                
                if(counter_flag!=3){
                    template_buildup += "<div class='clb'></div>";
                
                }
                
                break;
    }
   
    $('#'+action_arr[action+'_output_container']).html(template_buildup);
   
    /* 
	$.each(data, function(property, value) {
	
		template_buildup += template;
		
	});
    */
    
}





//Other functions

function set_ub_stats(){
         
	$.post("ajax/ub_set_stats.php",{width:screen.width,height:screen.height});
	
}









/* UTLITIES */





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






function linkify(inputText) {
	var replaceText, replacePattern1, replacePattern2, replacePattern3;

	
	replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
	replacedText = inputText.replace(replacePattern1, '<a rel="nofollow" href="$1" target="_blank">$1</a>');

	replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
	replacedText = replacedText.replace(replacePattern2, '$1<a rel="nofollow" href="http://$2" target="_blank">$2</a>');
	
	return replacedText
}

function StrShort(inputString,StrLength){
	
	if (StrLength==undefined || StrLength ==''){
		StrLength==25;
	}
	if (inputString.length>StrLength){
		inputString = inputString.substr(0,StrLength)+'...'+inputString.substr(-10);
	}
	return inputString;
	
}

function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function nl2br (str, is_xhtml) {   
var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<div style="height:5px;"></div>' : '<div style="height:5px;"></div>';    
return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}


