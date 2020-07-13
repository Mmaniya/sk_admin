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
    $searchBydistID = $_POST['searchBydistID'];
   

    ## Custom Field value
    $searchByConstituency   = $_POST['searchByConstituency'];
    $searchByMandal         = $_POST['searchByMandal'];
    $searchByWard           = $_POST['searchByWard'];    
    $searchByBooth          = $_POST['searchByBooth'];
    $searchByBoothBranch    = $_POST['searchByBoothBranch'];
    $searchByVerifyed       = $_POST['searchByVerifyed'];
    $searchByWhatsappLink   = $_POST['searchByWhatsappLink'];
    $searchByCommunity      = $_POST['searchByCommunity'];
    $searchByGender         = $_POST['searchByGender'];
    $searchByAge            = $_POST['searchByAge'];

    ## Search 
    $searchQuery = " ";
    
    if($searchByConstituency != ''){
        $searchQuery .= " and (lg_const_id='".$searchByConstituency."') ";
    }
    if($searchByMandal != ''){
        $searchQuery .= " and (mandal_id='".$searchByMandal."') ";
    }
    if($searchByWard != ''){
        $searchQuery .= " and (ward_id='".$searchByWard."') ";
    }
    if($searchByBooth != ''){
        $searchQuery .= " and (booth_id='".$searchByBooth."') ";
    }
    if($searchByBoothBranch != ''){
        $searchQuery .= " and (booth_branch_id='".$searchByBoothBranch."') ";
    }
    if($searchByVerifyed != ''){
        $searchQuery .= " and (is_verified = '".$searchByVerifyed."' ) ";
    }
    if($searchByWhatsappLink != ''){
        $searchQuery .= " and (is_wag_link_sent = '".$searchByWhatsappLink."' ) ";
    }
    if($searchByCommunity != ''){
        $searchQuery .= " and (member_community ='".$searchByCommunity."' ) ";
    }
    if($searchByGender != ''){
        $searchQuery .= " and (member_gender ='".$searchByGender."' ) ";
    }   
    if($searchByAge != ''){
        $searchQuery .= " and (member_age ='".$searchByAge."' ) ";
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
    $sel = mysqli_query($con,"select count(*) as allcount from ".TBL_BJP_MEMBER." WHERE `district_id`=".$searchBydistID."  ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    // $empQuery = "select * from ".TBL_BJP_MEMBER." WHERE `district_id`=".$searchBydistID."".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empQuery = "select * from ".TBL_BJP_MEMBER." WHERE `district_id`=".$searchBydistID."".$searchQuery." order by member_name  ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($con, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {
        if($row['is_verified'] == 'Y'){
            $verified = '<span class="badge badge-success">YES</span>';
        }else{
            $verified = '<span class="badge badge-danger">NO</span>';
        }
    $data[] = array(
        $row['id'],
        $row['member_name'],
        $row['member_mobile'],
        $row['membership_number'],
        $verified,
        $action = '<a href="javascript:void(0)" style="float:center;color:#fd7e14" data-toggle="modal" data-target=".memberModel"  onclick="editMember('.$row['id'].')" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
            <a href="javascript:void(0)" style="float:center;color:red" data-toggle="modal" data-target=".memberModel"  onclick="deleteMember('.$row['id'].')" ><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;&nbsp;
            <a href="javascript:void(0)" style="float:center;color:green" data-toggle="modal" data-target=".memberModel"  onclick="viewMember('.$row['id'].')" ><i class="fa fa-eye" aria-hidden="true"></i></a>',

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