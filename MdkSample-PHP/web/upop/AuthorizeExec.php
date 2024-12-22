<?php
# Copyright(C) 2012 VeriTrans Inc., Ltd. All right reserved.
// -------------------------------------------------------------------------
//  VeriTrans 4G - UPOP決済与信実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '取引結果');

define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

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
  * 与信同時売上有無
  * false： 与信のみ
  * true: 同時売上
  */
  if ("true" == @$_POST["withCapture"]) {
    $is_with_capture = TRUE_FLAG_CODE;
  } else {
    $is_with_capture = FALSE_FLAG_CODE;
  }


$termUrl = @$_POST["termUrl"];
$customerIp = @$_POST["customerIp"];

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
  //消費者指定
 } else if (empty($termUrl)) {
  $warning =  "<font color='#ff0000'><b>必須項目：Verify　用URLが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
  //消費者指定
 } else if (empty($customerIp)) {
  $warning =  "<font color='#ff0000'><b>必須項目：消費者IPが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }

  /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new UpopAuthorizeRequestDto();

 $request_data->setOrderId($order_id);
 $request_data->setAmount($payment_amount);
 $request_data->setTermUrl($termUrl);
 $request_data->setCustomerIp($customerIp);
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
     * EntryForm取得
     */
   $entryForm = $response_data->getEntryForm();

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title><?php echo $page_title ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G UPOP決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">UPOP決済：取引結果</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">取引ID</td>
    <td class="rivaluetop"><?php echo $result_order_id ?><br/></td>
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

 <?php echo  $entryForm?>

</table>
<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>

