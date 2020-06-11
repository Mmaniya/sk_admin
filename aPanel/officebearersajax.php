

<?php
   include 'includes.php';
   
   /*---------- Office Bearers Table  --------*/
   
     if($_POST['act']=='DataTable') {
         ob_clean();
         $searchType = $_POST['type'];
         $GetAll = $_POST['GetAll'];
   
       $singleOfficeBearers = $_POST['singleOfficeBearers'];
   
       if($searchType =='all' && $singleOfficeBearers != '') {
         $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('id'=>$singleOfficeBearers.'-INT'),'showSql'=>'N');
       } else {
         $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
       }
       $officebearersList = Table::getData($param);
      
       if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
       $TotalCount = count($officebearersList);
       $totalPages= ceil(($TotalCount)/(PAGE_LIMIT));
       if($totalPages==0) $totalPages=PAGE_LIMIT;
       $StartIndex= ($page-1)*PAGE_LIMIT;
       if(count($officebearersList)>0) $ListingParentCatListArr = array_slice($officebearersList,$StartIndex,PAGE_LIMIT,true); 
       include 'viewofficebearers.php';
       exit();
     }
   
     if($_POST['act']=='parentListpagination') {
       ob_clean();
         $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
         $officebearersList = Table::getData($param);
         if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
         $TotalCount = count($officebearersList);
         $totalPages= ceil(($TotalCount)/(PAGE_LIMIT));
         if($totalPages==0) $totalPages=PAGE_LIMIT;
         $StartIndex= ($page-1)*PAGE_LIMIT;
         if(count($officebearersList)>0) $ListingParentCatListArr = array_slice($officebearersList,$StartIndex,PAGE_LIMIT,true); 
         include 'viewofficebearers.php';
   
         exit();   
         }
   
         if($_POST['act']=='searchGetBox') {
           ob_clean();
           $searchType = $_POST['type'];
           $filter_by = $_POST['filter_by'];
           $searchText = $_POST['searchby'];
           if($searchType =='all') {
               $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
           }    
           if($searchType =='all' &&  $filter_by != '') {
             $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>$filter_by.'-STRING'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
           } 
           if($searchType =='person_name') {
               $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('person_name'=>$searchText.'-STRING'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
           }
         $officebearersList = Table::getData($param);
         if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
         $TotalCount = count($officebearersList);
         $totalPages= ceil(($TotalCount)/(PAGE_LIMIT));
         if($totalPages==0) $totalPages=PAGE_LIMIT;
         $StartIndex= ($page-1)*PAGE_LIMIT;
         if(count($officebearersList)>0) $ListingParentCatListArr = array_slice($officebearersList,$StartIndex,PAGE_LIMIT,true); 
         include 'viewofficebearers.php';
         exit();
       }
   
   
   /*---------- End Office Bearers Table -----*/
   
   /*---------- SEARCH USER LIST -------------*/
   
     if($_POST['act']=='searchBox') {
         ob_clean();
         $searchType = $_POST['type'];
         $filter_by = $_POST['filter_by'];
         $searchText = $_POST['searchby'];
         if($searchType =='all') {
             $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
         }    
         if($searchType =='all' &&  $filter_by != '') {
           $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>$filter_by.'-STRING'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
         } 
         if($searchType =='person_name') {
             $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('person_name'=>$searchText.'-STRING'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
         }
       $officebearersList = Table::getData($param);
       if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
       $TotalCount = count($officebearersList);
       $totalPages= ceil(($TotalCount)/(PAGE_LIMIT));
       if($totalPages==0) $totalPages=PAGE_LIMIT;
       $StartIndex= ($page-1)*PAGE_LIMIT;
       if(count($officebearersList)>0) $ListingParentCatListArr = array_slice($officebearersList,$StartIndex,PAGE_LIMIT,true); 
       include 'officebearerslist.php';
       exit();
     }
   
   /*---------- END SEARCH USER LIST ---------*/
   
   /*---------- PAGEINATION ------------------*/
   
     if($_POST['act']=='parentCategoryListpagination') {
         ob_clean();
           $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'showSql'=>'N','orderby'=>'person_name','sortby'=>'asc');
           $officebearersList = Table::getData($param);
           if($_POST['page']=='')	$page=1;	else	$page = $_POST['page'];
           $TotalCount = count($officebearersList);
           $totalPages= ceil(($TotalCount)/(PAGE_LIMIT));
           if($totalPages==0) $totalPages=PAGE_LIMIT;
           $StartIndex= ($page-1)*PAGE_LIMIT;
           if(count($officebearersList)>0) $ListingParentCatListArr = array_slice($officebearersList,$StartIndex,PAGE_LIMIT,true); 
           include 'officebearerslist.php';   
   
       exit();   
       }
   /*---------- END PAGEINATION --------------*/
   
   /*---------- USER ROLE --------------------*/
   
    if($_POST['act']=='findrolePosition'){
        ob_clean();
        $hierarchy = $_POST['position'];
        $option = explode(",", $_POST['roleoption']);   
        $param = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),
        'condition'=>array('role_hierarchy'=>$hierarchy.'-CHAR'),'showSql'=>'N','orderby'=>'position','sortby'=>'desc');
        $hierarchy_list = Table::getData($param);
          ?>
          <?php  foreach($hierarchy_list as $key=>$value) {            
            $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_position'=>$value->role_abbr.'-CHAR','role_hierarchy'=>$hierarchy.'-CHAR'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
            $ob_list = Table::getData($param);
            $ob_count = count($ob_list); 
            if($ob_count<$value->no_of_roles) {            
            ?>    
          <option <?php if(in_array($value->position, $option)) echo 'selected="selected"'; ?>  value="<?php echo $value->id; ?>" ><?php echo $value->role_name; ?></option>
          <?php } } 
          exit();
    }  
    
   /*---------- END USER ROLE ----------------*/
   
   /*---------- FIND ROLE DISTRICT -----------*/
   
    if($_POST['act'] == 'findroleDistirct'){
        ob_clean();
          $district = $_POST['district'];
            $selected = explode(",", $_POST['selected']);
          //  print_r (in_array($selected));
          $dist_ID = join("','", $_POST['dist_ID']);
          if($dist_ID == ''){
              $query = "SELECT * from ".TBL_BJP_DISTRICT. " ORDER BY `id`";
            }else{
              $query = "SELECT * from ".TBL_BJP_DISTRICT. " WHERE `id` IN ('".$dist_ID."') ORDER BY `id`";
          }    
          $district_list = dB::mEXecuteSql($query);
          if( $district != 'S' && $district != '' ){?> 
        <option selected="true" disabled="disabled" value="">Please Select District</option>
        <?php }
          foreach($district_list as $key=>$value) {
          ?>
        <option <?php if(in_array($value->id, $selected)) { echo 'selected="selected"';} ?> value='<?php  echo $value->id; ?>'><?php  echo $value->district_name; ?></option>
        <?php 
          }  
          exit();
    }
    
    if($_POST['act'] == 'findsubroleDistirct'){
        ob_clean();
        $district = $_POST['district'];
        $dist_ID = join("','", $_POST['dist_ID']);
        
        if($_POST['dist_ID_edit'] == ''){
          if($dist_ID == ''){
                $query = "SELECT * from ".TBL_BJP_DISTRICT. " ORDER BY `id`";
            }else{
                $query = "SELECT * from ".TBL_BJP_DISTRICT. " WHERE `id` IN ('".$dist_ID."') ORDER BY `id`";
          }    
        } else {
            $query = "SELECT * from ".TBL_BJP_DISTRICT. " WHERE `id` IN (".$_POST['dist_ID_edit'].") ORDER BY `id`";
        }
        $district_list = dB::mEXecuteSql($query);
          include 'subrolelist.php';  
          exit();
    }
    
   /*---------- END FIND ROLE DISTRICT -------*/
   
   /*---------- FIND ROLE MANDAL -------------*/
   
    if($_POST['act'] == 'findroleMandal'){
        ob_clean();
          $disrictMultipleID = join("','",$_POST['disrictID']);
          $disrictSingleID =  $_POST['disrictID'];
          $findMandal =  join("','",  $_POST['findMandal']);
        
          $selected = explode(",", $_POST['selected']);
        
          if($findMandal == ''){
              if ($disrictSingleID != ''){ 
                $param = " Select * from ".TBL_BJP_MANDAL. " where `district_id`= $disrictSingleID "; 
              }  
              if ($disrictMultipleID != ''){   
                  $param = " Select * from ".TBL_BJP_MANDAL. " where `district_id` IN (".$disrictMultipleID.") "; 
              }
          }else{
                $param = " Select * from ".TBL_BJP_MANDAL. " where `id` IN (".$findMandal.") "; 
          }
          $mandal_list =  dB::mEXecuteSql($param);
          if( $disrictSingleID != '' || $findMandal !='' ){?> 
      <option  disabled="disabled" value="">Please Select Mandal</option>
      <?php }
        foreach($mandal_list as $key=>$value) { ?>
      <option <?php if(in_array($value->id, $selected)) { echo 'selected="selected"';} ?> value='<?php  echo $value->id; ?>'><?php  echo $value->mandal_name; ?></option>
      <?php 
        }  
        exit();
    }
    
    if($_POST['act'] == 'findsubroleMandal'){
        ob_clean();
        $disrictMultipleID = join("','", $_POST['disrictID']);   
        $disrictSingleID =  $_POST['disrictID'];
        $findMandal =  join("','",  $_POST['findMandal']);
        
        if($_POST['Mandal_id_edit'] == ''){
        if($findMandal == ''){
            if ($disrictSingleID != ''){ 
              $param = " Select * from ".TBL_BJP_MANDAL. " where `district_id`= $disrictSingleID "; 
            }  
            if ($disrictMultipleID != ''){   
                $param = " Select * from ".TBL_BJP_MANDAL. " where `district_id` IN ('".$disrictMultipleID."') "; 
            }
        }else{
          $param = " Select * from ".TBL_BJP_MANDAL. " where `id` IN ('".$findMandal."') "; 
        }
        }else{
        $param = " Select * from ".TBL_BJP_MANDAL. " where `id` IN (".$_POST['Mandal_id_edit'].") ORDER BY `id` "; 
        }
        $mandal_list =  dB::mEXecuteSql($param); 
        include 'subrolelist.php';   
        exit();
    }
   
   /*---------- END FIND ROLE MANDAL ---------*/
   
   /*---------- FIND ROLE WARD ---------------*/
   
    if($_POST['act'] == 'findroleWard'){
          ob_clean();
          $mandalMultiId = join("','", $_POST['mandalID']);
          $mandalSingleID =  $_POST['mandalID'];
          $wardData =  join("','",  $_POST['selectedward']);
          $selected = explode(",", $_POST['selected']);
          
          if($wardData == ''){
            if($mandalSingleID != ''){
              $param = " Select * from ".TBL_BJP_WARD. " where `mandal_id` = $mandalSingleID ";
            }
            if($mandalMultiId != ''){
              $param = " Select * from ".TBL_BJP_WARD. " where `mandal_id` IN ('".$mandalMultiId."') ";
            }
          } else{
              $param = " Select * from ".TBL_BJP_WARD. " where `id` IN ('".$wardData."') ";
          }          
          $ward_list = dB::mEXecuteSql($param);
          if( $mandalSingleID != ''){?> 
        <option  disabled="disabled" value="">Please Select Ward</option>
        <?php }
          foreach($ward_list as $key=>$value) {
          ?>
        <option <?php if(in_array($value->id, $selected)) { echo 'selected="selected"';} ?> value='<?php  echo $value->id; ?>'><?php  echo $value->ward_number; ?></option>
        <?php 
          }  
          exit();
    }
    
    if($_POST['act'] == 'findsubroleWard'){
        ob_clean();
          $mandalMultiId = join("','", $_POST['mandalID']);
          $mandalSingleID =  $_POST['mandalID'];
          $wardData =  join("','",  $_POST['selectedward']);
          if($_POST['ward_id_edit'] == ''){
            if($wardData == ''){
              if($mandalSingleID != ''){
                $param = " Select * from ".TBL_BJP_WARD. " where `mandal_id` = $mandalSingleID ";
              }
              if($mandalMultiId != ''){
                $param = " Select * from ".TBL_BJP_WARD. " where `mandal_id` IN ('".$mandalMultiId."') ";
              }
            } else{
                $param = " Select * from ".TBL_BJP_WARD. " where `id` IN ('".$wardData."') ";
            }
          } else {
                $param = " Select * from ".TBL_BJP_WARD. " where `id` IN (".$_POST['ward_id_edit'].")  ORDER BY `id` ";
          }         
          $ward_list = dB::mEXecuteSql($param);
          include 'subrolelist.php';   
        
        exit();
    }
    
   /*---------- END FIND ROLE WARD -----------*/
   
   /*---------- FIND ROLE SK -----------------*/
   
    if($_POST['act'] == 'findroleShaktikendram'){
        ob_clean();
          $wardMultiId = join("','", $_POST['wardID']);
          $wardSingleID =  $_POST['wardID'];
          $skid =  join("','",  $_POST['skid']);
          $selected = explode(",", $_POST['selected']);
        
          if($skid == ''){
            if($wardSingleID != ''){
                $query = " Select * from ".TBL_BJP_SK. " where `ward_id` = $wardSingleID ";
            }
            if($wardMultiId != ''){
                $query = " Select * from ".TBL_BJP_SK. " where `ward_id` IN ('".$wardMultiId."') ";
            } 
          }else{
              $query = " Select * from ".TBL_BJP_SK. " where `id` IN ('".$skid."') ";
          }
          $sk_list = dB::mEXecuteSql($query);
          if( $wardSingleID != ''){?> 
      <option  disabled="disabled" value="">Please Select Shakti Kendram</option>
      <?php }
        foreach($sk_list as $key=>$value) {
        ?>
      <option <?php if(in_array($value->id, $selected)) { echo 'selected="selected"';} ?> value='<?php  echo $value->id; ?>'><?php  echo $value->sk_name; ?></option>
      <?php 
        }  
        exit();
    }
    
    if($_POST['act'] == 'findsubroleShaktikendram'){
        ob_clean();
          $wardMultiId = join("','", $_POST['wardID']);
          $wardSingleID =  $_POST['wardID'];
          $skid =  join("','",  $_POST['skid']);
          if($_POST['sk_id_edit'] == ''){
            if($skid == ''){
              if($wardSingleID != ''){
                  $query = " Select * from ".TBL_BJP_SK. " where `ward_id` = $wardSingleID ";
              }
              if($wardMultiId != ''){
                  $query = " Select * from ".TBL_BJP_SK. " where `ward_id` IN ('".$wardMultiId."') ";
              } 
            }else{
              $query = " Select * from ".TBL_BJP_SK. " where `id` IN ('".$skid."') ";
            }
          } else {
            $query = " Select * from ".TBL_BJP_SK. " where `id` IN (".$_POST['sk_id_edit'].") ";
          }
          $sk_list = dB::mEXecuteSql($query);
          include 'subrolelist.php';   
        
        exit();
    }
   
   /*---------- END FIND ROLE SK -------------*/
   
   /*---------- FIND ROLE BOOTH --------------*/
   
    if($_POST['act'] == 'findroleBooth'){
          ob_clean();
          $skID = join("','", $_POST['skid']);
          $skID =  $_POST['skid'];
      
          $selected = explode(",", $_POST['selected']);
      
          echo $skquery = " Select * from ".TBL_BJP_SK. " where `id`  IN ('".$skID."') ";
          $sk_list = dB::mEXecuteSql($skquery);
          foreach($sk_list as $key=>$value) {
      
          $boothid = $value->booth_id;
          }
          //  if($wardSingleID != ''){
          //    $param = " Select * from ".TBL_BJP_SK. " where `ward_id` = $wardSingleID ";
          //  }
          //  if($wardMultiId != ''){
              $query = " Select * from ".TBL_BJP_BOOTH. " where `id` IN (".$boothid.") ";
          //  } 
                $booth_list = dB::mEXecuteSql($query);
                foreach($booth_list as $key=>$value) {
              ?>
        <option <?php if(in_array($value->id, $selected)) { echo 'selected="selected"';} ?> value='<?php  echo $value->id; ?>'><?php  echo $value->booth_number; ?></option>
        <?php 
        }  
        exit();
    }
   /*---------- END  FIND ROLE BOOTH ---------*/

  /*----------- MEMBER DETAILS ---------------*/
    if(isset($_POST['search'])){
      ob_clean();
      $search = $_POST['search']; 
      $qry = 'select * from '.TBL_BJP_MEMBER.' where (member_name like "%'.$search.'%") or (member_mobile like "%'.$search.'%") or (membership_number like "%'.$search.'%")  limit 20';
      $rsMembers=dB::mExecuteSql($qry); 
      if(count($rsMembers)>0) {
        foreach($rsMembers as $key=>$val) {
          $qry = 'select * from '.TBL_BJP_MANDAL.' where id='.$val->mandal_id;
          $rsMandal=dB::sExecuteSql($qry); 
          $qry = 'select * from '.TBL_BJP_WARD.' where id='.$val->ward_id;
          $rsWard=dB::sExecuteSql($qry); 
          $qry = 'select * from '.TBL_BJP_BOOTH.' where id='.$val->booth_id;
          $rsBooth=dB::sExecuteSql($qry);  
          $label = $val->member_name.'('.$val->membership_number.')::'.$rsMandal->mandal_name.'::'.$rsWard->ward_number.'::'.$rsBooth->booth_id.'::'.$val->member_mobile;                               
          $response[] = array("value"=>$val->id,"label"=>$label);             
        }
      }      
      echo json_encode($response);
      exit();
      }

      if($_POST['act']=='memberDetails') {
      ob_clean();
      $searchID = $_POST['filter_by'];
      $param = array('tableName'=>TBL_BJP_MEMBER,'fields'=>array('*'),'condition'=>array('id'=>$searchID.'-INT'),'showSql'=>'N','sortby'=>'asc');
      $member_list = Table::getData($param);
      include 'memberdetails.php';
      exit();
    }
  /*----------- END MEMBER DETAILS -----------*/

  /*----------- FORM DATA SAVE ---------------*/
    if($_POST['act']=='addFormDetails'){
      ob_clean();
      $role_id = $_POST['role_id'];
      $getrole = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$role_id.'-INT'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
      $role_list = Table::getData($getrole);
      $role_list->position;
      foreach ( $_POST['district_id'] as $key => $value) {
      $district_id = implode(',', $_POST['district_id']);
      }
      foreach ( $_POST['mandal_id'] as $key => $value) {
      $mandal_id = implode(',', $_POST['mandal_id']);
      } 
      foreach ( $_POST['ward_id'] as $key => $value) {
      $ward_id = implode(',', $_POST['ward_id']);
      } 
      foreach ( $_POST['sk_id'] as $key => $value) {
      $sk_id = implode(',', $_POST['sk_id']);
      }
      foreach ( $_POST['booth_id'] as $key => $value) {
      $booth_id = implode(',', $_POST['booth_id']);
      } 
      $params = array('role_hierarchy','sub_role_hierarchy','role_id','member_id','person_name','mobile_number','address','email_address');
      foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
      if($_POST['id']=='') {
      $param['state_id'] = '1';
      $param['district_id'] = $district_id;
      $param['mandal_id'] = $mandal_id;
      $param['ward_id'] = $ward_id;
      $param['sk_id'] = $sk_id;
      $param['booth_id'] = $booth_id;
      $param['role_position'] = $role_list->position;		
      $param['added_date'] = date('Y-m-d H:i:s',time());		
      $param['added_by']= $_SESSION['user_id'];  
      $rsDtls = Table::insertData(array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>$param,'showSql'=>'N')); 
      }
      else { 
      $param['state_id'] = '1';
      $param['district_id'] = $district_id;
      $param['mandal_id'] = $mandal_id;
      $param['ward_id'] = $ward_id;
      $param['sk_id'] = $sk_id;
      $param['booth_id'] = $booth_id;
      $param['role_position'] = $role_list->position;
      $param['updated_date'] = date('Y-m-d H:i:s',time());		
      $param['updated_by']= $_SESSION['user_id'];  
      $where= array('id'=>$_POST['id']);
      Table::updateData(array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>$param,'where'=>$where,'showSql'=>'Y'));
      }
      exit();
    }
  /*----------- END FORM DATA SAVE -----------*/