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
               <form action="javascript:void(0)" id="formUpadetAllMember" method="POST">
                  <input type="hidden" name="action" value="updateAllMember">
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
                     <a href="javascript:void(0);" id="updateAllMember" data-toggle="modal" data-target=".memberModel" class="offset-sm-1 col-sm-3 form-control btn btn-success">Update All Member</a>
                  </div><br><hr>
               </form>
                  <table id='membersTable' class='display dataTable table table-striped table-bordered'>  
                     <thead>
                        <tr>
                           <th colspan='6' style="color:#ff9933">MEMBERS TABLE
                           <a href="javascript:void(0);" data-toggle="modal" class="btn btn-warning btn-sm float-right" style="color:#FFF" data-target=".memberModel" onclick="createNewMember()"><i class="fa fa-plus"></i> ADD NEW MEMBER</a>
                           </th>
                        </tr>                     
                        <tr>
                           <th>Name</th>
                           <th>Mobile</th>
                           <th>Membership No</th>
                           <th>Verified</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                  </table>
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

       }
    },
    'columns': [
       { data: 'member_name' }, 
       { data: 'member_mobile' },
       { data: 'membership_number' }, 
       { data: 'is_verified' }, 
       { data: 'editid' }, 
    ],
  });

  $('#searchByDistrict').change(function(){
     var dist = $(this).val();
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
</script>
<?php } include "template.php"; ?>