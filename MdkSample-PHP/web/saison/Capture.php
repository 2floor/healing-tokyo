<?php
# Copyright(C) 2012 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// 永久不滅ポイント(永久不滅ウォレット)売上実行サンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('RESULT_PAGE', 'Result.php');
define('INPUT_PAGE', 'CaptureInp.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

require_once(MDK_DIR."3GPSMDK.php");

$txn_status = $_GET["mstatus"];

if (TXN_SUCCESS_CODE === $txn_status) {
// 成功
  // 売上画面へ
  include_once(INPUT_PAGE);
  exit();
} else {
  $processName     = htmlspecialchars("売上");

  $orderId         = htmlspecialchars($_GET["orderId"]);
  $mStatus         = htmlspecialchars($txn_status);
  $vResultCode     = htmlspecialchars($_GET["vResultCode"]);
  $mErrMsg         = htmlspecialchars($_GET["merrMsg"]);

  // 結果画面へ
  include_once(RESULT_PAGE);
  exit();
}
?>
