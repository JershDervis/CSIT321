<?php
ob_start();
session_start();

error_reporting(E_ALL); 

date_default_timezone_set('Australia/Sydney');

define('DIR',			$_SERVER['DOCUMENT_ROOT']);
define('DB_SERVER',		'127.0.0.1'); //CHANGE THIS to 'localhost' when live on web
define('DB_USERNAME',	DB_SERVER == '127.0.0.1' ? 'admin' : '');
define('DB_PASSWORD',	DB_SERVER == '127.0.0.1' ? 'abc123' : '');
define('DB_DATABASE',	DB_SERVER == '127.0.0.1' ? 'ds' : '');

define('SITE_EMAIL',	'dssd@email.com');
define('SITE_ADDR',		'Northfields Ave, Wollongong NSW 2522');
define('SITE_PHONE',	'+61 456 789 123');

define('SITE_NAME', 'Drive2Succeed');
define('SITE_URL', $_SERVER['HTTP_HOST']);
define('SITE_AUTO_EMAIL',	'noreply@qlick2learn.com');
define('SITE_CONTACT_EMAIL',	'noreply@qlick2learn.com');
define('SITE_AUTO_EMAIL_PASS',	'');

define('API_GOOGLE_KEY', '');

define('SITE_ROOT', realpath(dirname(__FILE__)));
define('FILES',			SITE_ROOT . '/uploads/');

try {
	//create PDO connection
	$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_USERNAME, DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	//show error
    echo $e->getMessage();
    exit;
}

//include the user class, pass in the database connection
include('session/classes/user.php');
$user = new User($db);

?>
