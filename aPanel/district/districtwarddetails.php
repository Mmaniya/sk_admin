<!--==============================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 12/6/2020;
   Use: View Ward Details Table 
   ================================-->
   <?php
   $prev=$next=$last=$first='&nbsp;';
   if($page > 1)
   $first = "<i class='fa fa-fast-backward' aria-hidden='true' onclick='ShowParentCatListPagination(\"1\",\"".$filter_by."\",\"".$id."\")'/></i>";
   
   if($page < $totalPages)
   $last = "<i class='fa fa-fast-forward' aria-hidden='true' onclick='ShowParentCatListPagination(\"$totalPages\",\"".$filter_by."\",\"".$id."\")'/><i>";
   if(count($ward_list)>0 && $totalPages > 1){
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
         <th scope="col">Ward Name</th>
         <th scope="col">Total Office Bearers</th>
         <!-- <th scope="col">Total Shakti Kendram</th> -->
         <th scope="col">Total Booths</th>
         <th scope="col">Verified/Unverified Members</th>
      </tr>
   </thead>
   
   <tbody>
      <?php
         if( count($ListingParentCatListArr)>0) {
         	$i = 1;
               foreach($ListingParentCatListArr as $key=>$value) {
                $skquery = array('tableName' => TBL_BJP_SK, 'fields' => array('*'),'condition' => array('ward_id' => $value->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
                $sk_list = Table::getData($skquery);
                $boothquery = array('tableName' => TBL_BJP_BOOTH, 'fields' => array('*'),'condition' => array('ward_id' => $value->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
                $booth_list = Table::getData($boothquery);
                $memberquery = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('ward_id' => $value->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
                $member_list = Table::getData($memberquery);
                $verifiedquery = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('ward_id' => $value->id.'-INT','is_verified'=>'Y-CHAR','status'=> 'A-CHAR'), 'showSql' => 'N');
                $verifiedmember = Table::getData($verifiedquery); 
                $officebearers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('ward_id' => $value->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'n');
                $officeberasList = Table::getData($officebearers);                 
         	?>	
      <tr align="center">
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateWard(<?php  echo $value->id; ?>)" ><?php  echo $value->ward_number; ?></a></td>
         <td><a href="javascript:void(0);"><?php  echo count($officeberasList); ?></a></td>
         <!-- <td><a href="javascript:void(0);"><?php // echo count($sk_list); ?></a></td> -->
         <td><a href="javascript:void(0);"><?php  echo count($booth_list); ?></a></td>
         <td style="text-align:center"><a href="javascript:void(0);"><?php  echo count($verifiedmember); echo ' / '; echo count($member_list); ?></a></td>
      </tr>
      <?php $i++; } 
         } else{ ?>
      <tr>
         <td colspan="2">No results Found
      </tr>
      <?php } echo $table_val; ?>
   </tbody>
</table>
<script>
   function getStateWard(id){
      paramData = {'act':'MandalWardDetails','wardId':id}; 
         ajax({
            a:"districtajax",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#wardFullDetails').html(data);
            }
      });
   }
</script>