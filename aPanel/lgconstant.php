<!--======================================
   Name: Manikandan;
   Create: 4/6/2020;
   Update: 5/6/2020;
   Use: ADD MP CONSTANT
   =======================================-->
   <?php
   function main() { 
   ?>
<div id="layoutSidenav_content">
   <div class="container-fluid">
      <h2 class="mt-3">LG CONSTANT DETAILS</h2>
      <ol class="breadcrumb mb-3">
         <a href="dashboard.php" class="breadcrumb-item">Home</a>
         <a href="lgconstant.php" class="breadcrumb-item active">LG Constant Details</a>
      </ol>
      <div class="row">
         <div class="col-md-12">
            <div class="card mb-4">
               <div class="card-header"><i class="fa fa-chart-bar mr-1"></i>LG Constant List
                  <button type="button" class="btn btn-outline-primary btn-sm float-right" onClick="openModelBox()" data-toggle="modal" data-target="#myModal">
                  <i class="fa fa-plus" aria-hidden="true"></i> Add New
                  </button>
               </div>
               <div class="card-body">
                  <input type="inputvalue" id="inputvalue" class="form-control card-margin col-sm-2" placeholder="Search Here.." />
                  <br>
                  <span  id="myTable"></span>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog">
            <span id="modelview">
         </div>
      </div>
   </div>
   <!-- End Model -->
</div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
    paramData = {'act':'searchConstant','filter_by':'all' }; 
    ajax({
         a: "lgconstantajax",
         b: paramData,
         c:function(){},
         d:function(data){
            $('#myTable').html(data);
         }
    });
    
    $('#inputvalue').keyup(function() {
           var filter_by = $(this).val();
             paramData = {'act':'searchConstant','filter_by':filter_by }; 
               ajax({
                  a:"lgconstantajax",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#myTable').html(data);
                 }
            });
      });
      
      paramData = {'act':'getAllData','type':'all'}; 
            ajax({
                  a:"lgconstantajax",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#myTable').html(data);
                  }
            });
            function openModelBox(id){
               paramData = {'id':id}
                  ajax({
                  a:"lgconstantajax",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                        $('#modelview').html(data);
                  }});
               };
   });
</script>
<?php } include "template.php"; ?>