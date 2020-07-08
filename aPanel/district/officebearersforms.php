
<?php include 'includes.php';
 if($_POST['action'] == 'M'){  

    $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>$_POST['action'].'-CHAR','mandal_id'=>$_POST['Mandal'].'-INT','status'=>'A-CHAR'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');        
    $ob_list = Table::getData($param);
    $ob_count = count($ob_list); 
    if($ob_count){
        ?>    
    <form action="javascript:void(0)" id="formDataddNewOb" method="POST">
        <input type="hidden" value="addNewOfficeBearersMandal" name="act">
        <input type="hidden" value="1" name="state_id">
        <input type="hidden" value="<?php  echo $_POST['District'] ?>" name="district_id">
        <input type="hidden" value="<?php  echo $_POST['Mandal'] ?>" name="mandal_id" id="mandalID"> 
        <input type="hidden" value="<?php  echo $_POST['action'] ?>" name="role_hierarchy" id="roleHierarchy"> 
        <div class="row">
            <div class="form-group col-sm-6" id="roleHierachy">
                <label>Role Position </label>
                <select class="form-control showData" name="role_id"></select>
            </div>
            <div class="form-group col-sm-6">
                <label >Sub Role Hierarachy</label><br>
                <label class="radio-inline">
                <input type="radio" name="sub_role_hierarchy" id="subRoleW" value="W"> WARD 
                </label>&nbsp;&nbsp;
                <label class="radio-inline">
                <input type="radio" name="sub_role_hierarchy" id="subRoleSK" value="SK"> SHAKTI KENDRAM
                </label>&nbsp;&nbsp;            
                <label class="radio-inline">
                <input type="radio" name="sub_role_hierarchy" id="subRoleB" value="B"> BOOTH
                </label>
                <label class="radio-inline">
                <input type="radio" name="sub_role_hierarchy" id="noneofabove" value="" checked> NONE
                </label>
            </div>
        </div>
 
        <div class="row">
            <div class="col-sm-6 col-lg-6" id="suRoleWard">
                <label>Select Ward</label>
                <select class="form-control selectsubRoleWard"  name="ward_id"></select>
            </div>
            <div class="col-sm-6 col-lg-6 " id="suRoleSK">
                <label>Select Booths</label><br>
                <select  class="form-control selectsubRoleBooth" name="booth_id[]"></select>
            </div>
            <div class="col-sm-6 col-lg-6" id="suRoleSKname">
                <label >Enter Shakti Kendram Name</label>
                <input type="text" class="form-control" name="sk_name" placeholder="Please Enter Shakti Kendram Name">
            </div>
            <div class="col-sm-6 col-lg-6">
                <label>Member Number/Name/Mobile</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" id="memberID" name="selectMem" onkeypress="searchKey(this.id)"  placeholder="Enter Your Member Number/Name/Mobile" value="">                  
                </div>
            </div>
            <div class="form-group col-sm-6" style="display:none;">
                <label>Sub Role Position </label>
                <select class="form-control showsubroleData" name="sub_role_id"></select>
            </div>
        </div>
        <span id="memberTable"></span>            
        <input type="submit" id="submit" class="btn btn-success" data-dismiss="modal"  value="Submit">
        <span id="errormsg"></span>
    </form><?php 
    } else {  ?><h4 style="color:red">Maximum Reached Office Bearers List </h4>     <?php  } ?>

<?php } else if($_POST['action'] == 'W'){?>

    <form action="javascript:void(0)" id="formDataddNewOb" method="POST">
    <input type="hidden" value="addNewOfficeBearersWard" name="act">
    <input type="hidden" value="1" name="state_id">
    <input type="hidden" value="<?php  echo $_POST['District'] ?>" name="district_id">
    <input type="hidden" value="<?php  echo $_POST['Mandal'] ?>" name="mandal_id" id="mandalID"> 
    <input type="hidden" value="<?php  echo $_POST['action'] ?>" name="role_hierarchy" id="roleHierarchy"> 
    <div class="row">
        <div class="form-group col-sm-6" id="roleHierachy">
            <label>Role Position </label>
            <select class="form-control showData" name="role_id" readonly></select>
        </div>   
        <div class="form-group col-sm-6">
            <label >Sub Role Hierarachy</label><br>
            <label class="radio-inline">
            <input type="radio" name="sub_role_hierarchy" id="subRoleSK" value="SK"> SHAKTI KENDRAM
            </label>&nbsp;&nbsp;          
            <label class="radio-inline">
            <input type="radio" name="sub_role_hierarchy" id="subRoleB" value="B"> BOOTH
            </label>
            <label class="radio-inline">
            <input type="radio" name="sub_role_hierarchy" id="noneofabove" value="" checked> NONE
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-6">
                <label>Select Ward</label>
                <select class="form-control selectsubRoleWard" name="ward_id"></select>
            </div>
            <div class="col-sm-6 col-lg-6 " id="suRoleSK">
                <label>Select Booths</label><br>
                <select  class="form-control selectsubRoleBooth" name="booth_id[]"></select>
            </div>
  
        <div class="col-sm-6 col-lg-6">
        <label>Member Number/Name/Mobile</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                </div>
                <input type="text" class="form-control" id="memberID" name="selectMem" onkeypress="searchKey(this.id)"  placeholder="Enter Your Member Number/Name/Mobile" value="">                  
            </div>
        </div>
        <div class="form-group col-sm-6" style="display:none;">
                <label>Sub Role Position </label>
                <select class="form-control showsubroleData" name="sub_role_id"></select>
            </div>
    </div>
    <span id="memberTable"></span>            
    <input type="submit" id="submit" class="btn btn-success" data-dismiss="modal"  value="Submit">
    <span id="errormsg" style="color:red">Please Select One Ward.!</span>
    </form>


<?php } else if($_POST['action'] == 'SK'){?>

    <form action="javascript:void(0)" id="formDataddNewOb" method="POST">
        <input type="hidden" value="addNewOfficeBearersSK" name="act">
        <input type="hidden" value="1" name="state_id">
        <input type="hidden" value="<?php  echo $_POST['District'] ?>" name="district_id">
        <input type="hidden" value="<?php  echo $_POST['Mandal'] ?>" name="mandal_id" id="mandalID"> 
        <input type="hidden" value="<?php  echo $_POST['action'] ?>" name="role_hierarchy" id="roleHierarchy"> 
        <div class="row">
            <div class="form-group col-sm-6" id="roleHierachy">
                <label>Role Position </label>
                <select class="form-control showData" name="role_id" readonly></select>
            </div>   
            <div class="form-group col-sm-6">
            <label>Select Ward</label><br>
            <select class="form-control selectsubRoleWard" name="ward_id"></select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-6">
            <label>Select Booth</label><br>
            <select  class="form-control selectsubRoleBooth"  multiple  name="booth_id[]"></select>
            </div>  
            <div class="col-sm-6 col-lg-6">
                <label >Enter Shakti Kendram Name</label>
                <input type="text" class="form-control" name="sk_name" placeholder="Please Enter Shakti Kendram Name">
            </div>  
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6 col-lg-6">
                <label>Member Number/Name/Mobile</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" id="memberID" name="selectMem" onkeypress="searchKey(this.id)"  placeholder="Enter Your Member Number/Name/Mobile" value="">                  
                </div>
            </div>
        </div>
        <span id="memberTable"></span>            
        <input type="submit" id="submit" class="btn btn-success" data-dismiss="modal"  value="Submit">
        <span id="errormsg" style="color:red">Please Select One Ward And Booth.!</span>
    </form>

<?php } else if($_POST['action'] == 'B'){?>

    <form action="javascript:void(0)" id="formDataddNewOb" method="POST">
        <input type="hidden" value="addNewOfficeBearersBooth" name="act">
        <input type="hidden" value="1" name="state_id">
        <input type="hidden" value="<?php  echo $_POST['District'] ?>" name="district_id">
        <input type="hidden" value="<?php  echo $_POST['Mandal'] ?>" name="mandal_id" id="mandalID"> 
        <input type="hidden" value="<?php  echo $_POST['action'] ?>" name="role_hierarchy" id="roleHierarchy"> 
        <div class="row">
            <div class="form-group col-sm-6" id="roleHierachy">
                <label>Role Position </label>
                <select class="form-control showData" name="role_id" readonly></select>
            </div>   
            <div class="form-group col-sm-6">
            <label>Select Ward</label><br>
            <select class="form-control selectsubRoleWard required" name="ward_id"></select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-6">
            <label>Select Booth</label><br>
            <select  class="form-control selectsubRoleBooth" name="booth_id"></select>
            </div>
            <div class="col-sm-6 col-lg-6">
            <label>Member Number/Name/Mobile</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                    </div>
                    <input type="text" class="form-control" id="memberID" name="selectMem" onkeypress="searchKey(this.id)"  placeholder="Enter Your Member Number/Name/Mobile" value="">                  
                </div>
            </div>
        </div>
        <span id="memberTable"></span>            
        <input type="submit" id="submit" class="btn btn-success" data-dismiss="modal"  value="Submit">
        <span id="errormsg"></span>
    </form>
<?php } ?>
<script>

