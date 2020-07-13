<!--======================================
   Name: Manikandan;
   Create: 5/6/2020;
   Update: 5/6/2020;
   Use: ADD DISTRICT
   =======================================-->
   <?php
   function main() { 
   ?>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<div id="layoutSidenav_content">
   <div class="container-fluid">
      <h2 class="mt-3">Member Details</h2>
      <ol class="breadcrumb mb-3">
      <a href="dashboard.php" class="breadcrumb-item">Home</a>
         <a href="member.php" class="breadcrumb-item active">Member Details</a>
      </ol>
      <div class="row">
         <div class="col-md-12">
            <div class="card mb-4">
               <div class="card-header"><img src="assets/images/bjpnamelogo.png" height="40">
               
               <span class="float-right mytextcolor" >TOTAL ACTIVE MEMBERS : <?php
                  $param = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition'  =>array('status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
                  $member_list = Table::getData($param);
                  echo $TotalCount = count($member_list);
                  ?></span>                  
               </div>
               <div class="card-body">  
               <label> Members Filter by Mandal</label>
                  <div class="row  col-sm-12">
                     <select id='searchByDistrict' name="district_id" class="col-sm-3 form-control">
                      <option value='' disabled selected>--Select District--</option>
                     </select>    
                     <select id='searchByConstituency' name="lg_const_id" class="offset-sm-1 col-sm-3 form-control">
                        <option value='' disabled selected>--Select Constituency--</option>
                     </select>
                     <select id='searchByMandal' name="mandal_id" class="offset-sm-1 col-sm-3 form-control">
                        <option value='' disabled selected>--Select Mandal--</option>
                     </select>
                     </div><br>
                     <div class="row  col-sm-12">
                     <select id='searchByWard' name="ward_id" class="col-sm-3 form-control">
                        <option value='' disabled selected>--Select Ward--</option>
                     </select>
                     <select id='searchByBooth' name="booth_id" class="offset-sm-1 col-sm-3 form-control">
                        <option value='' disabled selected>--Select Booth--</option>
                     </select> 
                     <select id='searchByBoothBranch' name="booth_branch_id" class="offset-sm-1 col-sm-3 form-control">
                        <option value='' disabled selected>--Select Booth Branch--</option>
                     </select>                                            
                  </div><br><hr>
                  <label> Members Filter by Categories</label>
                  <div class="row col-sm-12">
                     <select id='searchByVerifyed' name="is_verified" class="col-sm-3 form-control">
                        <option value=''>-- Verifyed Member --</option>
                        <option value='Y'>YES</option>
                        <option value='N'>NO</option>
                     </select> 
                     <select id='searchByGender' name="member_gender" class="offset-sm-1 col-sm-3 form-control">
                        <option value=''>-- Gender --</option>
                        <option value='M'>Male</option>
                        <option value='F'>Female</option>
                        <option value='O'>Others</option>
                     </select>
                     <select id='searchByAge' name="member_age" class="offset-sm-1 col-sm-3 form-control">
                        <option value=''>-- Member Age --</option>
                        <?php for ($x = 18; $x <= 100; $x++) { ?>
                           <option value='<?php echo $x ?>'><?php echo $x ?></option>
                        <?php } ?>                    
                     </select>       
                  </div><br>
                  <div class="row col-sm-12">
                     <select id='searchByWhatsappLink' name="is_wag_link_sent" class=" col-sm-3 form-control">
                        <option value=''>-- Whatsapp Link Send --</option>
                        <option value='Y'>YES</option>
                        <option value='N'>NO</option>
                     </select>
                     <select id='searchByCommunity' name="member_community" class="offset-sm-1 col-sm-3 form-control">
                        <option value=''>-- Member Community --</option>
                        <option value='OC'>OC</option>
                        <option value='BC'>BC</option>
                        <option value='SC'>SC</option>
                        <option value='MBC'>MBC</option>
                        <option value='ST'>ST</option>
                        <option value='SIRUPANMAI'>SIRUPANMAI</option>
                        <option value='NILL'>NILL</option>
                     </select>
                  </div><br><hr>
                  <label>Active/Inactive Members Details </label>
                  <div class="row col-sm-12">
                     <select id='searchByStatus' name="status" class=" col-sm-3 form-control">
                        <option value='A'>-- Member Status--</option>
                        <option value='A'>Active</option>
                        <option value='I'>Inactive</option>
                     </select>
                  </div><br><hr>
                  <form action="javascript:void(0)" id="formUpadetAllMember" method="POST">
                  <input type="hidden" name="action" value="updateAllMember">
                  <table id='membersTable' class='display dataTable table table-striped table-bordered' style="width:100%">  
                     <thead>
                        <tr>
                           <th colspan='6' style="color:#ff9933">MEMBERS TABLE
                           <a href="javascript:void(0);" data-toggle="modal" class="btn btn-warning btn-sm float-right" style="color:#FFF" data-target=".memberModel" onclick="createNewMember()"><i class="fa fa-plus"></i> ADD NEW MEMBER</a>
                           </th>
                        </tr>                     
                        <tr>
                        <th><input name="select_all" value="1" id="member-select-all" type="checkbox" /></th>
                           <th>Name</th>
                           <th>Mobile</th>
                           <th>Membership No</th>
                           <th>Verified</th>
                           <th>Action</th>                        
                     </thead>
                  </table>
                  <a href="javascript:void(0);" id="updateAllMember" data-toggle="modal" data-target=".memberModel" class="col-sm-3 form-control btn btn-success">Update With Selected Member</a>
                  </form>
               </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal -->   
      <div class="modal fade memberModel" role="dialog">
         <div class="modal-dialog modal-lg">
            <span id="modelshow"></span>
         </div>
      </div>
   </div>
   <!-- End Model -->
</div>
<script type="text/javascript">

$(document).ready(function() {
   // setInterval( function () {
   // dataTable.ajax.reload( null, false );
   // }, 10000 );
   // setTimeout(function(){ 
      // $('#membersTable').data.reload();
   // }, 3000);

   param = {'act':'getallDistrict'}
   ajax({
        a:"memberajax",
        b:param,
        c:function(){},
        d:function(data){
            $('#searchByDistrict').html(data);
        }
    }); 

    $('.wardDetails').DataTable( {
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false
    } );

    var dataTable = $('#membersTable').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    // 'searching': false, // Remove default Search Control
    'ajax': {
       'url':'membersmysql.php',
       'data': function(data){
          // Read values
          var distID       = $('#searchByDistrict').val();
          var conts        = $('#searchByConstituency').val();
          var mandal       = $('#searchByMandal').val();
          var wardId       = $('#searchByWard').val();
          var booth        = $('#searchByBooth').val();
          var boothbranch  = $('#searchByBoothBranch').val();
          var verifed      = $('#searchByVerifyed').val();
          var whatsappLink = $('#searchByWhatsappLink').val();
          var Community    = $('#searchByCommunity').val();
          var gender       = $('#searchByGender').val();
          var age          = $('#searchByAge').val();
          var status       = $('#searchByStatus').val();

          // Append to data
          data.action = 'dynamicSearch';
          data.searchBydistID = distID;
          data.searchByConstituency = conts;
          data.searchByMandal = mandal;
          data.searchByWard = wardId;      
          data.searchByBooth = booth;
          data.searchByBoothBranch = boothbranch;
          data.searchByVerifyed = verifed;
          data.searchByWhatsappLink = whatsappLink;
          data.searchByCommunity = Community;
          data.searchByGender = gender;
          data.searchByAge = age;
          data.searchByStatus = status;

       }
    },
   //  'columns': [
   //     { data: 'member_name' }, 
   //     { data: 'member_mobile' },
   //     { data: 'membership_number' }, 
   //     { data: 'is_verified' }, 
   //     { data: 'editid' }, 
   //     { data: 'updateMem' },
   //  ],
   'columnDefs': [{
         'targets': 0,
         'searchable':false,
         'orderable':false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '<input type="checkbox" name="member_id[]" value="' 
                + $('<div/>').text(data).html() + '">';
         }
      }],
      'order': [1, 'asc']    
  });

   // Handle click on "Select all" control
   $('#member-select-all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = dataTable.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#membersTable tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#member-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control 
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });
    
   $('#formUpadetAllMember').on('submit', function(e){
      var form = this;

      // Iterate over all checkboxes in the table
      dataTable.$('input[type="checkbox"]').each(function(){
         // If checkbox doesn't exist in DOM
         if(!$.contains(document, this)){
            // If checkbox is checked
            if(this.checked){
               // Create a hidden element 
               $(form).append(
                  $('<input>')
                     .attr('type', 'hidden')
                     .attr('name', this.name)
                     .val(this.value)
               );
            }
         } 
      });
      // Prevent actual form submission
      e.preventDefault();
   });


  $('#searchByDistrict').change(function(){
     var dist = $(this).val();
    $('#searchByConstituency').val('');
    $('#searchByMandal').val('');
    $('#searchByWard').val('');
    $('#searchByBooth').val('');
    $('#searchByBoothBranch').val('');

      param = {'act':'getallConstituency','dist':dist}
      ajax({
         a:"memberajax",
         b:param,
         c:function(){},
         d:function(data){
            $('#searchByConstituency').html(data);
         }
      });
    dataTable.draw();
  });
  $('#searchByConstituency').change(function(){
      var dist = $('#searchByDistrict').val();
      var constituency = $(this).val();

    $('#searchByMandal').val('');
    $('#searchByWard').val('');
    $('#searchByBooth').val('');
    $('#searchByBoothBranch').val('');
      param = {'act':'getallMandal','dist':dist,'const':constituency}
      ajax({
         a:"memberajax",
         b:param,
         c:function(){},
         d:function(data){
            $('#searchByMandal').html(data);
         }
      });
    dataTable.draw();
  });
  $('#searchByMandal').change(function(){
      var mandal = $(this).val();

    $('#searchByWard').val('');
    $('#searchByBooth').val('');
    $('#searchByBoothBranch').val('');

      param = {'act':'getallWard','mandal':mandal}
      ajax({
         a:"memberajax",
         b:param,
         c:function(){},
         d:function(data){
            $('#searchByWard').html(data);
         }
      });
    dataTable.draw();
  });
  $('#searchByWard').change(function(){
      var ward = $(this).val();

    $('#searchByBooth').val('');
    $('#searchByBoothBranch').val('');
      param = {'act':'getallBooth','ward':ward}
      ajax({
         a:"memberajax",
         b:param,
         c:function(){},
         d:function(data){
            $('#searchByBooth').html(data);
         }
      });
    dataTable.draw();
  });
  $('#searchByBooth').change(function(){

   $('#searchByBoothBranch').val('');
      var booth = $(this).val();
      param = {'act':'getallBoothBranch','booth':booth}
      ajax({
         a:"memberajax",
         b:param,
         c:function(){},
         d:function(data){
            $('#searchByBoothBranch').html(data);
         }
      });
    dataTable.draw();
  });  
  $('#searchByBoothBranch').change(function(){
    dataTable.draw();
  });

  $('#searchByVerifyed').change(function(){
    dataTable.draw();
  });
  $('#searchByWhatsappLink').change(function(){
    dataTable.draw();
  });
  $('#searchByCommunity').change(function(){
    dataTable.draw();
  });
  $('#searchByGender').change(function(){
    dataTable.draw();
  });
  $('#searchByAge').change(function(){
    dataTable.draw();
  });
  $('#searchByStatus').change(function(){
    dataTable.draw();
  });

  $('#updateAllMember').click(function() {
   formData = $('form#formUpadetAllMember').serialize();
      ajax({
         a:"membermodel",
         b:formData,
         c:function(){},
         d:function(data){
            $('#modelshow').html(data);              
         }          
      });
   });

});

