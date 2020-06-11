<?php

class VoterList {
    
    
      static function GetVoterStatistics($filter_by,$filter_id,$user_id) {
  
    $qry ="select id, count(*) total,
					sum(case when gender = 'M' then 1 else 0 end) TotalMale,
					sum(case when gender = 'F' then 1 else 0 end) TotalFemale,
					sum(case when gender = 'O' then 1 else 0 end) TotalOthers
					from ".TBL_BJP_VOTERS_LIST." where deleted_status='No' and ".$filter_by.'='.$filter_id;
  $genderCount = dB::sExecuteSql($qry);  
			
           
            
  $qry ="select count(id) as total from ".TBL_BJP_VOTERS_LIST." where deleted_status='No' and is_verified='Y' and ".$filter_by.'='.$filter_id;
            $rsVerifyVoter = dB::sExecuteSql($qry);
            
            
  $qry ="select count(id) as total from ".TBL_BJP_VOTERS_LIST." where deleted_status='No' and is_member='Y' and ".$filter_by.'='.$filter_id;
            $rsMemberCount = dB::sExecuteSql($qry);
          	
          	
   $qry ="select count(id) as total from ".TBL_BJP_NEW_VOTER_LIST." where deleted_status='No' and ".$filter_by.'='.$filter_id;
    $rsNewVoterCount = dB::sExecuteSql($qry);  
    
    
     $qry ="select count(id) as total from ".TBL_BJP_VOTERS_LIST." where deleted_status='No' and relationship_id not in(0)  and ".$filter_by.'='.$filter_id." group by relationship_id";
    $rsFamilyCount = dB::sExecuteSql($qry);
    $familyCount = $rsFamilyCount->total;
    if($familyCount=='') {$familyCount=0;  }
    
    
        $qry ="select count(id) as total from ".TBL_BJP_MEMBER_VOTER_SCHEME." where  `voter_list_id` in(select id from ".TBL_BJP_VOTERS_LIST." where ".$filter_by.'='.$filter_id.")";
    $rsSchemeTakenCount = dB::sExecuteSql($qry);
    
    $schemesCount = $rsSchemeTakenCount->total;
    if($schemesCount=='') {$schemesCount=0;  }
     
    
    
    if($filter_by=='ward_id') {
        
   $qry ="SELECT * FROM  ".TBL_BJP_BOOTH." WHERE $filter_by='$filter_id' order by booth_number asc";
      $rsBoothDetails = dB::mExecuteSql($qry); 
      if(count($rsBoothDetails)>0) {
      foreach($rsBoothDetails as $key=>$val) {
          $boothBranchList=array();
          $boothId = $val->id;
  
   $qry = "SELECT * FROM ".TBL_BJP_USER_PERMISSION."  WHERE `user_id` = ".$user_id." and (booth_id=".$boothId.") and status='A'"; 
	  $boothPermissionCheck =  dB::sExecuteSql($qry);  
	  $accessBooth='N';
	  if(count($boothPermissionCheck)>0) { $accessBooth = 'Y'; }
          
          
   $qry ="SELECT * FROM  ".TBL_BJP_BOOTH_BRANCH." WHERE booth_id='$boothId' order by booth_branch_name asc";
      $rsBoothBranch = dB::mExecuteSql($qry); 
      if(count($rsBoothBranch)>0)
      foreach($rsBoothBranch as $K=>$V) {
          
   $qry = "SELECT * FROM ".TBL_BJP_USER_PERMISSION."  WHERE booth_id =$boothId and `user_id` = ".$user_id." and (booth_branch_id=".$V->id." or booth_branch_id=0) and     status='A'"; 
	  $userCheck =  dB::mExecuteSql($qry);  
	  $accessBoothBranch='N';
	  if(count($userCheck)>0) { $accessBoothBranch = 'Y'; }
	  
	  $branchStatistics = VoterList::getStatisbyid('booth_branch_id',$V->id);
          
    $boothBranchList[] = array('id'=>$V->id,
                               "booth_branch_name"=>$V->booth_branch_name,
                               'booth_branch_access'=>$accessBoothBranch,
                               'statistics'=>$branchStatistics);
      }
   
    $boothStatistics = VoterList::getStatisbyid('booth_id',$val->id);
    
    $boothListDtls[] = array('id'=>$val->id,
                             "booth_number"=>$val->booth_number,
                             "booth_access"=>$accessBooth,
                             'statistics'=>$branchStatistics,
                             "booth_branch"=>$boothBranchList);
          
      }
      }
        
    }
    
    
    
    
    if($filter_by=='booth_id') {
        
  $boothId = $filter_id;
          
   $accessBooth = 'Y';  
   
   $qry ="SELECT * FROM  ".TBL_BJP_BOOTH." WHERE id=".$boothId;
    $rsBoothDetails = dB::sExecuteSql($qry); 
          
          
   $qry ="SELECT * FROM  ".TBL_BJP_BOOTH_BRANCH." WHERE booth_id='$boothId' order by booth_branch_name asc";
      $rsBoothBranch = dB::mExecuteSql($qry); 
      if(count($rsBoothBranch)>0)
      foreach($rsBoothBranch as $K=>$V) {
          
    $qry = "SELECT * FROM ".TBL_BJP_USER_PERMISSION."  WHERE booth_id =$boothId and `user_id` = ".$user_id." and (booth_branch_id=".$V->id." or booth_branch_id=0) and     status='A'";  
	  $userCheck =  dB::mExecuteSql($qry);  
	  $accessBoothBranch='N';
	  if(count($userCheck)>0) { $accessBoothBranch = 'Y'; }
	  
	  $branchStatistics = VoterList::getStatisbyid('booth_branch_id',$V->id);
          
    $boothBranchList[] = array('id'=>$V->id,
                               "booth_branch_name"=>$V->booth_branch_name,
                               'booth_branch_access'=>$accessBoothBranch,
                               'statistics'=>$branchStatistics);
      }
   
    $boothStatistics = VoterList::getStatisbyid('booth_id',$boothId);
    
    $boothListDtls[] = array('id'=>$rsBoothDetails->id,
                             "booth_number"=>$rsBoothDetails->booth_number,
                             "booth_access"=>$accessBooth,
                             'statistics'=>$boothStatistics,
                             "booth_branch"=>$boothBranchList);
          
       
      }
      
      
      
      
      if($filter_by=='booth_branch_id') {
       
  $boothBranchId = $filter_id;
          
   $accessBooth = 'Y';  
  
          
     $qry ="SELECT * FROM  ".TBL_BJP_BOOTH_BRANCH." WHERE id='$boothBranchId' order by booth_branch_name asc";
      $rsBoothBranch = dB::sExecuteSql($qry); 
    
       
          
    $accessBoothBranch = 'Y';  
    
	  $branchStatistics = VoterList::getStatisbyid('booth_branch_id',$rsBoothBranch->id);
            
    $boothBranchList[] = array('id'=>$rsBoothBranch->id,
                               "booth_branch_name"=>$rsBoothBranch->booth_branch_name,
                               'booth_branch_access'=>$accessBoothBranch,
                               'statistics'=>$branchStatistics);
     
   
    $boothStatistics = VoterList::getStatisbyid('booth_branch_id',$boothBranchId);
    
    $qry ="SELECT * FROM  ".TBL_BJP_BOOTH." WHERE id=".$rsBoothBranch->booth_id;
    $rsBoothDetails = dB::sExecuteSql($qry); 
    
    $qry ="select id,voter_serial_number,voter_id,name,relationship,relation_name,relationship_id,address,current_address,current_booth,current_booth_branch_id,age,gender,phone_number,aadhar_number,is_verified,is_member,membership_number from `".TBL_BJP_VOTERS_LIST."` where  booth_branch_id=$boothBranchId order by voter_serial_number asc";
     $rsVoterDetails = dB::mExecuteSql($qry);
    
    $boothListDtls[] = array('id'=>$rsBoothDetails->id,
                             "booth_number"=>$rsBoothDetails->booth_number,
                             "booth_access"=>$accessBooth,
                             'statistics'=>$branchStatistics,
                             "booth_branch"=>$boothBranchList,
                             'voter_list'=>$rsVoterDetails);
          
       
      }
      
        
    
    
    
    
    $resultArr = array('total_voter'=>$genderCount->total,
                       'total_male'=>$genderCount->TotalMale,
                       'total_female'=>$genderCount->TotalFemale,
                       'total_verified_voter'=>$rsVerifyVoter->total,
                       'total_member'=>$rsMemberCount->total,
                       'total_new_voter'=>$rsNewVoterCount->total,
                       'total_family'=>$familyCount,
                       'total_schemes_taken'=>$schemesCount,
                       "booth_data"=>$boothListDtls); 
    return $resultArr;
          
      }
      
      
      
      
      
      
      
      
  	 static function getStatisbyid($filter_by,$filter_id)
			 {    
      
       $qry ="select id, count(*) total,
					sum(case when gender = 'M' then 1 else 0 end) TotalMale,
					sum(case when gender = 'F' then 1 else 0 end) TotalFemale,
					sum(case when gender = 'O' then 1 else 0 end) TotalOthers
					from ".TBL_BJP_VOTERS_LIST." where deleted_status='No' and ".$filter_by.'='.$filter_id;
  $genderCount = dB::sExecuteSql($qry);  
			
           
            
  $qry ="select count(id) as total from ".TBL_BJP_VOTERS_LIST." where deleted_status='No' and is_verified='Y' and ".$filter_by.'='.$filter_id;
            $rsVerifyVoter = dB::sExecuteSql($qry);
            
            
  $qry ="select count(id) as total from ".TBL_BJP_VOTERS_LIST." where deleted_status='No' and is_member='Y' and ".$filter_by.'='.$filter_id;
            $rsMemberCount = dB::sExecuteSql($qry);
          	
          	
   $qry ="select count(id) as total from ".TBL_BJP_NEW_VOTER_LIST." where deleted_status='No' and ".$filter_by.'='.$filter_id;
    $rsNewVoterCount = dB::sExecuteSql($qry);
    
       $qry ="select count(id) as total from ".TBL_BJP_VOTERS_LIST." where deleted_status='No' and relationship_id not in(0)  and ".$filter_by.'='.$filter_id." group by relationship_id";
    $rsFamilyCount = dB::sExecuteSql($qry);
    $familyCount = $rsFamilyCount->total;
    if($familyCount=='') {$familyCount=0;  }
    
    
          $qry ="select count(id) as total from ".TBL_BJP_MEMBER_VOTER_SCHEME." where  `voter_list_id` in(select id from ".TBL_BJP_VOTERS_LIST." where ".$filter_by.'='.$filter_id.")";
    $rsSchemeTakenCount = dB::sExecuteSql($qry);
    
    $schemesCount = $rsSchemeTakenCount->total;
    if($schemesCount=='') {$schemesCount=0;  }
    
    
    $resultArr = array('total_voter'=>$genderCount->total,
                       'total_male'=>$genderCount->TotalMale,
                       'total_female'=>$genderCount->TotalFemale,
                       'total_verified_voter'=>$rsVerifyVoter->total,
                       'total_member'=>$rsMemberCount->total,
                       'total_new_voter'=>$rsNewVoterCount->total,
                       'total_family'=>$familyCount,
                       'total_schemes_taken'=>$schemesCount); 
                       
                       return $resultArr;
    
			 }
    
    
    
    
	
