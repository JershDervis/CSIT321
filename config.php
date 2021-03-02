<?php
require __DIR__ . '/vendor/autoload.php';

ob_start();
session_start();

//Enables error reporting, remove this when not debugging
error_reporting(E_ALL); 

date_default_timezone_set('Australia/Sydney');

define('SITE_ROOT', __DIR__);

$servername = "127.0.0.1";
$username = "admin";
$password = "abc123";
$database = "ds";

$SITE_EMAIL = "dssd@email.com";
$SITE_ADDR = "Northfields Ave, Wollongong NSW 2522";
$SITE_PHONE = "+61 456 789 123";

try {
	//create PDO connection
	$db = new PDO("mysql:host=".$servername.";dbname=".$database, $username, $password);
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