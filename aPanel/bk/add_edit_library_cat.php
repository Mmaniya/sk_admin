<?php 
$libCategoryId = $_POST['id'];
$btnName = $title = 'Add New ';
if($libCategoryId>0) { 
	$param = array('tableName'=>TBL_LIBRARY_CATEGORY,'fields'=>array('*'),'condition'=>array('id'=>$libCategoryId.'-INT'));
	$rsCategory = Table::getData($param);
	foreach($rsCategory as $K=>$V)  $$K=$V;
}
?>

 <div class="card-box">
                                    <h4 class="m-t-0 header-title">Add Library Category</h4>
                                    <p class="text-muted font-14 m-b-20"></p>

                                   <form class="form-horizontal" role="form" id="library_category_form" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Category Name : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo $category_name; ?>">
                                            </div>
                                        </div>
										
										 
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Description : </label>
                                            <div class="col-md-5">
                                              <textarea name="category_desc" id="category_desc" style="width: 308px;"><?php echo $category_desc; ?></textarea>
                                            </div>
                                        </div>
										 
                                        
                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-md-9">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditLibraryCat"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
								<script>
    
 
  
  $(document).ready(function (e){   
$("form#library_category_form").on('submit',(function(e){
e.preventDefault();
	  err=0;
	 if($('#category_name').val()=='' ){ err=1; $('#category_name').css("border","1px solid #F58634 "); } else{  $('#category_name').css("border","");}
	 
	 
	var form = $('#library_category_form');   
  if(err==0) {
	   $('.loading').show();
	   
   ajax({ 
  	a:'library_category',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){    showServiceCatList();
      var res = data.split("::");
       alert(res[1]);
      $('.right_bar_div').html('');
      
	 }});  

	  
 }  
}));
}); 
  
  
  </script>


 
