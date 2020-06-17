<?php 
   $prev=$next=$last=$first='&nbsp;';
   if($page > 1)
   $first = "<i class='fa fa-fast-backward' aria-hidden='true' onclick='ShowParentCatListPagination(\"1\",\"".$filter_by."\",\"".$id."\")'/></i>";
   
   if($page < $totalPages)
   $last = "<i class='fa fa-fast-forward' aria-hidden='true' onclick='ShowParentCatListPagination(\"$totalPages\",\"".$filter_by."\",\"".$id."\")'/><i>";
   if(count($wardFullDetails)>0 && $totalPages > 1){
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
   
   if( count($ListingParentCatListArr)>0) {
     $i = 1;
   foreach($ListingParentCatListArr as $key=>$value) {
   
     ?>
<style></style>
<div class="card">
   <div class="card-header bg-img"> WARD (<?php echo $value->ward_number; ?>) DETAILS</div>
   <input type="hidden" value="<?php echo $value->id ?>" id="officeBearersId">
   <div class="card-body row">
   <?php  $officebearers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('ward_id' => $value->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N','orderby' => 'role_hierarchy', 'sortby' => 'asc');
          $officeberasList = Table::getData($officebearers); 
    ?>
        <table class="table table-striped table-bordered" >
            <thead>
            <tr><th colspan='6' style="color:#ff9933">WARD INCHARGE</th></tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Role Hierarchy</th>
                    <th>address</th>
                    <th>Verified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php                 
                $i = 1; 
                foreach($officeberasList as $key =>$val) {
                    if($val->role_hierarchy == 'W'){
                    ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $val->person_name; if($val->person_name_ta !=''){ ?>(<?php echo $val->person_name_ta ?>)<?php } ?></td>
                    <td><?php echo $val->mobile_number ?></td>
                    <td><?php switch($val->role_hierarchy) { case "S" : echo 'STATE'; break; case "D" : echo 'DISTRICT'; break; case "M" : echo 'MANDAL'; break; case "W" : echo 'WARD'; break; case "SK" : echo 'SHAKTI KENDRAM'; break; case "B" : echo 'BOOTH'; break; } ?></td>
                    <td><?php echo $val->address ?></td>
                    <td><?php if($val->is_verified == 'N'){ echo '<p style="color:red;font-weight:700">NO</p>'; } else { echo '<p style="color:green;font-weight:700">YES</p>'; } ?></td>
                    <td><a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".deleteModel"  onclick="removeofficbearers(<?php echo $val->id ?>)" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>

                </tr>    
            <?php $i ++;} } ?>      
            </tbody>    
        </table>
        <table class="table table-striped table-bordered" >
            <thead >
            <tr><th colspan='6' style="color:#ff9933">SHAKTI KENDRAM</th></tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>address</th>
                    <th>Verified</th>
                    <th>Booth</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php                 
                $i = 1; 
                foreach($officeberasList as $key =>$val) {
                    if($val->role_hierarchy == 'SK'){
                    ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $val->person_name; if($val->person_name_ta !=''){ ?>(<?php echo $val->person_name_ta ?>)<?php } ?></td>
                    <td><?php echo $val->mobile_number ?></td>
                    <!-- <td><?php // switch($val->role_hierarchy) { case "S" : echo 'STATE'; break; case "D" : echo 'DISTRICT'; break; case "M" : echo 'MANDAL'; break; case "W" : echo 'WARD'; break; case "SK" : echo 'SHAKTI KENDRAM'; break; case "B" : echo 'BOOTH'; break; } ?></td> -->
                    <td><?php echo $val->address ?></td>
                    <td><?php if($val->is_verified == 'N'){ echo '<p style="color:red;font-weight:700">NO</p>'; } else { echo '<p style="color:green;font-weight:700">YES</p>'; } ?></td>
                    <td><?php 
                    $getbooth = 'select * from '.TBL_BJP_BOOTH.' where  `id` IN ('.$val->booth_id.') AND `status` ="A"';
                    $getboothList=dB::mExecuteSql($getbooth); 
                        foreach($getboothList as $key=>$value){
                               echo $value->booth_number; echo '<br>';
                        }
                    ?></td>
                    <td><a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".deleteModel"  onclick="removeofficbearers(<?php echo $val->id ?>)" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>    
            <?php $i ++;} } ?>      
            </tbody>    
        </table>
        <table class="table table-striped table-bordered" >
            <thead>
            <tr><th colspan='6' style="color:#ff9933">BOOTH INCHARGE</th></tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>address</th>
                    <th>Verified</th>
                    <th>Booth</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php                 
                $i = 1; 
                foreach($officeberasList as $key =>$val) {
                    if($val->role_hierarchy == 'B'){
                    ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $val->person_name; if($val->person_name_ta !=''){ ?>(<?php echo $val->person_name_ta ?>)<?php } ?></td>
                    <td><?php echo $val->mobile_number ?></td>
                    <td><?php echo $val->address ?></td>
                    <td><?php if($val->is_verified == 'N'){ echo '<p style="color:red;font-weight:700">NO</p>'; } else { echo '<p style="color:green;font-weight:700">YES</p>'; } ?></td>
                    <td><?php 
                    $getbooth = 'select * from '.TBL_BJP_BOOTH.' where  `id` IN ('.$val->booth_id.') AND `status` ="A"';
                    $getboothList=dB::mExecuteSql($getbooth); 
                        foreach($getboothList as $key=>$value){
                               echo $value->booth_number; echo '<br>';
                        }
                    ?></td>
                    <td><a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".deleteModel"  onclick="removeofficbearers(<?php echo $val->id ?>)" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>    
            <?php $i ++;} } ?>      
            </tbody>    
        </table>
        <table  class=" wardDetails table table-striped table-bordered" >
            <thead>
            <tr><th colspan='7' style="color:#ff9933">BOOTH DETAILS</th></tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Booth Number</th>
                    <th>Total Voters</th>
                    <th>Male Voters</th>
                    <th>Female Voters</th>
                </tr>
            </thead>
            <tbody>

            <?php 
             $boothquery = array('tableName' => TBL_BJP_BOOTH, 'fields' => array('*'),'condition' => array('ward_id' => $_POST['wardId'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
             $booth_list = Table::getData($boothquery);
            $i = 1; 

            foreach($booth_list as $key =>$val) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $val->booth_number ?></td>
                    <td><?php echo $val->total_voters ?></td>
                    <td><?php echo $val->male_voters_count ?></td>
                    <td><?php echo $val->female_voters_count ?></td>
                </tr>    
            <?php $i ++;} ?>      
            </tbody>    
        </table>
        <!-- <br><br>
        <table  class="wardDetails table table-striped table-bordered" >
            <thead>
            <tr><th colspan='5'>MEMBERS</th></tr>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Membership Number</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Verified</th>
                </tr>
            </thead>
            <tbody>

            <?php 
            //   $memberquery = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('ward_id' => $value->id.'-STRING','status'=> 'A-CHAR'), 'showSql' => 'N');
            //   $member_list = Table::getData($memberquery);
            // $i = 1; 
            ?><pre><?php// print_r( $booth_list) ?></pre><?php

            // foreach($member_list as $key =>$val) { ?>
                <tr>
                    <td><?php //echo $i; ?></td>
                    <td><?php //echo $val->member_name ?></td>
                    <td><?php //echo $val->membership_number ?></td>
                    <td><?php //echo $val->member_mobile ?></td>
                    <td><?php //echo $val->member_address ?></td>
                    <td><?php //if($val->is_verified == 'N'){ echo '<p style="color:red;font-weight:700">NO</p>'; } else { echo '<p style="color:green;font-weight:700">YES</p>'; } ?></td>
                </tr>    
            <?php //$i ++;} ?>      
            </tbody>    
        </table> -->
   </div>
</div>
<br>
<?php   } ?>
<?php } else{ ?>
<tr>
   <td colspan="5">No results Found<td>
</tr>
<?php } echo $table_val; ?>


<!-- Modal -->
<div class="modal fade deleteModel" role="dialog">
    <div class="modal-dialog">
        <span id="modelshow"></span>
    </div>
</div>


<script>
$(document).ready(function() {
    $('.wardDetails').DataTable( {
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );
function removeofficbearers(id){
    var wardId = $('#officeBearersId').val();
    paramData = {'ofid':id,'action':'deleteOfficeBearers','ward':wardId}
            ajax({
                  a:"districtmodel",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#modelshow').html(data);
                  }
            });   
}
</script>