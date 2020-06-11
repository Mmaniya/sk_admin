<!--==================================
   Name: Manikandan;
   Create: 24/5/2020;
   Update: 26/5/2020;
   Use: ADD NEW ROLE
   ====================================-->
<?php
   include 'includes.php';
   
   $modelId = $_POST['id'];
   $title = 'Add New Role';
   $joined_date ='';
   if($modelId>0) { 
   	$param = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$modelId.'-INT'),'showSql'=>'N',);
   	$roleData = Table::getData($param);
   	foreach($roleData as $K=>$V)  $$K=$V;
   	 $title = 'Edit Role ';
   	$joined_date = date('m/d/Y',strtotime($joined_date));
   }
   ?>
<div class="modal-content">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title"><?php echo $title; ?></h5>
   </div>
   <div class="modal-body">
      <form id="myForm" action="javascipt:void(0)">
         <input type="hidden" id="" name="act" value="inserRoleData">
         <input type="hidden" id="" name="id" value="<?php echo $modelId; ?>">
         <div class="form-group">
            <label for="exampleInputEmail1">Select Role Categories</label>
            <select class="form-control" name="role_hierarchy" >
               <?php (isset($_POST["role_hierarchy"])) ? $role_hierarchy = $_POST["role_hierarchy"] : $role_hierarchy; ?>
               <option <?php if ($role_hierarchy == "S" ) echo 'selected' ; ?> value="S" >STATE</option>
               <option <?php if ($role_hierarchy == "D" ) echo 'selected' ; ?> value="D">DISTRICT</option>
               <option <?php if ($role_hierarchy == "M" ) echo 'selected' ; ?> value="M">MANDAL</option>
               <option <?php if ($role_hierarchy == "W" ) echo 'selected' ; ?> value="W">WARD</option>
               <option <?php if ($role_hierarchy == "SK") echo 'selected' ; ?> value="SK">SHAKTI KENDRA</option>
               <option <?php if ($role_hierarchy == "B" ) echo 'selected' ; ?> value="B">BOOTH</option>
               <option <?php if ($role_hierarchy == "O" ) echo 'selected' ; ?> value="O">OTHERS</option>
            </select>
            <input type="hidden" id="triggerFunction" value="<?php echo $role_hierarchy ?>">                    
         </div>
         <div class="form-group">
            <label >Name of Role</label>
            <input type="text" class="form-control" name="role_name" value="<?php echo $role_name; ?>"  placeholder="Enter Name of Role">
         </div>
         <div class="form-group">
            <label >Role of Short Form</label>
            <input type="text" class="form-control" name="role_abbr" value="<?php echo $role_abbr; ?>" placeholder="Enter Short Name of Role">
         </div>
         <div class="form-group">
            <label >Number of Role</label>
            <input type="text" class="form-control" name="no_of_roles"  value="<?php echo $no_of_roles; ?>" placeholder="Enter Numbre of Role">
         </div>
         <div class="form-group">
            <label >Role Terms</label>
            <input type="text"  class="form-control" name="role_term" value="<?php echo $role_term; ?>" placeholder="Role Terms">
         </div>
         <div class="form-group">
            <label >Role Responsibilities</label>
            <textarea  class="form-control"  placeholder="Role Responsibilities" name="role_responsibilities" ><?php echo $role_responsibilities; ?></textarea>
         </div>
         <input type="hidden" value="A" name="status">
         <a href="javascript:void(0)" id="submit"  class="btn btn-success"   data-dismiss="modal"  class="btn btn-primary">Submit</a>
      </form>
   </div>
</div>
<script>
   $('#submit').click(function(event){ 
        var form = $('#myForm');   
        var functionValue = $('#triggerFunction').val();
        ajax({ 
            a:'newroleajax',
            b:form.serialize(),
            c:function(){},
            d:function(data){  
                $('#recordInsert').html('<p style="color:green">Data Updated Successfully.</p>'); 
                getRolehierarchy(functionValue);
                setTimeout(function(){
                  $('#recordInsert').fadeOut();
              },3000); 
             }
        });
   });
</script>