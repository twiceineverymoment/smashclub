<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_mailer.php");

writeLog(4, "Entering mass mail tester...");
svc_emailAllActiveUsers("SmashClub Email Test", "This is a message sent by the SmashClub test suite. If you're seeing this, it works!");
echo "Test mass mail was attempted. Check the logs.";
writeLog(4, "Mass mail test complete.");

?>