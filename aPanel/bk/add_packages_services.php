<?php 
$packageId = $_POST['id'];
$btnName = $title = 'Add New ';
if($packageId>0) { 
	$param = array('tableName'=>TBL_PACKAGES,'fields'=>array('*'),'condition'=>array('id'=>$packageId.'-INT'));
	$rsService = Table::getData($param);
	foreach($rsService as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
}
?>
<script>function toggle(id) {  $('.package_service_type_'+id).toggle();  }</script>
 <div class="card-box">
                                    <h4 class="m-t-0 header-title"><?php echo $package_name; ?>  </h4>
                                    <p class="text-muted font-14 m-b-20"></p>

                                   <form class="form-horizontal" role="form" id="service_form" enctype="multipart/form-data">
								    
					   

								 <div class="form-group row">
									<label class="col-md-8 col-form-label" style="text-align:left;">Add Package Services  : </label> 									 
								</div>
										 <div class="form-group row">                                           
                                              <div class="col-md-12">
						<?php  
                               $category_id[]='';  $service_id[]='';
						if($id!='') { 
						$param = array('tableName'=>TBL_PACKAGE_SERVICES,'fields'=>array('*'),'condition'=>array('package_id'=>$id.'-INT'));
						$rsPackageServices = Table::getData($param);
						if(count($rsPackageServices)>0) {
					  foreach($rsPackageServices as $key=>$val) {
						         $categoryIds[] = $val->service_category_id;
						         $serviceIds[] = $val->service_id;
						} 
						
						$category_id =  implode(',',$categoryIds);   
						$category_id =  explode(',',$category_id);   


						$service_id =  implode(',',$serviceIds);   
						$service_id =  explode(',',$service_id);
						}

						
						}
					 
					 
						$param=array();
						$param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('*'),'condition'=>array('status'=>'A-CHAR'));
						$rsServiceCat = Table::getData($param);
										 
                                        if(count($rsServiceCat)>0) {
										foreach($rsServiceCat as $key=>$val) {
											  if (in_array($val->id, $category_id)) { 
											  $checked='checked'; echo '<script>   toggle('.$val->id.')</script>'; } 		else{   $checked='';	} 
											 ?>
					<input type="checkbox" name="service_categoty_id[]"  onclick="toggle(<?php echo $val->id;?>)"  value="<?php echo $val->id;?>" <?php   echo $checked;  ?>> <?php echo $val->category_name;?>  	<br/>	
                     <ul class="package_service_type_<?php echo $val->id; ?>" style="display:none"> 
						<?php $param = array('tableName'=>TBL_SERVICES,'fields'=>array('*'),'condition'=>array('service_category_id'=>$val->id.'-INT'));
						$rsServiceRes = Table::getData($param);
                       if(count($rsServiceRes)>0) {
                         foreach($rsServiceRes as $K=>$V) {  
						  $checked='';
       if (in_array($V->id, $service_id)) {   $checked='checked';   } 
   
		
						 ?>
					 <li style="border: 1px solid #c5b9b9;padding: 5px;margin-bottom: 3px;">
					 <input type="checkbox" name="service_id[][<?php echo $val->id;?>]" value="<?php echo $V->id;?>" <?php echo $checked; ?>>&nbsp;<?php echo $V->service_name?>
<span style="margin-left: 10%;">$ <input type="text" name="service_price[<?php echo $V->id;?>]"  value="<?php echo $V->service_price;?>" style="width:100px"/> </span> </li>
					 
					   <?php } } else { echo '<li>No services found</li>'; } ?></ul>	
									
                                         <?php }} ?> 
												<p class="error_msg_checkbox" style="color:#ff0000"></p>
                                             <span style="clear:both"></span>
                                             </div>
                                        </div>   
										
										
                                        <div class="form-group mb-0 justify-content-end row">
										 <div class="col-md-6 preview_button_div" style="text-align:left">
										   <button type="button" onclick="showAddEditForm(<?php echo $id;?>)"  class="btn btn-primary waves-effect waves-light">Back </button>
										  </div>
                                            <div class="col-md-6 preview_button_div">
											<input type="hidden" name="package_id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="add_package_services"/>
                                                <button type="submit"  class="btn btn-primary waves-effect waves-light">Submit </button>
                                            </div>
											
                                        </div>
                                    </form>
                                </div>
 <style>
.preview_button_div {
    background-color: #f18628b0;
    padding: 20px 7px 20px 17px;
    text-align: right;
}
</style>	
 <script>
 
	
   
  
  $(document).ready(function (e){   
$("form#service_form").on('submit',(function(e){
e.preventDefault();
	  err=0;
	  
	  
	 
	var form = $('#service_form');   
  if(err==0) {
	   $('.loading').show();
	   
	   $.ajax({
url: "package.php",
type: "POST",
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,
success: function(data){   
var res = data.split("::");
 //alert(res[1]); 
 alert('added successfully');
$('.right_bar_div').html('');
  show_package_list();
},
error: function(){} 	        
});

	  /*  ajax({ 
  	a:'services',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){    
    $('.test').html(data);
	 }});  */
 }  
}));
}); 
  
  
  </script>


 


<style> textarea{border:1px solid #cfcfcf;}
.col-form-label {text-align:right; }
@media screen and (max-width: 768px) {
	
	.paddingTop { margin-top:20px; }
	.removebtn { margin-top:10px; float:right; }
}</style>
