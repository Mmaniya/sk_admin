<?php
 require("includes.php");

 if($_POST['act']=='payQuotation') {
	ob_clean();

	$quotationId = $_POST['id'];
	$param = array('tableName'=>TBL_QUOTATION,'fields'=>array('*'),'condition'=>array('id'=>$quotationId.'-INT'));
	$rsQuotation = Table::getData($param);

	foreach($rsQuotation as $K=>$V)  $$K=$V;

	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$lead_id.'-INT'));
	$rsLeads = Table::getData($param);




	?>   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">

	   <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-body" style="padding:0px;">
			<div class="body-div" style="padding:15px;">

				<div class="form-group row" style="background-color: #039cfd;color: #fff;margin:0px;">
				<label class="col-md-6 col-form-label">Payment for Quotation of <?php echo $rsLeads->lead_fname.' '.$rsLeads->lead_lname; ?> </label>
				<label class="col-md-6 col-form-label">#Quotation ID : <?php echo customizeSerial($id);?> </label>
				</div>
				<form method="post">
                <?php
				if($is_fully_paid=='Y' ) {

				?>
                <div class="alert alert-danger" role="alert">

                 <i class="fas fa-exclamation-triangle text-danger"></i> <?php echo $sentByName; ?> has already sent the quotation for this client. If you like to resend the quotation, fill in the following field with the email address(es)



                </div>



                <?php
				}
				?>
					<div class="row">
						<div class="col-md-12">
							 <div class="form-group row"> <br/>
						   <label class="col-md-12 col-form-label">Email:  (Enter multiple email address separated by , )</label>
							<div class="col-md-7">
								<input type="email" class="form-control" name="email_address" id="email_address" value="<?php echo $rsLeads->lead_email; ?>" style="width:100%">  <br/>
								<input type="hidden" name="id" id="quotation_id" value="<?php echo $id; ?>">
								<a href="javascript:void(0)" id="submitBtn" class="btn btn-primary" type="button" onclick="send_email_quotation()">Send</a>
							</div>
						   </div>

						</div>
					</div>
					</form>
				 </div>
			</div>
			<div class="modal-footer">
				<button type="button"  class="close btn btn-primary waves-effect" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
	</div><!-- /.modal -->

	 <tr>
  <td style="background:#fff;" colspan="2">
  <table width="100%">
 <tr><td style="padding:10px; padding-left:0px;"><?php echo 'To:<br/>&nbsp;'.$rsLeads->lead_fname.' '.$rsLeads->lead_lname.' <br/>'.$rsLeads->lead_phone.'<br/>'.$rsLeads->lead_email;?>  </td>
 <td style="padding:10px; padding-left:0px;">&nbsp;</td>
 </tr>

 <script>

	 $("#myModalLabel .close").click(function(){$("#myModalLabel").hide();});

	 function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }

	function send_email_quotation() {
		 err=0;

	  var quotation_id =  $('#quotation_id').val();
	  var email_address =  $('#email_address').val();
	 // if(IsEmail(email_address)==false){ err=1; $('#email_address').css("border","1px solid #ff0000 "); } else { err=0; $('#email_address').css("border","");}


	if(err==0) {
	paramData = {'act':'send_quotation','id':quotation_id,'email_address':email_address};

    $('#submitBtn').prop('disabled', true);
    $('#submitBtn').html('Sending.....');

	ajax({
		a:'quotation_send_email',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		alert(data);
            $('.preview_div').html(data);
         $('#con-close-modal').modal('hide');
         $('#submitBtn').prop('disabled', true);
		}});
	}
}

</script>



   <?php  exit();
   }



   if($_POST['act']=='sendQuotation') {
	ob_clean();

	$quotationId = $_POST['id'];
	$param = array('tableName'=>TBL_QUOTATION,'fields'=>array('*'),'condition'=>array('id'=>$quotationId.'-INT'));
	$rsQuotation = Table::getData($param);

	foreach($rsQuotation as $K=>$V)  $$K=$V;

	$param = array('tableName'=>TBL_LEADS,'fields'=>array('*'),'condition'=>array('id'=>$lead_id.'-INT'));
	$rsLeads = Table::getData($param);




	?>   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">

	   <div id="send-quotation-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-body" style="padding:0px;">
			<div class="body-div" style="padding:15px;">

				<div class="form-group row" style="background-color: #039cfd;color: #fff;margin:0px;">
				<label class="col-md-6 col-form-label">Quotation for : <?php echo $rsLeads->lead_fname.' '.$rsLeads->lead_lname; ?> </label>
				<label class="col-md-6 col-form-label">#Quotation ID : <?php echo customizeSerial($id);?> </label>
				</div>
				<form method="post">
                <?php
				if($email_sent=='Y' ) {
					if($sent_by==$_SESSION['user_id']) $sentByName = 'You ';
					else {
					$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$sent_by.'-INT'));
					$rsUsers = Table::getData($param);
					$sentByName= $rsUsers->contact_fname.' '.$rsUsers->contact_lname;
					}
				?>
                <div class="alert alert-danger" role="alert">

                 <i class="fas fa-exclamation-triangle text-danger"></i> <?php echo $sentByName; ?> has already sent the quotation for this client. If you like to resend the quotation, fill in the following field with the email address(es)



                </div>



                <?php
				}
				?>
					<div class="row">
						<div class="col-md-12">
							 <div class="form-group row"> <br/>
						   <label class="col-md-12 col-form-label">Email:  (Enter multiple email address separated by , )</label>
							<div class="col-md-7">
								<input type="email" class="form-control" name="email_address" id="email_address" value="<?php echo $rsLeads->lead_email; ?>" style="width:100%">  <br/>
								<input type="hidden" name="id" id="quotation_id" value="<?php echo $id; ?>">
								<a href="javascript:void(0)" id="submitBtn" class="btn btn-primary" type="button" onclick="send_email_quotation()">Send</a>
							</div>
						   </div>

						</div>
					</div>
					</form>
				 </div>
			</div>
			<div class="modal-footer">
				<button type="button"  class="close btn btn-primary waves-effect" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
	</div><!-- /.modal -->

	 <tr>
  <td style="background:#fff;" colspan="2">
  <table width="100%">
 <tr><td style="padding:10px; padding-left:0px;"><?php echo 'To:<br/>&nbsp;'.$rsLeads->lead_fname.' '.$rsLeads->lead_lname.' <br/>'.$rsLeads->lead_phone.'<br/>'.$rsLeads->lead_email;?>  </td>
 <td style="padding:10px; padding-left:0px;">&nbsp;</td>
 </tr>

 <script>

	 $("#myModalLabel .close").click(function(){$("#myModalLabel").hide();});

	 function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }

	function send_email_quotation() {
		 err=0;

	  var quotation_id =  $('#quotation_id').val();
	  var email_address =  $('#email_address').val();
	 // if(IsEmail(email_address)==false){ err=1; $('#email_address').css("border","1px solid #ff0000 "); } else { err=0; $('#email_address').css("border","");}


	if(err==0) {
	paramData = {'act':'send_quotation','id':quotation_id,'email_address':email_address};

    $('#submitBtn').prop('disabled', true);
    $('#submitBtn').html('Sending.....');

	ajax({
		a:'quotation_send_email',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		alert(data);
            $('.preview_div').html(data);
         $('#con-close-modal').modal('hide');
         $('#submitBtn').prop('disabled', true);
		}});
	}
}

</script>



   <?php  exit();
   }

 ?>
 <?php  //echo($final_array); ?>  
 
  