<?php

include 'includes.php';
 $member_ID = $_POST['member_ID'];
 $modelAction = $_POST['action'];
 $joined_date ='';
 if($member_ID>0) { 
      $param = array('tableName'=>TBL_BJP_MEMBER,'fields'=>array('*'),'condition'=>array('id'=>$member_ID.'-INT'),'showSql'=>'N',);
      $roleData = Table::getData($param);
     foreach($roleData as $K=>$V)  $$K=$V;
     $title = 'EDIT';
     $joined_date = date('m/d/Y',strtotime($joined_date));
 }
?>
<!-- 1. EDIT MODEL DATA FOR DISTRICT  -->
<?php if($modelAction =='edit'){ ?>
<div class="modal-content">
<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal">&times;</button>
   <h5 class="modal-title">
      <span style="color:#eab15c"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT MEMBER </span>
   </h5>
</div>
<div class="modal-body">
   <form action="javascript:void(0)" id="formMember" method="POST">
      <input type="hidden" value="<?php echo $member_ID ?>" name="id">
      <input type="hidden" value="mmemberEdit" name="act">
      <div class="form-group">
         <label >Member Name</label>
         <input type="text" class="form-control" name="member_name"  value="<?php echo $roleData->member_name; ?>" required placeholder="Enter Member Name">
      </div>
      <div class="form-group">
         <label >Tamil Name of Member </label>
         <input type="text" class="form-control" name="member_name_ta"  value="<?php echo $roleData->member_name_ta; ?>" placeholder="Enter Tamil Name of Member">
      </div>
      <input type="submit" id="submit" class="btn btn-success" <?php  if($modelId == ''){ ?> value="Submit" <?php } else { ?> value="Update" <?php } ?>>
   </form>
</div>
</div>
   <?php } ?>
   <script>
   $('form#formMember').validate({
         rules: {
            member_name: "required",
            member_name_ta: "required",
         },
         messages: {
            state_id: "Please Enter Name",
            district_name: "Please Enter Tamil Name of Member",
         },
         submitHandler: function(form){
         var formData = $('form#formMember').serialize();
            ajax({
               a:"memberajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('#myModal').modal('toggle');
                  paramData = {'act':'getAllData','type':'all'}; 
                     ajax({
                           a:"memberajax",
                           b:paramData,
                           c:function(){},
                           d:function(data){
                              $('#myTable').html(data);
                           }
                     });
               }          
            });
         }
      });
      </script>