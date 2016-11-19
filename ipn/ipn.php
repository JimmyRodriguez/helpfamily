<?php
/*
 * ipn.php
 *
 * PHP Toolkit for PayPal v0.51
 * http://www.paypal.com/pdn
 *
 * Copyright (c) 2004 PayPal Inc
 *
 * Released under Common Public License 1.0
 * http://opensource.org/licenses/cpl.php
 *
 */

//need to include lightworks bootstrap.php
require_once('local_config.php'); 
require_once('../includes/bootstrap_frontend.php'); 

//get global configuration information
include_once('../config/global_config.inc.php'); 

//get pay pal configuration file
include_once('../config/config.inc.php'); 
include_once('../config/config_global.php'); 

//-----------

    //need to global magic this lot
    $array_of_data = array();
   //$paypal_receiver_email = PAYPAL_EMAIL;
    $array_of_data['business'] = $business = trim(stripslashes(@$_POST['business'])); 
    $array_of_data['item_name'] = $item_name = trim(stripslashes(@$_POST['item_name']));
    $array_of_data['item_number'] = $item_number = trim(stripslashes(@$_POST['item_number']));
    $array_of_data['payment_status'] = $payment_status = trim(stripslashes(@$_POST['payment_status']));
    
    // The order total amount including taxes, shipping and discounts
    $array_of_data['mc_gross'] = $mc_gross = trim(stripslashes(@$_POST['mc_gross']));
    
    // Can be USD, GBP, EUR, CAD, JPY
    $array_of_data['mc_currency'] = $currency_code =  trim(stripslashes(@$_POST['mc_currency']));
    
    $array_of_data['txn_id'] = $txn_id = trim(stripslashes(@$_POST['txn_id']));
    $array_of_data['receiver_email'] = $receiver_email = trim(stripslashes(@$_POST['receiver_email']));
    $array_of_data['payer_email'] = $payer_email = trim(stripslashes(@$_POST['payer_email']));
    $array_of_data['payment_date'] = $payment_date = trim(stripslashes(@$_POST['payment_date']));
    
    $array_of_data['payment_date'] = date('Y-m-d H:i:s', strtotime($payment_date));
    
    // The Order Number (not order_id !)
    $array_of_data['invoice'] = $invoice =  trim(stripslashes(@$_POST['invoice']));
    
    $array_of_data['amount'] = $amount =  trim(stripslashes(@$_POST['amount']));
    
    $array_of_data['quantity'] = $quantity = trim(stripslashes(@$_POST['quantity']));
    $array_of_data['pending_reason'] = $pending_reason = trim(stripslashes(@$_POST['pending_reason']));
    $array_of_data['payment_method'] = $payment_method = trim(stripslashes(@$_POST['payment_method'])); // deprecated
    $array_of_data['payment_type'] = $payment_type = trim(stripslashes(@$_POST['payment_type']));
    
    // Billto
    $array_of_data['first_name'] = $first_name = trim(stripslashes(@$_POST['first_name']));
    $array_of_data['last_name'] = $last_name = trim(stripslashes(@$_POST['last_name']));
    $array_of_data['address_street'] = $address_street = trim(stripslashes(@$_POST['address_street']));
    $array_of_data['address_city'] = $address_city = trim(stripslashes(@$_POST['address_city']));
    $array_of_data['address_state'] = $address_state = trim(stripslashes(@$_POST['address_state']));
    $array_of_data['address_zip'] = $address_zipcode = trim(stripslashes(@$_POST['address_zip']));
    $array_of_data['address_country'] = $address_country = trim(stripslashes(@$_POST['address_country']));
    $array_of_data['residence_country'] = $residence_country = trim(stripslashes(@$_POST['residence_country']));
    
    $array_of_data['address_status'] = $address_status = trim(stripslashes(@$_POST['address_status']));
    
    $array_of_data['payer_status'] = $payer_status = trim(stripslashes(@$_POST['payer_status']));
    $array_of_data['notify_version'] = $notify_version = trim(stripslashes(@$_POST['notify_version'])); 
    $array_of_data['verify_sign'] = $verify_sign = trim(stripslashes(@$_POST['verify_sign'])); 
    $array_of_data['custom'] = $custom = trim(stripslashes(@$_POST['custom'])); 
    $array_of_data['txn_type'] = $txn_type = trim(stripslashes(@$_POST['txn_type'])); 

