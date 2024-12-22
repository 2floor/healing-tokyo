<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// PayPal決済実行画面のサンプル
// -------------------------------------------------------------------------

// MDK配置ディレクトリ
define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');

// PayPalから取引トークンを取得するアクション
define('ACTION_TYPE', 'set');

// 確認ページURL
define('DEFAULT_RETURN_PAGE', 'paypal/AuthorizeConfirm.php');
// 取引キャンセルページURL
define('DEFAULT_CANCEL_PAGE', 'paypal/PaymentMethodSelect.php');
// 配送情報有無　1：有/0:無
define('NO_SHIPPING_INFO', '0');

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

$return_url = "";
$cancel_url = "";

// サンプル使用設定
$config_file = "../env4sample.ini";

if (is_readable($config_file)) {
  $env_info = @parse_ini_file($config_file, true);
  $base_url = $env_info["Common"]["base.url"];
  $return_url = $base_url.DEFAULT_RETURN_PAGE;
  $cancel_url = $base_url.DEFAULT_CANCEL_PAGE;

  if (!empty($env_info["PayPal"]["return.url"])) {
    $return_url = $env_info["PayPal"]["return.url"];
  } else {
    if (!empty($base_url)) {
    $return_url = $base_url . DEFAULT_RETURN_PAGE;
    }
  }
  if (!empty($env_info["PayPal"]["cancel.url"])) {
    $cancel_url = $env_info["PayPal"]["cancel.url"];
  } else {
    if (!empty($base_url)) {
      $cancel_url = $base_url . DEFAULT_CANCEL_PAGE;
    }
  }
}

/**
 * 取引IDを取得
 */
$order_id = @$_POST["orderId"];
/**
 * 支払金額を取得
 */
$payment_amount = @$_POST["amount"];
/**
 * 決済方法を取得
 */
$payment_action = @$_POST["paymentAction"];


/**
 * 必須パラメータ値チェック
 */
if (empty($payment_amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：決済金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
}

// 決済方法をセッションに格納
session_start();
$_SESSION["payment_action"] = $payment_action;

/**
 * 要求パラメータ設定
 * 与信のみの場合PayPalAuthorizeRequestDto、
 * 与信同時売上の場合PayPalCaptureRequestDtoを使用
 */
if ($payment_action == "authorize") {
// 与信のみ
  $request_data = new PaypalAuthorizeRequestDto();
} else {
// 与信同時売上
  $request_data = new PayPalCaptureRequestDto();
}
$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
$request_data->setAction(ACTION_TYPE);
$request_data->setReturnUrl($return_url);
$request_data->setCancelUrl($cancel_url);
$request_data->setShippingFlag(NO_SHIPPING_INFO);

/**
 * 通信実行
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
    /**
     * PayPalログインページへリダイレクト
     */
    $login_url = $response_data->getLoginUrl();
    header('Location: '.$login_url);
    exit;
  // 失敗
  } else if (TXN_FAILURE_CODE === $txn_status) {
  } else {
    $page_title = ERROR_PAGE_TITLE;
  }
 }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $page_title ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G PayPal決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>
<div class="lhtitle">PayPal決済：取引結果</div>
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
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>
