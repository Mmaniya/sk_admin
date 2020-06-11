<?php 
 

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filter_by."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\")'/>";
	if(count($rsDocuments)>0 && $totalPages > 1){
	if($page > 1){
		$pageNo = $page - 1;
		$prev = "<img src='assets/images/prev_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\")'/>";
	} 
		
	if ($page < $totalPages){
		$pageNo = $page + 1;
		$next = " <img src='assets/images/next_page.png' style='cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\")'/>";
	} 
	
	if($pageNo=='')
		$pageNo=1;
	if($totalPages>1) {
	$pagebox="<td style='border:0;'>&nbsp;<input type='text' name='page' id='page' value='".$page."' onchange='ShowListPagination(this.value,\"".$filter_by."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center; width:50px; height:20px; vertical-align: middle;' size='4'> of $totalPages&nbsp;</td>";
	}	

	$table_val = "<table class='' width='100%;padding:10px' cellpadding='5' cellspacing='0' border='0' style='border:0;><tr style='background-color:#fff'><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right'><table align='right' cellpadding='0' cellspacing='1'><tr style='background-color:#fff'><td style='padding:10px 12px;'>$first</td><td style='padding:10px 6px;'> $prev </td>$pagebox<td style='padding:10px 2px;'>$next </td><td style='padding:10px 12px;'>$last</td></tr></table></td></tr></table>";
}  ?>

<div class="col-md-12"><hr></div>
<div class="row" style="font-weight:600">
<div class="col-md-1 d-none d-sm-block">#</div>
<div class="col-md-5 d-none d-sm-block">Document Name</div>
<div class="col-md-3 d-none d-sm-block">Document Type</div>
<div class="col-md-3 d-none d-sm-block">Action</div>
</div>
<div class="col-md-12 d-none d-sm-block"><hr></div>

 <?php   
	  if(count($listingArr)>0) {
	   foreach($listingArr as $key=>$val) { ?>
	   
<div class="row tb_row">
<div class="col-md-1 d-none d-sm-block"><?php echo $key+1;?></div>
<div class="col-md-5"><strong><?php echo $val->doc_name; ?></strong>
<p><?php echo $val->doc_desc; ?></p>
</div> 
<div class="col-md-3"><?php echo $val->doc_type; ?></div>
 
 <div class="col-md-3"> 
   <a href="javascript:void(0)" onclick="showAddEditDocuments(<?php echo $val->id; ?>)">[edit]</a>  
   <a href="javascript:void(0)" onclick="deleteDocuments(<?php echo $val->id; ?>)">[delete]</a>
  <?php if($val->doc_type=='multiple') { ?> <br/><a style="color:#000;" href="javascript:void(0)" onclick="showAddNewDocument(<?php echo $val->id; ?>,0)">[add new field]</a> <?php } ?>
 </div> <?php if($val->doc_type=='multiple' || $val->doc_type=='select' || $val->doc_type=='radio') {  ?>
 <div class="col-md-1"></div>
 <div class="col-md-8" style="background-color: #039cfd4d;padding: 15px;">
 <?php  $param = array('tableName'=>TBL_DOCUMENTS,'fields'=>array('*'),'condition'=>array('parent_id'=>$val->id.'-INT','status'=>'A-CHAR'));
	            $rsDocuments = Table::getData($param);
					if(count($rsDocuments)>0) {
                         foreach($rsDocuments as $K=>$V) {
							 ?>
    <div class="row"> 
	     <div class="col-md-4"><?php echo $V->doc_name; ?></div>
	     <div class="col-md-4"><?php echo $V->doc_type; ?></div>
	     <div class="col-md-4"><a style="color:#4c5667;" onclick="showAddNewDocument(<?php echo $val->id; ?>,<?php echo $V->id; ?>)" href="javascript:void(0)">[edit]</a> <a onclick="deleteDocuments(<?php echo $V->id; ?>);"  style="color:#4c5667;" href="javascript:void(0)">[delete]</a></div>
					</div>  <?php }  } ?>
  </div>  <?php } ?>
 
	 
	</div>
	 <?php } } else { ?>
	 <div class="col-md-12">No record found</div> <?php } ?>
	 <div class="col-md-12"><?php  if($table_val!='') { echo  $table_val; } ?></div>
	  <style>.tb_row { padding: 5px; border-bottom: 1px solid #0000002b; padding-top: 10px;}	
             .tb_row:nth-child(odd) {background-color: rgba(0, 0, 0, 0.03);} 
 </style>
 <script>
   function ShowListPagination(page) { 
	 paramData = {'act':'show_documents_list','page':page,}
	ajax({ 
		a:'documents_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.table_div').html(data);		
		}});	
	}
 </script>

