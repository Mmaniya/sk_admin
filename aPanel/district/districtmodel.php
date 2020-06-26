<!--==================================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 13/6/2020;
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
<?php } else if ($modelAction == 'districtCard') { 
  $district = 'select *, (select role_abbr from '.TBL_BJP_ROLE.' where id = role_id ) as position,(select role_name from '.TBL_BJP_ROLE.' where id = role_id ) as rolename from '.TBL_BJP_OFFICE_BEARERS.' where `district_id`="'.$modelId.'" AND `role_hierarchy` ="D" AND `status`="A"';
   $distpresitent = dB::mExecuteSql($district);
   foreach($distpresitent as $K=>$V){
   if($V->position == 'DP'){                           
      ?>
   <div class="row">
      <div class="card col-sm-12">
         <div class="card-body row"> 
            <div class="col-sm-10">               
               <h4><?php echo $V->person_name; echo '('; echo $V->person_name_ta; echo ')'; ?></h4>
               <h4><?php echo $V->mobile_number ?></h4>  
               <h4 class="mytextcolor"><?php echo $V->rolename ?></h4>  
            </div> 
            <div class="col-sm-2">
               <?php  
                   $mem = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('id' => $V->member_id.'-CHAR','status'=> 'A-CHAR'), 'showSql' => 'N');
                    $memberquery = Table::getData($mem);
                    if($memberquery->member_photo != ''){
                     ?>               
                     <img  src="<?php echo TBL_MEMBER_BASE_URL ?><?php echo $memberquery->member_photo ?>" height="100" weight="30" alt="District President">
                    <?php } else { ?>
                     <img  src="../assets/images/user.jpg" height="100" weight="30" alt="District President">
                  <?php } ?>
            </div>                                      
         </div>
      </div>
   </div>
   <br>
   <?php } } ?>
<div class="row" >
   <div class="col-sm-6">
      <div class="card text-white" style="background-color:#71dff1">
         <div class="card-body">
            <h3>Total Mandal  <?php
                  $param = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                  $mandal_list = Table::getData($param);
                  ?>
               <span  class="valueCounter" style="font-size:3rem; float:right"><?php echo $TotalCount = count($mandal_list);?></span>
            </h3> 
         </div>
      </div>
   </div>
   <div class="col-sm-6">
      <div class="card text-white" style="background-color:#ffba76">
         <div class="card-body" >
            <h3 >Total Wards  <?php
               $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
               $ward_list = Table::getData($param);
               ?>
               <span  class="valueCounter" style="font-size:3rem; float:right"><?php echo $TotalCount = count($ward_list);?>
            </h3> 
         </div>
      </div>
   </div>
</div>
<br>
<div class="row" >
   <div class="col-sm-6">
      <div class="card text-white" style="background-color:#ef8f6a">
         <div class="card-body">
            <h3>Total MP Constituency  <?php
                 $param = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                 $constituency_list = Table::getData($param);
                 ?>
              <span  class="valueCounter" style="font-size:3rem; float:right"><?php echo $TotalCount = count($constituency_list);?></span>
            </h3> 
         </div>
      </div>
   </div>
   <div class="col-sm-6">
      <div class="card text-white" style="background-color:#e46594">
         <div class="card-body" >
            <h3 >Total LG Constituency  <?php
               $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
               $lg_constituency_list = Table::getData($param);
               ?>
               <span  class="valueCounter" style="font-size:3rem; float:right"><?php echo $TotalCount = count($lg_constituency_list);?></span>
            </h3> 
         </div>
      </div>
   </div>
