<!--==============================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 9/6/2020;
   Use: View Ward Details Table 
   ================================-->
<?php
include 'includes.php';
$getMandalId = $_POST['id'];
?>
<table class="table table-hover" style="border: 2px solid #eee;" >
   <thead class="bg-primary text-white">
      <tr>
         <th scope="col">State Members</th>
         <th scope="col">District Members</th>
         <th scope="col">Mandal Members</th>
         <th scope="col">Ward Members</th>
         <th scope="col">SK Members</th>
         <th scope="col">Booth Members</th>
      </tr>
   </thead>   
   <tbody>
      <?php  

      $qry1 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND `role_hierarchy` ="S" OR `sub_role_hierarchy`="S" AND `status`="A" ORDER BY id DESC';
      $mainRoleS=dB::mExecuteSql($qry1); 

      $qry2 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND `role_hierarchy` ="D" OR `sub_role_hierarchy`="D" AND `status`="A" ORDER BY id DESC';
      $mainRoleD=dB::mExecuteSql($qry2); 

      $qry3 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND `role_hierarchy` ="M" OR `sub_role_hierarchy`="M" AND `status`="A" ORDER BY id DESC';
      $mainRoleM=dB::mExecuteSql($qry3); 

      $qry4 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND `role_hierarchy` ="W" OR `sub_role_hierarchy`="W" AND `status`="A" ORDER BY id DESC';
      $mainRoleW=dB::mExecuteSql($qry4);

      $qry5 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND `role_hierarchy` ="SK" OR `sub_role_hierarchy`="SK" AND `status`="A" ORDER BY id DESC';
      $mainRoleSK=dB::mExecuteSql($qry5); 

      $qry6 = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$getMandalId.'" AND `role_hierarchy` ="B" OR `sub_role_hierarchy`="B" AND `status`="A" ORDER BY id DESC';
      $mainRoleB=dB::mExecuteSql($qry6); 


      // // Mani Role Hierarchy  
      //    $stateMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'S -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $mainRoleS = Table::getData($stateMembers); 
         
      //    $districtMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'D -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $mainRoleD = Table::getData($districtMembers); 

      //    $mandalMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'M -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $mainRoleM = Table::getData($mandalMembers); 

      //    $wardMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'W -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $mainRoleW = Table::getData($wardMembers); 

      //    $skMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'SK -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $mainRoleSK = Table::getData($skMembers); 

      //    $boothMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'B -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $mainRoleB = Table::getData($boothMembers); 

      // // Sub Role Hierarchy
      //    $stateMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','sub_role_hierarchy'=>'S -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $subRoleS = Table::getData($stateMembers); 
         
      //    $districtMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','sub_role_hierarchy'=>'D -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $subRoleD = Table::getData($districtMembers); 

      //    $mandalMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','sub_role_hierarchy'=>'M -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $subRoleM = Table::getData($mandalMembers); 

      //    $wardMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','sub_role_hierarchy'=>'W -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $subRoleW = Table::getData($wardMembers); 

      //    $skMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','sub_role_hierarchy'=>'SK -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $subRoleSK = Table::getData($skMembers); 

      //    $boothMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','sub_role_hierarchy'=>'B -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
      //    $subRoleB = Table::getData($boothMembers); 

      ?>	
      <tr align="center">
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'S')"><?php  echo count($mainRoleS); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'D')"><?php  echo count($mainRoleD); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'M')"><?php  echo count($mainRoleM); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'W')"><?php  echo count($mainRoleW); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'SK')"><?php  echo count($mainRoleSK); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php  echo $_POST['id']?>,'B')"><?php  echo count($mainRoleB); ?></a></td>

    <!-- <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php // echo $_POST['id']?>,'S')"><?php // echo count($mainRoleS) + count($subRoleS) ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php // echo $_POST['id']?>,'D')"><?php // echo count($mainRoleD) + count($subRoleD); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php // echo $_POST['id']?>,'M')"><?php // echo count($mainRoleM) + count($subRoleM); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php // echo $_POST['id']?>,'W')"><?php // echo count($mainRoleW) + count($subRoleW); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php // echo $_POST['id']?>,'SK')"><?php // echo count($mainRoleSK) + count($subRoleSK); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php // echo $_POST['id']?>,'B')"><?php // echo count($mainRoleB) + count($subRoleB); ?></a></td> -->
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
