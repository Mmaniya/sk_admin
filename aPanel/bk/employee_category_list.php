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
<div class="col-md-8 d-none d-sm-block">Category Name</div>
<!--<div class="col-md-6 d-none d-sm-block">Description</div>-->
<div class="col-md-3 d-none d-sm-block">Action</div>
</div>
<div class="col-md-12 d-none d-sm-block"><hr></div>

<?php   $i = 0;
 if(count($listingArr)>0) {
	   foreach($listingArr as $key=>$val) {			
  $bgColor='';
 if($val->status=='I') { $active_c = 'inActiveClass';  }
 if($val->status=='A') { $active_c = 'activeClass';  }    
 $bg='';  $i++;  
 
 if ($i % 2 == 1 && $i != count($rsServiceCat)) { $bg = ' rgba(0, 0, 0, 0.03)';   }
 
				
 ?>
<div class="row right_border tb_row" style="background-color:<?php echo $bg; ?> ">
 <div class="col-md-1 d-none d-sm-block"><?php echo $key+1;?></div>
  <div class="col-md-8 colBorder"><strong><?php echo $val->category_name.'&nbsp ('.$val->abbreviation.')';?></strong><br/><?php echo $val->description; ?></div>
  <!--<div class="col-md-5 colBorder"><?php echo $val->description; ?></div>-->
  <div class="col-md-3 colBorder"><a href="javascript:void(0)" class="a_tag" onclick="showAddEditEmployeeCat(<?php echo $val->id; ?>)">[edit]</a> 
				<a href="javascript:void(0)" class="a_tag" onclick="deleteServices(<?php echo $val->id; ?>)">[delete]</a>  
				<?php if($val->status=='I') { ?>
			    <a href="javascript:void(0)" class="inActiveClass" onclick="setActiveCategory(<?php echo $val->id; ?>)">[activate]</a>
				<?php } 
				 if($val->status=='A') { ?>
				  <a href="javascript:void(0)" class="activeClass" onclick="setActiveCategory(<?php echo $val->id; ?>)">[Inactivate]</a>
				 <?php } ?>
				 <input type="hidden" id="status_text_<?php echo $val->id; ?>" value="<?php echo $val->status; ?>"></div>
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
	 paramData = {'act':'show_category_list','page':page}
	ajax({ 
		a:'employee_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.table_div').html(data);		
		}});	
	}

function setActiveCategory(id) {
	 var status =  $('#status_text_'+id).val();
	var  setstatus='';
	 if(status=='A') { var setstatus = 'I'; }
	 if(status=='I') { var setstatus = 'A'; }
	paramData = {'act':'setActiveCategory','id':id,'status':setstatus};
	ajax({ 
		a:'employee_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		 	 showServiceCatList();
		}});	
}  


</script>