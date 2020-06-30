<?php include 'includes.php';
    
/********* 1. SEARCH DISRICT  ****************/
    if ($_POST['act'] == 'searchDistrict') {
        ob_clean();
        $searchText = $_POST['filter_by'];
        if ($searchText == 'all') {
            $param = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'),'condition'  =>array('status'=> 'A-CHAR'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        } else {
            $param = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'), 'condition' => array('district_name' => $searchText.'-STRING'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        }
        $district_list = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($district_list);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($district_list) > 0) $ListingParentCatListArr = array_slice($district_list, $StartIndex, PAGE_LIMIT, true);
        include 'districtlist.php';
        exit();
    }

/********* 2. TABLE PAGINATION  **************/

    if ($_POST['act'] == 'parentListpagination') {
        ob_clean();
        $param = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $district_list = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($district_list);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($district_list) > 0) $ListingParentCatListArr = array_slice($district_list, $StartIndex, PAGE_LIMIT, true);
        include 'districtlist.php';

        exit();
    }

/********* 3. ADD DISRICT ********************/
    if ($_POST['act'] == 'addNewDisrict') {
        ob_clean();
        $params = array('state_id', 'district_name', 'district_name_ta', 'district_abbr');
        foreach($params as $K => $V) {
            $param[$V] = $$V = check_input($_POST[$V]);
        }
        if ($_POST['id'] == '') {
            $param['added_by'] = $_SESSION['user_id'];
            $param['added_date'] = date('Y-m-d H:i:s', time());
            $rsDtls = Table::insertData(array('tableName' => TBL_BJP_DISTRICT, 'fields' => $param, 'showSql' => 'N'));
        } else {
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];
            $where = array('id' => $_POST['id']);
            Table::updateData(array('tableName' => TBL_BJP_DISTRICT, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        }
        exit();
    }
/********* 4. STATUS UPDATE DISRICT  *********/

    if ($_POST['act'] == 'statusDataUpdate') {
        ob_clean();
        $param['status'] = $_POST['status'];
        $param['updated_date'] = date('Y-m-d H:i:s', time());
        $param['updated_by'] = $_SESSION['user_id'];
        $where = array('id' => $_POST['id']);
        echo Table::updateData(array('tableName' => TBL_BJP_DISTRICT, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        exit();
    }

/********* 5. VIEW DISRICT *******************/
    if ($_POST['act'] == 'getAllData') {
        ob_clean();

        $param = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $district_list = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($district_list);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($district_list) > 0) $ListingParentCatListArr = array_slice($district_list, $StartIndex, PAGE_LIMIT, true);
        include 'districtlist.php';
        exit();
    }

/********* 6. SEARCH MANDAL DETAILS VIEW *****/

    if ($_POST['act'] == 'getMandalData') {
        ob_clean();
        $searchText = $_POST['filter_by'];
        $query = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('district_id' => $searchText.'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $mandal_list = Table::getData($query);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($mandal_list);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($mandal_list) > 0) $ListingParentCatListArr = array_slice($mandal_list, $StartIndex, PAGE_LIMIT, true);
        include 'districtviewtable.php';
        exit();
    }

    if ($_POST['act'] == 'searchMandal') {
        ob_clean();
        $searchText = $_POST['filter_by'];
        $distID = $_POST['district_id'];

        $query = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('mandal_name' => $searchText.'-STRING','district_id'=> $distID. '-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $mandal_list = Table::getData($query);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($mandal_list);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($mandal_list) > 0) $ListingParentCatListArr = array_slice($mandal_list, $StartIndex, PAGE_LIMIT, true);
        include 'districtviewtable.php';
        exit();
    }
    
    if ($_POST['act'] == 'childListpagination') {
        ob_clean();
        $distID = $_POST['districtID'];
        $param = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('district_id'=> $distID. '-INT'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $mandal_list = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($mandal_list);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($mandal_list) > 0) $ListingParentCatListArr = array_slice($mandal_list, $StartIndex, PAGE_LIMIT, true);
        include 'districtviewtable.php';
        exit();
    }
/********* 7. WARD DETAILS VIEW **************/
    if ($_POST['act'] == 'wardDetailsGet') {
        ob_clean();
            $searchText = $_POST['id'];
            $query = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('mandal_id' => $searchText.'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $ward_list = Table::getData($query);
            if ($_POST['page'] == '') $page = 1;
            else $page = $_POST['page'];
            $TotalCount = count($ward_list);
            $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
            if ($totalPages == 0) $totalPages = PAGE_LIMIT;
            $StartIndex = ($page - 1) * PAGE_LIMIT;
            if (count($ward_list) > 0) $ListingParentCatListArr = array_slice($ward_list, $StartIndex, PAGE_LIMIT, true);
            include 'districtwarddetails.php';
        exit();
    }

/********* 8. WARD OFFICE BEARERS VIEW *******/
    if ($_POST['act'] == 'officeBearesDetailsget') {
        ob_clean();
            $searchText = $_POST['id'];
            $query = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $searchText.'-INT'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
            $ob_list = Table::getData($query);
            if ($_POST['page'] == '') $page = 1;
            else $page = $_POST['page'];
            $TotalCount = count($ob_list);
            $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
            if ($totalPages == 0) $totalPages = PAGE_LIMIT;
            $StartIndex = ($page - 1) * PAGE_LIMIT;
            if (count($ob_list) > 0) $ListingParentCatListArr = array_slice($ob_list, $StartIndex, PAGE_LIMIT, true);
            include 'districofficebearers.php';
        exit();
    }

/********* 9. ADD MANDAL *********************/
    if ($_POST['act'] == 'addNewMandal') {
        ob_clean();
        $params = array('state_id','district_id','mp_const_id','lg_const_id','mandal_name','mandal_tname');
        foreach($params as $K => $V) {
            $param[$V] = $$V = check_input($_POST[$V]);
        }
        if ($_POST['id'] == '') {
            $param['added_by'] = $_SESSION['user_id'];
            $param['added_date'] = date('Y-m-d H:i:s', time());
            $rsDtls = Table::insertData(array('tableName' => TBL_BJP_MANDAL, 'fields' => $param, 'showSql' => 'N'));
        } else {
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];
            $where = array('id' => $_POST['id']);
            Table::updateData(array('tableName' => TBL_BJP_MANDAL, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        }
        exit();
    }
/********* 10.PAGINATION FOR MEMBER DETAILS **/

    if($_POST['act'] == 'MandalofficeBearers') {
        ob_clean();  
            $qry = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$_POST['id'].'" AND (`role_hierarchy` ="'.$_POST['role'].'" OR `sub_role_hierarchy` ="'.$_POST['role'].'") AND `status`="A" ORDER BY id DESC';
            $stateMembersList=dB::mExecuteSql($qry); 

            if ($_POST['page'] == '') $page = 1;
            else $page = $_POST['page'];
            $TotalCount = count($stateMembersList);
            $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
            if ($totalPages == 0) $totalPages = PAGE_LIMIT;
            $StartIndex = ($page - 1) * PAGE_LIMIT;
            if (count($stateMembersList) > 0) $ListingParentCatListArr = array_slice($stateMembersList, $StartIndex, PAGE_LIMIT, true);
            include 'districtuserdetails.php';
        exit();
    }
    
    if($_POST['act'] == 'memberListpagination') {
        ob_clean();  
            $qry = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$_POST['mandalId'].'" AND (`role_hierarchy` ="'.$_POST['role'].'" OR `sub_role_hierarchy` ="'.$_POST['role'].'") AND `status`="A" ORDER BY id DESC';
            $stateMembersList=dB::mExecuteSql($qry);

            if ($_POST['page'] == '') $page = 1;
            else $page = $_POST['page'];
            $TotalCount = count($stateMembersList);
            $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
            if ($totalPages == 0) $totalPages = PAGE_LIMIT;
            $StartIndex = ($page - 1) * PAGE_LIMIT;
            if (count($stateMembersList) > 0) $ListingParentCatListArr = array_slice($stateMembersList, $StartIndex, PAGE_LIMIT, true);
            include 'districtuserdetails.php';
        exit();
    }
/********* 11.ADD NEW WARD *******************/

    if ($_POST['act'] == 'addNewWard') {
        ob_clean();
        $params = array('district_id','mp_const_id','lg_const_id','mandal_id','ward_number_old','ward_number','ward_zipcode','ward_category','ward_type');
        foreach($params as $K => $V) {
            $param[$V] = $$V = check_input($_POST[$V]);
        }
        if ($_POST['id'] == '') {
            $param['added_by'] = $_SESSION['user_id'];
            $param['added_date'] = date('Y-m-d H:i:s', time());
            $rsDtls = Table::insertData(array('tableName' => TBL_BJP_WARD, 'fields' => $param, 'showSql' => 'N'));
        } else {
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];
            $where = array('id' => $_POST['id']);
            Table::updateData(array('tableName' => TBL_BJP_WARD, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        }
        exit();
    }

/********* 12.OFFICE BEARERS ROLE SELECTION **/

    if($_POST['act']=='findrolePosition'){
        ob_clean();

        $hierarchy = $_POST['position'];
        $mandalID = $_POST['mandalID'];
        $wardID = $_POST['wardID'];
        $option = explode(",", $_POST['roleoption']);   
        $param = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>$hierarchy.'-CHAR'),'showSql'=>'N','orderby'=>'position','sortby'=>'desc');
        $hierarchy_list = Table::getData($param);?>
         <?php
         foreach($hierarchy_list as $key=>$value) {  
            if($wardID = $_POST['wardID'] != ''){
            $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_id'=>$value->id.'-INT','role_hierarchy'=>$hierarchy.'-CHAR','mandal_id'=>$mandalID.'-INT','ward_id'=>$wardID.'-INT','status'=>'A-CHAR'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
            } else {
                $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_id'=>$value->id.'-INT','role_hierarchy'=>$hierarchy.'-CHAR','mandal_id'=>$mandalID.'-INT','status'=>'A-CHAR'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
            }
            if($value->role_hierarchy == 'M'){
            $ob_list = Table::getData($param);
            $ob_count = count($ob_list); 
           if($ob_count<$value->no_of_roles) {  ?>    
                <option <?php   if(in_array($value->position, $option)) echo 'selected="selected"'; ?>  value="<?php  echo $value->id; ?>" ><?php  echo $value->role_name; ?></option>
          <?php } 
          } else{ ?>
                    <option <?php   if(in_array($value->position, $option)) echo 'selected="selected"'; ?>  value="<?php  echo $value->id; ?>" ><?php  echo $value->role_name; ?></option>
         <?php }
        }
          exit();

    } 
/********* 13.GET MEMBER DETAILS**************/

    if(isset($_POST['search'])){
        ob_clean();
        $search = $_POST['search']; 
        $mandal = $_POST['mandal']; 
       $qry = 'select * from '.TBL_BJP_MEMBER.' where ((member_name like "%'.$search.'%") or (member_mobile like "%'.$search.'%") or (membership_number like "%'.$search.'%")) and (mandal_id = '.$mandal.') limit 5';
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
        $param = array('tableName'=>TBL_BJP_MEMBER,'fields'=>array('*'),'condition'=>array('id'=>$searchID.'-INT','status'=>'A-CHAR'),'showSql'=>'N','sortby'=>'asc');
        $member_list = Table::getData($param);
        include 'memberdetails.php';
        exit();
      }
/********* 14.ADD OFFICE BEARERS *************/
    /* 1. add office bearesr Mandal */
        if ($_POST['act'] == 'addNewOfficeBearersMandal') {
            ob_clean();
        
            if($_POST['sub_role_hierarchy'] == 'W'){
                $subrolew = "select ward_id from ".TBL_BJP_OFFICE_BEARERS." where (`sub_role_hierarchy` = 'W' OR `role_hierarchy` = 'W') AND `mandal_id`=".$_POST['mandal_id']." AND `status` = 'A'";
                $subrolewList=dB::mExecuteSql($subrolew);
                foreach ($subrolewList as $W => $WV){      
                    $newArray[] = $WV->ward_id;       
                }                
                if (in_array(trim($_POST['ward_id']),$newArray)){  
                    $subroleId = 1;
                    $getWard = 'select ward_number from '.TBL_BJP_WARD.' where `id` = "'.$_POST['ward_id'].'" AND `status`="A"';
                    $getWardDetails=dB::mExecuteSql($getWard);
                    $getWardname = array();
                    foreach ($getWardDetails as $Wk => $WN){
                         $result = $WN->ward_number. ' Ward Incharge ';
                    }
                } 
            } else if($_POST['sub_role_hierarchy'] == 'SK'){
                foreach ($_POST['booth_id'] as $booth => $boothvalue){
                             $booth_id = implode(',',$_POST['booth_id']);
                    }
                $subrolesk = "select booth_id from ".TBL_BJP_OFFICE_BEARERS." where (`sub_role_hierarchy` = 'SK' OR `role_hierarchy` = 'SK') AND `mandal_id`=".$_POST['mandal_id']." AND `ward_id`=".$_POST['ward_id']." AND `status` = 'A'";
                $subroleskList=dB::mExecuteSql($subrolesk); 
                $newarry = array();
                foreach ($subroleskList as $SK => $SKV){
                    $newarry[]= $SKV->booth_id;
                }
                $arraymerge = implode(',',$newarry);
                $totalarray = explode(',',$arraymerge);
                foreach($totalarray as $subarray => $subvalue){
                if (in_array(trim($subvalue), $_POST['booth_id'])){  
                        $subroleId = 1;
                        $getsk = 'select booth_number from '.TBL_BJP_BOOTH.' where `id` = "'. $subvalue.'" AND `status`="A"';
                        $getSkDetails=dB::mExecuteSql($getsk);
                        $getBoothname = array();
                        foreach ($getSkDetails as $Bk => $BV){
                            $result = $BV->booth_number. ' Booth Incharge ';
                        }
                    }
                }
            } else if($_POST['sub_role_hierarchy'] == 'B'){
                foreach ($_POST['booth_id'] as $booth => $boothvalue){
                    $booth_id = implode(',',$_POST['booth_id']);
                }
                $subroleb = "select booth_id from ".TBL_BJP_OFFICE_BEARERS." where (`sub_role_hierarchy` = 'B' OR `role_hierarchy` = 'B') AND `mandal_id`=".$_POST['mandal_id']." AND `ward_id`=".$_POST['ward_id']." AND `status` = 'A'";
                $subrolebList=dB::mExecuteSql($subroleb); 
                $newarry = array();
                foreach ($subrolebList as $SK => $SKV){
                    $newarry[]= $SKV->booth_id;
                }
                $arraymerge = implode(',',$newarry);
                $totalarray = explode(',',$arraymerge);
                foreach($totalarray as $subarray => $subvalue){
                if (in_array(trim($subvalue), $_POST['booth_id'])){  
                        $subroleId = 1;
                        $getsk = 'select booth_number from '.TBL_BJP_BOOTH.' where `id` = "'. $subvalue.'" AND `status`="A"';
                        $getSkDetails=dB::mExecuteSql($getsk);
                        $getBoothname = array();
                        foreach ($getSkDetails as $Bk => $BV){
                            $result = $BV->booth_number;
                        }
                    }
                }
            }

            $query = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$_POST['role_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $role_list = Table::getData($query);

            $subquery = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$_POST['sub_role_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $sub_role_list = Table::getData($subquery);

            $checkmember = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('member_id'=>$_POST['member_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $checkmemberDetails = Table::getData($checkmember);
            $availmember = count($checkmemberDetails);
                if($availmember>0){ 
                    foreach($checkmemberDetails as $member=>$memberValue) { 
                         $result = $memberValue->person_name.'-'.$memberValue->mobile_number.' This Member';
                    }
                    $subroleId = 1;
                }
                
                if($subroleId == 0){
                    $param=array();
                    $paramsOB = array('role_hierarchy','sub_role_hierarchy','state_id','district_id','mandal_id','ward_id','member_id','membership_number','person_name','person_name_ta','mobile_number','address','email_address','whatsapp_number');
                    foreach($paramsOB as $key => $Val) {
                        $param[$Val] = $$Val = check_input($_POST[$Val]);
                    }
                    if ($_POST['id'] == '') {
                        $param['role_position'] =   $role_list->role_abbr.','.$sub_role_list->role_abbr;
                        $param['role_id'] =  $role_list->id.','.$sub_role_list->id;
                        $param['booth_id'] = $booth_id;
                        $param['added_by'] = $_SESSION['user_id'];
                        $param['added_date'] = date('Y-m-d H:i:s', time());
                        $rsDtls = Table::insertData(array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => $param, 'showSql' => 'N'));
                        echo '<p style="color:green;">New '.$role_list->role_name.' Created.</p>';
                    } 
                } else {
                    echo $resultPrint = '<p style="color:red;">'. $result .' Allready Exist</p>';
                }                 
            exit();
        }

    /* 2. add office bearesr ward */
        if ($_POST['act'] == 'addNewOfficeBearersWard') {
            ob_clean();
        
            foreach ($_POST['booth_id'] as $booth => $boothvalue){
                $booth_id = implode(',',$_POST['booth_id']);
            }
            
            $subrolew = "select ward_id from ".TBL_BJP_OFFICE_BEARERS." where (`sub_role_hierarchy` = 'W' OR `role_hierarchy` = 'W') AND `mandal_id`=".$_POST['mandal_id']." AND `status` = 'A'";
            $subrolewList=dB::mExecuteSql($subrolew);
            foreach ($subrolewList as $W => $WV){      
                $newArray[] = $WV->ward_id;       
            }                
            if (in_array(trim($_POST['ward_id']),$newArray)){  
                $subroleId = 1;
                $getWard = 'select ward_number from '.TBL_BJP_WARD.' where `id` = "'.$_POST['ward_id'].'" AND `status`="A"';
                $getWardDetails=dB::mExecuteSql($getWard);
                $getWardname = array();
                foreach ($getWardDetails as $Wk => $WN){
                     $result = $WN->ward_number. ' Ward Incharge ';
                }
            }              

       if($_POST['sub_role_hierarchy'] == 'SK'){
            foreach ($_POST['booth_id'] as $booth => $boothvalue){
                         $booth_id = implode(',',$_POST['booth_id']);
                }
            $subrolesk = "select booth_id from ".TBL_BJP_OFFICE_BEARERS." where (`sub_role_hierarchy` = 'SK' OR `role_hierarchy` = 'SK') AND `mandal_id`=".$_POST['mandal_id']." AND `ward_id`=".$_POST['ward_id']." AND `status` = 'A'";
            $subroleskList=dB::mExecuteSql($subrolesk); 
            $newarry = array();
            foreach ($subroleskList as $SK => $SKV){
                $newarry[]= $SKV->booth_id;
            }
            $arraymerge = implode(',',$newarry);
            $totalarray = explode(',',$arraymerge);
            foreach($totalarray as $subarray => $subvalue){
            if (in_array(trim($subvalue), $_POST['booth_id'])){  
                    $subroleId = 1;
                    $getsk = 'select booth_number from '.TBL_BJP_BOOTH.' where `id` = "'. $subvalue.'" AND `status`="A"';
                    $getSkDetails=dB::mExecuteSql($getsk);
                    $getBoothname = array();
                    foreach ($getSkDetails as $Bk => $BV){
                        $result = $BV->booth_number. ' Booth Incharge ';
                    }
                }
            }

            } else if($_POST['sub_role_hierarchy'] == 'B'){
                $subroleId = 1;
                $subroleb = "select booth_id from ".TBL_BJP_OFFICE_BEARERS." where (`sub_role_hierarchy` = 'B' OR `role_hierarchy` = 'B') AND `mandal_id`=".$_POST['mandal_id']." AND `ward_id`=".$_POST['ward_id']." AND `status` = 'A'";
                $subrolebList=dB::mExecuteSql($subroleb); 
                $newarry = array();
                foreach ($subrolebList as $SK => $SKV){
                    $newarry[]= $SKV->booth_id;
                }
                $arraymerge = implode(',',$newarry);
                $totalarray = explode(',',$arraymerge);
                foreach($totalarray as $subarray => $subvalue){
                if (in_array(trim($subvalue), $_POST['booth_id'])){  
                        $subroleId = 1;
                        $getsk = 'select booth_number from '.TBL_BJP_BOOTH.' where `id` = "'. $subvalue.'" AND `status`="A"';
                        $getSkDetails=dB::mExecuteSql($getsk);
                        $getBoothname = array();
                        foreach ($getSkDetails as $Bk => $BV){
                            $result = $BV->booth_number. ' Booth Incharge ';
                        }
                    }
                }
            }
            
            $query = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$_POST['role_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $role_list = Table::getData($query);

            $subquery = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$_POST['sub_role_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $sub_role_list = Table::getData($subquery);

         
            $checkmember = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('member_id'=>$_POST['member_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $checkmemberDetails = Table::getData($checkmember);
            $availmember = count($checkmemberDetails);
                if($availmember>0){ 
                    foreach($checkmemberDetails as $member=>$memberValue) { 
                         $result = $memberValue->person_name.'-'.$memberValue->mobile_number.' This Member';
                    }
                    $subroleId = 1;
                }
            
            if($subroleId == 0){

            $param=array();
            $paramsOB = array('role_hierarchy','sub_role_hierarchy','role_id','state_id','district_id','mandal_id','member_id','membership_number','ward_id','person_name','person_name_ta','mobile_number','address','email_address','whatsapp_number');
            foreach($paramsOB as $key => $Val) {
                $param[$Val] = $$Val = check_input($_POST[$Val]);
            }
            if ($_POST['id'] == '') {
                $param['role_position'] =  $role_list->role_abbr;
                $param['booth_id'] = $booth_id;
                $param['added_by'] = $_SESSION['user_id'];
                $param['added_date'] = date('Y-m-d H:i:s', time());
                $rsDtls = Table::insertData(array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => $param, 'showSql' => 'N'));
                echo  '<p style="color:green;">New '.$role_list->role_name.' Created.</p>';
            } 
               
        }  else {
            echo $resultPrint = '<p style="color:red;">'. $result .' Allready Exist</p>';
        }
            exit();
        }

    /* 3 add office bearers shakti kendram */
        if ($_POST['act'] == 'addNewOfficeBearersSK') {
            ob_clean();

            foreach ( $_POST['booth_id'] as $key => $value) {
                $booth_id = implode(',', $_POST['booth_id']);
            } 
     
            $subrolesk = "select booth_id from ".TBL_BJP_OFFICE_BEARERS." where (`sub_role_hierarchy` = '".$_POST['role_hierarchy']."' OR `role_hierarchy` = '".$_POST['role_hierarchy']."') AND `mandal_id`=".$_POST['mandal_id']." AND `ward_id`=".$_POST['ward_id']." AND `status` = 'A'";
            $subroleskList=dB::mExecuteSql($subrolesk); 
            $newarry = array();
            foreach ($subroleskList as $SK => $SKV){
                $newarry[]= $SKV->booth_id;
            }
            $arraymerge = implode(',',$newarry);
            $totalarray = explode(',',$arraymerge);
            foreach($totalarray as $subarray => $subvalue){
            if (in_array(trim($subvalue), $_POST['booth_id'])){  
                    $subroleId = 1;
                    $getsk = 'select booth_number from '.TBL_BJP_BOOTH.' where `id` = "'. $subvalue.'" AND `status`="A"';
                    $getSkDetails=dB::mExecuteSql($getsk);
                    $getBoothname = array();
                    foreach ($getSkDetails as $Bk => $BV){
                        echo '<h6 style="color:red;">'.$BV->booth_number.'</h6>';
                    }
                }
            }

            $query = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$_POST['role_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $role_list = Table::getData($query);


            $checkmember = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('member_id'=>$_POST['member_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $checkmemberDetails = Table::getData($checkmember);
            $availmember = count($checkmemberDetails);
                if($availmember>0){ 
                    foreach($checkmemberDetails as $member=>$memberValue) { 
                         $result = $memberValue->person_name.'-'.$memberValue->mobile_number.' This Member';
                    }
                    $subroleId = 1;
                }

            
            if($subroleId == 0){
       
            $param=array();
            $paramsOB = array('role_hierarchy','sub_role_hierarchy','role_id','state_id','district_id','mandal_id','member_id','membership_number','ward_id','person_name','person_name_ta','mobile_number','address','email_address','whatsapp_number');
                foreach($paramsOB as $key => $Val) {
                    $param[$Val] = $$Val = check_input($_POST[$Val]);
                }
                if ($_POST['id'] == '') {
                    $param['role_position'] =  $role_list->role_abbr;
                    $param['booth_id'] = $booth_id;
                    $param['added_by'] = $_SESSION['user_id'];
                    $param['added_date'] = date('Y-m-d H:i:s', time());
                    $rsDtls = Table::insertData(array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => $param, 'showSql' => 'N'));
                    echo  '<p style="color:green;">New '.$role_list->role_name.' Created.</p>';
                } 
            } else {
                echo $resultPrint = '<p style="color:red;">'.$result.' Allready Exist</p>';
            }
            exit();
        }
    /* 4 add office bearers Booth */
        if ($_POST['act'] == 'addNewOfficeBearersBooth') {
            ob_clean();
   
            $subroleb = "select * from ".TBL_BJP_OFFICE_BEARERS." where (`sub_role_hierarchy` = 'B' OR `role_hierarchy` = 'B') AND `mandal_id`=".$_POST['mandal_id']." AND `ward_id`=".$_POST['ward_id']." AND `booth_id`=".$_POST['booth_id']." AND `status` = 'A'";
            $subrolebList=dB::mExecuteSql($subroleb); 

            foreach ($subrolebList as $booth => $boothvalue){
                $subroleId = 1;
                $getsk = 'select booth_number from '.TBL_BJP_BOOTH.' where `id` = "'. $boothvalue->booth_id .'" AND `status`="A"';
                $getSkDetails=dB::mExecuteSql($getsk);
                $getBoothname = array();
                foreach ($getSkDetails as $Bk => $BV){
                    $result = 'Booth No '.$BV->booth_number;
                }            
            }
            $checkmember = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('member_id'=>$_POST['member_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $checkmemberDetails = Table::getData($checkmember);
            $availmember = count($checkmemberDetails);
            if($availmember>0){ 
                foreach($checkmemberDetails as $member=>$memberValue) { 
                        $result = $memberValue->person_name.'-'.$memberValue->mobile_number.' This Member';
                }
                $subroleId = 1;
            }

            
            $query = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$_POST['role_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
            $role_list = Table::getData($query);
    
            if($subroleId == 0){        
                $param=array();
                $paramsOB = array('role_hierarchy','sub_role_hierarchy','role_id','state_id','district_id','mandal_id','member_id','membership_number','ward_id','booth_id','person_name','person_name_ta','mobile_number','address','email_address','whatsapp_number');
                foreach($paramsOB as $key => $Val) {
                    $param[$Val] = $$Val = check_input($_POST[$Val]);
                }
                if ($_POST['id'] == '') {
                    $param['role_position'] =  $role_list->role_abbr;
                    $param['added_by'] = $_SESSION['user_id'];
                    $param['added_date'] = date('Y-m-d H:i:s', time());
                    $rsDtls = Table::insertData(array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => $param, 'showSql' => 'N'));
                    echo  '<p style="color:green;">New '.$role_list->role_name.' Created.</p>';
                } 
            } else {
                echo $resultPrint = '<p style="color:red;">'.$result.' Allready Exist</p>';
            }
            exit();
        } 
/********* 15.WARD FULL DETAILS **************/

    if($_POST['act'] == 'MandalWardDetails') {
        ob_clean();  
            $qry = 'select * from '.TBL_BJP_WARD.' where `id`="'.$_POST['wardId'].'" AND `status`="A"';
            $wardFullDetails=dB::mExecuteSql($qry); 

            if ($_POST['page'] == '') $page = 1;
            else $page = $_POST['page'];
            $TotalCount = count($wardFullDetails);
            $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
            if ($totalPages == 0) $totalPages = PAGE_LIMIT;
            $StartIndex = ($page - 1) * PAGE_LIMIT;
            if (count($wardFullDetails) > 0) $ListingParentCatListArr = array_slice($wardFullDetails, $StartIndex, PAGE_LIMIT, true);
            include 'districtcompletewardetails.php';
        exit();
    }

    if($_POST['act'] == 'MandalWardDetailsPagination') {
        ob_clean();  
            $qry = 'select * from '.TBL_BJP_WARD.' where `id`="'.$_POST['wardId'].'" AND `status`="A"';
            $wardFullDetails=dB::mExecuteSql($qry);

            if ($_POST['page'] == '') $page = 1;
            else $page = $_POST['page'];
            $TotalCount = count($wardFullDetails);
            $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
            if ($totalPages == 0) $totalPages = PAGE_LIMIT;
            $StartIndex = ($page - 1) * PAGE_LIMIT;
            if (count($wardFullDetails) > 0) $ListingParentCatListArr = array_slice($wardFullDetails, $StartIndex, PAGE_LIMIT, true);
            include 'districtcompletewardetails.php';
        exit();
    }

/********* 16.DELETE OFFICE BEARERS **********/
    if ($_POST['act'] == 'statusDataUpdateforOB') {
        ob_clean();
        $query = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('id'=> $_POST['id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
        $ob_list = Table::getData($query);
        if($ob_list->role_hierarchy !='' && $ob_list->sub_role_hierarchy != ''  ){
            if($_POST['subRole'] == $ob_list->role_hierarchy) {
                    $param['role_hierarchy'] = '';
                    if($_POST['subRole'] == 'SK'){
                        $param['ward_id'] = '';  
                        $param['booth_id'] = '';  
                    }        
            } else if($_POST['subRole'] == $ob_list->sub_role_hierarchy) {
                    $param['sub_role_hierarchy'] = '';
                    if($_POST['subRole'] == 'SK'){
                        $param['booth_id'] = '';  
                    }           
            }
        }else{
            $param['status']  = 'I';
        }
        $param['updated_date'] = date('Y-m-d H:i:s', time());
        $param['updated_by'] = $_SESSION['user_id'];
        $where = array('id' => $_POST['id']);
 
        Table::updateData(array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));      
        exit();
    } 
/********* 17.FETCH MANDAL THALAIVAR *********/
    if($_POST['act'] == 'fetchMandalThalaivar'){
        
        $mandal = 'select *, (select role_abbr from '.TBL_BJP_ROLE.' where id = role_id ) as position, (select role_name from '.TBL_BJP_ROLE.' where id = role_id ) as rolename from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$_POST['id'].'" AND `role_hierarchy` ="M" AND `status`="A"';
        $Mincharge = dB::mExecuteSql($mandal);
        foreach($Mincharge as $K=>$V){
        if($V->position == 'MP'){     ?>                               
        <div class="row">
           <div class="card col-sm-12">
              <div class="card-body row"> 
                 <div class="col-sm-10">               
                    <h4><?php  echo $V->person_name; echo '('; echo $V->person_name_ta; echo ')'; ?></h4>
                    <h4><?php echo $V->mobile_number ?></h4> 
                    <h4 class="mytextcolor"><?php  echo $V->rolename ?></h4>   
                 </div> 
                 <div class="col-sm-2">
                    <?php  
                       $mandal_member = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition' => array('id' => $V->member_id.'-CHAR','status'=> 'A-CHAR'), 'showSql' => 'N');
                       $mandal_member_list = Table::getData($mandal_member);

                       if($mandal_member_list->member_photo != ''){
                          ?>               
                          <img  src="<?php  echo TBL_MEMBER_BASE_URL ?><?php  echo $mandal_member_list->member_photo ?>" height="100" weight="30" alt="Mandal President">
                         <?php  } else { ?>
                          <img  src="../assets/images/user.jpg" height="100" weight="30" alt="District President">
                       <?php  } ?>
                 </div>                                  
              </div>
           </div>
        </div>
        <br> 
       <?php   } } 

    }
/********* 18.SELECT NEW WARD ****************/

    if($_POST['act']=='wardincharge' || $_POST['action'] == 'W' || $_POST['action'] == 'SK' || $_POST['action'] == 'B'){
        ob_clean();
        $mandalID = $_POST['mandalID'];   

        $param = array('tableName'=>TBL_BJP_WARD,'fields'=>array('*'),'condition'=>array('mandal_id'=>$mandalID.'-INT','status'=>'A-CHAR'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
        $ward_list = Table::getData($param);
        if(($_POST['act']=='wardincharge') != '') {?>        
        <option value="" selected="fasle" disabled="disabled">Please Select Ward</option>
        <?php } foreach($ward_list as $Key=>$value) {  

        ?><option  value="<?php echo $value->id; ?>" ><?php echo $value->ward_number; ?></option>
        <?php } 
        exit();
    }
/********* 19 SELECT FOR NEW BOOTH  **********/

    if($_POST['act']=='boothincharge'){
        ob_clean();
        $wardID = $_POST['wardID'];   
        $param = array('tableName'=>TBL_BJP_BOOTH,'fields'=>array('*'),'condition'=>array('ward_id'=>$wardID.'-STRING','status'=>'A-CHAR'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
        $booth_list = Table::getData($param); 
        ?>

        <?php foreach($booth_list as $Key=>$value) {  
        ?><option  value="<?php echo $value->id; ?>" ><?php echo $value->booth_number; ?></option>
        <?php } 
        exit();
    }
/********* 20.ADD EDIT NEW BOOTH *************/
    if ($_POST['act'] == 'addEditBooth') {
        ob_clean();
        $params = array('ward_id','old_booth_number','booth_number','total_voters','male_voters_count','female_voters_count','other_voters_count','booth_address','booth_zipcode','booth_police_station');
        foreach($params as $K => $V) {
            $param[$V] = $$V = check_input($_POST[$V]);
        }
        if ($_POST['id'] == '') {
            $param['added_by'] = $_SESSION['user_id'];
            $param['added_date'] = date('Y-m-d H:i:s', time());
            $rsDtls = Table::insertData(array('tableName' => TBL_BJP_BOOTH, 'fields' => $param, 'showSql' => 'N'));
        } else {
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];
            $where = array('id' => $_POST['id']);
            Table::updateData(array('tableName' => TBL_BJP_BOOTH, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        }
        exit();
    }
/********* 21.UPDATE OFFICE BEARERS **********/
    if ($_POST['act'] == 'editOfficeBearers') {

        $query = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$_POST['role_id'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
        $role_list = Table::getData($query);

        $paramsOB = array('role_hierarchy','sub_role_hierarchy','membership_number','district_id','mandal_id','mobile_number','whatsapp_number','person_name','mobile_number','address','email_address');        
        foreach($paramsOB as $key => $Val) {
            $param[$Val] = $$Val = check_input($_POST[$Val]);
        }
        if ($_POST['id'] != '')  {
            if($_POST['role_id'] != ''){
                $param['role_id'] =  $_POST['role_id'];
            }
            
            if($_POST['updateBooth'] != ''){
                foreach($_POST['updateBooth'] as $array=>$keyvalue) {
                    $param['booth_id'] = implode(',',$_POST['updateBooth']);
                }                          
            }
            if($_POST['addNewBooth'] != ''){
                foreach($_POST['addNewBooth'] as $array=>$keyvalue) {
                    $param['booth_id'] = implode(',',$_POST['addNewBooth']);
                }                          
            }
            if($_POST['addSubRoleMandal'] != ''){
                $param['sub_role_hierarchy'] = $_POST['addSubRoleMandal'];
            }
            if($_POST['addneWard'] != ''){
                $param['ward_id'] =$_POST['addneWard'];
            }else if($_POST['updateWard_id'] != ''){
                $param['ward_id'] = $_POST['updateWard_id'];
            }else{
                $param['ward_id'] = $_POST['ward_id'];
            }
            if($_POST['role_id'] != ''){
            $param['role_position'] =  $role_list->role_abbr;
            }
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];    
            $where = array('id' => $_POST['id']);
            $rsDtls = Table::updateData(array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => $param, 'where' => $where, 'showSql' => 'Y'));
            echo $result = '<p style="color:red;">'.$role_list->role_name.' Update</p>';
        }
    }
/********* 22.CHECK AVILABLE WARDS ***********/
    if ($_POST['act'] == 'findavailableWard') {
    
        $qry = 'select * from '.TBL_BJP_WARD.' where `id` NOT IN (select ward_id from '.TBL_BJP_OFFICE_BEARERS.' where (`role_hierarchy`="W" OR `sub_role_hierarchy`="W") AND `status`="A" AND  `mandal_id`="'.$_POST['mandalID'].'") AND `mandal_id` ="'.$_POST['mandalID'].'" AND `status`="A"';
        $wardFullDetails=dB::mExecuteSql($qry);
        
        foreach($wardFullDetails as $Key=>$val) {  
            ?><option  value="<?php echo $val->id; ?>" ><?php echo $val->ward_number; ?></option>
        <?php }

    };
/********* 23.GET ALL BOOTHS  ****************/
    if ($_POST['act'] == 'findselectedBooth') {

        $bootharray = explode(',',$_POST['boothID']);
            if($_POST['getRole'] == 'B'){
                $qry = 'select * from '.TBL_BJP_BOOTH.' where `ward_id` ='.$_POST['wardID'].' AND `status`="A"';
                $wardFullDetails=dB::mExecuteSql($qry);       
                foreach($wardFullDetails as $Key=>$val) {  ?>
                    <option <?php  if(in_array("$val->id",$_POST['boothID'])){ echo 'selected="selected"'; } ?>  value="<?php  echo $val->id; ?>" ><?php  echo $val->booth_number; ?></option>
                <?php  } 
            }else{
                $qry1 = 'select booth_id from '.TBL_BJP_OFFICE_BEARERS.' where  `mandal_id` ='.$_POST['mandalID'].' AND `ward_id` ='.$_POST['wardID'].' AND `id` !='.$_POST['obid'].' AND `booth_id` != "" AND `status`="A"';
                $findbooth=dB::mExecuteSql($qry1); 
                if(count($findbooth) == 0 || $findbooth->booth_id != ''){
                     $qry = 'select * from '.TBL_BJP_BOOTH.' where `ward_id` ='.$_POST['wardID'].' AND `status`="A"';
                }else{
                   $newarry = array();
                   foreach($findbooth as $array=>$keyvalue) {
                       $newarry[] = $keyvalue->booth_id;                     
                   }
                   $fillterarray = array_filter($newarry);
                   $formatarray = implode(',',$fillterarray);
                   $qry = 'select * from '.TBL_BJP_BOOTH.' where `ward_id` ='.$_POST['wardID'].' AND `id` NOT IN ('.$formatarray.') AND `status`="A"';
                }
                $wardFullDetails=dB::mExecuteSql($qry);       
                foreach($wardFullDetails as $Key=>$val) {  ?>
                    <option <?php  if(in_array("$val->id",$bootharray)){ echo 'selected="selected"'; } ?>  value="<?php  echo $val->id; ?>" ><?php  echo $val->booth_number; ?></option>
                <?php  }              
            }  

    };
/********* 24.ADD NEW SUBROLE WARD ***********/
    if ($_POST['act'] == 'addNewSubRole') { 
        ob_clean();
        $mandalID = $_POST['mandalID']; 
        $wardID = $_POST['wardID']; 

        $query = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('id'=>$_POST['obid'].'-INT','status'=>'A-CHAR'),'showSql'=>'N');
        $findMember = Table::getData($query);
        if($findMember->role_hierarchy !='' && $findMember->sub_role_hierarchy !=""){
        // $rsult = $findMember->person_name.'-'.$findMember->mobile_number.' This Memmber Allready Handle Two Many Wards!';
            echo $checkMember = '0';
        } else {
            if($_POST['selectRole'] == 'W'){
                $qry = 'select * from '.TBL_BJP_WARD.' where `id` NOT IN (select ward_id from '.TBL_BJP_OFFICE_BEARERS.' where (`role_hierarchy`="W" OR `sub_role_hierarchy`="W") AND `status`="A" AND  `mandal_id`="'.$_POST['mandalID'].'") AND `mandal_id` ="'.$_POST['mandalID'].'" AND `status`="A"';
            }else if($_POST['selectRole'] == 'SK'){
                $qry = 'select * from '.TBL_BJP_WARD.' where `mandal_id` ="'.$_POST['mandalID'].'" AND `status`="A"';   
            }     
            $wardFullDetails=dB::mExecuteSql($qry);    
            foreach($wardFullDetails as $Key=>$val) {  
                ?><option  value="<?php echo $val->id; ?>" ><?php echo $val->ward_number; ?></option>
            <?php }               
        }
        if($wardID != ''){
            $param = array('tableName'=>TBL_BJP_BOOTH,'fields'=>array('*'),'condition'=>array('ward_id'=>$wardID.'-STRING','status'=>'A-CHAR'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
            $booth_list = Table::getData($param); 
        
            ?>
            <?php foreach($booth_list as $Key=>$value) {  
            ?><option  value="<?php echo $value->id; ?>" ><?php echo $value->booth_number; ?></option>
            <?php }      
        }
        exit();
    }

/********* 25.ADD NEW SUBROLE BOOTH **********/
    if ($_POST['act'] == 'addNewSubRoleBooth') { 
        ob_clean();
        $wardID = $_POST['wardID']; 
        if($wardID != ''){
        
            $query = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('ward_id'=>$wardID.'-STRING','status'=>'A-CHAR'),'showSql'=>'N');
            $findbooth = Table::getData($query);
            foreach($findbooth as $array=>$keyvalue) {
                $newarry[] = $keyvalue->booth_id;                     
            }
            $fillterarray = array_filter($newarry);
            $formatarray = implode(',',$fillterarray); 
            if($formatarray != ''){
                $qry = 'select * from '.TBL_BJP_BOOTH.' where `ward_id` ="'.$_POST['wardID'].'" AND `id` NOT IN ('.$formatarray.') AND `status`="A"';
            }else{
                $qry = 'select * from '.TBL_BJP_BOOTH.' where `ward_id` ="'.$_POST['wardID'].'" AND `status`="A"';
            }
            $booth_list=dB::mExecuteSql($qry); 
            foreach($booth_list as $k=>$va) {  
            ?><option  value="<?php echo $va->id; ?>" ><?php echo $va->booth_number; ?></option>
            <?php } 
            }
        exit();
    }
/********* 26.DELETE FOR BOOTH ***************/

    if ($_POST['act'] == 'statusDataUpdateforBooth') {
        ob_clean();
        $param['status'] = $_POST['status'];
        $param['updated_date'] = date('Y-m-d H:i:s', time());
        $param['updated_by'] = $_SESSION['user_id'];
        $where = array('id' => $_POST['id']);
        echo Table::updateData(array('tableName' => TBL_BJP_BOOTH, 'fields' => $param, 'where' => $where, 'showSql' => 'Y'));
        exit();
    }