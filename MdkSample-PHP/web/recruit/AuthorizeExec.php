<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// リクルートかんたん支払いの実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '取引結果');

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
 * 商品名
 */
$item_name = @$_POST["itemName"];

/**
 * 決済完了時URL
 */
$successUrl = @$_POST["successUrl"];

/**
 * 決済エラー時URL
 */
$errorUrl = @$_POST["errorUrl"];

/**
 * プッシュURL
 */
$pushUrl = @$_POST["pushUrl"];

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
 * 商品番号
 */
if(isset($_POST["itemId"]) && trim($_POST["itemId"])){
  $item_id = @$_POST["itemId"];
}

/**
 * 必須パラメータ値チェック
 */
//サーバ内部指定
if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
//サーバ内部指定
} else if (empty($payment_amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
} else if (empty($item_name)) {
  $warning =  "<font color='#ff0000'><b>必須項目：商品名が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
}

/**
 * 要求電文パラメータ値の指定
 */
$request_data = new RecruitAuthorizeRequestDto();

$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
$request_data->setItemName($item_name);
$request_data->setWithCapture($is_with_capture);

$request_data->setSuccessUrl($successUrl);
$request_data->setErrorUrl($errorUrl);
$request_data->setPushUrl($pushUrl);

if(isset($item_id)){
$request_data->setItemId($item_id);
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
   * redirect URL取得
   */
  $redirect_url = $response_data->getRedirectUrl();
  // ログ
  $test_log = "<!-- vResultCode=" . $txn_result_code . " -->";

  if (TXN_SUCCESS_CODE === $txn_status) {
    if (empty($redirect_url) === false) {
      header("Location: " . $response_data->getRedirectUrl(), true, 302);
      exit;
    }
  } else {
      // エラーページ表示
      $html = createErrorPage($response_data);
      print $html . $test_log;
      exit;
  }
}
function createErrorPage($response) {

$html = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>エラーページ</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G リクルートかんたん支払いの取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">リクルートかんたん支払い：取引結果</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">取引ID</td>
    <td class="rivaluetop">'.$response->getOrderId().'<br/></td>
  </tr>
  <tr>
    <td class="rititle">取引ステータス</td>
    <td class="rivalue">'.$response->getMStatus().'</td>
  </tr>
  <tr>
    <td class="rititle">結果コード</td>
    <td class="rivalue">'.$response->getVResultCode().'</td>
  </tr>
  <tr>
    <td class="rititle">結果メッセージ</td>
    <td class="rivalue">'.$response->getMerrMsg().'</td>
  </tr>
</table>
<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body></html>';

 return $html;
}
?>