	      	 static function GetVoterListCount($Count)
			 {
		    $qry ="select id, count(*) total,
					sum(case when gender = 'M' then 1 else 0 end) TotalMale,
					sum(case when gender = 'F' then 1 else 0 end) TotalFemale,
					sum(case when gender = 'O' then 1 else 0 end) TotalOthers
					from ".TBL_BJP_VOTERS_LIST;
			return dB::sExecuteSql($qry);
			 }
  
			static function CheckVoterIDAlreadyExits($voterID) 
			{
			$qry ="select count(id) as total from `".TBL_BJP_VOTERS_LIST."` where voter_id like '".$voterID."%'";
			return dB::sExecuteSql($qry);
	        } 
			
			
			
	      	 static function GetBoothBranchCount($boothBranchId)
			 {
		         $qry ="select id, count(*) total,
					sum(case when gender = 'M' then 1 else 0 end) TotalMale,
					sum(case when gender = 'F' then 1 else 0 end) TotalFemale,
					sum(case when gender = 'O' then 1 else 0 end) TotalOthers
					from ".TBL_BJP_VOTERS_LIST." where booth_branch_id=".$boothBranchId."";
			   return dB::sExecuteSql($qry);
			 }
			 
			  static function GetBoothBranchMemberCount($boothBranchId)
			 { $qry ="select count(id) as total from ".TBL_BJP_MEMBER." where booth_branch_id=".$boothBranchId."";
			   return dB::sExecuteSql($qry);
			 }
			 
