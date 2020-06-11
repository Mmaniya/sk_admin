<?php

include "includes.php";

  
   $baseName =$_SERVER['HTTP_REFERER'];
   $referer = parse_url($_SERVER['HTTP_REFERER']);
   
   /*if(!strstr(BASE_URL,$referer['host']))
   {       
     header("location:index.php");
     exit();
   }*/
  
  $file =basename(parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH),".php"); 
  
  if($_REQUEST['pq']==1 & $file=='invoices') { 

    $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'showSql'=>'Y','condition'=>array('id'=>$_REQUEST['ili'].'-INT'));
	$rsInvLineItem = Table::getData($param);	 

    $param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'showSql'=>'Y','condition'=>array('id'=>$rsInvLineItem->invoice_id.'-INT'));
	$rsInvoice = Table::getData($param);	 
	$invoiceId = $rsInvoice->id;
  
    $param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$rsInvoice->client_id.'-INT'));
	$rsClient = Table::getData($param);  
 
	SessionWrite('CLIENT_ID',$rsClient->id);
	SessionWrite('CLIENT_NAME',$rsClient->client_fname.' '.$rsClient->client_lname);
	SessionWrite('CLIENT_EMAIL',$rsClient->client_email);
	SessionWrite('CLIENT_SPECIALIST',$rsClient->client_followed_by);
    header('location:questionnaire.php?ili='.$_REQUEST['ili']); exit();
  }  
 
  
 if($_REQUEST['ap']==1 && ($file=='invoices' || $file=='dashboard' || $file=='e_dashboard')) { 
 
	$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'shoqSql'=>'Y','condition'=>array('id'=>$_REQUEST['clid'].'-INT'));
	$rsClient = Table::getData($param);  
 
	SessionWrite('CLIENT_ID',$rsClient->id);
	SessionWrite('CLIENT_NAME',$rsClient->client_fname.' '.$rsClient->client_lname);
	SessionWrite('CLIENT_EMAIL',$rsClient->client_email);
	SessionWrite('CLIENT_SPECIALIST',$rsClient->client_followed_by);
  
 }
 if($_REQUEST['cl']==1 && $file=='invoiceStatus')
 {
  $param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'shoqSql'=>'Y','condition'=>array('id'=>$_REQUEST['clid'].'-INT'));
	$rsClient = Table::getData($param);  
 
	SessionWrite('CLIENT_ID',$rsClient->id);
	SessionWrite('CLIENT_NAME',$rsClient->client_fname.' '.$rsClient->client_lname);
	SessionWrite('CLIENT_EMAIL',$rsClient->client_email);
  SessionWrite('CLIENT_SPECIALIST',$rsClient->client_followed_by);
 }

 parse_str($_SERVER['QUERY_STRING'], $queries);
 
 foreach($queries as $QK => $QV)
 {
   $qryStr.=$QK."=".$QV."&";
 }
 $qryStr=substr($qryStr,0,-1);
 
if(SessionRead('CLIENT_ID')!='' && SessionRead('CLIENT_ID')>0) header('location:myorders.php?'.$qryStr); 

if($_REQUEST['txid']!='') {
	$txnid = $_REQUEST['txid'];
	$txnid=substr($txnid,0,strlen($txnid)-1);
	$clientObj = new Clients();
	$clientObj->transaction_id = $txnid;
	$clientCredentials = $clientObj->autoLogin();
	$clientEmail = $clientCredentials->client_email;
	$clientPass = $clientCredentials->client_pass;
}

