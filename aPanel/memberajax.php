<?php include 'includes.php';

/********* 1. MEMBER TABLE ****************/
    if($_POST['act'] == 'getallDistrict'){
        $param = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $districtList = Table::getData($param); ?>
            <option value='' <?php if($_POST['selected'] == ''){?> selected <? }?>>--Select District--</option>
       <?php foreach($districtList as $K => $V) { ?>
                <option <?php if($V->id == $_POST['selected']){ echo 'selected="selected"'; } ?> value="<?php echo $V->id ?>"><?php echo $V->district_name ?></option>
        <?php }
    }

    if($_POST['act'] == 'getallConstituency'){
        $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $constList = Table::getData($param); ?>
            <option value='' <?php if($_POST['selected'] == ''){?> selected <? }?>>--Select Constituency--</option>
       <?php foreach($constList as $K => $V) { ?>
                <option <?php if($V->id == $_POST['selected']){ echo 'selected="selected"'; } ?> value="<?php echo $V->id ?>"><?php echo $V->lg_const_name ?></option>
        <?php } ?>
        <?php
    }
    if($_POST['act'] == 'getallMandal'){
        $param = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('district_id' => $_POST['dist'].'-INT','lg_const_id' => $_POST['const'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $mandalList = Table::getData($param); ?>
        <option value=''  <?php if($_POST['selected'] == ''){?> selected <? }?>>--Select Mandal--</option>
       <?php foreach($mandalList as $K => $V) { ?>
                <option <?php if($V->id == $_POST['selected']){ echo 'selected="selected"'; } ?> value="<?php echo $V->id ?>"><?php echo $V->mandal_name ?></option>
        <?php } ?>
        <?php
    }
    if($_POST['act'] == 'getallWard'){
        $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('mandal_id' => $_POST['mandal'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $wardList = Table::getData($param); ?>
        <option value=''  <?php if($_POST['selected'] == ''){?> selected <? }?>>--Select Ward--</option>
       <?php foreach($wardList as $K => $V) { ?>
                <option <?php if($V->id == $_POST['selected']){ echo 'selected="selected"'; } ?> value="<?php echo $V->id ?>"><?php echo $V->ward_number ?></option>
        <?php } ?>
        <?php
    }
    if($_POST['act'] == 'getallBooth'){
        $param = array('tableName' => TBL_BJP_BOOTH, 'fields' => array('*'),'condition' => array('ward_id' => $_POST['ward'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $boothList = Table::getData($param); ?>
        <option value=''  <?php if($_POST['selected'] == ''){?> selected <? }?>>--Select Booth--</option>
        <?php foreach($boothList as $K => $V) { ?>
                <option <?php if($V->id == $_POST['selected']){ echo 'selected="selected"'; } ?> value="<?php echo $V->id ?>"><?php echo $V->booth_number ?></option>
        <?php } ?>
        <?php
    }
    if($_POST['act'] == 'getallBoothBranch'){
        $param = array('tableName' => TBL_BJP_BOOTH_BRANCH, 'fields' => array('*'),'condition' => array('booth_id' => $_POST['booth'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N', 'orderby' => 'id', 'sortby' => 'desc');
        $boothbranchList = Table::getData($param); ?>
        <option value=''  <?php if($_POST['selected'] == ''){?> selected <? }?>>--Select Booth Branch--</option>
        <?php foreach($boothbranchList as $K => $V) { ?>
                <option <?php if($V->id == $_POST['selected']){ echo 'selected="selected"'; } ?> value="<?php echo $V->id ?>"><?php echo $V->booth_branch_name ?></option>
        <?php } ?>
        <?php
    }

/********* 2. MEMBER TABLE UPDATE *********/

    if ($_POST['act'] == 'addEditMember') {
        ob_clean();
        $params = array('state_id','district_id','lg_const_id','mandal_id','ward_id','booth_id','booth_branch_id','member_name','member_name_ta','membership_number','member_mobile','is_whatsapp','member_another_mobile','member_email_address','member_DOB','member_age','member_gender','blood_group','member_education','job_category','others_job_category','member_address','member_zip','member_voter_id','member_aadhar_number');
        foreach($params as $K => $V) {
            $param[$V] = $$V = check_input($_POST[$V]);
        }
        if ($_POST['id'] == '') {
            $param['status'] = 'A';
            $param['mp_const_id'] = '1';
            $param['added_by'] = $_SESSION['user_id'];
            $param['added_date'] = date('Y-m-d H:i:s', time());
            $rsDtls = Table::insertData(array('tableName' => TBL_BJP_MEMBER, 'fields' => $param, 'showSql' => 'N'));
        } else {
            $param['status'] = 'A';
            $param['mp_const_id'] = '1';
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];
            $where = array('id' => $_POST['id']);
            Table::updateData(array('tableName' => TBL_BJP_MEMBER, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        }
        exit();
    }

    if($_POST['act'] == 'updateAllMembers'){
        ob_clean();
        $params = array('state_id','district_id','lg_const_id','mandal_id','ward_id','booth_id','booth_branch_id');
        foreach($params as $K => $V) {
            $param[$V] = $$V = check_input($_POST[$V]);
        }
      
        foreach(explode(',',$_POST['id']) as $key=>$val) {
        if ($_POST['id'] != '') {
            $param['status'] = 'A';
            $param['mp_const_id'] = '1';
            $param['updated_date'] = date('Y-m-d H:i:s', time());
            $param['updated_by'] = $_SESSION['user_id'];
            $where = array('id' => $val); 
           Table::updateData(array('tableName' => TBL_BJP_MEMBER, 'fields' => $param, 'where' => $where, 'showSql' => 'Y'));
        }
    }
        exit();
    }
/********* 3. STATUS UPDATE MEMBER  ********/

    if ($_POST['act'] == 'statusDataUpdate') {
        ob_clean();
        $param['status'] = $_POST['status'];
        $param['updated_date'] = date('Y-m-d H:i:s', time());
        $param['updated_by'] = $_SESSION['user_id'];
        $where = array('id' => $_POST['id']);
        Table::updateData(array('tableName' => TBL_BJP_MEMBER, 'fields' => $param, 'where' => $where, 'showSql' => 'N'));
        exit();
    }

/********* 4.VIEW MEMBER DETAILS ********/

    if($_POST['act'] == 'getmemberDistrict'){
        $param = array('tableName' => TBL_BJP_DISTRICT, 'fields' => array('*'), 'condition' => array('id' => $_POST['selected'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
        $districtList = Table::getData($param);
        echo $districtList->district_name; 
    }

    if($_POST['act'] == 'getmemberConstituency'){
        $param = array('tableName' => TBL_BJP_LG_CONST, 'fields' => array('*'), 'condition' => array('id' => $_POST['selected'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
        $constList = Table::getData($param); 
        echo $constList->lg_const_name;
    }
    if($_POST['act'] == 'getmemberMandal'){
        $param = array('tableName' => TBL_BJP_MANDAL, 'fields' => array('*'),'condition' => array('id' => $_POST['selected'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
        $mandalList = Table::getData($param);         
        echo $mandalList->mandal_name;
    }
    if($_POST['act'] == 'getmemberWard'){
        $param = array('tableName' => TBL_BJP_WARD, 'fields' => array('*'),'condition' => array('id' => $_POST['selected'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
        $wardList = Table::getData($param); 
        echo $wardList->ward_number;
    }
    if($_POST['act'] == 'getmemberBooth'){
        $param = array('tableName' => TBL_BJP_BOOTH, 'fields' => array('*'),'condition' => array('id' => $_POST['selected'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
        $boothList = Table::getData($param); 
         echo $boothList->booth_number;
    }
    if($_POST['act'] == 'getmemberBoothBranch'){
        $param = array('tableName' => TBL_BJP_BOOTH_BRANCH, 'fields' => array('*'),'condition' => array('id' => $_POST['selected'].'-INT','status'=> 'A-CHAR'), 'showSql' => 'N');
        $boothbranchList = Table::getData($param); 
         echo $boothbranchList->booth_branch_name;
    }