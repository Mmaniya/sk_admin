<?php
session_start();
function main() { 
?>
<div id="layoutSidenav_content">
    <div class="container-fluid">
        <h2 class="mt-3">New Role</h2>
        <ol class="breadcrumb mb-3">
            <a href="dashboard.php" class="breadcrumb-item">Home</a>
            <a href="addnewrole.php" class="breadcrumb-item active">Add New Role</a>
        </ol>
        <div class="row">
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Role Type
                    </div>        
                    <ul class="list-group">
                       <a href="javascript:void(0)"  onclick="getRolehierarchy('S')"  class="list-group-item list-group-item-action ">STATE</a>  
                       <a href="javascript:void(0)"  onclick="getRolehierarchy('D')"  class="list-group-item list-group-item-action ">DISTRICT</a>                      
                       <a href="javascript:void(0)"  onclick="getRolehierarchy('M')"  class="list-group-item list-group-item-action ">MANDAL</a>                      
                       <a href="javascript:void(0)"  onclick="getRolehierarchy('W')"  class="list-group-item list-group-item-action ">WARD</a>                      
                       <a href="javascript:void(0)"  onclick="getRolehierarchy('SK')"  class="list-group-item list-group-item-action ">SHAKTI KENDRA</a>                      
                       <a href="javascript:void(0)"  onclick="getRolehierarchy('B')"  class="list-group-item list-group-item-action ">BOOTH</a>  
                       <a href="javascript:void(0)"  onclick="getRolehierarchy('O')"  class="list-group-item list-group-item-action ">OTHERS</a>                                                              
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-header"><i class="fa fa-chart-bar mr-1"></i>Role List
                    <a href="javascript:void(0)"  data-toggle="modal"  data-target="#myModal" class="btn btn-outline-primary btn-sm float-right" onClick="openModelBox()"><i class="fa fa-plus" aria-hidden="true"></i> Add</a>
                    </div>
                    <div class="card-body" id="viewRolehierarchy"></div>
                    <div class="card-body" id="recordInsert"></div>
                </div>
            </div>
        </div>
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <span id="modelbox"></span>
    </div>
</div>
<!-- End Model --><!-- End Model -->
    </div>
</div>
<script type="text/javascript">
 function getRolehierarchy(value) {
    paramData = {'act':'districtgetRolehierarchy','role_hierarchy':value }; 
        $.ajax({
            type: "POST",
            url: "newroleajax.php",
            data: paramData,
            success: function(data){         
            $('#viewRolehierarchy').html(data);
            }
        });
   }
   $( document ).ready(function() {
        paramData = {'act':'districtgetRolehierarchy','role_hierarchy':'S'}; 
            $.ajax({
                type: "POST",
                url: "newroleajax.php",
                data: paramData,
                success: function(data){         
                $('#viewRolehierarchy').html(data);
                }
            });
   });
   
   function openModelBox(id){
    paramData = {'id':id}
        $.ajax({
            type: "POST",
            url: "rolemodelbox.php",
            data: paramData,
            success: function(data){ 
            $('#modelbox').html(data);
        }});
    };

</script>

<?php } include "template.php"; ?>