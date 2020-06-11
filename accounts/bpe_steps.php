<?php

include "includes.php";

/*
Array
(
    [act] => step_done
    [step_id] => 2
    [done] => 0
)

*/

if($_POST['act']=='step_done') {
    $bplanId = $_POST['bplan_id'];
    $stepId = $_POST['step_id'];
    $isDone = $_POST['done'];
    if($isDone==0){
        
        
    }else{
        
        
    $param['bplan_id']=$bplanId;	
    $param['step_id']=$stepId;	    
	$param['lead_added_by']=SessionRead('USER_ID');
	$param['lead_added_date']=date('Y-m-d H:i:s',time());
	$tableObj = new Table;
	$leadDtls = $tableObj->insertData(array('tableName'=>TBL_LEADS,'fields'=>$param,'showSql'=>'N')); 
        
    }
    
}

?>