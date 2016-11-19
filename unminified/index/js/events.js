//========user management - userBase==========



function registerUser(){
	
	//get data
	//or use form?
	
	//validate and then submit
	
	//????????
	//$('#target').submit();
	//????????
	
	$('#submit_register_error').html('');
	//in userBase give option to do this or ajax the regisrtaion
	$('#submit_register_load').fadeOut(100);
	$('#submit_register_load').attr('src','../images/loader/sm_dg.gif');
	
	
	var username 	= $('#username_register').val();
	var email 	= $('#email_register').val();
	
	//check if js md5 is same as PHP and then use that
	
	var p1 = hex_md5($('#p1_register').val());
	var p2 = hex_md5($('#p2_register').val());
	
	var contact     = $('#contact_register').is(':checked');
	
	/*recaptcha from google*/
	var recaptcha_challenge_field     = $('#recaptcha_challenge_field').val();
	var recaptcha_response_field      = $('#recaptcha_response_field').val();
	
	if(contact==false){
		contact=0;
	}
	else{
		contact=1;
	}
	//system will do server side validation one more time 'just in case'.
	$('#submit_register_load').fadeIn(100,function(){
		$.post("../ajax/ub_register_user.php",{email:email,
						       username:username,
						       p1:p1,
						       p2:p2,
						       contact:contact,
						       recaptcha_challenge_field:recaptcha_challenge_field,
						       recaptcha_response_field:recaptcha_response_field
						       },function(dataReturn){
			    
			    var obj = jQuery.parseJSON(dataReturn);
			    
			   
			    
			    if (obj.Ack=="success"){
				 
				 Recaptcha.reload();
				$('#submit_register_error').html(obj.Msg);
			
				$('#capt_register_error').html('');
				$('#capt_register_load').attr('src','../images/tick.png');
				$('#capt_register_load').fadeIn(300);
				
	
			    }
			    else if (obj.Ack=="validationFail"){
				//go through and display php validation
				
				
				if (obj.validationdata.usernameAck=='fail'){
					$('#username_register_error').html(obj.validationdata.usernameMsg);
					$('#username_register_load').attr('src','../images/cross.png');
					$('#username_register_load').fadeIn(300);
				}
				else{
					$('#username_register_error').html('');
					$('#username_register_load').attr('src','../images/tick.png');
					$('#username_register_load').fadeIn(300);
				}
				
				if (obj.validationdata.emailAck=='fail'){
					$('#email_register_error').html(obj.validationdata.emailMsg);
					$('#email_register_load').attr('src','../images/cross.png');
					$('#email_register_load').fadeIn(300);
				}
				else{
					$('#email_register_error').html('');
					$('#email_register_load').attr('src','../images/tick.png');
					$('#email_register_load').fadeIn(300);
				}
				
				if (obj.validationdata.passwordAck=='fail'){
					$('#p2_register_error').html(obj.validationdata.passwordMsg);
					$('#p2_register_load').attr('src','../images/cross.png');
					$('#p2_register_load').fadeIn(300);
				}
				else{
					$('#p2_register_error').html('');
					$('#p2_register_load').attr('src','../images/tick.png');
					$('#p2_register_load').fadeIn(300);
				}
				 
				if (obj.validationdata.blockAck=='fail'){
					$('#submit_register_error').html(obj.validationdata.blockMsg);
					
					
				}
				else{
					$('#submit_register_error').html('correct the errors and try again.');
				}
				
				if (obj.validationdata.captAck=='fail'){
					$('#capt_register_error').html(obj.validationdata.captMsg);
					$('#capt_register_load').attr('src','../images/cross.png');
					$('#capt_register_load').fadeIn(300);
					Recaptcha.reload();
					
				}
				else{
					$('#capt_register_error').html('');
					$('#capt_register_load').attr('src','../images/tick.png');
					$('#capt_register_load').fadeIn(300);
				} 
				 
				 
				
				
			    }
			    else{
				$('#submit_register_error').html(obj.Msg);
			    }
			   
		});
	});
	
	$('#submit_register_load').fadeOut(100);
	
	
}

