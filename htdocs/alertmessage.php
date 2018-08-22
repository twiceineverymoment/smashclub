<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

$alert = svc_getSetting("AlertMessageText");

if (svc_getSetting("ShowAlertMessage")==1){
	echo "<div id='alertmessage'><b>NOTICE: </b>".$alert."</div>";
}

?>