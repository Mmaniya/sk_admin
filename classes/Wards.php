<?php

class Wards {
	
	static function checkWardNumber($wardNumber,$districtId='') {
			echo $admin_qry ="select * from `".TBL_WARDS."` where ward_number = '".$wardNumber."'";
			if($districtId!='') $admin_qry.=' and district_id='.$districtId;
			$rsUser = dB::sExecuteSql($admin_qry);
			if($rsUser->id>0) return 1;
			return 0;
		}
	
	
	   
	
	static function getAllWards($districtId='') {
			if($districtId!='') $sub_qry = " and district_id='".$districtId."'";
			echo $admin_qry ="select a.*,b.district_name, b.state from `".TBL_WARDS."` a, ".TBL_DISTRICT." b WHERE a.district_id = b.id ".$sub_qry;
			return dB::mExecuteSql($admin_qry);
	   }
	
	static function getWardDetails($wardId) {
		
		$admin_qry ="select a.*,b.district_name, b.state from `".TBL_WARDS."` a, ".TBL_DISTRCT." b WHERE a.district_id = b.id ";
		return dB::mExecuteSql($admin_qry);
	}
	
	       static function GetwardNo($id) 
			{
		    $sql ="SELECT `id`, `ward_number` FROM `".TBL_BJP_WARD."` where id = '".$id."'";
			return dB::sExecuteSql($sql);
			}
			
			static function getTotalWardCount()
			{
			 $sql ="SELECT count(id) as total FROM `".TBL_BJP_WARD."`";
			 return dB::sExecuteSql($sql);
			}


}


?>