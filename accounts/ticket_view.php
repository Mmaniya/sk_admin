<?
function main() { 
     
		$clientId = $_SESSION['CLIENT_ID'];
		$param = array('tableName'=>TBL_CLIENTS,'fields'=>array('*'),'condition'=>array('id'=>$clientId.'-INT'),'showSql'=>'N');
		$rsClient = Table::getData($param);
	
	 $serviceCategoryObj = new ServiceCategory();
	 
	
	if($_POST['act']=='submitTicket') {
		ob_clean();
		$param=array();
		 
		$params = array('category_id','subject','message');
		foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
		
		 
		$param['client_id']= $_SESSION['CLIENT_ID']; 
		$param['message']= $_POST['message'];
		
		if(count($_FILES['files']['name'])>0) {
		foreach($_FILES['files']['name'] as $key=>$val) { 		
	$imagefile=$_FILES['files']['name'][$key]; 
	if($imagefile!='') {
	$expImage=explode('.',$imagefile);
	$imageExpType=$expImage[1];
	$date = date('m/d/Yh:i:sa', time());
	$rand=rand(10000,99999);
	$encname=$date.$rand;
	$service_files_serialize[] = $imageName=md5($encname).'.'.$imageExpType;
	$imagePath="../support_tickets/".$imageName;
	move_uploaded_file($_FILES["files"]["tmp_name"][$key],$imagePath);
		} }
	 }
		$param['files']= $imageName;
		
		$param['added_date'] = date('Y-m-d H:i:s',time());		
		$param['added_by']= $_SESSION['CLIENT_ID'];  
		echo $rsDtls = Table::insertData(array('tableName'=>TBL_TICKETS,'fields'=>$param,'showSql'=>'N')); 
		 
	
		exit();		
	}
	

 ?>

 <script type="text/javascript" src="../ckeditor/ckeditor.js"></script> 
<h1 class="heading">Tickets	  </h1> 
<div class="row">

 <div class="col-md-6">
    <div class="ticket_list_item"></div> 	 <br/>
 <span><a href="tickets.php" class="btn btn-danger" style="padding:5px">Open Ticket</a>	</span>
 </div>
	
	
  <div class="col-md-6">
     <div class="right_div">
   
	  </div> 
          </div>
		  
		  <script>
	

showTicketsList();
function showTicketsList() {
	paramData = {'act':'show_ticket_list'};
	ajax({ 
		a:'tickets',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.ticket_list_item').html(data); 
     }});	
}

function viewTickets(ticket_id,ticket_status) {
	$('.right_div').html('<h3>Loading...</h3>'); 
	paramData = {'act':'reply_tickets','ticket_id':ticket_id,'ticket_status':ticket_status};
	ajax({ 
		a:'tickets',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_div').html(data); 
     }});	
}

	
    var editor = CKEDITOR.replace('editor');
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
 
 
   
  $( "form#support_ticket_form" ).submit(function( event ) {
   event.preventDefault();
       
    err=0;
  if($('#category_id').val()=='' ){ err=1; $('#category_id').css("border","1px solid #ff0000 "); } else{  $('#category_id').css("border","");}
  if($('#subject').val()=='' ){ err=1; $('#subject').css("border","1px solid #ff0000 "); } else{  $('#subject').css("border","");}
 
var editorValue = editor.getData();

 if(editorValue=='' ){ err=1; $('#editor').css("border","1px solid #ff0000 ");  $('.editor_error').html('Enter Description'); } else{  $('#editor').css("border",""); $('.editor_error').html(''); }
   
		if(err==0) {
		   $.ajax({
		url: "tickets.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function(data){  
		var res = data.split("::");
		 alert(res[1]);   
		    $("#ticket_list_div").load(" #ticket_list_div");
                  $('form#support_ticket_form')[0].reset();

		},
		error: function(){} 	        
		});
		}


  });  
		
		
   
  
  </script>
<?php 	
}
include "template.php";

?>