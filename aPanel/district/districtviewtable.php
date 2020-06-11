<!--==============================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 5/6/2020;
   Use: View Single District Table 
   ================================-->
   <?php
   $prev=$next=$last=$first='&nbsp;';
   if($page > 1)
   $first = "<i class='fa fa-fast-backward' aria-hidden='true' onclick='ShowParentCatListPagination(\"1\",\"".$filter_by."\",\"".$id."\")'/></i>";
   
   if($page < $totalPages)
   $last = "<i class='fa fa-fast-forward' aria-hidden='true' onclick='ShowParentCatListPagination(\"$totalPages\",\"".$filter_by."\",\"".$id."\")'/><i>";
   if(count($mandal_list)>0 && $totalPages > 1){
   if($page > 1){
   $pageNo = $page - 1;
   $prev = " <i class='fa fa-backward' aria-hidden='true'  onclick='ShowParentCatListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$id."\")'/></i>";
   }       		
   if ($page < $totalPages) {
   $pageNo = $page + 1;
   $next = " <i class='fa fa-forward' aria-hidden='true'  onclick='ShowParentCatListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$id."\")'/><i>";
   } 
    if($pageNo=='')
     $pageNo=1;
    if($totalPages>1) {
    $pagebox="<td style='padding:0px'><input type='text' name='page' id='page' value='".$page."' onchange='ShowParentCatListPagination(this.value,\"".$filter_by."\",\"".$id."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center;width:30%;height:30px' size='4'> of $totalPages</td>";
    }	
     $table_val = "<table  width='100%' cellpadding='5' cellspacing='0' border='0' style='border:0;'><tr><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right' style='padding-bottom:0px'><table align='right' cellpadding='0' cellspacing='1'><tr><td style='padding:0 2px;'>$first</td><td style='padding:0 2px;'> $prev </td>$pagebox<td style='padding:0 2px;'>$next </td><td style='padding:0 2px;'>$last</td></tr></table></td></tr></table>";
   }
   
   ?>
<table class="table table-hover" style="border: 2px solid #eee;" >
   <thead class="bg-primary text-white">
      <tr>
         <th scope="col">Mandal Name</th>
      </tr>
   </thead>
   <tbody>
      <?php
         if( count($ListingParentCatListArr)>0) {
         	$i = 1;
               foreach($ListingParentCatListArr as $key=>$value) {
         	?>	
      <tr>
         <td><a href="javascript:void(0);" onClick="openCard(<?php  echo $value->id; ?>)"><?php  echo $value->mandal_name; ?></a></td>
      </tr>
      <?php $i++; } 
         } else{ ?>
      <tr>
         <td colspan="2">No results Found
      </tr>
      <?php } echo $table_val; ?>
   </tbody>
   <input type="hidden" value="<?php echo $value->district_id; ?>" id="viewDistrictId">
</table>
<script type="text/javascript">
   function ShowParentCatListPagination(page,condition,value) { 
      var distid = $('#viewDistrictId').val();
      paramData = {'act':'childListpagination','page':page,'filterby':value,'viewedby':'mandal','districtID':distid }; 
      ajax({
         a:"districtajax",
         b: paramData,
         c:function(){},
         d:function(data){
               $('#mandaltable').html(data);
            } 
      });
   }
   function openCard(id){
      paramData = {'mandal_ID':id,'action':'mandalCard'}
      ajax({
            a:"districtmodel",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#mandaldetails').html(data);
            }
      });          
   };
   
   
</script>