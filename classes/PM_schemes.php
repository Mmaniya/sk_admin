<?php

Class PM_schemes {
	
	static function Scheme_files($id)
	{  
		$qry = "select * from ".TBL_BJP_PM_SCHEMES_FILE." where scheme_id=$id";
		return dB::mExecuteSql($qry);
	}
	
	
	
}