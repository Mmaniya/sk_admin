<?php
require("includes.php"); 

$qry = 'SELECT * FROM '.TBL_BJP_OFFICE_BEARERS.''; 
$rsOfb=dB::mExecuteSql($qry); 
if(count($rsOfb)>0) {
	foreach($rsOfb as $key=>$val) {
		 
		$sk_id = $val->sk_id;
		$booth_id = $val->booth_id;
		$param['booth_id'] = $booth_id;
		$param['updated_date'] = date('Y-m-d H:i:s',time());		
		$where= array('id'=>$sk_id); 
	 	Table::updateData(array('tableName'=>TBL_BJP_SK,'fields'=>$param,'where'=>$where,'showSql'=>'N')); 		
	}
}
?>