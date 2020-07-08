<?php include 'includes.php'; ?>
<?php if($_POST['act'] == 'addnew'){ ?>
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> ADD NEW INCHRGE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="javascript:void(0)" id="formAddNewDistirctIncharge" method="POST">
        <input type="hidden" value="addNewOfficeBearersMandal" name="act">
        <input type="hidden" value="1" name="state_id">
        <input type="hidden" value="D" name="role_hierarchy">
        <input type="hidden" value="<?php echo $_POST['id']?>" name="district_id" id="districtID">
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-sm-12">         
                <label >Member Name/Number/Mobile</label>
                <input type="text" class="form-control" id="getPersonName" onkeypress="searchKey(this.id)" placeholder="Enter Member Name/Number/Mobile">
                <span id="datashow"></span>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12">         
                <select class="form-control showData" name="role_id"></select>
                </div>
            </div>
            <div class="row">
               <div class="form-group col-sm-12" id="members"></div>
            </div>
            <!-- <div class="row">
               <div class="form-group col-sm-12">
                  <label >Add new sub role:</label>
                  <input type="radio" name="addSubRoleMandal" value="M"> <label class="radio-inline">Mandal</label>
                  <input type="radio" name="addSubRoleMandal" value="W"> <label class="radio-inline">Ward</label>
                  <input type="radio" name="addSubRoleMandal" value="SK"> <label class="radio-inline">SK</label>
                  <input type="radio" name="addSubRoleMandal" value="" checked> <label class="radio-inline">None</label>
                  <span id="showError" style="color:red"></span>
                  <div class="row">
                     <div class="col-sm-4" id="newMandal">
                           <label>Select Mandal</label>
                           <select class="form-control newSubMandal"  name="addnewMandal"></select>
                     </div>
                     <div class="col-sm-4" id="newWard">
                           <label>Select Ward</label>
                           <select class="form-control newSubWard"  name="addneWard"></select>
                     </div>
                     <div class="col-sm-4" id="newBooth">
                           <label>Select Booth</label>
                           <select  class="form-control newSubBooth"  multiple  name="addNewBooth[]"></select>
                     </div>
                  </div>
               </div>
            </div> -->
            <input type="submit" id="submit"  class="btn btn-success" value="Submit">
        </div>
   
    </form>
    </div>
    <script>
        $('#submit').prop('disabled', true);
        function searchKey(id_attr) { 
            var district = $('#districtID').val();
            paramPosition = {'act':'findDistrictRole','position':'D','district':district };
            ajax({
                a:"districtajax",
                b:paramPosition,
                c:function(){},
                d:function(data){
                $('.showData').html(data);
                }
            });
            $( "#"+id_attr).autocomplete({
            source: function( request, response ) {
                $('#update_response_'+id_attr).html('processing...'); 
                var district = $('#districtID').val();
                // Fetch data
                $.ajax({
                url: "districtajax.php",
                type: 'post',
                dataType: "json",
                data: {
                search: request.term,district
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

           // 2. Add New SubRole
         $('#newMandal').hide();
         $('#newWard').hide();
         $('#newBooth').hide();
         $('input[type=radio][name=addSubRoleMandal]').change(function() {
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
                        if(data == '0'){                 
                           $('#showError').html('<p>This Member Allready Handle Two Many Wards!</p>').fadeIn('fast').delay(2000).fadeOut('fast');
                           $('#newMandal').hide();
                           $('#newWard').hide();
                           $('#newBooth').hide();
                        }else{    
                           $('.newMandal').html(data);
                           $('.newMandal').multiselect('rebuild');  
                        }                    
                     }
                  });
               }
            if($(this).val() == 'M'){
               $('#newMandal').show();
               $('#newWard').hide();
               $('#newBooth').hide();  
            }else if($(this).val() == 'W'){
               $('#newMandal').show();
               $('#newWard').show();
               $('#newBooth').hide();              
            } else if($(this).val() == 'SK'){
               $('#newWard').show();
               $('#newBooth').show();
               $('#newMandal').show();
            } else{
               $('#newWard').hide();
               $('#newBooth').hide();
               $('#newMandal').hide();
            }                          
         });

         $('.newSubMandal').multiselect({
                includeSelectAllOption: false,
                nonSelectedText: 'Select Mandal',
                buttonWidth:'400px',
                onChange:function(option, checked)
                {
                  $('.newSubWard').html('');
                  $('.newSubWard').multiselect('rebuild');
                  var selected = this.$select.val();
                  if(selected.length > 0)
                  {
                     paramPosition = {'act':'addNewSubRoleBooth','mandalID':selected };
                     ajax({
                     a:"districtajax",
                     b:paramPosition,
                     c:function(){},
                     d:function(data){
                           $('.newSubWard').html(data);
                           $('.newSubWard').multiselect('rebuild');
                        }
                     });
                  }
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


            

          // 5. Get the Formsubmit
          $('form#formAddNewDistirctIncharge').validate({
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
            var formData = $('form#formAddNewDistirctIncharge').serialize();
               ajax({
                  a:"districtajax",
                  b:formData,
                  c:function(){},
                  d:function(data){
                     $('.distrcit').modal('toggle'); 
                     location.reload();  
                  }          
               });
            }
         });
    </script>
<?php }  if($_POST['act'] == 'editdist'){?>

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
                  <?php $wquery = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition'=>array('id'=>$_POST['id'].'-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'asc');
                        $wqueryList = Table::getData($wquery);  ?>
                  <input type="hidden" value="editOfficeBearers" name="act">
                  <input type="hidden" value="1" name="state_id">
                  <input type="hidden" value="<?php  echo $wqueryList->district_id ?>" name="district_id" id="district_id">
                  <input type="hidden" value="<?php  echo $wqueryList->mandal_id ?>" name="mandal_id" id="mandalID"> 
                  <input type="hidden" value="<?php  echo $wqueryList->role_hierarchy ?>" name="role_hierarchy" id="role_hierarchy"> 
                  <input type="hidden" value="<?php  echo $wqueryList->sub_role_hierarchy ?>" name="sub_role_hierarchy" id="sub_role_hierarchy"> 
                  <input type="hidden" value="<?php  echo $wqueryList->ward_id ?>" name="ward_id" id="ward_id"> 
                  <input type="hidden" value="<?php  echo $wqueryList->booth_id ?>" name="booth_id" id="booth_id"> 
                  <input type="hidden" value="<?php  echo $_POST['role'] ?>" name="mainrole" id="getMainRole">
                  <input type="hidden" value="<?php  echo $wqueryList->id ?>" name="id" id="OBID">
                  
                  <label >Member Name</label>
                  <input type="text" class="form-control" readonly name="person_name" value="<?php echo $wqueryList->person_name; ?>" placeholder="Enter Member Name.">
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
            <div class="row">
               <div class="form-group col-sm-10">
               <label >Please check if you change main role:</label>
                  <input type="checkbox" id="checkSubRoleob"  value="">
                  <span id="showselectBox"></span>
               </div> 
               <!-- <div class="form-group col-sm-12">
                  <label >Add new sub role:</label>
                  <input type="radio" name="addSubRoleMandal" value="M"> <label class="radio-inline">Mandal</label>
                  <input type="radio" name="addSubRoleMandal" value="W"> <label class="radio-inline">Ward</label>
                  <input type="radio" name="addSubRoleMandal" value="SK"> <label class="radio-inline">SK</label>
                  <input type="radio" name="addSubRoleMandal" value="" checked> <label class="radio-inline">None</label>
                  <span id="showError" style="color:red"></span>
                  <div class="row">
                     <div class="col-sm-4" id="newMandal">
                           <label>Select Ward</label>
                           <select class="form-control newSubMandal"  name="addnewMandal"></select>
                     </div>
                     <div class="col-sm-4" id="newWard">
                           <label>Select Ward</label>
                           <select class="form-control newSubWard"  name="addneWard"></select>
                     </div>
                     <div class="col-sm-4" id="newBooth">
                           <label>Select Booth</label>
                           <select  class="form-control newSubBooth"  multiple  name="addNewBooth[]"></select>
                     </div>
                  </div>
               </div>   -->
            </div>
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
            <div class="displayerror"></div>
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
               var district_id = $('#district_id').val();
               var role = $('#role_hierarchy').val();
               paramPosition = {'act':'findDistrictRole','position':role,'district':district_id };
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
         $('input[type=radio][name=addSubRoleMandal]').change(function() {
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
                        if(data == '0'){                 
                           $('#showError').html('<p>This Member Allready Handle Two Many Wards!</p>').fadeIn('fast').delay(2000).fadeOut('fast');
                           $('#newWard').hide();
                           $('#newBooth').hide();
                        }else{    
                           $('.newSubWard').html(data);
                           $('.newSubWard').multiselect('rebuild');  
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
                        $('.newSubBooth').html(data);
                        $('.newSubBooth').multiselect('rebuild');
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
                     $('.distrcit').modal('toggle');
                     location.reload();   
                  }          
               });
            }
         });
   </script>




<?php } ?>