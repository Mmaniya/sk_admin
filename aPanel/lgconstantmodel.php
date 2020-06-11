<!--==================================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 5/6/2020;
   Use: ADD MP CONSTANT
   ====================================-->
   <?php
   include 'includes.php';
    $modelId = $_POST['id'];
    $modelAction = $_POST['action'];
    $title = 'Add New LG Constant';
    $joined_date ='';
    if($modelId>0) { 
        $param = array('tableName'=>TBL_BJP_LG_CONST,'fields'=>array('*'),'condition'=>array('id'=>$modelId.'-INT'),'showSql'=>'N',);
        $roleData = Table::getData($param);
        foreach($roleData as $K=>$V)  $$K=$V;
        $title = 'Edit LG Constant ';
        $joined_date = date('m/d/Y',strtotime($joined_date));
    }    
   
?>
<?php if($modelAction =='edit'){ ?>
<div class="modal-content">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title"><?php echo $title; ?></h5>
   </div>
   <div class="modal-body">
      <form action="javascript:void(0)" id="formData" method="POST">
         <input type="hidden" value="addNewLGConstant" name="act">
         <input type="hidden" value="<?php echo $modelId ?>" name="id">
         <div class="form-group">
            <label for="exampleInputEmail1">Select State</label>
            <select class="form-control" name="state_id" required>
            <?php (isset($_POST["state_id"])) ? $state_id = $_POST["state_id"] : $role_hierarchy; ?>
               <option selected="true" disabled="disabled" value="">Please Select State</option>
               <option <?php if ($state_id == "1" ) echo 'selected' ; ?> value="1" >Tamilnadu</option>
            </select>
         </div>
         <div class="form-group">
            <label >Name of District</label>
            <select class="form-control" name="district_id" required>
            <?php (isset($_POST["district_id"])) ? $district_id = $_POST["district_id"] : $district_id; ?>
               <option selected="true" disabled="disabled" value="">Please Select District</option>
               <?php $query = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                      $districtData = Table::getData($query);
                        foreach($districtData as $Key=>$Val){ ?>
                  <option <?php if ($district_id == $Val->id ) echo 'selected' ; ?> value="<?php echo $Val->id  ?>" ><?php echo $Val->district_name ?></option>
               <?php } ?>
            </select>
         </div>
         <div class="form-group">
            <label >MP Constituency Name</label>
            <select class="form-control" name="mp_const_id" required>
            <?php (isset($_POST["mp_const_id"])) ? $mp_const_id = $_POST["mp_const_id"] : $mp_const_id; ?>
               <option selected="true" disabled="disabled" value="">Please Select MP Constant</option>
               <?php $mpquery = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                      $mpConstantData = Table::getData($mpquery);
                        foreach($mpConstantData as $Key=>$Val){ ?>
                  <option <?php if ($mp_const_id == $Val->id ) echo 'selected' ; ?> value="<?php echo $Val->id  ?>" ><?php echo $Val->bjp_mp_const_name ?></option>
               <?php } ?>
            </select>
         </div>
         <div class="form-group">
            <label >LG Constituency No</label>
            <input type="text" class="form-control" name="lg_const_number"  value="<?php echo $lg_const_number; ?>" placeholder="Enter LG Constant No">
         </div>
         <div class="form-group">
            <label >Name of LG Constituency </label>
            <input type="text" class="form-control" name="lg_const_name"  value="<?php echo $lg_const_name; ?>" placeholder="Enter LG Constant Name">
         </div>
         <div class="form-group">
            <label >Tamil Name of LG Constituency </label>
            <input type="text" class="form-control" name="lg_const_tname"  value="<?php echo $lg_const_tname; ?>" placeholder="Enter LG Constant Tamil Name">
         </div>
         <div class="form-group">
            <label >LG Constituency Category</label>
            <select class="form-control" name="lg_const_category" required>
            <?php (isset($_POST["lg_const_category"])) ? $lg_const_category = $_POST["lg_const_category"] : $lg_const_category; ?>
               <option selected="true" disabled="disabled" value="">Please Select Category</option>
               <option <?php if ($lg_const_category == "P" ) echo 'selected' ; ?> value="P" >PUBLIC</option>
               <option <?php if ($lg_const_category == "W" ) echo 'selected' ; ?> value="W" >WOMEN</option>
               <option <?php if ($lg_const_category == "R" ) echo 'selected' ; ?> value="W" >RESERVED</option>
            </select>
         </div>
            <input type="submit" id="submit"   class="btn btn-success"   data-dismiss="modal"  <?php  if($modelId == ''){ ?> value="Submit" <?php } else { ?> value="Update" <?php } ?>>
      </form>
   </div>
</div>

<?php } else if( $modelAction =='delete'){ ?>

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
   <form id="formData" action="javascipt:void(0)">
      <input type="hidden" name="act" value="statusDataUpdate">
      <input type="hidden" name="id" value="<?php echo $modelId; ?>">
      <input type="hidden" value="I" name="status">
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <a href="javascript:void(0)" id="submit" class="btn btn-danger"  data-dismiss="modal">Delete</a>
      </div>
   </form>
</div>

<?php } else if($modelAction =='restore'){ ?>

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
   <form id="formData" action="javascipt:void(0)">
      <input type="hidden" name="act" value="statusDataUpdate">
      <input type="hidden" name="id" value="<?php echo $modelId; ?>">
      <input type="hidden" value="A" name="status">
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <a href="javascript:void(0)" id="submit" class="btn btn-success"   data-dismiss="modal">Restore</a>
      </div>
   </form>
</div>
<?php } ?>

<script>
     $("#submit").click(function(event){
         var formData = $('form#formData').serialize();
         ajax({
            a: "lgconstantajax",
            b: formData,
            c:function(){},
            d:function(data){
               $('#showNotifycation').html('<p style="color:green">Record Updated.!</p>');
               $( "#inputvalue" ).trigger( "keyup" );
               setTimeout(function() { $('#showNotifycation').fadeOut('slow');}, 2000);
               }
         });
   	});
</script>