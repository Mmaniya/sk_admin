<?php 
$documentsId = $_POST['id'];
$btnName = $title = 'Add New ';
if($documentsId>0) { 
	$param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'condition'=>array('id'=>$documentsId.'-INT'));
	$rsDocuments = Table::getData($param);
	foreach($rsDocuments as $K=>$V)  $$K=$V;
}
?>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
 <div class="card-box">
            <h4 class="m-t-0 header-title">Add Documents</h4>
             <p class="text-muted font-14 m-b-20"></p>
                   <form class="form-horizontal" role="form" id="documentsCategoryForm" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Document Name : </label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="doc_name" id="doc_name" value="<?php echo $doc_name; ?>">
                                            </div>
                                        </div>
																				 
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Description : </label>
                                            <div class="col-md-9">
                                              <textarea id="editor" name="doc_desc" id="doc_desc" style="width: 308px;"><?php echo $doc_desc; ?></textarea>
                                            </div>
                                        </div>
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Type of Document : </label>
                                            <div class="col-md-9">
				   <input type="radio" name="doc_type" value="text" <?php if($doc_type=='text') { echo 'checked';  } ?> onclick="showParent('text')"> Text&nbsp;  
				   <input type="radio" name="doc_type" value="textarea" <?php if($doc_type=='textarea') { echo 'checked';  } ?> onclick="showParent('textarea')"> Textarea&nbsp;  
				   <input type="radio" name="doc_type" value="multiple" <?php if($doc_type=='multiple') { echo 'checked';  } ?> onclick="showParent('multiple')"> Multiple&nbsp;  
                   <input type="radio" name="doc_type" value="select" <?php if($doc_type=='select') { echo 'checked';  } ?> onclick="showParent('select')"> Select Box&nbsp;  (for more than three options)
                   <input type="radio" name="doc_type" value="radio" <?php if($doc_type=='radio') { echo 'checked';  } ?> onclick="showParent('radio')"> Radio Button&nbsp; (For two-three options)  
				   <input type="radio" name="doc_type" value="file" <?php if($doc_type=='file') { echo 'checked';  } ?> onclick="showParent('file')"> File&nbsp;   <br/>
											   <span class="error_msg" style="color:#ff0000;"></span>
                                            </div>
                                        </div>
              <?php 
			    $param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'condition'=>array('parent_id'=>$id.'-INT','status'=>'A-CHAR'));
	            $rsDocuments = Table::getData($param);
					if(count($rsDocuments)>0) {
                         foreach($rsDocuments as $key=>$val) { 		
                             				 
							?>			
					 <div class="append_forms dynamicRow_field form-group row innerCategory_<?php echo $rand; ?>" style="margin-bttom:0px;">
					 <div class="col-md-3"> <strong>Name : </strong>
					   <input type="text" class="form-control" name="parent_doc_name[]" value="<?php echo $val->doc_name; ?>">
					 </div>
					 
					 <div class="col-md-3"> <strong>Description : </strong>
					   <input type="text" class="form-control" name="parent_doc_desc[]" value="<?php echo $val->doc_desc; ?>">
					 </div>
					 
					 <div class="col-md-4"> <strong>Type : </strong><br/> 
					   <input type="radio" name="parent_document_type[<?php echo $val->id; ?>][<?php echo $id;?>]" value="text" <?php if($val->doc_type=='text') { echo 'checked'; } ?>> Text&nbsp; 
         <input type="radio" name="parent_document_type[<?php echo $val->id; ?>][<?php echo $id;?>]" value="textarea" <?php if($val->doc_type=='textarea') { echo 'checked'; } ?>> Textarea&nbsp; 
					   <input type="radio" name="parent_document_type[<?php echo $val->id; ?>][<?php echo $id;?>]" value="file" <?php if($val->doc_type=='file') { echo 'checked'; } ?>> File&nbsp; 
                        <input type="radio" name="parent_document_type[<?php echo $val->id; ?>][<?php echo $id;?>]" value="select" <?php if($val->doc_type=='select') { echo 'checked'; } ?>> Select&nbsp;
                         <input type="radio" name="parent_document_type[<?php echo $val->id; ?>][<?php echo $id;?>]" value="radio" <?php if($val->doc_type=='radio') { echo 'checked'; } ?>> Radio&nbsp;
					  </div> 
					 
					 <input type="hidden" name="parent_hidden[]" value="<?php echo $val->id; ?>">
					 
					  <div class="col-md-2"><p></p>
  <button type="button" class="removebtn btn-icon waves-effect waves-light btn-danger btn-sm" onclick="removeDocuments(<?php echo $val->id; ?>,<?php echo $id; ?>)"> <i class="fa fa-remove"></i> </button>
					   </div> <div class="col-md-12"> </div>
					 
					</div> <script> $('.addmore_link').show();  </script>
					<?php } } ?>
										
										
										<div class="appendCategory"></div>
										
										 
										 <label class="col-md-10 col-form-label text-right addmore_link" style="display:none;">
                                            <a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="AddMoreCategory()"> <i class="fa fa-plus"></i> Add More </a></label>
										 
									 
                                     
                                     
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Is Repeatable Field : </label>
                                            <div class="col-md-5">
				   <input type="radio" name="is_repeatable_field" value="Y" <?php if($is_repeatable_field=='Y') { echo 'checked';  } ?>> Yes&nbsp;				  				 <input type="radio" name="is_repeatable_field" value="N" <?php if($is_repeatable_field=='N') { echo 'checked';  } ?>> No&nbsp;  
  <br/>
											   <span class="error_msg" style="color:#ff0000;"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mb-0 row">
                                            <div class="col-md-6" style="text-align:center;">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditDocuments"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Submit</button>
                                            </div>
											
											
                                        </div>
                                    </form>
                                </div>
								
								<script>
    var editor = CKEDITOR.replace('editor');
	CKEDITOR.editorConfig = function( config ) {
	    config.toolbarGroups = [
		 { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	];
  };
	var x = 0; 
var max_fields = 100;

  function AddMoreCategory() { 
		
		if(x < max_fields){
    x++; 
		var html=''
			html+='<div class="append_forms form-group row innerCategory_'+x+'" style="margin-bottom:0px;">';
				 html+='<div class="col-md-3"> <strong>Name : </strong>';
				   html+='<input type="text" class="form-control" name="parent_doc_name[]">';
				 html+='</div>';
				 
				 html+='<div class="col-md-3"> <strong>Description : </strong>';
				   html+='<input type="text" class="form-control" name="parent_doc_desc[]">';
				 html+='</div>';
				 
				 
				 
				 html+='<div class="col-md-4"> <strong>Type : </strong><br/>';
				   html+='<input type="radio" name="parent_document_type['+x+']" value="text"> Text&nbsp;';  
				   html+='<input type="radio" name="parent_document_type['+x+']" value="textarea"> Textarea&nbsp;';  
				   html+='<input type="radio" name="parent_document_type['+x+']" value="file"> File&nbsp;';  
				     html+='<input type="radio" name="parent_document_type['+x+']" value="select"> Select&nbsp;';  
					   html+='<input type="radio" name="parent_document_type['+x+']" value="radio"> Radio&nbsp;';  
				 html+='</div>'; 
				 
				  html+='<div class="col-md-2"><p><input type="hidden" name="parent_append_hidden[]" value="0"></p>';
				   html+='<button type="button" class="removebtn btn-icon waves-effect waves-light btn-danger btn-sm" onclick="removeCategoryRow('+x+')"> <i class="fa fa-remove"></i> </button>';  
				   html+='</div> <div class="col-md-12"> </div>'; 
				 
			html+='</div>'; 
		 
		 $('.appendCategory').append(html);
		}
  } 		

  function removeCategoryRow(id){   $('.innerCategory_'+id).remove();   x--; }	
  
  
   function showParent(type) {
	   $('.addmore_link').hide();
	   $('.appendCategory').html('');
	   $('.dynamicRow_field').hide();
	   if(type=='multiple' || type=='select' ||type=='radio' ) { AddMoreCategory(); $('.addmore_link').show(); $('.dynamicRow_field').show();  }
	   
   }
  
  
  

function removeDocuments(id,main_id) {
	if(confirm('Are you sure you want to delete this document?')) {
	paramData = {'act':'deleteCategory','id':id};
	ajax({ 
		a:'documents_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		   
var res = data.split("::");  
alert(res[1]);	showAddEditDocuments(main_id);	 
		}});	
} }
 
  
  $(document).ready(function (e){   
$("form#documentsCategoryForm").on('submit',(function(e){
e.preventDefault();
	  err=0;
	 if($('#doc_name').val()=='' ){ err=1; $('#doc_name').css("border","1px solid #ff0000 "); } else{  $('#doc_name').css("border","");}
	 if($('#doc_desc').val()=='' ){ err=1; $('#doc_desc').css("border","1px solid #ff0000 "); } else{  $('#doc_desc').css("border","");}
	 
	 var doc_type =  $("input[name='doc_type']:checked").val();   
	 if(doc_type==undefined){ err=1; $('.error_msg').html("Select Document Type");  } else{  $('.error_msg').html('');  }
	 
	var form = $('#documentsCategoryForm');   
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
      showDocumentsList();
	 }});  

	  
 }  
}));
}); 
  
  
  </script>


 <style>
 .append_forms {  padding-top: 20px; padding-bottom:20px; }
.append_forms:nth-child(even) {background-color: #f2f2f2; padding-top: 20px; padding-bottom: 10px;}
 textarea{border:1px solid #cfcfcf}
 </style>
