<!--==================================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 12/6/2020;
   Use: ADD DISTRICT
   ====================================-->
   <?php
   include 'includes.php';
    $modelId = $_POST['dist_ID'];
    $modelAction = $_POST['action'];
    $subAction = $_POST['subaction'];
    $joined_date ='';
    if($modelId>0) { 
         $param = array('tableName'=>TBL_BJP_DISTRICT,'fields'=>array('*'),'condition'=>array('id'=>$modelId.'-INT'),'showSql'=>'N',);
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
      <?php if($title == 'EDIT'){ ?> 
         <span style="color:#eab15c"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT DISTRICT </span>
      <?php } else { ?>
         <span style="color:#286b28"><i class="fa fa-files-o" aria-hidden="true"></i> ADD DISTRICT </span>
      <?php } ?>
      </h5>
   </div>
   <div class="modal-body">
      <form action="javascript:void(0)" id="formDistrict" method="POST">
         <input type="hidden" value="addNewDisrict" name="act">
         <input type="hidden" value="<?php echo $modelId ?>" name="id">
         <div class="form-group">
            <label>Select State</label>
            <select class="form-control" name="state_id" required>
               <?php (isset($_POST["state_id"])) ? $state_id = $_POST["state_id"] : $role_hierarchy; ?>
               <option selected="true" disabled="disabled" value="">Please Select State</option>
               <option <?php if ($state_id == "1" ) echo 'selected' ; ?> value="1" >Tamilnadu</option>
            </select>
         </div>
         <div class="form-group">
            <label >Name of District</label>
            <input type="text" class="form-control" name="district_name"  value="<?php echo $district_name; ?>" required placeholder="Enter Name District Name">
         </div>
         <div class="form-group">
            <label >Tamil Name of District </label>
            <input type="text" class="form-control" name="district_name_ta"  value="<?php echo $district_name_ta; ?>" placeholder="Enter Tamil Name of District">
         </div>
         <div class="form-group">
            <label >Abbreviation  of District</label>
            <input type="text" class="form-control" name="district_abbr"  value="<?php echo $district_abbr; ?>" placeholder="Abbreviation of District">
         </div>
         <input type="submit" id="submit" class="btn btn-success" <?php  if($modelId == ''){ ?> value="Submit" <?php } else { ?> value="Update" <?php } ?>>
      </form>
   </div>
</div>
<!-- 2. DELETE MODEL DATA -->
<?php } else if ($modelAction == 'delete'){ ?>
<div class="modal-content">
   <div class="modal-header">
      <h5 class="modal-title" style="color:red"><i class="fa fa-trash" aria-hidden="true"></i>  DELETE RECORD</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="modal-body">
      <p>Are you sure cofirm delete this data.?</p>
   </div>
   <form id="formDistrictDelete" action="javascipt:void(0)">
      <input type="hidden" name="act" value="statusDataUpdate">
      <input type="hidden" name="id" value="<?php echo $modelId; ?>">
      <input type="hidden" value="I" name="status">
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <input type="submit" id="submit" class="btn btn-danger" value="Delete">
      </div>
   </form>
</div>
<!-- 3. RESTORE MODEL DATA -->
<?php } else if ($modelAction == 'restore'){ ?>
<div class="modal-content">
   <div class="modal-header">
      <h5 class="modal-title" style="color:#286b28"><i class="fa fa-recycle" aria-hidden="true"></i> RESTORE RECORD</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="modal-body">
      <p>Are you sure cofirm restore this data.?</p>
   </div>
   <form id="formDistrictDelete" action="javascipt:void(0)">
      <input type="hidden" name="act" value="statusDataUpdate">
      <input type="hidden" name="id" value="<?php echo $modelId; ?>">
      <input type="hidden" value="A" name="status">
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <input type="submit" id="submit" class="btn btn-success"  value="Restore">
      </div>
   </form>
</div>
<!-- 3. ALERT BOX MODEL  ---->
<?php } else if ($modelAction == 'alertBox'){ ?>
<div class="modal-content">
   <div class="modal-header">
      <h5 class="modal-title" style="color:red"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ALERT</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="modal-body">
      <p>Not Allowed. District Deactivated.!</p>
   </div>
   </form>
</div>
<!-- 5. ADD NEW MANDAL DATA -->
<?php } else if ($modelAction == 'addnewmandal') { ?>
<div class="modal-content">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 style="color:#286b28"><i class="fa fa-files-o" aria-hidden="true"></i> ADD MANDAL </h5>
   </div>
   <div class="modal-body">
      <form action="javascript:void(0)" id="formDataMandal" method="POST">
         <input type="hidden" value="addNewMandal" name="act">
         <!-- <input type="hidden" value="<?php //echo $modelId ?>" name="id"> -->
         <div class="row">
            <div class="form-group col-sm-6">
               <label for="exampleInputEmail1">Select State</label>
               <select class="form-control" name="state_id" readonly>
                  <?php (isset($_POST["state_id"])) ? $state_id = $_POST["state_id"] : $role_hierarchy;  ?>
                  <!-- <option selected="true" disabled="disabled" value="">Please Select State</option> -->
                  <option <?php if ($state_id == "1" ) echo 'selected' ; ?> value="1" >Tamilnadu</option>
               </select>
            </div>
            <div class="form-group col-sm-6">
               <label >Name of District</label>
               <select class="form-control" name="district_id" readonly>
                  <option  value="<?php echo $roleData->id ?>" ><?php echo $roleData->district_name ?></option>
               </select>
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-6">
               <label >MP Constituency </label>
               <select class="form-control" name="mp_const_id">
                  <?php (isset($_POST["mp_const_id"])) ? $mp_const_id = $_POST["mp_const_id"] : $mp_const_id; ?>
                  <option selected="true" disabled="disabled" value="">Please Select MP Constituency</option>
                  <?php $mpquery = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'),'condition'=>array('district_id'=>$modelId.'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                     $mpConstantData = Table::getData($mpquery);
                        foreach($mpConstantData as $Key=>$Val){ ?>
                  <option <?php if ($mp_const_id == $Val->id ) echo 'selected' ; ?> value="<?php echo $Val->id  ?>" ><?php echo $Val->bjp_mp_const_name ?></option>
                  <?php } ?>
               </select>
            </div>
            <div class="form-group col-sm-6">
               <label >LG Constituency </label>
               <select class="form-control" name="lg_const_id" >
                  <?php (isset($_POST["lg_const_id"])) ? $lg_const_id = $_POST["lg_const_id"] : $lg_const_id; ?>
                  <option selected="true" disabled="disabled" value="">Please Select LG Constituency</option>
                  <?php $lgquery = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                     $lgConstantData = Table::getData($lgquery);
                        foreach($lgConstantData as $Key=>$Val){ ?>
                  <option <?php if ($lg_const_id == $Val->id ) echo 'selected' ; ?> value="<?php echo $Val->id  ?>" ><?php echo $Val->lg_const_name ?></option>
                  <?php } ?>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label >Mandal Name</label>
            <input type="text" class="form-control" name="mandal_name"  value="<?php echo $mandal_name; ?>" placeholder="Enter Mandal Name.">
         </div>
         <div class="form-group">
            <label >Tamil Name of Mandal </label>
            <input type="text" class="form-control" name="mandal_tname"  value="<?php echo $mandal_tname; ?>" placeholder="Enter Mandal Tamil Name.">
         </div>
         <input type="submit" id="submit"   class="btn btn-success" value="Submit">
      </form>
   </div>
</div>
<!-- 6. DISTRICT DETAILS SHOW -->
<?php } else if ($modelAction == 'districtCard') { ?>
<div class="row" >
   <div class="card col-sm-4">
      <div class="card-body ">
      <span >Active Mandal  <?php
            $param = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span> 
         <span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body ">
      <span >Inactive Mandal  <?php
            $param = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'I-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span> 
         <span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body " >
         <span  >Total Mandal  <?php
            $param = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span> 
         <span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
</div>
<br>
<div class="row">
   <div class="card col-sm-4">
      <div class="card-body ">
         <span >Active Wards  <?php
            $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span><span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body ">
         <span >Inactive Wards  <?php
            $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'I-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span><span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body ">
         <span >Total Wards  <?php
            $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span><span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
</div>
<br>
<div class="row">
   <div class="card col-sm-4">
      <div class="card-body ">
         <span >Active MP Constituency  <?php
            $param = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span> 
         <span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body ">
         <span >Inactive MP Constituency  <?php
            $param = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'I-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span> 
         <span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body ">
         <span >Total MP Constituency  <?php
            $param = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span> 
         <span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
</div>
<br>
<div class="row">
   <div class="card col-sm-4">
      <div class="card-body ">
         <span  >Active LG Constituency <?php
            $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span><span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body ">
         <span  >Inactive LG Constituency <?php
            $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'I-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span><span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body ">
         <span  >Total LG Constituency <?php
            $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $district_list = Table::getData($param);
            ?></span><span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
</div>
<br>
<div class="row">
   <div class="card col-sm-4">
      <div class="card-body ">
         <span >verified users            
         <?php $memqueryverified = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','is_verified'=>'Y-CHAR','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $verifiedlist = Table::getData($memqueryverified);   
            ?>               
         </span> 
         <span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo  count($verifiedlist);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body ">
         <span >unverified users           
         <?php $memqueryverified = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','is_verified'=>'N-CHAR','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $verifiedlist = Table::getData($memqueryverified);   
            ?>               
         </span>
         </span>
         <span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo $TotalCount = count($district_list);
            ?></span>
      </div>
   </div>
   <div class="card col-sm-4">
      <div class="card-body ">
         <span >Total users            
         <?php $memqueryverified = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $verifiedlist = Table::getData($memqueryverified);   
            ?>               
         </span> 
         <span  class="valueCounter mytextcolor" style="font-size:3rem; float:right"><?php echo  count($verifiedlist);
            ?></span>
      </div>
   </div>
</div>
<!-- 7. MANDAL DETAILS SHOW -->
<?php } else if ($modelAction == 'mandalCard'){?>
<div class="row">
   <div class="col-md-12">
      <div class="card mb-4">
         <div class="card-header">
            <strong style="font-size:1.5rem;">
            <?php $param = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('id' => $_POST['mandal_ID'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
               $mandal_list = Table::getData($param);
               echo $mandal_list->mandal_tname; 
               echo ' (';
               echo $mandal_list->mandal_name;
               echo ')';
               ?>
            </strong>
            <span>
               <button type="button" class="btn btn-warning btn-sm float-right" id="getmandalvalue" data-toggle="modal" data-target="#myModal">
               <i class="fa fa-plus" aria-hidden="true"></i> ADD NEW WARD 
               </button>
            </span>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-12">
               <input type="hidden" value="<?php echo $mandal_list->id ?>" id="getMandalid">  
               <div class="row">
                  <div class="card col-sm-5 bg-info text-white">
                     <div class="card-body">
                        <h4>Total Wards
                        <span   class="valueCounter" style="float: right; right;font-size: 3rem;">
                           <?php $wardquery = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                              $ward_list = Table::getData($wardquery);         
                              echo count($ward_list);                                                                       
                              ?>               
                           </span>
                           </h4>
                     </div>
                  </div>
                  <div class="card offset-sm-1 col-sm-5 text-white" style="background-color:#ea8a2a">
                     <div class="card-body">
                        <h4>Total Shakti Kendram 
                           <span   class="valueCounter" style="float: right; right;font-size: 3rem;">
                           <?php
                              $skquery = array('tableName' => TBL_BJP_SK, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                              $sk_list = Table::getData($skquery);    
                              echo count($sk_list);                                                                       
                              ?>               
                           </span>
                        </h4>
                     </div>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="card col-sm-5 text-white" style="background-color:#f95e22">
                     <div class="card-body">
                        <h4>Total Booths 
                        <span   class="valueCounter" style="float: right; right;font-size: 3rem;">
                           <?php
                              $boothqry = "SELECT * FROM ".TBL_BJP_BOOTH." WHERE ward_id IN (SELECT id FROM ".TBL_BJP_WARD." WHERE mandal_id = ".$mandal_list->id." AND status = 'A')";
                              $boothList=dB::mExecuteSql($boothqry);   
                              echo count($boothList);                                                                     
                              ?>               
                           </span>
                        </h4>
                     </div>
                  </div>
                  <div class="card offset-sm-1 col-sm-5 text-white" style="background-color:#bb4470">
                     <div class="card-body">               
                         <h4>Total Members 
                         <span   class="valueCounter" style="float: right; right;font-size: 3rem;">
                           <?php $memquery = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                              $mem_list = Table::getData($memquery);  
                              echo  count($mem_list);                                                                         
                              ?>               
                           </span>
                        </h4>
                     </div>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="card col-sm-5 text-white" style="background-color:#d0bd62">
                     <div class="card-body">
                        <h4>Verified Members
                        <span class="">
                        <span   class="valueCounter" style="float: right; right;font-size: 3rem;">
                           <?php $memqueryverified = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','is_verified'=>'Y-CHAR','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                              $verifiedlist = Table::getData($memqueryverified);   
                              echo count($verifiedlist);                                                                       
                              ?>               
                           </span>
                           </span>
                        </h4>
                     </div>
                  </div>
                  <div class="card offset-sm-1 col-sm-5 text-white" style="background-color:#25bf9c">
                     <div class="card-body">
                        <h4>Non Verified Members
                        <span   class="valueCounter" style="float: right; right;font-size: 3rem;">
                           <?php $memquerynonverified = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','is_verified'=>'N-CHAR','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                              $nonverifiedlist = Table::getData($memquerynonverified);   
                              echo count($nonverifiedlist);                                                                       
                              ?>               
                           </span>
                        </h4>
                     </div>
                  </div>
               </div>


                  <hr>
                  <ul class="nav nav-tabs" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link" href="#ward" role="tab" onClick="wardDetailsget(<?php  echo $mandal_list->id; ?>)" data-toggle="tab">
                           <h5>WARD</h5>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#officebearers" role="tab"  onClick="officeBearesDetailsget(<?php  echo $mandal_list->id; ?>)" data-toggle="tab">
                           <h5>OFFICE BEARERS</h5>
                        </a>
                     </li>

                     <li class="nav-item" style="margin-left: 50%;">
                         <a class="nav-link btn btn-warning btn-sm" style="color:#ffffff" href="#newofficebearers" role="tab" onClick="addofficebearers(<?php echo $mandal_list->id; ?>,<?php echo $mandal_list->district_id; ?>)" data-toggle="tab">
                              <i class="fa fa-plus" aria-hidden="true"></i> ADD OFFICE BEARERS
                           </a>   
                     </li>
            
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in" id="ward">
                        <div id="wardDetails"></div>
                     </div>
                     <div role="tabpanel" class="tab-pane fade" id="officebearers">
                        <div id="officebearersDetails"></div>
                        <div id="mandalofficeBeares"></div>
                     </div>
                     <div role="tabpanel" class="tab-pane fade" id="newofficebearers">
                        <div id="newofficeBeares"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- 8. ADD NEW WARD -->
<?php } else if ($modelAction == 'addnewWard') { 

 $param = array('tableName'=>TBL_BJP_MANDAL,'fields'=>array('*'),'condition'=>array('id'=>$_POST['id'].'-INT'),'showSql'=>'N','status'=> 'A-CHAR');
 $mandalData = Table::getData($param);

 $param = array('tableName'=>TBL_BJP_DISTRICT,'fields'=>array('*'),'condition'=>array('id'=>$mandalData->district_id.'-INT'),'showSql'=>'N','status'=> 'A-CHAR');
 $DistrictData = Table::getData($param);

?>
<div class="modal-content">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 style="color:#286b28"><i class="fa fa-files-o" aria-hidden="true"></i> ADD WARD </h5>
   </div>
   <div class="modal-body">
      <form action="javascript:void(0)" id="formDataWard" method="POST">
         <input type="hidden" value="addNewWard" name="act">
         <div class="row">
            <div class="form-group col-sm-6">
               <label for="exampleInputEmail1">Name of District</label>
               <select class="form-control" name="district_id" required readonly>
                  <option  value="<?php echo $DistrictData->id ?>" ><?php echo $DistrictData->district_name ?></option>
               </select>
            </div>
            <div class="form-group col-sm-6">
               <label >Name of Mandal</label>
               <select class="form-control" name="mandal_id" required readonly>
                  <option  value="<?php echo $mandalData->id ?>" ><?php echo $mandalData->mandal_name ?></option>
               </select>
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-6">
               <label >MP Constituency </label>
               <select class="form-control" name="mp_const_id" required>
                  <?php (isset($_POST["mp_const_id"])) ? $mp_const_id = $_POST["mp_const_id"] : $mp_const_id; ?>
                  <option selected="true" disabled="disabled" value="">Please Select MP Constituency</option>
                  <?php $mpquery = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'),'condition'=>array('district_id'=>$mandalData->district_id.'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                     $mpConstantData = Table::getData($mpquery);
                        foreach($mpConstantData as $Key=>$Val){ ?>
                  <option <?php if ($mp_const_id == $Val->id ) echo 'selected' ; ?> value="<?php echo $Val->id  ?>" ><?php echo $Val->bjp_mp_const_name ?></option>
                  <?php } ?>
               </select>
            </div>
            <div class="form-group col-sm-6">
               <label >LG Constituency </label>
               <select class="form-control" name="lg_const_id" required>
                  <?php (isset($_POST["lg_const_id"])) ? $lg_const_id = $_POST["lg_const_id"] : $lg_const_id; ?>
                  <option selected="true" disabled="disabled" value="">Please Select LG Constituency</option>
                  <?php $lgquery = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'),'condition'=>array('district_id'=>$mandalData->district_id.'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                     $lgConstantData = Table::getData($lgquery);
                        foreach($lgConstantData as $Key=>$Val){ ?>
                  <option <?php if ($lg_const_id == $Val->id ) echo 'selected' ; ?> value="<?php echo $Val->id  ?>" ><?php echo $Val->lg_const_name ?></option>
                  <?php } ?>
               </select>
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-4">
               <label >Ward No</label>
               <input type="text" class="form-control" name="ward_number"  value="<?php echo $ward_number; ?>" placeholder="Enter Ward No.">
            </div>
            <div class="form-group col-sm-4">
               <label >Ward Old No </label>
               <input type="text" class="form-control" name="ward_number_old"  value="<?php echo $ward_number_old; ?>" placeholder="Enter Ward Old No.">
            </div>
            <div class="form-group col-sm-4">
               <label >Ward Zip Code </label>
               <input type="text" class="form-control" name="ward_zipcode"  value="<?php echo $ward_zipcode; ?>" placeholder="Enter Ward Zip Code.">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-6">
               <label >Ward Category</label>
               <select class="form-control" name="ward_category">
               <?php (isset($_POST["ward_category"])) ? $ward_category = $_POST["ward_category"] : $ward_category; ?>
                  <option selected="true" disabled="disabled" value="">Please Select Category</option>
                  <option <?php if ($ward_category == "P" ) echo 'selected' ; ?> value="P" >PUBLIC</option>
                  <option <?php if ($ward_category == "W" ) echo 'selected' ; ?> value="W" >WOMEN</option>
                  <option <?php if ($ward_category == "R" ) echo 'selected' ; ?> value="W" >RESERVED</option>
               </select>
            </div>
            <div class="form-group col-sm-6">
               <label >Ward Type</label>
               <select class="form-control" name="ward_type">
               <?php (isset($_POST["ward_type"])) ? $ward_type = $_POST["ward_type"] : $ward_type; ?>
                  <option selected="true" disabled="disabled" value="">Please Select Category</option>
                  <option <?php if ($ward_type == "R" ) echo 'selected' ; ?> value="R" >RURAL</option>
                  <option <?php if ($ward_type == "C" ) echo 'selected' ; ?> value="C" >CITY</option>
               </select>
            </div>
         </div>
         <input type="submit" id="submit"  class="btn btn-success" value="Submit">
      </form>
   </div>
</div>
<?php } else if ($modelAction == 'add_edit_OfficeBearers'){

   $ofID = $_POST['obid'];
   $title = ' Add New Office Bearers';
   $mandalID = $_POST['mandalid'];
   $distID = $_POST['districtID'];

   if($ofID>0){
   $officebearers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition'=>array('id'=>$ofID.'-INT','status'=> 'A-CHAR'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
   $officebearersList = Table::getData($officebearers);
   $title = 'Edit Office Bearers';
   }
   ?>
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title"><?php echo $title ?></h5>
         <button type="button" class="close" id="<?php echo $ofID ?>" onclick="closeMemberCard(this.id)">&times;</button>
      </div>
      <div class="modal-body">
         <form action="javascript:void(0)" id="formData" method="POST">
            <input type="hidden" value="addNewOfficeBearers" name="act">
            <input type="hidden" value="1" name="state_id">
            <input type="hidden" value="<?php echo $distID ?>" name="district_id">
            <input type="hidden" value="<?php echo $mandalID ?>" name="mandal_id" id="mandalID">
            <input type="hidden" value="<?php echo $ofID ?>" name="id" id="getOFId">

            <div class="row">
               <div class="form-group col-sm-6">
                     <label >Role Hierarachy</label>
                     <select class="form-control" name="role_hierarchy" id="roleHierarchy">
                     <?php (isset($officebearersList->role_hierarchy)) ? $officebearersList->role_hierarchy = $officebearersList->role_hierarchy : $officebearersList->role_hierarchy; ?>
                        <option selected="true" disabled="disabled" value="">Please Select Category</option>
                        <option <?php if ($officebearersList->role_hierarchy == "M" ) echo 'selected' ; ?> value="M" >Mandal</option>
                        <option <?php if ($officebearersList->role_hierarchy == "SK" ) echo 'selected' ; ?> value="SK" >Shakti Kendram</option>
                        <option <?php if ($officebearersList->role_hierarchy == "W" ) echo 'selected' ; ?> value="W" >Ward</option>
                        <option <?php if ($officebearersList->role_hierarchy == "B" ) echo 'selected' ; ?> value="B" >Booth</option>
                     </select>
               </div>
               <div class="form-group col-sm-6">
                     <label >Sub Role Hierarachy</label>
                     <select class="form-control" name="sub_role_hierarchy" id="subRole">
                     <?php (isset($officebearersList->sub_role_hierarchy)) ? $officebearersList->sub_role_hierarchy =$officebearersList->sub_role_hierarchy : $officebearersList->sub_role_hierarchy; ?>
                        <option selected="true" disabled="disabled" value="">Please Select Category</option>
                        <option <?php if ($officebearersList->sub_role_hierarchy == "SK" ) echo 'selected' ; ?> value="SK" >Shakti Kendram</option>
                        <option <?php if ($officebearersList->sub_role_hierarchy == "W" ) echo 'selected' ; ?> value="W" >Ward</option>
                        <option <?php if ($officebearersList->sub_role_hierarchy == "B" ) echo 'selected' ; ?> value="B" >Booth</option>
                     </select>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6 col-lg-6">
                  <label>Role Position </label>
                  <select class="form-control" id="showData" name="role_id">
                  </select>
               </div>
               <div class="col-sm-6">
                     <label>Member Id </label>
                     <div class="input-group mb-3">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                        </div>
                        <input type="text" class="form-control" id="memberID" onkeypress="searchKey(this.id)"  placeholder="Enter You Member ID">                  
                     </div>
               </div> 
            </div>
            <span id="memberTable">
               <!-- <span id="showNotifycation"></span>              -->
            </span>
            <input type="submit" id="submit" class="btn btn-success" data-dismiss="modal"  value="Submit">
         </form>
      </div>
   </div>

<?php } ?>
<script>
/************* FORM SUBMIT ************/
   /* 1. Add Edit District Form */
      $('form#formDistrict').validate({
         rules: {
         state_id: "required",
         district_name: "required",
         },
         messages: {
            state_id: "Please Select One State",
            district_name: "Please Enter District Name",
         },
         submitHandler: function(form){
         var formData = $('form#formDistrict').serialize();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('#myModal').modal('toggle');
                  paramData = {'act':'getAllData','type':'all'}; 
                     ajax({
                           a:"districtajax",
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

   /*  2. Delete Restore District Form */
      $('form#formDistrictDelete').validate({
         submitHandler: function(form){
         var formData = $('form#formDistrictDelete').serialize();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('#myModal').modal('toggle');
                  paramData = {'act':'getAllData','type':'all'}; 
                     ajax({
                           a:"districtajax",
                           b:paramData,
                           c:function(){},
                           d:function(data){
                              $('#myTable').html(data);
                           }
                     });
               }          
            });
         }
      })

   /* 3. Add Mandal Form */
      $('form#formDataMandal').validate({
         rules: {
         state_id: "required",
         mp_const_id: "required",
         lg_const_id: "required",
         mandal_name: "required",
         },
         messages: {
            mp_const_id: "Please Select One MP Constituency",
            lg_const_id: "Please Select One LG Constituency",
            mandal_name: "Select Enter Mandal Name",
         },
         submitHandler: function(form){
         var formData = $('form#formDataMandal').serialize();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('#myModal').modal('toggle');
                  $("#inputvalue" ).trigger( "keyup" );
               }          
            });
         }
      });

   /* 4. Add Ward Form */
      $('form#formDataWard').validate({
         rules: {
         district_id: "required",
         mandal_id: "required",
         mp_const_id: "required",
         lg_const_id: "required",
         ward_number: "required",
         ward_category: "required",
         ward_type: "required",

         },
         messages: {
            mp_const_id: "Please Select One MP Constituency",
            lg_const_id: "Please Select One LG Constituency",
            ward_number: "Select Enter Ward Name",
            ward_category: "Please Select Category",
            ward_type: "Please Select Ward Type",
         },
         submitHandler: function(form){
         var formData = $('form#formDataWard').serialize();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('#myModal').modal('toggle');
                  $("#inputvalue" ).trigger( "keyup" );
               }          
            });
         }
      });

   $('form#formData').validate({
      rules: {
      role_hierarchy: "required",
      membership_number: "required",
      person_name: "required",
      mobile_number: "required",
      },
      messages: {
         role_hierarchy: "Please Select One Role Hierarchy",
         membership_number: "Please Enter Membership Number",
         person_name: "Enter Person Name",
         mobile_number: "Enter Mobile Number"
      },
      submitHandler: function(form){
      var formData = $('form#formData').serialize();
      var closeId = $('#getOFId').val();
      var id = $('#mandalID').val();
      var role = $('#roleHierarchy').val();
         ajax({
            a:"districtajax",
            b:formData,
            c:function(){},
            d:function(data){
               $('#memberTable').html('<p style="color:green">Record Updated.!</p>');
               $("#inputvalue" ).trigger( "keyup" );
               $('#editOfficeBearers_'+closeId).remove();
               officeBearesDetailsget(id);
               getStateUsers(id,role);
               }          
         });
      }
   });

