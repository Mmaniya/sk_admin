<?php
// tables include
ini_set('display_errors',0);
require_once("../../includes/Config.tbl.inc.php");
// configuration
require_once("../../config/db_config.php");

// load basic support methods
require_once("../../includes/mail_functions.php");

require_once("../../includes/functions.php");
require_once("../../includes/pagination.php");
require_once("../../includes/Session.php");
//require_once("../../includes/text_message.php");
 
// database connection
require_once("../../classes/DatabaseConnection.php");
require_once("../../classes/dB.php");

//classes
require_once("../../config/config.php");
require_once("../../classes/Table.php");
require_once("../../classes/Users.php");
require_once('../../phpMailer/class.phpmailer.php');

   
 
session_start();
ob_start();
ini_set('display_errors',0);
date_default_timezone_set('America/New_York');

?>