//-----------

        // Get the list of IP addresses for www.paypal.com and notify.paypal.com
       
       
       
        $paypal_iplist = gethostbynamel('www.paypal.com');
	$paypal_iplist2 = gethostbynamel('notify.paypal.com');
        $paypal_iplist = array_merge( $paypal_iplist, $paypal_iplist2 );

        $paypal_sandbox_hostname = 'ipn.sandbox.paypal.com';
        $remote_hostname = gethostbyaddr( $_SERVER['REMOTE_ADDR'] );
        
        $valid_ip = false;
        
        if( $paypal_sandbox_hostname == $remote_hostname ) {
            $valid_ip = true;
            //$hostname = 'www.sandbox.paypal.com';
        }
        else {
            $ips = "";
            // Loop through all allowed IPs and test if the remote IP connected here
            // is a valid IP address
            foreach( $paypal_iplist as $ip ) {
                $ips .= "$ip,\n";
                $parts = explode( ".", $ip );
                $first_three = $parts[0].".".$parts[1].".".$parts[2];
                if( preg_match("/^$first_three/", $_SERVER['REMOTE_ADDR']) ) {
                    $valid_ip = true;
                }
            }
            //$hostname = 'www.paypal.com';
        }
        
        if( !$valid_ip ) {
           
	    
	    $subject = "PayPal IPN Transaction on your site: Possible fraud";
	    $content = "Error code 506. Possible fraud. Error with REMOTE IP ADDRESS = ".$_SERVER['REMOTE_ADDR'].". 
                        The remote address of the script posting to this notify script does not match a valid PayPal ip address\n
            These are the valid IP Addresses: $ips
            
            The Order ID received was: $invoice";
			  
	    $email = PP_LOGS_EMAIL;
		//echo 'error##: invalid ip';
	     Admin::sendEmail($subject,$content,$email);
	    
            
	    
            //exit();
        }

/*-------------*/


//decide which post method to use
switch($paypal['post_method']) { 

case "libCurl": //php compiled with libCurl support

$result=libCurlPost($paypal['url'],$_POST); 


break;


case "curl": //cURL via command line

$result=curlPost($paypal['url'],$_POST); 

break; 


case "fso": //php fsockopen(); 

$result=fsockPost($paypal['url'],$_POST);
$result_str = $result=implode(",",$result);

break; 


default: //use the fsockopen method as default post method

$result=fsockPost($paypal['url'],$_POST);
$result_str = $result=implode(",",$result);

break;

}

//need to do some sort of ip checking before posting data as in joomla/virtumart notify.php


//check the ipn result received back from paypal

