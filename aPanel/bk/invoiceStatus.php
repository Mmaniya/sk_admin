<?php  
require("includes.php");
function main() { 


    $invoiceObj = new Invoice();
    if($_POST['act']=='show_log')
    {
        ob_clean();
        if($_POST['type']==TBL_INVOICE_LINE_ITEM)
        {
            $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$_POST['id'].'-INT'),'showSql'=>'N');
            $rsLineItem = Table::getData($param);

            $title="BE - ".$rsLineItem->invoice_id." - ".$rsLineItem->line_item;
        }
        else{
            $title="BE - ".$_POST['id'];
        }
        include("view_log.php");
        exit;
    }
    if($_POST['act']=='setDueDate')
    {
        ob_clean();
        $param=array();
		$param['estimated_delivery_date']=date('Y-m-d',strtotime($_POST['due_date']));
        $param['updated_date'] = date('Y-m-d H:i:s',time());
        $param['updated_by'] = $_SESSION['user_id']; 				
		$where= array('id'=>$_POST['invoice_line_item_id']);
        Table::updateData(array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
        exit;
    }
    if($_POST['act']=='delete_invoice')
    {
        ob_clean();

        $param=array();
		$param['is_deleted']='Y';
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['deleted_by']= $_SESSION['user_id'];  
		$where= array('id'=>$_POST['invoice_id']);
        Table::updateData(array('tableName'=>TBL_INVOICE,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
        
        exit;
    }
    if($_POST['act']=='submitInternalMessages') {
        ob_clean();
        
       $params = array('invoice_line_item_id','invoice_id','message');
       foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
                     
       $param['added_date'] = date('Y-m-d H:i:s',time());		
       $param['added_by']= $_SESSION['user_id'];  
       echo $rsDtls = Table::insertData(array('tableName'=>TBL_INTERNAL_MESSAGES,'fields'=>$param,'showSql'=>'N')); 
        
        exit();	
       }

    if($_POST['act']=='showInternalMessages')
    {
    
            ob_clean();
             
            $invoiceLineItemId = $_POST['invoice_line_item_id'];           
            $invoice_id = $_POST['invoice_id']; 
            $isDashboard=$_POST['dashboard'];
                       
            $param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$invoiceLineItemId.'-INT'),'showSql'=>'N');
            $rsLineItem = Table::getData($param);
             
            ?>
            <div class="card">
              <h5 class="card-header bg-primary text-white">BE - <?php echo $invoice_id; ?> - <?php echo $rsLineItem->line_item; ?></h5>
              
            <ul class="comments-list">
            <?php
             $qry = "SELECT * from `".TBL_INTERNAL_MESSAGES."` where  invoice_id = ".$invoice_id." and invoice_line_item_id = ".$invoiceLineItemId;
             $rsMessages =  dB::mExecuteSql($qry);		
             $messageCnt=count($rsMessages);
                if(count($rsMessages)>0) {
                    $cCnt=0;
                  foreach($rsMessages as $key=>$val) { $postedName='';
                    $cCnt++;
                     
                    $qry = "SELECT * from `".TBL_USERS."` where id = ".$val->added_by."";
                    $rsUsers =  dB::sExecuteSql($qry);	
                    $postedName = $rsUsers->contact_fname.' '.$rsUsers->contact_lname;
                       
                    $boldMessage=0; 
                    if($_POST['dashboard'] && $val->is_read=='N')
                         $boldMessage=1; 
                     ?>
                        <li <?php echo $boldMessage?"style='font-weight:bold;'":"";?> <?php echo ($messageCnt==$cCnt)?"id='lastCId'":""?>><?php echo $val->message; ?> <br/> -<small><?php echo $postedName.' '.getTimeAgo(strtotime($val->added_date));?> </small></li>
                        
                     <?php
                     
                  } 
                  
                  } else { echo ' <li>No messages available</li>';  }		?>
            
            </ul>
            <?php
             if($isDashboard)
             {
                 ?>
                 <div class="col-lg-1" style="margin-bottom:10px">
                 <button id="replyBtn" class="bt btn-info btn-sm" onclick="$('#commentFrm').toggle();if($('#commentFrm').css('display')=='none') $('#replyBtn').html('Reply'); else $('#replyBtn').html('Hide');" style="margin-top:10px;" type="button">Reply</button>	 
                 </div>
                 <?php
             }
            ?>
            <div id="commentFrm" style="display:<?php echo $isDashboard?'none':'block'?>">
            <form style="padding:10px;">
            <input type="hidden" id="invoice_line_item_id" value="<?php echo $invoiceLineItemId;?>">
            <input type="hidden" id="invoice_id" value="<?php echo $invoice_id;?>">            
            <textarea class="form-control" id="internal_message"></textarea>
            <button class="bt btn-danger btn-sm" onclick="submitInternalMessages()" style="margin-top:10px;" type="button">Submit</button>
            <button class="btn btn-danger btn-sm float-right" type="button" style="margin-top:10px;" onclick="closeForm()">Close</button>
            </form>
            </div>
             </div>
             <style>
             .comments-list { list-style-type:none;padding-left:10px;  max-height: 400px; overflow-y: scroll;}
             .comments-list li {border-bottom:1px solid #00000026;padding-top:10px; }
             </style>
             <script>
             $('.comments-list').animate({scrollTop: $('.comments-list').prop("scrollHeight")}, 500);
             
             function submitInternalMessages() { 	err=0;
             var invLineItemId = $('#invoice_line_item_id').val();
             var invoiceId = $('#invoice_id').val();
             
              if($('#internal_message').val()=='' ){ err=1; $('#internal_message').css("border","1px solid #ff0000 "); } else{  $('#internal_message').css("border","");}
                 var internal_message =  $('#internal_message').val();
             if(err==0) {
                $('#tempMessage'+invLineItemId).val(internal_message);
                 paramData = {'act':'submitInternalMessages','invoice_line_item_id': invLineItemId,"invoice_id":invoiceId,"message":internal_message };
                      ajax({ 
                        a:'invoiceStatus',
                        b:$.param(paramData),
                        c:function(){},
                        d:function(data){  
                        var res = data.split("::");
                        alert(res[1]);                                        
                        showInternalMessages(invLineItemId,invoiceId); 
                        if($('#tempMessage'+invLineItemId).val()!='')
                            $('#lastMessageStr'+invLineItemId).html($('#tempMessage'+invLineItemId).val());
                        }}); 
             } }
                         
             
             </script>
            <?php 
            exit();	
            }
   
    if($_POST['act']=='view_invoice_line_specialist')
    {
        ob_clean();
        $line_item_id=$_POST['line_item_id'];
        include 'view_invoice_line_item_specialist.php'; 
        exit();
    }
    if($_POST['act']=='showInvoices')
    {
        ob_clean();
        extract($_POST);
        $serviceid=$_POST['serviceId'];        
        $docIds=$_POST['docIds'];   
        //print_r($_POST);exit;
        $invoiceObj->service_id=$serviceid;
		$invoiceObj->category_id=$_POST['categoryId'];
        $invoiceRes=$invoiceObj->getInvoicesByService();

        if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
            $totalCount = count($invoiceRes);
            $totalPages= ceil(($totalCount)/(PAGE_LIMIT));
            if($totalPages==0) $totalPages=1;
            $StartIndex= ($page-1)*PAGE_LIMIT;
            if(count($invoiceRes)>0) $listingArr = array_slice($invoiceRes,$StartIndex,PAGE_LIMIT,true);	
            
                $prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filter_by."\",\"".$id."\",\"".$serviceid."\",\"".$docIds."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\",\"".$id."\",\"".$serviceid."\",\"".$docIds."\")'/>";
	if(count($invoiceRes)>0 && $totalPages > 1){
	if($page > 1){
		$pageNo = $page - 1;
		$prev = "<img src='assets/images/prev_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$id."\",\"".$serviceid."\",\"".$docIds."\")'/>";
	} 
		
	if ($page < $totalPages){
		$pageNo = $page + 1;
		$next = " <img src='assets/images/next_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$id."\",\"".$serviceid."\",\"".$docIds."\")'/>";
	} 
	
	if($pageNo=='')
		$pageNo=1;
	if($totalPages>1) {
	$pagebox="<td style='border:0;'><input type='text' name='page' id='page' value='".$page."' onchange='ShowListPagination(this.value,\"".$filter_by."\",\"".$id."\",\"".$serviceid."\",\"".$docIds."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center; width: 25px; height: 15px; vertical-align: middle;' size='4'> of $totalPages</td>";
	}	

	$table_val = "<table class='' width='100%;padding:10px' cellpadding='5' cellspacing='0' border='0' style='border:0;><tr style='background-color:#fff'><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right'><table align='right' cellpadding='0' cellspacing='1'><tr style='background-color:#fff'><td style='padding:10px 12px;'>$first</td><td style='padding:10px 6px;'> $prev </td>$pagebox<td style='padding:10px 2px;'>$next </td><td style='padding:10px 12px;'>$last</td></tr></table></td></tr></table>";
}  


    
if(count($listingArr) > 0) {
	   
?>
<style>
.hasDatepicker {
    position: absolute;
    z-index: 9999;
}
</style>
<table cellpadding="2" width="100%" cellspacing="0" class="table-bordered"> 
        <thead>
        <th></th>
        <th>Due Date</th>
        <?php
            foreach($GLOBALS['PROCESS_STEPS'] as $pk =>$pv) { ?><th><?php echo $pv;?></th><?php } ?>
            <?php if($_SESSION['user_type']!='E' && $_SESSION['user_type']!='FL') { ?><th>Assign Specialist</th><?php } ?>
            <th>Last Activity</th>   
            <th>Update Phase</th>
            <th>Update Status</th>
            <th>Internal Comments</th>                 
        </thead>
            
        <?php
        
        $param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$serviceid.'-INT'));
        $rsService = Table::getData($param);
        $unserializeSteps =  unserialize($rsService->service_steps);  	

		$rowCnt=0;
        foreach($listingArr as $lk => $lv)
        {
            
            $invoiceObj->docIds=$docIds;
            $invoiceObj->invoice_line_item_id=$lv->id;
            $docIdsArr=explode(",",$docIds);
            $docIdsArr=array_unique($docIdsArr);
            $quesCnt=$invoiceObj->getQuestionnaireDetailsByDoc();
             
            $quesPercentage=($quesCnt/count($docIdsArr))*100;

            foreach($GLOBALS['PROCESS_STEPS'] as $pk =>$pv) {
                if($pk=='QA')
                    continue;

                $invoiceObj->invoice_id=$lv->invoice_id;
                $invoiceObj->invoice_line_item_id=$lv->id;
                $invoiceObj->step_name=$pk;

                $InvProcess=$invoiceObj->getInvoiceLineItemStatus();

                $$pk=$InvProcess->recCnt;
            }
            
            $invoiceObj->invoice_id=$lv->invoice_id;
            $clientRes=$invoiceObj->getClientByInvoice();

            $invoiceObj->invoice_line_item_id=$lv->id;
            $lastActivity=$invoiceObj->getInvoiceLastActivity();            
			$bgColor = '#f5f5f5';
            if($rowCnt%2==0) $bgColor = '#ffffff';
            
      $param = array('tableName'=>TBL_INTERNAL_MESSAGES,'fields'=>array('*'),'condition'=>array('invoice_id'=>$lv->invoice_id.'-INT', 'invoice_line_item_id'=>$lv->id.'-INT'), 'orderby'=>'id','sortby'=>'desc','limit'=>1);
            $internalMessageRes = Table::getData($param);
            $internalMessageRes=$internalMessageRes[0];                      
            
           //Invoice status part             
$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$lv->invoice_id.'-INT'));
$rsInvoice = Table::getData($param);

$invStatus=trim($rsInvoice->line_item_status);

if($_SESSION['user_type']!='E' && $_SESSION['user_type']!='FL') {
//get sepcialist
    $specialist_name='';
    if($lv->specialist_id > 0)
    {
        $param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$lv->specialist_id.'-INT'));
        $rsUsers = Table::getData($param);
        
        $specialist_name = $rsUsers->contact_fname.' '.$rsUsers->contact_lname;               
    }
}
$statusOption='';
if($invStatus =='QS') { $statusOption = '<option value="IP">InProgress </option><option value="SP">Submitted for Process</option>'; } 
if($invStatus =='IP') { $statusOption = '<option value="SP">Submitted for Process</option><option value="AWC">Awaiting Customer Reply</option><option value="D">Done</option>'; } 
if($invStatus =='AWC') { $statusOption = '<option value="R">Replied</option><option value="IP">InProgress </option>'; } 
if($invStatus =='R') { $statusOption = '<option value="IP">InProgress </option><option value="SP">Submitted for Process</option><option value="AWC">Awaiting Customer Reply</option>'; } 
if($invStatus =='SP') { $statusOption = '<option value="D">Done</option><option value="AWC">Awaiting Customer Reply</option>'; } 
if($invStatus =='FQ') { $statusOption = '<option value="IP">InProgress </option><option value="SP">Submitted for Process</option><option value="AWC">Awaiting Customer Reply</option>'; } 
                
        ?>
        <tr style="border: 1px solid #ccc;height: 45px; background-color:<?php echo $bgColor?>" id="invoiceLineItem_<?php echo $lv->id;?>" class="border"><td style="width:25%">              
        <a class="text-primary" <?php if($_SESSION['user_type']!='FL') {?>href="javascript:show_invoice_paymentDtls('<?php echo $lv->invoice_id;?>')" <?php } ?>><strong>BE-<?php echo $lv->invoice_id;?></strong></a>&nbsp;<span id='status_<?php echo $lv->id;?>'><?php echo getStatusStyle($lv->line_item_status);?></span>
        <?php if($_SESSION['user_type']!='E' && $_SESSION['user_type']!='FL') {?><span style="float:right"><a style="color:#52bb56" title="View Log" href="javascript:viewLogs('<?php echo $lv->id;?>','<?php echo TBL_INVOICE_LINE_ITEM;?>')">&nbsp;<i class="fa fa-history" aria-hidden="true"></i></a>
<a title="Edit Invoice" href="javascript:editInvoice('<?php echo $lv->invoice_id;?>')"><i class="fa fa-edit" aria-hidden="true"></i></a>&nbsp;<a href="javascript:void();" onclick="deleteInvoice('<?php echo $lv->invoice_id;?>')" title="Delete Invoice"><i style="color:red" class="fas fa-trash"></i></a></span><?php } ?>

        <br>
        
        <div class="text-danger"><strong><?php echo $lv->line_item; ?></strong></div>
        <?php if(strlen($lv->line_desc) > 0) { ?>
        <div class="text-warning" style="font-style: italic;font-size: 13px;"><strong><?php echo substr($lv->line_desc,0,25); if(strlen($lv->line_desc) > 25) echo "..";?></strong>&nbsp;<?php if(strlen($lv->line_desc) > 25) {?><i data-toggle="modal" data-target="#line_desc_<?php echo $lv->id;?>" style="cursor:pointer; font-size:16px; color:#039cfd" class="fas fa-caret-down"></i><?php } ?></div>
        <div id="line_desc_<?php echo $lv->id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="CenterModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="CenterModalLabel"><?php echo $lv->line_item;?></h4>
                    </div>
                    <div class="modal-body">
                        <?php echo $lv->line_desc; ?>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>
		<?php }
            $paymentLink='';
            $invoiceObj->invoice_id=$lv->invoice_id;
            $paymentLink=$invoiceObj->getInvoicePaymentLink();

        $param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$lv->invoice_id.'-INT'));
        $resInvoice = Table::getData($param);
		
		$clientCompany='';
		if($clientRes->client_company_name!='') { $clientCompany = '<strong>'.$clientRes->client_company_name.'</strong><br/>';  }
        ?>
		
		<?php echo $clientCompany.' <strong>'.$clientRes->client_fname." ".$clientRes->client_lname."</strong>(".$clientRes->id.")";?> <a style="color:#f76397" href="<?=SHAREPOINT_LINK.$clientRes->id;?>" target="_blank"><i class="fa fa-folder" aria-hidden="true"></i></a>
                <br><?php echo $clientRes->client_phone;?><br><?php if($_SESSION['user_type']!='FL') { ?><a title="Client Login" href="<?php echo BASE_URL;?>accounts?clid=<?php echo $clientRes->id;?>&cl=1&invi=<?php echo $lv->invoice_id;?>" target="_blank"><i class="fas fa-external-link-alt" style="font-size:20px"></i></a>&nbsp;<?php } ?><a href="javascript:void(0)" style="color:#343C49;" title="Show Password" onclick="$('#clientPass_<?php echo $clientRes->id;?>').toggle();"><i style="font-size:20px" class="fas fa-key"></i></a>&nbsp;<a href="javascript:void(0)" title="Send SMS" onclick="send_sms('<?php echo $clientRes->id;?>')"> <i class="fas fa-sms text-success" style="font-size:24px;"></i></a>&nbsp;<a href="javascript:void(0)" onclick="showSendEmail(<?php echo $clientRes->id;?>,'<?php echo $lv->invoice_id;?>','<?php echo $lv->id;?>','all','C')" title="Send Email"><i class="fa fa-envelope" style="font-size:24px;" aria-hidden="true"></i></a>
				
			<?php  $serviceObj = new Invoice();
                   $serviceObj->invoice_line_item_id=$lv->id;
                   $is_questionnaire=$serviceObj->isQuestionnaire();
					if($is_questionnaire){ ?>	
					<a target="_blank" href="invoices.php?invId=<?php echo $lv->invoice_id; ?>&item_id=<?php echo $lv->id;?>">Questionnaire</a> <?php } 
				 
				 		
				if($paymentLink!='') { ?>&nbsp;<a target="_blank" href="<?php echo $paymentLink;?>" title="Pay installment"><i style="font-size:24px;" class="fas fa-comment-dollar text-success"></i></a><?php } ?><br><?php if($resInvoice->balance_amount > 0) { ?><strong>Balance:</strong> <?php echo money($resInvoice->balance_amount,'$');?><br><?php } echo $clientRes->client_email;?><div id="clientPass_<?php echo $clientRes->id;?>" style="display:none; color:#52bb56; font-weight:bold"><?php echo $clientRes->client_pass;?></div></td>
        <td>
        <?php 
        $delivery_due_date='';
        if($lv->estimated_delivery_date=='0000-00-00')
        {            
            $delivery_time_arr=explode("|",$lv->delivery_time);         
            $val_to_add='';
            
            switch($delivery_time_arr[1])
            {
                case "D":
                $val_to_add="+".$delivery_time_arr[0]." day";
                break;
                case "M":
                $val_to_add="+".$delivery_time_arr[0]." month";
                break;
                case "H":
                $val_to_add="+".$delivery_time_arr[0]." hour";
                break;
            }
            if($delivery_time_arr[0] > 1)
                $val_to_add.="s";
                        
            if($lv->added_date!='0000-00-00' && $val_to_add!='')
                $delivery_due_date=date('m/d/Y',strtotime($val_to_add, strtotime($lv->added_date)));
                
        }
        else
        {
            if($lv->estimated_delivery_date!='0000-00-00')
                $delivery_due_date=date('m/d/Y',strtotime($lv->estimated_delivery_date));
               
        }

        
        $delivery_due_date=($delivery_due_date=='' || $delivery_due_date=='12/31/1969')?"<span style='color:red'>Not set</span>":$delivery_due_date;
        $addErrCls='';
       
        if(strtotime($delivery_due_date) < strtotime(date('m/d/Y')) && $delivery_due_date!="<span style='color:red'>Not set</span>")
          $addErrCls='style="background-color:red; color:#fff; padding:3px"';
        echo '<span id="display_date_'.$lv->id.'" '.$addErrCls.'>'.$delivery_due_date.'</span>';
        ?>
        
        <div id="datepicker_<?php echo $lv->id;?>" class="datePickerCls"></div>
        <i style="cursor:pointer;color:#f1b53d; font-size:17px" class="fas fa-calendar-alt" class="duedate_datepicker" onclick="showDatePicker('<?php echo $lv->id;?>')" title="Change Due Date"></i>        
        </td>
        <td>
        <a href="invoices.php?invId=<?php echo $lv->invoice_id;?>&item_id=<?php echo $lv->id;?>" target="_blank" title="Show Questionnaire"><i class="fas fa-tasks"></i></a>
        <div style="font-size:12px"><?php echo $quesCnt>0?$quesCnt:"0";?>/<?php echo count($docIdsArr);?></div>
        <div class="progress"  style="background-color:#e9ecef; height:2rem;margin-bottom:0px; cursor:pointer">
