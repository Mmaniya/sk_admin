<?php 

 

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='vertical-align: initial;cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filterType."\",\"".$filterText."\",\"".$service_types."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='vertical-align: initial;cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\",\"".$filterText."\",\"".$service_types."\")'/>";
	if(count($rsLibrary)>0 && $totalPages > 1){
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
} 
   
	$param1 = array('tableName'=>TBL_LIBRARY_CATEGORY,'fields'=>array('*'),'showSql'=>'N','condition'=>array('id'=>$filterType.'-INT'));
	$rsLibCategory1 = Table::getData($param1);

?>
 
<div class="library_list_span">

 <div class="row">
    <div class="col-lg-6"> <strong> Category : <?php echo $rsLibCategory1->category_name; ?> </strong></div>
    <div class="col-lg-6"><a href="javascript:void(0)" onclick="showAddEditLibrary(0,<?php echo $filterType; ?>)" style="float:right">Add New</a></div> 
 </div>
								
<div class="col-md-12"><hr></div>

<div class="row" style="font-weight:600">
<div class="col-md-1 d-none d-sm-block">#</div>
<div class="col-md-2 d-none d-sm-block">Title</div>
<div class="col-md-6 d-none d-sm-block">Content</div>
<div class="col-md-3 d-none d-sm-block">Action</div>
</div>
<div class="col-md-12 d-none d-sm-block"><hr></div>

<?php   $i = 0;
 if(count($listingArr)>0) {
	   foreach($listingArr as $key=>$val) {			
  $bgColor='';
   
 $bg='';  $i++;  
 
 if ($i % 2 == 1 && $i != count($rsLibrary)) { $bg = ' rgba(0, 0, 0, 0.03)';   }
 
 $param = array('tableName'=>TBL_LIBRARY_CATEGORY,'fields'=>array('*'),'condition'=>array('id'=>$val->lib_category_id.'-CHAR'));
	$rsLibCategory = Table::getData($param);
				
 ?>
<div class="row right_border tb_row" style="background-color:<?php echo $bg; ?> ">
 <div class="col-md-1 d-none d-sm-block"><?php echo $key+1;?></div>
  <div class="col-md-2 colBorder"><?php echo $val->title; ?> </div>
  <div class="col-md-6 colBorder"><small><?php echo $val->content; ?></small> </div>
  <div class="col-md-3 colBorder"><a href="javascript:void(0)" class="a_tag" onclick="showAddEditLibrary(<?php echo $val->id; ?>,<?php echo $val->lib_category_id; ?>)">[edit]</a> 
   <a href="javascript:void(0)" class="a_tag" onclick="deleteLibrary(<?php echo $val->id; ?>,<?php echo $val->lib_category_id; ?>)">[delete]</a></div>
</div>  

 <?php } } else { ?> <div class="col-md-12">No results</div><?php } ?>
 <?php  if($table_val!='') { echo  $table_val; } ?>
  
 <style> .tb_row { padding:15px 10px; border-bottom: 1px solid #0000002b; padding-top: 10px;}
  .tb_row:nth-child(odd) {background-color: rgba(0, 0, 0, 0.03) !important;} 
  
 

 .right_border .colBorder {   }
 .activeClass { color:#ff0000;  }
 .inActiveClass { color:#008000;   }
 .library_list_span { background-color:#ffffff;padding:20px;}
 </style>
 </div>
 
<script> 
 
  function ShowListPagination(page,filterType) { 
	 paramData = {'act':'show_category_list','page':page,'category_id':filterType}
	ajax({ 
		a:'library_category',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.right_bar_div').html(data);		
		}});	
	}

 function showAddEditLibrary(id,category_id) {
	paramData = {'act':'add_edit_library','id':id,'category_id':category_id};
	ajax({ 
		a:'library',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		  $('.right_bar_div').html(data);			  
		}});	
}

function deleteLibrary(id,category_id) {
	if(confirm('Are you sure you want to delete this Library?')) {
	paramData = {'act':'deleteLibrary','id':id};
		 
	ajax({ 
		a:'library',
		b:$.param(paramData),
		c:function(){},
		d:function(data){
		 viewLibrary(category_id);	
var res = data.split("::");
alert(res[1]);		 
		}});	
} }

</script>