<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<?php 
   $prev=$next=$last=$first='&nbsp;';
   if($page > 1)
   $first = "<i class='fa fa-fast-backward' aria-hidden='true' onclick='ShowParentCatListPagination(\"1\",\"".$filter_by."\",\"".$id."\")'/></i>";
   
   if($page < $totalPages)
   $last = "<i class='fa fa-fast-forward' aria-hidden='true' onclick='ShowParentCatListPagination(\"$totalPages\",\"".$filter_by."\",\"".$id."\")'/><i>";
   if(count($wardFullDetails)>0 && $totalPages > 1){
   if($page > 1){
   $pageNo = $page - 1;
   $prev = " <i class='fa fa-backward' aria-hidden='true'  onclick='ShowParentCatListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$id."\")'/></i>";
   }       		
   if ($page < $totalPages) {
   $pageNo = $page + 1;
   $next = " <i class='fa fa-forward' aria-hidden='true'  onclick='ShowParentCatListPagination(\"".$pageNo."\",\"".$filter_by."\",\"".$id."\")'/><i>";
   } 
   if($pageNo=='')
    $pageNo=1;
   if($totalPages>1) {
   $pagebox="<td style='padding:0px'><input type='text' name='page' id='page' value='".$page."' onchange='ShowParentCatListPagination(this.value,\"".$filter_by."\",\"".$id."\")' style='border: 1px solid rgb(170, 170, 170); text-align: center;width:30%;height:30px' size='4'> of $totalPages</td>";
   }	
    $table_val = "<table  width='100%' cellpadding='5' cellspacing='0' border='0' style='border:0;'><tr><td align='center' style='border:1; font-size:14px; vertical-align:middle; color:#000; padding:10px;'></td><td align='right' style='padding-bottom:0px'><table align='right' cellpadding='0' cellspacing='1'><tr><td style='padding:0 2px;'>$first</td><td style='padding:0 2px;'> $prev </td>$pagebox<td style='padding:0 2px;'>$next </td><td style='padding:0 2px;'>$last</td></tr></table></td></tr></table>";
   }
   