<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo round($quesPercentage);?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($quesPercentage);?>%">
<span class="sr-only"><?php echo round($quesPercentage);?>% Complete</span>
</div>
</div></td>
        <td align="center"><input type="checkbox" class="RCls" name="review" value="Review"  onclick="updateLineItemProcess('<?php echo $lv->invoice_id;?>','<?php echo $lv->id;?>','R',this)" <?php if($R > 0) echo "checked";?> ></div></td>
        <td align="center"><input class="ACls" type="checkbox" name="affidavits" value="Affidavits" onclick="updateLineItemProcess('<?php echo $lv->invoice_id;?>','<?php echo $lv->id;?>','A',this)" <?php if($A > 0) echo "checked";?>></td>
        <td align="center"><input class="ASCls" type="checkbox" name="application_submit" value="Application Submit" onclick="updateLineItemProcess('<?php echo $lv->invoice_id;?>','<?php echo $lv->id;?>','AS',this)" <?php if($AS > 0) echo "checked";?>></td>
        <td align="center"><input class="HOCls" type="checkbox" name="handover" value="Handover" onclick="updateLineItemProcess('<?php echo $lv->invoice_id;?>','<?php echo $lv->id;?>','HO',this)" <?php if($HO > 0) echo "checked";?>></td>          
        <?php if($_SESSION['user_type']!='E' && $_SESSION['user_type']!='FL') { ?>
        <td><span class="assignresponse_<?php echo $lv->id;?>"> <?php echo $specialist_name; ?>  </span><br>  
	 <a href="javascript:void(0)" title="Assign Specialist" class="btn btn-warning btn-sm assignresponse_show_<?php echo $lv->id; ?>" onclick="assignSpecialist(<?php echo $lv->invoice_id.','.$lv->id; ?>)">Assign</a></td>
        <?php } ?>
        <td><i><?php echo $lastActivity;?></i></td>         
        <td style="padding:5px"><?php 
        $unserCnt=count($unserializeSteps);
        $stepPhaseStr='';
        for($i=0;$i<=$unserCnt;$i++)
        {
            if($unserializeSteps['service_name_append'][$i]!='')
            {
                $selected='';
                if($lv->service_step_name==$unserializeSteps['service_name_append'][$i])
                        $selected='selected';                
              $stepPhaseStr.="<option vale='".$unserializeSteps['service_name_append'][$i]."' ".$selected.">".$unserializeSteps['service_name_append'][$i]."</option>";
            }
        }    
        if($stepPhaseStr!='')
            echo '&nbsp;<select class="form-control" name="service_step_name" id="service_step_name_'.$lv->id.'">'.$stepPhaseStr.'</select><div style="margin-left: 1px;
        margin-top: 5px;"><button title="Update Phase" class="btn btn-primary btn-sm serviceStepList" onclick="submitPhaseList('.$lv->id.')">Set</button></div>';                
                else
                  echo "<span style='color:red'>No phase defined.</span>";
        ?></td>
        <td align="center"><a title="Change Invoice Status" href="javascript:void(0)"  class="btn btn-sm btn-success" title="update status" onclick="show_invoice_status('<?php echo $lv->id;?>')">Update</a>
        </td>         
        <td><span id="lastMessageStr<?php echo $lv->id;?>"><?php echo $internalMessageRes->message;?></span>&nbsp;<span><a href="javascript:void(0)" title="Show Message Window" onclick="showInternalMessages('<?php echo $lv->id;?>','<?php echo $lv->invoice_id;?>')"><i class="fas fa-comments"></i></a></span></td>
        </tr>
        <tr id="invoiceLineItem2_<?php echo $lv->id;?>">
            <td colspan="10">&nbsp;</td>
        </tr>
        <?php
        }        
        ?>
        </table>
    <?php } else { ?><div class="col-md-12">No record found</div><?php } ?><div class="col-md-12"><?php  if($table_val!='') { echo  $table_val; } ?></div> <?php exit;} ?>     
    
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Invoices Status</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active activeBread" style="cursor:pointer;">Invoices Status</li>
            
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <div class="card-box" style="background-color:#FFF">
            <div class="row page_head_title"  id="search_form_div">
            <div class="col-lg-6"><h4 class="m-t-0 header-title">Invoices Status Details</h4></div>
            <div class="col-lg-6"></div>
            <div class="col-lg-12" style="padding:10px"> 

            <form id="filter_form" style="display:flex;">
                <select class="form-control" style="padding:2px; margin-left:10px;width:20%" name="filter_type" id="filter_type" onchange="filterOption(this.value)">
                <option value="filter">Filter</option>								 
                <option value="step">Step</option>
                <option value="services">Services</option>                
                </select>
                
                <input type="text" name="filter_textbox" id="filter_textbox" class="form-control" style="padding:2px; margin-left:10px; width:25%">
                <select class="form-control" id="steps" style="display:none;padding:2px; margin-left:10px;width:25%">
                <option value="">Select</option>
                <?php
                      foreach($GLOBALS['PROCESS_STEPS'] as $pk =>$pv) { if($pk=='QA') continue;?><option value="<?php echo $pk;?>"><?php echo $pv;?></option><?php } ?>                   
                </select>
                <input type="hidden" name="filter_text_id" id="filter_text_id">
                <input type="hidden" name="filter_text" id="filter_text">
                <input type="hidden" name="act" value="filter_status_list">
                <button type="button" onclick="searchInvoice()" class="btn btn-sm btn-primary" style="margin-left:10px;">Search</button>  
                <button type="button" title="Clear Form" onclick="$('#filter_type').val('filter');filterOption('filter');" class="btn btn-sm btn-danger" style="margin-left:10px;">Clear</button>
                <button type="button" onclick="refreshServices();" class="btn btn-sm btn-success" style="margin-left:10px;" title="Reload Invoices">Refresh</button>              
            </form>
            </div> 
            </div>
            <div class="view_invoices_div"></div>
            <div class="table_div"><?php
              $catRes=$invoiceObj->getCategoriesByInvoices();
                
              foreach($catRes as $ck => $cv)
              {   
                  ?>                 
                        <div class="catCls" id="cBlock<?php echo $cv->category_id;?>">
                        <div class="title-panel-heading"  style="background-color: #f5f5f5;padding: 10px;">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cv->category_id;?>">
                            <?php echo $cv->category_name;?></a>
                            <span style="float:right; font-size:30px;cursor:pointer;color: rgb(3, 156, 253);" class="categoryCls" id="cat-<?php echo $cv->category_id;?>">-</span>
                        </h4>
                        </div>          
                        <div id="cat<?php echo $cv->category_id;?>" class="panel-collapse">
                  <?php
                 
                $invoiceObj->category_id=$cv->category_id;
                $serviceRes = $invoiceObj->getServicesByInvoices(); 
               
                foreach($serviceRes as $sk => $sv)
                {               
                    $qry="select document_id from ".TBL_SERVICES." where id='".$sv->service_id."'";   
                    $docRes = dB::mExecuteSql($qry);
                    $docIds=$docRes[0]->document_id;
                    $docIdsArr=explode(",",$docIds);
                    
                    $invoiceObj->get_count=1;
                    $invoiceObj->service_id=$sv->service_id;
					$invoiceObj->category_id=$cv->category_id;
                    $invCntRes=$invoiceObj->getInvoicesByService();

                    ?>
                    <div data-serv="<?php echo $sv->service_id;?>" class="panel-heading service-panel-collapse" style="background-color: #f5f5f5;padding: 10px; padding-left:25px">
                    <h6><strong><?php echo $sv->line_item;?></strong> <span id="count<?php echo $cv->category_id."-".$sv->service_id;?>" style="color:#039cfd">(<?php echo $invCntRes->invCnt;?>)</span><span style="cursor:pointer;float:right; font-size:30px;padding-right:25px" data-docs="<?php echo $docIds;?>" class="serviceCls" id="service-<?php echo $cv->category_id."-".$sv->service_id;?>">+</span></h6>
                    <div data-service="<?php echo $sv->service_id;?>" style="display:none" id="service<?php echo $cv->category_id."-".$sv->service_id;?>"  class="service-panel-collapse2"> </div>
                    <input type="hidden" name="prevCnt" class="prevCntCls" id="prevCnt<?php echo $cv->category_id."-".$sv->service_id;?>" value="<?php echo $invCntRes->invCnt;?>">
                    </div> 
                    <?php      
                }
                ?>
                </div>
                <br></div><?php   
              }
            ?> </div>
            <div class="preview_div"></div>
        </div>      
        </div>
        <div class="col-lg-3">
           <span class="right_bar_div"></span>
         </div>     
        </div>
        <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
              <style>.loader {
  position: relative;
  text-align: center;
  margin: 15px auto 35px auto;
  z-index: 9999;
  display: block;
  width: 80px;
  height: 80px;
  border: 10px solid rgba(0, 0, 0, .3);
  border-radius: 50%;
  border-top-color: #000;
  animation: spin 1s ease-in-out infinite;
  -webkit-animation: spin 1s ease-in-out infinite;
}</style>
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body text-center">
              <div class="loader"></div>
            </div>
          </div>    
        </div>
        </div>
        <input type="hidden" name="initial_load" id="initial_load" value="0">
        <script>
        function updateLineItemProcess(invId, invLineItemId,stepval,currentCheckbox)
{
    if(confirm('Are you sure you want to update this?'))
    {
        var checkedval=0;

        if(currentCheckbox.checked)
            checkedval=1;

        paramData = {'act':'updateLineItemProcess','invoice_line_item_id': invLineItemId,"invoice_id":invId,'step':stepval, "checkedval":checkedval};
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
                //alert(data);
            }});
    }
    else{this.checked=false;}
}
function filterOption(filterVal) {
	$('#filter_textbox').val('');
	$('#filter_text_id').val('');
	$('#filter_text').val('');    
    $('.catCls').show();
    //$('.serviceCls').html('+').css('font-size','30px');
    $('#steps').val('');
    //$('.panel-collapse').hide();
    //$('.service-panel-collapse2').hide();
    $('.service-panel-collapse').show(); 
    $('.service-panel-collapse tbody tr').show();
    //$('.service-panel-collapse').show();
    $('.prevCntCls').each(function(){
        var curid=$(this).attr('id').split('prevCnt');
        $('#count'+curid[1]).html("("+$('#prevCnt'+curid[1]).val()+")");
    })
    if(filterVal=='step')
     {
        $('#filter_textbox').hide();
        $('#steps').show();
     } 
     else{
        $('#filter_textbox').show();
        $('#steps').hide();
     }
}
var filter_type = $('#filter_type').val();
 $("#filter_textbox").autocomplete({ 	 
  source: function(request, response) {
  $.getJSON("search_details.php",{ filter_type: $('#filter_type').val(),'act':'invoiceAutocomplete','term':$('#filter_textbox').val() },response); },
  minLength: 2,
  select: function(event, ui){      
  event.preventDefault();  
	$("#filter_textbox").val(ui.item.value);
	$("#filter_text_id").val(ui.item.id);
	$("#filter_text").val(ui.item.value);
	//searchInvoice(); 
    //alert(ui.item.id);       
    var catId=$("div[data-serv='" + ui.item.id + "']").parent().attr('id').replace('cat','');
    $('.catCls').hide();
    $('#cBlock'+catId).show();    
    $('.service-panel-collapse').hide();
    $("div[data-serv='" + ui.item.id + "']").show(); 
	 
	 } 
});

