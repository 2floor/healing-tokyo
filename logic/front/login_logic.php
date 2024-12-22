<?php
session_start();
require_once __DIR__ .  '/../../logic/common/common_logic.php';
require_once __DIR__ .  '/../../logic/common/jis_common_logic.php';
$common_logic = new common_logic();
$jis_common_logic = new jis_common_logic();

if($_POST['mail'] != null && $_POST['mail'] != '' && $_POST['password'] != null && $_POST['password'] != ''){
	$jis_common_logic->login($_POST);

}else{
	header("Location: ../../login.php?er=1");
	exit();
}


?>