function editMember(id){
    paramModel = {'action':'addEditMember','memberID':id}
    ajax({
        a:"membermodel",
        b:paramModel,
        c:function(){},
        d:function(data){
            $('#modelshow').html(data);
        }
    });    
}
function createNewMember(){
    var wardId = $('#wardId').val();
    paramModel = {'action':'addEditMember','ward':wardId}
    ajax({
        a:"membermodel",
        b:paramModel,
        c:function(){},
        d:function(data){
            $('#modelshow').html(data);
        }
    });   
}

function deleteMember(id){
   paramModel = {'action':'memberDelete','memberID':id}
    ajax({
        a:"membermodel",
        b:paramModel,
        c:function(){},
        d:function(data){
            $('#modelshow').html(data);
        }
    }); 
}

function restoreMember(id){
paramModel = {'action':'memberRetore','memberID':id}
 ajax({
     a:"membermodel",
     b:paramModel,
     c:function(){},
     d:function(data){
         $('#modelshow').html(data);
     }
 }); 
}

function viewMember(id){
paramModel = {'action':'memberDetailsView','memberID':id}
 ajax({
     a:"membermodel",
     b:paramModel,
     c:function(){},
     d:function(data){
         $('#modelshow').html(data);
     }
 }); 
}
</script>
<?php } include "template.php"; ?>