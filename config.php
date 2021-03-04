<?php
ob_start();
session_start();

error_reporting(E_ALL); 

date_default_timezone_set('Australia/Sydney');

define('DIR',			__DIR__);
define('DB_SERVER',		'127.0.0.1');
define('DB_USERNAME',	'admin');
define('DB_PASSWORD',	'abc123');
define('DB_DATABASE',	'ds');

define('SITE_EMAIL',	'dssd@email.com');
define('SITE_ADDR',		'Northfields Ave, Wollongong NSW 2522');
define('SITE_PHONE',	'+61 456 789 123');

define('SITE_AUTO_EMAIL',	'noreply@qlick2learn.com');

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
include('session/classes/phpmailer/mail.php');
$user = new User($db);

?>