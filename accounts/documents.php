<?php 
function main() {
	
	if($_POST['act']=='submitDocuments') {
		ob_clean();
		$param=array(); 		 
		 
		$param['client_id']= $_SESSION['CLIENT_ID']; 
		
		$param['uploaded_by']='C'; // CLIENT 
		 $param['invoice_line_item_id']= $_POST['line_item_id'];; // CLIENT 
				
	 
		if(count($_FILES['document_file']['name'])>0) {
		foreach($_FILES['document_file']['name'] as $key=>$val) { 		
	$imagefile=$_FILES['document_file']['name'][$key]; 
	 $param['document_name']= $_POST['document_name'][$key];
	 if($_POST['document_name'][$key]!='') {
	$expImage=explode('.',$imagefile);
	$fileExpType=$expImage[1];
	$date = date('m/d/Yh:i:sa', time());
	$rand=rand(10000,99999);
	$encname=$date.$rand;
	 $fileName=md5($encname).'.'.$fileExpType;
	$filePath="../client_documents/".$fileName;
	move_uploaded_file($_FILES["document_file"]["tmp_name"][$key],$filePath);
	
	$param['document_file']= $fileName;

	$param['added_date'] = date('Y-m-d H:i:s',time());		
	$param['added_by']= $_SESSION['CLIENT_ID'];  
	echo $rsDtls = Table::insertData(array('tableName'=>TBL_CLIENT_DOCUMENTS,'fields'=>$param,'showSql'=>'N')); 
	 }
		 
		  }
	 }
		
	
		exit();		
	}
	
	
	
	if($_POST['act']=='deleteDocument') {
 ob_clean();
 
 $param = array('tableName'=>TBL_CLIENT_DOCUMENTS,'fields'=>array('*'),'condition'=>array('id'=>$_POST['id'].'-INT'),'showSql'=>'N');
 $rsDocuments= Table::getData($param); 
 $file = '../client_documents/'.$rsDocuments->document_file;
 unlink($file);
 
 $param=array();
$where= array('id'=>$_POST['id'],'client_id'=>$_SESSION['CLIENT_ID']);
 Table::deleteData(array('tableName'=>TBL_CLIENT_DOCUMENTS,'fields'=>$param,'showSql'=>'N','where'=>$where));		
 exit();	}
	
	
	
 if($_POST['act']=='showDocumentsList') {
ob_clean(); 
 $invoice_line_item_id = $_POST['invoice_line_item_id'];
$condition = array('client_id'=>$_SESSION['CLIENT_ID'].'-INT');
if($invoice_line_item_id>0) {  $condition = array('client_id'=>$_SESSION['CLIENT_ID'].'-INT','invoice_line_item_id'=>$invoice_line_item_id.'-INT');  }

if($invoice_line_item_id>0) {
   $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` where id = ".$invoice_line_item_id;
 $rsInvLItem=  dB::sExecuteSql($qry); 
 $lineLineItemName =  $rsInvLItem->line_item;
	 }
	 
?>
<div class="card" style="margin-top:20px">    
  <div class="card-body"> <h5><?php echo  $lineLineItemName; ?></h5>
<table class="table m-0 table-stripped">
<thead class="bg-primary text-white">
<th>#</th>
<th>Document</th>
 <th>Action</th>
</thead>
<tbody>
 <?php 
 $param = array('tableName'=>TBL_CLIENT_DOCUMENTS,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>$condition,'showSql'=>'N');
 $rsDocuments= Table::getData($param); 
 if(count($rsDocuments)>0) {
 foreach($rsDocuments as $key=>$val) {
	 ?>
<tr> 
<td><?php echo $key+1; ?></td>
<td><a href="../client_documents/<?php echo $val->document_file;?>" download><?php echo $val->document_name;?></a></td>
<td>
<a href="../client_documents/<?php echo $val->document_file;?>" style="font-size: 14px;font-weight: 600;" download>[download]</a> 
<a href="javascript:void(0)" style="font-size: 14px;font-weight: 600;" onclick="delete_document(<?php echo $val->id;?>)">[delete]</a> 
</td>
</tr>
<?php } } else {
echo '<tr><td colspan="3" style="text-align:center;">No Documents Uploaded</td></tr>';

}	?>
</tbody>
</table>
<button type="button" class="btn btn-danger btn-sm" style="padding:7px;font-size:14px;float:right;" onclick="showDocumentUploadForm(<?php echo $invoice_line_item_id; ?>)">Upload Document</button>
<br/>
<span class="upload_form"></span>
   </div>
 </div>
 
 
 <script>
 
   function showDocumentUploadForm(service_id) {
	  paramData = {'act':'showDocumentsUploadForm', 'invoice_line_item_id': service_id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			 $('.upload_form').html(data);
			  $('#con-close-modal').modal('show');
            }});	    	  
 }
 
 
 function delete_document(id) {
if(confirm('Are you sure delete this document?')) {	 
	  paramData = {'act':'deleteDocument', 'id': id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  
			    show_client_documents(<?php echo $invoice_line_item_id; ?>);
            }});	    	  
 } }
 
  function show_client_documents(invoice_line_item_id) {  
	  paramData = {'act':'showDocumentsList', 'invoice_line_item_id': invoice_line_item_id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('#content_order').html(data);
			  $('#document_list_tb').html(data);
			  $('#order_content_div').html(data);
            }});	    	  
 }
 </script>
<?php 
exit();
 } 	
	
	 if($_POST['act']=='showDocumentsUploadForm') {
ob_clean(); 
$clientId = $_SESSION['CLIENT_ID'];
 $param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('client_id'=>$clientId),'showSql'=>'N');
 $rsInvoices= Table::getData($param); 
 foreach($rsInvoices  as $K=>$V) $invoiceArr[]=$V->id;
 $invoiceIds = implode(',',$invoiceArr);
 
  $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` where invoice_id in (".$invoiceIds.")";
 $rsInvLItems=  dB::mExecuteSql($qry); 


$invoice_line_item_id = $_POST['invoice_line_item_id'];


if($invoice_line_item_id>0) {
   $qry ="SELECT * from `".TBL_INVOICE_LINE_ITEM."` where id = ".$invoice_line_item_id;
 $rsInvLItem=  dB::sExecuteSql($qry); 
 $lineLineItemName = ' - '.$rsInvLItem->line_item;
	 }
?>
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">			 
			<div class="modal-body">
				 <div class="row">
					<div class="col-md-12">
<div class="card" style="margin-top:20px">    
  <div class="card-body">
<p class="card-header bg-primary text-white">Upload Files  <?php echo $lineLineItemName; ?></p> <br/>
 
    <form name="upload_document_form" id="upload_document_form"   enctype="multipart/form-data">
	   	
		<?php if($invoice_line_item_id==0 || $invoice_line_item_id=='') { ?>
		 <div class="row">
			  <div class="form-group col-md-12">
		 <label class="require" style="font-size: 16px;padding-right: 10px;">Order Item : </label>
		 <select name="line_item_id" id="line_item_id">
		 <?php
		 foreach($rsInvLItems as $K=>$V) {
		 ?>
		 <option value="<?php echo $V->id;?>"><?php echo $V->line_item;?></option>
		 <?php
		 }
		 ?>
		 </select>
		 <span class="editor_error" style="border: none;font-size: 12px;color:#ff0000;"></span>
		</div>
		</div>
		<?php } else { ?> <input type="hidden" name="line_item_id" value="<?php echo $invoice_line_item_id; ?>"> 

		<?php } ?>
		
			
		
	     <div class="row">
			  <div class="form-group col-md-12">
				  <label class="require" style="font-size: 16px;padding-right: 10px;">Document Name : </label>
				   <textarea name="document_name[]"  class="form-control" id="document_name"></textarea>
				   <span class="editor_error" style="border: none;font-size: 12px;color:#ff0000;"></span>
			   </div>   
				
				<div class="form-group col-md-12">
				  <label class="require" style="font-size: 16px;padding-right: 10px;">Document File</label>
					<input type="file" name="document_file[]" style="border: none;font-size: 12px;">
				</div> 
			 </div>	
			
			<span class="document_appended_file"></span>
			 <button type="button" class="btn btn-danger"  style="padding: 4px;font-size: 12px;" onclick="addmoreDocumentFile()">Add more</button>
			 
			 <input type="hidden" name="act" value="submitDocuments">
			 <input type="hidden" name="invoice_line_item_id" id="invoice_line_item_id" value="<?php echo $invoice_line_item_id; ?>">
			 
			 <div class="form-group col-md-12">  <hr/>
			 <button type="submit" class="btn btn-danger"  style="padding: 8px;font-size: 16px;">Upload files</button>
			 </div>
   </form>
</div>
</div>
</div>
				</div>				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>				 
			</div>
		</div>
	</div>
	</div><!-- /.modal -->
 


<script>

 $( "form#upload_document_form" ).submit(function( event ) {
   event.preventDefault();        
    err=0;
  
  if($('#document_name').val()=='' ){ err=1; $('#document_name').css("border","1px solid #ff0000 "); } else{  $('#document_name').css("border","");}
   
		if(err==0) {
		   $.ajax({
		url: "documents.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(data){   
		var res = data.split("::");
		alert(res[1]);   		    
            $('form#upload_document_form')[0].reset();
  show_client_documents();  $('#con-close-modal').modal('hide');  $('.modal-backdrop').css('display','none');
 
		},
		error: function(){} 	        
		});
		}


  });
  
  
  
 function show_client_documents() {  var invoice_line_item_id = $('#invoice_line_item_id').val();
	  paramData = {'act':'showDocumentsList', 'invoice_line_item_id': invoice_line_item_id};
          ajax({ 
            a:'documents',
            b:$.param(paramData),
            c:function(){},
            d:function(data){  
			  $('#content_order').html(data);
			  $('#document_list_tb').html(data);
            }});	    	  
 }
 
 var x_file = 0; 
var max_fields_file = 5;

  function  addmoreDocumentFile() {
	  if(x_file < max_fields_file){
    x_file++; 
	var html='';
	
			html+='<div class="row  inner_document_file_'+x_file+'" style="border-top: 1px solid #00000029;padding-top: 15px;padding-bottom: 15px;"> ';
			  html+='<div class="form-group col-md-12">';
				  html+='<label class="require" style="font-size: 16px;padding-right: 10px;">Document Name : </label>';
				   html+='<textarea name="document_name[]"  class="form-control" id="document_name"></textarea>';
				   html+='<span class="editor_error" style="border: none;font-size: 12px;color:#ff0000;"></span>';
			   html+='</div>';   
				
				html+='<div class="form-group col-md-8">';
				  html+='<label class="require" style="font-size: 16px;padding-right: 10px;">Document File</label>';
					 html+='<input type="file" name="document_file[]" style="border: none;font-size: 12px;">';
				html+='</div>'; 
				html+='<div class="form-group col-md-4">';
				   html+='<button style="padding: 4px;font-size: 12px;" type="button" onclick="removeDocumentRow('+x_file+')" class="removebtn btn btn-icon waves-effect waves-light btn-danger btn-sm">remove</button>';
				html+='</div>'; 
			 html+='</div>';	 
			 
	   $('.document_appended_file').append(html);
  }   }
  
   function removeDocumentRow(id){ $('.inner_document_file_'+id).remove(); x--; }
</script>
<?php 
exit();
 } 	


	
	
} include 'template.php';
