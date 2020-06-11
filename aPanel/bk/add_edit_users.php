<?php
 $userId = $_POST['id'];
$btnName = $title = 'Add New';
$joined_date ='';
if($userId>0) { 
	$param = array('tableName'=>TBL_USERS,'fields'=>array('*'),'condition'=>array('id'=>$userId.'-INT'));
	$rsUsers = Table::getData($param);
	foreach($rsUsers as $K=>$V)  $$K=$V;
	$btnName = $title = 'Edit ';
	$joined_date = date('m/d/Y',strtotime($joined_date));
}
 
?>
	
 <div class="card-box">
                                    <h4 class="m-t-0 header-title"><?php echo $title; ?> Users </h4>
                                    <p class="text-muted font-14 m-b-20"></p>

                                   <form class="form-horizontal" role="form" id="users_form" enctype="multipart/form-data" autocomplete="off">
                                        <div class="form-group row">
                                     
                                            <div class="col-md-4"><strong>Username : </strong> <br/>
                              <?php if($id>0) {   echo $username; ?> 
							   <input type="hidden" name="username" value="<?php echo $username; ?>">
							  <?php  } else { ?>     <input type="text"   class="form-control" name="username" id="username" value="<?php echo $username; ?>" autocomplete="off" onblur="checkUsername(this.value)">
                                                <input type="hidden" id="username_check" value="">
							  <span class="username_check_span" style="color:#ff0000"></span> <?php } ?>
                                            </div>
										<?php if($userId==0) { ?>
											<div class="col-md-4"> Password : 
                                              <input type="password" class="form-control" name="password" id="password" value="<?php echo $password; ?>">
											  </div>
											
											<div class="col-md-4">Confirm Password :
                                              <input type="password" class="form-control" name="password" id="cpassword">
											   <span class="password_error" style="color:#ff0000;"></span>
                                            </div>
										<?php } else { ?> <input type="hidden" name="password"  value="<?php echo $password; ?>"><?php } ?>
                                                              
										</div>
										
										
										 <div class="form-group row">
                                            
                                            <div class="col-md-12"><strong> User Type : </strong> <br/>
                                              <input type="radio" name="user_type" value="SA" <?php if($user_type=='SA') { echo 'checked'; } ?>> Super Admin &nbsp;
                                              <input type="radio" name="user_type" value="A" <?php if($user_type=='A') { echo 'checked'; } ?>> Admin &nbsp;
                                              <input type="radio" name="user_type" value="E" <?php if($user_type=='E') { echo 'checked'; } ?>> Employee &nbsp;
											  <input type="radio" name="user_type" value="FL" <?php if($user_type=='FL') { echo 'checked'; } ?>> Freelancer &nbsp;	
											  <br/>
											  <span class="error_msg" style="color:#ff0000;"></span>
                                            </div>
											<?php 
       /* $employeeTypeArr = array("BPS"=>"Business Plan Specialist","CS"=>"Certification Specialist","LS"=>"License Specialist","WS"=>"Website Specialist",
                          "DMS"=>"Digital Marketing Specialist",
						  "All"=>"All",
						  "A"=>"Administration",
						  "ACC"=>"Accounting",'PM'=>'Project Manager');
						  $employee_type = explode(',',$employee_type); 
						  ?>  
											 
					 <?php foreach($employeeTypeArr as $key=>$val) {   ?>   <script>  					 
					<?php  if (in_array($key, $employee_type))  { ?> $("input[type=checkbox][value='<?php echo $key;?>']").prop("checked",true); <?php  } 
				 ?>  </script>
					 <?php  }  */ ?> 
					 
					  <div class="form-group row">
								 
								<div class="col-md-12"><br/><strong> Employee Type : </strong> <br/>
								  <?php 
											  
		$param = array('tableName'=>TBL_EMPLOYEE_CATEGORY,'fields'=>array('*'),'orderby'=>'id','sortby'=>'desc','condition'=>array('status'=>'A-CHAR'));
		$rsEmployee = Table::getData($param);	
		 $employee_type = explode(',',$employee_type); 
										$i=0;
                                        if(count($rsEmployee)>0) {
										foreach($rsEmployee as $key=>$val) {  $checked=''; 
										 if (in_array($val->id, $employee_type))  {  $checked ='checked';   } ?>
					<input type="checkbox" class="checkbox" name="employee_type[]" value="<?php echo $val->id;?>" <?php echo $checked; ?>> <?php echo $val->category_name;
					$i++;
                if($i==3){ echo '<br/>';  }
					?>  				
                                         <?php }}  if(count($rsEmployee)>0) { ?> 
										 <input type="checkbox"   id="select_all" value="All"> All &nbsp; <br/>
										 <?php } ?>
									 </div>								
							    </div>	 
								
								

											 
											<?php /*<div class="col-md-12"><br/><strong> Employee Type : </strong> <br/>
								<input type="checkbox" name="employee_type[]" value="A" <?php if($employee_type=='A') { echo 'checked'; } ?>> Administration &nbsp;
								<input type="checkbox" name="employee_type[]" value="ACC" <?php if($employee_type=='ACC') { echo 'checked'; } ?>> Accounting &nbsp;
								<input type="checkbox" name="employee_type[]" value="BPS" <?php if($employee_type=='BPS') { echo 'checked'; } ?>> Business Plan Specialist &nbsp; <br/>
								<input type="checkbox" name="employee_type[]" value="PM" <?php if($employee_type=='PM') { echo 'checked'; } ?>> Project Manager &nbsp;
								<input type="checkbox" name="employee_type[]" value="CS" <?php if($employee_type=='CS') { echo 'checked'; } ?>> Certification Specialist &nbsp;
								<input type="checkbox" name="employee_type[]" value="LS" <?php if($employee_type=='LS') { echo 'checked'; } ?>> License Specialist &nbsp; <br/>
								<input type="checkbox" name="employee_type[]" value="WS" <?php if($employee_type=='WS') { echo 'checked'; } ?>> Website Specialist &nbsp;
								<input type="checkbox" name="employee_type[]" value="DMS" <?php if($employee_type=='DMS') { echo 'checked'; } ?>> Digital Marketing Specialist &nbsp;
								<input type="checkbox" name="employee_type[]" value="All" <?php if($employee_type=='All') { echo 'checked'; } ?>> All &nbsp; <br/>
											   <span class="emp_error_msg" style="color:#ff0000;"></span>
                                            </div> */ ?>
											
                                        </div>
										
										 
										
										<div class="form-group row">                                            
                                            <div class="col-md-5"><strong> First Name :</strong>
                                              <input type="text" class="form-control" name="contact_fname" id="contact_fname" value="<?php echo $contact_fname; ?>">							   
                                            </div>
											<div class="col-md-5"><strong> Last Name : </strong>
                                              <input type="text"   class="form-control" name="contact_lname" id="contact_lname" value="<?php echo $contact_lname; ?>">
											</div>
                                        </div>
										
										<div class="form-group row">                                             
                                            <div class="col-md-5"> <strong> Email Address  : </strong><br/>
											 <?php if($id>0) {   echo '<a href="mailto:'.$contact_email.'">'.$contact_email.'</a>'; ?> 
 <input type="hidden" name="contact_email"  value="<?php echo $contact_email; ?>">
											 <?php } else { ?>
                                              <input type="email" class="form-control" name="contact_email" id="contact_email" value="<?php echo $contact_email; ?>" onblur="checkEmail(this.value)">
											   <input type="hidden" id="email_check" value="">
											 <span class="email_check_span" style="color:#ff0000"></span> <?php } ?>
											  </div> 
										<div class="col-md-5"> <strong> Contact Phone  :  </strong>
										   <input type="text" class="form-control" name="contact_phone" id="contact_phone" value="<?php echo $contact_phone; ?>">
										   <span class="error_contact_phone" style="color:#ff0000;"></span>
										</div> 
                                        </div>
										
										<div class="form-group row">                                            
                                            <div class="col-md-10"><strong> Contact Address : </strong> <br/>                                            
											  <textarea class="form-control" name="contact_address" id="contact_address"><?php echo $contact_address; ?></textarea>						   
                                            </div>
											 
                                        </div>
										
										
										<div class="form-group row">                                             
                                            <div class="col-md-5"><strong>  Country  : </strong>
                      <!-- <input type="text" class="form-control" name="contact_country" id="contact_country" value="<?php echo $contact_country; ?>">-->
											  
		   <select name="contact_country" id="contact_country" class="form-control" onchange="changeCountry(this.value)">
 <option value="" selected="selected">Select Country</option>   
