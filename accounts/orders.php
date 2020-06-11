<?php

	$clientId = $_SESSION['CLIENT_ID'];
	$invoiceId = $_POST['order_id'];
	$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$invoiceId.'-INT'),'showSql'=>'N');
	$rsInvoice = Table::getData($param);
	
	if($_SESSION['CLIENT_SPECIALIST']>0) {
		$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$_SESSION['CLIENT_SPECIALIST'].'-INT'),'showSql'=>'N');
		$rsSpecialist = Table::getData($param);
		$specialistName=$rsSpecialist->contact_fname.' '.$rsSpecialist->contact_lname;
		$specialistEmail=$rsSpecialist->business_email;
	}


 ?>

<h1 class="heading">Orders</h1>

<div class="row">
  <div class="col-md-8">
    <div class="card h-100">
        <h5 class="card-header warning-text text-left">Order Id : BPE<?=$invoiceId?> </h5>
           <div class="card-body">
              <div class="table-responsive-md">
                <table class="table table-hover">
                <thead class="bg-primary text-white">
                <tr><th scope="col">#</th><th scope="col">Invoice #</th><th scope="col">Action</th></tr> </thead>
                <tbody>
                <tr>
                <th scope="row">2</th>
                <td>Subject of the Support Ticket Comes here</td>
                <td><i class="fas fa-reply"></i></td>
                </tr>
                
                <tr><td colspan="3" class="text-right"><a href="tickets.php" class="btn btn-danger">Open Ticket</a></td>
                </tbody>
                </table>
            </div>
         </div>
      </div>
   </div>
</div>   