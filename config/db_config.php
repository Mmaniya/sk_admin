<?

$dev_server = TRUE;
define("LOCAL", true);
session_start();
if ($dev_server) {

    // Dev Database credentials
    define("BA_DBHOST", "localhost");
    define("BA_DBUSER", "root");
    define("BA_DBPASSWORD", "");
    define("BA_DBNAME", "sk_admin");
   
   // DB connection 
   $con=mysqli_connect(BA_DBHOST,BA_DBUSER,BA_DBPASSWORD,BA_DBNAME);
    //Constants
    define ('BASE_URL', 'http://localhost/bjp_sk/App/');
    //define ('BASE_URL', 'https://coimbatorebjp.com/App/');
	define ('BASE_ADMIN_URL', 'http://192.168.1.135/68ward/secure/');
    define ('ERROR_EMAIL_ADDRESS', 'kavitharjn@gmail.com');
	define ("SUBDIR", "68ward/");

} else {
	
    // Dev Database credentials
    define("BA_DBHOST", "localhost");
    define("BA_DBUSER", "root");
    define("BA_DBPASSWORD", "mysql");
    define("BA_DBNAME", "bjp");

    //Constants
    define ('BASE_URL', 'http://192.168.1.135/GreenIndia/');
	define ('BASE_ADMIN_URL', 'http://192.168.1.135/GreenIndia/admin/');
    define ('ERROR_EMAIL_ADDRESS', 'kavitharjn@gmail.com');
	define ("SUBDIR", "GreenIndia/");
	

} // End if dev server 

define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
define("SITE_DOCUMENT_ROOT", DOCUMENT_ROOT . SUBDIR );
define("HTTP_HOST", $_SERVER["HTTP_HOST"]);
define("REMOTE_ADDR", $_SERVER["REMOTE_ADDR"]);
define("SERVER_ADDR", $_SERVER["SERVER_ADDR"]);
define("SERVER_NAME", $_SERVER["SERVER_NAME"]);
define("REQUEST_URI", $_SERVER["REQUEST_URI"]);
define("SCRIPT_NAME", $_SERVER["SCRIPT_NAME"]);
define("PHP_SELF", $_SERVER["PHP_SELF"]);
define("PATH_ROOT", dirname(PHP_SELF)=='/'?'':dirname(PHP_SELF));
define("FILE_NAME", basename(PHP_SELF));
define("SITE_HTTP", BASE_URL);
define("SITE_HTTPS", BASE_URL);
?>