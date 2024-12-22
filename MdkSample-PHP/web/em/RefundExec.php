<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 電子マネー決済 返金実行および結果画面のサンプル
// -------------------------------------------------------------------------

/**
 * MDK配置ディレクトリ
 */
define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Refund.php');

/**
 * ステータスコード
 */
define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '取引結果');

require_once(MDK_DIR."3GPSMDK.php");

// 変数の初期化
$orderId = "";
$txn_status = "";
$txn_result_code = "";
$error_message = "";

/**
 * 決済方式
 *
 * サイバーEdy : edy-pc
 * モバイル Edy : edy-mobile
 * モバイルEdyダイレクト : edy-direct
 * モバイルSuicaメール決済 : suica-mobile-mail
 * モバイルSuicaアプリ決済 : suica-mobile-app
 * Suicaインターネット決済メール連携 : suica-pc-mail
 * Suicaインターネット決済アプリ連携 : suica-pc-app
 * WAON PC決済 : waon-pc
 * WAON モバイル決済 : waon-mobile
 */
$service_option_type = @$_POST["serviceOptionType"];

/**
 * 本取引の取引ID
 */
 $order_id = "dummy".time();

/**
 * 返金依頼金額  <= 決済金額
 */
 $request_amount = @$_POST["amount"];

/**
 * オーダー種別
 * 返金：refund
 * 新規返金: refund_new
 */
 $order_kind = @$_POST["orderKind"];

/**
 * 返金対象取引ID
 */
 $refund_order_id = @$_POST["refundOrderId"];

/**
 * 決済期限（Suica）
 */
 $settlement_limit = @$_POST["settlementLimit"];

/**
 * 画面タイトル
 */
 $screen_title = @$_POST["screenTitle"];

/**
 * 必須パラメータ値チェック
 */
 if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($request_amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($order_kind)) {
  $warning =  "<font color='#ff0000'><b>必須項目：取引種別が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($refund_order_id)) {
  $warning =  "<font color='#ff0000'><b>必須項目：対象取引IDが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if ("edy-mobile" != $service_option_type
 && "edy-pc" != $service_option_type
 && "edy-direct" != $service_option_type
 && "waon-pc" != $service_option_type
 && "waon-mobile" != $service_option_type
 && empty($settlement_limit)) {
  $warning =  "<font color='#ff0000'><b>必須項目：決済期限が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }

/**
 * 要求電文パラメータ値の指定
 */
 $request_data = new EmRefundRequestDto();
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);
 $request_data->setRefundOrderId($refund_order_id);
 $request_data->setOrderKind($order_kind);
 $request_data->setAmount($request_amount);
 if ("edy-pc" != $service_option_type
  && "edy-direct" != $service_option_type
  && "edy-mobile" != $service_option_type
  && "waon-pc" != $service_option_type
  && "waon-mobile" != $service_option_type) {
  $request_data->setSettlementLimit($settlement_limit);
 }
 if ("waon-pc" === $service_option_type) {
  $request_data->setSuccessUrl("http://127.0.0.1/web/PaymentMethodSelect.php?status=success");
  $request_data->setFailureUrl("http://127.0.0.1/web/PaymentMethodSelect.php?status=failure");
  $request_data->setCancelUrl("http://127.0.0.1/web/PaymentMethodSelect.php?status=cancel");
 }
 if ("edy-pc" != $service_option_type
  && "edy-mobile" != $service_option_type
  && "edy-direct" != $service_option_type
  && "waon-pc" != $service_option_type
  && "waon-mobile" != $service_option_type) {
  $request_data->setScreenTitle($screen_title);
 }

/**
 * 実施
 */
 $transaction = new TGMDK_Transaction();
 $response_data = $transaction->execute($request_data);

 //予期しない例外
 if (!isset($response_data)) {
  $page_title = ERROR_PAGE_TITLE;
 //想定応答の取得
 } else {
  // 取引ID
  $orderId = $response_data->getOrderId();

  $page_title = NORMAL_PAGE_TITLE;
 /**
  * 結果コード取得
  */
  $txn_status = $response_data->getMStatus();
 /**
  * 詳細コード取得
  */
  $txn_result_code = $response_data->getVResultCode();
 /**
  * エラーメッセージ取得
  */
  $error_message = $response_data->getMerrMsg();
  // 成功
  if (TXN_SUCCESS_CODE === $txn_status) {
    $application_url = $response_data->getAppUrl();
  } else if (TXN_PENDING_CODE === $txn_status) {
  // 失敗
  } else if (TXN_FAILURE_CODE === $txn_status) {
  } else {
    $page_title = ERROR_PAGE_TITLE;
  }
 }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title><?php echo $page_title ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 電子マネー決済の返金取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>
<div class="lhtitle">電子マネー決済返金：取引結果</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">取引ID</td>
    <td class="rivaluetop"><?php echo $orderId ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">取引ステータス</td>
    <td class="rivalue"><?php echo $txn_status ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">結果コード</td>
    <td class="rivalue"><?php echo $txn_result_code ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">結果メッセージ</td>
    <td class="rivalue"><?php echo $error_message ?><br/></td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">受付番号</td>
    <td class="rivaluetop"><?php echo $response_data->getReceiptNo() ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">決済アプリケーション起動URL</td>
    <td class="rivalue">
<?php
    if (isset($application_url)) {
?>
    <a href="<?php echo $application_url ?>">起動url</a>
<?php
    }
?>
    <br/>
    </td>
  </tr>
</table>
<br>
<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