foreach($ListingParentCatListArr as $key=>$value) { ?>
<div class="card">
   <div class="card-header bg-img"> WARD (<?php echo $value->ward_number; ?>) DETAILS</div>
   <input type="hidden" value="<?php echo $value->id ?>" id="wardId">
   <input type="hidden" value="<?php echo $value->district_id ?>" id="districtID">
   <input type="hidden" value="<?php echo $value->mandal_id ?>" id="mandal_id">

   <div class="card-body row">
   
   <?php  $officebearers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('ward_id' => $value->id.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N','orderby' => 'role_hierarchy', 'sortby' => 'asc');
          $officeberasList = Table::getData($officebearers); 
    ?>
    
        <table class="table table-striped table-bordered" >
            <thead>
            <tr><th colspan='6' style="color:#ff9933">WARD INCHARGE
                <?php                 
                $qry = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where (`role_hierarchy` ="W" OR `sub_role_hierarchy` ="W") AND `ward_id`='.$value->id.' AND `mandal_id`='.$value->mandal_id.' AND`status`="A"';
                $wardList=dB::mExecuteSql($qry); 
                if(count($wardList)<=0){
                ?>                                        
                <a href="javascript:void(0);" style="float:right" data-toggle="modal" class="btn btn-warning btn-sm float-right" style="color:#FFF" data-target=".deleteModel" onclick="addNewBoothIncharge('W')"><i class="fa fa-plus"></i> ADD NEW WARD INCHARGE</a>
                <?php } ?>
            </th>
            </tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>address</th>
                    <th>Verified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php                 
                $i = 1; 
                foreach($officeberasList as $key =>$val) {
                    if($val->role_hierarchy == 'W' || $val ->sub_role_hierarchy == 'W'){
                    ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $val->person_name; if($val->person_name_ta !=''){ ?>(<?php echo $val->person_name_ta ?>)<?php } ?></td>
                    <td><?php echo $val->mobile_number ?></td>
                    <td><?php echo $val->address ?></td>
                    <td><?php if($val->is_verified == 'N'){ echo '<p style="color:red;font-weight:700">NO</p>'; } else { echo '<p style="color:green;font-weight:700">YES</p>'; } ?></td>
                    <td>
                        <a href="javascript:void(0)" style="float:center;color:#fd7e14" data-toggle="modal" data-target=".deleteModel"  onclick="editwardofficebearers(<?php  echo $val->id ?>,'W')" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".deleteModel"  onclick="removeofficbearers(<?php echo $val->id ?>,'W')" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>    
            <?php $i ++;} } ?>      
            </tbody>    
        </table>

        <table class="table table-striped table-bordered" >
            <thead >
            <tr><th colspan='8' style="color:#ff9933">SHAKTI KENDRA INCHARGE                                              
                <a href="javascript:void(0);" style="float:right" data-toggle="modal" class="btn btn-warning btn-sm float-right" style="color:#FFF" data-target=".deleteModel" onclick="addNewBoothIncharge('SK')"><i class="fa fa-plus"></i> ADD NEW SHAKTI KENDR INCHARGE</a>
            </th>
            </tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>address</th>
                    <th>SK Name </th>
                    <th>Verified</th>
                    <th>Booth</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php                 
                $i = 1; 
                foreach($officeberasList as $key =>$val) {
                    if($val->role_hierarchy == 'SK' || $val ->sub_role_hierarchy == 'SK'){
                    ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $val->person_name; if($val->person_name_ta !=''){ ?>(<?php echo $val->person_name_ta ?>)<?php } ?></td>
                    <td><?php echo $val->mobile_number ?></td>
                    <td><?php echo $val->address ?></td>
                    <th>
                    <?php
                    $skname = 'select * from '.TBL_BJP_SK.' where  `id` = '.$val->sk_id.' AND `status` ="A" ORDER BY id';
                    $sknameList=dB::mExecuteSql($skname); 
                    foreach($sknameList as $key=>$va){
                    echo $va->sk_name;
                    }
                    ?>
                    </th>
                    <td><?php if($val->is_verified == 'N'){ echo '<p style="color:red;font-weight:700">NO</p>'; } else { echo '<p style="color:green;font-weight:700">YES</p>'; } ?></td>
                    <td><?php 
                    $getbooth = 'select * from '.TBL_BJP_BOOTH.' where  `id` IN ('.$val->booth_id.') AND `status` ="A" ORDER BY id';
                    $getboothList=dB::mExecuteSql($getbooth); 
                        foreach($getboothList as $key=>$v){
                               echo $v->booth_number; echo '<br>';
                        }
                    ?></td>
                    <td>
                        <a href="javascript:void(0)" style="float:center;color:#fd7e14" data-toggle="modal" data-target=".deleteModel"  onclick="editwardofficebearers(<?php echo $val->id ?>,'SK')" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".deleteModel"  onclick="removeofficbearers(<?php echo $val->id ?>,'SK')" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>    
            <?php $i ++;} } ?>      
            </tbody>    
        </table>

        <table class="table table-striped table-bordered" >
            <thead>
            <tr><th colspan='7' style="color:#ff9933">BOOTH INCHARGE
            <a href="javascript:void(0);" style="float:right" data-toggle="modal" class="btn btn-warning btn-sm float-right" style="color:#FFF" data-target=".deleteModel" onclick="addNewBoothIncharge('B')"><i class="fa fa-plus"></i> ADD NEW BOOTH INCHARGE</a>
            </th>
            </tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>address</th>
                    <th>Verified</th>
                    <th>Booth</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php                 
                $i = 1; 
                foreach($officeberasList as $key =>$val) {
                    if($val->role_hierarchy == 'B' || $val ->sub_role_hierarchy == 'B'){
                    ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $val->person_name; if($val->person_name_ta !=''){ ?>(<?php echo $val->person_name_ta ?>)<?php } ?></td>
                    <td><?php echo $val->mobile_number ?></td>
                    <td><?php echo $val->address ?></td>
                    <td><?php if($val->is_verified == 'N'){ echo '<p style="color:red;font-weight:700">NO</p>'; } else { echo '<p style="color:green;font-weight:700">YES</p>'; } ?></td>
                    <td><?php 
                    $getbooth = 'select * from '.TBL_BJP_BOOTH.' where  `id` IN ('.$val->booth_id.') AND `status` ="A"';
                    $getboothList=dB::mExecuteSql($getbooth); 
                        foreach($getboothList as $key=>$value){
                               echo $value->booth_number; echo '<br>';
                        }
                    ?></td>
                    <td>
                        <a href="javascript:void(0)" style="float:center;color:#fd7e14" data-toggle="modal" data-target=".deleteModel"  onclick="editwardofficebearers(<?php echo $val->id ?>,'B')" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".deleteModel"  onclick="removeofficbearers(<?php echo $val->id ?>,'B')" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>    
            <?php $i ++;} } ?>      
            </tbody>    
        </table>

        <table  class="wardDetails table table-striped table-bordered" >
            <thead>
            <tr><th colspan='6' style="color:#ff9933">BOOTH DETAILS</th>
            <th style="float:right"><a href="javascript:void(0);" data-toggle="modal" class="btn btn-warning btn-sm float-right" style="color:#FFF" data-target=".deleteModel" onclick="createNewBooth()"><i class="fa fa-plus"></i> ADD NEW BOOTH</a></th>
            </tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Booth Number</th>
                    <th>Total Voters</th>
                    <th>Male Voters</th>
                    <th>Female Voters</th>
                    <th>Others</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php 
             $boothquery = array('tableName' => TBL_BJP_BOOTH, 'fields' => array('*'),'condition' => array('ward_id' => $_POST['wardId'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'booth_number');
             $booth_list = Table::getData($boothquery);
             $i = 1; 

            foreach($booth_list as $key =>$val) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $val->booth_number ?></td>
                    <td><?php echo $val->total_voters ?></td>
                    <td><?php echo $val->male_voters_count ?></td>
                    <td><?php echo $val->female_voters_count ?></td>
                    <td><?php echo $val->other_voters_count ?></td>
                    <td>
                        <a href="javascript:void(0)" style="float:center;color:#fd7e14" data-toggle="modal" data-target=".deleteModel"  onclick="editBooth(<?php echo $val->id ?>)" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".deleteModel"  onclick="removeBooth(<?php echo $val->id ?>)" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>    
            <?php $i ++;} ?>      
            </tbody>    
        </table>

        <!-- <table class="table table-striped table-bordered" id="membersTable">
            <thead>
                <tr><th colspan='6' style="color:#ff9933">MEMBERS TABLE</th>
                <th style="float:right"><a href="javascript:void(0);" data-toggle="modal" class="btn btn-warning btn-sm float-right" style="color:#FFF" data-target=".deleteModel" onclick="createNewBooth()"><i class="fa fa-plus"></i> ADD NEW BOOTH</a></th>
                </tr>
                <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Membership No</th>
                    <th>Verified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php // $getmember = 'select * from '.TBL_BJP_MEMBER.' where `ward_id`='.$value->id.' AND `status` ="A"  ORDER BY `member_name` ASC';
                    //  $getmemberList=dB::mExecuteSql($getmember);
                       //   $i = 1; 
                       //   foreach($getmemberList as $key=>$val){ ?>
                          <tr>
                          <td><?php //echo $i; ?></td>
                          <td><?php// echo $val->member_name; ?></td>
                          <td><?php //echo $val->member_mobile; ?></td>
                          <td><?php //echo $val->membership_number; ?></td>
                          <td><?php //echo $val->is_verified; ?></td>
                          <td></td>
                          </tr>
                <?php // $i ++; } ?>
            </tbody>
        </table> -->

   <!-- Table -->
   <div class="row offset-sm-8 col-sm-12">
        <div class="col-sm-2">
            <select id='searchByVerifyed' class="form-control">
                <option value=''>-- Verifyed Member --</option>
                <option value='Y'>YES</option>
                <option value='N'>NO</option>
            </select>    
        </div>
        <div class="col-sm-2">
            <select id='searchByBooth' class="form-control">
                <option value=''>-- Select Booth --</option>
                <?php  foreach($booth_list as $key =>$val) { ?> 
                <option value="<?php echo $val->id ?>"><?php echo $val->booth_number ?></option>
                <?php } ?>
            </select>    
        </div>
    </div>
    <table id='membersTable' class='display dataTable table table-striped table-bordered'>  
        <thead>
        <tr>
            <th colspan='6' style="color:#ff9933">MEMBERS TABLE
            <a href="javascript:void(0);" data-toggle="modal" class="btn btn-warning btn-sm float-right" style="color:#FFF" data-target=".deleteModel" onclick="createNewMember()"><i class="fa fa-plus"></i> ADD NEW MEMBER</a>
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
<br>
<?php   } ?>

<!-- Modal -->
<div class="modal fade deleteModel" role="dialog">
    <div class="modal-dialog modal-lg">
        <span id="modelshow"></span>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.wardDetails').DataTable( {
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false
    } );
    // $('#membersTable').DataTable();

    var dataTable = $('#membersTable').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    // 'searching': false, // Remove default Search Control
    'ajax': {
       'url':'membertable.php',
       'data': function(data){
          // Read values
          var wardId = $('#wardId').val();
          var gender = $('#searchByBooth').val();
          var verifed = $('#searchByVerifyed').val();
          // Append to data
          data.action = 'dynamicSearch';
          data.searchByBooth = gender;
          data.searchByVerifyed = verifed;
          data.wardId = wardId;
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

  $('#searchByVerifyed').change(function(){
    dataTable.draw();
  });

  $('#searchByBooth').change(function(){
    dataTable.draw();
  });




});

