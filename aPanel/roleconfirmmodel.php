<!--==================================
   Name: Manikandan;
   Create: 22/5/2020;
   Update: 24/5/2020;
   Use: USER ROLE DELETE AND RESTORE
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
   
   if($_POST['act']=='deleteRole'){
   ?>
<div class="modal-content">
   <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Delete Record</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="modal-body">
      <p>Are you sure cofirm delete this data.?</p>
   </div>
   <form id="myForm" action="javascipt:void(0)">
      <input type="hidden" name="act" value="statusRoleDataUpdate">
      <input type="hidden" name="id" value="<?php echo $modelId; ?>">
      <input type="hidden" id="triggerFunction" value="<?php echo $role_hierarchy ?>">                    
      <input type="hidden" value="I" name="status">
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <a href="javascript:void(0)" id="submit" class="btn btn-danger"  data-dismiss="modal">Delete</a>
      </div>
   </form>
</div>
<?php } if($_POST['act']=='restoreRole'){ ?>
<div class="modal-content">
   <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Restore Record</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="modal-body">
      <p>Are you sure cofirm restore this data.?</p>
   </div>
   <form id="myForm" action="javascipt:void(0)">
      <input type="hidden" name="act" value="statusRoleDataUpdate">
      <input type="hidden" name="id" value="<?php echo $modelId; ?>">
      <input type="hidden" id="triggerFunction" value="<?php echo $role_hierarchy ?>">                    
      <input type="hidden" value="A" name="status">
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <a href="javascript:void(0)" id="submit" class="btn btn-success"   data-dismiss="modal">Restore</a>
      </div>
   </form>
</div>
<?php } ?>
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
              setTimeout(function(){
                  $('#recordInsert').fadeOut();
              },3000); 
              getRolehierarchy(functionValue);
             }
        });      
   });
</script>