<!--==================================
Name: Manikandan;
Create: 1/6/2020;
Update: 4/6/2020;
Use: SUB ROLE HIERARACHY 
====================================-->

<!-- ======= SUB ROLE DISTRICT ============ -->
   <?php if ($district_list != ''){ ?>
      <div id="State_District">
         <div class="row" >
            <div class="col-md-4 col-lg-4">
               <label>Sub Select District</label><br />
               <select name="district_id[]" class="form-control S_subSelectDistrict">
                  <option selected="true" disabled="disabled" value="">Please Select District</option>
                  <?php 
                     $array = explode(",",$_POST['dist_ID_edit']);
                     $val =  array_unique( array_diff_assoc( $array, array_unique( $array ) ) );
                     foreach(array_count_values($val) as $v => $c)
                     
                     $param = " Select * from ".TBL_BJP_MANDAL. " where `district_id` IN (".$v.") ";
                     $subMandal = dB::mEXecuteSql($param);
                     $mandalarray = $_POST['Mandal_id_edit'];
                     
                     $ward = " Select * from ".TBL_BJP_WARD. " where `mandal_id` IN (".$_POST['Mandal_id_edit'].")";
                     $subWard = dB::mEXecuteSql($ward);
                     $wardarray = $_POST['ward_id_edit'];
                     
                     $sk = " Select * from ".TBL_BJP_SK. " where `ward_id` IN (".$_POST['ward_id_edit'].") ";
                     $subsk = dB::mEXecuteSql($sk);
                     $skarray = $_POST['sk_id_edit'];
                     
                     $bootharray = $_POST['booth_id_edit'];
                     $booth = " Select * from ".TBL_BJP_BOOTH. " where `id` IN (".$bootharray.")";
                     $subbooth = dB::mEXecuteSql($booth);
                     
                     foreach($district_list as $key=>$value) {         
                     ?>
                  <option <?php if($v == $value->id) { echo 'selected="selected"'; } ?> value='<?php echo $value->id; ?>'><?php echo $value->district_name ?></option>
                  <?php 
                     } ?>
               </select>
            </div>
            <?php if($_POST['selected'] == 'D'){?>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Mandal</label><br/>
               <select  name="mandal_id[]" multiple class="form-control S_subSelectMandal">               
               <?php 
                  $mandalarraymultiple = explode(",",$_POST['Mandal_id_edit']);
                  foreach ($subMandal as $index => $value) { ?>
                  <option <?php foreach( $mandalarraymultiple as $val ) { if($value->id == $val) { echo 'selected="selected"'; } } ?> value='<?php echo $value->id; ?>'><?php echo $value->mandal_name; ?></option>
                  <?php }?>
               </select>
            </div>
            <?php } else if($_POST['selected'] == 'M'){?>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Mandal</label><br />
               <select name="mandal_id[]" class="form-control S_subSelectMandal">
                  <option selected="true" disabled="disabled" value="">Please Select Mandal</option>
                  <?php  foreach ($subMandal as $index => $value) { ?>
                  <option <?php if($value->id == $mandalarray) { echo 'selected="selected"'; } ?> value='<?php echo $value->id; ?>'><?php echo $value->mandal_name; ?></option>
                  <?php }?>
               </select>
            </div>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Ward</label><br />
               <select  name="ward_id[]" multiple class="form-control S_subSelectWard">
                  <?php
                  $wardarraymultiple = explode(",",$_POST['ward_id_edit']);
                  foreach ($subWard as $index => $ward) { ?>
                  <option <?php foreach( $wardarraymultiple as $val ) {  if($ward->id == $val) { echo 'selected="selected"'; } }?> value='<?php echo $ward->id; ?>'><?php echo $ward->ward_number; ?></option>
                  <?php }?>
               </select>
            </div>
            <?php } else if($_POST['selected'] == 'W'){ ?>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Mandal</label><br />
               <select name="mandal_id[]" class="form-control S_subSelectMandal">
                  <option selected="true" disabled="disabled" value="">Please Select Mandal</option>
                  <?php  foreach ($subMandal as $index => $value) { ?>
                  <option <?php if($value->id == $mandalarray) { echo 'selected="selected"'; } ?> value='<?php echo $value->id; ?>'><?php echo $value->mandal_name; ?></option>
                  <?php }?>
               </select>
            </div>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Ward</label><br />
               <select name="ward_id[]" class="form-control S_subSelectWard">
                  <option  selected="true" disabled="disabled" value="">Please Select Ward</option>
                  <?php foreach ($subWard as $index => $ward) { ?>
                  <option <?php if($ward->id = $wardarray) { echo 'selected="selected"'; } ?> value='<?php echo $ward->id; ?>'><?php echo $ward->ward_number; ?></option>
                  <?php }?>
               </select>
            </div>
         </div>
         <br>
         <div class="row">
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Shakti Kendram</label><br />
               <select  name="sk_id[]" multiple class="form-control S_subSelectSK">
                  <?php
                  $multiplearraysk = explode(",",$_POST['sk_id_edit']);
                  foreach ($subsk as $index => $SK) { ?>
                  <option <?php foreach( $multiplearraysk as $val ) { if($SK->id == $val) { echo 'selected="selected"'; }} ?> value='<?php echo $SK->id; ?>'><?php echo $SK->sk_name; ?></option>
                  <?php }?>
               </select>
            </div>
         </div>
         <br> 
         <?php } else if($_POST['selected'] == 'SK'){ ?>
         <div class="col-md-4 col-lg-4" id="statesubMandal">
            <label> Sub Select Mandal</label><br />
            <select name="mandal_id[]"  class="form-control S_subSelectMandal">
               <option selected="true" disabled="disabled" value="">Please Select Mandal</option>
               <?php  foreach ($subMandal as $index => $value) { ?>
               <option <?php if($value->id == $mandalarray) { echo 'selected="selected"'; } ?> value='<?php echo $value->id; ?>'><?php echo $value->mandal_name; ?></option>
               <?php }?>
            </select>
         </div>
         <div class="col-md-4 col-lg-4" id="statesubWard">
            <label> Sub Select Ward</label><br />
            <select name="ward_id[]" class="form-control S_subSelectWard">
               <option  selected="true" disabled="disabled" value="">Please Select Ward</option>
               <?php foreach ($subWard as $index => $ward) { ?>
               <option <?php if($ward->id == $wardarray) { echo 'selected="selected"'; } ?> value='<?php echo $ward->id; ?>'><?php echo $ward->ward_number; ?></option>
               <?php }?>
            </select>
         </div>
         </div>
         <br>
         <div class="row">
            <div class="col-md-4 col-lg-4" id="statesubSk">
               <label> Sub Select Shakti Kendram</label><br />
               <select  name="sk_id[]" class="form-control S_subSelectSK">
                  <option  selected="true" disabled="disabled" value="">Please Select SK</option>
                  <?php foreach ($subsk as $index => $SK) { ?>
                  <option <?php if($SK->id == $skarray) { echo 'selected="selected"'; } ?> value='<?php echo $SK->id; ?>'><?php echo $SK->sk_name; ?></option>
                  <?php }?>
               </select>
            </div>
            <div class="col-md-4 col-lg-4" id="statesubBooth">
               <label> Sub Select Booth</label><br />
               <select  name="booth_id[]" multiple  class="form-control S_subSelectBooth">
                  <?php foreach ($subbooth as $index => $booth) { ?>
                  <option <?php  echo 'selected="selected"'; ?> value='<?php echo $booth->id; ?>'><?php echo $booth->booth_number; ?></option>
                  <?php }?>
               </select>
            </div>
         </div>
         <?php } else if($_POST['selected'] == 'B'){ ?>
         <div class="col-md-4 col-lg-4" id="statesubMandal">
            <label> Sub Select Mandal</label><br />
            <select name="mandal_id[]"  class="form-control S_subSelectMandal">
               <option selected="true" disabled="disabled" value="">Please Select Mandal</option>
               <?php  foreach ($subMandal as $index => $value) { ?>
               <option <?php if($value->id == $mandalarray) { echo 'selected="selected"'; } ?> value='<?php echo $value->id; ?>'><?php echo $value->mandal_name; ?></option>
               <?php }?>
            </select>
         </div>
         <div class="col-md-4 col-lg-4" id="statesubWard">
            <label> Sub Select Ward</label><br />
            <select name="ward_id[]" class="form-control S_subSelectWard">
               <option  selected="true" disabled="disabled" value="">Please Select Ward</option>
               <?php foreach ($subWard as $index => $ward) { ?>
               <option <?php if($ward->id == $wardarray) { echo 'selected="selected"'; } ?> value='<?php echo $ward->id; ?>'><?php echo $ward->ward_number; ?></option>
               <?php }?>
            </select>
         </div>
         </div>
         <br>
         <div class="row">
            <div class="col-md-4 col-lg-4" id="statesubSk">
               <label> Sub Select Shakti Kendram</label><br />
               <select  name="sk_id[]" class="form-control S_subSelectSK">
                  <option  selected="true" disabled="disabled" value="">Please Select SK</option>
                  <?php foreach ($subsk as $index => $SK) { ?>
                  <option <?php if($SK->id == $skarray) { echo 'selected="selected"'; } ?> value='<?php echo $SK->id; ?>'><?php echo $SK->sk_name; ?></option>
                  <?php }?>
               </select>
            </div>
            <div class="col-md-4 col-lg-4" id="statesubBooth">
               <label> Sub Select Booth</label><br />
               <select  name="booth_id[]"  class="form-control S_subSelectBooth">
                  <?php foreach ($subbooth as $index => $booth) { ?>
                  <option <?php  echo 'selected="selected"'; ?> value='<?php echo $booth->id; ?>'><?php echo $booth->booth_number; ?></option>
                  <?php }?>
               </select>
            </div>
         </div>
         <?php } ?>
         </div>
         <br>
      </div>
      <script type="application/javascript">
         $('.S_subSelectDistrict').multiselect({
         includeSelectAllOption: true,
         nonSelectedText: 'Select District',
         buttonWidth:'276px',
         onChange:function(option, checked)
            {
               $('.S_subSelectMandal').html('');
               $('.S_subSelectMandal').multiselect('rebuild');
               var selected = this.$select.val();
               if(selected.length > 0);
               {
               paramMandal = {'act':'findroleMandal','disrictID':selected }; 
               ajax({
               a:"officebearersajax",
               b:paramMandal,
               c:function(){},
               d:function(data){
                        $('.S_subSelectMandal').html(data);
                        $('.S_subSelectMandal').multiselect('rebuild');
                     }
               });
               }
            }
         });
         
         $('.S_subSelectMandal').multiselect({
         includeSelectAllOption: true,
         nonSelectedText: 'Select Mandal',
         buttonWidth:'276px',
         onChange:function(option, checked)
         {
            $('.S_subSelectWard').html('');
            $('.S_subSelectWard').multiselect('rebuild');
            var selected = this.$select.val();
            if(selected.length > 0);
            {
               paramMandal = {'act':'findroleWard','mandalID':selected }; 
                  ajax({
                  a:"officebearersajax",
                  b:paramMandal,
                  c:function(){},
                  d:function(data){
                        $('.S_subSelectWard').html(data);
                        $('.S_subSelectWard').multiselect('rebuild');
                     }
                  });
            }
         }             
         }); 
         
         $('.S_subSelectWard').multiselect({
         includeSelectAllOption: true,
         nonSelectedText: 'Select Ward',
         buttonWidth:'276px', 
         onChange:function(option, checked)
         {
            $('.S_subSelectSK').html('');
            $('.S_subSelectSK').multiselect('rebuild');
            var selected = this.$select.val();
            if(selected.length > 0);
            {
               paramMandal = {'act':'findroleShaktikendram','wardID':selected }; 
               ajax({
               a:"officebearersajax",
               b:paramMandal,
               c:function(){},
               d:function(data){
                     $('.S_subSelectSK').html(data);
                     $('.S_subSelectSK').multiselect('rebuild');
                  }
               });
            }
         }             
         });
         
         $('.S_subSelectSK').multiselect({
         includeSelectAllOption: false,
         nonSelectedText: 'Select Shathi Kendram',
         buttonWidth:'276px', 
         onChange:function(option, checked)
         {
            $('.S_subSelectBooth').html('');
            $('.S_subSelectBooth').multiselect('rebuild');
            var selected = this.$select.val();
            if(selected.length > 0);
            {
               paramMandal = {'act':'findroleBooth','skid':selected }; 
               ajax({
               a:"officebearersajax",
               b:paramMandal,
               c:function(){},
               d:function(data){
                     $('.S_subSelectBooth').html(data);
                     $('.S_subSelectBooth').multiselect('rebuild');
                  }
               });
            }
         } 
         });
         $('.S_subSelectBooth').multiselect({
         includeSelectAllOption: false,
         nonSelectedText: 'Select Booth',
         buttonWidth:'276px', }); 
      </script>
   <?php  } ?>
