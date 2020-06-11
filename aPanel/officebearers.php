<!--==================================
Name: Manikandan;
Create: 26/5/2020;
Update: 4/6/2020;
Use: Parent Page of OfficeBearers 
====================================-->

<?php
   function main() { 
   ?>
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
      <div class="col-md-2">
         <div class="card">
            <div class="card-header">Office Bearer's List</div>
            <div class="card-body">
               <p id="notification" style="color:red"></p>
               <div class="search-box row">
                  <input type="inputvalue" id="inputvalue" class="form-control card-margin " placeholder="Search Here.." />
               </div>
            </div>
            <span id="myTable"></span>
         </div>
      </div>
      <div class="col-md-10">
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
         <span id="modelData"></span>
         <br>
         <div class="card">
            <div class="card-body">
               <form action="javascript:void(0)" id="formDataID" method="POST">
                  <!-- ============================== -->
                  <!--       MAIN ROLE FUNCTION       -->
                  <!-- ============================== -->
                  <div class="row">
                     <div class="col-md-6 col-lg-6">
                        <label >Role Hierarachy</label><br>
                        <select class="form-control" id="MainHierarchy" name="role_hierarchy" required>
                           <option selected="false" disabled="disabled" value="">Select Role Hierarachy</option>
                           <option <?php if($value->role_hierarchy =="S") echo 'selected="selected"'; ?> value="S">STATE</option>
                           <option  <?php if($value->role_hierarchy =="D") echo 'selected="selected"'; ?> value="D">DISTRICT</option>
                           <option  <?php if($value->role_hierarchy =="M") echo 'selected="selected"'; ?> value="M">MANDAL</option>
                           <option  <?php if($value->role_hierarchy =="W") echo 'selected="selected"'; ?> value="W">WARD</option>
                           <option  <?php if($value->role_hierarchy =="SK") echo 'selected="selected"'; ?> value="SK">SHAKTI KENDRA</option>
                           <option  <?php if($value->role_hierarchy =="B") echo 'selected="selected"'; ?> value="B">BOOTH</option>
                        </select>
                     </div>
                     <div class="col-md-6 col-lg-6">
                        <label>Role Position </label>
                        <select class="form-control" id="showData" name="role_id" required>
                           <option selected="false" disabled="disabled" value=""> Select Position</option>
                        </select>
                     </div>
                  </div>
                  <br>
                  <div class="row" >
                     <div class="col-md-4 col-lg-4" id="mainDistrict">
                        <label>Select District</label><br/>
                        <select  name="district_id[]" multiple id="selectDistirct" class="form-control" >
                        </select>                   
                     </div>
                     <div class="col-md-4 col-lg-4" id="mainMandal">
                        <label>Select Mandal</label><br />
                        <select  name="mandal_id[]" multiple id="selectMandal" class="form-control">
                        </select>
                     </div>
                     <div class="col-md-4 col-lg-4" id="mainWard">
                        <label>Select Ward</label><br />
                        <select  name="ward_id[]" multiple id="selectWard" class="form-control">
                        </select>
                     </div>
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-md-4 col-lg-4" id="mainSK">
                        <label>Select Shakti Kendram</label><br />
                        <select  name="sk_id[]" multiple id="selectshakitikendram" class="form-control">
                        </select>
                     </div>
                     <div class="col-md-4 col-lg-4" id="mainBooth">
                        <label>Select Booth</label><br />
                        <select  name="booth_id[]" id="selectbooth" multiple class="form-control">
                        </select>
                     </div>
                  </div>
                  <br>
                  <!-- <span id="subRole"></span> -->
                  <input type="hidden" name="act" value="addFormDetails">
                  <div class="row">
                     <div class="col-md-12 col-lg-12" id="radio_button_group">
                        <label>Sub Role Hierarchy</label><br>
                        <div class="form-check-inline" >
                           <label class="form-check-label">
                           <input type="radio" id="S_District" name="sub_role_hierarchy" class="form-check-input" value="D">District
                           </label>
                        </div>
                        <div class="form-check-inline" >
                           <label class="form-check-label">
                           <input type="radio" id="S_Mandal" name="sub_role_hierarchy" class="form-check-input" value="M">Mandal
                           </label>
                        </div>
                        <div class="form-check-inline" >
                           <label class="form-check-label">
                           <input type="radio" id="S_Ward"  name="sub_role_hierarchy" class="form-check-input"  value="W" >Ward
                           </label>
                        </div>
                        <div class="form-check-inline" >
                           <label class="form-check-label">
                           <input type="radio" id="S_Shatikendram" name="sub_role_hierarchy" class="form-check-input"  value="SK">Shakti Kendra
                           </label>
                        </div>
                        <div class="form-check-inline" >
                           <label class="form-check-label">
                           <input type="radio" id="S_Booth" name="sub_role_hierarchy" class="form-check-input"  value="B" >Booth
                           </label>
                        </div>
                     </div>
                     <br>
                  </div>
                  <br>
                  <!-- ============================== -->
                  <!--    SUB ROLE FUNCTION           -->
                  <!-- ============================== -->
                  <div id="printstate"></div>
                  <!-- ========== MEMBER DETAILS ====--->
                  <h4>Member Details</h4>
                  <div class="input-group mb-3">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                     </div>
                     <input type="text" class="form-control" id="memberID" onkeypress="searchKey(this.id)"  placeholder="Enter You Member ID" required>                  
                  </div>
                  <span id="memberTable"></span>
                  <input type="submit" class="btn btn-success" >
               </form>
               <span id="SuccessMsg"></span>
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
            paramData = {'act':'searchBox','type':'all','filter_by':filter_by }; 
            $.ajax({
                  type: "POST",
                  url: "officebearersajax.php",
                  data: paramData,
                  success: function(data){ 
                  $('#myTable').html(data);
                  }
            });           
         }
   
      $(window).on("load", function() {
   /********** 2. DEFAULT LOAD DATA *********************/
         paramData = {'act':'searchBox','type':'all'}; 
               ajax({
                  a:"officebearersajax",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#myTable').html(data);
                  }
               });
      
   /********** 3. LIVE DATA SEARCH **********************/
   
         $('#inputvalue').keyup(function() {
            var filter_by = $(this).val();
               paramData = {'act':'searchBox','type':'person_name','searchby':filter_by }; 

               ajax({
                  a:"officebearersajax",
                  b:paramData,
                  c:function(){},
                  d:function(data){
                     $('#myTable').html(data);
                  }
            });
         }); 
      });
   
   /********** 4. GET Main Role Hierarchy ***************/
   
         $('#MainHierarchy').multiselect({
            buttonWidth: '400px',
            onChange:function(option, checked){
            $('#selectDistirct').html('');
            $('#selectDistirct').multiselect('rebuild');
            $('#selectMandal').html('');
            $('#selectMandal').multiselect('rebuild');
   
            $("#S_District").attr('checked', false);
            $("#S_Mandal").attr('checked', false);
            $("#S_Ward").attr('checked', false);
            $("#S_Shatikendram").attr('checked', false);
            $("#S_Booth").attr('checked', false);
   
            var selected = this.$select.val();
            if(selected == 'S'){
               $('#selectDistirct').attr('multiple','multiple');
               $('#mainDistrict').show();
               $('#mainMandal').hide();
               $('#mainWard').hide();
               $('#mainSK').hide();
               $('#mainBooth').hide();
   
            $("#S_District").attr('disabled', false);
            $("#S_Mandal").attr('disabled', false);
            $("#S_Ward").attr('disabled', false);
            $("#S_Shatikendram").attr('disabled', false);
            $("#S_Booth").attr('disabled', false);
   
            } else if(selected == 'D'){ 
               $('#selectDistirct').removeAttr('multiple');
               $('#selectMandal').attr('multiple','multiple');
               $('#mainDistrict').show();
               $('#mainMandal').show();
               $('#mainWard').hide();
               $('#mainSK').hide();
               $('#mainBooth').hide();
   
               $("#S_District").attr('checked', false);
               $("#S_District").attr('disabled', true);
   
            } else if(selected == 'M'){
   
               $("#S_District").attr('checked', false);
               $("#S_District").attr('disabled', true);
               $("#S_Mandal").attr('checked', false);
               $("#S_Mandal").attr('disabled', true);
   
               $('#selectDistirct').removeAttr('multiple');
               $('#selectMandal').removeAttr('multiple');
               $('#selectWard').attr('multiple','multiple');
   
               $('#mainDistrict').show();
               $('#mainMandal').show();
               $('#mainWard').show();
               $('#mainSK').hide();
               $('#mainBooth').hide();
               
   
            } else if (selected == 'W'){
               $('#selectDistirct').removeAttr('multiple');
               $('#selectMandal').removeAttr('multiple');
               $('#selectWard').removeAttr('multiple');
               $('#selectshakitikendram').attr('multiple','multiple');
   
               
               $("#S_District").attr('checked', false);
               $("#S_District").attr('disabled', true);
               $("#S_Mandal").attr('checked', false);
               $("#S_Mandal").attr('disabled', true);            
               $("#S_Ward").attr('checked', false);
               $("#S_Ward").attr('disabled', true);
                          
               $('#mainDistrict').show();
               $('#mainMandal').show();
               $('#mainWard').show();
               $('#mainSK').show();
               $('#mainBooth').hide();
   
            } else if(selected == 'SK'){
   
               $('#selectDistirct').removeAttr('multiple');
               $('#selectMandal').removeAttr('multiple');
               $('#selectWard').removeAttr('multiple');
               $('#selectshakitikendram').removeAttr('multiple');
               $('#selectbooth').attr('multiple','multiple');
               $('#mainDistrict').show();
               $('#mainMandal').show();
               $('#mainWard').show();
               $('#mainSK').show();
               $('#mainBooth').show();
   
               $("#S_District").attr('checked', false);
               $("#S_District").attr('disabled', true);
               $("#S_Mandal").attr('checked', false);
               $("#S_Mandal").attr('disabled', true);            
               $("#S_Ward").attr('checked', false);
               $("#S_Ward").attr('disabled', true);
               $("#S_Shatikendram").attr('checked', false);
               $("#S_Shatikendram").attr('disabled', true);
   
            }  else if (selected == 'B'){
   
               $('#selectDistirct').removeAttr('multiple');
               $('#selectMandal').removeAttr('multiple');
               $('#selectWard').removeAttr('multiple');
               $('#selectshakitikendram').removeAttr('multiple');
               $('#selectbooth').removeAttr('multiple');
               $('#mainDistrict').show();
               $('#mainMandal').show();
               $('#mainWard').show();
               $('#mainSK').show();
               $('#mainBooth').show();
            }
            if(selected.length > 0)
               paramPosition = {'act':'findrolePosition','position':selected };
               paramDistrict = {'act':'findroleDistirct','district':selected };
               // paramSubrole = {'selected':selected }; 
   
               {
                  ajax({
                  a:"officebearersajax",
                  b:paramPosition,
                  c:function(){},
                  d:function(data){  
                        $('#showData').html(data);
                     }
                  });
   
                  ajax({
                  a:"officebearersajax",
                  b:paramDistrict,
                  c:function(){},
                  d:function(data){                  
                        $('#selectDistirct').html(data);
                        $('#selectDistirct').multiselect('rebuild');
                     }
                  });
   

               }
            }
            });
            
            $('#selectDistirct').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: 'Select District',
            buttonWidth:'276px',
            onChange:function(option, checked)
               {
                  $('#selectMandal').html('');
                  $('#selectMandal').multiselect('rebuild');
                  var selected = this.$select.val();
   
                  if(selected.length > 0)
                  {
                     paramMandal = {'act':'findroleMandal','disrictID':selected }; 
                     ajax({
                     a:"officebearersajax",
                     b:paramMandal,
                     c:function(){},
                     d:function(data){
                           $('#selectMandal').html(data);
                           $('#selectMandal').multiselect('rebuild');
                        }
                     });
                  }
               }
            });
            
            $('#selectMandal').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: 'Select Mandal',
            buttonWidth:'276px',
            onChange:function(option, checked)
               {
                  $('#selectWard').html('');
                  $('#selectWard').multiselect('rebuild');
                  var selected = this.$select.val();
                  if(selected.length > 0)
                  {
                     paramMandal = {'act':'findroleWard','mandalID':selected }; 
                     ajax({
                     a:"officebearersajax",
                     b:paramMandal,
                     c:function(){},
                     d:function(data){
                           $('#selectWard').html(data);
                           $('#selectWard').multiselect('rebuild');
                        }
                     });
                  }
               }
            });
   
            $('#selectWard').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: 'Select Ward',
            buttonWidth:'276px',
            onChange:function(option, checked)
               {
                  $('#selectshakitikendram').html('');
                  $('#selectshakitikendram').multiselect('rebuild');
                  var selected = this.$select.val();
                  if(selected.length > 0)
                  {
                     paramMandal = {'act':'findroleShaktikendram','wardID':selected }; 
                     ajax({
                     a:"officebearersajax",
                     b:paramMandal,
                     c:function(){},
                     d:function(data){
                           $('#selectshakitikendram').html(data);
                           $('#selectshakitikendram').multiselect('rebuild');
                        }
                     });
                  }
               }
            });
            
            $('#selectshakitikendram').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: 'Select Shakti kendram',
            buttonWidth:'276px',
            onChange:function(option, checked)
               {
                  $('#selectbooth').html('');
                  $('#selectbooth').multiselect('rebuild');
                  var selected = this.$select.val();
                  if(selected.length > 0)
                  {
                     paramMandal = {'act':'findroleBooth','skid':selected }; 
                     ajax({
                     a:"officebearersajax",
                     b:paramMandal,
                     c:function(){},
                     d:function(data){
                           $('#selectbooth').html(data);
                           $('#selectbooth').multiselect('rebuild');
                        }
                     });
                  }
               }
            });
   
            $('#selectbooth').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: 'Select Booth',
            buttonWidth:'276px',         
            });
   
   /********** 5. GET MEMBER DETAILS  *******************/
      function searchKey(id_attr) {  
         $( "#"+id_attr).autocomplete({
         source: function( request, response ) {
               $('#update_response_'+id_attr).html('processing...'); 
            // Fetch data
            $.ajax({
            url:"officebearersajax.php",
            type:'post',
            dataType: "json",
            data: {
            search: request.term
            },
            success: function(data) { 
               // alert(data);
               response( data );
            }
            });
         },
         select: function (event, ui) {
            // Set selection
            $('#'+id_attr).val(ui.item.label); // display the selected text
            $('.'+id_attr).val(ui.item.value);      
            paramMember = {'act':'memberDetails','filter_by':ui.item.value }; 
                  $.ajax({
                     url: "officebearersajax.php",
                     data: paramMember,
                     success: function(data) { 
                        $('#memberTable').html(data);
                     }
               });
   
            return false;
         }
         });
      }
   /********** 6. SUBMIT FORM **************************/
          $( "#formDataID" ).submit(function() {
            var formData = $( this ).serializeArray();
          var role_appr = $('#showData').val();
               ajax({
                  a: "officebearersajax",
                  b: formData,
                  c:function(){},
                  d:function(data){
                        if(data != ''){ 
                           $('#SuccessMsg').html('<p style="color:green">Data Inserted Successfully..!</p>');
                           setTimeout(function() { $('#SuccessMsg').fadeOut('slow');}, 2000);
                           $("#formDataID").get(0).reset();
                           // xhr.abort()
                           $('#memberTable').hide();
                           $('#printstate').hide();
                        } else { 
                           $('#SuccessMsg').html('<p style="color:red">Try again..!</p>');}
                  }
                });
         });
   /********** 7. SUBROLE HIERARCHY ********************/
      $('#radio_button_group input').change(function() {
         var mainrole = $('#MainHierarchy').val();
         var selected = $(this).val();
         var selectDistirct = $('#selectDistirct').val();
         var selectMandal = $('#selectMandal').val();
         var Warddata = $("#selectWard").val();
         var skdata = $("#selectshakitikendram").val();
         if (mainrole == 'S'){
            if(selectDistirct != ''){
            paramDistrict = {'act':'findsubroleDistirct','dist_ID':selectDistirct,'selected':selected }; 
            ajax({
                  a:"officebearersajax",
                  b:paramDistrict,
                  c:function(){},
                  d:function(data){
                     $('#printstate').html(data);
                     }
               });
            }else{
               alert('Select One District.!');
               $("#S_District").prop('checked', false);
               $("#S_Mandal").prop('checked', false);
               $("#S_Ward").prop('checked', false);
               $("#S_Shatikendram").prop('checked', false);
               $("#S_Booth").prop('checked', false);
      
            } 
         } else if(mainrole == 'D') {
            if(selectMandal != ''){
                  paramMandal = {'act':'findsubroleMandal','findMandal':selectMandal,'selected':selected}; 
                     ajax({
                     a:"officebearersajax",
                     b:paramMandal,
                     c:function(){},
                     d:function(data){
                        $('#printstate').html(data);
                        }
                  });
            } else {
               alert('Select One Mandal.!');
               $("#S_Mandal").prop('checked', false);
            }
         } else if(mainrole == 'M'){
               if(Warddata != ''){
                  paramWard = {'act':'findsubroleWard','selectedward':Warddata,'selected':selected }; 
                  ajax({
                  a:"officebearersajax",
                  b:paramWard,
                  c:function(){},
                  d:function(data){
                     $('#printstate').html(data);
                     }
                  });
               } else {
                  alert('Select One Ward.!');
                  $("#S_Ward").prop('checked', false);
               }
            } else if(mainrole == 'W'){
               if(skdata != ''){
                  paramSK = {'act':'findsubroleShaktikendram','skid':skdata,'selected':selected }; 
                  ajax({
                  a:"officebearersajax",
                  b:paramSK,
                  c:function(){},
                  d:function(data){
                     $('#printstate').html(data);
                     }
                  });
               } else {
                  alert('Select One Shakti Kendram.!');
                  $("#S_Sk").prop('checked', false);
               }
            }           
      });
</script>
<?php } 
include "template.php"; ?>