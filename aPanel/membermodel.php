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
<!--==== 1. ADD EDIT SINGLE MEMBER UPDATE  ===-->

   <?php if($modelAction == 'addEditMember'){ ?>
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

         <h6>MEMBER BASIC DETAILS</h6>
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
                     $('#membersTable').dataTable()._fnAjaxUpdate();
                     $('.memberModel').modal('toggle');              
                  }          
               });
            }
      });
   </script>
<!--==== 2. UPDATE ALL MEMBERS   =============-->
   <?php } else if($modelAction == 'updateAllMember'){ ?>
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" style="color:green"><i class="fa fa-plus" aria-hidden="true"></i> UPDATE NEW MEMBERS</h5>     
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
         <form action="javascript:void(0)" id="formupdateAllMember" method="POST">
           <?php
            if($_POST['member_id'] != ''){
            foreach ($_POST['member_id'] as $K => $V){
                  $member = implode(',',$_POST['member_id']);
               }
            }
            ?>   
            <input type="hidden" value="<?php echo $member; ?>" name="id">
            <input type="hidden" value="updateAllMembers" name="act">
               <input type="hidden" value="1" name="state_id">
            <h6>MEMBER MANDAL DETAILS</h6>
            <div class="row">
               <select id='District' name="district_id" class="col-sm-3 form-control"> 
                     <option value='' disabled selected>--Select District--</option>     
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
      $('form#formupdateAllMember').validate({
            // rules: {
            //    member_name: "required",
            //    member_name_ta: "required",
            // },
            // messages: {
            //    state_id: "Please Enter Name",
            //    district_name: "Please Enter Tamil Name of Member",
            // },
            submitHandler: function(form){
            var formData = $('form#formupdateAllMember').serialize();
               ajax({
                  a:"memberajax",
                  b:formData,
                  c:function(){},
                  d:function(data){
                     $('#membersTable').dataTable()._fnAjaxUpdate();
                     $('.memberModel').modal('toggle');              
                  }          
               });
            }
      });
   </script>
<!--==== 3. DELETE SINGLE MEMBERS  ===========-->
   <?php } else if ($modelAction == 'memberDelete'){ ?>
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
         <form id="formMemberDelete" action="javascipt:void(0)">
            <input type="hidden" name="act" value="statusDataUpdate">
            <input type="hidden" name="id" value="<?php echo $_POST['memberID']; ?>">
            <input type="hidden" value="I" name="status">
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               <input type="submit" id="submit" class="btn btn-danger" value="Delete">
            </div>
         </form>
      </div>
      <script>
         $('form#formMemberDelete').validate({
               submitHandler: function(form){
               var formData = $('form#formMemberDelete').serialize();
                  ajax({
                     a:"memberajax",
                     b:formData,
                     c:function(){},
                     d:function(data){
                        $('#membersTable').dataTable()._fnAjaxUpdate();
                        $('.memberModel').modal('toggle');               
                     }          
                  });
               }
            })
      </script>
<!--==== 4. RESTORE SINGLE MEMBERS  ==========-->
   <?php } else if ($modelAction == 'memberRetore'){ ?>
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title"style="color:green"><i class="fa fa-undo"aria-hidden="true"></i> RETORE RECORD</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p>Are you sure cofirm restore this data.?</p>
         </div>
         <form id="formMemberDelete" action="javascipt:void(0)">
            <input type="hidden" name="act" value="statusDataUpdate">
            <input type="hidden" name="id" value="<?php echo $_POST['memberID']; ?>">
            <input type="hidden" value="A" name="status">
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               <input type="submit" id="submit" class="btn btn-danger" value="Delete">
            </div>
         </form>
      </div>
      <script>
         $('form#formMemberDelete').validate({
               submitHandler: function(form){
               var formData = $('form#formMemberDelete').serialize();
                  ajax({
                     a:"memberajax",
                     b:formData,
                     c:function(){},
                     d:function(data){
                        $('#membersTable').dataTable()._fnAjaxUpdate();
                        $('.memberModel').modal('toggle');               
                     }          
                  });
               }
            })
      </script>
<!--==== 5. VIEW SINGLE MEMBERS Details ======-->
   <?php } else if ($modelAction == 'memberDetailsView'){ ?>
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" style="color:green"><i class="fa fa-eye" aria-hidden="true"></i> VIEW MEMBERS DETAILS</h5>     
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <?php 
               $param = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'), 'condition' => array('id' => $_POST['memberID'].'-INT'), 'showSql' => 'N');
               $memberList = Table::getData($param);
            ?>
            <input type="hidden" readonly id="district_id" value="<?php echo $memberList->district_id; ?>">
            <input type="hidden" readonly id="lg_const_id" value="<?php echo $memberList->lg_const_id; ?>">
            <input type="hidden" readonly id="mandal_id" value="<?php echo $memberList->mandal_id; ?>">
            <input type="hidden" readonly id="ward_id" value="<?php echo $memberList->ward_id; ?>">
            <input type="hidden" readonly id="booth_id" value="<?php echo $memberList->booth_id; ?>">
            <input type="hidden" readonly id="booth_branch_id" value="<?php echo $memberList->booth_branch_id; ?>">
               <h6>MEMBER BASIC DETAILS</h6>
            <div class="row">
               <span  class="col-sm-6"> District : <strong><span id='District'></span></strong></span> 
               <span  class="col-sm-6"> Constituency : <strong><span id='Constituency'></span></strong></span> 
            </div><br>
            <div class="row">
               <span  class="col-sm-6"> Mandal : <strong><span id='MandalDetails'></span></strong></span>
               <span  class="col-sm-6"> Ward : <strong><span id='Ward'></span></strong></span>  
            </div><br>
            <div class="row">
               <span  class="col-sm-6"> Booth : <strong><span id='Booth'></span></strong></span>
               <span  class="col-sm-6"> Booth Branch : <strong><span id='BoothBranch'></span></strong></span>
            </div>
            <br><hr>
            <h6>MEMBER PERSONAL DETAILS</h6>
            <div class="row">
               <div class="col-sm-6">
                  <span class="col-sm-6">
                     <span>NAME : <?php echo $memberList->member_name; ?>&nbsp;(<?php echo $memberList->member_name_ta ?>)</span>
                  </span><br>
                  <span class="col-sm-6">
                     <span >MOBILE : <?php echo $memberList->member_mobile;?>,<?php echo $memberList->member_another_mobile; ?></span>
                  </span><br>
                  <span class="col-sm-6">
                     <span >E-MAIL : <?php echo $memberList->member_email_address;?></span>
                  </span><br>
                  <span class="col-sm-6">
                     <span >GENDER :<?php if($memberList->member_gender =='M'){ echo 'Male'; }else if($memberList->member_gender =='F') { echo 'Female'; }?></span>
                  </span><br>
                  <span class="col-sm-6">
                     <span >DOB :<?php echo $memberList->member_DOB;?></span>
                  </span><br> 
                  <span class="col-sm-6">
                     <span>AGE :<?php echo $memberList->member_age;?></span>
                  </span><br>
                  <span class="col-sm-6">
                     <span >BLOOD GROUP :<?php echo $memberList->blood_group	;?></span>
                  </span>          
               </div>
               <div class="col-sm-6">
                  <span class="col-sm-6">
                     <span>MEMBERSHIP NO : <?php echo $memberList->membership_number; ?></span><br>
                  </span>
                  <span class="col-sm-6">
                     <?php if($memberList->member_photo !=''){ ?>
                     <img src="../images/member/<?php echo $memberList->member_photo; ?>" alt="Member IMG" width="150" height="150">
                     <?php } else { ?>
                        <img src="assets/images/user.jpg" alt="Member IMG" width="150" height="150">
                     <?php } ?>
                  </span>
               </div>
            </div>
           <hr>
            <h6>MEMBER EDUCATION/JOB DETAILS</h6>
            <div class="row">
               <span class="col-sm-4">
                  <span>EDUCATION : <?php echo $memberList->member_education; ?></span>
               </span>
               <span class="col-sm-4">
                  <span>JOB : <?php echo $memberList->job_category; ?></span>
               </span>
               <span class="col-sm-4">
                  <span>OTHERS JOB : <?php echo $memberList->others_job_category; ?></span>
               </span>
            </div>
            <br><hr>
            <h6>MEMBER ADDRESS & ID DETAILS</h6>
            <div class="row">
               <span class="col-sm-12"> 
                  <span>ADDRESS : <?php echo $memberList->member_address; ?>&nbsp;<?php echo $memberList->member_zip; ?></span>
               </span>  
            </div><br>
            <div class="row">
               <span class="col-sm-6"> 
                  <span>VOTER ID : <?php echo $memberList->member_voter_id; ?></span>
               </span>
               <span class="col-sm-6"> 
                  <span>AADHAR NO : <?php echo $memberList->member_aadhar_number; ?></span>
               </span>
            </div>
         </div>        
      </div>
      <script type="text/javascript">
         var dist = $('#district_id').val();
         var constituency = $('#lg_const_id').val();
         var mandal = $('#mandal_id').val();
         var ward = $('#ward_id').val();
         var booth = $('#booth_id').val();
         var boothbranch = $('#booth_branch_id').val();

         paramDist = {'act':'getmemberDistrict','selected':dist}
         ajax({
            a:"memberajax",
            b:paramDist,
            c:function(){},
            d:function(data){
               $('#District').html(data);
            }
         });

         paramDist = {'act':'getmemberConstituency','selected':constituency}
         ajax({
            a:"memberajax",
            b:paramDist,
            c:function(){},
            d:function(data){
               $('#Constituency').html(data);
            }
         });

         paramconst = {'act':'getmemberMandal','selected':mandal}
         ajax({
            a:"memberajax",
            b:paramconst,
            c:function(){},
            d:function(data){
               $('#MandalDetails').html(data);
            }
         });

         parammandal = {'act':'getmemberWard','selected':ward}
         ajax({
            a:"memberajax",
            b:parammandal,
            c:function(){},
            d:function(data){
               $('#Ward').html(data);
            }
         });

         paramward = {'act':'getmemberBooth','selected':booth}
         ajax({
            a:"memberajax",
            b:paramward,
            c:function(){},
            d:function(data){
               $('#Booth').html(data);
            }
         });
         
         parambooth = {'act':'getmemberBoothBranch','selected':boothbranch}
         ajax({
            a:"memberajax",
            b:parambooth,
            c:function(){},
            d:function(data){
               $('#BoothBranch').html(data);
            }
         });
      </script>
   <?php } ?>