<?php

$prev=$next=$last=$first='&nbsp;';

if($page > 1)
	$first = "<img src='assets/images/first_page.png' style='vertical-align: initial;cursor:pointer; margin-top:3px;' border='0'  onclick='ShowListPagination(\"1\",\"".$filterType."\",\"".$filterText."\",\"".$service_types."\")'/>";
	
	if($page < $totalPages)
	$last = "<img src='assets/images/last_page.png' style='vertical-align: initial;cursor:pointer; margin-top:3px;' border='0' onclick='ShowListPagination(\"$totalPages\",\"".$filter_by."\",\"".$filterText."\",\"".$service_types."\")'/>";
	if(count($rsServices)>0 && $totalPages > 1){
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


<table class="table table-bordered table-striped">
			<thead>
			<tr>
				<th style="width:10px;">#</th>
				<th>Services Name</th>
				<th>Price</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
   <?php  
	 if(count($listingArr)>0) {
	   foreach($listingArr as $key=>$val) {	

		$param=array();
		$param = array('tableName'=>TBL_SERVICE_CATEGORY,'fields'=>array('id,abbreviation'),'condition'=>array('id'=>$val->service_type.'-CHAR'));
		$rsServiceCat = Table::getData($param);
										?>
			<tr>
				<th><?php echo $key+1;?></th>
				<td><?php echo $val->service_name.'('.$rsServiceCat->abbreviation.')'; ?><br/><small><?php echo $val->service_description; ?></small></td>
				<td style="text-align:right;"><?php echo money($val->service_price,'$'); ?></td>
				<td> <a href="javascript:void(0)" onclick="showAddEditForm(<?php echo $val->id; ?>)">[edit]</a>  
				<a href="javascript:void(0)" onclick="deleteServices(<?php echo $val->id; ?>)">[delete]</a></td>
			</tr>                                   
	  <?php } } else { ?>
	  <tr><td colspan="4" style="text-align:center;">No recound found</td> </tr> <?php } ?>
			</tbody>
</table> <div class="row">
 <div class="col-md-12">
<?php  if($table_val!='') { echo  $table_val; } ?>
</div> </div>

<script>
 function ShowListPagination(page,filter_type,filter_text,service_types) { 
	 paramData = {'act':'searchForm','page':page,'filter_type':filter_type,'filter_text':filter_text,'service_types':service_types}
	ajax({ 
		a:'services',
		b:$.param(paramData),
		c:function(){},
		d:function(data){  
		  $('.table_div').html(data);		
		}});	
	}
</script>