function editwardofficebearers(id,role) {
    paramData = {'obid':id,'action':'editwardOfficeBearers','role':role}                     
    ajax({
        a:"districtmodel",
        b:paramData,
        c:function(){},
        d:function(data){
        $('#modelshow').html(data);
        }
    });
}
function removeofficbearers(id,sub){
    var wardId = $('#wardId').val();
    paramData = {'ofid':id,'action':'deleteWardMembers','ward':wardId,'subRole':sub}
    ajax({
            a:"districtmodel",
            b:paramData,
            c:function(){},
            d:function(data){
                $('#modelshow').html(data);
            }
    });   
}

function createNewBooth(){
    var wardId = $('#wardId').val();
    paramModel = {'action':'addEditNewBooth','ward':wardId}
    ajax({
        a:"districtmodel",
        b:paramModel,
        c:function(){},
        d:function(data){
            $('#modelshow').html(data);
        }
    });   
}

function editBooth(id){
    var wardId = $('#wardId').val();
    paramModel = {'action':'addEditNewBooth','ward':wardId,'boothid':id}
    ajax({
        a:"districtmodel",
        b:paramModel,
        c:function(){},
        d:function(data){
            $('#modelshow').html(data);
        }
    });   
}

function removeBooth(id){
    var wardId = $('#wardId').val();
    paramData = {'boothid':id,'action':'deleteBooth','wardId':wardId}
    ajax({
        a:"districtmodel",
        b:paramData,
        c:function(){},
        d:function(data){
            $('#modelshow').html(data);
        }
    });   
}


function addNewBoothIncharge(role){
    var wardId = $('#wardId').val();
    var districtID = $('#districtID').val();
    var mandal_id = $('#mandal_id').val();

    model = {'action':'addNewIncharge','role':role,'wardId':wardId,'districtID':districtID,'mandal_id':mandal_id}
    ajax({
            a:"districtmodel",
            b:model,
            c:function(){},
            d:function(data){
                $('#modelshow').html(data);
            }
    });   
}
function editMember(id){
    // alert(id);
}
function createNewMember(){

    $('.deleteModel').on('show', function () {
      $('.modal-body',this).css({width:'auto',height:'auto', 'max-height':'100%'});
});

    var wardId = $('#wardId').val();
    paramModel = {'action':'addEditMember','ward':wardId}
    ajax({
        a:"districtmodel",
        b:paramModel,
        c:function(){},
        d:function(data){
            $('#modelshow').html(data);
        }
    });   
}
</script>