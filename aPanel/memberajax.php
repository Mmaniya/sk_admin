<?php include 'includes.php';
/********* 1. SEARCH MEMBER  ****************/
if ($_POST['act'] == 'searchMember') {
    ob_clean();
    $searchText = $_POST['filter_by'];
    if ($searchText == 'all') {
        $param = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'condition'  =>array('status'=> 'A-CHAR'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
    } else {
        $param = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'), 'condition' => array('member_name' => $searchText.'-STRING'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
    }
    $member_list = Table::getData($param);
    if ($_POST['page'] == '') $page = 1;
    else $page = $_POST['page'];
    $TotalCount = count($member_list);
    $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
    if ($totalPages == 0) $totalPages = PAGE_LIMIT;
    $StartIndex = ($page - 1) * PAGE_LIMIT;
    if (count($member_list) > 0) $ListingParentCatListArr = array_slice($member_list, $StartIndex, PAGE_LIMIT, true);
    include 'memberlist.php';
    exit();
}

/********* 2. VIEW MEMBER *******************/
if ($_POST['act'] == 'getAllData') {
    ob_clean();

    $param = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
    $member_list = Table::getData($param);
    if ($_POST['page'] == '') $page = 1;
    else $page = $_POST['page'];
    $TotalCount = count($member_list);
    $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
    if ($totalPages == 0) $totalPages = PAGE_LIMIT;
    $StartIndex = ($page - 1) * PAGE_LIMIT;
    if (count($member_list) > 0) $ListingParentCatListArr = array_slice($member_list, $StartIndex, PAGE_LIMIT, true);
    include 'memberlist.php';
    exit();
}

/********* 3. TABLE PAGINATION  **************/

if ($_POST['act'] == 'parentListpagination') {
    ob_clean();
    $param = array('tableName' => TBL_BJP_MEMBER, 'fields' => array('*'),'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
    $member_list = Table::getData($param);
    if ($_POST['page'] == '') $page = 1;
    else $page = $_POST['page'];
    $TotalCount = count($member_list);
    $totalPages = ceil(($TotalCount) / (PAGE_LIMIT));
    if ($totalPages == 0) $totalPages = PAGE_LIMIT;
    $StartIndex = ($page - 1) * PAGE_LIMIT;
    if (count($member_list) > 0) $ListingParentCatListArr = array_slice($member_list, $StartIndex, PAGE_LIMIT, true);
    include 'memberlist.php';

    exit();
}

/********* 4. ADD MEMBER  **************/

if ($_POST['act'] == 'mmemberEdit') {
    ob_clean();
    $params = array('member_name', 'member_name_ta');
    foreach($params as $K => $V) {
        $param[$V] = $$V = check_input($_POST[$V]);
    }
    if ($_POST['id'] == '') {
        $param['added_by'] = $_SESSION['user_id'];
        $param['added_date'] = date('Y-m-d H:i:s', time());
        $rsDtls = Table::insertData(array('tableName' => TBL_BJP_MEMBER, 'fields' => $param, 'showSql' => 'N'));
    } else {
        $param['updated_date'] = date('Y-m-d H:i:s', time());
        $param['updated_by'] = $_SESSION['user_id'];
        $where = array('id' => $_POST['id']);
        Table::updateData(array('tableName' => TBL_BJP_MEMBER, 'fields' => $param, 'where' => $where, 'showSql' => 'Y'));
    }
    exit();
}