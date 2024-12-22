<?php
	require_once('../3GPSMDK.php');
	$params = Array("-update");
	$client = new TGMDK_ClientCertificateMain();
	$client->execute($params);
?>
