<?php
  include "includes.php";
  
  echo ini_get('post_max_size')."-".ini_get('upload_max_filesize');
if($_POST['act']=='submit_qs') {

  $invoice_line_item_id = $_POST['invoice_line_item_id'];
  $qry = "SELECT invoice_id from `".TBL_INVOICE_LINE_ITEM."` where id = ".$invoice_line_item_id;
  $invoice_id =  dB::sExecuteSql($qry)->invoice_id;		
  
  $documentsArr = $_POST['document'];
//echo '<pre>';
 // print_r($_POST);
 // echo '</pre>';
 // exit();

  
  $totalInput=0;
    $totalParams = array();
	
  foreach($documentsArr as $K=>$V) {
	 foreach($V as $K1=>$V1) 
	 {
		if($K1!='type') {
			$param['invoice_line_item_id']= $invoice_line_item_id;
			$param['document_id']= $K;
			$param['invoice_id']=$invoice_id;
			if(is_array($V['type']))$param['document_type']= $V['type'][0]; 
			else $param['document_type']= $V['type']; 
			$param['document_name']= $K1;
			if(!is_array($V1) && $V1!='') {
				$value=1;
				$param['document_text']= $V1;
				$sql = "SELECT parent_id from `".TBL_DOCUMENTS."` where id = $K";
				$value=0;
				$parentId =  dB::sExecuteSql($sql)->parent_id;
				$param['parent_id']=$parentId;	
			}
			else
			{
				
			
				
			$newArray=array();
			$sql = "SELECT parent_id from `".TBL_DOCUMENTS."` where id = $K";
			$value=0;
			$parentId =  dB::sExecuteSql($sql)->parent_id;
			
			$param['parent_id']=$parentId;	
			foreach($V1 as $K2=>$V2) $newArray[]=$V2;	
			if(count($newArray)>0)	{		$param['document_text']= serialize($newArray); $value=1; }
			else $param=array();
			
			}
			if(count($param)>0)			$totalParams[]=$param;
			if($value==1) $totalInput++;
			$param=array();

				
				
			}
		}
	 }
  




 if(isset($_FILES)) {
	  $uploadedFiles = $_FILES['files']['name'];
	 	   	
	  foreach($uploadedFiles as $K1=>$V1) {
		 if ( (!(is_array($V1)) && $V1!='') || (is_array($V1) && (count($V1)>0)) ) {
					$qry = "SELECT document_text from `".TBL_QUESTIONNAIRE_DTLS."` where invoice_line_item_id = ".$invoice_line_item_id." and document_id=".$K1;
					$docTxt =  dB::sExecuteSql($qry)->document_text;
					if($docTxt!=''){					
					$docTxt=unserialize($docTxt);
					$newArray=$docTxt;
					}
					else				
						$newArray=array();
		 foreach($V1 as $K2=>$V2) {
			  if ( (!(is_array($V2)) && $V2!='') || (is_array($V2) && (count($V2)>0)) ) {
				$param['invoice_line_item_id']= $invoice_line_item_id;
				$param['document_id']=$document_id = $K1;
				$param['invoice_id']=$invoice_id;
				$param['document_name']= $K2;
				$param['document_type']= 'file'; 
			  
				$folderName =getQuestPath($invoice_id, $invoice_line_item_id);
				
				if(!is_array($V2)) {
				$fileExpType=end((explode(".", $V2)));	
				$fileName=str_replace(' ','_',strtolower($K2)).'.'.$fileExpType; 
				$imagePath= $folderName.$fileName;
				$param['document_text']=$fileName;
				move_uploaded_file($_FILES["files"]["tmp_name"][$K1][$K2],$imagePath);
				} else {
										
					
					
			$sql = "SELECT parent_id from `".TBL_DOCUMENTS."` where id = $K1";
			
			$parentId =  dB::sExecuteSql($sql)->parent_id;
			$cnt=0;
			$param['parent_id']=$parentId;	
			$currentIds=array();
			foreach($V2 as $K3=>$V3) {
			$currentIds[]=$K3;				
			if($V3!='') {
				$fileExpType=end((explode(".", $V3)));	
				$fileName=str_replace(' ','_',strtolower($K2))."_".$K3.'.'.$fileExpType; 
				
				
				$imagePath= $folderName.$fileName;
				
				//$param['document_text']=$fileName;
				try{
					
				move_uploaded_file($_FILES["files"]["tmp_name"][$K1][$K2][$K3],$imagePath);
				
				}
				catch(Exception $e){echo 'Message: ' .$e->getMessage();exit;}
				$newArray[$K3]=$fileName;	
			}
			}
			if(count($newArray)>0) {
								
				foreach($newArray as $nK => $nV)
				{
					if(!in_array($nK, $currentIds))
					unset($newArray[$nK]);							
						
				}				
				sort($newArray);				
				
				
			$param['document_text']= serialize($newArray);
			} else {
			$param=array();	
			}
					
				}
				if(count($param)>0)	$totalParams[]=$param;
				$param=array();
				
			  
				
			  }
		  }
		 }
	   }
  }
  //print_r($totalParams);
  //exit;
  
 /* echo '<pre>';
  print_r($totalParams);
  echo '</pre>';
  exit;*/
 
  

foreach($totalParams as $K=>$V) {
 
 if($V['document_text']!='a:1:{i:0;s:0:"";}')
 {	
  $qry = "SELECT id from `".TBL_QUESTIONNAIRE_DTLS."` where invoice_line_item_id = ".$V['invoice_line_item_id']." and document_id=".$V['document_id'];
  $docDtl =  dB::sExecuteSql($qry)->id;		
  if($V['document_text']!='')  $filledDtls[] = "<li>".ucwords(str_replace('_',' ',$V['document_name']))."</li>";
  $param=array();
  if(empty($docDtl))
	{
		$param['invoice_line_item_id']= $V['invoice_line_item_id'];
		$param['document_id']=$V['document_id'];
		$param['invoice_id']=$V['invoice_id'];
		$param['parent_id']=$V['parent_id'];
		$param['document_type']= $V['document_type'];
		$param['document_name']= ucwords(str_replace('_',' ',$V['document_name']));
		$param['document_text']= $V['document_text'];
		$param['added_date'] = date('Y-m-d H:i:s',time());		
		$param['added_by']= $_SESSION['user_id'];
		
		$rsDtls = Table::insertData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'showSql'=>'Y'));
		$invoiceObj = new Invoice();
		$invoiceObj->invoice_line_item_id=$V['invoice_line_item_id'];
		$invoiceObj->document_id=$V['document_id'];
		$invoiceObj->invoice_id=$V['invoice_id'];
		$similarLineItems=$invoiceObj->getSimilarLineItemsByDoc();
		
	//
		foreach($similarLineItems as $SK => $SV)
		{
			$qry = "SELECT id from `".TBL_QUESTIONNAIRE_DTLS."` where invoice_line_item_id = ".$SV." and document_id=".$V['document_id'];
			$docDtl2 =  dB::sExecuteSql($qry)->id;	
			
			if(empty($docDtl2))
			{
				if(isset($_FILES))
				foreach($uploadedFiles as $K1=>$V1) {
					if ( (!(is_array($V1)) && $V1!='') || (is_array($V1) && (count($V1)>0)) ) {
					foreach($V1 as $K2=>$V2) {
						 if ( (!(is_array($V2)) && $V2!='') || (is_array($V2) && (count($V2)>0)) ) {
							$folderName =getQuestPath($invoice_id, $SV);
							$originalfolderName =getQuestPath($invoice_id, $invoice_line_item_id);

							if(!is_array($V2)) {
							$fileExpType=end((explode(".", $V2)));	
							$fileName=str_replace(' ','_',strtolower($K2)).'.'.$fileExpType; 
							$imagePath= $folderName.$fileName;
							
							if(!copy($originalfolderName.$fileName,$imagePath))
							  echo "image error";
							} else {
								foreach($V2 as $K3=>$V3) { 
									if($V3!='') {
										$fileExpType=end((explode(".", $V3)));	
										$fileName=str_replace(' ','_',strtolower($K2))."_".$K3.'.'.$fileExpType; 
																				
										$imagePath= $folderName.$fileName;
										copy($originalfolderName.$fileName,$imagePath) or die();
									}
								}	
							}	
						 }
					 }	 
				  } 
				}  
				$param['invoice_line_item_id']=$SV;
			    $rsDtls = Table::insertData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'showSql'=>'N'));
			} 
			else{
				unset($param['added_date']);
				unset($param['added_by']);
				$where= array('id'=>$docDtl);
				$param['updated_by']= $_SESSION['user_id'];  
				$param['updated_date'] = date('Y-m-d H:i:s',time());	
				$param['invoice_line_item_id']=$SV;
				Table::updateData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'where'=>$where,'showSql'=>'Y'));
			} 			
			
		}

	} else {
		
		$param['document_type']= $V['document_type'];
		$param['invoice_line_item_id']= $V['invoice_line_item_id'];
		$param['document_id']=$V['document_id'];
		$param['invoice_id']=$V['invoice_id'];
		$param['parent_id']=$V['parent_id'];
		$param['document_name']=ucwords(str_replace('_',' ',$V['document_name']));
		$param['document_text']= $V['document_text'];
		$param['updated_by']= $_SESSION['user_id'];  
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$where= array('id'=>$docDtl);		
		Table::updateData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		
		$invoiceObj = new Invoice();
		$invoiceObj->invoice_line_item_id=$V['invoice_line_item_id'];
		$invoiceObj->document_id=$V['document_id'];
		$invoiceObj->invoice_id=$V['invoice_id'];
		$similarLineItems=$invoiceObj->getSimilarLineItemsByDoc();
		
		foreach($similarLineItems as $K1 => $V1)
		{	
			$param['invoice_line_item_id']=$V1;
			$sQry = "SELECT id from `".TBL_QUESTIONNAIRE_DTLS."` where invoice_line_item_id = ".$V1." and document_id=".$V['document_id'];
			
			$sDocDtl =  dB::sExecuteSql($sQry)->id;
			$where= array('id'=>$sDocDtl);
			Table::updateData(array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		}
//		echo '<br/>';
	}
	
  }
}

//exit;
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

if(!strstr(BASE_URL,'localhost'))
{
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


<!--<a href="myorders.php?invi=<?php echo  $invoice_id;?>" class="btn btn-lg btn-primary"> View Order </a> </div>-->

</div>
<?php


exit();
}




?>