if(eregi("VERIFIED",$result_str)) 
{
    
    if(isset($paypal['business']))
    {
        //>>>>>>log successful transaction to file or database <<<<<<<<<<<<<<<<<<<
        
        
        //try to send data to paypal with users ip - else I think this will just be paypals ip
        $ipad = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
        if(eregi("Completed",$payment_status) || eregi("Pending",$payment_status)){
            /* - this orderid does not match anything
            if (empty($order_id)) {
                //send error to admin email
		log_inp_db($array_of_data,'missing order id value');
                $subject = "IPN: missing order id value txn id: $txn_id";
		$content = "Error occurred: payment status: $payer_status \n\n"
			  ."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
			  ."paypal transaction id: $txn_id";
			  
		$email = PP_LOGS_EMAIL;
		
		// Admin::sendEmail($subject,$content,$email);
                exit();
            }
	    */
            $invoice_response = getinvoice($invoice);
	    if($invoice_response!==false){
		$userid = $invoice_response['data']['userid'];
		$user_email = general::globalGetOnePieceOfData('email','user_table', " userid='$userid' ");
		if($invoice_response['data']['amount']!=$mc_gross){
		    //should this be checking against user record? - I thnk so
		    log_inp_db($array_of_data,'ms_gross/amount values error');
		    $subject = "IPN: ms_gross/amount values error - txn id: $txn_id";
		    $content = "Error occurred: payment status: $payer_status \n\n"
			      ."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
			      ."paypal transaction id: $txn_id";
			      
		    $email = PP_LOGS_EMAIL;
		    //echo 'error##: invalid invoice amount';
		    Admin::sendEmail($subject,$content,$email);
		    
		    exit();
		}
	    }
	    else{
		    log_inp_db($array_of_data,'could not find matching invoice in payments');
		    $subject = "IPN: could not find invoice - txn id: $txn_id";
		    $content = "Error occurred: payment status: $payer_status \n\n"
			      ."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
			      ."paypal transaction id: $txn_id";
			      
		    $email = PP_LOGS_EMAIL;
		    //echo 'error##: invalid invoic id';
		    Admin::sendEmail($subject,$content,$email);
		    
		    exit();
	    }
            
            if (eregi ("Completed", $payment_status)){
              
                log_inp_db($array_of_data,'successful payment');
		
		$data = array(
			      "paid"=>1,
			      "valid"=>1,
			      "userid"=>$userid,
			      "status"=>$payment_status,
			      "amount"=>$invoice_response['data']['amount'],
			      "ipad"=>$ipad,
			      "txn_id"=>$txn_id,
			      "invoice"=>$invoice_response['data']['pid'],
			      "source"=>$invoice_response['data']['type'],
			      "group"=>$invoice_response['data']['group']
			      );
		$expire_in = general::globalGetOnePieceOfData('expire_in_days','user_groups', " groupid='".$invoice_response['data']['group']."' ");
                $data['expire'] = $expire_in;
		//$response = Admin::update_user_and_payments_ipn(1,1,$userid,$payment_status,$invoice_response['data']['amount'],$ipad,$txn_id,$invoice_response['data']['pid'],$invoice_response['data']['type'],$invoice_response['data']['group']);
                $response = Admin::update_user_and_payments_ipn($data);

                if($response == 'okay'){
		    
		    
                    //send email for completed
		    $subject = "IPN: successful payment - txn id: $txn_id";
		    $content = "payment status: $payer_status \n\n"
			  ."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
			  ."paypal transaction id: $txn_id";
			  
		    $email = PP_LOGS_EMAIL;
		    //echo 'error##: success';
		    //Admin::sendEmail($subject,$content,$email);
                }
                else{
                    //send email with response error code indicating there was an error
		    $subject = "IPN: successful payment BUT failed dbase ($response) - txn id: $txn_id";
		    $content = "payment status: $payer_status - error:$response \n\n"
			  ."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
			  ."paypal transaction id: $txn_id - this transaction was not logged";
			  
		    $email = PP_LOGS_EMAIL;
		    //echo 'error##: success but no db'.$response;
		    
                }
                 Admin::sendEmail($subject,$content,$email);
		
		
		switch ($invoice_response['data']['type']){
		    case 'newreg':
			$wel_sub = 'Your account at '.SITENAME.' has been created!';
			$emailfile = 'new_reg.php';
			break;
		    case 'upgrade':
			$wel_sub = 'Your account at '.SITENAME.' has been upgraded!';
			$emailfile = 'upgrade.php';
			break;
		    case 'renew':
			$wel_sub = 'Your membership at '.SITENAME.' has been renewed!';
			$emailfile = 'renew.php';
			break;
		    
		}
		
		$wel_con = general::getFile('../ajax/html/email/'.$emailfile);
		
		$wel_con = str_replace('[[tranid]]',$txn_id.'/'.$invoice,$wel_con);
		$wel_con = str_replace('[[site]]',SITENAME,$wel_con);

		general::globalEmail($user_email,REG_EMAIL,$wel_con, $wel_sub);
                
                //update payments table as well with a new record!!!
                
                
            }
            elseif (eregi ("Pending", $payment_status)){
		log_inp_db($array_of_data,"pending payment : ($pending_reason)");
		//$paid,$valid,$userid,$status,$amount,$ipad,$txn_id,$invoice,$source,$group
		$data = array(
			      "paid"=>2,
			      "valid"=>0,
			      "userid"=>$userid,
			      "status"=>$payment_status,
			      "amount"=>$invoice_response['data']['amount'],
			      "ipad"=>$ipad,
			      "txn_id"=>$txn_id,
			      "invoice"=>$invoice_response['data']['pid'],
			      "source"=>$invoice_response['data']['type'],
			      "group"=>$invoice_response['data']['group']
			      );
                //$response = Admin::update_user_and_payments_ipn(2,0,$userid,$payment_status,$invoice_response['data']['amount'],$ipad,$txn_id,$invoice_response['data']['pid'],$invoice_response['data']['type'],$invoice_response['data']['group']);
                $response = Admin::update_user_and_payments_ipn($data);
		if($response == 'okay'){
                    //send email for pending
		     $subject = "IPN: pending payment: ($pending_reason) - txn id: $txn_id";
		    $content = "payment status: $payer_status - $pending_reason\n\n"
			  ."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
			  ."paypal transaction id: $txn_id";
			  
		    $email = PP_LOGS_EMAIL;
		    //echo 'error##: pending '.$pending_reason;
		    //// Admin::sendEmail($subject,$content,$email);
		    
                }
                else{
		 
                    //send email with response error code indicating there was an error
		    $subject = "IPN: pending payment: ($pending_reason) BUT failed dbase ($response) - txn id: $txn_id";
		    $content = "payment status: $payer_status - $pending_reason - error:$response \n\n"
			  ."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
			  ."paypal transaction id: $txn_id - this transaction was not logged";
			  
		    $email = PP_LOGS_EMAIL;
		    //echo 'error##: pending but no db'.$pending_reason;
		    
                }
		 Admin::sendEmail($subject,$content,$email);
            }
            
        }
        else{
            //invalid - set some sort of flag on account?
            //email payments@nadlabs.com
	    log_inp_db($array_of_data,"unknown error: does not match pending or complete");
	    $subject = "IPN: unknown error - txn id: $txn_id";
	    $content = "payment status: $payer_status  \n\n"
		  ."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
		  ."paypal transaction id: $txn_id - this transaction was not logged";
		  
	    $email = PP_LOGS_EMAIL;
	    //echo 'error##: unknown '.$payer_status;
	     Admin::sendEmail($subject,$content,$email);
        }
    
    }
    else{
        die('doomed');
    }
    
} 