/*********** WRAD DETAILS GET *********/
   function wardDetailsget(id){
      paramData = {'act':'wardDetailsGet','id':id }; 
         ajax({
            a:"districtajax",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#wardDetails').html(data);
            }
      });
   }

/**** OFFICE BEARES DETAILS GET *******/
   function officeBearesDetailsget(id){
      paramData = {'act':'officeBearesDetailsget','id':id }; 
         ajax({
            a:"districofficebearers",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#officebearersDetails').html(data);
            }
      });
   }

/*********** VALUE COUNTER  ***********/
   $('.valueCounter').each(function () {
      var $this = $(this);
      jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
         duration: 1500,
         easing: 'swing',
         step: function () {
            $this.text(Math.ceil(this.Counter));
         }
      });
   });

/*********** ADD NEW WARD  ************/
   $('#getmandalvalue').click(function() {
         var id = $('#getMandalid').val();
           paramData = {'id':id,'action':'addnewWard'}
            ajax({
                  a:"districtmodel",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#modelview').html(data);
                  }
            });        
   });

/*********** ADD NEW OFFICEBEARERS ****/

      function addofficebearers(id,distID) {
           paramData = {'mandalid':id,'districtID':distID,'action':'add_edit_OfficeBearers'}
            ajax({
                  a:"districtmodel",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#newofficeBeares').html(data);
                  }
            });        
      };