$(document).ready(function() {
    /* Get Main role Hierarchy */
    $('#submit').prop('disabled', true);
    $('#errormsg').hide();

         var mandalID = $('#mandalID').val();
         var mainRole = $('#roleHierarchy').val();
         paramPosition = {'act':'findrolePosition','position':mainRole,'mandalID':mandalID };
         ajax({
            a:"districtajax",
            b:paramPosition,
            c:function(){},
            d:function(data){
               $('.showData').html(data);
            }
         });
        
    /* Get Main Role Ward Details */

         paramPosition = {'act':'wardincharge','mandalID':mandalID };
         ajax({
            a:"districtajax",
            b:paramPosition,
            c:function(){},
            d:function(data){
               $('.selectsubRoleWard').html(data);
               $('.selectsubRoleWard').multiselect('rebuild');

            }
         });

    /* Get Booth Details */
            $('.selectsubRoleWard').multiselect({
                includeSelectAllOption: false,
                nonSelectedText: 'Select Ward',
                buttonWidth:'400px',
                onChange:function(option, checked)
                {
                  $('.selectsubRoleBooth').html('');
                  $('.selectsubRoleBooth').multiselect('rebuild');
                  var selected = this.$select.val();
                  if(selected.length > 0)
                  {
                     paramPosition = {'act':'boothincharge','wardID':selected };
                     ajax({
                     a:"districtajax",
                     b:paramPosition,
                     c:function(){},
                     d:function(data){
                           $('.selectsubRoleBooth').html(data);
                           $('.selectsubRoleBooth').multiselect('rebuild');
                        }
                     });
                  }
                }
            });   
            $('.selectsubRoleBooth').multiselect({
                includeSelectAllOption: false,
                nonSelectedText: 'Select Booth',
                buttonWidth:'400px',
            });
         
         
    /* Add new Office Berares */
      $('form#formDataddNewOb').validate({
         rules: {
            role_hierarchy: "required",
            role_id: "required",
            membership_number: "required",
            person_name: "required",
            mobile_number: "required",
            selectMem: "required",   
               },
         messages: {
            role_hierarchy: "Please Select One Role Hierarchy",
            membership_number: "Please Enter Membership Number",
            person_name: "Enter Person Name",
            mobile_number: "Enter Mobile Number",
            role_id: "Please Select Role Position",
            selectMem: "Eneter MembershipId/Mobile/Name",
         },

       
         submitHandler: function(form){     
            var formData = $('form#formDataddNewOb').serialize();
            var id = $('#mandalID').val();
            var role = $('#roleHierarchy').val();
            var dataward = $('.selectsubRoleWard').val();
            var databooth = $('.selectsubRoleBooth').val();
            if(role == 'W' && dataward == null ){  
                $('#errormsg').show();
                setTimeout(function(){
                    $('#errormsg').hide();
                }, 2000);

            }else if(role == 'SK' && databooth == '' ){ 
                $('#errormsg').show();
                setTimeout(function(){
                    $('#errormsg').hide();
                }, 2000);

            }else{
                ajax({
                a:"districtajax",
                b:formData,
                c:function(){},
                d:function(data){
                    $('#memberTable').html(data);
                    $("#inputvalue" ).trigger( "keyup" );
                    officeBearesDetailsget(id);
                    $('#memberID').val('');
                    paramPosition = {'act':'findrolePosition','position':mainRole,'mandalID':mandalID };
                        ajax({
                            a:"districtajax",
                            b:paramPosition,
                            c:function(){},
                            d:function(data){
                            $('.showData').html(data);
                            }
                        });
                        
                    }          
                });
            }   
        }   
      });
    /* Sub Role Hierarchy */
        $('#suRoleWard').hide();
        $('#suRoleSK').hide();
        $('#suRoleSKname').hide();
        $('input[type=radio][name=sub_role_hierarchy]').change(function() {
            var getValue = $(this).val();  
            var mandalID = $('#mandalID').val();
        
            paramPosition = {'action':getValue,'mandalID':mandalID};
            ajax({
                a:"districtajax",
                b:paramPosition,
                c:function(){},
                d:function(data){
                    $('.selectsubRoleWard').html(data);
                    $('.selectsubRoleWard').multiselect('rebuild');                }
            });

        
  
         paramPosition = {'act':'findrolePosition','position':getValue,'mandalID':mandalID };
         ajax({
            a:"districtajax",
            b:paramPosition,
            c:function(){},
            d:function(data){
               $('.showsubroleData').html(data);
            }
         });

            if(getValue == 'W'){
                $('#suRoleWard').show();
                $('#suRoleSK').hide();
                $('#suRoleSKname').hide();
            }else if (getValue == 'SK'){
                $('#suRoleWard').show();
                $('#suRoleSK').show();
                $('#suRoleSKname').show();
                $(".selectsubRoleBooth").attr("multiple", (this.checked) ? "multiple" : "");
            } else if (getValue == 'B'){
                $('#suRoleWard').show();
                $('#suRoleSK').show();
                $('#suRoleSKname').hide();
                $(".selectsubRoleBooth").removeAttr("multiple", (this.checked) ? "multiple" : "");
            } else {
                $('#suRoleWard').hide();
                $('#suRoleSK').hide();
                $('#suRoleSKname').hide();                
                    paramPosition = {'act':'wardincharge','mandalID':mandalID };
                    ajax({
                        a:"districtajax",
                        b:paramPosition,
                        c:function(){},
                        d:function(data){
                        $('.selectsubRoleWard').html(data);
                        $('.selectsubRoleWard').multiselect('rebuild');

                        }
                    });
            }

            $('.selectsubRoleWard').multiselect({
                includeSelectAllOption: false,
                nonSelectedText: 'Select Ward',
                buttonWidth:'400px',
                onChange:function(option, checked)
                {
                  $('.selectsubRoleBooth').html('');
                  $('.selectsubRoleBooth').multiselect('rebuild');
                  var selected = this.$select.val();
                  if(selected.length > 0)
                  {
                     paramPosition = {'act':'boothincharge','wardID':selected };
                     ajax({
                     a:"districtajax",
                     b:paramPosition,
                     c:function(){},
                     d:function(data){
                           $('.selectsubRoleBooth').html(data);
                           $('.selectsubRoleBooth').multiselect('rebuild');
                        }
                     });
                  }
                }
            });   
            $('.selectsubRoleBooth').multiselect({
                includeSelectAllOption: false,
                nonSelectedText: 'Select Booth',
                buttonWidth:'400px',
            });
         
        });
}); 
/*********** SEARCH MEMBER DETAILS  ***/
    function searchKey(id_attr) { 
         $( "#"+id_attr).autocomplete({
         source: function( request, response ) {
               $('#update_response_'+id_attr).html('processing...'); 
               var mandal = $('#getMandalid').val();
               var wardId = $('.selectsubRoleWard').val();
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
                        $('#memberTable').html(data);
                     }
               });
   
            return false;
         }
         });
    }
   
</script>