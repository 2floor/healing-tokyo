<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// MasterPass決済の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', 'Transaction Result (取引結果)');

require_once(MDK_DIR."3GPSMDK.php");
/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 支払金額
 */
$payment_amount = @$_POST["amount"];

/**
 * 与信方法
 */
$is_with_capture = @$_POST["withCapture"];
if ("1" == $is_with_capture) {
  $is_with_capture = TRUE_FLAG_CODE;
} else {
  $is_with_capture = FALSE_FLAG_CODE;
}


/**
 * 必須パラメータ値チェック
 */
//サーバ内部指定
if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>Unset Order Id<br>(必須項目：取引IDが指定されていません)</b></font>";
  include_once(INPUT_PAGE);
  exit;
//サーバ内部指定
} else if (empty($payment_amount)) {
  $warning =  "<font color='#ff0000'><b>Unset Amount<br>(必須項目：金額が指定されていません)</b></font>";
  include_once(INPUT_PAGE);
  exit;
}


/**
 * 要求電文パラメータ値の指定
 */
$request_data = new MasterpassAuthorizeRequestDto();

$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
$request_data->setWithCapture($is_with_capture);

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
  $page_title = NORMAL_PAGE_TITLE;

  /**
   * 取引ID取得
   */
  $result_order_id = $response_data->getOrderId();
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
  /**
   * 取引日時取得
   */
  $auth_authorizeDatetime = $response_data->getAuthorizeDatetime();
  /**
   * 承認番号取得
   */
  $auth_authCode = $response_data->getAuthCode();

  // 成功
  if (TXN_SUCCESS_CODE === $txn_status) {
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title><?php echo $page_title ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G MasterPass決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>


<div class="lhtitle">MasterPass Result<br/>(決済：取引結果)</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">Order ID<br/>(取引ID)</td>
    <td class="rivaluetop"><?php echo $result_order_id ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Status<br/>(取引ステータス)</td>
    <td class="rivalue"><?php echo $txn_status ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Code<br/>(結果コード)</td>
    <td class="rivalue"><?php echo $txn_result_code ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Message<br/>(結果メッセージ)</td>
    <td class="rivalue"><?php echo $error_message ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Authorization Datetime<br/>(取引日時)</td>
    <td class="rivalue"><?php echo $auth_authorizeDatetime ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Authentication Code<br/>(承認番号)</td>
    <td class="rivalue"><?php echo $auth_authCode ?><br/></td>
  </tr>
</table>

<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>

