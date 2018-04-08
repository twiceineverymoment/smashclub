<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_authentication.php");

svc_logOutUser();

echo "<script type='text/javascript'>window.location='/';</script>";

?>