$('#steps').on('change', function()
{   
    if(this.value!='')
    {
        $('.catCls').hide();
        var clsName=this.value+'Cls';        
        $('.service-panel-collapse').hide();
        $('.service-panel-collapse tbody tr').hide();
        $('.service-panel-collapse tbody tr').each(function()
        {            
            catIdStr=$(this).parents('.service-panel-collapse2').attr('id');
            var catIdArr=catIdStr.split('service');
            var catIdArr2=catIdArr[1].split("-");                
            
            if($(this).find("."+clsName).attr('checked'))
            {
                $(this).show();
                $('#cat'+catIdArr2[0]).show();
                $('#cBlock'+catIdArr2[0]).show();
                $('#service'+catIdArr2[0]+'-'+catIdArr2[1]).show();
                //$('#count'+catIdArr2[0]+'-'+catIdArr2[1]).html();   
                invCnt=0;
                $.each($('#service'+catIdArr2[0]+'-'+catIdArr2[1]+' tr'), function(){                                  
                    if($(this).css('display')!='none') {                    
                        invCnt++;
                    }
                })
                $('#count'+catIdArr2[0]+'-'+catIdArr2[1]).html("("+(invCnt-1)+")");  
                
                $("div[data-serv='" + catIdArr2[1] + "']").show();                              
                $("div[data-serv='" + catIdArr2[1] + "']").find('.serviceCls').html("-").css('font-size','35px');
                //$(this).parentsUntil($('#cat'+catIdArr2[0])).show();
                //$(this).parents($('#cBlock'+catIdArr2[0])).show();
                //$(this).parents('.service-panel-collapse').show();
            }                    

        });
    }
    else
    {
        //$('.service-panel-collapse tbody tr').hide();
    }
});

