<?php
  include "includes.php";

if($_POST['act']=='submit_qs') {

  $invoice_line_item_id = $_POST['invoice_line_item_id'];
  $qry = "SELECT invoice_id from `".TBL_INVOICE_LINE_ITEM."` where id = ".$invoice_line_item_id;
  $invoice_id =  dB::sExecuteSql($qry)->invoice_id;		
  
  $documentsArr = $_POST['document'];

//  echo '<pre>';
 // print_r($_POST);
 
  
  $totalInput=0;
    $totalParams = array();
	
  foreach($documentsArr as $K=>$V) {
	 
	 foreach($V as $K1=>$V1) 
	 {
		if($K1!='type') {
			$param['invoice_line_item_id']= $invoice_line_item_id;
			$param['document_id']= $K;
			$param['invoice_id']=$invoice_id;
			$param['document_type']= $V['type']; 
			$param['document_name']= $K1;
			$param['document_text']= $V1;
			$totalParams[]=$param;
			if($V1!='') $totalInput++;
			$param=array();
		}
	 }
  }
  


 if(isset($_FILES)) {
	  $uploadedFiles = $_FILES['files']['name'];
	  foreach($uploadedFiles as $K1=>$V1) {

		 foreach($V1 as $K2=>$V2) {
		  if($V2!='') {
			  
			    $fileExpType=end((explode(".", $V2)));
				  
				$param['invoice_line_item_id']= $invoice_line_item_id;
				$param['document_id']=$document_id = $K1;
				$param['invoice_id']=$invoice_id;
				$param['document_name']= $K2;
				$param['document_type']= 'file'; 
				$imagePath="../questionnaire_documents/".$invoice_line_item_id.'_'.$document_id.'_'.$invoice_id.'.'.$fileExpType;
				$param['document_text']=QUEST_DOCS.$invoice_line_item_id.'_'.$document_id.'_'.$invoice_id.'.'.$fileExpType;
				move_uploaded_file($_FILES["files"]["tmp_name"][$K1][$K2],$imagePath);
				$totalParams[]=$param;
				$param=array();
			  }
		  }
	   }
  }
  
 // print_r($totalParams);
 //echo '</pre>';
foreach($totalParams as $K=>$V) {
	
  $qry = "SELECT id from `".TBL_QUESTIONNAIRE_DTLS."` where invoice_line_item_id = ".$V['invoice_line_item_id']." and document_id=".$V['document_id'];
  $docDtl =  dB::sExecuteSql($qry)->id;		
  if($V['document_text']!='')  $filledDtls[] = "<li>".ucwords(str_replace('_',' ',$V['document_name']))."</li>";
  if($docDtl==0)
	{
		$param['invoice_line_item_id']= $V['invoice_line_item_id'];
		$param['document_id']=$V['document_id'];
		$param['invoice_id']=$V['invoice_id'];
		$param['document_type']= $V['document_type'];
		$param['document_name']= ucwords(str_replace('_',' ',$V['document_name']));
		$param['document_text']= $V['document_text'];
		$param['added_date'] = date('Y-m-d H:i:s',time());		
		$param['added_by']= $_SESSION['CLIENT_ID'];  
		$rsDtls = Table::insertData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'showSql'=>'N')); 	
	} else {
		
		$param['document_type']= $V['document_type'];
		$param['document_name']=ucwords(str_replace('_',' ',$V['document_name']));
		$param['document_text']= $V['document_text'];
		$param['updated_by']= $_SESSION['CLIENT_ID'];  
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$where= array('id'=>$docDtl);
		Table::updateData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));		
	}
	

}


if($filledQuestions>0) {
	
	$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$invoice_line_item_id.'-INT'));
	$rsInvLineItem = Table::getData($param);		
	$prevStatus = $rsInvLineItem->line_item_status;
	 
	$param=array();
	$param['line_item_status'] = 'FQ'; 
	$param['status_set_by'] =  $_SESSION['user_id'];  
	$param['updated_date'] = date('Y-m-d H:i:s',time());		
	$param['updated_by']= $_SESSION['user_id'];  
	$where= array('id'=>$invoice_line_item_id);
	Table::updateData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
	 
	
	
	
	$param=array();	
	$param['line_item_id']= $invoice_line_item_id;
	$param['previous_status']= $prevStatus;
	$param['new_status']=  'FQ'; 
	$param['status_set_by']=  $_SESSION['user_id']; 
	$param['status_set_date']= date('Y-m-d H:i:s',time());	
	$param['status_reason']='';
	
	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['user_id'];  
	$rsDtls = Table::insertData(array('tableName'=>TBL_INVOICE_LINE_ITEM_STATUS,'fields'=>$param,'showSql'=>'N')); 
	$param=array();
	
}

$invoiceObj = new Invoice();
$invoiceObj->invoice_line_item_id = $invoice_line_item_id;
$invoiceObj->invoice_id = $invoice_id;
$emailHtml = $invoiceObj->questionnaireAlertEmail();	


	    //use PHPMailer\PHPMailer\PHPMailer;
		//use PHPMailer\PHPMailer\Exception;
		require_once 'PHPMailer/src/Exception.php';
		require_once 'PHPMailer/src/PHPMailer.php';
		require_once 'PHPMailer/src/SMTP.php';
		
		echo $emailSubject = "[BPE Alert] Questionnare Submitted for Order Id: ".$invoice_id." : ".$rsClient->client_fname.' '.$rsClient->client_lname; 
		
		$mail = new PHPMailer();   
			
		try {
			//Server settings
			$mail->SMTPDebug = 2;                                       // Enable verbose debug output
			$mail->isSMTP();                                            // Set mailer to use SMTP
			$mail->Host       = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			$mail->Username   = 'AKIAV6VOGF6A2SW4EACC';                     // SMTP username
			$mail->Password   = 'BPq9hAB7wThsvuZpsGWrITKeAwk8C96Iep5T5AhWkqbK';                               // SMTP password
			$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port       = 587;                                    // TCP port to connect to
		
			//Recipients
			$mail->setFrom('support@bizplaneasy.com', 'BizPlanEasy Support');
			$mail->addReplyTo('support@bizplaneasy.com', 'BizPlanEasy Support');
			
		
			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			//$mail->AddAddress('support@mastermindsolutionsonline.com');
		
			$mail->AddAddress('support@bizplaneasy.com');
			$mail->AddBCC('kavitharjn@gmail.com');

			$mail->Subject =  $emailSubject;                
			$mail->Body = $emailHtml;
		$mail->send();

			
		   
		} catch (Exception $e) {
				ob_clean();
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				exit();
		}	
		


$totalServices = $_POST['totalServices'];
 $filledQuestions =   $totalInput;
ob_clean();
?>
<div class="card-body bg-white" style="padding:10px;">

<h5 class="text-primary"> Thank you for filling in your questionnaire. <br/> </h5>
<?php if($totalServices!=$filledQuestions) { ?>
   <p> We see that you have left out few documents/details in the questionnaire. The following are the details filled in by you until now. <strong>You can always return this form to fill in the left out documents/details at any point of time.</strong></p>
   <ul class="ml-5 pl-5" style="font-size:22px">
   <?php echo implode(' ',$filledDtls); ?>
   </ul><br/>

<?php } ?>

<h5>Your questionnaire has been submitted succesfully. You will be contacted by your assigned BPE Specialist for any other clarifications. </h5> 


<a href="myorders.php?invi=<?php echo  $invoice_id;?>" class="btn btn-lg btn-primary"> View Order </a> </div>

</div>
<?php


exit();
}




?>