			  static function GetBranchNewVoterCount($boothBranchId)
			 { $qry ="select count(id) as total from ".TBL_BJP_NEW_VOTER_LIST." where booth_branch_id=".$boothBranchId."";
			   return dB::sExecuteSql($qry);
			 }
			 
			  static function GetBranchVerifyCount($boothBranchId)
			 { $qry ="select count(id) as total from ".TBL_BJP_VOTERS_LIST." where booth_branch_id=".$boothBranchId." and is_verified='Y'";
			   return dB::sExecuteSql($qry);
			 }
			 
			 
			 static function GetBoothMemberCount($boothId)
			 {   $qry ="select count(id) as total from ".TBL_BJP_MEMBER." where booth_id=".$boothId."";
			   return dB::sExecuteSql($qry);
			 }
			 
			 
			 static function getBoothList($userId) {
				 
			    $qry = "SELECT  id,user_id,booth_id  FROM ".TBL_BJP_USER_PERMISSION." WHERE user_id =".$userId." group by booth_id";  
				return dB::mExecuteSql($qry);
				
			 }
			 
			 static function getUsersPermissionBooth($userId)
			 {
				 $qry = "SELECT * FROM ".TBL_BJP_USER_PERMISSION."  WHERE `user_id` = ".$userId." group by booth_id"; 
				 return dB::mExecuteSql($qry);
				 
			 }
			 
