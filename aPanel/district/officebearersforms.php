
<?php include 'includes.php';
 if($_POST['action'] == 'M'){  

    $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>$_POST['action'].'-CHAR','mandal_id'=>$_POST['Mandal'].'-INT','status'=>'A-CHAR'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');        
    $ob_list = Table::getData($param);
    $ob_count = count($ob_list); 
        if($ob_count<6){
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
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-6">
            <label>Member Id </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                </div>
                <input type="text" class="form-control" id="memberID" name="selectMem" onkeypress="searchKey(this.id)"  placeholder="Enter You Member ID" value="">                  
            </div>
        </div>
        <div class="col-sm-6 col-lg-6" id="subOption">
        </div>
    </div>
    <span id="memberTable"></span>            
    <input type="submit" id="submit" class="btn btn-success" data-dismiss="modal"  value="Submit">
    </form>
        <?php } else {   ?>
            <h4 style="color:red">Maximum Reached Office Bearers List </h4>     
       <?php  } ?>

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
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-6">
        <label>Select Ward</label>
            <select class="form-control" id="selectWard" name="ward_id"></select>
        </div>
        <div class="col-sm-6 col-lg-6">
            <label>Member Id </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                </div>
                <input type="text" class="form-control" id="memberID" name="selectMem" onkeypress="searchKey(this.id)"  placeholder="Enter You Member ID" value="">                  
            </div>
        </div>
    </div>
    <span id="memberTable"></span>            
    <input type="submit" id="submit" class="btn btn-success" data-dismiss="modal"  value="Submit">
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
        <select class="form-control" id="selectWard" name="ward_id"></select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-6">
        <label>Select Booth</label><br>
        <select  class="form-control"  multiple  id="selectBooth" name="booth_id[]"></select>
        </div>
        <div class="col-sm-6 col-lg-6">
            <label>Member Id </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                </div>
                <input type="text" class="form-control" id="memberID" name="selectMem" onkeypress="searchKey(this.id)"  placeholder="Enter You Member ID" value="">                  
            </div>
        </div>
    </div>
    <span id="memberTable"></span>            
    <input type="submit" id="submit" class="btn btn-success" data-dismiss="modal"  value="Submit">
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
        <select class="form-control" id="selectWard" name="ward_id"></select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-6">
        <label>Select Booth</label><br>
        <select  class="form-control" id="selectBooth" name="booth_id"></select>
        </div>
        <div class="col-sm-6 col-lg-6">
            <label>Member Id </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-id-card"  aria-hidden="true"></i></span>
                </div>
                <input type="text" class="form-control" id="memberID" name="selectMem" onkeypress="searchKey(this.id)"  placeholder="Enter You Member ID" value="">                  
            </div>
        </div>
    </div>
    <span id="memberTable"></span>            
    <input type="submit" id="submit" class="btn btn-success" data-dismiss="modal"  value="Submit">
    </form>

<?php } ?>
<script>

$(document).ready(function() {
    /* Get Main role Hierarchy */

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

    /* Get Ward Details */

         paramPosition = {'act':'wardincharge','mandalID':mandalID };
         ajax({
            a:"districtajax",
            b:paramPosition,
            c:function(){},
            d:function(data){
               $('#selectWard').html(data);
               $('#selectWard').multiselect('rebuild');

            }
         });

    /* Get Booth Details */
            $('#selectWard').multiselect({
                includeSelectAllOption: false,
                nonSelectedText: 'Select Mandal',
                buttonWidth:'400px',
                onChange:function(option, checked)
                {
                  $('#selectBooth').html('');
                  $('#selectBooth').multiselect('rebuild');
                  var selected = this.$select.val();
                  if(selected.length > 0)
                  {
                     paramPosition = {'act':'boothincharge','wardID':selected };
                     ajax({
                     a:"districtajax",
                     b:paramPosition,
                     c:function(){},
                     d:function(data){
                           $('#selectBooth').html(data);
                           $('#selectBooth').multiselect('rebuild');
                        }
                     });
                  }
                }
            });   
            $('#selectBooth').multiselect({
                includeSelectAllOption: true,
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
            selectMem: "required"
               },
         messages: {
            role_hierarchy: "Please Select One Role Hierarchy",
            membership_number: "Please Enter Membership Number",
            person_name: "Enter Person Name",
            mobile_number: "Enter Mobile Number",
            role_id: "Please Select Role Position",
            selectMem: "Eneter MembershipId/Mobile/Name"
         },
         submitHandler: function(form){
         var formData = $('form#formDataddNewOb').serialize();
         var id = $('#mandalID').val();
         var role = $('#roleHierarchy').val();
            ajax({
               a:"districtajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('#memberTable').html(data);
                  $("#inputvalue" ).trigger( "keyup" );
                  officeBearesDetailsget(id);
                  $('#memberID').val('');
                     // paramData = {'act':'fetchMandalThalaivar','id':id}; 
                     //    ajax({
                     //       a:"districtajax",
                     //       b:paramData,
                     //       c:function(){},
                     //       d:function(data){
                     //          $('#mandalThalaivar').html(data);
                     //       }
                     // });
                  }          
                });
            }      
      });
    /* Sub Role Hierarchy */

        $('input[type=radio][name=sub_role_hierarchy]').change(function() {
            var getValue = $(this).val();  
            var mandalID = $('#mandalID').val();
        
            paramPosition = {'action':getValue,'mandalID':mandalID};
            ajax({
                a:"districtajax",
                b:paramPosition,
                c:function(){},
                d:function(data){
                    $('#subOption').html(data);
                }
            });

            // paramPosition = {'act':'wardincharge', };
            // ajax({
            //     a:"districtajax",
            //     b:paramPosition,
            //     c:function(){},
            //     d:function(data){
            //     $('#selectWard').html(data);
            //     $('#selectWard').multiselect('rebuild');

            //     }
            // });

        })
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
   
</script>