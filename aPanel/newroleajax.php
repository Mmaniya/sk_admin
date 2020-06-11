<!--==================================
   Name: Manikandan;
   Create: 24/5/2020;
   Update: 26/5/2020;
   Use: ADD NEW ROLE AJAX
   ====================================-->
<?php
include 'includes.php';

if($_POST['act']=='districtgetRolehierarchy'){
    ob_clean();
    $r_hierarchy = $_POST['role_hierarchy'];
    $param = array('tableName'=>TBL_BJP_ROLE,'fields'=>array('*'),'condition'=>array('role_hierarchy'=>$r_hierarchy.'-CHAR'),'showSql'=>'N','orderby'=>'position','sortby'=>'asc');  
    $roleList= Table::getData($param);
    $TotalCount = count($roleList);
    include 'rolelist.php';
    exit();
  }
  if($_POST['act']=='updateRolePostionId'){
    ob_clean();
    $r_position = $_POST['position'];
    $r_dataid = $_POST['dataid'];
    $cnt=1;
    foreach($r_position as $K=>$V) {
    $query = "UPDATE ".TBL_BJP_ROLE. " SET `position`= $cnt  WHERE `id`= $V" ;
    $cnt++;
    $officebearersList = dB::mEXecuteSql($query);
   }
    include 'rolelist.php';

    exit();
  }

  if($_POST['act'] =='inserRoleData'){
      ob_clean();
     
      $params = array('role_hierarchy','role_name','role_abbr','role_abbr','no_of_roles','role_term','role_responsibilities','position','added_by');
      foreach($params as $K=>$V) {  $param[$V]=$$V=check_input($_POST[$V]); } 
       
      if($_POST['id'] =='') {
         $param['added_date'] = date('Y-m-d H:i:s',time());		
         $param['added_by']= $_SESSION['user_id'];  
         echo $roleInsert = Table::insertData(array('tableName'=>TBL_BJP_ROLE,'fields'=>$param,'showSql'=>'N')); 
          $explode = explode('::',$roleInsert);  $roleID = $explode[2];
      }
       else { 
      $param['updated_date'] = date('Y-m-d H:i:s',time());		
      $param['updated_by']= $_SESSION['user_id'];  
      $where= array('id'=>$_POST['id']);
      echo  Table::updateData(array('tableName'=>TBL_BJP_ROLE,'fields'=>$param,'where'=>$where,'showSql'=>'Y'));
    }
    exit();
  }
  if($_POST['act'] =='statusRoleDataUpdate'){
    ob_clean();
    $param['status'] = $_POST['status'];     
    $param['updated_date'] = date('Y-m-d H:i:s',time());		
    $param['updated_by']= $_SESSION['user_id'];  
    $where= array('id'=>$_POST['id']);
    echo  Table::updateData(array('tableName'=>TBL_BJP_ROLE,'fields'=>$param,'where'=>$where,'showSql'=>'N'));
  exit();
}
?>