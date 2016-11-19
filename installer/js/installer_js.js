function install(){
	$('#success, #warn').slideUp(300);
	
        var dbserver = $('#dbserver').val();
        var dbname = $('#dbname').val();
        var dbusername = $('#dbusername').val();
        var dbpassword = $('#dbpassword').val();
        
        var recap_pub = $('#recap_public').val();
        var recap_pri = $('#recap_private').val();

	if ($('#dbtestdata').is(':checked')){
		var dbtestdata=1;
	}
	else{
		var dbtestdata=0;
	}

	$('#loading').fadeIn(500,function(){
		$.post("ajax/installer.php",{ dbserver:dbserver,
					    dbname:dbname,
					    dbusername:dbusername,
					    dbpassword:dbpassword,
					    recap_pub:recap_pub,
					    recap_pri:recap_pri,
					    dbtestdata:dbtestdata
		       
						},function(dataReturn){
			
				var obj = jQuery.parseJSON(dataReturn);
				$('#loading').fadeOut(500,function(){
					if(obj.Ack=='success'){
						$('#success').slideDown(500);
					 }
					 else{
						
					       $('#errors_js').html(obj.Msg);
					       $('#warn').slideDown(500);
					 }
				});
				  
				
		});
	});
    
}