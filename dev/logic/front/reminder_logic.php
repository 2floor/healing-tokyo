<?php
require_once __DIR__ . "/../../logic/common/common_logic.php";
$common_logic = new common_logic();

if($_POST['method'] != null && $_POST['method'] != ''){
	if($_POST['method'] == 'reminder'){
		$member = $common_logic->select_logic("select  `member_id` as `id`, `mail` from t_member where mail = ? ", array($_POST['mail']));
		$ty = 1;
		if($member == null || $member == ''){
			$member = $common_logic->select_logic("select `store_basic_id` as `id`, `mail` from t_store_basic where mail = ? ", array($_POST['mail']));
			$ty = 2;
		}

		if($member == null || $member == ''){
			header("Location:../../reminder.php?er=1");
			exit();
		}


		$data = array($common_logic->getRandomString(4),$member[0]['mail'],ceil(microtime(true)),$ty,$member[0]['id']);
		$url_add = urlencode(base64_encode(implode("#???#", $data)));


		$mail = $post['mail'];
		$subject = '【JIS】Password reminder.' ;

		$body = '

/***********************************************************/
This will be an automatic email.
/***********************************************************/


Thank you for using JIS.
Click on the URL below to change your password.

https://jis-j.com/reminder_change.php?ad='.$url_add.'


/*--------------------------------------------*/
Japan International Services
/*--------------------------------------------*/
';

		mb_language ( "Japanese" );
		mb_internal_encoding ( "UTF-8" );
		$from = "enquiry@jis-j.com";
		$from_name = "Japan International Services";

		$header = "Content-Type: text/plain; charset=UTF-8 \n";
		$header .= "Content-Transfer-Encoding: BASE64 \n";
		$header .= "Return-Path: " . $from . "\n";
		$header .= "From:" .mb_encode_mimeheader($from_name) ."<".$from.">\n";
		$header .= "Sender: " . $from_name ."\n";
		$header .= "Reply-To: " .mb_encode_mimeheader($from_name) ."<".$from.">\n";
		$header .= "Organization: " . $from . " \n";
		$header .= "X-Sender: " . $from . " \n";
		$header .= "X-Priority: 3 \n";

		mb_send_mail($member[0]['mail'], $subject, base64_encode($body), $header);

		header("Location:../../reminder_comp.php");
		exit();



	}elseif($_POST['method'] == 'change_pw'){

		list($ha, $mail, $time, $ty, $id) = explode("#???#", base64_decode(urldecode($_POST['ad'])));
		if(isset($ha) !== false && isset($mail) !== false && isset($time) !== false && isset($time) !== false && isset($ty) !== false && isset($id) !== false){
			if($time < ceil(microtime(true)) + 60*30){
				if($_POST['password'] == $_POST['password_conf']){
					if($ty == 1){
						$res = $common_logic->update_logic("t_member", " where member_id = ? and mail = ? ", array("password"), array(
								$common_logic->convert_password_encode($_POST['password']),
								$id,
								$mail,
						));
					}elseif($ty == 2){
						$res = $common_logic->update_logic("t_store_basic", " where store_basic_id = ? and mail = ? ", array("password"), array(
								$common_logic->convert_password_encode($_POST['password']),
								$id,
								$mail,
						));
					}

					if($res){
						header("location:../../reminder_change_comp.php");
						exit();

					}else{
						header("location:../../reminder_change.php?er=2");
						exit();
					}

				}else{
					header("location:../../reminder_change.php?er=1");
					exit();
				}
			}
		}

	}
}else{
	header("Location:../../");
	exit();
}