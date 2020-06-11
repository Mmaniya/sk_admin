<?php


$documentId = $_POST['id'];
$parent_id = $_POST['parent_id'];
$btnName = $title = 'Add New';  
if($parent_id>0) { 
		$param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'condition'=>array('id'=>$parent_id.'-INT'));
		$rsPElements = Table::getData($param);
		print_r($rsPElements);
		foreach($rsPElements as $K=>$V)  $$K=$V;
		$btnName = $title = 'Edit ';
}
 
?>

	<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			 
			<div class="modal-body">
			<form id="addNewdocumentsCategoryForm">
			<div class="row">
					<div class="col-md-6">
				<?php 	$param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'condition'=>array('id'=>$documentId.'-INT'));
	$rsDocument= Table::getData($param); ?>
						<strong> <?php echo $title; ?>  - <?php echo $rsDocument->doc_name; ?>  </strong>
					</div>
					 
<div class="col-md-12"> <hr> </div>
				</div>
				 
				 
					<div class="form-group row">
						 <div class="col-md-6"> <strong>Name : </strong>
					   <input type="text" class="form-control" name="doc_name" id="doc_name" value="<?php echo $doc_name; ?>">
					 </div>
					 </div>

             <div class="form-group row">
						 <div class="col-md-6"> <strong>Description : </strong>
					   <input type="text" class="form-control" name="doc_desc" id="doc_desc" value="<?php echo $doc_desc; ?>">
					 </div>										  
					</div>

					<div class="form-group row"><div class="col-md-6"> 
                      <strong>Type : </strong><br/> 
					   <input type="radio" name="doc_type" value="text" <?php if($doc_type=='text') { echo 'checked'; } ?>> Text&nbsp; 
                       <input type="radio" name="doc_type" value="textarea" <?php if($doc_type=='textarea') { echo 'checked'; } ?>> Textarea&nbsp; 
					   <input type="radio" name="doc_type" value="file" <?php if($doc_type=='file') { echo 'checked'; } ?>> File&nbsp;  
                       <input type="radio" name="doc_type" value="select" <?php if($doc_type=='select') { echo 'checked'; } ?>> Select&nbsp;  <br/>
                       <input type="radio" name="doc_type" value="radio" <?php if($doc_type=='radio') { echo 'checked'; } ?>> Radio&nbsp;  <br/>
                       <br/>
					   
					   <span class="error_msg" style="color:#ff0000;"></span>
					 </div>							
					 </div>							
									 
									 
				<div class="row">  					
    			<div class="dynamicRow_field form-group row innerCategory_<?php echo $rand; ?>" style="margin-bttom:0px;">  
					 <input type="hidden" name="parent_hidden[]" value="<?php echo $val->id; ?>">
				<!--<div class="col-md-2"><p></p>
				<button type="button" class="removebtn btn-icon waves-effect waves-light btn-danger btn-sm" onclick="removeDocuments(<?php echo $val->id; ?>,<?php echo $id; ?>)"> <i class="fa fa-remove"></i> </button>
				</div> <div class="col-md-12"><hr/></div>-->
					 <input type="hidden" name="id" value="<?php echo $id;?>"/>
					 <input type="hidden" name="parent_id" value="<?php echo $documentId;?>"/>
							<input type="hidden" name="act" value="addEditNewDocuments"/> 
							
					</div> 
			</div>
		 <div class="row" style="padding-bottom:20px;">
		     <div class="col-md-6"> <button type="submit"  class="btn btn-info waves-effect waves-light">Submit</button></div>
			  
		 </div>					 
			</form>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
				 
			</div>
		</div>
	</div>
	</div><!-- /.modal -->
	
	<script>
 
  $(document).ready(function (e){   
$("form#addNewdocumentsCategoryForm").on('submit',(function(e){
e.preventDefault();
	  err=0;
	 if($('#doc_name').val()=='' ){ err=1; $('#doc_name').css("border","1px solid #ff0000 "); } else{  $('#doc_name').css("border","");}
	 if($('#doc_desc').val()=='' ){ err=1; $('#doc_desc').css("border","1px solid #ff0000 "); } else{  $('#doc_desc').css("border","");}
	 
	 var doc_type =  $("input[name='doc_type']:checked").val();   
	 if(doc_type==undefined){ err=1; $('.error_msg').html("Select Document Type");  } else{  $('.error_msg').html('');  }
	 
	var form = $('#addNewdocumentsCategoryForm');   
  if(err==0) {
	   $('.loading').show();
	   
   ajax({ 
  	a:'documents_category',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){      
      var res = data.split("::");
       alert(res[1]);
      $('.right_bar_div').html('');
      showDocumentsList();  $('#con-close-modal').modal('hide'); 	
	 }});  

	  
 }  
}));
}); 
  
	 
  </script>
	
	
	
	<style>
	 .full-width-tabs > ul.nav.nav-tabs {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.full-width-tabs > ul.nav.nav-tabs > li {
    float: none;
    display: table-cell;
}
.full-width-tabs > ul.nav.nav-tabs > li > a {
    text-align: center;
}
.take-all-space-you-can{
    width:100%;
}  .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #fff;
    background-color: #2772d0;
    border-color: #dee2e6 #dee2e6 #fff;
}

.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link {
    color: #fff;
    background-color: #a0939a;
    border-color: #dee2e6 #dee2e6 #fff;
}

</style>