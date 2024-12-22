<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/common/common_logic.php';
$common_logic = new common_logic();
$jis_common_logic = new jis_common_logic();
$jis_common_logic->login_check();

$post = $_POST;

if($post['nickname']== null || $post['nickname']== '' || $post['review_point']== null || $post['review_point']== '' || $post['comment']== null || $post['comment']== '' ){
	$d = array();
	foreach ($post as $n => $v) {
		$d[] = $n.'='.$v;
	}
	header("Location:./review.php?er=1&" .implode('&', $d));
	exit();
}


$common_logic->insert_logic("t_review", array(
		$_SESSION['jis']['login_member']['member_id'],
		$post['nicname'],
		$post['store_basic_id'],
		$post['tour_id'],
		$post['rid'],
		0,//$post['confirmation_flg'],
		0,//$post['auth_flg'],
		$post['review_point'],
		$post['comment'],
		null,//$post['reply'],
		0,//$post['del_flg'],
		0,//$post['public_flg'],
));


header("Location:./review_comp.php");
exit();