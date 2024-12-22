<?php
// 設定ファイル読込
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
$jis_common_logic = new jis_common_logic ();
$jis_common_logic->create_pdf(array('reservation_id' => $_GET["rsv"]));
