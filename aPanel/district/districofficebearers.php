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
         $stateMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'S -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
         $stateMembersList = Table::getData($stateMembers); 
         
         $districtMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'D -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
         $districtMembersList = Table::getData($districtMembers); 

         $mandalMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'M -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
         $mandalMembersList = Table::getData($mandalMembers); 

         $wardMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'W -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
         $wardMembersList = Table::getData($wardMembers); 

         $skMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'SK -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
         $skMembersList = Table::getData($skMembers); 

         $boothMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $getMandalId.'-INT','role_hierarchy'=>'B -CHAR','status'=> 'A-CHAR'),'orderby' => 'id', 'showSql' => 'N');
         $boothMembersList = Table::getData($boothMembers); 
      ?>	
      <tr align="center">
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php echo $_POST['id']?>,'S')"><?php  echo count($stateMembersList); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php echo $_POST['id']?>,'D')"><?php  echo count($districtMembersList); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php echo $_POST['id']?>,'M')"><?php  echo count($mandalMembersList); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php echo $_POST['id']?>,'W')"><?php  echo count($wardMembersList); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php echo $_POST['id']?>,'SK')"><?php  echo count($skMembersList); ?></a></td>
         <td><a href="javascript:void(0);" title="click to get more information." onClick="getStateUsers(<?php echo $_POST['id']?>,'B')"><?php  echo count($boothMembersList); ?></a></td>
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
