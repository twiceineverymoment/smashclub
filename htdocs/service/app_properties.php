<?php

const SEVERE = 1;	//Fatal errors, usually caused by SQL queries failing to execute
const ERROR = 2;	//Non-fatal function errors
const WARNING = 3;	//Possible problems, especially security alerts
const ALERT = 4;	//Important events to look at, i.e. major account changes, security events
const INFO = 5;		//Successful events worth noting, i.e. account changes or admin actions
const DEBUG = 6;	//Used for variable dumps when debugging functions
const TRACE = 7;	//Used for tracing data values in detail through function steps

global $db, $debug, $mqdb, $mail_options;
//require_once("C:/xampp/php/pear/Mail/Queue.php");

//APP PROPERTY VALUES----------------------------

error_reporting(E_ALL);					//Enable or disable the PHP error reporting system. Recommended: E_ALL in Development, 0 in any higher environment
$debug = true;							//Enable debug dumps on script pages. Recommended: TRUE in Development, FALSE in any higher environment

$log_level = TRACE; 					//Log detail level. Recommended: TRACE in Development, DEBUG in Test/Beta, INFO in Production
$log_location = "C:/xampp/htdocs/logs";	//Folder location of the smashclub.log file. If you are on Linux, make sure you have the correct read/write permissions!

$email_on = false;						//If true, send emails using PHP mail(). If false, all outgoing mail is disabled. Message info will be dumped to the logs instead.

$timezone = "America/New_York";			//Time zone of the PHP server

$db_server = "localhost:3306";			//Database server address - you may or may not need a port number depending on your server OS
$db_database = "UTCSC_DEV";				//Database name
$db_username = "root";					//Database credentials
$db_password = "";

/*
$mailqueue_server = "bvista-srv01";
$mailqueue_database = "smashclubmail_dvlp";
$mailqueue_user = "db_developer";
$mailqueue_password = "l3mm35m45h";

$mail_server = "smtp.gmail.com";
$mail_port = 465;
$mail_user = "utcsmashclub@gmail.com";
$mail_password = "sc.mailer.3020$";
*/

//End APP PROPERTY VALUES------------------------

//Initialize session and set user type. If type is not set, set it to 0.
//Type 0 = not logged in, 1 = member, 2 = scorekeeper, 3 = organizer, 4 = root
session_start();
if (!isset($_SESSION['type'])){
	$_SESSION['type'] = 0;
}

date_default_timezone_set($timezone);

$db = mysqli_connect($db_server, $db_username, $db_password, $db_database);

if (!$db){
	writeLog(SEVERE, "MySQL Connection failed! 503 errors will be shown until this is resolved.");
	writeLog(SEVERE, mysqli_error($db));
	if (strpos($_SERVER['PHP_SELF'], "errorpage")===false){
		showErrorPage(503);
		die();
	}
}

/* Properties for PEAR mail server
$mqdb['type'] = "mdb2";
$mqdb['dsn'] = "mysql://".$mailqueue_user.":".$mailqueue_password."@".$mailqueue_server."/".$mailqueue_database;
$mqdb['mail_table'] = "mail_queue";

$mail_options['driver']    = 'smtp';
$mail_options['host']      = $mail_server;
$mail_options['port']      = $mail_port;
$mail_options['localhost'] = 'localhost'; //optional Mail_smtp parameter
$mail_options['auth']      = true;
$mail_options['username']  = $mail_user;
$mail_options['password']  = $mail_password;
*/

function writeLog($status, $text){
	global $log_level, $log_location;
	if ($status > $log_level) return;
	$filepath = $log_location."/smashclub.log";
	$info = array("", "[SEVERE ]", "[ERROR  ]", "[WARNING]", "[ALERT  ]", "[INFO   ]", "[DEBUG  ]", "[TRACE  ]");
	$user = ($_SESSION['type']>0) ? "[".$_SESSION['name']."]" : "[Anonymous]";
	$entry = date("[Y-m-d H:i:s] ", time()) . $info[$status] . " " . $user . ": " . $text. "\r\n";
	file_put_contents($filepath, $entry, FILE_APPEND);
}

function showErrorPage($code){
	http_response_code($code);
	echo "<meta http-equiv='REFRESH' content='0 url=/errorpage/?e=".$code."' />";
}

function sendRedirect($url){
	http_response_code(302);
	echo "<meta http-equiv='REFRESH' content='0 url=".$url."' />";
}

function showJavascriptAlert($message){
	echo "<script type='text/javascript'>alert('".$message."');</script>";
}

function sendBack(){
	echo "<script type='text/javascript'>window.history.back();</script>";
}

?>