/*********** MAIN ROLE HIERARCHY   ****/

      $('#roleHierarchy').change(function() {
         var mainRole = $(this).val();

         paramPosition = {'act':'findrolePosition','position':mainRole };
         ajax({
            a:"districtajax",
            b:paramPosition,
            c:function(){},
            d:function(data){
                  if(data.trim() != '') {
                  $('#showData').html(data);
               }  
               if(data.trim() == '') {
                  $('#showData').html('<option selected="true" disabled="disabled" value="">Please Select Position</option>');
               }
            }
         });
         if (mainRole == "SK") {
            $("#subRole").attr('disabled', false);
            $("#subRole").not(this).find("option[value=SK]").attr('disabled', true);
            $("#subRole").not(this).find("option[value=W]").attr('disabled', false);
            $("#subRole").not(this).find("option[value=B]").attr('disabled', false);
         } else if(mainRole == "M") {
            $("#subRole").attr('disabled', false);
            $("#subRole").not(this).find("option[value=SK]").attr('disabled', false);
            $("#subRole").not(this).find("option[value=W]").attr('disabled', false);
            $("#subRole").not(this).find("option[value=B]").attr('disabled', false);
         } else if(mainRole == "W") {
            $("#subRole").attr('disabled', false);
            $("#subRole").not(this).find("option[value=SK]").prop('disabled', true);
            $("#subRole").not(this).find("option[value=W]").prop('disabled', true);
            $("#subRole").not(this).find("option[value=B]").prop('disabled', false);
         } else if(mainRole == "B") {
            $("#subRole").attr('disabled', true);
         }
      });
   
/*********** SEARCH MEMBER DETAILS  ***/

      function searchKey(id_attr) { 
         $( "#"+id_attr).autocomplete({
         source: function( request, response ) {
               $('#update_response_'+id_attr).html('processing...'); 
               var mandal = $('#getMandalid').val();
            // Fetch data
            $.ajax({
            url: "districtajax.php",
            type: 'post',
            dataType: "json",
            data: {
            search: request.term,mandal
            },
            success: function( data ) { 
               // alert(data);
               response( data );
            }
            });
         },
         select: function (event, ui) {
            $('#'+id_attr).val(ui.item.label); 
            $('.'+id_attr).val(ui.item.value);      
            paramMember = {'act':'memberDetails','filter_by':ui.item.value }; 
                  ajax({
                     a: "districtajax",
                     b: paramMember,
                     c:function(){},
                     d:function(data){
                        $('#memberTable').html(data);
                     }
               });
   
            return false;
         }
         });
      }
   
/*********** CLOSE MEMBER EDIT CARD ******/

   function closeMemberCard(id){
         $('#editOfficeBearers_'+id).remove();
   }

</script>