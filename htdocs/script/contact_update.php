<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_member_lookup.php");

if (!isset($_POST['save'])){
	writeLog(WARNING, "Script:CONTACT_UPDATE loaded without proper context, IP: ".$_SERVER['REMOTE_ADDR']);
	showErrorPage(400);
	die();
}

global $db; //Used for mysql string escaping input sanitization

$first = mysqli_real_escape_string($db, $_POST['first']);
$last = mysqli_real_escape_string($db, $_POST['last']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$showeml = ($_POST['showeml']=="yes") ? 1 : 0 ;
$showphn = ($_POST['showphn']=="yes") ? 1 : 0 ;
$emlnot = ($_POST['emlnot']=="yes") ? 1 : 0 ;
$uuid = $_SESSION['uuid'];

if (svc_changeContactInfo($uuid, $first, $last, $email, $phone, $showeml, $showphn, $emlnot)){
	sendRedirect("/account/");
} else {
	showErrorPage(500);
}

?>