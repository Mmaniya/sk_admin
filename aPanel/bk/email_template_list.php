<?php 

 

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='vertical-align: initial;cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filterType."\",\"".$filterText."\",\"".$service_types."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='vertical-align: initial;cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\",\"".$filterText."\",\"".$service_types."\")'/>";
	if(count($rsServiceCat)>0 && $totalPages > 1){
	if($page > 1){
		$pageNo = $page - 1;
		$prev = "<img src='assets/images/prev_page.png' style='vertical-align: initial;cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$filterText."\",\"".$service_types."\")'/>";
	} 
		
	if ($page < $totalPages){
		$pageNo = $page + 1;
		$next = " <img src='assets/images/next_page.png' style='vertical-align: initial;cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$filterText."\",\"".$service_types."\")'/>";
	} 
	
	if($pageNo=='')
		$pageNo=1;
	if($totalPages>1) {
	$pagebox="<td style='border:0;'><input type='text' name='page' id='page' value='".$page."' onchange='ShowListPagination(this.value,\"".$filter_by."\",\"".$filterText."\",\"".$service_types."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center; width: 50px; height: 20px; vertical-align: middle;' size='4'> of $totalPages &nbsp; </td>";
	}	

	 $table_val = "<table class='' width='100%;padding:10px' cellpadding='5' cellspacing='0' border='0' style='border:0;><tr style='background-color:#fff'><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right'><table align='right' cellpadding='0' cellspacing='1'><tr style='background-color:#fff'><td style='padding:10px 12px;'>$first</td><td style='padding:10px 6px;'> $prev </td>$pagebox<td style='padding:10px 2px;'>$next </td><td style='padding:10px 12px;'>$last</td></tr></table></td></tr></table>";
} ?>
 

 
<div class="col-md-12"><hr></div>

<div class="row" style="font-weight:600">
<div class="col-md-1 d-none d-sm-block">#</div>
<div class="col-md-6 d-none d-sm-block">Template Name</div>
<!--<div class="col-md-6 d-none d-sm-block">Description</div>-->
<div class="col-md-4 d-none d-sm-block">Action</div>
</div>
<div class="col-md-12 d-none d-sm-block"><hr></div>

<?php    
 if(count($listingArr)>0) {
	   foreach($listingArr as $key=>$val) {			
        
				
 ?>
<div class="row right_border tb_row">
 <div class="col-md-1 d-none d-sm-block"><?php echo $key+1;?></div>
  <div class="col-md-6 colBorder"><strong><?php echo $val->template_name;?></strong><br/><small><?php echo $val->email_subject; ?></small></div>
  
  <div class="col-md-4 colBorder">
                <a href="javascript:void(0)" onclick="showAddEditEmailTemplate(<?php echo $val->id; ?>)">[edit]</a> 
    			<a href="javascript:void(0)" onclick="view_email_template(<?php echo $val->id; ?>)">[view]</a>
				<a href="javascript:void(0)" onclick="deleteEmailTemplate(<?php echo $val->id; ?>)">[delete]</a>  
			   </div>
</div> <div class="col-md-12"> </div>

 <?php } } else { ?> <div class="col-md-12">No results</div><?php } ?>
 <?php  if($table_val!='') { echo  $table_val; } ?>
  
 <style> .tb_row { padding:15px 10px; border-bottom: 1px solid #0000002b; padding-top: 10px;}
  .tb_row:nth-child(odd) {background-color: rgba(0, 0, 0, 0.03) !important;} 
  
 

 .right_border .colBorder {   }
 .activeClass { color:#ff0000;  }
 .inActiveClass { color:#008000;   }
 
 </style>
 
 
<script> 
 
  function ShowListPagination(page) { 
	 paramData = {'act':'show_template_list','page':page}
	ajax({ 
		a:'email_template',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.table_div').html(data);		
		}});	
	}
 
function view_email_template(id) { 
	 paramData = {'act':'view_email_template','id':id}
	ajax({ 
		a:'email_template',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.right_bar_div').html(data);		
		}});	
	}
 

</script>