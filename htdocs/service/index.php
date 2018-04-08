<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/app_properties.php");
writeLog(ALERT, "Attempt was made to navigate directly to the /service/ folder from ".$_SERVER['REMOTE_ADDR']);
showErrorPage(403);
die();

?>