</div>
<br>
<div class="row" >
   <div class="col-sm-6">
      <div class="card text-white" style="background-color:#d0bd62">
         <div class="card-body">
            <h3>Total Booth  <?php
                 $param = "SELECT * FROM ".TBL_BJP_BOOTH." WHERE ward_id IN (SELECT id FROM ".TBL_BJP_WARD." WHERE district_id = ". $_POST['dist_ID']." AND status = 'A')";
                 $Booth_list = dB::mExecuteSql($param);   
                 ?>
              <span  class="valueCounter" style="font-size:3rem; float:right"><?php echo $TotalCount = count($Booth_list);?></span>
            </h3> 
         </div>
      </div>
   </div>
   <div class="col-sm-6">
      <div class="card text-white" style="background-color:#25bf9c">
         <div class="card-body" >
            <h3 >Total Members<?php              
              $memqueryverified = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist_ID'].'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
              $verifiedlist = Table::getData($memqueryverified);   
              ?>               
               <span  class="valueCounter" style="font-size:3rem; float:right"><?php echo  count($verifiedlist);?></span>
            </h3> 
         </div>
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
               <button type="button" class="btn btn-warning btn-sm float-right" style="color:#FFF" id="getmandalvalue" data-toggle="modal" data-target="#myModal">
               <i class="fa fa-plus" aria-hidden="true"></i> ADD NEW WARD 
               </button>
            </span>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-12">
               <input type="hidden" value="<?php echo $mandal_list->id ?>" id="getMandalid">  
               <span id="mandalThalaivar"></span>              
               <div class="row">
                  <div class="col-sm-4">
                     <div class="card text-white" style="background-color:#71dff1">
                        <div class="card-body">
                           <h5>Total Wards
                              <span   class="valueCounter" style="float: right; right;font-size: 2.5rem;">
                              <?php $wardquery = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                                 $ward_list = Table::getData($wardquery);         
                                 echo count($ward_list);                                                                       
                                 ?>               
                              </span>
                           </h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card text-white" style="background-color:#ffba76">
                        <div class="card-body">
                           <h5>Total SK
                              <span   class="valueCounter" style="float: right; right;font-size: 2.5rem;">
                              <?php
                                 $skquery = array('tableName' => TBL_BJP_SK, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                                 $sk_list = Table::getData($skquery);    
                                 echo count($sk_list);                                                                       
                                 ?>               
                              </span>
                           </h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card  text-white" style="background-color:#ef8f6a">
                        <div class="card-body">
                           <h5>Total Booth
                              <span   class="valueCounter" style="float: right; right;font-size: 2.5rem;">
                              <?php
                                 $boothqry = "SELECT * FROM ".TBL_BJP_BOOTH." WHERE ward_id IN (SELECT id FROM ".TBL_BJP_WARD." WHERE mandal_id = ".$mandal_list->id." AND status = 'A')";
                                 $boothList=dB::mExecuteSql($boothqry);   
                                 echo count($boothList);                                                                     
                                 ?>               
                              </span>
                           </h5>
                        </div>
                     </div>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-4">
                     <div class="card text-white" style="background-color:#e46594">
                        <div class="card-body">               
                           <h5>Total Members 
                              <span   class="valueCounter" style="float: right; right;font-size: 2.5rem;">
                                 <?php $memquery = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                                 $mem_list = Table::getData($memquery);  
                                 echo  count($mem_list);                                                                         
                                 ?>               
                              </span>
                           </h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card text-white" style="background-color:#d0bd62">
                        <div class="card-body">
                           <h5>Verified Members
                           <span class="">
                           <span   class="valueCounter" style="float: right; right;font-size: 2.5rem;">
                              <?php $memqueryverified = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','is_verified'=>'Y-CHAR','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                                 $verifiedlist = Table::getData($memqueryverified);   
                                 echo count($verifiedlist);                                                                       
                                 ?>               
                              </span>
                              </span>
                           </h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card text-white" style="background-color:#25bf9c">
                        <div class="card-body">
                           <h5>Unverified Members
                           <span   class="valueCounter" style="float: right; right;font-size: 2.5rem;">
                              <?php $memquerynonverified = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('mandal_id' => $mandal_list->id.'-INT','is_verified'=>'N-CHAR','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                                 $nonverifiedlist = Table::getData($memquerynonverified);   
                                 echo count($nonverifiedlist);                                                                       
                                 ?>               
                              </span>
                           </h5>
                        </div>
                     </div>
                  </div>
               </div>
               <br>
                  <hr>
                  <ul class="nav nav-tabs" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" href="#ward" role="tab" onClick="wardDetailsget(<?php  echo $mandal_list->id; ?>)" data-toggle="tab">
                           <h5 style="color:#000">WARD</h5>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#officebearers" role="tab"  onClick="officeBearesDetailsget(<?php  echo $mandal_list->id; ?>)" data-toggle="tab">
                           <h5 style="color:#000">OFFICE BEARERS</h5>
                        </a>
                     </li>
                     <li class="nav-item" style="margin-left: 42%;margin-top: 0.5%">
                         <a class="nav-link" href="#newofficebearers" role="tab" onClick="addofficebearers(<?php echo $mandal_list->id; ?>,<?php echo $mandal_list->district_id; ?>)" data-toggle="tab">
                              <i class="fa fa-plus" aria-hidden="true"></i> ADD OFFICE BEARERS
                           </a>   
                     </li>            
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                     <div role="tabpanel " class="tab-pane fade in active show" id="ward">
                        <div id="wardDetails"></div>
                        <div id="wardFullDetails"></div>
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
<script>
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
</script>
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

<!-- 9. ADD NEW OFFICE BEARERS -->
<?php } else if ($modelAction == 'officeBearersNew'){ ?>
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title">ADD NEW OFFICE BEARERS</h5>
      </div>
      <div class="modal-body">

            <label class="radio-inline col-sm-2">
               <input type="radio" name="optradio" value="M"> Mandal 
            </label>
            <label class="radio-inline col-sm-2">
               <input type="radio" name="optradio" value="W"> Ward
            </label>
            <label class="radio-inline col-sm-3">
               <input type="radio" name="optradio" value="SK"> Shakti Kendram
            </label>
            <label class="radio-inline col-sm-2">
               <input type="radio" name="optradio" value="B"> Booth
            </label>
            <input type="hidden" value="<?php echo $_POST['mandalid']; ?>"id="Mandal">
            <input type="hidden" value="<?php echo $_POST['districtID']; ?>"id="District">

         <div id="viewoboptions"></div>  

      </div>
</div>

<!-- 10. DELETE WARD MEMBER -->
<?php } else if ($modelAction == 'deleteWardMembers'){ ?>
<div class="modal-content">
   <div class="modal-header">
      <h5 class="modal-title" style="color:red"><i class="fa fa-trash" aria-hidden="true"></i>  DELETE RECORDS</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="modal-body">
      <p>Are you sure cofirm delete this data.?</p>
   </div>
   <form id="deleteWardMembers" action="javascipt:void(0)">
      <input type="hidden" name="act" value="statusDataUpdateforOB">
      <input type="hidden" name="id" value="<?php echo $_POST['ofid']; ?>" id="officeBeraersId">
      <input type="hidden" name="" value="<?php echo $_POST['ward'] ?>" id="ward_Id">
      <input type="hidden" name="subRole" value="<?php echo $_POST['subRole'] ?>" id="subRole">
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <input type="submit" id="submit" class="btn btn-danger"  value="Delete">
      </div>
   </form>
</div>

<!-- 10. DELETE OFFICE BEARERS -->
<?php } else if($modelAction == 'deleteOfficeBearers'){?>
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
   <form id="deleteOfficeBearers" action="javascipt:void(0)">
      <input type="hidden" name="act" value="statusDataUpdateforOB">
      <input type="hidden" name="id" value="<?php echo $_POST['ofid']; ?>" id="officeBeraersId">
      <input type="hidden" name="subRole" value="<?php echo $_POST['role'] ?>" id="subRole">
      <!-- <input type="hidden" name="status" value="<?php //echo $_POST['status'] ?>"> -->
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
         <input type="submit" id="submit" class="btn btn-danger"  value="Delete">
      </div>
   </form>
</div>

<!-- 11. EDIT OFFICE BEARERS -->
<?php } else if($modelAction == 'editOfficeBearers'){?>

<div class="modal-content">
   <div class="modal-header">
      <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> EDIT OFFICEBEARERS</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="modal-body">
      <form action="javascript:void(0)" id="formEditOfficeBearers" method="POST">
         <div class="row">
            <div class="form-group col-sm-6">
               <?php $wquery = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition'=>array('id'=>$_POST['obid'].'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                  $wqueryList = Table::getData($wquery);?>
               <input type="hidden" value="editOfficeBearers" name="act">
               <input type="hidden" value="1" name="state_id">
               <input type="hidden" value="<?php  echo $_POST['role'] ?>" id="selectedOb">
               <input type="hidden" value="<?php  echo $wqueryList->district_id ?>" name="district_id">
               <input type="hidden" value="<?php  echo $wqueryList->mandal_id ?>" name="mandal_id" id="mandalID"> 
               <input type="hidden" value="<?php  echo $wqueryList->role_hierarchy ?>" name="role_hierarchy" id="role_hierarchy"> 
               <input type="hidden" value="<?php  echo $wqueryList->sub_role_hierarchy ?>" name="sub_role_hierarchy" id="sub_role_hierarchy"> 
               <input type="hidden" value="<?php  echo $wqueryList->ward_id ?>" name="ward_id" id="ward_id"> 
               <input type="hidden" value="<?php  echo $wqueryList->booth_id ?>" name="booth_id" id="booth_id"> 
               <label >Member Name</label>
               <input type="text" class="form-control" readonly name="person_name" value="<?php echo $wqueryList->person_name; ?>" placeholder="Enter Member Name.">
               <input type="hidden" class="form-control" name="id" id="officeBearersId" readonly value="<?php echo $_POST['obid']; ?>">
            </div>
            <div class="form-group col-sm-6">
               <label >Membership No</label>
               <input type="text" class="form-control" name="membership_number" value="<?php echo $wqueryList->membership_number; ?>" placeholder="Membership Number">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-6">
               <label >Enter Mobile Number</label>
               <input type="text" class="form-control" name="mobile_number" value="<?php echo $wqueryList->mobile_number; ?>" placeholder="Enter Mobile Number.">
            </div>
            <div class="form-group col-sm-6">
               <label >Enter Whatsapp Number</label>  
               <input type="text" class="form-control" name="whatsapp_number" value="<?php echo $wqueryList->whatsapp_number; ?>" placeholder="Enter Whatsapp Number">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-12">
               <label >Address</label>
               <input type="text" class="form-control" name="address" value="<?php echo $wqueryList->address; ?>" placeholder="Booth Address">
            </div>
         </div>
         <div class="row">
            <?php if($wqueryList->role_hierarchy == "M" && $_POST['role'] == 'M'){ ?>
            <div class="form-group col-sm-7">
               <label > Are you sure change main role</label>
               <input type="checkbox" id="getRole"  value="">
               <span id="showselectBox"></span>
            </div>
            <?php } else if($wqueryList->role_hierarchy == "W" || $wqueryList->sub_role_hierarchy == "W" && $_POST['role'] == 'W'){?>
            <div class="form-group col-sm-7">
               <label> Are you sure change ward</label>
               <input type="checkbox" id="getAvailWard"  value="">
               <span id="displayWard"></span>
            </div>
            <?php } else if($wqueryList->role_hierarchy == "SK" || $wqueryList->sub_role_hierarchy == "SK" && $_POST['role'] == 'SK'){ ?>
            <div class="form-group col-sm-7">
               <label> Are you sure change sk booth</label>
               <input type="checkbox" class="getAvailBooth"  value="<?php echo $_POST['obid']; ?>" >
            </div>
            <?php } else if($wqueryList->role_hierarchy == "B" || $wqueryList->sub_role_hierarchy == "B" && $_POST['role'] == 'B'){ ?>
            <div class="form-group col-sm-7">
               <label> Are you sure change booth</label>
               <input type="checkbox" class="getAvailBooth" id="getBooth"  value="<?php echo $_POST['obid']; ?>">
            </div>
            <?php } ?>
            <div class="row col-sm-12" id="displaySKward">
               <div class="form-group col-sm-6">
                  <?php  $qry = 'select * from '.TBL_BJP_WARD.' where `mandal_id` ='.$wqueryList->mandal_id.' AND id='.$wqueryList->ward_id.' AND `status`="A"';
                     $wardFullDetails=dB::mExecuteSql($qry); ?>
                  <input type="text" class="form-control" readonly value="<?php  foreach($wardFullDetails as $Key=>$val) { echo $val->ward_number; } ?>" >
               </div>
               <div class="form-group col-sm-6">
                  <select class="form-control selectsubRoleBooth" multiple style="width:100%" id="multiSelectBooth" name="updateBooth[]"></select>
               </div>
            </div>
            <!-- <div class="row col-sm-12" id="displayBooth">
               <div class="form-group col-sm-6">
                  <?php  $qry = 'select * from '.TBL_BJP_WARD.' where `mandal_id` ='.$wqueryList->mandal_id.' AND id='.$wqueryList->ward_id.' AND `status`="A"';
                     $wardFullDetails=dB::mExecuteSql($qry); ?>
                  <input type="text" class="form-control" readonly value="<?php  foreach($wardFullDetails as $Key=>$val) { echo $val->ward_number; } ?>" >
               </div>
               <div class="form-group col-sm-6">
                  <select class="form-control selectsubRoleBooth" style="width:100%" name="boothupdate"></select>
                  <div class="displayerror"></span>
                  </div>
               </div>
            </div> -->
         </div>
         <div class="displayerror"></div>
         <input type="submit" id="submit" class="btn btn-success" value="Submit">
      </form>
   </div>
</div>
<script>
   // 1. Get the mandal role position
      $('#getRole').click(function(){
         if($(this).prop("checked") == true){
            $('#showselectBox').show();
            var mandalid = $('#mandalID').val();
            var role = $('#role_hierarchy').val();
            paramPosition = {'act':'findrolePosition','position':role,'mandalID':mandalid };
            ajax({
               a:"districtajax",
               b:paramPosition,
               c:function(){},
               d:function(data){
                  $('#showselectBox').html('<select class="form-control" name="role_id" value="">'+data+'</select>');
               }
            });
         } else if($(this).prop("checked") == false){
            $('#showselectBox').hide();
         }
      });
   // 2. Get the availabe ward 
      $('#getAvailWard').click(function(){
         if($(this).prop("checked") == true){
            $('#displayWard').show();
            var mandalid = $('#mandalID').val();
            var role = $('#role_hierarchy').val();
            paramPosition = {'act':'findavailableWard','position':role,'mandalID':mandalid };
            ajax({
               a:"districtajax",
               b:paramPosition,
               c:function(){},
               d:function(data){
                  $('#displayWard').html('<select class="form-control" name="updateWard_id" value="">'+data+'</select>');
               }
            });
         } else if($(this).prop("checked") == false){
            $('#displayWard').hide();
         }
      });
   // 3. Get the available  for sk
      $('#displaySKward').hide();

      $('#getBooth').click(function(){
         $(".selectsubRoleBooth").prop("multiple", (this.checked) ? "" : "");
      });
      $('.getAvailBooth').click(function(){
         if($(this).prop("checked") == true){
            var obid = $(this).val();
            $('#displaySKward').show();
            var ward_id = $('#ward_id').val();
            var mandalid = $('#mandalID').val();
            var boothID = $('#booth_id').val()
            paramPosition = {'act':'findselectedBooth','wardID':ward_id,'mandalID':mandalid,'obid':obid,'boothID':boothID };
               ajax({
               a:"districtajax",
               b:paramPosition,
               c:function(){},
               d:function(data){
                     $('.selectsubRoleBooth').html(data);
                     $('.selectsubRoleBooth').multiselect('rebuild');
                  }
               });
         } else if($(this).prop("checked") == false){
            $('#displaySKward').hide();
         }
      });
</script>

<!-- 12. DELETE OFFICE BEARERS -->
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

<!-- 13. EDIT WARD OFFICE BEARERS -->
<?php } else if($modelAction == 'editwardOfficeBearers'){?>

   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> EDIT OFFICEBEARERS</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="javascript:void(0)" id="formEditOfficeBearers" method="POST">
            <div class="row">
               <div class="form-group col-sm-6">
                  <?php $wquery = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition'=>array('id'=>$_POST['obid'].'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                     $wqueryList = Table::getData($wquery);?>
                  <input type="hidden" value="editOfficeBearers" name="act">
                  <input type="hidden" value="1" name="state_id">
                  <input type="hidden" value="<?php  echo $_POST['role'] ?>" id="selectedOb">
                  <input type="hidden" value="<?php  echo $wqueryList->district_id ?>" name="district_id">
                  <input type="hidden" value="<?php  echo $wqueryList->mandal_id ?>" name="mandal_id" id="mandalID"> 
                  <input type="hidden" value="<?php  echo $wqueryList->role_hierarchy ?>" name="role_hierarchy" id="role_hierarchy"> 
                  <input type="hidden" value="<?php  echo $wqueryList->sub_role_hierarchy ?>" name="sub_role_hierarchy" id="sub_role_hierarchy"> 
                  <input type="hidden" value="<?php  echo $wqueryList->ward_id ?>" name="ward_id" id="ward_id"> 
                  <input type="hidden" value="<?php  echo $wqueryList->booth_id ?>" name="booth_id" id="booth_id"> 
                  <label >Member Name</label>
                  <input type="text" class="form-control" readonly name="person_name" value="<?php echo $wqueryList->person_name; ?>" placeholder="Enter Member Name.">
                  <input type="hidden" class="form-control" name="id" id="officeBearersId" readonly value="<?php echo $_POST['obid']; ?>">
               </div>
               <div class="form-group col-sm-6">
                  <label >Membership No</label>
                  <input type="text" class="form-control" name="membership_number" value="<?php echo $wqueryList->membership_number; ?>" placeholder="Membership Number">
               </div>
            </div>
            <div class="row">
               <div class="form-group col-sm-6">
                  <label >Enter Mobile Number</label>
                  <input type="text" class="form-control" name="mobile_number" value="<?php echo $wqueryList->mobile_number; ?>" placeholder="Enter Mobile Number.">
               </div>
               <div class="form-group col-sm-6">
                  <label >Enter Whatsapp Number</label>  
                  <input type="text" class="form-control" name="whatsapp_number" value="<?php echo $wqueryList->whatsapp_number; ?>" placeholder="Enter Whatsapp Number">
               </div>
            </div>
            <div class="row">
               <div class="form-group col-sm-12">
                  <label >Address</label>
                  <input type="text" class="form-control" name="address" value="<?php echo $wqueryList->address; ?>" placeholder="Booth Address">
               </div>
            </div>
            <div class="row">
               <?php if($wqueryList->role_hierarchy == "M" && $_POST['role'] == 'M'){ ?>
               <div class="form-group col-sm-7">
                  <label > Are you sure change main role</label>
                  <input type="checkbox" id="getRole"  value="">
                  <span id="showselectBox"></span>
               </div>
               <?php } else if($wqueryList->role_hierarchy == "W" || $wqueryList->sub_role_hierarchy == "W" && $_POST['role'] == 'W'){?>
               <div class="form-group col-sm-7">
                  <label> Are you sure change ward</label>
                  <input type="checkbox" id="getAvailWard"  value="">
                  <span id="displayWard"></span>
               </div>
               <?php } else if($wqueryList->role_hierarchy == "SK" || $wqueryList->sub_role_hierarchy == "SK" && $_POST['role'] == 'SK'){ ?>
               <div class="form-group col-sm-7">
                  <label> Are you sure change sk booth</label>
                  <input type="checkbox" class="getAvailBooth"  value="<?php echo $_POST['obid']; ?>" >
               </div>
               <?php } else if($wqueryList->role_hierarchy == "B" || $wqueryList->sub_role_hierarchy == "B" && $_POST['role'] == 'B'){ ?>
               <div class="form-group col-sm-7">
                  <label> Are you sure change booth</label>
                  <input type="checkbox" class="getAvailBooth" id="getBooth"  value="<?php echo $_POST['obid']; ?>">
               </div>
               <?php } ?>
               <div class="row col-sm-12" id="displaySKward">
                  <div class="form-group col-sm-6">
                     <?php  $qry = 'select * from '.TBL_BJP_WARD.' where `mandal_id` ='.$wqueryList->mandal_id.' AND id='.$wqueryList->ward_id.' AND `status`="A"';
                        $wardFullDetails=dB::mExecuteSql($qry); ?>
                     <input type="text" class="form-control" readonly value="<?php  foreach($wardFullDetails as $Key=>$val) { echo $val->ward_number; } ?>" >
                  </div>
                  <div class="form-group col-sm-6">
                     <select class="form-control selectsubRoleBooth" multiple style="width:100%" id="multiSelectBooth" name="updateBooth[]"></select>
                  </div>
               </div>
               <!-- <div class="row col-sm-12" id="displayBooth">
                  <div class="form-group col-sm-6">
                     <?php  $qry = 'select * from '.TBL_BJP_WARD.' where `mandal_id` ='.$wqueryList->mandal_id.' AND id='.$wqueryList->ward_id.' AND `status`="A"';
                        $wardFullDetails=dB::mExecuteSql($qry); ?>
                     <input type="text" class="form-control" readonly value="<?php  foreach($wardFullDetails as $Key=>$val) { echo $val->ward_number; } ?>" >
                  </div>
                  <div class="form-group col-sm-6">
                     <select class="form-control selectsubRoleBooth" style="width:100%" name="boothupdate"></select>
                     <div class="displayerror"></span>
                     </div>
                  </div>
               </div> -->
            </div>
            <div class="displayerror"></div>
            <input type="submit" id="submit" class="btn btn-success" value="Submit">
         </form>
      </div>
   </div>
   <script>
      // 1. Get the mandal role position
         $('#getRole').click(function(){
            if($(this).prop("checked") == true){
               $('#showselectBox').show();
               var mandalid = $('#mandalID').val();
               var role = $('#role_hierarchy').val();
               paramPosition = {'act':'findrolePosition','position':role,'mandalID':mandalid };
               ajax({
                  a:"districtajax",
                  b:paramPosition,
                  c:function(){},
                  d:function(data){
                     $('#showselectBox').html('<select class="form-control" name="role_id" value="">'+data+'</select>');
                  }
               });
            } else if($(this).prop("checked") == false){
               $('#showselectBox').hide();
            }
         });
      // 2. Get the availabe ward 
         $('#getAvailWard').click(function(){
            if($(this).prop("checked") == true){
               $('#displayWard').show();
               var mandalid = $('#mandalID').val();
               var role = $('#role_hierarchy').val();
               paramPosition = {'act':'findavailableWard','position':role,'mandalID':mandalid };
               ajax({
                  a:"districtajax",
                  b:paramPosition,
                  c:function(){},
                  d:function(data){
                     $('#displayWard').html('<select class="form-control" name="updateWard_id" value="">'+data+'</select>');
                  }
               });
            } else if($(this).prop("checked") == false){
               $('#displayWard').hide();
            }
         });
      // 3. Get the available  for sk
         $('#displaySKward').hide();

         $('#getBooth').click(function(){
            $(".selectsubRoleBooth").prop("multiple", (this.checked) ? "" : "");
         });
         $('.getAvailBooth').click(function(){
            if($(this).prop("checked") == true){
               var obid = $(this).val();
               $('#displaySKward').show();
               var ward_id = $('#ward_id').val();
               var mandalid = $('#mandalID').val();
               var boothID = $('#booth_id').val()
               paramPosition = {'act':'findselectedBooth','wardID':ward_id,'mandalID':mandalid,'obid':obid,'boothID':boothID };
                  ajax({
                  a:"districtajax",
                  b:paramPosition,
                  c:function(){},
                  d:function(data){
                        $('.selectsubRoleBooth').html(data);
                        $('.selectsubRoleBooth').multiselect('rebuild');
                     }
                  });
            } else if($(this).prop("checked") == false){
               $('#displaySKward').hide();
            }
         });
   </script>

<!-- 13. ADD NEW BOOTH -->
<?php } else if($modelAction == 'addNewBooth'){?>
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> ADD NEW BOOTH</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
      <form action="javascript:void(0)" id="formAddNewBooth" method="POST">
         <input type="hidden" value="addNewBooth" name="act">
         <div class="row">
            <div class="form-group col-sm-6">
               <?php $wquery = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition'=>array('id'=>$_POST['ward'].'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                     $wqueryList = Table::getData($wquery);?>
                  <label >Ward Name</label>
                  <input type="text" class="form-control" readonly value="<?php echo $wqueryList->ward_number; ?>" placeholder="Enter Ward No.">
                  <input type="hidden" class="form-control" name="ward_id" readonly value="<?php echo $wqueryList->id; ?>">
            </div>
            <div class="form-group col-sm-6">
               <label >Booth Name/No</label>
               <input type="text" class="form-control" name="booth_number" placeholder="Enter Booth Name/No.">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-6">
               <label >Booth Old Name/No </label>
               <input type="text" class="form-control" name="old_booth_number" placeholder="Enter Booth Old Name/No.">
            </div>
            <div class="form-group col-sm-6">
               <label >Total Voter's </label>  
                  <input type="text" class="form-control" name="total_voters" placeholder="Total Voters">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-4">
               <label >Male Voter's </label>  
                  <input type="text" class="form-control" name="male_voters_count" placeholder="Total Male Voters">
            </div>       <div class="form-group col-sm-4">
               <label >Female Voter's </label>  
                  <input type="text" class="form-control" name="female_voters_count" placeholder="Total Female Voters">
            </div>
            <div class="form-group col-sm-4">
               <label >Other Voter's </label>  
                  <input type="text" class="form-control" name="other_voters_count" placeholder="Total Other Voters">
            </div>
         </div>

         <div class="row">
            <div class="form-group col-sm-12">
               <label >Address</label>
                  <input type="text" class="form-control" name="booth_address" placeholder="Booth Address">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-6">
               <label >Booth Zipcode </label>  
                  <input type="text" class="form-control" name="booth_zipcode" placeholder="Booth Zipcode">
            </div>       
            <div class="form-group col-sm-6">
               <label >Booth Policestation </label>  
                  <input type="text" class="form-control" name="booth_police_station" placeholder="Booth Policestation">
            </div>
         </div>
         <input type="submit" id="submit"  class="btn btn-success" value="Submit">
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

   /* 2. Delete Restore District Form */
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
   
   /* 5. Status Update For Ward Members */
      $('form#deleteWardMembers').validate({
         submitHandler: function(form){
            var ofId = $('#officeBeraersId').val();
            var id = $('#ward_Id').val();
            var formData = $('form#deleteWardMembers').serialize();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  if($('.deleteModel').modal('toggle')){
                        getStateWard(id);
                  }
                  // $("#wardFullDetails").load(location.href+" #wardFullDetails>*","");
               }          
            });
         }
      });

   /* 6. Status Update For Office Bearers */

      $('form#deleteOfficeBearers').validate({
         submitHandler: function(form){
            var ofId = $('#officeBeraersId').val();
            var formData = $('form#deleteOfficeBearers').serialize();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('.uddateOB').modal('toggle');         
                  $('#deleteOfficeBearers_'+ofId).remove();
               }          
            });
         }
      });

   /* 7. Add New Booth */
      $('form#formAddNewBooth').validate({
         rules: {
            ward_id: "required",
            booth_number: "required",
            booth_address: "required",
         },
         messages: {
            booth_number: "Please Enter Booth Name/No",
            booth_address: "Please Enter Booth Address",
         },
         submitHandler: function(form){
         var formData = $('form#formAddNewBooth').serialize();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('.deleteModel').modal('toggle');
                  // paramData = {'act':'getAllData','type':'all'}; 
                  //    ajax({
                  //          a:"districtajax",
                  //          b:paramData,
                  //          c:function(){},
                  //          d:function(data){
                  //             $('#myTable').html(data);
                  //          }
                  //    });
               }          
            });
         }
      });
   /* 8. Edit Office Bearers */
      $('form#formEditOfficeBearers').validate({
         rules: {
         id: "required",
         person_name: "required",
         mobile_number: "required",
         booth_address: "required",
         },
         messages: {
            mobile_number: "Please Enter Mobile Number",
            booth_address: "Please Enter Booth Address"
         },
         submitHandler: function(form){
         var formData = $('form#formEditOfficeBearers').serialize();
         var mandalId = $('#mandalID').val();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('.updateofficebearers').modal('toggle'); 
                  $('.deleteModel').modal('toggle'); 
                  officeBearesDetailsget(mandalId);          
               }          
            });
         }
      });
