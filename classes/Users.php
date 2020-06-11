<?

class Users {
	
	static function checkUserId($username) {
	   $admin_qry ="select * from `".TBL_USERS."` where username = '".$username."'";
			$rsUser = dB::sExecuteSql($admin_qry); 
			if($rsUser->id>0) return 1;
			return 0;
		}
	
	static function checkPasswordStrength($password) {
			if( strlen($pwd) < 8 ) { $error .= "Password too short! Should be atleast 8 characters";}
			if( strlen($pwd) > 20 ) { $error .= "Password too long!";	}
			if( !preg_match("#[0-9]+#", $pwd) ) {$error .= "Password must include at least one number!";}
			if( !preg_match("#[a-z]+#", $pwd) ) {$error .= "Password must include at least one letter!";}
			if( !preg_match("#[A-Z]+#", $pwd) ) {$error .= "Password must include at least one CAPS!";}
			if( !preg_match("#\W+#", $pwd) ) {$error .= "Password must include at least one symbol!";}
			if($error){	return  "Password validation failure(your choice is weak): $error"; 	} else {	return "Your password is strong.";	}
		}
	   
	static function checkCredentials($username,$password) {
	   	$usernameExists = Users::checkUserId($username);
	       if($usernameExists==1) {
			        $admin_qry ="select * from `".TBL_USERS."` where username = '".$username."' and password='".$password."'";
				$rsUser = dB::sExecuteSql($admin_qry);
				
				if($rsUser->id>0) {
					 if($rsUser->user_status=='A') $returnArr = array("Success",$rsUser); 
					 else $returnArr = array("User is not active.Please contact webmaster"); 
			} else {	$returnArr = array("Invalid Password"); }
			} else
			$returnArr = array("Invalid UserName");
		  	return $returnArr;
	   }
	   
	static function getAllUsers($type='') {
			if($type!='') $sub_qry = " and user_type='".$type."'";
			$admin_qry ="select * from `".TBL_USERS.$sub_qry;
			return $rsUser = dB::mExecuteSql($admin_qry);
	   }
	
	static function getUsers($params=array()) {
		
		if(count($params)>0) foreach($params as $K=>$V){ 
		  $tempArr =explode('-',$V);
		   $$K=$V;
		  if(count($tempArr)==2) {
		  $field = $K;
		  $fieldval = $tempArr[0];
		  $fieldType = $tempArr[1];
		  if($fieldType=='INT' || $fieldType=='' || $fieldType=='ENUM' || $fieldType=='CHAR') $sub_qry[]="`$field`=".$fieldval;
		  if($fieldType=='STRING') $sub_qry[]="`$field` like '%".$fieldval."%'";
		  if($fieldType=='DATE') $sub_qry[]="`$field` = '".date_format('Y-m-d',$fieldval)."'";
		  }
		}
		if($orderby!='') { 	if($sortby=='') $sortby='ASC'; 	$sort_qry = " order by ".$orderby.' '.$sortby; 	}
		if(count($sub_qry)>0) $subqry= " where ".implode(' and ',$sub_qry);
		if(count($fieldsArr)==0) $fields='*'; else $fields=implode(',',$fieldsArr);
		$query="select ".$fields." from ".TBL_USERS." $subqry $sort_qry";
		if($id=='')	return dB::mExecuteSql($query);
		return dB::sExecuteSql($query);
	}
	
	
	static function insertUser($params=array()) {
		if(count($params)>0) foreach($params as $K=>$V){ if($V!='') {
			$$K=$V; 
			$fieldArr[]=$K;} 
		}
		foreach($fieldArr as $K=>$V) $fieldVal[] = "'".$$V."'";
		$userId=0;
		if($email!='-')	$userId = Users::userAlreadyExists($email);
		if($userId>0) {
		  return "Error1::User Already Exists::".$userId;  	
		} else {
			 $query = "insert into ".TBL_USERS."( ".implode(',',$fieldArr).",added_date) 
							   values (".implode(',',$fieldVal).",'".date('Y-m-d H:i:s',time())."')";
			$userId= dB::insertSql($query);		if($userId>0)	{ 
			return "Success::Successfully added::".$userId;
		}
		else return "Error2::Something is wrong with database connection.";
		}
	}
	
	
	static function userAlreadyExists($email_address) {
	  $rsUser = Users::getUsers(array('email_address'=>$email_address.'-STRING'));
	  if(count($rsUser)>0) return $rsUser[0]->id;
	  return 0;	
	}
	
	
	static function updateUser($params=array()) {
		if(count($params)>0) foreach($params as $K=>$V){ $$K=$V; if($K!='company_id') $updateFields[]=$K; }
		foreach($updateFields as $K=>$V) $subQry[] = "`".$V."`='".$$V."'";
		$uptFields = implode(',',$subQry);				 
		 $query = "update ".TBL_USERS." set ".$uptFields." where id =$company_id ";
		$affectedRows = dB::updateSql($query);
		if($affectedRows>0)	return "Success::Successfully updated::".$company_id;
		else return "Success::".$affectedRows." rows affected::".$company_id;
	}
	
	static function SetStatus($userId,$status) {
		 $query = "update ".TBL_USERS." set `status`='$status'
												 where id =$userId ";
		$affectedRows = dB::updateSql($query);
	}


}


?>