$('.serviceCls').on('click',function(){
    
  var idArr=$(this).attr('id').split("-");
  
  if($('#initial_load').val()==1 || 1==1)
  {
    if($('#service'+idArr[1]+"-"+idArr[2]).css('display')=='none')
    {
            $(this).html('-').css('font-size','35px');
            $('#service'+idArr[1]+"-"+idArr[2]).show();
    }
    else{
            $(this).html('+').css('font-size','30px');
            $('#service'+idArr[1]+"-"+idArr[2]).hide();
    }
      
  }
  
  if($.trim($('#service'+idArr[1]+"-"+idArr[2]).html())=='')
  {    

    paramData = {'act':'showInvoices','serviceId':idArr[2],'categoryId':idArr[1],'docIds':$(this).data('docs'),'id':'#service'+idArr[1]+"-"+idArr[2]}
    ajax({ 
                a:'invoiceStatus',
                b:$.param(paramData),
                c:function(){},
                d:function(data){    
				
                    $('#service'+idArr[1]+"-"+idArr[2]).html(data);
                    $('.datepicker').datepicker({
                                format: 'dd/mm/yyyy',
                                changeYear: true
                            });
                }}); 
  }
  
});
$('.categoryCls').on('click',function(){

    idval='#cat'+$(this).attr('id').replace('cat-','');
  
    if($(idval).css('display')=='none')
        $(this).html('-').css('font-size','35px');
    else
        $(this).html('+').css('font-size','30px');;
    $(idval).toggle();
});

