<?php 
  $emailTempId = $_POST['id'];
$btnName = $title = 'Add New ';
if($emailTempId>0) { 
	$param = array('tableName'=>TBL_EMAIL_TEMPLATE,'fields'=>array('*'),'condition'=>array('id'=>$emailTempId.'-INT'));
	$rsEmailTemplate = Table::getData($param);
	foreach($rsEmailTemplate as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
}
?><style>.text-blue { color:#039cfd;font-size:20px; } .form-control { font-size:17px; height:auto; } </style>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
							 <div class="card">
							   <h4 class="card-header bg-primary text-white"><?php echo $btnName; ?> Email Template</h4>
								<p class="text-muted font-14 m-b-20"></p>
							   <div class="card-body"> 
                                   <form class="form-horizontal" role="form" id="email_template_form" enctype="multipart/form-data">
								   
								     <div class="form-group row">
								<label class="col-md-12 col-form-label text-blue"> Type : </label>
								<div class="col-md-6">
								<select name="email_type" id="email_type" class="form-control" onchange="sfrm(this.value)">
                                <option value="">Select Type</option>
                                <option value="G">General</option>
                                <option value="S">Services</option>
                                <option value="P">Payment</option>
                                <option value="O">Other</option>
								</select>
								   </div>
								<span class="error_type" style="color:#ff0000;"></span>
							</div>
							
								   
								   
							
							
								    <div class="form-group row" id="services_field" style="display:none">
									  <div class="col-md-4">
                                            <label class="col-md-12 col-form-label text-blue">Category : </label>
                                            <div class="col-md-12">
 <select name="service_category_id" id="service_category_id" class="form-control" onchange="get_service_list(this.value,'')">
 <option value="">Select category</option>
                                                 <?php 
   $param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('*'),'orderby'=>'category_name','sortby'=>'asc','condition'=>array('status'=>'A-CHAR'));
		$rsCategory = Table::getData($param);
		if(count($rsCategory)>0) {
		foreach($rsCategory as $key=>$val) { $selected=''; if($service_category_id==$val->id) { $selected ='selected'; }
		  echo '<option value='.$val->id.' '.$selected.'>'.$val->category_name.'</option>';
		
		} } else { echo 'No category '; } ?>
		</select>
                                            </div>
                                      </div>
									  
									   <div class="col-md-6">
									     <label class="col-md-12 col-form-label text-blue">Services : </label>
                                            <div class="col-md-12">
                                                <select name="service_id" id="service_id" class="form-control">
												<option value="">Select Services</option>
												</select>
                                            </div>
									   </div>
                                   </div>
										
								   
								   
							<div class="form-group row">
								<label class="col-md-12 col-form-label text-blue">Template Name : </label>
								<div class="col-md-12">
									<input type="text" class="form-control" name="template_name" id="template_name" value="<?php echo $template_name; ?>">
								</div>
							</div>
							
							 <div class="form-group row">                                           
								<div class="col-md-12"> <label class="col-form-label text-blue">Email Subject : </label>
									<input type="text" class="form-control" name="email_subject" id="email_subject" value="<?php echo $email_subject; ?>">
								</div>
							</div>
							
							 <div class="form-group row">                                            
								<div class="col-md-12"><label class="col-form-label text-blue">Email body : </label>
								  <textarea name="email_body" id="editor" ><?php echo $email_body; ?></textarea>
								</div>
							</div>
							
							
							<div class="form-group row">                                           
								<div class="col-md-12"> <label class="col-form-label text-blue">Spanish Email Subject : </label>
									<input type="text" class="form-control" name="spanish_email_subject" id="spanish_email_subject" value="<?php echo $spanish_email_subject; ?>">
								</div>
							</div>
							
							 <div class="form-group row">                                            
								<div class="col-md-12"><label class="col-form-label text-blue">Spanish Email body : </label>
								  <textarea name="spanish_email_body" id="editor2" ><?php echo $spanish_email_body; ?></textarea>
								</div>
							</div>
										
										
										
                           <div class="form-group row">                                           
								<div class="col-md-12"> <label class="col-form-label text-blue">Notes : </label>
									 <textarea name="notes" id="notes" class="form-control"><?php echo $notes; ?></textarea>
								</div>
							</div>
							
							  
                                        
                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-md-12" style="text-align:right">
											<input type="hidden" name="email_template_id" value="<?php echo $id;?>" id="email_template_id"/>
											<input type="hidden" name="act" value="addEditEmailTemplate"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Submit</button>
                                            &nbsp;<button type="button" onclick="closeForm()"  class="btn btn-danger waves-effect waves-light" style="float: right;">Close</button></div>
                                        </div>
                                    </form>
                                </div>
                                </div>
								
								<script>
				 
$('#email_type').val(<?php echo '"'.$email_type.'"';?>);
				sfrm(<?php echo '"'.$email_type.'"';?>);
	function sfrm(type) {
		$('#services_field').hide();
  if(type=='S') { $('#services_field').show(); }
	}		
								
 <?php if($id>0) { ?> get_service_list(<?php echo $service_category_id.','.$service_id;?>); <?php } ?>
	 
function get_service_list(id,service_id) { 
	 paramData = {'act':'show_service_list','id':id,'service_id':service_id}
	ajax({ 
		a:'email_template',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('#service_id').html(data);		
		}});	
	}
 
	
	
  var editor = CKEDITOR.replace('editor');
  var spanish = CKEDITOR.replace('editor2');
 CKEDITOR.editorConfig = function( config ) {
	    config.toolbarGroups = [
		 { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	];
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
   /* config.filebrowserBrowseUrl = '../ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
   config.filebrowserImageBrowseUrl = '../cckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
   config.filebrowserFlashBrowseUrl = '../cckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = '../cckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = '../cckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = '../cckeditor/kcfinder/upload.php?opener=ckeditor&type=flash'; */
};
  
  $(document).ready(function (e){   
$("form#email_template_form").on('submit',(function(e){
e.preventDefault();
	  err=0;
	  
	  for (instance in CKEDITOR.instances) {
    CKEDITOR.instances[instance].updateElement();
}

	 if($('#template_name').val()=='' ){ err=1; $('#template_name').css("border","1px solid #F58634 "); } else{  $('#template_name').css("border","");}
	 if($('#email_subject').val()=='' ){ err=1; $('#email_subject').css("border","1px solid #F58634 "); } else{  $('#email_subject').css("border","");}
	 
	
	var type = $('#email_type').val();
	if(type=='') { err=1; $('#email_type').css("border","1px solid #F58634 "); } else{  $('#email_type').css("border","");}
	
	if(type=='S') {
		if($('#category_id').val()=='' ){ err=1; $('#category_id').css("border","1px solid #F58634 "); } else{  $('#category_id').css("border","");}
	    if($('#service_id').val()=='' ){ err=1; $('#service_id').css("border","1px solid #F58634 "); } else{  $('#service_id').css("border","");}
	}
	
	
	var email_body = editor.getData();
	var spanish_email_body = spanish.getData();
	
	 	 
	 var form = $('#email_template_form');   
  if(err==0) {
	   $('.loading').show();
	  //paramData = {'act':'addEditEmailTemplate','template_name':template_name,'email_subject':email_subject,'email_body':email_body,'email_template_id':id,''} 
   ajax({ 
  	a:'email_template',
 // b:$.param(paramData),
 	b:form.serialize(),
  	c:function(){},
  	d:function(data){   showEmailTemplateList();
      var res = data.split("::");
       alert(res[1]);
      $('.right_bar_div').html('');
      
	 }});  
  
 }  
}));
}); 
  
  
 

function closeForm() {
	 $('.right_bar_div').html('');
	
}
 
  
  </script>


 
