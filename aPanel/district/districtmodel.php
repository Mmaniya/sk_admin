<!--==================================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 30/6/2020;
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
   <script>
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
   </script>

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
   <script>
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
   </script>
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
      <form id="formDistrictRestore" action="javascipt:void(0)">
         <input type="hidden" name="act" value="statusDataUpdate">
         <input type="hidden" name="id" value="<?php echo $modelId; ?>">
         <input type="hidden" value="A" name="status">
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <input type="submit" id="submit" class="btn btn-success"  value="Restore">
         </div>
      </form>
   </div>
   <script>
      $('form#formDistrictRestore').validate({
            submitHandler: function(form){
            var formData = $('form#formDistrictRestore').serialize();
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
   </script>

<!-- 4. ALERT BOX MODEL  ---->
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
         <form action="javascript:void(0)" id="forAddNewMandal" method="POST">
            <input type="hidden" value="addNewMandal" name="act">
            <div class="row">
               <div class="form-group col-sm-6">
                  <label for="exampleInputEmail1">Select State</label>
                  <select class="form-control" name="state_id" readonly>
                     <?php (isset($_POST["state_id"])) ? $state_id = $_POST["state_id"] : $role_hierarchy;  ?>
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
   <script>
      $('form#forAddNewMandal').validate({
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
         var formData = $('form#forAddNewMandal').serialize();
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
   </script>
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
   <br>
   <div class="row" >
      <div class="card-body row"> 
         <table class="table table-striped table-bordered" >
            <thead>
            <tr><th colspan='9' style="color:#ff9933">DISTRICT INCHARGE
            <a href="javascript:void(0);" style="float:right"  class="btn btn-warning btn-sm float-right" style="color:#FFF" data-toggle="modal" data-target=".distrcit" onclick="addnewdistrictincharge(<?php echo $_POST['dist_ID']; ?>,'addnew')"><i class="fa fa-plus"></i> ADD NEW DITRICT INCHARGE</a>
            </th>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Main Role</th>
                    <th>Sub Role</th>
                    <th>Mandal</th>
                    <th>Ward</th>
                    <th>Booth</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php    
              $qry = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where (`role_hierarchy` ="D" OR `sub_role_hierarchy` ="D") AND `district_id`= '.$_POST['dist_ID'].' AND`status`="A"';
               $disrictList=dB::mExecuteSql($qry);              
                $i = 1; 
                foreach($disrictList as $key =>$val) {
                    ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $val->person_name; if($val->person_name_ta !=''){ ?>(<?php echo $val->person_name_ta ?>)<?php } ?></td>
                    <td><?php echo $val->mobile_number ?></td>
                    <td>                    
                     <?php if($val->role_id != '0' && $val->role_hierarchy == 'D' || $val->sub_role_hierarchy == 'D'){ ?>
                        <span class="mytextcolor">
                           <?php  
                              $roleMembers = array('tableName' => TBL_BJP_ROLE, 'fields' => array('*'),'condition' => array('id' => $val->role_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
                              $roleMembersList = Table::getData($roleMembers);
                              echo $roleMembersList->role_name;
                              }
                           ?>
                        </span>
                    </td>
                    <td>                    
                        <?php if($val->sub_role_hierarchy != 'D'){ ?>
                        <span class="mytextcolor">
                           <?php  switch($val->sub_role_hierarchy) { case "M" : echo 'MANDAL'; break; case "W" : echo 'WARD INCHARGE'; break; case "SK": echo 'SAKTI KENDRAM'; break; case "B" : echo 'BOOTH INCHARGE'; break;  }
                           }?>
                        </span>
                    </td>
                    <td><?php
                           $findmandal = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('id' => $val->mandal_id.'-STRING'),'orderby' => 'id', 'showSql' => 'N');
                           $findmandalList = Table::getData($findmandal);     
                           echo $findmandalList->mandal_name;
                     ?></td>
                    <td><?php
                           $findsubrole = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('id' => $val->ward_id.'-INT'),'orderby' => 'id', 'showSql' => 'N');
                           $findsubroleList = Table::getData($findsubrole);     
                           echo $findsubroleList->ward_number;
                     ?></td>
                    <td>
                    <?php 
                     $qry = 'select * from '.TBL_BJP_BOOTH.' where `id` IN ('.$val->booth_id.') AND `status`="A"';
                     $findsubroleSKList=dB::mExecuteSql($qry);                           
                        foreach($findsubroleSKList as $array) { 
                              echo $array->booth_number.'<br>';
                        }              
                    ?>
                    
                    </td>
                    <td>
                        <a href="javascript:void(0)" style="float:center;color:#fd7e14" data-toggle="modal" data-target=".distrcit"  onclick="addnewdistrictincharge(<?php  echo $val->id ?>,'editdist')" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <!-- <a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".deleteModel"  onclick="removeofficbearers(<?php // echo $val->id ?>,'W')" ><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr> 
                    <?php $i ++; } ?>
            </tbody>
         </table>
      </div>
   </div>

   <div class="modal fade distrcit" tabindex="-1" role="dialog"  aria-hidden="true">
   <div class="modal-dialog" role="document">
         <dic class ="dist_model"></div>
   </div>
   </div>
   <script>
      function addnewdistrictincharge(distId,func){
         paramPosition = {'act':func,'id':distId };
         ajax({
            a:"districtinchargeform",
            b:paramPosition,
            c:function(){},
            d:function(data){
               $('.dist_model').html(data);
            }
         });
      }
   </script>
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
                     <div class="col-sm-4" id="boothcount">
                        <div class="card  text-white" style="background-color:#ef8f6a">
                           <div class="card-body">
                              <h5>Total Booth
                                 <span   class="valueCounter" style="float: right; right;font-size: 2.5rem;">
                                 <?php
                                    $boothqry = "SELECT * FROM ".TBL_BJP_BOOTH." WHERE ward_id IN (SELECT id FROM ".TBL_BJP_WARD." WHERE mandal_id = ".$mandal_list->id." AND status = 'A') AND status='A'";
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
                        <li class="nav-item ml-auto" style="margin-top: 0.5%">
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
         <form action="javascript:void(0)" id="formAddNewWard" method="POST">
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

   <script>
      $('form#formAddNewWard').validate({
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
         var formData = $('form#formAddNewWard').serialize();
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
   </script>

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
   <script>
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
   </script>

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
   <script>
      /* 1. Status Update For Ward Members */
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
                  }          
               });
            }
         });
   </script>
<!-- 11. DELETE OFFICE BEARERS -->
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
         <input type="hidden" value="<?php echo $_POST['mandalId'] ?>" id="mandalId">
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <input type="submit" id="submit" class="btn btn-danger"  value="Delete">
         </div>
         <span id="showresult"></span>
      </form>
   </div>
   <script>
      /* 1. Status Update For Office Bearers */
      $('form#deleteOfficeBearers').validate({
            submitHandler: function(form){
               var ofId = $('#officeBeraersId').val();
               var id = $('#mandalId').val();
               var role = $('#subRole').val();
               var formData = $('form#deleteOfficeBearers').serialize();
               ajax({
                  a:"districtajax",
                  b:formData,
                  c:function(){},
                  d:function(data){
                     $('#showresult').html(data);
                     setTimeout(function(){ 
                        $('.uddateOB').modal('toggle');  
                        getStateUsers(id,role);    
                     }, 1500);
                  }          
               });
            }
         });
   </script>

<!-- 12. EDIT OFFICE BEARERS -->
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
                  <input type="hidden" value="<?php  echo $wqueryList->district_id ?>" name="district_id">
                  <input type="hidden" value="<?php  echo $wqueryList->mandal_id ?>" name="mandal_id" id="mandalID"> 
                  <input type="hidden" value="<?php  echo $wqueryList->role_hierarchy ?>" name="role_hierarchy" id="role_hierarchy"> 
                  <!-- <input type="hidden" value="<?php // echo $wqueryList->sub_role_hierarchy ?>" name="sub_role_hierarchy" id="sub_role_hierarchy">  -->
                  <input type="hidden" value="<?php  echo $wqueryList->ward_id ?>" name="ward_id" id="ward_id"> 
                  <input type="hidden" value="<?php  echo $wqueryList->booth_id ?>" name="booth_id" id="booth_id"> 
                  <input type="hidden" value="<?php  echo $_POST['role'] ?>" name="mainrole" id="getMainRole">

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
                  <input type="text" class="form-control" name="address" value="<?php echo $wqueryList->address; ?>" placeholder="Enter Address">
               </div>
            </div>
            <?php if($wqueryList->role_hierarchy == "M" && $_POST['role'] == 'M'){ ?>
               <input type="hidden" class="form-control" id="OBID" value="<?php echo $wqueryList->id; ?>">
            <div class="row">
               <div class="form-group col-sm-12">
               <label >Please check if you change main role:</label>
                  <input type="checkbox" id="checkSubRoleob"  value="">
                  <span id="showselectBox"></span>
               </div> 
               <?php if($wqueryList->sub_role_hierarchy == ''){ ?>
               <div class="form-group col-sm-12">
                  <label >Are you sure add new sub role:</label>
                  <input type="radio" name="sub_role_hierarchy"  value="W" > <label class="radio-inline">Ward</label>
                  <input type="radio" name="sub_role_hierarchy"  value="SK"> <label class="radio-inline">SK</label>
                  <input type="radio" name="sub_role_hierarchy"   checked  value=""> <label class="radio-inline">None</label>
                  <span id="showError" style="color:red"></span>
                  <div class="row">
                     <div class="col-sm-6" id="newWard">
                        <label>Select Ward</label>
                           <select class="form-control newSubWard"  name="addneWard"></select>
                     </div>
                     <div class="col-sm-6" id="newBooth">
                     <label>Select Booth</label>
                           <select  class="form-control newSubBooth"  multiple  name="addNewBooth[]"></select>
                     </div>
                  </div>
               </div>  
               <?php }else { ?><input type="hidden" name="sub_role_hierarchy" value="<?php echo $wqueryList->sub_role_hierarchy ?>"> <?php } ?>
            </div>
            <?php } else if(($wqueryList->role_hierarchy == "W" || $wqueryList->sub_role_hierarchy == "W") && $_POST['role'] == 'W'){?>
            <!-- <div class="row"> -->
               <!-- <div class="form-group col-sm-7">
                  <label> Are you sure change ward</label>
                  <input type="checkbox" id="getAvailWardOb"  value="">
               </div> -->
               <!-- <div class="form-group col-sm-12">
               <label>please check if you want change sk booth</label>
                  <input type="checkbox" id="addNewSK" name="sub_role_hierarchy" value="SK">
               </div>
            </div> -->
            <!-- <div class="row">
               <div class="form-group col-sm-6" id="addSKBooth">
                     <select  class="form-control newSubBooth"  multiple  name="addNewBooth[]"></select>
               </div>
            </div> -->
            <?php } else if(($wqueryList->role_hierarchy == "SK" || $wqueryList->sub_role_hierarchy == "SK") && $_POST['role'] == 'SK'){ ?>
            <div class="row">
               <div class="form-group col-sm-12">
                  <label> please check if you want change sk booth</label>
                  <input type="checkbox" class="getAvailBoothOb"  value="<?php echo $_POST['obid']; ?>" >
               </div>
            </div>
            <?php } else if(($wqueryList->role_hierarchy == "B" || $wqueryList->sub_role_hierarchy == "B") && $_POST['role'] == 'B'){ ?>
            <div class="row">
               <div class="form-group col-sm-10">
                  <label> please check if you want change booth</label>
                  <input type="checkbox" class="getAvailBoothOb" id="getBoothOb"  value="<?php echo $_POST['obid']; ?>">
               </div>
            </div>
            <?php } ?>
            <div class="row displaySKwardOb" id="displaySKwardOb">
               <div class="form-group col-sm-6">
                  <?php  $qry = 'select * from '.TBL_BJP_WARD.' where `mandal_id` ='.$wqueryList->mandal_id.' AND id='.$wqueryList->ward_id.' AND `status`="A"';
                           $wardFullDetails=dB::mExecuteSql($qry); ?>
                  <input type="text" class="form-control" readonly value="<?php  foreach($wardFullDetails as $Key=>$val) { echo $val->ward_number; } ?>" >
               </div>
               <div class="form-group col-sm-6">
                  <select class="form-control selectsubRoleBooth" multiple style="width:100%" id="multiSelectBooth" name="updateBooth[]"></select>
               </div>
            </div>
            <div class="row col-sm-12">
               <input type="submit" id="submit" class="btn btn-success" value="Submit">
            </div>
         </form>
      </div>
   </div>
   <script>
      // 1. Get the mandal role position
         $('#checkSubRoleob').click(function(){
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

      // 2. Add New SubRole
         $('#newWard').hide();
         $('#newBooth').hide();
         $('input[type=radio][name=sub_role_hierarchy]').change(function() {
               var mandalid = $('#mandalID').val();
               var obid = $('#OBID').val();
               var AddSubRole = $(this).val();
               if($(this).val() != ''){
                  param = {'act':'addNewSubRole','mandalID':mandalid,'obid':obid,'selectRole':AddSubRole};
                  ajax({
                     a:"districtajax",
                     b:param,
                     c:function(){},
                     d:function(data){
                        if(data.trim() == 'existmember'){                 
                           $('#showError').html('<p>This Member Allready Handle Two Many Wards!</p>').fadeIn('fast').delay(2000).fadeOut('fast');
                           $('#newWard').hide();
                           $('#newBooth').hide();
                        }else{    
                           if(data.trim() == ''){
                           $('.newSubWard').html('<option selected="false" disabled="disabled" value="">No Ward Available</option>');
                           $('.newSubWard').multiselect('rebuild');  
                           }else{
                           $('.newSubWard').html(data);
                           $('.newSubWard').multiselect('rebuild');  
                           }    
                        }               
                     }
                  });
               }
            if($(this).val() == 'W'){
               $('#newWard').show();
               $('#newBooth').hide();              
            } else if($(this).val() == 'SK'){
               $('#newWard').show();
               $('#newBooth').show();
            } else{
               $('#newWard').hide();
               $('#newBooth').hide();
            }                          
         });

         $('.newSubWard').multiselect({
                includeSelectAllOption: false,
                nonSelectedText: 'Select Ward',
                buttonWidth:'400px',
                onChange:function(option, checked)
                {
                  $('.newSubBooth').html('');
                  $('.newSubBooth').multiselect('rebuild');
                  var selected = this.$select.val();
                  if(selected.length > 0)
                  {
                     paramPosition = {'act':'addNewSubRoleBooth','wardID':selected };
                     ajax({
                     a:"districtajax",
                     b:paramPosition,
                     c:function(){},
                     d:function(data){
                           $('.newSubBooth').html(data);
                           $('.newSubBooth').multiselect('rebuild');
                        }
                     });
                  }
                }
            });   
            $('.newSubBooth').multiselect({
                includeSelectAllOption: false,
                nonSelectedText: 'Select Booth',
                buttonWidth:'400px',
            });


      // 3. Get the availabe ward 
         $('#getAvailWardOb').click(function(){
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

         // Get the availabe Booth
         $('#addSKBooth').hide();
         $('#addNewSK').click(function(){
            if($(this).prop("checked") == true){
               $('#addSKBooth').show();
               var ward_id = $('#ward_id').val();
               paramPosition = {'act':'addNewSubRoleBooth','wardID':ward_id };
                  ajax({
                  a:"districtajax",
                  b:paramPosition,
                  c:function(){},
                  d:function(data){
                     if(data.trim() == ''){
                        $('.newSubBooth').html('<option selected="false" disabled="disabled" value="">No Booth Available</option>');
                        $('.newSubBooth').multiselect('rebuild');
                     }else{
                        $('.newSubBooth').html(data);
                        $('.newSubBooth').multiselect('rebuild');
                     }
                     }
                  });
            } else if($(this).prop("checked") == false){
               $('#addSKBooth').hide();
            }
         });


      // 4. Get the available  for sk
         $('#displaySKwardOb').hide();
         $('#getBoothOb').click(function(){
            $(".selectsubRoleBooth").prop("multiple", (this.checked) ? "" : "");
         });
         $('.getAvailBoothOb').click(function(){
            if($(this).prop("checked") == true){
               var obid = $(this).val();
               $('#displaySKwardOb').show();
               var ward_id = $('#ward_id').val();
               var mandalid = $('#mandalID').val();
               var boothID = $('#booth_id').val();
               var getRole = $('#getMainRole').val();
               paramPosition = {'act':'findselectedBooth','wardID':ward_id,'mandalID':mandalid,'obid':obid,'boothID':boothID,'getRole':getRole };
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
               $('#displaySKwardOb').hide();
            }
         });

      // 5. Get the Formsubmit
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
            var id = $('#mandalID').val();
            var role = $('#getMainRole').val();
               ajax({
                  a:"districtajax",
                  b:formData,
                  c:function(){},
                  d:function(data){
                     $('.updateofficebearers').modal('toggle'); 
                     officeBearesDetailsget(id);  
                     getStateUsers(id,role);    
                  }          
               });
            }
         });
   </script>

<!-- 13. DELETE RECORDS -->
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

<!-- 14. EDIT WARD OFFICE BEARERS -->
<?php } else if($modelAction == 'editwardOfficeBearers'){?>

   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> EDIT OFFICEBEARERS</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="javascript:void(0)" id="formEditWardOfficeBearers" method="POST">
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
                  <input type="hidden" value="<?php  echo $wqueryList->role_id ?>" name="role_id" > 
                  <input type="hidden" value="<?php  echo $_POST['role'] ?>" name="mainrole" id="getWardRole">
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
                  <input type="text" class="form-control" name="address" value="<?php echo $wqueryList->address; ?>" placeholder="Enter Address">
               </div>
            </div>
               <?php if($wqueryList->role_hierarchy == "M" && $_POST['role'] == 'M'){ ?>
                  <div class="row">
                     <div class="form-group col-sm-7">
                     <label >Please check if you change main role:</label>
                        <input type="checkbox" id="getRole"  value="">
                        <span id="showselectBox"></span>
                     </div>
                  </div>
               <?php } else if(($wqueryList->role_hierarchy == "W" || $wqueryList->sub_role_hierarchy == "W") && $_POST['role'] == 'W'){?>
                  <!-- <div class="row"> -->
                     <!-- <div class="form-group col-sm-7">
                        <label> Are you sure change ward</label>
                        <input type="checkbox" id="getAvailWard"  value="">
                     </div> -->
                     <!-- <div class="form-group col-sm-12">
                        <label>Please check if you want change sk booth</label>
                           <input type="checkbox" id="addNewSK"  value="">
                     </div> -->
                  <!-- </div> -->
                     <!-- <div class="form-group col-sm-6" id="displayWard"></div> -->
                  <!-- <div class="row">
                     <div class=" form-group col-sm-6" id="addSKBooth">
                           <input type="hidden" value="SK" name="sub_role_hierarchy"> 
                           <select  class="form-control newSubBooth"  multiple  name="addNewBooth[]"></select>
                     </div>
                  </div> -->
               <?php } else if(($wqueryList->role_hierarchy == "SK" || $wqueryList->sub_role_hierarchy == "SK") && $_POST['role'] == 'SK'){ ?>
                  <div class="row">
                     <div class="form-group col-sm-10">
                        <label>please check if you want change sk booth</label>
                        <input type="checkbox" class="getAvailBooth"  value="<?php echo $_POST['obid']; ?>" >
                     </div>
                  </div>
               <?php } else if(($wqueryList->role_hierarchy == "B" || $wqueryList->sub_role_hierarchy == "B") && $_POST['role'] == 'B'){ ?>
                  <div class="row">
                     <div class="form-group col-sm-10">
                        <label> please check if you want change booth</label>
                        <input type="checkbox" class="getAvailBooth" id="getBoothward"  value="<?php echo $_POST['obid']; ?>">
                     </div>
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
                  <input type="submit" id="submit" class="btn btn-success" value="Submit">
               <span id="displayerror"></span>
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
         $('#getBoothward').click(function(){
            $(".selectsubRoleBooth").prop("multiple", (this.checked) ? "" : "");
         });
         $('.getAvailBooth').click(function(){
            if($(this).prop("checked") == true){
               var obid = $(this).val();
               $('#displaySKward').show();
               var ward_id = $('#ward_id').val();
               var mandalid = $('#mandalID').val();
               var boothID = $('#booth_id').val()
               var getRole = $('#getWardRole').val();
               paramPosition = {'act':'findselectedBooth','wardID':ward_id,'mandalID':mandalid,'obid':obid,'boothID':boothID,'getRole':getRole };
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

         // $('#addSKBooth').hide();
         // $('#addNewSK').click(function(){
         //    if($(this).prop("checked") == true){
         //       $('#addSKBooth').show();
         //       var ward_id = $('#ward_id').val();
         //       paramPosition = {'act':'addNewSubRoleBooth','wardID':ward_id };
         //          ajax({
         //          a:"districtajax",
         //          b:paramPosition,
         //          c:function(){},
         //          d:function(data){
         //                $('.newSubBooth').html(data);
         //                $('.newSubBooth').multiselect('rebuild');
         //             }
         //          });
         //    } else if($(this).prop("checked") == false){
         //       $('#addSKBooth').hide();
         //    }
         // });

      // 4. Form Edit Office Bearers 
        $('form#formEditWardOfficeBearers').validate({
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
         var formData = $('form#formEditWardOfficeBearers').serialize();
         var id = $('#ward_id').val();
         var role = $('#getWardRole').val();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('#displayerror').html(data);
                  setTimeout(function(){ 
                     $('.deleteModel').modal('toggle'); 
                     getStateWard(id);
                  }, 1500);
               }          
            });
         }
      });
   </script>

<!-- 15. ADD NEW BOOTH -->
<?php } else if($modelAction == 'addEditNewBooth'){
      $bqry = array('tableName' => TBL_BJP_BOOTH, 'fields' => array('*'),'condition'=>array('id'=>$_POST['boothid'].'-INT'),'showSql' => 'N','sortby' => 'asc');
      $bqryList = Table::getData($bqry);?>
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> ADD NEW BOOTH</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
      <form action="javascript:void(0)" id="formAddNewBooth" method="POST">
         <input type="hidden" value="addEditBooth" name="act">
         <input type="hidden" class="form-control" name="id"  readonly value="<?php echo $bqryList->id; ?>">

         <div class="row">
            <div class="form-group col-sm-6">
               <?php $wquery = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition'=>array('id'=>$_POST['ward'].'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                     $wqueryList = Table::getData($wquery);?>
                  <label >Ward Name</label>
                  <input type="text" class="form-control" readonly value="<?php echo $wqueryList->ward_number; ?>" placeholder="Enter Ward No.">
                  <input type="hidden" class="form-control" name="ward_id" id="ward_id" readonly value="<?php echo $wqueryList->id; ?>">
            </div>
            <div class="form-group col-sm-6">
               <label >Booth Name/No</label>
               <input type="text" class="form-control" name="booth_number" value="<?php echo $bqryList->booth_number ?>" placeholder="Enter Booth Name/No.">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-6">
               <label >Booth Old Name/No </label>
               <input type="text" class="form-control" name="old_booth_number" value="<?php echo $bqryList->old_booth_number ?>" placeholder="Enter Booth Old Name/No.">
            </div>
            <div class="form-group col-sm-6">
               <label >Total Voter's </label>  
                  <input type="text" class="form-control" name="total_voters" value="<?php echo $bqryList->total_voters ?>" placeholder="Total Voters">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-4">
               <label >Male Voter's </label>  
                  <input type="text" class="form-control" name="male_voters_count" value="<?php echo $bqryList->male_voters_count ?>" placeholder="Total Male Voters">
            </div>       <div class="form-group col-sm-4">
               <label >Female Voter's </label>  
                  <input type="text" class="form-control" name="female_voters_count" value="<?php echo $bqryList->female_voters_count ?>" placeholder="Total Female Voters">
            </div>
            <div class="form-group col-sm-4">
               <label >Other Voter's </label>  
                  <input type="text" class="form-control" name="other_voters_count" value="<?php echo $bqryList->other_voters_count ?>" placeholder="Total Other Voters">
            </div>
         </div>

         <div class="row">
            <div class="form-group col-sm-12">
               <label >Address</label>
                  <input type="text" class="form-control" name="booth_address" value="<?php echo $bqryList->booth_address ?>" placeholder="Booth Address">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-6">
               <label >Booth Zipcode </label>  
                  <input type="text" class="form-control" name="booth_zipcode" value="<?php echo $bqryList->booth_zipcode ?>" placeholder="Booth Zipcode">
            </div>       
            <div class="form-group col-sm-6">
               <label >Booth Policestation </label>  
                  <input type="text" class="form-control" name="booth_police_station" value="<?php echo $bqryList->booth_police_station ?>" placeholder="Booth Policestation">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-12">
               <label >Whatsapp Group Link</label>
                  <input type="text" class="form-control" name="booth_whatsapp_group_link" value="<?php echo $bqryList->booth_whatsapp_group_link ?>" placeholder="Whatsapp Group Link">
            </div>
         </div>
         <input type="submit" id="submit"  class="btn btn-success" value="Submit">
      </form>

      </div>
   </div>
   <script>
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
            var id = $('#ward_id').val();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('.deleteModel').modal('toggle'); 
                  getStateWard(id);
               }          
            });
            return false;
         }
      });
   </script>