			 static function getNewVotersBothCount($userId,$branchId,$fromDate,$toDate)
			 {   
			     if($fromDate!='') {
					$from = date('Y-m-d H:i:s',strtotime($fromDate));
					$to = date('Y-m-d',strtotime($toDate));
					$todates = $to.' 23:59:59';
 					$date = "and added_date between '".$from."' and '".$todates ."'"; 
					 }
			 
				if($userId!='') { $addedBy = "`added_by` = ".$userId." and"; }
				$qry = "SELECT  count(id) as total FROM ".TBL_BJP_NEW_VOTER_LIST."  WHERE  ".$addedBy." booth_branch_id = ".$branchId." ".$date.""; 
				return dB::sExecuteSql($qry); 
				}
			 
			  static function getNewBoothBranchesVotersCount($branchId)
			 {
				 $qry = "SELECT  count(id) as total FROM ".TBL_BJP_NEW_VOTER_LIST."  WHERE   booth_branch_id = ".$branchId.""; 
				 return dB::mExecuteSql($qry); 
			 }
			 
			 
			 static function getNewMembersCount($userId,$branchId,$fromDate,$toDate)
			 {
				if($fromDate!='') 
				{
					$from = date('Y-m-d H:i:s',strtotime($fromDate));
					$to = date('Y-m-d',strtotime($toDate));
					$todates = $to.' 23:59:59';
				   $date = "and added_date between '".$from."' and '".$todates ."'"; 

					}
				  if($userId!='') { $addedBy = "`added_by` = ".$userId." and"; }
			   $qry = "SELECT count(id) as total FROM ".TBL_BJP_MEMBER."  WHERE  ".$addedBy." booth_branch_id = ".$branchId." and membership_number ='0' ".$date.""; 
				return dB::sExecuteSql($qry); 
			 }
			 
