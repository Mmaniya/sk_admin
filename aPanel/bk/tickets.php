<?php function main() { 

$ticketsObj = new tickets;

if($_POST['act']=='reply_tickets') {
 ob_clean();
   include 'tickets_reply.php';
 exit();	
}

if($_POST['act']=='show_ticket_list') {
 ob_clean();
   include 'ticket_list.php';
 exit();	
}


if($_POST['act']=='submitReplyTicket') {
		ob_clean();
		$param=array();
		 
			$param1 = array('tableName'=>TBL_TICKETS,'fields'=>array('*'),'condition'=>array('id'=>$_POST['ticket_id'].'-INT'));
			$rsPTicket = Table::getData($param1);
			$param['subject']= $rsPTicket->subject; 	
			 $param['invoice_id']= $rsPTicket->invoice_id; 			
            $param['category_id']= $rsPTicket->category_id; 			
            $param['invoice_line_item_id']= $rsPTicket->invoice_line_item_id; 	
			
			if($rsPTicket->parent_id==0) { 	             		
			$param['parent_id']= $_POST['ticket_id']; 
			$param['root_parent_id']= $_POST['ticket_id']; }
			else  { 			 
			$param['parent_id']= $_POST['ticket_id']; 
			$param['root_parent_id']= $rsPTicket->root_parent_id;
			}
		
		
		$param['message']= $_POST['message'];
		$param['user_id']=$_SESSION['user_id'];  
		$param['ticket_by']='U';
		
		if(count($_FILES['files']['name'])>0) {
		foreach($_FILES['files']['name'] as $key=>$val) { 		
	$imagefile=$_FILES['files']['name'][$key]; 
	if($imagefile!='') {
	$expImage=explode('.',$imagefile);
	$imageExpType=$expImage[1];
	$date = date('m/d/Yh:i:sa', time());
	$rand=rand(10000,99999);
	$encname=$date.$rand;
	$imageName=md5($encname).'.'.$imageExpType;
	$imagePath="../support_tickets/".$imageName;
	move_uploaded_file($_FILES["files"]["tmp_name"][$key],$imagePath); 	
	$param['files']= $imageName;
		} }
	 } 
		$param['added_date'] = date('Y-m-d H:i:s',time());		
		$param['added_by']= $_SESSION['id'];  
		echo $rsDtls = Table::insertData(array('tableName'=>TBL_TICKETS,'fields'=>$param,'showSql'=>'N')); 
		 
		 $param=array();
	
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$param['user_id']=$_SESSION['id'];  
		$where= array('id'=>$_POST['ticket_id']);
		  $rsDtls = Table::updateData(array('tableName'=>TBL_TICKETS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		
		
		$explode = explode('::',$rsDtls);  
		 
		 $ticketId = $explode[2]; 
		  if($_POST['ticket_id']=='') {
				$tickets_to = 'C';
				$ticketType = 'reply';
			 
				include 'ticket_send_email.php';
				
				$tickets_to = 'U';
				$ticketType = 'reply';
				include  'ticket_send_email.php';

		  
		  } else {
				$tickets_to = 'U';
				$ticketType = 'create'; 
				include  'ticket_send_email.php';
		 
		 		$tickets_to = 'C';
				$ticketType = 'create'; 
				include  'ticket_send_email.php'; 
				}
				
		exit();		
	}
	
	
	if($_POST['act']=='update_ticket_status') {
		ob_clean();
		 
		$param['user_id']=$_POST['user_id'];   
		$param['ticket_status']=$_POST['ticket_status'];  
		
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$param['updated_by']= $_SESSION['user_id'];  
		$where= array('id'=>$_POST['update_ticket_id']);
		echo Table::updateData(array('tableName'=>TBL_TICKETS,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
		exit();	
	}
	
?>


	<div class="row">
	<div class="col-sm-12">
		<div class="page-title-box">
			<h4 class="page-title">Tickets</h4>
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
				<li class="breadcrumb-item active">Tickets</li>
			</ol>
			<div class="clearfix"></div>
		</div>
	</div>
	</div>

<?php 
$ticketStatusCount = $ticketsObj->getTicketStatusCount();

 ?>
<div class="row">
   <div class="col-2 col-lg-2">
              <div class="card shadow-1">
                <div class="card-body"> 
				    <a href="tickets_view.php?ticket_status=O">
                    <h5 class="text-center">Open</h5>                     
                  <div class="text-center my-2">
                    <div class="text-info" style="font-size:60px;"><?php echo $ticketStatusCount->total_Open; ?></div>
                    <span class="fw-400 text-muted">Total</span>
                  </div> </a>
                </div>
                
              </div>
            </div>
			
			
			 <div class="col-2 col-lg-2">
              <div class="card shadow-1">
                <div class="card-body">
				     <a href="tickets_view.php?ticket_status=I">            
                    <h5 class="text-center">In Progress</h5>                     
                  <div class="text-center my-2">
                    <div class="text-info" style="font-size:60px;"><?php echo $ticketStatusCount->total_InProgress; ?></div>
                    <span class="fw-400 text-muted">Total</span>
                  </div></a>
                </div>
                
              </div>
            </div>
			
			
			 <div class="col-2 col-lg-2">
              <div class="card shadow-1">
                <div class="card-body">
				     <a href="tickets_view.php?ticket_status=R">
                     <h5 class="text-center">Resolved</h5>
                  <div class="text-center my-2">
                    <div class="text-info" style="font-size:60px;"><?php echo $ticketStatusCount->total_Resolved; ?></div>
                    <span class="fw-400 text-muted">Total</span>					 
                  </div> </a>
                </div>
                
              </div>
            </div>
			
			 <div class="col-2 col-lg-2">
              <div class="card shadow-1">
                <div class="card-body"> 
				    <a href="tickets_view.php?ticket_status=NR">
                     <h5 class="text-center"> Not Resolved</h5>                                       
                  <div class="text-center my-2">
                    <div class="text-info" style="font-size:60px;"><?php echo $ticketStatusCount->total_NotResolved; ?></div>
                    <span class="fw-400 text-muted">Total</span>
                  </div> </a>
                </div>                
              </div>
            </div>
			
			 <div class="col-2 col-lg-2">
              <div class="card shadow-1">
                <div class="card-body"> 
				     <a href="tickets_view.php?ticket_status=C">    
                    <h5 class="text-center">Closed</h5>                                      
                  <div class="text-center my-2">
                    <div class="text-info" style="font-size:60px;"><?php echo $ticketStatusCount->total_Closed; ?></div>
                    <span class="fw-400 text-muted">Total</span>
                  </div> </a>
                </div>                
              </div>
            </div>
			
			
			
			
            </div>



<?php } include 'template.php'; ?>