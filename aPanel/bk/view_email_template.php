<?php 
  $emailTempId = $_POST['id'];
$btnName = $title = 'Add New ';
if($emailTempId>0) { 
	$param = array('tableName'=>TBL_EMAIL_TEMPLATE,'fields'=>array('*'),'condition'=>array('id'=>$emailTempId.'-INT'));
	$rsEmailTemplate = Table::getData($param);
	foreach($rsEmailTemplate as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
}
   
   $param = array('tableName'=>TBL_SERVICES,'fields'=>array('id,service_name'),'condition'=>array('id'=>$service_id.'-INT'));
		$rsServices = Table::getData($param);
  
?><style>.text-blue { color:#039cfd;font-size:20px; } .form-control { font-size:17px; height:auto; } </style>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
 <div class="card">
                                    <h5 class="card-header bg-primary text-white"><?php echo $btnName; ?> Email Template</h5>
                                   <div class="card-body">  

                                   <form class="form-horizontal" role="form" id="email_template_form" enctype="multipart/form-data">
								    <div class="form-group row">
                                            <label class="col-md-12 col-form-label text-blue">Service Name : </label>  
                                            <div class="col-md-12 form-control">
                                                <?php echo $rsServices->service_name; ?>
                                            </div>
                                        </div>
										
                                        <div class="form-group row">
                                            <label class="col-md-12 col-form-label text-blue">Template Name : </label>  
                                            <div class="col-md-12 form-control">
                                                <?php echo $template_name; ?>
                                            </div>
                                        </div>
										
										 <div class="form-group row">
										  <label class="col-md-12 col-form-label text-blue">Email Subject : </label>                                       
                                            <div class="col-md-12 form-control"> 
                                               <?php echo $email_subject; ?>
                                            </div>
                                        </div>
										
										 <div class="form-group row">
										 <label class="col-md-12  col-form-label text-blue">Email body :  </label>                                              
                                            <div class="col-md-12 form-control">
                                            <?php echo htmlspecialchars_decode($email_body); ?>
                                            </div>
                                        </div>
										
										
										<div class="form-group row">       
                                             <label class="col-md-12 col-form-label text-blue">Spanish Email Subject :  </label>  										
                                            <div class="col-md-12 form-control">
                                            <?php echo $spanish_email_subject; ?>
                                            </div>
                                        </div>
										
										
										<div class="form-group row">     
                                             <label class="col-md-12 col-form-label text-blue">Spanish Email body :  </label>  										
                                            <div class="col-md-12 form-control">
                                            <?php echo htmlspecialchars_decode($spanish_email_body); ?>
                                            </div>
                                        </div>
										
										
										<div class="form-group row">
                                          <label class="col-md-12 col-form-label text-blue">Notes :  </label> 										
                                            <div class="col-md-12 form-control"> 
                                            <?php echo $notes; ?>
                                            </div>
                                        </div>
										
										 
										  
                                        
                                        <div class="form-group mb-0 justify-content-end row">
										 <div class="col-md-6"><button type="button" onclick="closeForm()"  class="btn btn-danger waves-effect waves-light">Close</button></div>
                                            
                                        </div>
                                    </form>
                                </div>
                                </div>
								
<script>
function closeForm() { $('.right_bar_div').html('');}
</script>


 