function submitPhaseList(line_item_id) {    
	service_step_name =  $('#service_step_name_'+line_item_id).val();
    //alert(service_step_name);
	 paramData = {'act':'updateServiceList','line_item_id':line_item_id,'service_step_name':service_step_name};
	ajax({ 
		a:'process',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			  var res = data.split('::');
			  alert(res[1]); 
			  //$('.current_phase_'+line_item_id).html('<small>Current Phase : '+service_step_name+'</small>');
			  //$('.serviceStepList').hide();
		}});	 	 
 }
 function show_invoice_status(invoice_item_id) {   
	paramData = {'act':'show_invoice_status','id':invoice_item_id};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
            $('.right_bar_div').css('position','absolute');
		  $('.right_bar_div').html(data);	
          topPos=$('#status_'+invoice_item_id).offset().top-70;
          $('.right_bar_div').animate({top:topPos},1500);		  
		}});	
}
function ShowListPagination(page,filter_type,id,serviceid,docids) { 
    
	 paramData = {'act':'showInvoices','page':page,'filter_type':filter_type,'id':id,'serviceId':serviceid,'docIds':docids}    
	ajax({ 
		a:'invoiceStatus',
		b:$.param(paramData),
		c:function(){},
		d:function(data){                              
		  $(id).html(data);		
		}});	
	}

    $(function(){
		
        $('.button-menu-mobile').trigger('click');
        loadInvoiceServices();
        $('#initial_load').val('1');
    });
    
    function loadInvoiceServices()
    {
        totServCnt=$('.serviceCls').length;
		
        serviceCnt=0;

        $('.serviceCls').each(function(){
            serviceCnt++;
            var idArr=$(this).attr('id').split("-");
          
        if($('#service'+idArr[1]+"-"+idArr[2]).css('display')=='none')
        {
                $(this).html('-').css('font-size','35px');
                $('#service'+idArr[1]+"-"+idArr[2]).show();
        }
        else{
                $(this).html('+').css('font-size','30px');
                $('#service'+idArr[1]+"-"+idArr[2]).hide();
        }                  
        
        paramData = {'act':'showInvoices','serviceId':idArr[2],'categoryId':idArr[1],'docIds':$(this).data('docs'),'id':'#service'+idArr[1]+"-"+idArr[2]}
        ajax({ 
                    a:'invoiceStatus',
                    b:$.param(paramData),
                    c:function(){},
                    d:function(data){  					
                        $('#service'+idArr[1]+"-"+idArr[2]).html(data);
                       
                        if(serviceCnt==totServCnt)
                        {	                            
							setTimeout(function() { $("#loadingModal").modal("hide"); },500);                           
                        }
                    }}); 
       
        });
    }
    function refreshServices()
    {
        $('.service-panel-collapse2').hide();        
        $("#loadingModal").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
         });
         loadInvoiceServices();
    }
    function showQuestionnaireCmts(invLineItemId,documentId,questionnaireId) {
	 paramData = {'act':'showQuestionnaireCmts','invoice_line_item_id': invLineItemId,"document_id":documentId,"questionnaire_id":questionnaireId };
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
                $('.right_bar_div').css('position','absolute');
			   $('.right_bar_div').html(data);
               $('.right_bar_div').append('<textarea style="display:none" id="tempMessage'+invLineItemId+'"></textarea>');
               var eleTopPos=100;
                topPos=$('#status_'+invLineItemId).offset().top-eleTopPos;
               $('.right_bar_div').animate({top:topPos},1500);
            }}); 
}
function closeForm() {
	$('.right_bar_div').html('');
	
}
function send_sms(id) {
	
	paramData = {'client_id':id,'type':'client'};
	ajax({ 
		a:'send_sms',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		
			$('.right_bar_div').html(data);	
		  $('#con-close-modal').modal('show'); 		   
		}});	
}