/*********** WRAD DETAILS GET *********/

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
   // $('.valueCounter').each(function () {
   //    var $this = $(this);
   //    jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
   //       duration: 1500,
   //       easing: 'swing',
   //       step: function () {
   //          $this.text(Math.ceil(this.Counter));
   //       }
   //    });
   // });

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
           paramData = {'mandalid':id,'districtID':distID,'action':'officeBearersNew'}
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

      $('input[type=radio][name=optradio]').change(function() {
         var getValue = $(this).val();
         var getMandal = $('#Mandal').val();
         var getDistrict = $('#District').val();

         paramPosition = {'action':getValue,'Mandal':getMandal,'District':getDistrict };
         ajax({
            a:"officebearersforms",
            b:paramPosition,
            c:function(){},
            d:function(data){
               $('#viewoboptions').html(data);
            }
         });

      })
   
/*********** GET WARD INCHARCE ********/

   $(document).ready(function() {
      var id = $('#getMandalid').val();
      paramData = {'act':'wardincharge','mandalID':id }; 
         ajax({
            a:"districtajax",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#selectWard').html(data);
            }
      });

      // paramData = {'act':'fetchMandalThalaivar','id':id}; 
      //    ajax({
      //       a:"districtajax",
      //       b:paramData,
      //       c:function(){},
      //       d:function(data){
      //          $('#mandalThalaivar').html(data);
      //       }
      // });

      paramData = {'act':'wardDetailsGet','id':id }; 
            ajax({
               a:"districtajax",
               b:paramData,
               c:function(){},
               d:function(data){
                  $('#wardDetails').html(data);
               }
         });
      
   });

</script>