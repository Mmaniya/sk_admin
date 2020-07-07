        <table class="table table-striped table-bordered" id="obtabel">
            <thead>
            <tr><th colspan='7' style="color:#ff9933">
                <?php 
                       switch($_POST['role']) { 
                        case "M" :                    
                            echo 'MANDAL OFFICE BEARERS';
                        break;      
                        case "W" :                    
                                echo 'WARD OFFICE BEARERS';
                        break; 
                        case "SK" :  
                            echo 'SHAKTI KENDRA OFFICE BEARERS';   
                        break; 
                        case "B" :             
                            echo 'BOOTH OFFICE BEARERS';   
                        break;         
                        }
                ?>
            </th>
            </tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>SubRole</th>
                    <th>Ward</th>
                    <th>Booth</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <input type="text" style="display:none" value="<?php echo $_POST['role']; ?>" id="selectedRole">
            <?php                 
                $i = 1; 
                foreach($stateMembersList as $key=>$value) {
                    ?>
                    <input type="hidden" value="<?php echo $value->mandal_id; ?>" id="viewMandalID">
                    <input type="hidden" value="<?php echo $value->role_hierarchy; ?>" id="memberRole">
                    <input type="hidden" value="<?php echo $value->id ?>" id="officeBearersId">
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $value->person_name; if($value->person_name_ta !=''){ ?>(<?php echo $value->person_name_ta ?>)<?php } ?></td>
                    <td><?php echo $value->mobile_number ?></td>
                    <td>
                    <?php
                        if($value->role_hierarchy != ''){                   
                            $roleMembers = array('tableName' => TBL_BJP_ROLE, 'fields' => array('*'),'condition' => array('id' => $value->role_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
                            $roleMembersList = Table::getData($roleMembers);
                            echo '<span  style="font-size:15px; text-transform:uppercase">'.$roleMembersList->role_name.'</span>';
                        }
                    ?>
                    </td>
                    <td>
                    <?php
                        switch($value->sub_role_hierarchy) {      
                        case "W" :                    
                                echo '<span style="font-size:15px;">WARD INCHARGE</span>';
                        break; 
                        case "SK" :  
                            echo '<span style="font-size:15px;">SHAKTI KENDRAM</span>';   
                        break; 
                        case "B" :             
                            echo '<span  style="font-size:15px;">BOOTH INCHARGE</span>';   
                        break; 
                        case "" :
                            echo '--';
                        break;
                        } 
                    ?>
                    </td>
                    <td>
                        <?php
                        $findsubrole = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('id' => $value->ward_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
                        $findsubroleList = Table::getData($findsubrole);
                        echo $findsubroleList->ward_number;
                         ?>
                    </td>
                    <td> <?php 
                          $qry = 'select * from '.TBL_BJP_BOOTH.' where `id` IN ('.$value->booth_id.') AND `status`="A"';
                          $findsubroleSKList=dB::mExecuteSql($qry);                                 
                            foreach($findsubroleSKList as $array) {
                            echo $array->booth_number.'<br>';
                            } 
                        ?>
                    </td>
                    <td>
                        <a href="javascript:void(0)" style="float:center;color:#fd7e14" data-toggle="modal" data-target=".updateofficebearers"  onclick="editofficebearers(<?php echo $value->id ?>)" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".uddateOB"  onclick="deleteofficebearers(<?php echo $value->id ?>)" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>           
                </tr>    
            <?php $i ++; } ?>      
            </tbody>    
        </table>

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
    // $('#officebearers').DataTable();
    $(document).ready(function() {
    $('#obtabel').DataTable();
} );
 
   function editofficebearers(id) {
      var role = $('#selectedRole').val();
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
      var role = $('#selectedRole').val();          
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