<?php

function main() { 		
 $lineItemId = $_REQUEST['ili'];


$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$lineItemId.'-INT'),'showSql'=>'N');
$rsInvLItem = Table::getData($param);

$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$rsInvLItem->invoice_id.'-INT'),'showSql'=>'N');
$rsInvoices = Table::getData($param);  
?>
 <div class="row">
  <div class="col-md-12"><h1 class="heading">Questionnaire</h1> </div> 
</div>
<div class="row">
  <div class="col-md-8">
    <div class="card h-100">
	<div class="card-header bg-primary text-white">
        <strong>Order Id : BPE-<?php echo $rsInvoices->id;?></strong> 
		<input type="hidden" id="q_invoice_id" value="<?php echo $rsInvoices->id;?>">
		<span class="btnLabel text-primary pull-right" onclick="sendQuesReviewEmail('<?php echo $lineItemId;?>')">Send Questionnaire  for Review</span> 
		
		<span style="font-size:15px; float:right" class="text-primary pull-right btnLabel"><a style="color:#fff;" href="more_information.php?ili=<?php echo $lineItemId ?>">More Information</a></span> 
		
		 <span class="btnLabel text-primary pull-right">
		 <a target="_blank" style="color:#fff;" href="<?php echo SHAREPOINT_LINK.SessionRead('CLIENT_ID');?>">Folder</a></span> 
     </div> 	 
      <div class="card-body">  
 <div class="row">
    	<div class="col-md-12">
    		<div id="questionnaire_html" class="border"> 
            </div>
      </div>
    </div>   
</div> 
</div>
</div>
<div class="col-md-4">
  <span class="right_bar_div"></span>
 </div>

</div>

<style>
 .btnLabel { cursor:pointer; font-size:16px;float:right;color:#fff !important;font-weight:600;background-color: #ff0000;
padding: 5px 15px;border-radius: 5px;margin-right:5px; }
</style>

<script>
   



function sendQuesReviewEmail(invoice_line_item_id) {
	  paramData = {'act':'sendQuesReviewEmail', 'invoice_line_item_id': invoice_line_item_id};
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			 alert(data);
			   
            }});	
}

function showQuestionnaire(service_id) {
	      paramData = {'act':'showQuestionnaire', 'service_id': service_id};
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			
			   $('#questionnaire_html').html(data);
            }});	    
	 
}
showQuestionnaire(<?php echo $_REQUEST['ili'];?>);

function processQuestionnaire() {
  $( "form#questionnaire" ).submit(function( event ) {
   event.preventDefault();
   $.ajax({
		url: "process_questionnaire.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(data){  
		alert(data);
		   $('#questionnaire_html').html(data);
		   sendQuesReviewEmail(<?php echo $lineItemId;?>);  	 
		   
		},
		error: function(){} 	        
		});  });
}  

function showQuestionnaireComments(service_id) {
	      paramData = {'act':'showQuestionnaire', 'service_id': service_id};
          ajax({ 
            a:'process',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			
			   $('#questionnaire_html').html(data);
            }});	    
	 
}
</script>
<?php 
}
include "template.php";
?>