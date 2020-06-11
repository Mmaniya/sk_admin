<?php

class Members {
	
	        static function getMemberStatistics($filter_by,$filter_text) {
	              	$qry ="select id, count(*) total,
						sum(case when gender = 'M' then 1 else 0 end) totalMale,
						sum(case when gender = 'F' then 1 else 0 end) totalFemale,
						sum(case when gender = 'O' then 1 else 0 end) totalOthers
						from ".TBL_BJP_VOTERS_LIST." where $filter_by in($filter_text)";
				       $memberGender = dB::sExecuteSql($qry);   
				       
				                $qry ="select id, count(*) total,
						sum(case when is_verified = 'Y' then 1 else 0 end) totalVerified,
						sum(case when is_verified = 'N' then 1 else 0 end) totalnotVerified
						from ".TBL_BJP_MEMBER." where $filter_by in($filter_text)";
				       $memberVerified = dB::sExecuteSql($qry);
				       
				       $memberArr = array('total_voters'=>$memberGender->total,
				                          'total_male'=>$memberGender->totalMale,
				                          'total_female'=>$memberGender->totalFemale,
				                          'total_others'=>$memberGender->totalOthers,
				                          'total_members'=>$memberVerified->total,
				                          'total_verified'=>$memberVerified->totalVerified,
				                          'total_not_verified'=>$memberVerified->totalnotVerified);
				                          
                 return $memberArr;
	            
	        }
	
	
	        static function CheckMemberAlreadyExits($voterID) {
		    $explode = explode ('-:',$voterID);
		    $qry ="select id,member_voter_id from `".TBL_BJP_MEMBER."` where member_voter_id like '".$explode[0]."%'";
			return dB::sExecuteSql($qry);
	        } 
	
	        static function CheckMemberNumberAlreadyExits($MemberID) {
		    $qry ="select id,membership_number from `".TBL_BJP_MEMBER."` where membership_number like '".$MemberID."%'";
			return dB::sExecuteSql($qry);
	        } 
	        static function CheckAadharNumberAlreadyExits($Aadhar) {
		    $AadharNumber = str_replace('-','',$Aadhar);
		    $qry ="select id,member_aadhar_number from `".TBL_BJP_MEMBER."` where member_aadhar_number like '".$AadharNumber."%'";
			return dB::sExecuteSql($qry);
	        } 
		
	        static function GetBoothName($BoothID) {
			$qry ="select id,booth_number from `".TBL_BJP_BOOTH."` where id = '".$BoothID."'";
			return dB::sExecuteSql($qry);
			}
			
			static function GetVoterName($voterid) {
			$qry ="select id,voter_id,name from `".TBL_BJP_VOTERS_LIST."` where voter_id = '".$voterid."'";
			return dB::sExecuteSql($qry);
		    }
           
			static function GetMemberCount($Count)  {
			$qry ="select id, count(*) total,
						sum(case when member_gender = 'M' then 1 else 0 end) TotalMale,
						sum(case when member_gender = 'F' then 1 else 0 end) TotalFemale,
						sum(case when member_gender = 'O' then 1 else 0 end) TotalOthers
						from ".TBL_BJP_MEMBER;
				return dB::sExecuteSql($qry);
		    }
		
		
		    
		 static function getBoothBranchMembers($branchId)
		 {
			  $qry = "SELECT count(id) as total FROM ".TBL_BJP_MEMBER." where booth_branch_id='".$branchId."' ";  
				return dB::sExecuteSql($qry); 
		 }
		
        
		
		    static function GetLGconsName($id) 
			{
		    $sql ="SELECT `id`, `lg_const_name` FROM `".TBL_BJP_LG_CONST."` where id = '".$id."'";
			return dB::sExecuteSql($sql);
			}
			
			static function GetMPconsName($consID) 
			{
			$sql ="SELECT `id`, `bjp_mp_const_name` FROM `".TBL_BJP_MP_CONST."` where id = '".$consID."'";
			return dB::sExecuteSql($sql);
			}
						 
			static function GetState($id) 
			{
		 	$sql ="SELECT `id`, `state_name` FROM `".TBL_BJP_STATE."` where id = '".$id."'";
			return dB::sExecuteSql($sql);
			}
			
			static function GetDistrict($id) 
			{
			$sql ="SELECT `id`, `district_name` FROM `".TBL_BJP_DISTRICT."` where id = '".$id."'";
			return dB::sExecuteSql($sql);
			}
					  
			static function GetMandalName($id) 
			{
			$sql ="SELECT `id`, `mandal_name` FROM `".TBL_BJP_MANDAL."` where id = '".$id."'";
			return dB::sExecuteSql($sql);
			}
			
			static function GetboothNo($id) 
			{
			$sql ="SELECT `id`, `booth_number` FROM `".TBL_BJP_BOOTH."` where id = '".$id."'";
			return dB::sExecuteSql($sql);
			}
			static function GetboothBranchName($id) 
			{
			echo $sql ="SELECT `id`, `booth_branch_name` FROM `".TBL_BJP_BOOTH_BRANCH."` where id = '".$id."'";
			return dB::sExecuteSql($sql);
			}
			 static function GetwardNo($id) 
			{
		    $sql ="SELECT `id`, `ward_number` FROM `".TBL_BJP_WARD."` where id = '".$id."'";
			return dB::sExecuteSql($sql);
			}
    
    
            function getMemberDetails(){
                $memberId = $this->id;
		        $sql ="SELECT * FROM `".TBL_BJP_MEMBER."` where id = '".$id."'";
			    return dB::sExecuteSql($sql);                
            }

}

?>