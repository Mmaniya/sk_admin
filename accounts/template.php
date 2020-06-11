<?php 
    include "includes.php";
  
	
	if(SessionRead('CLIENT_ID')=='' || SessionRead('CLIENT_ID')==0) header('location:index.php');
	
	$file = basename($_SERVER['SCRIPT_NAME'], ".php"); 
    switch($file) {
	  case "dashboard": 	$dbActive="active"; break;
	  case "myorders":      $myordersActive ="active"; break;
		
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>BizPlanEasy : Account Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google" content="notranslate">
        <meta name="application-name" content="BizPlanEasy">
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
        <!-- Font Awesome CSS - CDN -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">
         <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet">   
        <link href="css/responsive.css" rel="stylesheet">




        
        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/default.js"></script>   
        <script type="text/javascript" src="js/jquery.inputmask.bundle.js"></script>
    
<!--        <script src="js/jquery-migrate-1.4.1.min.js"></script>
        <link type="text/css" href="css/jquery-ui-1.7.2.custom.min.css" rel="stylesheet" />
        <script src="js/jquery-ui-1.7.2.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
	    <script type="text/javascript" src="js/autoresize.jquery.min.js"></script>        
-->        
        
        <script type="text/javascript">
            
            function popup( lnk , height, width)
            {        
                var x = screen.availWidth/2 - 250;
                var y = 80;		
                hWnd = window.open(lnk.href,"popup","width=" + width + ",height=" + height +", left=" + x + ", top=" + y + ", resizable=yes,scrollbars=yes")
                return false;
            }

            // equal to php function html_error_msg()
            function html_error_msg(e, error_msg)
            {	
                return e.html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="margin-right:1em"></i>'+error_msg+'</div>' );
            }

            function html_error_field(field, errorMsg) {
                html_error_fields_reset();
                // add error message to needed field
                var bsError=$(field), $group=bsError.closest('.form-group');
                $('.form-control', $group).addClass('is-invalid');
                $('div', $group).append('<div class="invalid-feedback">'+errorMsg+'</div>');
                field.focus();
            }
            function html_error_fields_reset() {
                // remove old error messages
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            }

            // equal to php function html_highlight()
            function html_highlight( e, msg )
            {
                return e.html('<div class="alert alert-info"><i class="fa fa-info-circle" aria-hidden="true" style="margin-right:1em"></i>'+msg+'</div><br />');
            }



            $(function() {
                var $body=$('body');
                $('[data-toggle=offcanvas]').click(function() {
                   
                    var status;
                    if ($body.find('.sidebar-module .label:visible').length) {
                        $body.addClass('sidebarInactive').removeClass('sidebarActive');
                        $('#sidebar .label').attr('style', 'display: none !important');
                        status = 0;
                    } else {
                        $body.addClass('sidebarActive').removeClass('sidebarInactive');
                        $('#sidebar .label').attr('style', 'display: table-cell !important');
                        status = 1;
                    }
                    $.ajax({
                        type: "POST",
                        url: '?action=sidebarStatus',
                        data: {'status': status}
                    });
                    return false;
                });
                $('.sidebar-module a').click(function() {
                    if ($body.find('.sidebar-module .label:visible').length==0) {
                        $body.addClass('sidebarActive').removeClass('sidebarInactive');
                        $('#sidebar .label').attr('style', 'display: table-cell !important');
                        return false;
                    }
                });
            });
			
			
	</script>
    </head>
    <body class="">
   <nav class="navbar navbar-expand-lg navbar-light bg-white">
	<a class="navbar-brand" href="dashboard.php"><img src="images/bpe_logo.png" height="36" /></a>

	<button type="button" class="profile navbar-toggler" data-toggle="collapse" data-target="#subMenu" aria-controls="#subMenu" aria-expanded="false" aria-label="Toggle navigation">
		<table cellPadding="0" cellSpacing="0">
		<td><table class="ico"><td><i class="fa fa-user" aria-hidden="true"></i></td></table></td>
		<td class="caret"><i class="fa fa-caret-down" aria-hidden="true"></i></td>
		</table>
	</button>

	<div class="collapse navbar-collapse justify-content-end" id="subMenu">

		<div class="d-none d-lg-block" style="width:100%">
			My BPE Dashboard		</div>

		<table class="d-block d-lg-none mnc-menu">
		<tr class="divider">
			<td><a href="accountprofile.php"><i class="fa fa-user" aria-hidden="true"></i></a></td>
			<td><a href="accountprofile.php">My Profile</a></td></tr>
		<!--<tr class="">
			<td><a href="bill_payment.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></td>
			<td><a href="bill_payment.php">Pay Your Bill</a></td></tr>
		<tr class="divider">
			<td><a href="update_payment.php"><i class="fa fa-credit-card" aria-hidden="true"></i></a></td>
			<td><a href="update_payment.php">Update Payment Method</a></td></tr>
				<tr class="divider">
			<td><a href="referral.php"><i class="fa fa-users" aria-hidden="true"></i></a></td>
			<td><a href="referral.php">Referral Program</a></td></tr>-->
		<tr><td><a href="../help/" target="_blank"><i class="fa fa-life-ring" aria-hidden="true"></i></a></td>
			<td><a href="../help/" target="_blank">Help</a></td></tr>
		<tr><td><a href="signout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a></td>
			<td><a href="signout.php">Logout</a></td></tr>
		</table>

		<ul class="list-unstyled d-none d-lg-block pl-4">
			<li class="nav-item dropdown">
				<a href="#" class="profile" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					<table cellPadding="0" cellSpacing="0">
					<td class="label" align="right" nowrap><strong><?php echo $_SESSION['CLIENT_BIZ'].' ( '. $_SESSION['CLIENT_NAME'].' )';?></strong><br /><small><?php echo $_SESSION['CLIENT_EMAIL']?></small></td>
					<td><table class="ico"><td><i class="fa fa-user" aria-hidden="true"></i></td></table></td>
					<td class="caret"><i class="fa fa-caret-down" aria-hidden="true"></i></td>
					</table>
				</a>
				<div class="dropdown-menu border-azure mnc-menu">
				<table>
			<!--	<tr class="divider">
					<td><a href="accountprofile.php"><i class="fa fa-user" aria-hidden="true"></i></a></td>
					<td><a href="accountprofile.php">My Profile</a></td></tr>
				<tr class="divider">
					<td><a href="bill_paymentbill_payment.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></td>
					<td><a href="bill_payment.php">Pay Your Bill</a></td></tr>
                    <tr class="divider">
					<td><a href="update_payment.php"><i class="fa fa-credit-card" aria-hidden="true"></i></a></td>
					<td><a href="update_payment.php">Update Payment Method</a></td></tr>
								<tr class="divider">
					<td><a href="referral.php"><i class="fa fa-users" aria-hidden="true"></i></a></td>
					<td><a href="referral.php">Referral Program</a></td></tr>-->
				<tr><td><a href="../help/"><i class="fa fa-life-ring" aria-hidden="true"></i></a></td>
					<td><a href="../help/">Help</a></td></tr>
				<tr><td><a href="signout.php"><i class="fa fa-sign-out-alt" aria-hidden="true"></i></a></td>
					<td><a href="signout.php">Logout</a></td></tr>
				</table>
				</div>
			</li>
        </ul>

	</div>
</nav>
   <a href="#" class="expander" data-toggle="offcanvas"><img src="images/ico-bars.png" border="0" /></a>
   <table width="100%" class="container-fluid" style="padding:0">
       <tr>
<td id="sidebar" valign="top">
<table class="sidebar-module mnc-menu" style="position:sticky !important; top:0px;">
<tr class="<?php echo $dbActive;?>">
	<td class="ico"><a href="dashboard.php" title="Dashboard"><i class="fa fa-tachometer-alt" aria-hidden="true"></i></a></td>
	<td class="label d-none d-xl-table-cell"><a href="dashboard.php" title="Dashboard">Dashboard</a></td>
</tr>
<!--<tr class="">
	<td class="ico"><a href="tasks.php" title="My Tasks"><i class="fa fa-check-square" aria-hidden="true"></i></a></td>
	<td class="label d-none d-xl-table-cell"><a href="tasks.php" title="My Tasks">My Tasks</a></td>
</tr>
<tr class="">
	<td class="ico"><a href="mybpe.php" title="My Business Plan"><i class="fab fa-wpforms" aria-hidden="true"></i></a></td>
	<td class="label d-none d-xl-table-cell"><a href="myorders.php" title="My Business Plan">My Business Plan</a></td>
</tr>-->
<tr class="<?php echo $myordersActive;?>">
	<td class="ico"><a href="myorders.php" title="My Documents"><i class="fas fa-handshake" aria-hidden="true"></i></a></td>
	<td class="label d-none d-xl-table-cell"><a href="myorders.php" title="My Orders">My Order</a></td>
</tr>
<!--<tr class="">
	<td class="ico"><a class="hvr-fade" href="bills.php"><i class="fas fa-receipt" aria-hidden="true"></i></a></td>
	<td class="label d-none d-xl-table-cell"><a class="hvr-fade" href="bills.php">Billing & Invoices</a></td>
</tr>-->

<tr class="">
	<td class="ico"><a href="accountprofile.php" title="Account Profile"><i class="fa fa-user" aria-hidden="true"></i></a></td>
	<td class="label d-none d-xl-table-cell"><a href="accountprofile.php" title="Dashboard">My Profile</a></td>
</tr>
<!--
<tr class="">
	<td class="ico"><a href="questionnaire.php" title="Questionnaire Wizard"><i class="fa fa-list-ol" aria-hidden="true"></i></a></td>
	<td class="label d-none d-xl-table-cell"><a href="questionnaire.php" title="Questionnaire Wizard">Questionnaire Wizard</a></td>
</tr>-->

<!--<tr>
	<td class="ico"><a class="hvr-fade" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-user" aria-hidden="true"></i></a></td>
	<td class="label d-none d-xl-table-cell"><a class="hvr-fade" data-toggle="modal" data-target="#exampleModal">Refer a Friend</a></td>
</tr>-->
<tr class="">
	<td class="ico"><a href="signout.php" title="Account Logout"><i class="fa fa-sign-out-alt" aria-hidden="true"></i></a></td>
	<td class="label d-none d-xl-table-cell"><a href="signout.php" title="Logout">Logout</a></td>
</tr>
</table>   


</td>
<td id="contentbar" valign="top" class="content">
			<?php  main(); ?>
       </td>   </tr>    
</table>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
		<form action="dashboard.php" method="post">
		<input type="hidden" name="action" value="referal" />
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Our Referral Program is Simple</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	            </button>
			</div>
			<div class="modal-body">
                        
                <table cellPadding="0" cellSpacing="0" class="text-primary ">
                <tr><td><b>Your Referral Code</b>:</td><td width="30" align="center"></td></tr><tr><td><?=$_SESSION['CLIENT_ID']?></td></tr>
                <tr><td><b>Your Referral Link</b>:</td><td width="30" align="center"></td></tr><tr><td>https://www.bizplaneasy.com/?ref=<?=$_SESSION['CLIENT_ID']?></td></tr>
                </table>
            
                <div class="text-justify pt-3">Give anyone your Referral Code (or your Referral Link) and we'll pay you for every paid and completed order submitted with that code. Optionally, we can provide your Referrals with a discount. Contact us to let us know.<br /><br />
	            We will pay you on the 1st of each month for all completed (shipped) orders in the previous month. By default we pay by check and mail it to the address shown in My Profile (US only). If you want to be paid by PayPal enter your address below. Note: International addresses must utilize PayPal.<br /><br /></div>
	            <div class="form-group">
					<label for="exampleInputName1"><strong>Your Paypal Account:</strong></label>
					<input type="email" name="paypal" class="form-control" id="paypal_account" autofocus required />
	            </div>
	            Payout: $10 per business plan.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	            <button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
		</form>
   </div>
</div>


   
    </body>
    <script>
	 var $body=$('body');
	$body.addClass('sidebarInactive').removeClass('sidebarActive');
                        $('#sidebar .label').attr('style', 'display: none !important');
	</script>

</html>