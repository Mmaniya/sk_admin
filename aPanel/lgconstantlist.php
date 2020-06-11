<!--==============================
Name: Manikandan;
Create: 5/6/2020;
Update: 5/6/2020;
Use: View LG CONTSTANT Table 
================================-->
<?php
   $prev=$next=$last=$first='&nbsp;';
   if($page > 1)
   $first = "<i class='fa fa-fast-backward' aria-hidden='true' onclick='ShowParentCatListPagination(\"1\",\"".$filter_by."\",\"".$id."\")'/></i>";
   
   if($page < $totalPages)
   $last = "<i class='fa fa-fast-forward' aria-hidden='true' onclick='ShowParentCatListPagination(\"$totalPages\",\"".$filter_by."\",\"".$id."\")'/><i>";
   if(count($lgconstantlist)>0 && $totalPages > 1){
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
         <th scope="col">State ID</th>
         <th scope="col">District Name</th>
         <th scope="col">MP Constituency Name</th>
         <th scope="col">LG Constituency No</th>
         <th scope="col">LG Constituency Name</th>
         <th scope="col">Constituency Category</th>
         <th scope="col" style="text-align:center">Action</th>
      </tr>
   </thead>
   <tbody>
      <?php

         if( count($ListingParentCatListArr)>0) {
         	$i = 1;
            foreach($ListingParentCatListArr as $key=>$value) {
             $query = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'), 'condition' => array('id' => $value->district_id.'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
             $districtData = Table::getData($query);    
             $mpquery = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'),'condition' => array('id' => $value->mp_const_id.'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
             $mpConstantData = Table::getData($mpquery);  
         	?>	
      <tr>         
         <td><?php echo $i; ?></td>
         <td><?php  if( $value->state_id == '1' ) echo 'Tamilnadu'; ?></td>
         <td><?php  echo $districtData->district_name;  ?></td>
         <td><?php  echo $mpConstantData->bjp_mp_const_name; ?></td>
         <td><?php  echo $value->lg_const_number; ?></td>
         <td><?php  echo $value->lg_const_name; ?></td>
         <td><?php if($value->lg_const_category == 'P'){ echo 'PUBLIC'; } else if($value->lg_const_category == 'W') { echo 'WOMEN'; } else if($value->lg_const_category == 'R') { echo 'RESERVED'; }?></td>
         
         <td style="text-align:center">
         <?php if($value->status == 'A') { ?> <a href="javascript:void(0);" data-toggle="modal" onClick="openModelBox(<?php  echo $value->id; ?>)" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>&nbsp; <?php } ?>
            <?php if($value->status == 'A') { ?>
            <a href="javascript:void(0);" data-toggle="modal" onClick="deleteData(<?php  echo $value->id; ?>)" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>&nbsp;
            <?php } else { ?>
            <a href="javascript:void(0);" data-toggle="modal" onClick="restoreData(<?php  echo $value->id; ?>)" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> Restore</a>&nbsp;
            <?php } ?>
            <a href="javascript:void(0);" <?php if($value->status == 'A') { ?> class="btn btn-success btn-sm" <?php } else { ?> class="btn btn-danger btn-sm" <?php } ?> ><i class="fa fa-exclamation-circle" aria-hidden="true"> </i> <?php if($value->status == 'A') { ?> Active <?php } else { ?> Inactive <?php } ?></a></span>
          </td>
      </tr>
      <?php $i++; } 
         } else{ ?>
      <tr>
         <td colspan="7">No results Found
         <td>
      </tr>
      <?php } echo $table_val; ?>
   </tbody>
</table>
<script>	
   function ShowParentCatListPagination(page,condition,value) { 
      paramData = {'act':'parentListpagination','page':page,'filterby':value }; 
      ajax({
         a:"lgconstantajax",
         b: paramData,
         c:function(){},
         d:function(data){
               $('#myTable').html(data);
            } 
      });
   } 
   function openModelBox(id){
      paramData = {'id':id,'action':'edit'}
      ajax({
            a:"lgconstantmodel",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#modelview').html(data);
            }
      });          
   };
   function deleteData(id){
      paramData = {'id':id,'action':'delete'}
      ajax({
            a:"lgconstantmodel",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#modelview').html(data);
            }
      });          
   };
   function restoreData(id){
      paramData = {'id':id,'action':'restore'}
      ajax({
            a:"lgconstantmodel",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#modelview').html(data);
            }
      });          
   };
</script>

