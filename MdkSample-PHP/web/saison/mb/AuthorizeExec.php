<?php
# Copyright(C) 2012 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// 永久不滅ポイント(永久不滅ウォレット)ユーザ認可実行サンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../../tgMdk/');

define('RESULT_PAGE', 'Result.php');
define('INPUT_PAGE', 'Authorize.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

require_once(MDK_DIR."3GPSMDK.php");


if (isset($_POST['updateOrderIdButton'])) {
  include_once(INPUT_PAGE);
  exit();
}

/**
 * 設定ファイルから設定値を読み取り
 */
$config_file = "../../env4sample.ini";
if (is_readable($config_file)) {
  $env_info = @parse_ini_file($config_file, true);
  $merchant_redirection_uri = $env_info["SAISON"]["merchant_redirection_uri.MB"];
  $PC_OR_SP_settlement_method = "MB";
}

/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 金額
 */
$amount = @$_POST["amount"];

/**
 * 必須パラメータ値チェック
 */
if (empty($order_id)) {
  $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
  $warning = mb_convert_encoding($warning, "SJIS", "UTF-8");
  include_once(INPUT_PAGE);
  exit();
} else if (empty($amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
  $warning = mb_convert_encoding($warning, "SJIS", "UTF-8");
  include_once(INPUT_PAGE);
  exit();
} else if (!is_numeric ($amount)) {
  $warning =  "<font color='#ff0000'><b>金額は数値で入力しなければなりません</b></font>";
  $warning = mb_convert_encoding($warning, "SJIS", "UTF-8");
  include_once(INPUT_PAGE);
  exit(); 
}

// 金額をCapture画面へ引き渡すためにSessionに格納しておく
ini_set('session.use_trans_sid', '1');
session_start();
$_SESSION = array();
$_SESSION["amount"] = $amount;

/**
 * 要求電文パラメータ値の指定
 */
$request_data = new SaisonAuthorizeRequestDto();
$request_data->setOrderId($order_id);
$request_data->setSettlementMethod($PC_OR_SP_settlement_method);
$request_data->setMerchantRedirectionUri($merchant_redirection_uri."?session_id=".session_id()."&");

/**
 * 実施
 */
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

/**
 * 処理結果コードが成功なら、実施した結果から取得した次の画面URLへリダイレクト
 */
$txn_status = $response_data->getMStatus();

if (TXN_SUCCESS_CODE === $txn_status) {
// 成功
  // HTTP/1.1 301 Moved Permanently を使用してリダイレクト
  header("Location: " . $response_data->getResResponseContents(), true, 301);
  exit();
} else {
// 失敗
  $processName     = htmlspecialchars(mb_convert_encoding("与信", "SJIS", "UTF-8"), ENT_COMPAT | 'ENT_HTML401', "Shift_JIS");
  $_screen         = $_POST["_screen"];

  $orderId         = htmlspecialchars($response_data->getOrderId());
  $mStatus         = htmlspecialchars($txn_status);
  $vResultCode     = htmlspecialchars($response_data->getVResultCode());
  $mErrMsg         = htmlspecialchars(mb_convert_encoding($response_data->getMerrMsg(), "SJIS", "UTF-8"), ENT_COMPAT | 'ENT_HTML401', "Shift_JIS");

  include_once(RESULT_PAGE);
  exit();
}
?>
