<!--==================================
   Name: Manikandan;
   Create: 26/5/2020;
   Update: 28/5/2020;
   Use: ADD NEW ROLE lIST
   ====================================-->

<ul id="sortable" class="list-group">
<?php
   if( count($roleList)>0) {
       foreach($roleList as $key=>$value) {
          ?>
<li class="list-group-item" id="<?php echo $value->id ?>" value="<?php echo $value->role_hierarchy; ?>">
   <strong><?php echo $value->role_name;?></strong> (<?php echo $value->no_of_roles;?> Roles)  <?php  echo $value->role_term ?>
   <span class="float-right">
       <?php if($value->status == 'A') { ?> <a href="javascript:void(0);" data-toggle="modal" onClick="openModelBox(<?php  echo $value->id; ?>)" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit </a>&nbsp; <?php } ?>
   <?php if($value->status == 'A') { ?>
   <a href="javascript:void(0);" data-toggle="modal" onClick="deleteRole(<?php  echo $value->id; ?>)" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>&nbsp;
   <?php } else { ?>
   <a href="javascript:void(0);" data-toggle="modal" onClick="restoreRole(<?php  echo $value->id; ?>)" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> Restore</a>&nbsp;
   <?php } ?>
   <a href="javascript:void(0);" <?php if($value->status == 'A') { ?> class="btn btn-success btn-sm" <?php } else { ?> class="btn btn-danger btn-sm" <?php } ?> ><i class="fa fa-exclamation-circle" aria-hidden="true"> </i> <?php if($value->status == 'A') { ?> Active <?php } else { ?> Inactive <?php } ?></a></span>
   <p><?php  echo $value->role_responsibilities ?></p>
</li>
<?php } } ?>
</ui>
<script>
   $( document ).ready(function() {
       $("#sortable").sortable({
           update: function( event, ui ) {
              var getHierarchy =  ui.item.attr("value");
               var getDataArray = new Array();
               $("#sortable li").each(function(){
                   getDataArray.push($(this).attr("id"));
               });
              var positionID =  (ui.item.index()+1);
              paramData = {'act':'updateRolePostionId','position':getDataArray,'hierarchy':getHierarchy };
            ajax({
                   a:"newroleajax",
                   b:paramData,
                   c:function(){},
                   d:function(data){}
               });
              
           }
       });
   });
   function openModelBox(id,role_hierarchy){
       paramData = {'id':id}
           ajax({
               a:"rolemodelbox",
               b: paramData,
               c:function(){},
               d:function(data){
                   $('#modelbox').html(data);
               }
        });
       };
   function deleteRole(id){
       paramData = {'act':'deleteRole','id':id}
           ajax({
               a:"roleconfirmmodel",
               b:paramData,
               c:function(){},
               d:function(data){ 
                    $('#modelbox').html(data);
                }
           });
       };
   function restoreRole(id){
           paramData = {'act':'restoreRole','id':id}
               ajax({
                   a:"roleconfirmmodel",
                   b:paramData,
                   c:function(){},
                   d:function(data){
                        $('#modelbox').html(data);
                    }
               });
       };
</script>