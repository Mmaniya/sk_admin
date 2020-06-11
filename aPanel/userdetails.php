<!--==================================
Name: Manikandan;
Create: 4/5/2020;
Update: 5/6/2020;
Use: MEMBER OF OFFICE BEARERS VIEW 
====================================-->
<?php
   include 'includes.php';
   ?>
<div class="modal-dialog">
<div class="modal-content">
   <div class="modal-header">
      <h5 class="modal-title">Office Bearers Details</h5>
   </div>
   <div class="modal-body">
      <ul class="list-group list-group-flush">
         <?php 
            $getByID = $_POST['value'];
            $param = "Select * from ".TBL_BJP_OFFICE_BEARERS." where id='$getByID'";
            $officeBearersDetails = dB::mEXecuteSql($param);
            if( count($officeBearersDetails)>0) {
                foreach($officeBearersDetails as $key=>$value) {
                        if($value->role_hierarchy == 'S' ){
                            $hierarchy = 'State';
                        }if($value->role_hierarchy == 'D' ){
                            $hierarchy = 'District';
                        } else if($value->role_hierarchy == 'M'){
                            $hierarchy = 'Mandal';
                        } else if($value->role_hierarchy == 'W'){
                            $hierarchy = 'Ward';
                        } else if($value->role_hierarchy == 'SK'){
                            $hierarchy = 'Shakti Kendram';
                        } else if($value->role_hierarchy == 'B'){
                            $hierarchy = 'Booth';
                        } 
                        if($value->sub_role_hierarchy == 'D' ){
                            $sub_role_hierarchy = 'District';
                        } else if($value->sub_role_hierarchy == 'M'){
                            $sub_role_hierarchy = 'Mandal';
                        } else if($value->sub_role_hierarchy == 'W'){
                            $sub_role_hierarchy = 'Ward';
                        } else if($value->sub_role_hierarchy == 'SK'){
                            $sub_role_hierarchy = 'Shakti Kendram';
                        } else if($value->sub_role_hierarchy == 'B'){
                            $sub_role_hierarchy = 'Booth';
                        } 
            if($value->role_position == ''){
             $position = "Select * from ".TBL_BJP_ROLE." where position = NULL";
            }else{
               $position = "Select * from ".TBL_BJP_ROLE." where position ='$value->role_position'";
            }
            $positionName = dB::mEXecuteSql($position);

            
            $query = "Select * from ".TBL_BJP_DISTRICT." where id IN ($value->district_id)";
            $districtName = dB::mEXecuteSql($query);
            
            $mandal = "Select * from ".TBL_BJP_MANDAL." where id IN ($value->mandal_id)";
            $mandalName = dB::mEXecuteSql($mandal);
            
            $ward = "Select * from ".TBL_BJP_WARD." where id IN ($value->ward_id)";
            $wardName = dB::mEXecuteSql($ward);
            
            $sk = "Select * from ".TBL_BJP_SK." where id IN ($value->sk_id)";
            $skName = dB::mEXecuteSql($sk);
            
            $booth = "Select * from ".TBL_BJP_BOOTH." where id IN ($value->booth_id)";
            $BoothName = dB::mEXecuteSql($booth);
            ?>  
         <li class="list-group-item"><strong>NAME      : </strong> <i class="font-italic"><?php echo $value->person_name?>&nbsp;(<?php echo $value->person_name_ta?>)</i></li>
         <li class="list-group-item"><strong>MAIN ROLE : </strong> <i class="font-italic"><?php echo $hierarchy?></i></li>
         <li class="list-group-item"><strong>POSITION  : </strong> <i class="font-italic"><?php  foreach($positionName as $pos_key=>$pos_val) { echo $pos_val->role_name; } ?></i></li>
         <li class="list-group-item"><strong>SUB ROLE  : </strong> <i class="font-italic"><?php echo $sub_role_hierarchy; ?></i></li>
         <li class="list-group-item"><strong>DISTRICT  : </strong> <i class="font-italic"><?php   foreach($districtName as $key=>$val) { echo $val->district_name .'&nbsp'; }?></i></li>
         <li class="list-group-item"><strong>MANDAL    : </strong> <i class="font-italic"><?php foreach($mandalName as $key=>$val) { echo $val->mandal_name .'&nbsp'; }?></i></li>
         <li class="list-group-item"><strong>WARD      : </strong> <i class="font-italic"><?php foreach($wardName as $key=>$val) { echo $val->ward_number . '&nbsp'; }?></i></li>
         <li class="list-group-item"><strong>SHAKTI KENDRA : </strong> <i class="font-italic"><?php  foreach($skName as $key=>$val) { echo $val->sk_name .'&nbsp'; }?></i></li>
         <li class="list-group-item"><strong>BOOTH     : </strong> <i class="font-italic"><?php  foreach($BoothName as $key=>$val) { echo $val->booth_number .'&nbsp'; }?></i></li>
         <?php } } ?>
      </ul>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
</div>