<!--======================================
Name: Manikandan;
Create: 5 / 6 / 2020;
Update: 5 / 6 / 2020;
Use: MAIN AJAX FUNCTION FOR LG CONSTANT 
======================================= -->

<?php include 'includes.php';
    
/********* 1. SEARCH LG CONSTANT  *********/
    if ($_POST['act'] == 'searchConstant') {
        ob_clean();
        $searchText = $_POST['filter_by'];
        if ($searchText == 'all') {
            $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        } else {
            $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'), 'condition' => array('lg_const_name' => $searchText.'-STRING'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        }
        $lgconstantlist = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($lgconstantlist);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($lgconstantlist) > 0) $ListingParentCatListArr = array_slice($lgconstantlist, $StartIndex, PAGE_LIMIT, true);
        include 'lgconstantlist.php';
        exit();
    }

/********* 2. TABLE PAGINATION  ***********/

    if ($_POST['act'] == 'parentListpagination') {
        ob_clean();
        $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $lgconstantlist = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($lgconstantlist);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($lgconstantlist) > 0) $ListingParentCatListArr = array_slice($lgconstantlist, $StartIndex, PAGE_LIMIT, true);
        include 'lgconstantlist.php';

        exit();
    }

/********* 3. ADD LG CONSTATNT ************/
    if ($_POST['act'] == 'addNewLGConstant') {
        ob_clean();
        $params = array('state_id','district_id','mp_const_id','lg_const_number','lg_const_name','lg_const_tname','lg_const_category');
        foreach($params as $K => $V) {
            $param[$V] = $$V = check_input($_POST[$V]);
        }
        if ($_POST['id'] == '') {
            $param['added_by'] = $_SESSION['user_id'];
            $param['added_date'] = date('Y-m-d H:i:s', time());
            $rsDtls = Table::insertData(array('tableName' => TBL_BJP_LG_CONST, 'fields' => $param, 'showSql' => 'N'));
        } else {
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];
            $where = array('id' => $_POST['id']);
            Table::updateData(array('tableName' => TBL_BJP_LG_CONST, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        }
        exit();
    }
/********* 4. UPDATE LG CONSTATNT  ********/

    if ($_POST['act'] == 'statusDataUpdate') {
        ob_clean();
        $param['status'] = $_POST['status'];
        $param['updated_date'] = date('Y-m-d H:i:s', time());
        $param['updated_by'] = $_SESSION['user_id'];
        $where = array('id' => $_POST['id']);
        Table::updateData(array('tableName' => TBL_BJP_LG_CONST, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        exit();
    }

/********* 5. VIEW LG CONSTATNT ***********/
    if ($_POST['act'] == 'getAllData') {
        ob_clean();
        $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $lgconstantlist = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($lgconstantlist);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($lgconstantlist) > 0) $ListingParentCatListArr = array_slice($lgconstantlist, $StartIndex, PAGE_LIMIT, true);
        include 'lgconstantlist.php';
        exit();
    }
?>