			 static function getUpdatedVoterListCount($userId,$branchId,$fromDate,$toDate)
			 {     if($fromDate!='') 
			      {
					  $from = date('Y-m-d H:i:s',strtotime($fromDate));
					$to = date('Y-m-d',strtotime($toDate));
					$todates = $to.' 23:59:59';
					$date = "and updated_date between '".$from."' and '".$todates ."'"; 
					 }
			          $updatedBy = "updated_by!=0 and";
			       if($userId!='') { $updatedBy = "updated_by = ".$userId." and"; }
				 $qry = "SELECT count(id) as total FROM ".TBL_BJP_VOTERS_LIST."  WHERE  ".$updatedBy." booth_branch_id = ".$branchId." ".$date.""; 
				 return dB::sExecuteSql($qry); 
			 }
			 
			 static function getUsersBoothDtls($userId,$name,$relationName,$voterId)
			 {
				  
				// $qry = "SELECT * FROM ".TBL_BJP_USER_PERMISSION."  WHERE `user_id` = ".$userId." group by booth_id";
				 //$rsUsersDtls = dB::mExecuteSql($qry); 
				 $rsUsersDtls = VoterList::getUsersPermissionBooth($userId);
				 foreach($rsUsersDtls as $key=>$val)
				 {  $usersBoothId[] = $val->booth_id; }  
				 
				  $boothId =  implode(',',$usersBoothId);
				 				 				   
			     $query ="select * from `".TBL_BJP_VOTERS_LIST."` where booth_id in(".$boothId.") and name like '%".$name."%' and relation_name like  '%".$relationName."%' and voter_id like '%".$voterId."%'"; 
				 return dB::mExecuteSql($query);
			
			 }
			 
			  static function getBoothBranchList($boothId)
			 {
				 $qry = "SELECT id,booth_branch_name,booth_id FROM ".TBL_BJP_BOOTH_BRANCH."  WHERE  booth_id = ".$boothId." ";   
				 return dB::mExecuteSql($qry); 
			 }
			 
			 static function getVoterDetails($id)
			 {
				 $qry = "SELECT * FROM ".TBL_BJP_VOTERS_LIST."  WHERE  id = ".$id."";   
				 return dB::sExecuteSql($qry); 
			 }
			 
			  static function getUsersDetails($id)
			 {
				 $qry = "SELECT * FROM ".TBL_USERS."  WHERE  id = ".$id."";   
				 return dB::sExecuteSql($qry); 
			 }
			 
			 static function getUserPermissionBooth($userId)
			 {
				    $qry = "SELECT id,booth_id,booth_branch_id FROM ".TBL_BJP_USER_PERMISSION." where user_id =".$userId." group by booth_id";   
				    return dB::mExecuteSql($qry); 
			 }
			 
			 static function getAllUserPermissionBooth()
			 {
				    $qry = "SELECT id,booth_id,booth_branch_id FROM ".TBL_BJP_USER_PERMISSION."  group by booth_id";   
				    return dB::mExecuteSql($qry); 
			 }
			 
			 
			 static function showUpdatedVoterList($userId,$branchId,$fromdate,$todate) 
			 {
				  $updatedBy = 'updated_by!=0 and ';
				 if($userId!='') { $updatedBy = 'updated_by ='.$userId.' and '; }
				  if($fromdate!='')   {
				    $from =  date('Y-m-d',$fromdate);  
					$to = date('Y-m-d',$todate); 
					$todates = $to.' 23:59:59'; $fromdates = $from.' 00:00:00';
					$date = "and updated_date between '".$fromdates."' and '".$todates ."'";   
						}
				   $qry = "SELECT * FROM ".TBL_BJP_VOTERS_LIST."  WHERE   ".$updatedBy." booth_branch_id=".$branchId." ".$date."";   
				  return dB::mExecuteSql($qry); 
				 
			 }
			 
