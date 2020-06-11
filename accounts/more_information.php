<?php

function main() { 		
 $lineItemId = $_REQUEST['ili'];


$param = array('tableName'=>TBL_INVOICE_LINE_ITEM,'fields'=>array('*'),'condition'=>array('id'=>$lineItemId.'-INT'),'showSql'=>'N');
$rsInvLItem = Table::getData($param);

$param = array('tableName'=>TBL_INVOICE,'fields'=>array('*'),'condition'=>array('id'=>$rsInvLItem->invoice_id.'-INT'),'showSql'=>'N');
$rsInvoices = Table::getData($param);  
?>
 <div class="row">
  <div class="col-md-12"><h1 class="heading">More Information</h1> </div> 
</div>
<div class="row">
  <div class="col-md-8">
    <div class="card h-100">
	<div class="card-header bg-primary text-white">
        <strong>Questionnaire Documents <?php echo $rsInvoices->id;?></strong>  
	
     </div> 	 
 <div class="card-body">  
    <div class="row">
    	<div class="col-md-8">
    		<div style="padding:10px;border-top:none;">  
 <table class="table">   
			<?php 
   
	  $file='';
 $param = array('tableName'=>TBL_QUESTIONNAIRE_DTLS,'fields'=>array('*'),'condition'=>array('invoice_line_item_id'=>$lineItemId.'-INT','document_type'=>'file-CHAR'),'showSql'=>'N');
     $rsQuesDtls = Table::getData($param);
	   
	  $serial_no=1;
	     if(count($rsQuesDtls)>0) { 
           foreach($rsQuesDtls as $K=>$V) {
             if($V->document_text!='') {	 
			  $sno=$serial_no++;
			  if(is_serialized($V->document_text)) { 			 
			      $isSerialized = unserialize($V->document_text);
  				  
 			  
              foreach($isSerialized as $key=>$val) { 
 	 
                  $document_name = ucwords(strtolower($V->document_name));	  
			     $fileName = strtolower($val);
				      $folder = getQuestSitePath($V->invoice_id,$V->invoice_line_item_id).$fileName;
					echo '<tr>  <td><a href="'.$folder.'" download>'.str_replace("-"," ",$document_name).'</a></td> 
		             <td><a style="text-transform: capitalize;" href="'.$folder.'" download>Download</a></td> </tr>';
 
}
			  
			  } else {
				   
			     $document_name = ucwords(strtolower($V->document_name));
				    $folder = getQuestSitePath($V->invoice_id,$V->invoice_line_item_id).$V->document_text;
					 
                 echo '<tr> <td><a href="'.$folder.'" download>'.str_replace("-"," ",$document_name).'</a></td> 
		             <td><a style="text-transform: capitalize;" href="'.$folder.'" download>Download</a></td> </tr>';
				  
			  } 			                   
			 } 		 
			   
		}  } else {
			echo '<h4>No Results</h4>';
			
		}
	      
    

  ?>
 </table>
            </div>
      </div>
    </div>   
  </div> 
</div>
</div>
<div class="col-md-4">
  <span class="right_bar_div"></span>
 </div>

</div>

<style>
 .btnLabel { cursor:pointer; font-size:16px;float:right;color:#fff !important;font-weight:600;background-color: #ff0000;
padding: 5px 15px;border-radius: 5px;margin-right:5px; }
</style>
 
<?php 
}
include "template.php";
?>