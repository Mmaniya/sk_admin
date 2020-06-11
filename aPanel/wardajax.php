<!--======================================
Name: Manikandan;
Create: 6 / 6 / 2020;
Update: 6 / 6 / 2020;
Use: MAIN AJAX FUNCTION FOR MANDAL
======================================= -->

<?php include 'includes.php';
    
/********* 1. SEARCH LG CONSTANT  *********/
    if ($_POST['act'] == 'searchWard') {
        ob_clean();
        $searchText = $_POST['filter_by'];
        if ($searchText == 'all') {
            $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        } else {
            $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'), 'condition' => array('ward_number' => $searchText.'-STRING'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        }
        $wardlist = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($wardlist);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($wardlist) > 0) $ListingParentCatListArr = array_slice($wardlist, $StartIndex, PAGE_LIMIT, true);
        include 'wardlist.php';
        exit();
    }

/********* 2. TABLE PAGINATION  ***********/

    if ($_POST['act'] == 'parentListpagination') {
        ob_clean();
        $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $wardlist = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($wardlist);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($wardlist) > 0) $ListingParentCatListArr = array_slice($wardlist, $StartIndex, PAGE_LIMIT, true);
        include 'wardlist.php';

        exit();
    }

/********* 3. ADD LG CONSTATNT ************/
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
/********* 4. UPDATE LG CONSTATNT  ********/

    if ($_POST['act'] == 'statusDataUpdate') {
        ob_clean();
        $param['status'] = $_POST['status'];
        $param['updated_date'] = date('Y-m-d H:i:s', time());
        $param['updated_by'] = $_SESSION['user_id'];
        $where = array('id' => $_POST['id']);
        Table::updateData(array('tableName' => TBL_BJP_WARD, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        exit();
    }

/********* 5. VIEW LG CONSTATNT ***********/
    if ($_POST['act'] == 'getAllData') {
        ob_clean();
        $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $wardlist = Table::getData($param);
        if ($_POST['page'] == '') $page = 1;
        else $page = $_POST['page'];
        $TotalCount = count($wardlist);
        $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
        if ($totalPages == 0) $totalPages = PAGE_LIMIT;
        $StartIndex = ($page - 1) * PAGE_LIMIT;
        if (count($wardlist) > 0) $ListingParentCatListArr = array_slice($wardlist, $StartIndex, PAGE_LIMIT, true);
        include 'wardlist.php';
        exit();
    }
?>