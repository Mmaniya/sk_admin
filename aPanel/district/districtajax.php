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
            Table::updateData(array('tableName' => TBL_BJP_DISTRICT, 'fields' => $param, 'where' => $where, 'showSql' => 'Y'));
        }
        exit();
    }
/********* 4. UPDATE DISRICT  ****************/

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
            // $stateMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $_POST['id'].'-INT','role_hierarchy'=>$_POST['role'].'-CHAR'),'orderby' => 'id', 'showSql' => 'N');
            // $stateMembersList = Table::getData($stateMembers); 

            $qry = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$_POST['id'].'" AND `role_hierarchy` ="'.$_POST['role'].'" OR `sub_role_hierarchy`="'.$_POST['role'].'"';
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
            // $stateMembers = array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => array('*'),'condition' => array('mandal_id' => $_POST['mandalId'].'-INT','role_hierarchy'=>$_POST['role'].'-CHAR'),'orderby' => 'id', 'showSql' => 'N');
            // $stateMembersList = Table::getData($stateMembers); 
            $qry = 'select * from '.TBL_BJP_OFFICE_BEARERS.' where `mandal_id`="'.$_POST['id'].'" AND `role_hierarchy` ="'.$_POST['role'].'" OR `sub_role_hierarchy`="'.$_POST['role'].'"';
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
        $option = explode(",", $_POST['roleoption']);   
        $param = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>$hierarchy.'-CHAR'),'showSql'=>'N','orderby'=>'position','sortby'=>'desc');
        $hierarchy_list = Table::getData($param);
          ?>
          <?php  foreach($hierarchy_list as $key=>$value) {            
            $param = array('tableName'=>TBL_BJP_OFFICE_BEARERS,'fields'=>array('*'),'condition'=>array('role_position'=>$value->role_abbr.'-CHAR','role_hierarchy'=>$hierarchy.'-CHAR'),'showSql'=>'N','orderby'=>'id','sortby'=>'desc');
            $ob_list = Table::getData($param);
            $ob_count = count($ob_list); 
            if($ob_count<$value->no_of_roles) {  ?>    
          <option <?php if(in_array($value->position, $option)) echo 'selected="selected"'; ?>  value="<?php echo $value->id; ?>" ><?php echo $value->role_name; ?></option>
          <?php } }
          exit();
    } 
/********* 13.GET MEMBER DETAILS**************/

    if(isset($_POST['search'])){
        ob_clean();
        $search = $_POST['search']; 
        $mandal = $_POST['mandal']; 
        $qry = 'select * from '.TBL_BJP_MEMBER.' where ((member_name like "%'.$search.'%") or (member_mobile like "%'.$search.'%") or (membership_number like "%'.$search.'%")) and (mandal_id = '.$mandal.') limit 20';
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

    if ($_POST['act'] == 'addNewOfficeBearers') {
        ob_clean();

        $query = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('id'=>$_POST['role_id'].'-CHAR'),'showSql'=>'N','sortby'=>'desc');
        $role_list = Table::getData($query);

         $paramsOB = array('role_hierarchy','sub_role_hierarchy','role_id','state_id','district_id','mandal_id','member_id','person_name','mobile_number','address','email_address','is_verified');
        foreach($paramsOB as $key => $Val) {
            $param[$Val] = $$Val = check_input($_POST[$Val]);
        }
        if ($_POST['id'] == '') {
            $param['role_position'] =  $role_list->role_abbr;
            $param['added_by'] = $_SESSION['user_id'];
            $param['added_date'] = date('Y-m-d H:i:s', time());
            $rsDtls = Table::insertData(array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => $param, 'showSql' => 'N'));
            echo $rsDtls;
        } else {
            $param['role_position'] =  $role_list->role_abbr;
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];
            $where = array('id' => $_POST['id']);
            $rsDtls = Table::updateData(array('tableName' => TBL_BJP_OFFICE_BEARERS, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
            echo $rsDtls;

        }
        exit();
    }
?>