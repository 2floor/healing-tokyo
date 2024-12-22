<?php
# Copyright(C) 2013 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// ショッピングクレジット決済画面表示実行サンプル
// -------------------------------------------------------------------------
define('RESULT_PAGE', 'Result.php');

$processName     = htmlspecialchars("決済結果取得");
$orderId         = htmlspecialchars($_GET["orderId"]);
$mStatus         = htmlspecialchars($_GET["mstatus"]);
$vResultCode     = htmlspecialchars($_GET["vResultCode"]);
$mErrMsg         = htmlspecialchars($_GET["merrMsg"]);
$receiptNo       = array_key_exists('receiptNo', $_GET) ? htmlspecialchars($_GET['receiptNo']) : "";
$mErrMsg         = htmlspecialchars($_GET["merrMsg"]);
$_screen         = array_key_exists('_screen', $_POST) ? htmlspecialchars($_POST['_screen']) : "";
include_once(RESULT_PAGE);
exit();
?>
