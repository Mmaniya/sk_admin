<!--==============================
   Name: Manikandan;
   Create: 5/6/2020;
   Update:12/6/2020;
   Use: View Ward Details Table 
   ================================-->
<?php
include 'includes.php';
$getMandalId = $_POST['id'];
?>
<table class="table table-hover" style="border: 2px solid #eee;" >
   <thead class="bg-primary text-white">
      <tr>
         <!-- <th scope="col">State Office Bearers</th> -->
         <!-- <th scope="col">District Office Bearers</th> -->
         <th scope="col">Mandal Office Bearers</th>
         <th scope="col">Ward Office Bearers</th>
         <th scope="col">SK Office Bearers</th>
         <th scope="col">Booth Members</th>
      </tr>
   </thead>   
   <tbody>
      <?php  
      // $qry1 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND (`role_hierarchy` ="S" OR `sub_role_hierarchy` = "S")  AND `status`="A" ORDER BY id DESC';
      // $mainRoleS=dB::mExecuteSql($qry1); 

      // $qry2 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND (`role_hierarchy` ="D" OR `sub_role_hierarchy` = "D") AND `status`="A" ORDER BY id DESC';
      // $mainRoleD=dB::mExecuteSql($qry2); 

      $qry3 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND (`role_hierarchy` ="M" OR `sub_role_hierarchy` = "M") AND `status`="A" ORDER BY id DESC';
      $mainRoleM=dB::mExecuteSql($qry3); 

      $qry4 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND (`role_hierarchy` ="W" OR `sub_role_hierarchy` = "W") AND `status`="A" ORDER BY id DESC';
      $mainRoleW=dB::mExecuteSql($qry4);

      $qry5 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND (`role_hierarchy` ="SK" OR `sub_role_hierarchy` = "SK") AND `status`="A" ORDER BY id DESC';
      $mainRoleSK=dB::mExecuteSql($qry5); 

      $qry6 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND (`role_hierarchy` ="B" OR `sub_role_hierarchy` = "B")  AND `status`="A" ORDER BY id DESC';
      $mainRoleB=dB::mExecuteSql($qry6); 

      ?>	
      <tr align="center">
         <!-- <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php // echo $_POST['id']?>,'S')"><?php // echo count($mainRoleS); ?></a></td> -->
         <!-- <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php // echo $_POST['id']?>,'D')"><?php // echo count($mainRoleD); ?></a></td> -->
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'M')"><?php  echo count($mainRoleM); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'W')"><?php  echo count($mainRoleW); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'SK')"><?php echo count($mainRoleSK); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'B')"><?php  echo count($mainRoleB); ?></a></td>    
      </tr>
   </tbody>
</table>
<script>
   function getStateUsers(id,role){
      paramData = {'act':'MandalofficeBearers','id':id,'role':role}; 
         ajax({
            a:"districtajax",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#mandalofficeBeares').html(data);
            }
      });
   }
</script>
