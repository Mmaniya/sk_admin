<!--======================================
Name: Manikandan;
Create: 4 / 6 / 2020;
Update: 4 / 6 / 2020;
Use: MAIN AJAX FUNCTION FOR MP CONSTANT 
======================================= -->

<?php include 'includes.php';
    
/********* 1. SEARCH MP CONSTANT  *********/
    if ($_POST['act'] == 'searchConstant') {
        ob_clean();
        $searchText = $_POST['filter_by'];
        if ($searchText == 'all') {
            $param = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        } else {
            $param = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'), 'condition' => array('bjp_mp_const_name' => $searchText.'-STRING'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        }
        $mpconstantlist = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($mpconstantlist);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($mpconstantlist) > 0) $ListingParentCatListArr = array_slice($mpconstantlist, $StartIndex, PAGE_LIMIT, true);
        include 'mpconstantlist.php';
        exit();
    }

/********* 2. TABLE PAGINATION  ***********/

    if ($_POST['act'] == 'parentListpagination') {
        ob_clean();
        $param = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $mpconstantlist = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($mpconstantlist);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($mpconstantlist) > 0) $ListingParentCatListArr = array_slice($mpconstantlist, $StartIndex, PAGE_LIMIT, true);
        include 'mpconstantlist.php';

        exit();
    }

/********* 3. ADD MP CONSTATNT ************/
    if ($_POST['act'] == 'addNewMpConstant') {
        ob_clean();
        $params = array('state_id','district_id', 'bjp_mp_const_no', 'bjp_mp_const_name', 'bjp_mp_const_tname','mp_const_category');
        foreach($params as $K => $V) {
            $param[$V] = $$V = check_input($_POST[$V]);
        }
        if ($_POST['id'] == '') {
            $param['added_by'] = $_SESSION['user_id'];
            $param['added_date'] = date('Y-m-d H:i:s', time());
            $rsDtls = Table::insertData(array('tableName' => TBL_BJP_MP_CONST, 'fields' => $param, 'showSql' => 'N'));
        } else {
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];
            $where = array('id' => $_POST['id']);
            Table::updateData(array('tableName' => TBL_BJP_MP_CONST, 'fields' => $param, 'where' => $where, 'showSql' => 'Y'));
        }
        exit();
    }
/********* 4. UPDATE MP CONSTATNT  ********/

    if ($_POST['act'] == 'statusDataUpdate') {
        ob_clean();
        $param['status'] = $_POST['status'];
        $param['updated_date'] = date('Y-m-d H:i:s', time());
        $param['updated_by'] = $_SESSION['user_id'];
        $where = array('id' => $_POST['id']);
        echo Table::updateData(array('tableName' => TBL_BJP_MP_CONST, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        exit();
    }

/********* 5. VIEW MP CONSTATNT ***********/
    if ($_POST['act'] == 'getAllData') {
        ob_clean();

        $param = array('tableName' => TBL_BJP_MP_CONST, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $mpconstantlist = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($mpconstantlist);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($mpconstantlist) > 0) $ListingParentCatListArr = array_slice($mpconstantlist, $StartIndex, PAGE_LIMIT, true);
        include 'mpconstantlist.php';
        exit();
    }
?>