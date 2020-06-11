<!--==================================
   Name: Manikandan;
   Create: 30/6/2020;
   Update: 4/6/2020;
   Use: MAIN TABLE FOR OFFICEBEARERS
 ====================================-->
<?php function main() { ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
<div id="layoutSidenav_content">
<div class="container-fluid">
   <h2 class="mt-3">Office Bearers Details</h2>
   <ol class="breadcrumb mb-3">
      <a href="dashboard.php" class="breadcrumb-item">Home</a>
      <a href="officebearers.php" class="breadcrumb-item active">Office Bearers Details</a>
   </ol>
   <div class="row">
      <div class="col-md-12">
         <!-- ============================== -->
         <!--       FORM HEADER              -->
         <!-- ============================== -->
         <div class="card-deck">
            <div class="card bg-info" >
               <div class="card-body text-center" id="D" onclick="test(this);">
                  <h6 class="card-text">
                     TOTAL DISTRICT USERS
                  </h6>
                  <?php 
                     $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>'D'.'-STRING'),'showSql'=>'N');
                     $role_hierarchy = Table::getData($param);
                     $TotalCount = count( $role_hierarchy);
                     ?>
                  <b><?php echo $TotalCount; ?></b>
               </div>
            </div>
            <div class="card bg-info">
               <div class="card-body text-center" id="M" onclick="test(this);">
                  <h6 class="card-text">TOTAL MANDAL USERS</h6>
                  <?php 
                     $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>'M'.'-STRING'),'showSql'=>'N');
                     $role_hierarchy = Table::getData($param);
                     $TotalCount = count( $role_hierarchy);
                     ?>
                  <b><?php echo $TotalCount; ?></b>
               </div>
            </div>
            <div class="card bg-info">
               <div class="card-body text-center"  id="W" onclick="test(this);">
                  <h6 class="card-text">TOTAL WARD USERS</h6>
                  <?php 
                     $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>'W'.'-STRING'),'showSql'=>'N');
                     $role_hierarchy = Table::getData($param);
                     $TotalCount = count( $role_hierarchy);
                     ?>
                  <b><?php echo $TotalCount; ?></b>
               </div>
            </div>
            <div class="card bg-info">
               <div class="card-body text-center" id="SK" onclick="test(this);">
                  <h6 class="card-text">SHAKTI KENDRA USERS</h6>
                  <?php 
                     $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>'SK'.'-STRING'),'showSql'=>'N');
                     $role_hierarchy = Table::getData($param);
                     $TotalCount = count( $role_hierarchy);
                     ?>
                  <b><?php echo $TotalCount; ?></b>
               </div>
            </div>
         </div>
         <br>
         <!-- ======= END HEADER ============ -->
         <div id="modelData" class="modal" role="dialog">
         </div>
         <br>
         <div class="card">
            <div class="card-header">
               Over All Office Bearers List
               <span style="float:right"><?php if( $_REQUEST['obid'] != '') { ?> <a href="officebearerstable.php" class="btn btn-info">View All</a> <?php } ?> </span>
            </div>
            <div class="card-body">
               <p id="notification" style="color:red"></p>
               <span id="myTable"></span>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="application/javascript">
   /********** 1. GET CARD DETAILS **********************/
         function test(value){
            var filter_by = $(value).attr("id");
            if(filter_by == 'M'){
               $('#notification').html('*Mandal Users Details');
            }else  if(filter_by == 'D'){
               $('#notification').html('*District Users Details')
            }else  if(filter_by == 'W'){
               $('#notification').html('*Ward Users Details')
            }else  if(filter_by == 'SK'){
               $('#notification').html('*Shakti Kendra Users Details')
            }
            paramData = {'act':'searchGetBox','type':'all','filter_by':filter_by }; 
            ajax({
                  a:"officebearersajax",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#myTable').html(data);
                  }
            });         
         }
   
      $(window).on("load", function() {
   /********** 2. DEFAULT LOAD DATA *********************/
            paramData = {'act':'searchGetBox','type':'all'}; 
            ajax({
                  a:"officebearersajax",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#myTable').html(data);
                  }
            });
   
               paramDatatable = {'act':'DataTable','type':'all','GetAll':'GetAllData','singleOfficeBearers':<?php if( $_REQUEST['obid'] != ''){ echo $_REQUEST['obid']; } else { echo 'null';} ?>}; 
               ajax({
                  a:"officebearersajax",
                  b:paramDatatable,
                  c:function(){},
                  d:function(data){
                     $('#myTable').html(data);
                  }
               });
   
      });
   
</script>
<?php } include "template.php"; ?>