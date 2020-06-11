<?php
// tables include
require_once("../secure_includes/Config.tbl.inc.php");
// configuration
require_once("../secure_config/db_config.php");
// load basic support methods
require_once("../secure_includes/mail_functions.php");
require_once("../secure_includes/functions.php");
require_once("../secure_includes/pagination.php");
require_once("../secure_includes/Session.php");
// database connection
require_once("../secure_classes/DatabaseConnection.php");
require_once("../secure_classes/dB.php");

//classes
require_once("../secure_config/config.php");
require_once("../secure_classes/Table.php");
require_once("../secure_classes/Users.php");
require_once('../phpMailer/class.phpmailer.php');

require_once("../secure_classes/ServiceCategory.php");
require_once("../secure_classes/EmployeeCategory.php");
require_once("../secure_classes/Leads.php");
require_once("../secure_classes/Discount.php");
require_once("../secure_classes/PaypalPro.class.php");
require_once("../secure_classes/Packages.php");
require_once("../secure_classes/Quotation.php");
require_once("../secure_classes/Clients.php");
require_once("../secure_classes/Invoice.php");
require_once("../secure_classes/Form.class.php");
require_once("../secure_classes/Tickets.php");
session_start();
ob_start();
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
?>