<option value="Afghanistan">Afghanistan</option> 
<option value="Albania">Albania</option> 
<option value="Algeria">Algeria</option> 
<option value="American Samoa">American Samoa</option> 
<option value="Andorra">Andorra</option> 
<option value="Angola">Angola</option> 
<option value="Anguilla">Anguilla</option> 
<option value="Antarctica">Antarctica</option> 
<option value="Antigua and Barbuda">Antigua and Barbuda</option> 
<option value="Argentina">Argentina</option> 
<option value="Armenia">Armenia</option> 
<option value="Aruba">Aruba</option> 
<option value="Australia">Australia</option> 
<option value="Austria">Austria</option> 
<option value="Azerbaijan">Azerbaijan</option> 
<option value="Bahamas">Bahamas</option> 
<option value="Bahrain">Bahrain</option> 
<option value="Bangladesh">Bangladesh</option> 
<option value="Barbados">Barbados</option> 
<option value="Belarus">Belarus</option> 
<option value="Belgium">Belgium</option> 
<option value="Belize">Belize</option> 
<option value="Benin">Benin</option> 
<option value="Bermuda">Bermuda</option> 
<option value="Bhutan">Bhutan</option> 
<option value="Bolivia">Bolivia</option> 
<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
<option value="Botswana">Botswana</option> 
<option value="Bouvet Island">Bouvet Island</option> 
<option value="Brazil">Brazil</option> 
<option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
<option value="Brunei Darussalam">Brunei Darussalam</option> 
<option value="Bulgaria">Bulgaria</option> 
<option value="Burkina Faso">Burkina Faso</option> 
<option value="Burundi">Burundi</option> 
<option value="Cambodia">Cambodia</option> 
<option value="Cameroon">Cameroon</option> 
<option value="Canada">Canada</option> 
<option value="Cape Verde">Cape Verde</option> 
<option value="Cayman Islands">Cayman Islands</option> 
<option value="Central African Republic">Central African Republic</option> 
<option value="Chad">Chad</option> 
<option value="Chile">Chile</option> 
<option value="China">China</option> 
<option value="Christmas Island">Christmas Island</option> 
<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
<option value="Colombia">Colombia</option> 
<option value="Comoros">Comoros</option> 
<option value="Congo">Congo</option> 
<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
<option value="Cook Islands">Cook Islands</option> 
<option value="Costa Rica">Costa Rica</option> 
<option value="Cote D'ivoire">Cote D'ivoire</option> 
<option value="Croatia">Croatia</option> 
<option value="Cuba">Cuba</option> 
<option value="Cyprus">Cyprus</option> 
<option value="Czech Republic">Czech Republic</option> 
<option value="Denmark">Denmark</option> 
<option value="Djibouti">Djibouti</option> 
<option value="Dominica">Dominica</option> 
<option value="Dominican Republic">Dominican Republic</option> 
<option value="Ecuador">Ecuador</option> 
<option value="Egypt">Egypt</option> 
<option value="El Salvador">El Salvador</option> 
<option value="Equatorial Guinea">Equatorial Guinea</option> 
<option value="Eritrea">Eritrea</option> 
<option value="Estonia">Estonia</option> 
<option value="Ethiopia">Ethiopia</option> 
<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
<option value="Faroe Islands">Faroe Islands</option> 
<option value="Fiji">Fiji</option> 
<option value="Finland">Finland</option> 
<option value="France">France</option> 
<option value="French Guiana">French Guiana</option> 
<option value="French Polynesia">French Polynesia</option> 
<option value="French Southern Territories">French Southern Territories</option> 
<option value="Gabon">Gabon</option> 
<option value="Gambia">Gambia</option> 
<option value="Georgia">Georgia</option> 
<option value="Germany">Germany</option> 
<option value="Ghana">Ghana</option> 
<option value="Gibraltar">Gibraltar</option> 
<option value="Greece">Greece</option> 
<option value="Greenland">Greenland</option> 
<option value="Grenada">Grenada</option> 
<option value="Guadeloupe">Guadeloupe</option> 
<option value="Guam">Guam</option> 
<option value="Guatemala">Guatemala</option> 
<option value="Guinea">Guinea</option> 
<option value="Guinea-bissau">Guinea-bissau</option> 
<option value="Guyana">Guyana</option> 
<option value="Haiti">Haiti</option> 
<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
<option value="Honduras">Honduras</option> 
<option value="Hong Kong">Hong Kong</option> 
<option value="Hungary">Hungary</option> 
<option value="Iceland">Iceland</option> 
<option value="India">India</option> 
<option value="Indonesia">Indonesia</option> 
<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> 
<option value="Iraq">Iraq</option> 
<option value="Ireland">Ireland</option> 
<option value="Israel">Israel</option> 
<option value="Italy">Italy</option> 
<option value="Jamaica">Jamaica</option> 
<option value="Japan">Japan</option> 
<option value="Jordan">Jordan</option> 
<option value="Kazakhstan">Kazakhstan</option> 
<option value="Kenya">Kenya</option> 
<option value="Kiribati">Kiribati</option> 
<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> 
<option value="Korea, Republic of">Korea, Republic of</option> 
<option value="Kuwait">Kuwait</option> 
<option value="Kyrgyzstan">Kyrgyzstan</option> 
<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> 
<option value="Latvia">Latvia</option> 
<option value="Lebanon">Lebanon</option> 
<option value="Lesotho">Lesotho</option> 
<option value="Liberia">Liberia</option> 
<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
<option value="Liechtenstein">Liechtenstein</option> 
<option value="Lithuania">Lithuania</option> 
<option value="Luxembourg">Luxembourg</option> 
<option value="Macao">Macao</option> 
<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> 
<option value="Madagascar">Madagascar</option> 
<option value="Malawi">Malawi</option> 
<option value="Malaysia">Malaysia</option> 
<option value="Maldives">Maldives</option> 
<option value="Mali">Mali</option> 
<option value="Malta">Malta</option> 
<option value="Marshall Islands">Marshall Islands</option> 
<option value="Martinique">Martinique</option> 
<option value="Mauritania">Mauritania</option> 
<option value="Mauritius">Mauritius</option> 
<option value="Mayotte">Mayotte</option> 
<option value="Mexico">Mexico</option> 
<option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
<option value="Moldova, Republic of">Moldova, Republic of</option> 
<option value="Monaco">Monaco</option> 
<option value="Mongolia">Mongolia</option> 
<option value="Montserrat">Montserrat</option> 
<option value="Morocco">Morocco</option> 
<option value="Mozambique">Mozambique</option> 
<option value="Myanmar">Myanmar</option> 
<option value="Namibia">Namibia</option> 
<option value="Nauru">Nauru</option> 
<option value="Nepal">Nepal</option> 
<option value="Netherlands">Netherlands</option> 
<option value="Netherlands Antilles">Netherlands Antilles</option> 
<option value="New Caledonia">New Caledonia</option> 
<option value="New Zealand">New Zealand</option> 
<option value="Nicaragua">Nicaragua</option> 
<option value="Niger">Niger</option> 
<option value="Nigeria">Nigeria</option> 
<option value="Niue">Niue</option> 
<option value="Norfolk Island">Norfolk Island</option> 
<option value="Northern Mariana Islands">Northern Mariana Islands</option> 
<option value="Norway">Norway</option> 
<option value="Oman">Oman</option> 
<option value="Pakistan">Pakistan</option> 
<option value="Palau">Palau</option> 
<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
<option value="Panama">Panama</option> 
<option value="Papua New Guinea">Papua New Guinea</option> 
<option value="Paraguay">Paraguay</option> 
<option value="Peru">Peru</option> 
<option value="Philippines">Philippines</option> 
<option value="Pitcairn">Pitcairn</option> 
<option value="Poland">Poland</option> 
<option value="Portugal">Portugal</option> 
<option value="Puerto Rico">Puerto Rico</option> 
<option value="Qatar">Qatar</option> 
<option value="Reunion">Reunion</option> 
<option value="Romania">Romania</option> 
<option value="Russian Federation">Russian Federation</option> 
<option value="Rwanda">Rwanda</option> 
<option value="Saint Helena">Saint Helena</option> 
<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
<option value="Saint Lucia">Saint Lucia</option> 
<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
<option value="Samoa">Samoa</option> 
<option value="San Marino">San Marino</option> 
<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
<option value="Saudi Arabia">Saudi Arabia</option> 
<option value="Senegal">Senegal</option> 
<option value="Serbia and Montenegro">Serbia and Montenegro</option> 
<option value="Seychelles">Seychelles</option> 
<option value="Sierra Leone">Sierra Leone</option> 
<option value="Singapore">Singapore</option> 
<option value="Slovakia">Slovakia</option> 
<option value="Slovenia">Slovenia</option> 
<option value="Solomon Islands">Solomon Islands</option> 
<option value="Somalia">Somalia</option> 
<option value="South Africa">South Africa</option> 
<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> 
<option value="Spain">Spain</option> 
<option value="Sri Lanka">Sri Lanka</option> 
<option value="Sudan">Sudan</option> 
<option value="Suriname">Suriname</option> 
<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
<option value="Swaziland">Swaziland</option> 
<option value="Sweden">Sweden</option> 
<option value="Switzerland">Switzerland</option> 
<option value="Syrian Arab Republic">Syrian Arab Republic</option> 
<option value="Taiwan, Province of China">Taiwan, Province of China</option> 
<option value="Tajikistan">Tajikistan</option> 
<option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
<option value="Thailand">Thailand</option> 
<option value="Timor-leste">Timor-leste</option> 
<option value="Togo">Togo</option> 
<option value="Tokelau">Tokelau</option> 
<option value="Tonga">Tonga</option> 
<option value="Trinidad and Tobago">Trinidad and Tobago</option> 
<option value="Tunisia">Tunisia</option> 
<option value="Turkey">Turkey</option> 
<option value="Turkmenistan">Turkmenistan</option> 
<option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
<option value="Tuvalu">Tuvalu</option> 
<option value="Uganda">Uganda</option> 
<option value="Ukraine">Ukraine</option> 
<option value="United Arab Emirates">United Arab Emirates</option> 
<option value="United Kingdom">United Kingdom</option> 
<option value="United States">United States</option> 
<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
<option value="Uruguay">Uruguay</option> 
<option value="Uzbekistan">Uzbekistan</option> 
<option value="Vanuatu">Vanuatu</option> 
<option value="Venezuela">Venezuela</option> 
<option value="Viet Nam">Viet Nam</option> 
<option value="Virgin Islands, British">Virgin Islands, British</option> 
<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
<option value="Wallis and Futuna">Wallis and Futuna</option> 
<option value="Western Sahara">Western Sahara</option> 
<option value="Yemen">Yemen</option> 
<option value="Zambia">Zambia</option> 
<option value="Zimbabwe">Zimbabwe</option>
</select>
											  
											  </div> 	

												<div class="col-md-5"><strong>State : </strong>
            <input type="text"   class="form-control" name="contact_state" id="contact_state" value="<?php echo $contact_state; ?>"> 
	
 <select class="form-control" name="us_state" id="us_state" style="display:none;">
    <option value="">State</option>
    <option value="Alabama">Alabama</option>
    <option value="Alaska">Alaska</option>
    <option value="Arizona">Arizona</option>
    <option value="Arkansas">Arkansas</option>
    <option value="California">California</option>
    <option value="Colorado">Colorado</option>
    <option value="Connecticut">Connecticut</option>
    <option value="Delaware">Delaware</option>
    <option value="District of Columbia">District of Columbia</option>
    <option value="Florida">Florida</option>
    <option value="Georgia">Georgia</option>
    <option value="Guam">Guam</option>
    <option value="Hawaii">Hawaii</option>
    <option value="Idaho">Idaho</option>
    <option value="Illinois">Illinois</option>
    <option value="Indiana">Indiana</option>
    <option value="Iowa">Iowa</option>
    <option value="Kansas">Kansas</option>
    <option value="Kentucky">Kentucky</option>
    <option value="Louisiana">Louisiana</option>
    <option value="Maine">Maine</option>
    <option value="Maryland">Maryland</option>
    <option value="Massachusetts">Massachusetts</option>
    <option value="Michigan">Michigan</option>
    <option value="Minnesota">Minnesota</option>
    <option value="Mississippi">Mississippi</option>
    <option value="Missouri">Missouri</option>
    <option value="Montana">Montana</option>
    <option value="Nebraska">Nebraska</option>
    <option value="Nevada">Nevada</option>
    <option value="New Hampshire">New Hampshire</option>
    <option value="New Jersey">New Jersey</option>
    <option value="New Mexico">New Mexico</option>
    <option value="New York">New York</option>
    <option value="North Carolina">North Carolina</option>
    <option value="North Dakota">North Dakota</option>
    <option value="Northern Marianas Islands">Northern Marianas Islands</option>
    <option value="Ohio">Ohio</option>
    <option value="Oklahoma">Oklahoma</option>
    <option value="Oregon">Oregon</option>
    <option value="Pennsylvania">Pennsylvania</option>
    <option value="Puerto Rico">Puerto Rico</option>
    <option value="Rhode Island">Rhode Island</option>
    <option value="South Carolina">South Carolina</option>
    <option value="South Dakota">South Dakota</option>
    <option value="Tennessee">Tennessee</option>
    <option value="Texas">Texas</option>
    <option value="Utah">Utah</option>
    <option value="Vermont">Vermont</option>
    <option value="Virginia">Virginia</option>
    <option value="Virgin Islands">Virgin Islands</option>
    <option value="Washington">Washington</option>
    <option value="West Virginia">West Virginia</option>
    <option value="Wisconsin">Wisconsin</option>
    <option value="Wyoming">Wyoming</option>
