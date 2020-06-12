<!--==============================
Name: Manikandan;
Create: 5/6/2020;
Update: 9/6/2020;
Use: View District Table 
================================-->
<?php
   $prev=$next=$last=$first='&nbsp;';
   if($page > 1)
   $first = "<i class='fa fa-fast-backward' aria-hidden='true' onclick='ShowParentCatListPagination(\"1\",\"".$filter_by."\",\"".$id."\")'/></i>";
   
   if($page < $totalPages)
   $last = "<i class='fa fa-fast-forward' aria-hidden='true' onclick='ShowParentCatListPagination(\"$totalPages\",\"".$filter_by."\",\"".$id."\")'/><i>";
   if(count($district_list)>0 && $totalPages > 1){
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
         <th>#</th>
         <th scope="col">STATE</th>
         <th scope="col">DISTRICT</th>
         <th scope="col">SHORTFORM</th>
         <th scope="col" style="text-align:center">ACTION</th>
      </tr>
   </thead>
   <tbody>
      <?php
         if( count($ListingParentCatListArr)>0) {
         	$i = 1;
         foreach($ListingParentCatListArr as $key=>$value) {
         	?>	
      <tr>
         <td><?php  echo $i; ?></td>
         <td><?php  if( $value->state_id == '1' ) echo 'Tamilnadu'; ?></td>
         <td> <?php if($value->status == 'A') { ?>
                          <a href="districtview.php?dist=<?php echo $value->id ?>" ><?php  echo $value->district_name; ?> (<?php  echo $value->district_name_ta ?>)</a>
         <?php } else { ?><a href="javascript:void(0);" data-toggle="modal" onClick="alertData()" data-target="#myModal"><?php  echo $value->district_name; ?> (<?php  echo $value->district_name_ta ?>)</a>
         <?php } ?>
          </td>
         <td><?php  echo $value->district_abbr; ?></td>
         <td style="text-align:center">
         <?php if($value->status == 'A') { ?> <a href="javascript:void(0);" data-toggle="modal" onClick="openModelBox(<?php  echo $value->id; ?>)" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>&nbsp; <?php } ?>
            <?php if($value->status == 'A') { ?>
            <a href="javascript:void(0);" data-toggle="modal" onClick="deleteData(<?php  echo $value->id; ?>)" data-target="#myModal" class="btn btn-warning btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>&nbsp;
            <?php } else { ?>
            <a href="javascript:void(0);" data-toggle="modal" onClick="restoreData(<?php  echo $value->id; ?>)" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> Restore</a>&nbsp;
            <?php } ?>
            <a href="javascript:void(0);" <?php if($value->status == 'I') { ?> class="btn btn-danger btn-sm" ><i class="fa fa-exclamation-circle" aria-hidden="true"> </i>  Inactive <?php } ?></a></span>
          </td>
      </tr>
      <?php $i++; } 
         } else{ ?>
      <tr>
         <td colspan="5">No results Found
         <td>
      </tr>
      <?php } echo $table_val; ?>
   </tbody>
</table>
<script>	
   function alertData(){
   // alert('Not Allowed. District Deactivated.!');
   paramData = {'action':'alertBox'}
      ajax({
            a:"districtmodel",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#modelview').html(data);
            }
      });          

}
   function ShowParentCatListPagination(page,condition,value) { 
      paramData = {'act':'parentListpagination','page':page,'filterby':value }; 
      ajax({
         a:"districtajax",
         b: paramData,
         c:function(){},
         d:function(data){
               $('#myTable').html(data);
            } 
      });
   } 
   function openModelBox(id){
      paramData = {'dist_ID':id,'action':'edit'}
      ajax({
            a:"districtmodel",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#modelview').html(data);
            }
      });          
   };
   function deleteData(id){
      paramData = {'dist_ID':id,'action':'delete'}
      ajax({
            a:"districtmodel",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#modelview').html(data);
            }
      });          
   };
   function restoreData(id){
      paramData = {'dist_ID':id,'action':'restore'}
      ajax({
            a:"districtmodel",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#modelview').html(data);
            }
      });          
   };

</script>