$errorMesage='';
if($_POST['act']=='login') {
  $postVar = array('login_option','email','phone','password');  
  foreach($postVar as $K=>$V) $params[$V]=check_input($_POST[$V]);
  $returnArr = Clients::checkLoginCredentials($params);
  if(count($returnArr)>1) {
	 $rsUser = $returnArr[1];
	 SessionWrite('CLIENT_ID',$rsUser->id);
	 SessionWrite('CLIENT_NAME',$rsUser->client_fname.' '.$rsUser->client_lname);
	 SessionWrite('CLIENT_EMAIL',$rsUser->client_email);
	 SessionWrite('CLIENT_SPECIALIST',$rsUser->client_followed_by);
       
     header('location:myorders.php');
	 }
	 $errorMesage = $returnArr[0];
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>BizPlanEasy : Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google" content="notranslate">
<meta name="application-name" content="BizPlanEasy">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
<!-- Font Awesome CSS - CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.css">
<link href="css/style.css" rel="stylesheet">       
</head>
<body>
    <div class="row row-eq-height login">
        <div class="left col-lg-5 col-xl-4">
         <table>
	      <tr class="header" align="center">
		  <td class="pl-5 pr-5"><a href="https://www.bizplaneasy.com/"><img src="images/bpe_logo.png" height="40" border="0" /></a></td>
	      </tr>
	      <tr class="content">
		   <td class="p-5" valign="top">
            <p>Please enter your account <strong>email address or phone number</strong> and password below to login.</p>
            <br />
               <?php
               if($errorMesage!=''){
                ?>   
                
               <div class="alert alert-danger text-justify">
                   <strong> <?php echo $errorMesage; ?> </strong>
               </div>
               <?php   
                 }
               ?>
            <form name="login" method="post">
                <input type="hidden" name="act" value="login" />
                <div class="form-group">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-primary btn-default active">
                    <input type="radio" name="login_option" id="option1" autocomplete="off" value="email" checked> Email Address
                  </label>
                  <label class="btn btn-primary btn-default">
                    <input type="radio" name="login_option" id="option2" value="phone" autocomplete="off" > Phone Number
                  </label>
                </div>
               </div>
                <div class="form-group" id="email_address_input">
                    <label for="email">Email Address:</label>
                    <input name="email"  pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" id="email" type="text" class="form-control form-control-lg" value="<?=$clientEmail?>"  required/>
                    
                </div>
                <div class="form-group" id="phone_input" style="display:none">
                    <label for="phone">Phone Number:</label>
                    <input name="phone" id="phone" type="text" class="form-control form-control-lg phone-format" value="" />
                    
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input name ="password" id="password" type="password" class="form-control form-control-lg" value="<?=$clientPass?>" required/>
                </div>
                <br />
                <div class="form-group">
                    <button class="btn orange" type="submit"><i style="padding-right:5px" class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
                    <a class="btn btn-link" href="forgotpass.php">Forgot Password?</a>
                </div>
             </form>
              <script>document.getElementById('email').focus()</script>
            </td>
          </tr>
         </table>
        </div>  
    <div class="right col-lg-7 col-xl-8 pl-5 pr-5">
	<table border="0" width="100%" height="100%">
		<tr class="header">
			<td>
				<div>
					<div>My BizPlanEasy Dashboard<div style="float:right">
						<i class="fa fa-phone" aria-hidden="true"></i> 800.326.1362
						<i class="fa fa-envelope ml-4" aria-hidden="true"></i> <a href="support.php" class="white-font" >Email Us</a>
					</div></div>
					
				</div>
			</td>
		</tr>
		<tr>
			<td class="pt-0 pb-5 pt-md-5" valign="top">
				<p><b>Features of My Account</b></p>
				<ul class="simple checkmark">
				<li class="mt-4">Check the Status of your order(s)</li>
				<li class="mt-3">View/Print Your Invoice</li>
				<li class="mt-3">Download Your Business Plan(s)</li>
				<li class="mt-3">Pay Your Bill or Cancel/Update any Recurring Services</li>
				</ul>
			</td>
		</tr>
		</table>
    </div>
    </div>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script type="text/javascript" src="js/default.js"></script>    
    <script>
         $(".btn-group-toggle input:radio").on('change', function() { 
            var val = $(this).val();
            if (val == 'email') {
                $('#email_address_input').show();
                $('#phone_input').hide();
                $("#email").prop('required',true);
                $("#phone").prop('required',false);
                setTimeout(function() {  $('#email').focus(); }, 0)
            }
            if(val=='phone'){
                $('#phone_input').show();
                $('#email_address_input').hide();
                setTimeout(function() {  $('#phone').focus(); }, 0)
                $("#phone").prop('required',true);
                $("#email").prop('required',false);
            }
        })
    
    </script>    
</body>
</html>