</select>

											</div>
                                       
                                        </div>
										
										
										<div class="form-group row">                                           
                                           
										
 <div class="col-md-5"><strong> City : </strong>
                                              <input type="text" class="form-control" name="contact_city" id="contact_city" value="<?php echo $contact_city; ?>">							   
                                            </div>
									   </div>
										
										
										
										 
										<div class="form-group row">
                                             <div class="col-md-5"> <strong> Skype ID  : </strong>
                                              <input type="text" class="form-control" name="skype_id" id="skype_id" value="<?php echo $skype_id; ?>">
											  </div> 	

											<div class="col-md-5"><strong> Joined Date  : </strong>
											<input type="text" class="form-control datepicker" name="joined_date" id="joined_date" value="<?php echo $joined_date; ?>">
											</div> 											  
                                        </div>
									 
										
										<div class="form-group row">
                                             <div class="col-md-8"> <strong> Business Email  : </strong> 
                                            <div class="" style="display:inline-flex;">
											<input type="text" class="form-control" name="business_email" id="business_email" value="<?php echo $business_email; ?>" style="width:50%">@bizplaneasy.com </div>
											  </div> 	

											<div class="col-md-4"></div> 		
											  
                                        </div>
												

									<div class="form-group row">
										<div class="col-md-5"><strong>Phone : </strong>
										  <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>">	
										  <input type="hidden" id="email_check">
                                           <span class="error_phone" style="color:#ff0000;"></span>										  
										</div>
										<div class="col-md-5"><strong>Timezone : </strong>
										   
										  <select class="form-control" name="timezone" id="timezone" >
										  <option value="">Select</option>
 <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
