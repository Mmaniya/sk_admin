<?php
 include 'includes.php';

if($_POST['action'] == 'dynamicSearch') {
    ob_clean(); 
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = $_POST['search']['value']; // Search value
    $wardId = $_POST['wardId'];

    ## Custom Field value
    $searchByVerifyed = $_POST['searchByVerifyed'];
    $searchByBooth = $_POST['searchByBooth'];

    ## Search 
    $searchQuery = " ";
    if($searchByVerifyed != ''){
    $searchQuery .= " and (is_verified like '%".$searchByVerifyed."%' ) ";
    }
    if($searchByBooth != ''){
    $searchQuery .= " and (booth_id='".$searchByBooth."') ";
    }
    if($searchValue != ''){
    $searchQuery .= " and (member_name like '%".$searchValue."%' or 
    member_mobile like '%".$searchValue."%' or 
    membership_number like'%".$searchValue."%' ) ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($con,"select count(*) as allcount from ".TBL_BJP_MEMBER."");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($con,"select count(*) as allcount from ".TBL_BJP_MEMBER." WHERE `ward_id`=".$wardId."  ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from ".TBL_BJP_MEMBER." WHERE `ward_id`=".$wardId."".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {
        if($row['is_verified'] == 'Y'){
            $verified = '<span class="badge badge-success">YES</span>';
        }else{
            $verified = '<span class="badge badge-danger">NO</span>';
        }
    $data[] = array(
        "member_name"=>$row['member_name'],
        "member_mobile"=>$row['member_mobile'],
        "membership_number"=>$row['membership_number'],
        "is_verified"=>$verified,
        "editid"=>'<a href="javascript:void(0)" style="float:center;color:#fd7e14" data-toggle="modal" data-target=".deleteModel"  onclick="editMember('.$row['id'].')" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
            <a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".deleteModel"  onclick="deleteMember('.$row['id'].')" ><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;&nbsp;
            <a href="javascript:void(0)" style="float:center;color:green" data-toggle="modal" data-target=".deleteModel"  onclick="viewMember('.$row['id'].')" ><i class="fa fa-eye" aria-hidden="true"></i></a>'

    );
    }

    ## Response
    $response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
    );
    echo json_encode($response);

    exit();
}


?>