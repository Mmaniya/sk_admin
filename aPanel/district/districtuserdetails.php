<?php 
   $prev=$next=$last=$first='&nbsp;';
   if($page > 1)
   $first = "<i class='fa fa-fast-backward' aria-hidden='true' onclick='ShowParentCatListPagination(\"1\",\"".$filter_by."\",\"".$id."\")'/></i>";
   
   if($page < $totalPages)
   $last = "<i class='fa fa-fast-forward' aria-hidden='true' onclick='ShowParentCatListPagination(\"$totalPages\",\"".$filter_by."\",\"".$id."\")'/><i>";
   if(count($stateMembersList)>0 && $totalPages > 1){
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
<input type="hidden" value="<?php echo $value->mandal_id; ?>" id="viewMandalID">
<input type="hidden" value="<?php echo $value->role_hierarchy; ?>" id="memberRole">
<div class="card">
   <?php// if($value->role_hierarchy != ''){ ?>
   <div class="card-header">
   Office Bearers Details
   <!-- <?php // switch( $value->role_hierarchy) {case "S" : echo 'State'; break; case "D" : echo 'District'; break; case "M" : echo 'Mandal'; break; case "W" : echo 'Ward'; break; case "SK" : echo 'Shakti Kendram'; break; case "B" : echo 'Booth'; break; } ?> Member Details -->
   </div>
   <?php //} ?>
   <input type="hidden" value="<?php echo $value->id ?>" id="officeBearersId">
   <div class="card-body row">
      <span class="col-sm-7">
      <label>Name : <?php echo $value->person_name_ta; echo '('; echo $value->person_name; echo ')'; ?> </label><br>
      <label>Mobile : <?php echo $value->mobile_number; ?> </label><br>
      <?php if($value->address) { ?>
      <label>Address : <?php echo $value->address; ?> </label><br>
      <?php } if($value->email_address) { ?>
      <label>E-Mail : <?php echo $value->email_address; ?> </label>
      <?php } ?>
      </span>
      <span class="col-sm-5">
      <?php $param = array('tableName'=>TBL_BJP_MEMBER,'fields'=>array('*'),'condition'=>array('id'=>$value->member_id.'-INT','status'=>'A-CHAR'),'showSql'=>'N','sortby'=>'asc');
         $member_list = Table::getData($param);
         
         if($member_list->membership_number != ''){ ?>
      <label>Membership Number : <?php echo $member_list->membership_number; ?> </label><br>
      <?php } if($value->role_hierarchy != ''){ ?>
      <label>Role Hierarchy: <?php switch($value->role_hierarchy) { case "S" : echo 'STATE'; break; case "D" : echo 'DISTRICT'; break; case "M" : echo 'MANDAL'; break; case "W" : echo 'WARD'; break; case "SK" : echo 'SHAKTI KENDRAM'; break; case "B" : echo 'BOOTH'; break; } ?> </label><br>
      <?php } if($value->sub_role_hierarchy != ''){ ?>
      <label>Sub Role Hierarchy: <?php switch($value->sub_role_hierarchy) { case "S" : echo 'STATE'; break; case "D" : echo 'DISTRICT'; break; case "M" : echo 'MANDAL'; break; case "W" : echo 'WARD'; break; case "SK" : echo 'SHAKTI KENDRAM'; break; case "B" : echo 'BOOTH'; break; } ?> </label><br>
      <?php } if($value->role_id != '0'){ ?>
      <label> Role Position: <span style="color:#4eab07">
      <?php  
         $roleMembers = array('tableName' => TBL_BJP_ROLE, 'fields' => array('*'),'condition' => array('id' => $value->role_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
         $roleMembersList = Table::getData($roleMembers);
         echo $roleMembersList->role_name;
         ?></span>
      </label><br>
      <?php } ?>
      <a href="javascript:void(0)" style="float:right"  onClick="editofficebearers(<?php echo $value->id; ?>,<?php echo $value->mandal_id; ?>,<?php echo $value->district_id; ?>,<?php echo $value->member_id ?>)" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
      </span>
   </div>
   <span id="editOfficeBearers_<?php echo $value->id ?>"></span>
</div>
<br>
<?php   } ?>
<?php } else{ ?>
<tr>
   <td colspan="5">No results Found
   <td>
</tr>
<?php } echo $table_val; ?>
<script>
   function ShowParentCatListPagination(page,condition,value) { 
      var mandalid = $('#viewMandalID').val();
      var value = $('#memberRole').val();
         paramData = {'act':'memberListpagination','page':page,'role':value,'mandalId':mandalid}; 
         ajax({
         a:"districtajax",
         b: paramData,
         c:function(){},
         d:function(data){
               $('#mandalofficeBeares').html(data);
            } 
         });
   }
   
   function editofficebearers(id,mandalid,districtID,member_id) {
           paramData = {'obid':id,'mandalid':mandalid,'districtID':districtID,'action':'add_edit_OfficeBearers'}                     
            ajax({
                  a:"districtmodel",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#editOfficeBearers_'+id).html(data);
                  }
            });
            paramMember = {'act':'memberDetails','filter_by':member_id }; 
                  ajax({
                     a:"districtajax",
                     b:paramMember,
                     c:function(){},
                     d:function(data){
                        $('#memberTable').html(data);
                     }
               });                     
      }
</script>