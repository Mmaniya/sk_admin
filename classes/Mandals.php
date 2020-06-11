<?php

class Mandals {
	
	static function getTotalMandalsCount()
			{
			 $sql ="SELECT count(id) as total FROM `".TBL_BJP_MANDAL."`";
			 return dB::sExecuteSql($sql);
			}
	


    public function getMandalNameById() {
        $mandalId = $this->id;
        $sql ="SELECT mandal_nameFROM `".TBL_BJP_MANDAL."` where id =".$mandalId;
		$mandalRs = dB::sExecuteSql($sql);
        return $mandalRs->mandal_name;
    }
}

/*
$mandalObj = new Mandals();
$mandalObj->id = 1;
$mandalName = $mandalObj->getMandalNameById();
*/
	?>