else 
{
    if(isset($paypal['business']))
    {
        //log successful transaction to file or database
        if (eregi ("INVALID", $result_str)) {
                log_inp_db($array_of_data,'WARNING INVALID PAYMENT');
		
                //email about suspect payment
		$subject = "IPN: WARNING INVALID PAYMENT - txn id: $txn_id";
		$content = "payment status: $payer_status  \n\n"
		."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
		."paypal transaction id: $txn_id ";
		  
		$email = PP_LOGS_EMAIL;
		//echo 'error##: INVALID ';
		

        }
        else {
                //email general error
		log_inp_db($array_of_data,'SOME ERROR OCCURED (1)');
		
		$subject = "IPN: SOME ERROR OCCURED (1) - txn id: $txn_id";
		$content = "payment status: $payer_status  \n\n"
		."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
		."paypal transaction id: $txn_id ";
		  
		$email = PP_LOGS_EMAIL;
		//echo 'error##: INVALID OTHER ';
		
        }
	Admin::sendEmail($subject,$content,$email);
    }
    else{
	    $subject = "IPN: SOME ERROR OCCURED (2) - txn id: $txn_id";
	    $content = "payment status: $payer_status  \n\n"
		."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
		."paypal transaction id: $txn_id ";
		  
	    $email = PP_LOGS_EMAIL;
	    //echo 'error##: INVALID 2';
	     Admin::sendEmail($subject,$content,$email);
	    die('doomed');
    }
    
    
} 



 function log_inp_db($array_of_data,$notification){
    $set='NULL';
    global $conn;
    foreach($array_of_data as $ipn_value)
    {
	$set .= ",'$ipn_value'";
    }
    
    $sql_ipn = "INSERT INTO ipn_logs VALUES ($set,'$notification',now())";
    
    $dataPostBack =  dbase::globalQuery($sql_ipn,$conn,1);
        
    if($dataPostBack[1]==1){
	
	return true;
	//cool
	
    }
    else{
	return false;
	    $subject = "IPN: FAILED TO LOG IPN DATA (3) - txn id: ".$array_of_data['txn_id']." ";
	    $content = "payment status: $payer_status  \n\n"
		."IP ADDRESS: ".$_SERVER['REMOTE_ADDR']."\n\n"
		."paypal transaction id: $txn_id ";
		  
	    $email = PP_LOGS_EMAIL;
	//echo 'error##: FAILED TO LOGIN TO DB ';
	     Admin::sendEmail($subject,$content,$email);
    }
}



 function getinvoice($invoice){
    global $conn;
    
    $sql_invoice = "SELECT * FROM payments WHERE pid='$invoice'";
    $dataPostBack =  dbase::globalQuery($sql_invoice,$conn,2);
    if($dataPostBack[1]==1){
	
	return array('Ack'=>true,"data"=>$dataPostBack[0]);
	
    }
    else{
	return false;
    }
}

?>

