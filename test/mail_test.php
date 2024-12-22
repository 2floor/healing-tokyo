<?php
session_start();
$echo = '';
if($_POST['mail'] != null && $_POST['mail'] != ''){
	
		mb_language ( "Japanese" );
		mb_internal_encoding ( "UTF-8" );

		$header  = "Content-Type: text/plain; charset=ISO-2022-JP \n";
		$header .= "Content-Transfer-Encoding: 7bit \n";
		$header .= "Return-Path: " . "no-reply@healing-tokyo.com" . "\n";
		$header .= "From:" .mb_encode_mimeheader("JAPAN INT") ."<"."no-reply@healing-tokyo.com".">\n";
		$header .= "Sender: " . "JAPAN INT" ."\n";
		$header .= "Reply-To: " .mb_encode_mimeheader("JAPAN INT") ."<"."no-reply@healing-tokyo.com".">\n";
		$header .= "Organization: " . "no-reply@healing-tokyo.com" . " \n";
		$header .= "X-Sender: " . "no-reply@healing-tokyo.com" . " \n";
		$header .= "X-Priority: 3 \n";

$subject_adminer = 'Healing Tokyoテストメール';
$body_in = '送信内容
sousinnaiyou
';

		mb_send_mail($_POST['mail'], $subject_adminer, $body_in, $header);
		
		
		$echo = '<span style="color:red;">'.$_POST['mail'].'に送信完了</span>';
}

?>
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
<?php require_once '../required/html_head.php'?>
<link rel="stylesheet" href="./assets/css/mbr-additional.css">

</head>
<body>
	<?php print $echo ?>
	<form method="post">
		<input type="text" name="mail" value="" style="width: 200px;">
		<button type="submit">送信</button>
	</form>
	
</body>
</html>