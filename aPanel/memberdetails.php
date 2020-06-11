<!--==================================
   Name: Manikandan;
   Create: 1/5/2020;
   Update: 4/6/2020;
   Use: ADD MEMBER FOR OFFICEBEARERS 
   ====================================-->

<?php
   if(count($member_list)>0){
      echo   '<div class="row">
                  <div class="col-md-6">
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                          </div>
                          <input type="text" class="form-control" name="person_name" placeholder="Username" value="'.$member_list->member_name.'">
                      </div>
                  </div>
                  <div class="col-md-6">    
                      <div class="input-group mb-3">
                          <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                          <input type="text" class="form-control" name="email_address" placeholder="Your Email" value="'.$member_list->member_email_address.'">
                          <div class="input-group-append">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                          </div>
                          <input type="number" class="form-control" name="mobile_number" placeholder="Your Mobile Number" value="'.$member_list->member_mobile.'">
                      </div>
                  </div>
                  <div class="col-md-6">    
                      <div class="input-group mb-3">
                          <span class="input-group-text"><i class="fa fa-id-card" aria-hidden="true"></i></span>
                          <input type="number" class="form-control" name="member_id" placeholder="Your Member ID" value="'.$member_list->membership_number.'">
                          <div class="input-group-append">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-address-book" aria-hidden="true"></i></span>
                          </div>
                          <textarea class="form-control" name="address" placeholder="Your Mobile Number">'.$member_list->member_address.'</textarea>
                      </div>
                  </div>
              </div>';
    }?>