<!-- 17. DELETE BOOTH -->
<?php } else if($modelAction == 'deleteBooth'){?>
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
      <form id="formBoothDelete" action="javascipt:void(0)">
         <input type="hidden" name="act" value="statusDataUpdateforBooth">
         <input type="hidden" name="id" value="<?php echo $_POST['boothid']; ?>">
         <input type="hidden" id="ward_id" name="wardId" value="<?php echo $_POST['wardId']; ?>">
         <input type="hidden" value="I" name="status">
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <input type="submit" id="submit" class="btn btn-danger" value="Delete">
         </div>
      </form>
   </div>
   <script>
      $('form#formBoothDelete').validate({
            submitHandler: function(form){
            var formData = $('form#formBoothDelete').serialize();
               ajax({
                  a:"districtajax",
                  b:formData,
                  c:function(){},
                  d:function(data){
                     var id = $('#ward_id').val();
                        ajax({
                           a:"districtajax",
                           b:formData,
                           c:function(){},
                           d:function(data){
                              $('.deleteModel').modal('toggle'); 
                              getStateWard(id);
                           }          
                        });                     
                  }          
               });
            }
         })
   </script>
<!-- 18. ADD NEW INCAHRGE -->
<?php } else if($modelAction == 'addNewIncharge'){ ?>
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> ADD NEW INCHRGE</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="javascript:void(0)" id="formAddNewIncharge" method="POST">
            <input type="hidden" name="state_id" value="1" id="state_id">
            <input type="hidden" name="ward_id" value="<?php echo $_POST['wradId'] ?>" id="wradId">
            <input type="hidden" name="district_id" value="<?php echo $_POST['districtID'] ?>" id="districtID">
            <input type="hidden" name="mandal_id" value="<?php echo $_POST['mandal_id'] ?>" id="mandal_id">
            <input type="hidden" name="role_hierarchy" value="<?php echo $_POST['role'] ?>" id="mainrole">
            <select class="form-control showData" style="display:none" name="role_id" readonly></select>
               <div class="row">
 
                  <div class="form-group col-sm-12">         
                     <label >Member Name/Number/Mobile</label>
                     <input type="text" class="form-control" id="getPersonName" onkeypress="searchKey(this.id)" placeholder="Enter Member Name/Number/Mobile">
                     <span id="datashow"></span>
                  </div>  
                  <?php if($_POST['role'] == 'SK') { ?>
                     <input type="hidden" value="addNewOfficeBearersSK" name="act">              
                  <div class="form-group col-sm-12">
                        <select  class="form-control newSubBooth" style="width: 100%;"  multiple  name="booth_id[]"></select>
                  </div>
                  <div class="form-group col-sm-12">         
                        <label >Enter Shakti Kendram Name</label>
                        <input type="text" class="form-control" name="sk_name" placeholder="Please Enter Shakti Kendram Name">
                     </div>
                  <?php } else if($_POST['role'] == 'W'){?>      
                     <input type="hidden" value="addNewOfficeBearersWard" name="act">

                     <div class="form-group col-sm-12">
                        <label>Please check if you want add sk booth</label>
                           <input type="checkbox" id="addNewSK" name="sub_role_hierarchy" value="SK">
                     </div>
              
                     <div class=" form-group col-sm-12 addSKBooth">
                           <select  class="form-control newSubBooth"  multiple  name="booth_id[]"></select>
                     </div>
                     <div class="form-group col-sm-12 addSKBooth">         
                        <label >Enter Shakti Kendram Name</label>
                        <input type="text" class="form-control" name="sk_name" placeholder="Please Enter Shakti Kendram Name">
                     </div>

                  <?php } else if($_POST['role'] == 'B'){ ?>
                     <input type="hidden" value="addNewOfficeBearersBooth" name="act">
                     <div class="form-group col-sm-12">
                           <select  class="form-control newSubBooth" style="width: 100%;"  name="booth_id"></select>
                     </div>
                  <?php } ?>
               </div>    
               <div id="members"></div>
            <input type="submit" id="submit"  class="btn btn-success" value="Submit">
            <span id="errormsg"></span>      
         </form>
      </div>
   </div>
   <script>
   $('#submit').prop('disabled', true);
    function searchKey(id_attr) { 
      var mandalID = $('#mandal_id').val();
         var mainRole = $('#mainrole').val();
         paramPosition = {'act':'findrolePosition','position':mainRole,'mandalID':mandalID };
         ajax({
            a:"districtajax",
            b:paramPosition,
            c:function(){},
            d:function(data){
               $('.showData').html(data);
            }
         });
         var wradId = $('#wradId').val();
         if(mainRole == 'SK'){
               paramBooth = {'act':'addNewSubRoleBooth','wardID':wradId };
         }else if(mainRole == 'B'){
               paramBooth = {'act':'boothincharge','wardID':wradId };
         }else{
            paramBooth = {'act':'boothincharge','wardID':wradId };
         }
            ajax({
            a:"districtajax",
            b:paramBooth,
            c:function(){},
            d:function(data){  
                  if(data.trim() == ''){
                     $('.newSubBooth').html('<option selected="false" disabled="disabled" value="">No Ward/Booth Available</option>');
                     $('.newSubBooth').multiselect('rebuild'); 
                  }else{
                     $('.newSubBooth').html(data);
                     $('.newSubBooth').multiselect('rebuild'); 
                  }                                            
               }
            });

         $( "#"+id_attr).autocomplete({
         source: function( request, response ) {
            $('#update_response_'+id_attr).html('processing...'); 
            var mandal = $('#getMandalid').val();
            var wardId = $('#wradId').val();
            // Fetch data
            $.ajax({
            url: "districtajax.php",
            type: 'post',
            dataType: "json",
            data: {
            search: request.term,mandal,wardId
            },
            success: function( data ) { 
               response( data );
            }
            });
         },
         appendTo: $('#datashow'),
         select: function (event, ui) {
            $('#submit').prop('disabled', false);
            $('#'+id_attr).val(ui.item.label); 
            $('.'+id_attr).val(ui.item.value);      
            paramMember = {'act':'memberDetails','filter_by':ui.item.value }; 
                  ajax({
                     a: "districtajax",
                     b: paramMember,
                     c:function(){},
                     d:function(data){
                        $('#members').html(data);
                     }
               });   
            return false;
         }
         });
    }


         $('.addSKBooth').hide();
         $('#addNewSK').click(function(){
            if($(this).prop("checked") == true){
               $('.addSKBooth').show();
               var ward_id = $('#wradId').val();
               paramPosition = {'act':'addNewSubRoleBooth','wardID':ward_id };
                  ajax({
                  a:"districtajax",
                  b:paramPosition,
                  c:function(){},
                  d:function(data){
                        $('.newSubBooth').html(data);
                        $('.newSubBooth').multiselect('rebuild');
                     }
                  });
            } else if($(this).prop("checked") == false){
               $('.addSKBooth').hide();
            }
         });



    $('form#formAddNewIncharge').validate({
         rules: {
            role_hierarchy: "required",
            role_id: "required",
            membership_number: "required",
            person_name: "required",
            mobile_number: "required",
            selectMem: "required",
            "booth_id[]": "required",               },
         messages: {
            role_hierarchy: "Please Select One Role Hierarchy",
            membership_number: "Please Enter Membership Number",
            person_name: "Enter Person Name",
            mobile_number: "Enter Mobile Number",
            role_id: "Please Select Role Position",
            selectMem: "Eneter MembershipId/Mobile/Name",
            "booth_id[]":  "please Select One Booth",
         },
         submitHandler: function(form){
         var formData = $('form#formAddNewIncharge').serialize();
         var mainrole = $('#mainrole').val();
         if($('.newSubBooth').val() == '' && mainrole =='SK'){   
               $('#errormsg').html('<h6 style="color:red">please select at least one ward</h6>');
            }else{
               ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  var id = $('#wradId').val();         
                  $('#errormsg').html(data);
                     setTimeout(function(){ 
                        $('.deleteModel').modal('toggle'); 
                        getStateWard(id);
                     }, 1500);                        
                  }          
                });
            }
         }      
      });

 </script>
