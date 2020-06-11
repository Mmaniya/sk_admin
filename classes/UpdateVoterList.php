<?php 
class UpdateVoterList
{
	static function GetStateName($id)
	{
		$sql ="SELECT `id`, `state_name` FROM `".TBL_BJP_STATE."` where id = '".$id."'";
		return dB::sExecuteSql($sql);
		
	}
	
	static function GetDistrictName($id)
	{
	    $sql ="SELECT `id`, `district_name` FROM `".TBL_BJP_DISTRICT."` where id = '".$id."'";
		return dB::sExecuteSql($sql);
		
	}

	static function GetLGconsName($id) 
	{
		$sql ="SELECT `id`, `lg_const_name` FROM `".TBL_BJP_LG_CONST."` where id = '".$id."'";
		return dB::sExecuteSql($sql);
	}
			

	static function GetMPconsName($id) 
	{
		$sql ="SELECT `id`, `bjp_mp_const_name` FROM `".TBL_BJP_MP_CONST."` where id = '".$id."'";
		return dB::sExecuteSql($sql);
	}
			
	static function GetMandalName($id) 
	{
		$sql ="SELECT `id`, `mandal_name` FROM `".TBL_BJP_MANDAL."` where id = '".$id."'";
		return dB::sExecuteSql($sql);
	}
	static function GetWardNumber($id) 
	{
		$sql ="SELECT `id`, `ward_number` FROM `".TBL_BJP_WARD."` where id = '".$id."'";
		return dB::sExecuteSql($sql);
	}
	
	static function GetBoothBranchName($id) 
	{
	    $sql ="SELECT `id`, `booth_branch_name` FROM `".TBL_BJP_BOOTH_BRANCH."` where id = '".$id."'";
		return dB::sExecuteSql($sql);
	}
	
	static function GetBoothNo($id) 
	{
	    $sql ="SELECT `id`, `booth_number` FROM `".TBL_BJP_BOOTH."` where id = '".$id."'";
		return dB::sExecuteSql($sql);
	}
	
	static function UnlinkVoterImage($id) 
	{
	    $sql ="SELECT `id`, `photo` FROM `".TBL_BJP_VOTERS_LIST."` where id = '".$id."'";
		return dB::sExecuteSql($sql);
	}
	
	static function SearchVoterList($quertString,$searchType)
	{
	   $sql ="SELECT `id`, `photo` FROM `".TBL_BJP_VOTERS_LIST."` where id = '".$id."'";
	   return dB::mExecuteSql($sql);
	}
	
	static function getPermissionboothList($userId)
	{
		  $sql ="SELECT id,user_id,booth_id FROM `".TBL_BJP_USER_PERMISSION."` where user_id = '".$userId."' group by booth_id";
		  return dB::mExecuteSql($sql);
		   
            }
			
   static function getUserPermissionList($userId) {
	 $sql ="SELECT *  FROM `".TBL_BJP_USER_PERMISSION."` where user_id = '".$userId."' group by booth_id";
		  return dB::mExecuteSql($sql);
		  }
}

?>