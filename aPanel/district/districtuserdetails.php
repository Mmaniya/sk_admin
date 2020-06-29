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
<input type="hidden" value="<?php echo $_POST['role']; ?>" id="selctedRole">
<div class="card" id="deleteOfficeBearers_<?php echo $value->id ?>">
   <div class="card-header">
      Office Bearers Details
   </div>
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

            $qry = 'select * from '.TBL_BJP_BOOTH.' where `id` IN ('.$value->booth_id.') AND `status`="A"';
            $findsubroleSKList=dB::mExecuteSql($qry);  
                 
            if($member_list->membership_number != ''){ ?>
         <label>Membership Number : <?php echo $member_list->membership_number; ?> </label><br>
         <?php } if($value->role_hierarchy != ''){ ?>
         <?php  switch($value->role_hierarchy) {      
                  case "W" : 
                        $findsubrole = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('id' => $value->ward_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
                        $findsubroleList = Table::getData($findsubrole);
                        echo '<span class="mytextcolor">'.$findsubroleList->ward_number.' WARD INCHARGE</span>';
                  break; 
                  case "SK" :     
                     $findsubrole = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('id' => $value->ward_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
                     $findsubroleList = Table::getData($findsubrole);
                     echo 'WARD&nbsp;<span class="mytextcolor">'.$findsubroleList->ward_number.'</span><br>'; 
                     echo 'SHAKTI KENDRA INCHARGE&nbsp;'; 
                  foreach($findsubroleSKList as $array) { 
                     echo '<span class="mytextcolor">'.$array->booth_number.'&nbsp; </span>';
                     } 
                  break; 
                  case "B" : 
                     $findsubrole = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('id' => $value->ward_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
                     $findsubroleList = Table::getData($findsubrole);
                     echo 'WARD&nbsp;<span class="mytextcolor">'.$findsubroleList->ward_number.'</span><br>'; 
                     echo ' BOOTH INCHARGE&nbsp;';
                     foreach($findsubroleSKList as $array) { 
                        echo '<span class="mytextcolor">'.$array->booth_number.'&nbsp; </span>';
                        } 
                  break; 
               } 
            } 
            if($_POST['role'] != 'M'){
               switch($value->sub_role_hierarchy) {      
               case "W" : 
               $findsubrole = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('id' => $value->ward_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
               $findsubroleList = Table::getData($findsubrole);
               echo '<span class="mytextcolor">'.$findsubroleList->ward_number.' WARD INCHARGE</span>';
               break; 
                  case "SK" :  
                        $findsubrole = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('id' => $value->ward_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
                        $findsubroleList = Table::getData($findsubrole);
                        if($value->role_hierarchy != 'W'){
                              echo 'WARD&nbsp;<span class="mytextcolor">'.$findsubroleList->ward_number.'</span>'; 
                        }
                           echo '<br>SHAKTI KENDRA INCHARGE&nbsp;'; 
                           foreach($findsubroleSKList as $array) { 
                                 echo '<span class="mytextcolor">'.$array->booth_number.'&nbsp; </span>';
                           }  
                  break; 
               case "B" :
                  $findsubrole = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('id' => $value->ward_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
                  $findsubroleList = Table::getData($findsubrole);
                  echo 'WARD&nbsp;<span class="mytextcolor">'.$findsubroleList->ward_number.'</span><br>'; 
                  echo ' BOOTH INCHARGE&nbsp;';
                  foreach($findsubroleSKList as $array) { 
                     echo '<span class="mytextcolor">'.$array->booth_number.'&nbsp; </span>';
                     } 
               break; 
               }
            } 
            if($value->sub_role_hierarchy != ''){ 
            $qry = 'select * from '.TBL_BJP_BOOTH.' where `id` IN ('.$value->booth_id.') AND `status`="A"';
            $findsubroleSKList=dB::mExecuteSql($qry);   
            ?>         
         <?php } if($value->role_id != '0' && $value->role_hierarchy == 'M' && $_POST['role'] == 'M'){ ?>
         <label> Role Position: <span class="mytextcolor">
         <?php  
            $roleMembers = array('tableName' => TBL_BJP_ROLE, 'fields' => array('*'),'condition' => array('id' => $value->role_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
            $roleMembersList = Table::getData($roleMembers);
            echo $roleMembersList->role_name;
            ?></span>
         </label>
         <?php } ?>
         <span class="row" >

         <?php // if($_POST['role'] != 'W'){ ?>
         <span class="col-sm-3">
            <a href="javascript:void(0)" style="float:right;color:orange" data-toggle="modal" data-target=".updateofficebearers"  onClick="editofficebearers(<?php echo $value->id; ?>)" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
         </span>
         <?php // } ?>
         <span class="col-sm-3">
            <a href="javascript:void(0)" style="float:right;color:red" data-toggle="modal" data-target=".uddateOB"  onClick="deleteofficebearers(<?php echo $value->id; ?>)" ><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
         </span>

         </span>
      </span>
   </div>
</div>
<br>
<?php   } ?>
<?php } else { ?>
<tr>
   <td colspan="5">No results Found
   <td>
</tr>
<?php } echo $table_val; ?>
<!-- Modal -->
<div class="modal fade uddateOB" role="dialog">
   <div class="modal-dialog">
      <span id="updateModel"></span>
   </div>
</div>
<div class="modal fade updateofficebearers" role="dialog">
   <div class="modal-dialog">
      <span class="viewofficebearers"></span>
   </div>
</div>
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
   function editofficebearers(id) {
      var role = $('#selctedRole').val();
      paramData = {'obid':id,'action':'editOfficeBearers','role':role}                     
         ajax({
               a:"districtmodel",
               b:paramData,
               c:function(){},
               d:function(data){
                  $('.viewofficebearers').html(data);
               }
         });                                   
   }   
   function deleteofficebearers(id) {  
      var role = $('#selctedRole').val();          
      paramData = {'ofid':id,'action':'deleteOfficeBearers','role':role}
            ajax({
                  a:"districtmodel",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#updateModel').html(data);
                  }
            });                        
   }

   
</script>