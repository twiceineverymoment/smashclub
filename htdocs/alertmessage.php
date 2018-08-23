<?php

require_once($_SERVER['DOCUMENT_ROOT']."/service/svc_site_settings.php");

$alert = svc_getSetting("AlertMessageText");

if (svc_getSetting("ShowAlertMessage")==1){
	echo "<div id='alertmessage'><b>NOTICE: </b>".$alert."</div>";
}

?>

<noscript>
	<div id="noscript-banner"><b>Note: </b>It appears that you have JavaScript disabled or your browser does not support it. For the best experience on SmashClub please enable JavaScript or upgrade to a supported browser.</div>
</noscript>

<?php
/*
$ua = get_browser(null, true);
$uastr = var_export($ua, true);
writeLog(DEBUG, $uastr);
*/
?>