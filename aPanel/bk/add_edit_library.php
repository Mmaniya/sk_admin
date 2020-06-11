<?php 
$libCategoryId = $_POST['id'];
$btnName = $title_label = 'Add New ';
$lib_category_id = $_POST['category_id'];
if($libCategoryId>0) { 
	$param = array('tableName'=>TBL_LIBRARY,'fields'=>array('*'),'condition'=>array('id'=>$libCategoryId.'-INT'));
	$rsCategory = Table::getData($param);
	foreach($rsCategory as $K=>$V)  $$K=$V;
}
?>

 <div class="card-box">
                                    <h4 class="m-t-0 header-title">Add Library Category</h4>
                                    <p class="text-muted font-14 m-b-20"></p>

                                   <form class="form-horizontal" role="form" id="library_form" enctype="multipart/form-data">
								   
								    <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Category Name : </label>
                                            <div class="col-md-5">
                                                <select name="lib_category_id" id="lib_category_id" class="form-control">
												<option value=''>select category</option>
					<?php $param = array('tableName'=>TBL_LIBRARY_CATEGORY,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'));
					$rsLibCategory = Table::getData($param);
					if(count($rsLibCategory)) {
					foreach($rsLibCategory as $key=>$val) { $selected='';
						if($val->id==$lib_category_id) { $selected ='selected'; }
					?>
					<option value="<?php echo $val->id; ?>" <?php echo $selected; ?>><?php echo $val->category_name; ?></option>
					<?php } } else { echo '<option>No Category found</option>'; }?>
												</select>
                                            </div>
                                        </div>
										
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Title : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="title" id="title" value="<?php echo $title; ?>">
                                            </div>
                                        </div>
										
										 
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Content : </label>
                                            <div class="col-md-8">
                                              <textarea name="content" id="content" class="form-control" style="height:300px"><?php echo $content; ?></textarea>
                                            </div>
                                        </div>
										                                         
                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-md-9">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditLibrary"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
								<script>
    
 
  
  $(document).ready(function (e){   
$("form#library_form").on('submit',(function(e){
e.preventDefault();
	  err=0;
	 if($('#lib_category_id').val()=='' ){ err=1; $('#lib_category_id').css("border","1px solid #F58634 "); } else{  $('#lib_category_id').css("border","");}
	 if($('#title').val()=='' ){ err=1; $('#title').css("border","1px solid #F58634 "); } else{  $('#title').css("border","");}
	 if($('#content').val()=='' ){ err=1; $('#content').css("border","1px solid #F58634 "); } else{  $('#content').css("border","");}
	 var lib_category_id = $('#lib_category_id').val();
	 
	var form = $('#library_form');   
  if(err==0) {
	   $('.loading').show();
	   
   ajax({ 
  	a:'library',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){    
      var res = data.split("::");
       alert(res[1]); 
      $('.right_bar_div').html('');
      viewLibrary(lib_category_id);
	 }});  

	  
 }  
}));
}); 
   function viewLibrary(id) {
	paramData = {'act':'show_library_list','category_id':id};
	ajax({ 
		a:'library',
		b:$.param(paramData),
		c:function(){},
		d:function(data){    
		  $('.right_bar_div').html(data);			  
		}});	
}
  
  </script>


 
