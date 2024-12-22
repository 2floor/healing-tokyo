<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// PayPal決済確認画面のサンプル
// -------------------------------------------------------------------------

// MDK配置ディレクトリ
define('MDK_DIR', '../tgMdk/');

// PayPalから取引情報を取得するアクション
define('ACTION_TYPE', 'get');

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
$token = "";
$payer_id = "";
$amount = "";

 //1. PayPalからのトークンを再セット (authorize:get)
 $token = htmlspecialchars(@$_GET["token"]);

 // 画面で選択された決済方法を取得
 session_start();
 $payment_action = htmlspecialchars(@$_SESSION["payment_action"]);

 /**
  * リクエスト
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
 $request_data->setAction(ACTION_TYPE);
 $request_data->setToken($token);

// 2. exec transaction (get)

 $transaction = new TGMDK_Transaction();
 $response_data = $transaction->execute($request_data);

 //予期しない例外
 if (!isset($response_data)) {
  $page_title = ERROR_PAGE_TITLE;
  $main_message = "<font color='#ff0000'><b>応答が取得できませんでした。</b></font>";
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
    $token = $response_data->getToken();
    $payer_id = $response_data->getPayerId();
    $amount = $response_data->getAmount();
    $main_message = "<font color='#ff0000'><b>処理（get）に成功しました</b></font>";
  // 失敗
  } else if (TXN_FAILURE_CODE === $txn_status) {
    $main_message = "<font color='#ff0000'><b>取引に失敗しました</b></font>";
  } else {
    $page_title = ERROR_PAGE_TITLE;
    $main_message = "<font color='#ff0000'><b>応答が取得できませんでした。</b></font>";
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
本画面はVeriTrans4G PayPal決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>
<div class="lhtitle">PayPal決済：取引確認</div>
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
    <td class="rititletop">Token</td>
    <td class="rivaluetop"><?php echo $token ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">請求番号</td>
    <td class="rivalue"><?php echo $response_data->getInvoiceId() ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">PayPal顧客番号</td>
    <td class="rivalue"><?php echo $payer_id ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">合計金額</td>
    <td class="rivalue"><?php echo $amount ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">配送先氏名</td>
    <td class="rivalue"><?php echo $response_data->getShipName() ?><br/></td>
  </tr>
</table>
<br/>
<form action="./AuthorizeComplete.php" method="post">
<!--  AuthorizeComplete.php へパラメータを引き継ぎdoアクションを実行します -->
<input type="hidden" name="token" value="<?php echo $token ?>">
<input type="hidden" name="payer" value="<?php echo $payer_id ?>">
<input type="hidden" name="amount" value="<?php echo $amount ?>">
<input type="submit" value="確定"/>
</form>
<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