<option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
<option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
<option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
<option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
<option value="America/Anchorage">(GMT-09:00) Alaska</option>
<option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
<option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
<option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
<option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
<option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
<option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
<option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
<option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
<option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
<option value="America/Havana">(GMT-05:00) Cuba</option>
<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
<option value="America/Caracas">(GMT-04:30) Caracas</option>
<option value="America/Santiago">(GMT-04:00) Santiago</option>
<option value="America/La_Paz">(GMT-04:00) La Paz</option>
<option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
<option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
<option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
<option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
<option value="America/Araguaina">(GMT-03:00) UTC-3</option>
<option value="America/Montevideo">(GMT-03:00) Montevideo</option>
<option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
<option value="America/Godthab">(GMT-03:00) Greenland</option>
<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
<option value="Atlantic/Azores">(GMT-01:00) Azores</option>
<option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
<option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
<option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
<option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
<option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
<option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
<option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
<option value="Asia/Beirut">(GMT+02:00) Beirut</option>
<option value="Africa/Cairo">(GMT+02:00) Cairo</option>
<option value="Asia/Gaza">(GMT+02:00) Gaza</option>
<option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
<option value="Europe/Minsk">(GMT+02:00) Minsk</option>
<option value="Asia/Damascus">(GMT+02:00) Syria</option>
<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
<option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
<option value="Australia/Perth">(GMT+08:00) Perth</option>
<option value="Australia/Eucla">(GMT+08:45) Eucla</option>
<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
<option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
<option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
<option value="Asia/Magadan">(GMT+11:00) Magadan</option>
<option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
<option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
<option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
<option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
<option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
<option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
</select>
										  
										</div>
									</div>
										 
                                        
                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-md-9">
											<input type="hidden" name="id" value="<?php echo $id;?>"/>
											<input type="hidden" name="act" value="addEditUsers"/>
                                                <button type="submit"  class="btn btn-info waves-effect waves-light">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
 <script>
      
	$('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
 
	  
	 
	  <?php if($id>0) { ?> changeCountry('<?php echo $contact_country; ?>'); <?php } ?>
							
  
	$('select[name^="contact_country"] option[value="<?php echo $contact_country; ?>"]').attr("selected","selected");
	$('select[name^="us_state"] option[value="<?php echo $contact_state; ?>"]').attr("selected","selected");
	$('select[name^="timezone"] option[value="<?php echo $timezone; ?>"]').attr("selected","selected");


	function changeCountry(countryName) {
		$('#us_state').hide();
		$('#contact_state').hide();
   if(countryName=='United States') {   $('#us_state').show();   } else { $('#contact_state').show();  }
 
	}		
								
								
								
								
  $(document).ready(function (e){  
 $("#phone").inputmask({"mask": "(999) 999-9999"});
 $("#contact_phone").inputmask({"mask": "(999) 999-9999"});
   
  $( function() {
    $( ".datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
    });
  } );
  
$("form#users_form").on('submit',(function(e){
e.preventDefault(); 
	  err=0;
	<?php if($id==0) { ?>  if($('#username').val()=='' ){ err=1; $('#username').css("border","1px solid #ff0000 "); } else{  $('#username').css("border","");  }
	
	  var usernameVal = $('#username').val(); 
	    checkUsername(usernameVal);  
	  
	 var username_check = $('#username_check').val();  
	 
	 
    if(username_check==0) { err=0; $('#username_check').val(''); $('.username_check_span').html(''); $('#username').css("border",""); } 
	if(username_check==1) {  err=1; $('#username').css("border","1px solid #ff0000 "); $('.username_check_span').html('Username Already Exits'); }
	
	  <?php } ?>
	 
	 
	 
	 <?php if($userId==0) { ?> 
	 if($('#password').val()=='' ){ err=1; $('#password').css("border","1px solid #ff0000 "); } else{  $('#password').css("border","");}
	 if($('#cpassword').val()=='' ){ err=1; $('#cpassword').css("border","1px solid #ff0000 "); } else{  $('#cpassword').css("border","");}
	 password = $('#password').val();
	 cpassword = $('#cpassword').val()
	 
	 if(password!=cpassword) {  err=1; $('.password_error').html('<small>Enter Confirm Password Same as Password </small>');
$('#password').css("border","1px solid #ff0000 "); $('#cpassword').css("border","1px solid #ff0000 ");
	 } else { $('.password_error').html(''); $('#password').css("border",""); $('#cpassword').css("border","");  }
	 
	 <?php } ?>
	 
	 var user_type =  $("input[name='user_type']:checked").val();
	  
	 if(user_type==undefined){ err=1; $('.error_msg').html("Select User Type");  } else{  $('.error_msg').html('');  }
	 
	 /*
	 var employee_type =  $("input[name='employee_type']:checked").val();
	 
	 if(employee_type==undefined){ err=1; $('.emp_error_msg').html("Select Employee Type");  } else{  $('.emp_error_msg').html('');  } */
	

	 
	  if($('#contact_fname').val()=='' ){ err=1; $('#contact_fname').css("border","1px solid #ff0000 "); } else{  $('#contact_fname').css("border","");}
	  if($('#contact_lname').val()=='' ){ err=1; $('#contact_lname').css("border","1px solid #ff0000 "); } else{  $('#contact_lname').css("border","");}
	  var contact_email =  $('#contact_email').val(); 
	   <?php if($id==0) { ?> checkEmail(contact_email); 	  
	  if(IsEmail(contact_email)==false){ err=1; $('#contact_email').css("border","1px solid #ff0000 "); } else { $('#contact_email').css("border","");}
	   
	
	  
	 if(IsEmail(contact_email)==true) {
	 var contact_email = $('#contact_email').val(); 
	 
	  
	var email_check = $('#email_check').val();  
	if(email_check==0) { err=0; $('#email_check').val(''); $('.username_check_span').html(''); $('#username').css("border",""); } 
	if(email_check==1) {  err=1; $('#username').css("border","1px solid #ff0000 "); $('.username_check_span').html('Username Already Exits'); }
	 
	 }  <?php } ?>	
	
	  
	  if($('#contact_address').val()=='' ){ err=1; $('#contact_address').css("border","1px solid #ff0000 "); } else{  $('#contact_address').css("border","");}
	  if($('#contact_city').val()=='' ){ err=1; $('#contact_city').css("border","1px solid #ff0000 "); } else{  $('#contact_city').css("border","");}
	  //if($('#contact_state').val()=='' ){ err=1; $('#contact_state').css("border","1px solid #ff0000 "); } else{  $('#contact_state').css("border","");}
	  if($('#contact_country').val()=='' ){ err=1; $('#contact_country').css("border","1px solid #ff0000 "); } else{  $('#contact_country').css("border","");}
	  
	  var countryName = $('#contact_country').val();
	  
	  if(countryName=='United States') {   
 
	  if($('#us_state').val()=='' ) { err=1; $('#us_state').css("border","1px solid #ff0000 "); } else {  $('#us_state').css("border","");}
	  
	     } 
	  
	  if(countryName!='United States') {    
 if($('#contact_state').val()=='' ) { err=1; $('#contact_state').css("border","1px solid #ff0000 "); } else {  $('#contact_state').css("border","");}
	  } 
	  
	 // if($('#contact_state').val()=='' ){ err=1; $('#contact_state').css("border","1px solid #ff0000 "); } else{  $('#contact_state').css("border","");}
	 
	 
	   if($('#contact_phone').val()=='' ){ err=1; $('#contact_phone').css("border","1px solid #ff0000"); } else{  $('#contact_phone').css("border",""); var contact_phone = $('#contact_phone').val();
	 mobCodeChar = contact_phone.replace(/[^A-Z0-9]+/ig, "");  
	 if(mobCodeChar.length<10) { err=1; $('.error_contact_phone').html( 'Enter 10 digit Phone number');$('#contact_phone').css("border","1px solid #ff0000");  }
   	 else { $('.error_contact_phone').html(''); $('#contact_phone').css("border",""); }
	 }
	 
	  /* var business_email =  $('#business_email').val()
	  if(IsEmail(business_email)==false){ err=1; $('#business_email').css("border","1px solid #ff0000 "); } else { $('#business_email').css("border","");} */
	  
	   if($('#business_email').val()=='' ){ err=1; $('#business_email').css("border","1px solid #ff0000 "); } else{  $('#business_email').css("border","");}
	 
	 
	 if($('#phone').val()=='' ){ err=1; $('#phone').css("border","1px solid #ff0000"); } else{  $('#phone').css("border",""); var phone = $('#phone').val();
	 mobCodeChar = phone.replace(/[^A-Z0-9]+/ig, "");  
	 if(mobCodeChar.length<10) { err=1; $('.error_phone').html( 'Enter 10 digit Phone number');$('#contact_phone').css("border","1px solid #ff0000");  }
   	 else { $('.error_phone').html(''); $('#contact_phone').css("border",""); }
	 }
	 
	 
	  if($('#timezone').val()=='' ){ err=1; $('#timezone').css("border","1px solid #ff0000 "); } else{  $('#timezone').css("border","");}
	  
	 
	 
	var form = $('#users_form');  
 	 
  if(err==0) {
	   $('.loading').show();
   ajax({ 
  	a:'users',
  	b:form.serialize(),
  	c:function(){},
  	d:function(data){   
    var res = data.split("::");
alert(res[1]);
$('.right_bar_div').html('');
 show_user_list();
	 }});  

	  
 }  
}));
});   
  
  
  
