<?php 
$serviceId = $_POST['id'];
$btnName = $title = 'Add New ';
if($serviceId>0) { 
	$param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('*'),'condition'=>array('id'=>$serviceId.'-INT'));
	$rsService = Table::getData($param);
	foreach($rsService as $K=>$V)  $$K=$V;
}
?>

 <div class="card-box">
                                    <h4 class="m-t-0 header-title">Add Service Category</h4>
                                    <p class="text-muted font-14 m-b-20"></p>

                                   <form class="form-horizontal" role="form" id="service_category_form" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Category Name : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo $category_name; ?>">
                                            </div>
                                        </div>
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Abbreviation : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="abbreviation" id="abbreviation" value="<?php echo $abbreviation; ?>">
                                            </div>
                                        </div>
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Description : </label>
                                            <div class="col-md-5">
                                              <textarea name="description" id="description" style="width: 308px;"><?php echo $description; ?></textarea>
                                            </div>
                                        </div>
										
										 
										 
                                        
                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-md-9">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditServiceCat"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
								<script>
    
 
  
  $(document).ready(function (e){   
$("form#service_category_form").on('submit',(function(e){
e.preventDefault();
	  err=0;
	 if($('#category_name').val()=='' ){ err=1; $('#category_name').css("border","1px solid #F58634 "); } else{  $('#category_name').css("border","");}
	 
	 
	var form = $('#service_category_form');   
  if(err==0) {
	   $('.loading').show();
	   
   ajax({ 
  	a:'service_category',
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


 