function showSendEmail(id,invoice_id,line_item_id,email_type,param_type) {

//if(param_type=='C') paramData = {'act':'showClientEmail','client_id':id,param_type:param_type,'email_type':email_type,'templateId':'8'};
paramData = {'act':'showSendEmail','client_id':id,param_type:param_type,'email_type':email_type,'invoice_id':invoice_id,'line_item_id':line_item_id};

 ajax({ 
     a:'process',
     b:$.param(paramData), 
     c:function(){},
     d:function(data){ 		
       $('.right_bar_div').html(data);	
       $('#con-close-modal').modal('show');		  
     }});	
}
function assignSpecialist(id,line_item_id) {
	paramData = {'act':'view_invoice_line_specialist','id':id,'line_item_id':line_item_id};
	ajax({ 
		a:'invoiceStatus',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
            //alert(data);
			$('.modal-popup').html(data); 
			$('#con-close-modal-1').modal('show'); 	  
		}});	
}       

function showInternalMessages(invLineItemId,invoiceId)
{
    paramData = {'act':'showInternalMessages','invoice_line_item_id': invLineItemId,"invoice_id":invoiceId };
          ajax({ 
            a:'invoiceStatus',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
                $('.right_bar_div').css('position','absolute');
			   $('.right_bar_div').html(data);
               $('.right_bar_div').append('<textarea style="display:none" id="tempMessage'+invLineItemId+'"></textarea>');
               var eleTopPos=100;               
               topPos=$('#status_'+invLineItemId).offset().top-eleTopPos;
               $('.right_bar_div').animate({top:topPos},1500);
            }}); 

}
function show_questionnaire(invoice_item_id,invoice_id) {
	paramData = {'act':'show_questionnaire','line_item_id':invoice_item_id,'invoice_id':invoice_id};
	ajax({ 
		a:'invoices',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);	
		  $('#con-close-modal').modal('show');	
		}});	
}