function checkUsername(source,endid){
	
	//alert($('#username_'+endid).val());
	$('#username_'+endid+'_load').attr('src','../images/loader/sm_dg.gif');
	var username= $('#username_'+endid).val();
	
	//0=register 1=edit - but that's not really used outside admin
			
	//change_email_load
	//change_error_email
	
	//check input/length/validness/if already exists (need to send in source)
	$('#username_'+endid+'_load').fadeIn(100,function(){
		$.post("../ajax/ub_check_username_valid.php",{username:username,source:source},function(dataReturn){
			    var obj = jQuery.parseJSON(dataReturn);
						 
			    if (obj.Ack=="success"){
				 
				
				 //set tick
				 $('#username_'+endid+'_error').html('');
				 $('#username_'+endid+'_load').attr('src','../images/tick.png');
				 $('#username_'+endid+'_load').fadeIn(300);
				// return true;
	
			    }
			    else{
				//set cross
				
				$('#username_'+endid+'_error').html(obj.validationdata.usernameMsg);
				 $('#username_'+endid+'_load').attr('src','../images/cross.png');
				 
				 $('#username_'+endid+'_load').fadeIn(300);
				
			       //return false;
			    }
			   
		});
	});
	//nasty hack ahead - workout how to get return values from callBack.
	if ($('#username_'+endid+'_error').html()==''){
		return true;
	}
	else{
		return false;
	}
	
}

function set_screen_res(){

	$.post("../ajax/ub_set_screen_res.php",{width:screen.width,height:screen.height});
	//no data sent back - silent function - if it fails, oh well!
}




function checkPasswords(source,endid){
	$('#p2_'+endid+'_load').attr('src','../images/loader/sm_dg.gif');
	var return_value = '';
	//1 = reg/change 2=for login (not really useful)
	if (source==0){
		//register+change - check both passwords
		
		var p1 = $('#p1_'+endid).val();
		var p2 = $('#p2_'+endid).val();
		
		$('#p2_'+endid+'_load').fadeIn(100,function(){
			
			if (p1!=p2){
				//mismatch
				$('#p2_'+endid+'_error').html('passwords do not match');
				$('#p2_'+endid+'_load').attr('src','../images/cross.png');
				//return false;
			}
			else{
				if(p1=='' || p2 ==''){
					
					//not entered
					$('#p2_'+endid+'_error').html('password not entered');
					$('#p2_'+endid+'_load').attr('src','../images/cross.png');
					//return false;
				}
				else{
					if (p1.length<6 || p2.length<6){
						//too short
						//eventually make more advanced version of this to test strength
						$('#p2_'+endid+'_error').html('password is too short');
						$('#p2_'+endid+'_load').attr('src','../images/cross.png');
						//return false;
					}
					else{
						//ok
						
						$('#p2_'+endid+'_error').html(check_password_safety(p1));
						$('#p2_'+endid+'_load').attr('src','../images/tick.png');
						//return true;
						
					}
				}
			}
			
		});
		
	}
	else if (source==1){
	
		//this part is useless? - yes - not going to use it: marked for removal
		//login - make sure not empty
		var p1 = $('#p1_login').val();

		
		$('#p1_login_load').fadeIn(100,function(){
			if(p1=='' ){
				
				//not entered
				$('#p1_login_error').html('password not entered');
				$('#p1_login_load').attr('src','../images/cross.png');
				return false;
			}
			
			else{
				//ok
				return true;
				
			}
			
		});
	}
	
	//nasty hack ahead - workout how to get return values from callBack.
	if ($('#p2_'+endid+'_load').attr('src')=='../images/tick.png'){
		return true;
	}
	else{
		return false;
	}
	
}

function checkEmail(source,endid){
	
	
	var email= $('#email_'+endid).val();
	
	//source = 0 reg, 1 = change	
	//check input/length/validness/if already exists (need to send in source)
	
	$('#email_'+endid+'_load').attr('src','../images/loader/sm_dg.gif');
	$('#email_'+endid+'_load').fadeIn(100,function(){
		$.post("../ajax/ub_check_email_valid.php",{email:email,source:source},function(dataReturn){
			    var obj = jQuery.parseJSON(dataReturn);
						 
			    if (obj.Ack=="success"){
				 
				 //set tick
				 $('#email_'+endid+'_load').attr('src','../images/tick.png');
				 $('#email_'+endid+'_error').html('');
				 $('#email_'+endid+'_load').fadeIn(300);
				// return true;
	
			    }
			    else{
				//set cross
				 $('#email_'+endid+'_load').attr('src','../images/cross.png');
				 $('#email_'+endid+'_error').html(obj.validationdata.emailMsg);
				 $('#email_'+endid+'_load').fadeIn(300);
				
				//return false;
			    }
			   
		});
		
		
	});
	//nasty hack ahead - workout how to get return values from callBack.
	if ($('#email_'+endid+'_error').html()==''){
		return true;
	}
	else{
		return false;
	}
}