			 static function showNewMemberList($userId,$branchId,$fromdate,$todate)
			 {   
			     if($userId!='') { $addedBy = 'and added_by ='.$userId.''; }
				 if($fromdate!='')   {
				    $from =  date('Y-m-d',$fromdate);  
					$to = date('Y-m-d',$todate); 
					$todates = $to.' 23:59:59'; $fromdates = $from.' 00:00:00';
					$date = "and added_date between '".$fromdates."' and '".$todates ."'";   
						}
				 
			        $qry = "SELECT * FROM ".TBL_BJP_MEMBER." where membership_number='0' ".$addedBy." and booth_branch_id='".$branchId."' ".$date."";  
				    return dB::mExecuteSql($qry); 
				 }
		 
		 
		    static function getVotersRelativeDetails($relationshipId,$voterListId)
			{    
			    /*
			     $relationId = 'relationship_id = '.$voterListId;
			        $qry = "SELECT * FROM ".TBL_BJP_VOTERS_LIST."  WHERE  ".$relationId." and deleted_status='No'";  
				return dB::mExecuteSql($qry); */
				
				 $relationId = '(id = '.$voterListId.' or relationship_id='.$voterListId.')';
			   if($relationshipId!=0) { $relationId = 'id = '.$relationshipId.' or relationship_id = '.$relationshipId.'';  }
			  
			//  $relationId = 'relationship_id='.$voterListId;
			            $qry = "SELECT * FROM ".TBL_BJP_VOTERS_LIST."  WHERE  ".$relationId." order by relationship_id asc";      
				return dB::mExecuteSql($qry); 
				
			}
		 
		 
		 static function getAppliedSchemesDetails()
		 {
			  $qry = "SELECT * FROM ".TBL_BJP_MEMBER_VOTER_SCHEME." order by id desc";  
				return dB::mExecuteSql($qry); 
		 }
		 
		 static function getMembersDetails()
		 {
			  $qry = "SELECT * FROM ".TBL_BJP_MEMBER." where membership_number!=0 order by id desc";  
				return dB::mExecuteSql($qry); 
		 }
		 
		 
		   static function getDistrictCount()
			 {
				    $qry = "SELECT count(id) as total FROM ".TBL_BJP_DISTRICT."";   
				    return dB::sExecuteSql($qry); 
			 }
			 
			  static function getMpConstCount()
			 {
				    $qry = "SELECT count(id) as total FROM ".TBL_BJP_MP_CONST."";   
				    return dB::sExecuteSql($qry); 
			 }
			 
			 static function getLgConstCount()
			 {
				    $qry = "SELECT count(id) as total FROM ".TBL_BJP_LG_CONST."";   
				    return dB::sExecuteSql($qry); 
			 }
			 static function getMandalsCount()
			 {
				    $qry = "SELECT count(id) as total FROM ".TBL_BJP_MANDAL."";   
				    return dB::sExecuteSql($qry); 
			 }
			 
			  static function getWardsCount()
			 {
				    $qry = "SELECT count(id) as total FROM ".TBL_BJP_WARD."";   
				    return dB::sExecuteSql($qry); 
			 }
			 
			 static function getBoothCount()
			 {
				    $qry = "SELECT count(id) as total FROM ".TBL_BJP_BOOTH."";   
				    return dB::sExecuteSql($qry); 
			 }
			 
			  static function getUpdatedTableDtls($tableName,$id)
			 {
				    $qry = "SELECT * FROM  ".$tableName." where id=".$id." ";   
				    return dB::sExecuteSql($qry); 
			 }
			 
			  
			 
}


?>