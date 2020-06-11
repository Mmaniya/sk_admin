<?

include "includes.php";
ini_set('display_errors');

		$clientParamArr = array('quotation_id'=>1,'transaction_id'=>12312);
		$clientObj = new Clients();
		$clientObj->param = $clientParamArr;
		$clientObj->addNewClient();

?>