function checkForgot(){
	
	var forgot= $('#user_email_forgot').val();
			
	//change_email_load
	//change_error_email
	
	//check against existing records
	
	$.post("../ajax/com_eng/check_forgot_valid.php",{forgot:forgot},function(dataReturn){
                    var obj = jQuery.parseJSON(dataReturn);
                                         
                    if (obj.Ack=="success"){
                         
			 //set tick
			 $('#user_email_forgot_load').attr('src','../images/tick.png');
			 $('#user_email_forgot_error').html();

                    }
                    else{
			//set cross
			 $('#user_email_forgot_load').attr('src','../images/cross.png');
			 $('#user_email_forgot_error').html();
			
                       
                    }
                   
        });
	
}

function loginUser(){
	
	
	//again use jquery for submiting but on userbase give two options
	
	$('#submit_login_error').html('');
	var username = $('#username_login').val();
	var password = hex_md5($('#p1_login').val());
	$('#submit_login_load').fadeIn(100,function(){
		$.post("../ajax/ub_login_user.php",{username:username,password:password},function(dataReturn){
			    var obj = jQuery.parseJSON(dataReturn);
						 
			    if (obj.Ack=="success"){
				 
				 //do anything else you need to on success - like refresh page
				 
				 $('#submit_login_error').html(obj.Msg);
	
			    }
			    else{
				//do anything else you need to on fail
				 
				 
				 $('#submit_login_error').html(obj.Msg);
				
			       
			    }
			    
		});
	});
	$('#submit_login_load').fadeOut(100);
	
	
}

function changeEmail(){
	
	
			
	 
	//change_email_load
	//change_error_email
	
	//check against existing records
	$('#submit_change_email_error').html('');
	var email = $('#email_change').val();
	var p1 = hex_md5($('#p3_change').val());
	$('#submit_change_email_load').fadeIn(100,function(){
		$.post("../ajax/ub_save_edit_email.php",{email:email,p1:p1},function(dataReturn){
			    var obj = jQuery.parseJSON(dataReturn);
						 
			    if (obj.Ack=="success"){
				 //ba383f6d464c50f11899e8ba894022b6
				 //set tick
				 $('#email_change_load').attr('src','../images/tick.png');
				$('#email_change_error').html('');
				
				$('#p3_change_load').attr('src','../images/tick.png');
				$('#p3_change_error').html('');
				 $('#submit_change_email_error').html(obj.Msg);
	
			    }
			    else if (obj.Ack=='validationFail'){
				//set cross
				
				if (obj.validationdata.emailAck == 'fail'){
					$('#email_change_load').attr('src','../images/cross.png');
					$('#email_change_error').html(obj.validationdata.emailMsg);
					
				}
				 
				if (obj.validationdata.passAck == 'fail'){
					$('#p3_change_load').attr('src','../images/cross.png');
					$('#p3_change_error').html(obj.validationdata.passMsg);
				
				}
			        $('#submit_change_email_error').html(obj.Msg);
			    }
			    else{
				//set cross
				 $('#email_change_load').attr('src','../images/cross.png');
				 $('#submit_change_email_error').html(obj.Msg);
			    }
			    
			    $('#p3_change_load').fadeIn(300);
			    $('#email_change_load').fadeIn(300);
			     
		});
	});
	
	$('#submit_change_email_load').fadeOut(100);
	
}