<!-- ======= END SUB ROLE DISTRICT ======== -->

<!-- ======= SUB ROLE MANDAL ============== -->
   <?php if ($mandal_list != ''){ ?>
      <div id="District_Mandal">
         <div class="row" >
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Mandal</label><br />
               <select name="mandal_id[]"  class="form-control D_subSelectMandal">
                  <option selected="true" disabled="disabled" value="">Please Select Mandal</option>
                  <?php
                     $array = explode(",",$_POST['Mandal_id_edit']);
                     $val =  array_unique( array_diff_assoc( $array, array_unique( $array ) ) );
                     foreach(array_count_values($val) as $v => $c)
                     
                     $ward = " Select * from ".TBL_BJP_WARD. " where `mandal_id` IN (".$v.")";
                     $subWard = dB::mEXecuteSql($ward);
                     $wardarray = $_POST['ward_id_edit'];
                     
                     $sk = " Select * from ".TBL_BJP_SK. " where `ward_id` IN (".$_POST['ward_id_edit'].") ";
                     $subsk = dB::mEXecuteSql($sk);
                     $skarray = $_POST['sk_id_edit'];
                     
                     $bootharray = $_POST['booth_id_edit'];
                     $booth = " Select * from ".TBL_BJP_BOOTH. " where `id` IN (".$bootharray.")";
                     $subbooth = dB::mEXecuteSql($booth);
                     
                     foreach($mandal_list as $key=>$value) { 
                     ?>
                  <option <?php if($v == $value->id) { echo 'selected="selected"'; } ?>  value='<?php  echo $value->id; ?>'><?php  echo $value->mandal_name; ?></option>
                  <?php }  ?>
               </select>
            </div>
            <?php if($_POST['selected'] == 'M'){?>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Ward</label><br />
               <select  name="ward_id[]" multiple class="form-control D_subSelectWard">
               <?php
                  $wardarraymultiple = explode(",",$_POST['ward_id_edit']);
                  foreach ($subWard as $index => $ward) { ?>
                  <option <?php foreach( $wardarraymultiple as $val ) {  if($ward->id == $val) { echo 'selected="selected"'; } }?> value='<?php echo $ward->id; ?>'><?php echo $ward->ward_number; ?></option>
                  <?php }?>
               </select>
            </div>
            <?php } else if($_POST['selected'] == 'W'){?>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Ward</label><br />
               <select  name="ward_id[]" class="form-control D_subSelectWard">
                  <option  selected="true" disabled="disabled" value="">Please Select Ward</option>
                  <?php
                  $wardarraymultiple = explode(",",$_POST['ward_id_edit']);
                  foreach ($subWard as $index => $ward) { ?>
                  <option <?php foreach( $wardarraymultiple as $val ) {  if($ward->id == $val) { echo 'selected="selected"'; } }?> value='<?php echo $ward->id; ?>'><?php echo $ward->ward_number; ?></option>
                  <?php }?>
               </select>
            </div>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Shakti Kendram</label><br />
               <select  name="sk_id[]" multiple class="form-control D_subSelectSK">
               <?php
                  $multiplearraysk = explode(",",$_POST['sk_id_edit']);
                  foreach ($subsk as $index => $SK) { ?>
                  <option <?php foreach( $multiplearraysk as $val ) { if($SK->id == $val) { echo 'selected="selected"'; }} ?> value='<?php echo $SK->id; ?>'><?php echo $SK->sk_name; ?></option>
                  <?php }?>
               </select>
            </div>
            <?php } else if($_POST['selected'] == 'SK'){?>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Ward</label><br />
               <select  name="ward_id[]" class="form-control D_subSelectWard">
                  <option  selected="true" disabled="disabled" value="">Please Select Ward</option>
                  <?php foreach ($subWard as $index => $ward) {    ?>
                  <option <?php if($ward->id == $wardarray) { echo 'selected="selected"'; } ?> value='<?php echo $ward->id; ?>'><?php echo $ward->ward_number; ?></option>
                  <?php }?>
               </select>
            </div>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Shakti Kendram</label><br />
               <select  name="sk_id[]" class="form-control D_subSelectSK">
                  <option  selected="true" disabled="disabled" value="">Please Select SK</option>
                  <?php foreach ($subsk as $index => $SK) { ?>
                  <option <?php if($SK->id == $skarray) { echo 'selected="selected"'; } ?> value='<?php echo $SK->id; ?>'><?php echo $SK->sk_name; ?></option>
                  <?php }?>
               </select>
            </div>
         </div>
         <br>
         <div class="row">
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Booth</label><br />
               <select  name="booth_id[]" multiple class="form-control D_subSelectBooth">
                  <?php foreach ($subbooth as $index => $booth) { ?>
                  <option <?php  echo 'selected="selected"'; ?> value='<?php echo $booth->id; ?>'><?php echo $booth->booth_number; ?></option>
                  <?php }?>
               </select>
            </div>
         </div>
         <br>
         <?php } else if($_POST['selected'] == 'B'){?>
         <div class="col-md-4 col-lg-4" >
            <label> Sub Select Ward</label><br />
            <select  name="ward_id[]" class="form-control D_subSelectWard">
               <option  selected="true" disabled="disabled" value="">Please Select Ward</option>
               <?php foreach ($subWard as $index => $ward) {    ?>
               <option <?php if($ward->id == $wardarray) { echo 'selected="selected"'; } ?> value='<?php echo $ward->id; ?>'><?php echo $ward->ward_number; ?></option>
               <?php }?>
            </select>
         </div>
         <div class="col-md-4 col-lg-4" >
            <label> Sub Select Shakti Kendram</label><br />
            <select  name="sk_id[]" class="form-control D_subSelectSK">
               <option  selected="true" disabled="disabled" value="">Please Select Ward</option>
               <?php foreach ($subWard as $index => $ward) {    ?>
               <option <?php if($ward->id == $wardarray) { echo 'selected="selected"'; } ?> value='<?php echo $ward->id; ?>'><?php echo $ward->ward_number; ?></option>
               <?php }?>
            </select>
         </div>
      </div>
      <br>
      <div class="row">
         <div class="col-md-4 col-lg-4" >
            <label> Sub Select Booth</label><br />
            <select  name="booth_id[]" class="form-control D_subSelectBooth">
               <?php foreach ($subbooth as $index => $booth) { ?>
               <option <?php  echo 'selected="selected"'; ?> value='<?php echo $booth->id; ?>'><?php echo $booth->booth_number; ?></option>
               <?php }?>
            </select>
         </div>
      </div>
      <?php } ?>
      </div>
      </div>
      <br>
      <script type="application/javascript">
         $('.D_subSelectMandal').multiselect({
         includeSelectAllOption: false,
         nonSelectedText: 'Select Mandal',
         buttonWidth:'276px',
         onChange:function(option, checked)
            {
               $('.D_subSelectWard').html('');
               $('.D_subSelectWard').multiselect('rebuild');
               var selected = this.$select.val();
               if(selected.length > 0);
               {
                  paramMandal = {'act':'findroleWard','mandalID':selected }; 
                     ajax({
                     a:"officebearersajax",
                     b:paramMandal,
                     c:function(){},
                     d:function(data){
                           $('.D_subSelectWard').html(data);
                           $('.D_subSelectWard').multiselect('rebuild');
                        }
                     });
               }
            }             
         }); 
         
         $('.D_subSelectWard').multiselect({
         includeSelectAllOption: false,
         nonSelectedText: 'Select Ward',
         buttonWidth:'276px', 
         onChange:function(option, checked)
            {
               $('.D_subSelectSK').html('');
               $('.D_subSelectSK').multiselect('rebuild');
               var selected = this.$select.val();
               if(selected.length > 0);
               {
                  paramMandal = {'act':'findroleShaktikendram','wardID':selected }; 
                  ajax({
                  a:"officebearersajax",
                  b:paramMandal,
                  c:function(){},
                  d:function(data){
                        $('.D_subSelectSK').html(data);
                        $('.D_subSelectSK').multiselect('rebuild');
                     }
                  });
               }
            }             
         });
         
         $('.D_subSelectSK').multiselect({
         includeSelectAllOption: false,
         nonSelectedText: 'Select Shathi Kendram',
         buttonWidth:'276px', 
         onChange:function(option, checked)
            {
               $('.D_subSelectBooth').html('');
               $('.D_subSelectBooth').multiselect('rebuild');
               var selected = this.$select.val();
               if(selected.length > 0);
               {
                  paramMandal = {'act':'findroleBooth','skid':selected }; 
                  ajax({
                  a:"officebearersajax",
                  b:paramMandal,
                  c:function(){},
                  d:function(data){
                        $('.D_subSelectBooth').html(data);
                        $('.D_subSelectBooth').multiselect('rebuild');
                     }
                  });
               }
            } 
         });
         $('.D_subSelectBooth').multiselect({
         includeSelectAllOption: false,
         nonSelectedText: 'Select Booth',
         buttonWidth:'276px', });      
      </script>
   <?php  } ?>
