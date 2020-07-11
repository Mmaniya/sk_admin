<?php

include 'includes.php';
 $member_ID = $_POST['member_ID'];
 $modelAction = $_POST['action'];
 $joined_date ='';
 if($member_ID>0) { 
      $param = array('tableName'=>TBL_BJP_MEMBER,'fields'=>array('*'),'condition'=>array('id'=>$member_ID.'-INT'),'showSql'=>'N',);
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
      <span style="color:#eab15c"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT MEMBER </span>
   </h5>
</div>
<div class="modal-body">
   <form action="javascript:void(0)" id="formMember" method="POST">
      <input type="hidden" value="<?php echo $member_ID ?>" name="id">
      <input type="hidden" value="mmemberEdit" name="act">
      <div class="form-group">
         <label >Member Name</label>
         <input type="text" class="form-control" name="member_name"  value="<?php echo $roleData->member_name; ?>" required placeholder="Enter Member Name">
      </div>
      <div class="form-group">
         <label >Tamil Name of Member </label>
         <input type="text" class="form-control" name="member_name_ta"  value="<?php echo $roleData->member_name_ta; ?>" placeholder="Enter Tamil Name of Member">
      </div>
      <input type="submit" id="submit" class="btn btn-success" <?php  if($modelId == ''){ ?> value="Submit" <?php } else { ?> value="Update" <?php } ?>>
   </form>
</div>
</div>
<script>
   $('form#formMember').validate({
         rules: {
            member_name: "required",
            member_name_ta: "required",
         },
         messages: {
            state_id: "Please Enter Name",
            district_name: "Please Enter Tamil Name of Member",
         },
         submitHandler: function(form){
         var formData = $('form#formMember').serialize();
            ajax({
               a:"memberajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('#myModal').modal('toggle');
                  paramData = {'act':'getAllData','type':'all'}; 
                     ajax({
                           a:"memberajax",
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
<?php } else if($modelAction == 'addEditMember'){ ?>
<div class="modal-content">
   <div class="modal-header">
      <?php  if($_POST['memberID'] == '') { ?><h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> ADD NEW MEMBER</h5>
      <?php } else { ?> 
         <h5 class="modal-title" style="color:orange"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT NEW MEMBER</h5>
      <?php } ?>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="modal-body">
   <form action="javascript:void(0)" id="formAddEditMember" method="POST">
      <?php 
         $param = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'), 'condition' => array('id' => $_POST['memberID'].'-INT','status' =>'A-CHAR'), 'showSql' => 'N');
         $memberList = Table::getData($param);
      ?>
      <input type="hidden" value="addEditMember" name="act">
      <input type="hidden" class="form-control" name="id" id="memberid" readonly value="<?php echo $memberList->id; ?>">
      <input type="hidden" class="form-control" name="state_id" id="state_id" readonly value="1">
      <input type="hidden" readonly id="district_id" value="<?php echo $memberList->district_id; ?>">
      <input type="hidden" readonly id="lg_const_id" value="<?php echo $memberList->lg_const_id; ?>">
      <input type="hidden" readonly id="mandal_id" value="<?php echo $memberList->mandal_id; ?>">
      <input type="hidden" readonly id="ward_id" value="<?php echo $memberList->ward_id; ?>">
      <input type="hidden" readonly id="booth_id" value="<?php echo $memberList->booth_id; ?>">
      <input type="hidden" readonly id="booth_branch_id" value="<?php echo $memberList->booth_branch_id; ?>">

      <h6>MEMBER MANDAL DETAILS</h6>
      <div class="row">
         <select id='District' name="district_id" class="col-sm-3 form-control"> 
               <option value=''  disabled selected>--Select District--</option>     
         </select>    
         <select id='Constituency' name="lg_const_id" class="offset-sm-1 col-sm-3 form-control">
            <option value=''  disabled selected>--Select Constituency--</option>
         </select>
         <select id='MandalDetails' name="mandal_id" class="offset-sm-1 col-sm-3 form-control">
            <option value='' disabled selected>--Select Mandal--</option>
         </select>
      </div><br>
      <div class="row">
         <select id='Ward' name="ward_id" class="col-sm-3 form-control">
            <option value='' disabled selected>--Select Ward--</option>
         </select>
         <select id='Booth' name="booth_id" class="offset-sm-1 col-sm-3 form-control">
            <option value='' disabled selected>--Select Booth--</option>
         </select> 
         <select id='BoothBranch' name="booth_branch_id" class="offset-sm-1 col-sm-3 form-control">
            <option value='' disabled selected>--Select Booth Branch--</option>
         </select>                                            
      </div>
      <br><hr>
      <h6>MEMBER PERSONAL DETAILS</h6>
      <div class="row">       
         <div class="form-group col-sm-4">
            <label >Member Name</label>  
               <input type="text" class="form-control" name="member_name" value="<?php echo $memberList->member_name ?>" placeholder="Enter Member Name">
         </div>
         <div class="form-group col-sm-4">
            <label >Member Name Tamil</label>  
               <input type="text" class="form-control" name="member_name_ta" value="<?php echo $memberList->member_name_ta ?>" placeholder="Enter Member Name in Tamil">
         </div>
         <div class="form-group col-sm-4">
            <label >Membership Number</label>  
               <input type="text" class="form-control" name="membership_number" value="<?php echo $memberList->membership_number ?>" placeholder="Enter Membership Number">
         </div>
      </div>
      <div class="row">           
         <div class="form-group col-sm-4">
            <label >Member Mobile </label>  
               <input type="text" class="form-control" name="member_mobile" value="<?php echo $memberList->member_mobile ?>" placeholder="Total Member Mobile Number">
         </div>
         <div class="form-group col-sm-4">
               <label class="checkbox-inline">Same Number in Whatsapp</label>  <br>
                  <input type="radio" <?php if($memberList->is_whatsapp =="Y") { echo "checked"; } ?>  name="is_whatsapp" value="Y"> Yes
                  <input type="radio" <?php if($memberList->is_whatsapp =="N") { echo "checked"; } ?>  name="is_whatsapp" value="N"> No
         </div>
         <div class="form-group col-sm-4">
            <label >Member Alternative Mobile </label>  
               <input type="text" class="form-control" name="member_another_mobile" value="<?php echo $memberList->member_another_mobile ?>" placeholder="Total Member Mobile Number(optinal)">
         </div>
      </div>
      <div class="row">           
         <div class="form-group col-sm-3">
            <label >Member E-Mail </label>  
               <input type="email" class="form-control" name="member_email_address" value="<?php echo $memberList->member_email_address ?>" placeholder="Total Member E-Mail">
         </div>
         <div class="form-group col-sm-3">
            <label >Member DOB</label>  
               <input type="date" class="form-control" name="member_DOB" value="<?php echo $memberList->member_DOB ?>" placeholder="Enter Member DOB">
         </div>       
         <div class="form-group col-sm-2">
            <label >Member Age </label>  
               <input type="text" class="form-control" name="member_age" value="<?php echo $memberList->member_age ?>" placeholder="Age">
         </div>
         <div class="form-group col-sm-2">
            <label >Gender </label>  
               <select class="form-control" name="member_gender" value="">
               <option value="" selected disabel>Gender</option>
               <option <?php if ($memberList->member_gender == 'M' ) echo 'selected' ; ?> value="M">Male</option>
               <option <?php if ($memberList->member_gender == 'F' ) echo 'selected' ; ?> value="F">Female</option>
               <option <?php if ($memberList->member_gender == 'O' ) echo 'selected' ; ?> value="O">Others</option>
               </select>
         </div>
         <div class="form-group col-sm-2">
            <label >Blood Group </label>  
               <input type="text" class="form-control" name="blood_group" value="<?php echo $memberList->blood_group ?>" placeholder="Blood Group">
         </div>
      </div>
      <hr>
      <h6>MEMBER EDUCATION/JOB DETAILS</h6>
      <div class="row">
         <div class="form-group col-sm-4">
            <label >Degree of Education </label>
               <input type="text" class="form-control" name="member_education" value="<?php echo $memberList->member_education	 ?>" placeholder="Completed Degree">
         </div>
         <div class="form-group col-sm-4">
            <label >Job Category	</label>  
               <input type="text" class="form-control" name="job_category" value="<?php echo $memberList->job_category ?>" placeholder="Job Category">
         </div>       
         <div class="form-group col-sm-4">
            <label >Others Job Category	 </label>  
               <input type="text" class="form-control" name="others_job_category" value="<?php echo $memberList->others_job_category ?>" placeholder="Others Job Category	">
         </div>
      </div>
      <hr>
      <h6>MEMBER ADDRESS & ID DETAILS</h6>
      <div class="row">
         <div class="form-group col-sm-9">
            <label >Address</label>
               <input type="text" class="form-control" name="member_address" value="<?php echo $memberList->member_address ?>" placeholder="Member Address">
         </div>
         <div class="form-group col-sm-3">
            <label >Zip Code	</label>  
               <input type="text" class="form-control" name="member_zip" value="<?php echo $memberList->member_zip ?>" placeholder="Zip Code">
         </div>           
      </div>
      <div class="row">
         <div class="form-group col-sm-4">
            <label >Member Photo</label>  
               <input type="file" class="form-control" name="member_photo" value="<?php echo $memberList->member_photo ?>" placeholder="Member Photo">
         </div>
         <div class="form-group col-sm-4">
            <label >Member Voter Id	</label>
               <input type="text" class="form-control" name="member_voter_id" value="<?php echo $memberList->member_voter_id ?>" placeholder="Member Voter ID">
         </div>
         <div class="form-group col-sm-4">
            <label >Member Aadhar Number</label>  
               <input type="text" class="form-control" name="member_aadhar_number" value="<?php echo $memberList->member_aadhar_number ?>" placeholder="Member Aadhar Number">
         </div>       
      </div> 
      <input type="submit" id="submit"  class="btn btn-success" value="Submit">
   </form>

   </div>
</div>
<script type="text/javascript">
      var dist = $('#district_id').val();
      var constituency = $('#lg_const_id').val();
      var mandal = $('#mandal_id').val();
      var ward = $('#ward_id').val();
      var booth = $('#booth_id').val();
      var boothbranch = $('#booth_branch_id').val();

      paramDist = {'act':'getallDistrict','selected':dist}
      ajax({
         a:"memberajax",
         b:paramDist,
         c:function(){},
         d:function(data){
               $('#District').html(data);
         }
      });

      paramDist = {'act':'getallConstituency','dist':dist,'selected':constituency}
      ajax({
         a:"memberajax",
         b:paramDist,
         c:function(){},
         d:function(data){
            $('#Constituency').html(data);
         }
      });

      paramconst = {'act':'getallMandal','dist':dist,'const':constituency,'selected':mandal}
      ajax({
         a:"memberajax",
         b:paramconst,
         c:function(){},
         d:function(data){
            $('#MandalDetails').html(data);
         }
      });

      parammandal = {'act':'getallWard','mandal':mandal,'selected':ward}
      ajax({
         a:"memberajax",
         b:parammandal,
         c:function(){},
         d:function(data){
            $('#Ward').html(data);
         }
      });

      paramward = {'act':'getallBooth','ward':ward,'selected':booth}
      ajax({
         a:"memberajax",
         b:paramward,
         c:function(){},
         d:function(data){
            $('#Booth').html(data);
         }
      });
      
      parambooth = {'act':'getallBoothBranch','booth':booth,'selected':boothbranch}
      ajax({
         a:"memberajax",
         b:parambooth,
         c:function(){},
         d:function(data){
            $('#BoothBranch').html(data);
         }
      });

   $('#District').change(function(){
      var dist = $(this).val();
      param = {'act':'getallConstituency','dist':dist}
      ajax({
         a:"memberajax",
         b:param,
         c:function(){},
         d:function(data){
            $('#Constituency').html(data);
         }
      });
   });
   $('#Constituency').change(function(){
      var dist = $('#District').val();
      var constituency = $(this).val();      
      param = {'act':'getallMandal','dist':dist,'const':constituency}
      ajax({
         a:"memberajax",
         b:param,
         c:function(){},
         d:function(data){
            $('#MandalDetails').html(data);
         }
      });
   });
   $('#MandalDetails').change(function(){
         var mandal = $(this).val();
         param = {'act':'getallWard','mandal':mandal}
         ajax({
            a:"memberajax",
            b:param,
            c:function(){},
            d:function(data){
               $('#Ward').html(data);
            }
         });
   });
   $('#Ward').change(function(){
         var ward = $(this).val();
         param = {'act':'getallBooth','ward':ward}
         ajax({
            a:"memberajax",
            b:param,
            c:function(){},
            d:function(data){
               $('#Booth').html(data);
            }
         });
   });
   $('#Booth').change(function(){
         var booth = $(this).val();
         param = {'act':'getallBoothBranch','booth':booth}
         ajax({
            a:"memberajax",
            b:param,
            c:function(){},
            d:function(data){
               $('#BoothBranch').html(data);
            }
         });
   }); 

   $('form#formAddEditMember').validate({
         // rules: {
         //    member_name: "required",
         //    member_name_ta: "required",
         // },
         // messages: {
         //    state_id: "Please Enter Name",
         //    district_name: "Please Enter Tamil Name of Member",
         // },
         submitHandler: function(form){
         var formData = $('form#formAddEditMember').serialize();
            ajax({
               a:"memberajax",
               b:formData,
               c:function(){},
               d:function(data){
                  $('.memberModel').modal('toggle');              
               }          
            });
         }
   });
</script>
<?php } else if($modelAction == 'updateAllMember'){ ?>
<div class="modal-content">
   <div class="modal-header">
      <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> UPDATE NEW MEMBERS</h5>     
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="modal-body">
      <form action="javascript:void(0)" id="formAddEditMember" method="POST">
         <?php 
            $searchQuery = " ";
    
            if($_POST["lg_const_id"] != ''){
                $searchQuery .= " and (lg_const_id='".$_POST["lg_const_id"]."') ";
            }
            if($_POST["mandal_id"] != ''){
               $searchQuery .= " and (mandal_id='".$_POST["mandal_id"]."') ";
            }
            if($_POST["ward_id"] != ''){
                $searchQuery .= " and (ward_id='".$_POST["ward_id"]."') ";
            }
            if($_POST["booth_id"] != ''){
                $searchQuery .= " and (booth_id='".$_POST["booth_id"]."') ";
            }
            if($_POST["booth_branch_id"] != ''){
                $searchQuery .= " and (booth_branch_id='".$_POST["booth_branch_id"]."') ";
            }
            if($_POST["is_verified"] != ''){
                $searchQuery .= " and (is_verified = '".$_POST["is_verified"]."' ) ";
            }
            if($_POST["is_wag_link_sent"] != ''){
                $searchQuery .= " and (is_wag_link_sent = '".$_POST["is_wag_link_sent"]."' ) ";
            }
            if($_POST["member_community"] != ''){
                $searchQuery .= " and (member_community ='".$_POST["member_community"]."' ) ";
            }
            if($_POST["member_gender"] != ''){
                $searchQuery .= " and (member_gender ='".$_POST["member_gender"]."' ) ";
            }   
            if($_POST["member_age"] != ''){
                $searchQuery .= " and (member_age ='".$_POST["member_age"]."' ) ";
            }

           $qry = 'select * from '.TBL_BJP_MEMBER.' WHERE `district_id`='.trim($_POST["district_id"]).''.$searchQuery.'';
           $memberList=dB::mExecuteSql($qry);

           $newarry = array();
           foreach ($memberList as $K => $V){
               $newarry[]= $V->id;
           }
           $member = implode(',',$newarry);

         ?>
         <input type="hidden" value="addEditMember" name="act">
            <input type="hidden" value="<?php echo $member; ?>" name="memberID">
         <h6>MEMBER MANDAL DETAILS</h6>
         <div class="row">
            <select id='District' name="district_id" class="col-sm-3 form-control"> 
                  <option value=''  disabled selected>--Select District--</option>     
            </select>    
            <select id='Constituency' name="lg_const_id" class="offset-sm-1 col-sm-3 form-control">
               <option value=''  disabled selected>--Select Constituency--</option>
            </select>
            <select id='MandalDetails' name="mandal_id" class="offset-sm-1 col-sm-3 form-control">
               <option value='' disabled selected>--Select Mandal--</option>
            </select>
         </div><br>
         <div class="row">
            <select id='Ward' name="ward_id" class="col-sm-3 form-control">
               <option value='' disabled selected>--Select Ward--</option>
            </select>
            <select id='Booth' name="booth_id" class="offset-sm-1 col-sm-3 form-control">
               <option value='' disabled selected>--Select Booth--</option>
            </select> 
            <select id='BoothBranch' name="booth_branch_id" class="offset-sm-1 col-sm-3 form-control">
               <option value='' disabled selected>--Select Booth Branch--</option>
            </select>                                            
         </div>
         <br><hr>        
         <input type="submit" id="submit"  class="btn btn-success" value="Submit">
      </form>
   </div>
</div>
<script>

      paramDist = {'act':'getallDistrict'}
      ajax({
         a:"memberajax",
         b:paramDist,
         c:function(){},
         d:function(data){
               $('#District').html(data);
         }
      });

   $('#District').change(function(){
      var dist = $(this).val();
      param = {'act':'getallConstituency','dist':dist}
      ajax({
         a:"memberajax",
         b:param,
         c:function(){},
         d:function(data){
            $('#Constituency').html(data);
         }
      });
   });
   $('#Constituency').change(function(){
      var dist = $('#District').val();
      var constituency = $(this).val();      
      param = {'act':'getallMandal','dist':dist,'const':constituency}
      ajax({
         a:"memberajax",
         b:param,
         c:function(){},
         d:function(data){
            $('#MandalDetails').html(data);
         }
      });
   });
   $('#MandalDetails').change(function(){
         var mandal = $(this).val();
         param = {'act':'getallWard','mandal':mandal}
         ajax({
            a:"memberajax",
            b:param,
            c:function(){},
            d:function(data){
               $('#Ward').html(data);
            }
         });
   });
   $('#Ward').change(function(){
         var ward = $(this).val();
         param = {'act':'getallBooth','ward':ward}
         ajax({
            a:"memberajax",
            b:param,
            c:function(){},
            d:function(data){
               $('#Booth').html(data);
            }
         });
   });
   $('#Booth').change(function(){
         var booth = $(this).val();
         param = {'act':'getallBoothBranch','booth':booth}
         ajax({
            a:"memberajax",
            b:param,
            c:function(){},
            d:function(data){
               $('#BoothBranch').html(data);
            }
         });
   }); 
</script>
<?php } ?>