function checkUsername(username) {   
	paramData = {'act':'checkUsername','username':username};
	ajax({ 
		a:'users',
		b:$.param(paramData),
		c:function(){},
		d:function(data){ 
		if(data.trim()==0) { $('#username_check').val(0); }
        if(data.trim()==1) {  $('#username_check').val(1);    }	
  if(data.trim()==0) { err=0; $('#username_check').val(''); $('.username_check_span').html(''); $('#username').css("border",""); } 
	if(data.trim()==1) {  err=1; $('#username').css("border","1px solid #ff0000 "); $('.username_check_span').html('Username already exits'); }
 
		
		}});	
}


  
function checkEmail(contact_email) {   
	paramData = {'act':'checkEmail','contact_email':contact_email};
	ajax({ 
		a:'users',
		b:$.param(paramData),
		c:function(){},
		d:function(data){ 
		//alert(data);
		if(data.trim()==0) { $('#email_check').val(0); }
        if(data.trim()==1) {  $('#email_check').val(1);    }	
  if(data.trim()==0) { err=0; $('#email_check').val(''); $('.email_check_span').html(''); $('#contact_email').css("border",""); } 
	if(data.trim()==1) {  err=1; $('#contact_email').css("border","1px solid #ff0000 "); $('.email_check_span').html('Email Address already exits'); }
 
		
		}});	
}


  
   function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }
	  
  
  </script>

 
 


<style> textarea{border:1px solid #cfcfcf}

@media screen and (max-width: 768px) {
	.paddingTop { margin-top:20px; }
	.removebtn { margin-top:10px; float:right; }
}
.form-control { color: #000; }

</style>