<!-- ======= END SUB ROLE MANDAL ========== -->

<!-- ======= SUB ROLE WARD ================ -->
   <?php if ($ward_list != ''){ ?>
      <div id="Mandal_Ward">
         <div class="row" >
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Ward</label><br />
               <select  name="ward_id[]" class="form-control M_subSelectWard">
                  <option selected="true" disabled="disabled" value="">Please Select Ward</option>
                  <?php 
                        $array = explode(",",$_POST['ward_id_edit']);
                        $val =  array_unique( array_diff_assoc( $array, array_unique( $array ) ) );
                        foreach(array_count_values($val) as $v => $c)
                        
                        $sk = " Select * from ".TBL_BJP_SK. " where `ward_id` IN (".$v.") ";
                        $subsk = dB::mEXecuteSql($sk);
                        $skarray = $_POST['sk_id_edit'];
                        
                        $bootharray = $_POST['booth_id_edit'];
                        $booth = " Select * from ".TBL_BJP_BOOTH. " where `id` IN (".$bootharray.")";
                        $subbooth = dB::mEXecuteSql($booth);

                     foreach($ward_list as $key=>$value) {
                        ?>
                  <option <?php if($v == $value->id) { echo 'selected="selected"'; } ?> value='<?php  echo $value->id; ?>'><?php  echo $value->ward_number; ?></option>
                  <?php 
                     } 
                     ?>
               </select>
            </div>
            <?php if($_POST['selected'] == 'W'){?>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Shakti Kendram</label><br />
               <select  name="sk_id[]" multiple class="form-control M_subSelectSK">
               <?php
                  $multiplearraysk = explode(",",$_POST['sk_id_edit']);
                  foreach ($subsk as $index => $SK) { ?>
                  <option <?php foreach( $multiplearraysk as $val ) { if($SK->id == $val) { echo 'selected="selected"'; }} ?> value='<?php echo $SK->id; ?>'><?php echo $SK->sk_name; ?></option>
                  <?php }?>
               </select>
            </div>
         </div>
         <?php } else if($_POST['selected'] == 'SK'){ ?>
         <div class="col-md-4 col-lg-4" >
            <label> Sub Select Shakti Kendram</label><br />
            <select  name="sk_id[]" class="form-control M_subSelectSK">
            <option  selected="true" disabled="disabled" value="">Please Select SK</option>
            <?php foreach ($subsk as $index => $SK) { ?>
                  <option <?php if($SK->id == $skarray) { echo 'selected="selected"'; } ?> value='<?php echo $SK->id; ?>'><?php echo $SK->sk_name; ?></option>
                  <?php }?>
            </select>
         </div>
         <div class="col-md-4 col-lg-4" >
            <label> Sub Select Booth</label><br />
            <select  name="booth_id[]" multiple class="form-control M_subSelectBooth">
               <?php foreach ($subbooth as $index => $booth) { ?>
                  <option <?php  echo 'selected="selected"'; ?> value='<?php echo $booth->id; ?>'><?php echo $booth->booth_number; ?></option>
                  <?php }?>
            </select>
         </div>
      </div>
      </div>
      <?php } else if($_POST['selected'] == 'B'){ ?>
      <div class="col-md-4 col-lg-4" >
         <label> Sub Select Shakti Kendram</label><br />
         <select  name="sk_id[]" class="form-control M_subSelectSK">
            <option  selected="true" disabled="disabled" value="">Please Select SK</option>
            <?php foreach ($subsk as $index => $SK) { ?>
               <option <?php if($SK->id == $skarray) { echo 'selected="selected"'; } ?> value='<?php echo $SK->id; ?>'><?php echo $SK->sk_name; ?></option>
            <?php }?>
         </select>
      </div>
      <div class="col-md-4 col-lg-4" >
         <label> Sub Select Booth</label><br />
         <select  name="booth_id[]"  class="form-control M_subSelectBooth">
         <option  selected="true" disabled="disabled" value="">Please Select Ward</option>
         <?php foreach ($subbooth as $index => $booth) { ?>
                  <option <?php  echo 'selected="selected"'; ?> value='<?php echo $booth->id; ?>'><?php echo $booth->booth_number; ?></option>
                  <?php }?>
         </select>
      </div>
      </div>                         
      </div>
      <?php } ?>
      <br>
      <script type="application/javascript">
         $('.M_subSelectWard').multiselect({
         includeSelectAllOption: true,
         nonSelectedText: 'Select Ward',
         buttonWidth:'276px', 
         onChange:function(option, checked)
            {
               $('.M_subSelectSK').html('');
               $('.M_subSelectSK').multiselect('rebuild');
               var selected = this.$select.val();
               if(selected.length > 0);
               {
                  paramMandal = {'act':'findroleShaktikendram','wardID':selected }; 
                  ajax({
                  a:"officebearersajax",
                  b:paramMandal,
                  c:function(){},
                  d:function(data){
                        $('.M_subSelectSK').html(data);
                        $('.M_subSelectSK').multiselect('rebuild');
                     }
                  });
               }
            }             
         });
         
         $('.M_subSelectSK').multiselect({
         includeSelectAllOption: true,
         nonSelectedText: 'Select Shathi Kendram',
         buttonWidth:'276px', 
         onChange:function(option, checked)
            {
               $('.M_subSelectBooth').html('');
               $('.M_subSelectBooth').multiselect('rebuild');
               var selected = this.$select.val();
               if(selected.length > 0);
               {
                  paramMandal = {'act':'findroleBooth','skid':selected }; 
                  ajax({
                  a:"officebearersajax",
                  b:paramMandal,
                  c:function(){},
                  d:function(data){
                        $('.M_subSelectBooth').html(data);
                        $('.M_subSelectBooth').multiselect('rebuild');
                     }
                  });
               }
            } 
         });
         $('.M_subSelectBooth').multiselect({
         includeSelectAllOption: true,
         nonSelectedText: 'Select Booth',
         buttonWidth:'276px', });      
         
      </script>
   <?php  } ?>