function changePs(){

	$('#submit_change_ps_error').html('');
	$('#submit_change_ps_load').fadeIn(100,function(){
		if (checkPasswords(0,'change')){
			
			var p1 = hex_md5($('#p1_change').val());
			var p2 = hex_md5($('#p2_change').val());
			var p4 = hex_md5($('#p4_change').val());
		
			$.post("../ajax/ub_save_edit_ps.php",{p1:p1,p2:p2,p4:p4},function(dataReturn){
				    var obj = jQuery.parseJSON(dataReturn);
							 
				    if (obj.Ack=="success"){
					 
					 //set tick
					 $('#p2_change_load').attr('src','../images/tick.png');
					 $('#submit_change_ps_error').html(obj.Msg);
					 $('#email_change_error').html('');
					 $('#p4_change_load').attr('src','../images/tick.png');
					 $('#p4_change_error').html('');			
					 
		
				    }
				    else if (obj.Ack=='validationFail'){
					
					if (obj.validationdata.passwordAck == 'fail'){
						$('#p2_change_load').attr('src','../images/cross.png');
						$('#p2_change_error').html(obj.validationdata.passwordMsg);
						$('#submit_change_ps_error').html(obj.Msg);
					}
					
					if (obj.validationdata.passAck == 'fail'){
						$('#p4_change_load').attr('src','../images/cross.png');
						$('#p4_change_error').html(obj.validationdata.passMsg);
						$('#submit_change_ps_error').html(obj.Msg);
					}
					
				       
				    }
				    else{
					//set cross
					 $('#p2_change_load').attr('src','../images/cross.png');
				
					 $('#submit_change_ps_error').html(obj.Msg);
				    }
				    $('#p4_change_load').fadeIn(300);
				    $('#p2_change_load').fadeIn(300);
				   
			});
		
		
		}
		else{
			$('#submit_change_ps_error').html('correct the errors and try again');
		}
	});
	$('#submit_change_ps_load').fadeOut(100);
	
}

function activateAcc(){
	//var username_email = $('#user_email_forgot').val();
	
	$.post("../ajax/ub_activate.php",{a:'1291125424',u:'149e9677a5989fd342ae44213df68868'},function(dataReturn){
		
		alert(dataReturn);
		
	});
}

function forgotPs(){
	
	alert(hex_md5('abc'));
	
	var username_email = $('#user_email_forgot').val();
	
	$.post("../ajax/ub_forgot_ps.php",{username_email:username_email},function(dataReturn){
		
		alert(dataReturn);
		
	});
	
}

function check_password_safety(pwd){

	var msg = "";
	var points = pwd.length;
	
	
	var has_letter		= new RegExp("[a-z]");
	var has_caps		= new RegExp("[A-Z]");
	var has_numbers		= new RegExp("[0-9]");
	var has_symbols		= new RegExp("\\W");
	
	if(has_letter.test(pwd)) 	{ points += 4; }
	if(has_caps.test(pwd)) 		{ points += 4; }
	if(has_numbers.test(pwd)) 	{ points += 4; }
	if(has_symbols.test(pwd)) 	{ points += 4; }
	
	
	if( points >= 24 ) {
		msg = '<span style="color: #0f0;">Your password is strong.</span>';
	} else if( points >= 16 ) {
		msg = '<span style="color: #00f;">Your password is medium strength.</span>';
	} else if( points >= 12 ) {
		msg = '<span style="color: #fa0;">Your password is weak.</span>';
	} else {
		msg = '<span style="color: #f00;">Your password is very weak.</span>';
	}
	
	return msg ;
}



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

function nl2br (str, is_xhtml) {
    // Converts newlines to HTML line breaks  
    // 
    // version: 1009.2513
    // discuss at: http://phpjs.org/functions/nl2br    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Philip Peterson
    // +   improved by: Onno Marsman
    // +   improved by: Atli Þór
    // +   bugfixed by: Onno Marsman    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Maximusya
    // *     example 1: nl2br('Kevin\nvan\nZonneveld');    // *     returns 1: 'Kevin\nvan\nZonneveld'
    // *     example 2: nl2br("\nOne\nTwo\n\nThree\n", false);
    // *     returns 2: '<br>\nOne<br>\nTwo<br>\n<br>\nThree<br>\n'
    // *     example 3: nl2br("\nOne\nTwo\n\nThree\n", true);
    // *     returns 3: '\nOne\nTwo\n\nThree\n'
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '' : '<br>';
 
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
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


//linkify 

function linkify(inputText) {
	var replaceText, replacePattern1, replacePattern2, replacePattern3;

	
	replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
	replacedText = inputText.replace(replacePattern1, '<a rel="nofollow" href="$1" target="_blank">$1</a>');

	replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
	replacedText = replacedText.replace(replacePattern2, '$1<a rel="nofollow" href="http://$2" target="_blank">$2</a>');
	
	return replacedText
}

function URLShort(inputString){
	
	if (inputString.length>55){
		inputString = inputString.substr(0,30)+'...'+inputString.substr(-5);
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
