<?php

session_start();
require_once __DIR__ . '/../logic/common/common_logic.php';
$common_logic = new common_logic();

$common_logic->update_logic("t_review", " where review_id = ? ", array(
		"reply"
), array(
		$_POST['reply'],
		$_POST['review_id'],

));

header("Location:./review_comp.php");
exit();