function deleteInvoice(invId)
{
    if(confirm('Are you sure you want to delete this invoice and related items?'))
    {
        paramData = {'act':'delete_invoice','invoice_id':invId};
        ajax({ 
		a:'invoiceStatus',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
            refreshServices();    
		}});	
    }
}

function set_delivery_due_date(invLineItemId,dueDate)
{
    //alert($('#delivery_due_date_'+invLineItemId).val());
    paramData = {'act':'setDueDate','invoice_line_item_id':invLineItemId, 'due_date':dueDate};
        ajax({ 
		a:'invoiceStatus',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
            alert('Estimated due date updated.');
		}});	
}

function showDatePicker(invLineItemId)
{
    $('#datepicker_'+invLineItemId).show();
    $("#datepicker_"+invLineItemId).datepicker({
            changeMonth: true,
            changeYear: true,
            format: 'mm/dd/yyyy',            
            yearRange: "-50:+0",        
            defaultDate:$('#display_date_'+invLineItemId).html(),    
            onSelect: function(datetext){
                set_delivery_due_date(invLineItemId,datetext);               
                $('#display_date_'+invLineItemId).html(datetext);
                $('#datepicker_'+invLineItemId).hide();
            }
           
    });
    
}
$(function(){
$(document).on("click", function(e) {
    var elem = $(e.target);
    
    if(!elem.hasClass("hasDatepicker") && 
        !elem.hasClass("ui-datepicker") && 
        !elem.hasClass("ui-icon") && 
        !elem.hasClass("ui-datepicker-next") && 
        !elem.hasClass("ui-datepicker-prev") && 
        !$(elem).parents(".ui-datepicker").length && !elem.hasClass("fa-calendar-alt")){
            //alert($('.hasDatepicker').length);
            $('.hasDatepicker').hide();
    }
});
});

function editInvoice(invId)
{
	$('.preview_div').hide();
	paramData = {'act':'edit_invoice','invoice_id':invId,'processTrack':1};
        ajax({ 
		a:'edit_invoice',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
			$('.table_div').fadeOut();
			$('.preview_div').html(data).fadeIn('3000');
		}});	
}

function showHideTracking()
{
	$('.preview_div').fadeOut();	
	$('.table_div').fadeIn('3000');
}
function show_invoice_paymentDtls(invoice_id) {
	  paramData = {'act':'show_invoice_payment_details','invoice_id':invoice_id};
          ajax({ 
            a:'invoices',
            b:$.param(paramData),
            c:function(){},
            d:function(data){   
			  $('.right_bar_div').html(data);
			  $('#con-close-modal').modal('show');
			  
            }});	    	  
 }
        <?php
if($_REQUEST['invId'] > 0) { ?>
        editInvoice('<?php echo $_REQUEST['invId'];?>');
        <?php }
         ?>
        </script>     
<?php }

if($_SESSION['user_type']=='E' || $_SESSION['user_type']=='FL')
    include 'e_template.php';
else
include 'template.php'; ?>