<!-- ======= END SUB ROLE WARD ============ -->

<!-- ======= SUB ROLE SK ================== -->
   <?php if ($sk_list != ''){ ?>
      <div id="Ward_SK">
         <div class="row" >
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Shakti Kendram</label><br />
               <select  name="sk_id[]" class="form-control W_subSelectSK">
                  <option  disabled="disabled" value="">Please Select Shakti Kendram</option>
                  <?php    
                           $array = explode(",",$_POST['sk_id_edit']);
                           $val =  array_unique( array_diff_assoc( $array, array_unique( $array ) ) );
                           foreach(array_count_values($val) as $v => $c)
                                                   
                           $bootharray = $_POST['booth_id_edit'];
                           $booth = " Select * from ".TBL_BJP_BOOTH. " where `id` IN (".$v.")";
                           $subbooth = dB::mEXecuteSql($booth);

                  foreach($sk_list as $key=>$value) {
                     ?>
                  <option <?php if($v == $value->id) { echo 'selected="selected"'; } ?> value='<?php  echo $value->id; ?>'><?php  echo $value->sk_name; ?></option>
                  <?php 
                     } ?>
               </select>
            </div>
            <?php  if($_POST['selected'] == 'SK'){ ?>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Booth</label><br />
               <select  name="booth_id[]" multiple class="form-control W_subSelectBooth">
               <?php foreach ($subbooth as $index => $booth) { ?>
               <option <?php  echo 'selected="selected"'; ?> value='<?php echo $booth->id; ?>'><?php echo $booth->booth_number; ?></option>
               <?php }?>
               </select>
            </div>
            <?php } else if($_POST['selected'] == 'B'){ ?>
            <div class="col-md-4 col-lg-4" >
               <label> Sub Select Booth</label><br />
               <select  name="booth_id[]" class="form-control W_subSelectBooth">
               <?php foreach ($subbooth as $index => $booth) { ?>
               <option <?php  echo 'selected="selected"'; ?> value='<?php echo $booth->id; ?>'><?php echo $booth->booth_number; ?></option>
               <?php }?>
               </select>
            </div>
            <?php } ?>
         </div>
      </div>
      <br>
      <script type="application/javascript">
         $('.W_subSelectSK').multiselect({
         includeSelectAllOption: true,
         nonSelectedText: 'Select Shathi Kendram',
         buttonWidth:'276px', 
         onChange:function(option, checked)
            {
               $('.W_subSelectBooth').html('');
               $('.W_subSelectBooth').multiselect('rebuild');
               var selected = this.$select.val();
               if(selected.length > 0);
               {
                  paramMandal = {'act':'findroleBooth','skid':selected }; 
                  ajax({
                  a:"officebearersajax",
                  b:paramMandal,
                  c:function(){},
                  d:function(data){
                        $('.W_subSelectBooth').html(data);
                        $('.W_subSelectBooth').multiselect('rebuild');
                     }
                  });
               }
            } 
         });
         $('.W_subSelectBooth').multiselect({
         includeSelectAllOption: false,
         nonSelectedText: 'Select Booth',
         buttonWidth:'276px', });      
      </script>
   <?php  } ?>
<!-- ======= END SUB ROLE SK ================== -->
