<!--======================================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 5/6/2020;
   Use: ADD DISTRICT
   =======================================-->
   <?php
   function main() { 
   ?>
<div id="layoutSidenav_content">
   <div class="container-fluid">
      <h2 class="mt-3">District Details</h2>
      <ol class="breadcrumb mb-3">
      <a href="../dashboard.php" class="breadcrumb-item">Home</a>
         <a href="index.php" class="breadcrumb-item active">District Details</a>
      </ol>
      <div class="row">
         <div class="col-md-12">
            <div class="card mb-4">
               <div class="card-header"><img src="../assets/images/bjpnamelogo.png" height="40">
                  <button type="button" class="btn btn-sm btn-bjp float-right" onClick="openModelBox()" data-toggle="modal" data-target="#myModal">
                  <i class="fa fa-plus" aria-hidden="true"></i><strong>ADD NEW DISTRICT</strong>
                  </button>
               </div>
               <div class="card-body">
               <span class ="row" id="getTotalData" >
                  <input type="inputvalue" id="inputvalue" class="form-control card-margin col-sm-2" placeholder="Search District Here.." />
                  <h5 class="col-sm-5 offset-sm-4 mytextcolor" >TOTAL ACTIVE DISTRICT : <?php
                  $param = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'),'condition'  =>array('status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                  $district_list = Table::getData($param);
                  echo $TotalCount = count($district_list);
                  ?></h5>
                   <!-- <h5 class="col-sm-4 mytextcolor"  >TOTAL INACTIVE DISTRICT : <?php
                  // $param = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'),'condition'  =>array('status'=> 'I-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                  // $district_list = Table::getData($param);
                  // echo $TotalCount = count($district_list);
                  ?></h5> -->
                  </span>
                  <br>
                  <span  id="myTable"></span>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog">
            <span id="modelview"></span>
         </div>
      </div>
   </div>
   <!-- End Model -->
</div>
<script type="text/javascript">
   $(document).ready(function(){
    paramData = {'act':'searchDistrict','filter_by':'all' }; 
    ajax({
         a: "districtajax",
         b: paramData,
         c:function(){},
         d:function(data){
            $('#myTable').html(data);
         }
    });
    
    $('#inputvalue').keyup(function() {
           var filter_by = $(this).val();
             paramData = {'act':'searchDistrict','filter_by':filter_by }; 
               ajax({
                  a: "districtajax",
                  b: paramData,
                  c:function(){},
                  d:function(data){
                  $('#myTable').html(data);
                 }
            });
      });
   
      paramData = {'act':'getAllData','type':'all'}; 
            ajax({
                  a:"districtajax",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#myTable').html(data);
                  }
            });
            
            // function openModelBox(id){
            //    paramData = {'id':id}
            //       ajax({
            //       a:"districtajax",
            //       b:paramData,
            //       c:function(){},
            //       d:function(data){
            //             $('#modelview').html(data);
            //       }});
            //    };

            
   });


</script>
<?php } include "template.php"; ?>