<!-- 19. ADD NEW MEMBER -->
<?php } else if($modelAction == 'addEditMember'){
      // $bqry = array('tableName' => TBL_BJP_BOOTH, 'fields' => array('*'),'condition'=>array('id'=>$_POST['boothid'].'-INT'),'showSql' => 'N','sortby' => 'asc');
      // $bqryList = Table::getData($bqry);
      ?>
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> ADD NEW MEMBER</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
      <form action="javascript:void(0)" id="formAddNewBooth" method="POST">
         <input type="hidden" value="addEditMember" name="act">
         <input type="hidden" class="form-control" name="id"  readonly value="<?php echo $bqryList->id; ?>">

         <div class="row">  
            <div class="form-group col-sm-4">
               <?php $wquery = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition'=>array('id'=>$_POST['ward'].'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                     $wqueryList = Table::getData($wquery);?>
                  <label >Ward Name</label>  
                  <input type="text" class="form-control" value="<?php echo $wqueryList->ward_number; ?>" readonly >
                  <input type="hidden" class="form-control" name="ward_id" id="ward_id" readonly value="<?php echo $wqueryList->id ?>">
                  <input type="hidden" class="form-control" name="state_id" id="state_id" readonly value="1">
                  <input type="hidden" class="form-control" name="district_id" id="district_id" readonly value="<?php echo $wqueryList->district_id; ?>">
                  <input type="hidden" class="form-control" name="mp_const_id" id="mp_const_id" readonly value="<?php echo $wqueryList->mp_const_id; ?>">
                  <input type="hidden" class="form-control" name="lg_const_id" id="lg_const_id" readonly value="<?php echo $wqueryList->lg_const_id; ?>">
                  <input type="hidden" class="form-control" name="mandal_id" id="mandal_id" readonly value="<?php echo $wqueryList->mandal_id; ?>">
            </div>
            <div class="form-group col-sm-4">
               <label >Select Booth Name/No</label>
               <select class="form-control" name="booth_number" id="selectBooth" value="">
               <?php
                  $bqry = array('tableName' => TBL_BJP_BOOTH, 'fields' => array('*'),'condition'=>array('ward_id'=>$_POST['ward'].'-INT'),'showSql' => 'N','sortby' => 'asc');
                  $bqryList = Table::getData($bqry);?>
                  <option value="">-- Select Booth--</option>
                  <?php foreach($bqryList as $key=>$val){ ?>
                        <option value="<?php echo $val->id ?>"><?php echo $val->booth_number ?></option>
                <?php  }
               ?>
               </select>
            </div>
            <div class="form-group col-sm-4" id="boothbranch"></div>
         </div>
         <div class="row">       
            <div class="form-group col-sm-4">
               <label >Member Name</label>  
                  <input type="text" class="form-control" name="member_name" value="<?php echo $bqryList->member_name ?>" placeholder="Enter Member Name">
            </div>
            <div class="form-group col-sm-4">
               <label >Member Name Tamil</label>  
                  <input type="text" class="form-control" name="member_name_ta" value="<?php echo $bqryList->member_name_ta ?>" placeholder="Enter Member Name in Tamil">
            </div>
            <div class="form-group col-sm-4">
               <label >Membership Number</label>  
                  <input type="text" class="form-control" name="membership_number" value="<?php echo $bqryList->membership_number ?>" placeholder="Enter Membership Number">
            </div>
         </div>
         <div class="row">           
            <div class="form-group col-sm-4">
               <label >Member Mobile </label>  
                  <input type="text" class="form-control" name="member_mobile" value="<?php echo $bqryList->member_mobile ?>" placeholder="Total Member Mobile Number">
            </div>
            <div class="form-group col-sm-4">
                  <label class="checkbox-inline">Same Number in Whatsapp</label>  <br>
                     <input type="radio" checked name="is_whatsapp" value="Y"> Yes
                     <input type="radio" name="is_whatsapp" value="N"> No
            </div>
            <div class="form-group col-sm-4">
               <label >Member Alternative Mobile </label>  
                  <input type="text" class="form-control" name="member_another_mobile" value="<?php echo $bqryList->member_another_mobile ?>" placeholder="Total Member Mobile Number(optinal)">
            </div>
         </div>

         <div class="row">           
            <div class="form-group col-sm-4">
               <label >Member E-Mail </label>  
                  <input type="email" class="form-control" name="member_email_address" value="<?php echo $bqryList->member_email_address ?>" placeholder="Total Member E-Mail">
            </div>
            <div class="form-group col-sm-4">
               <label >Member DOB</label>  
                  <input type="date" class="form-control" name="member_DOB" value="<?php echo $bqryList->member_DOB ?>" placeholder="Enter Member DOB">
            </div>       
            <div class="form-group col-sm-2">
               <label >Member Age </label>  
                  <input type="text" class="form-control" name="member_age" value="<?php echo $bqryList->member_age ?>" placeholder="Age">
            </div>
            <div class="form-group col-sm-2">
               <label >Gender </label>  
                  <select class="form-control" name="member_gender" value="<?php echo $bqryList->member_gender ?>">
                  <option value="" selected disabel>Gender</option>
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                  <option value="O">Others</option>
                  </select>
            </div>
         </div>



         <div class="row">
            <div class="form-group col-sm-12">
               <label >Address</label>
                  <input type="text" class="form-control" name="booth_address" value="<?php echo $bqryList->booth_address ?>" placeholder="Booth Address">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-6">
               <label >Booth Zipcode </label>  
                  <input type="text" class="form-control" name="booth_zipcode" value="<?php echo $bqryList->booth_zipcode ?>" placeholder="Booth Zipcode">
            </div>       
            <div class="form-group col-sm-6">
               <label >Booth Policestation </label>  
                  <input type="text" class="form-control" name="booth_police_station" value="<?php echo $bqryList->booth_police_station ?>" placeholder="Booth Policestation">
            </div>
         </div>
         <div class="row">
            <div class="form-group col-sm-12">
               <label >Whatsapp Group Link</label>
                  <input type="text" class="form-control" name="booth_whatsapp_group_link" value="<?php echo $bqryList->booth_whatsapp_group_link ?>" placeholder="Whatsapp Group Link">
            </div>
         </div>
         <input type="submit" id="submit"  class="btn btn-success" value="Submit">
      </form>

      </div>
   </div>
<script>
   $('#selectBooth').change(function(){
      var boothId = $(this).val();
      paramPosition = {'act':'findBoothBranch','boothId':boothId };
         ajax({
         a:"districtajax",
         b:paramPosition,
         c:function(){},
         d:function(data){
               $('#boothbranch').html(data);
            }
         });
   });
</script>
<?php } ?>
<script>
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
      paramData = {'act':'fetchMandalThalaivar','id':id}; 
         ajax({
            a:"districtajax",
            b:paramData,
            c:function(){},
            d:function(data){
               $('#mandalThalaivar').html(data);
            }
      });
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