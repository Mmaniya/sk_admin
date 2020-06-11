<?php 
$discountId = $_POST['id'];
$btnName = $title = 'Add New ';
$discount_type = 'P';
if($discountId>0) { 
	$param = array('tableName'=>TBL_DISCOUNT,'fields'=>array('*'),'condition'=>array('id'=>$discountId.'-INT'));
	$rsService = Table::getData($param);
	foreach($rsService as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit New ';
}
?>

 <div class="card-box">
                                    <h4 class="m-t-0 header-title"><?php echo $btnName; ?></h4>
                                    <p class="text-muted font-14 m-b-20"></p>

                                   <form class="form-horizontal" role="form" id="discount_form" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Discount Name : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="discount_name" id="discount_name" value="<?php echo $discount_name; ?>">
                                            </div>
                                        </div>
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Discount Code : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="discount_code" id="discount_code" value="<?php echo $discount_code; ?>">
                                            </div>
                                        </div>
																				
										 
										  <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Discount Type : </label>
                                            <div class="col-md-5">
                                                <input type="radio" name="discount_type" value="P" <?php if($discount_type=='P') { echo 'checked'; } ?>> Percentage
                                                <input type="radio" name="discount_type" value="F" <?php if($discount_type=='F') { echo 'checked'; } ?>> Flat
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                            <label class="col-md-3 col-form-label">Discount value : </label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="discount_value" id="discount_value" value="<?php echo $discount_value; ?>">
                                            </div>
                                        </div>
										
										 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Vaild : </label>
                                            <div class="col-md-3"> From
                                                <input type="text" class="form-control datepicker" name="valid_from" id="valid_from" value="<?php echo $valid_from; ?>">
                                            </div>
											
											 <div class="col-md-3"> To 
                                                <input type="text" class="form-control datepicker"  name="valid_to" id="valid_to" value="<?php echo $valid_to; ?>">
                                            </div>
                                        </div>
											
											
											 <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Description : </label>
                                            <div class="col-md-5">
                                              <textarea name="discount_desc" id="discount_desc" style="width: 308px;"><?php echo $discount_desc; ?></textarea>
                                            </div>
                                        </div>
										
                                        
                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-md-9">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditDiscount"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
								<script>
    
 $( function() {
    $( ".datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
    });
  } );
  
  $(document).ready(function (e){   
$("form#discount_form").on('submit',(function(e){
e.preventDefault();
	  err=0;
	 if($('#discount_name').val()=='' ){ err=1; $('#discount_name').css("border","1px solid #F58634 "); } else{  $('#discount_name').css("border","");}
	 if($('#discount_code').val()=='' ){ err=1; $('#discount_code').css("border","1px solid #F58634 "); } else{  $('#discount_code').css("border","");}
	 if($('#discount_value').val()=='' ){ err=1; $('#discount_value').css("border","1px solid #F58634 "); } else{  $('#discount_value').css("border","");}
	 if($('#valid_from').val()=='' ){ err=1; $('#valid_from').css("border","1px solid #F58634 "); } else{  $('#valid_from').css("border","");}
	 if($('#valid_to').val()=='' ){ err=1; $('#valid_to').css("border","1px solid #F58634 "); } else{  $('#valid_to').css("border","");}
		
	 
	 
	var form = $('#discount_form');   
  if(err==0) {
	   $('.loading').show();
	   
   ajax({ 
  	a:'discount',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){    showDiscountList();
      var res = data.split("::");
       alert(res[1]);
      $('.right_bar_div').html('');
      
	 }});  

	  
 }  
}));
}); 
  
  
  </script>


 
