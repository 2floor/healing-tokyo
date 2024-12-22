<?php
require_once __DIR__ . "/./logic/common/common_logic.php";
$common_logic = new common_logic();


$er = true;
if($_GET['rc'] != null && $_GET['rc'] != ''){
	list($mail, $member_id) = explode("###", urldecode(base64_decode($_GET['rc'])));
	$member = $common_logic->select_logic("select * from t_member where member_id = ? and mail = ? ", array($member_id, $mail));
	if($member != null && $member != null ){
		if($member[0]['del_flg'] == '0'){
			echo "This email address has been verified.";
			exit();
		}elseif($member[0]['del_flg'] == '9'){
			$common_logic->update_logic("t_member", "where member_id = ? ", array("del_flg"), array(0, $member_id));
			header("Location:./reconfirm_comp.php");
			exit();
		}
	}
}

if($er){
	echo "Error : Invalid URL";
	exit();
}

?>