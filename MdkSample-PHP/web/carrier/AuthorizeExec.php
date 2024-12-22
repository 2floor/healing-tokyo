<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済の実行および結果画面のサンプル
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
 * キャリア選択
 */
$service_option_type = @$_POST["serviceOptionType"];

/**
 * 支払金額
 */
$payment_amount = @$_POST["amount"];

/**
 * 端末種別
 */
$terminal_kind = @$_POST["terminalKind"];

/**
 * 商品タイプ
 */
$item_type = @$_POST["itemType"];

/**
 * 都度継続区分
 */
$accounting_type = @$_POST["accountingType"];

/**
 * 初回課金年月日
 */
$mpFirstDate = @$_POST["mpFirstDate"];

/**
 * 継続課金日
 */
$mpDay = @$_POST["mpDay"];

/**
 * 決済完了時URL
 */
$successUrl = @$_POST["successUrl"];

/**
 * 決済キャンセル時URL
 */
$cancelUrl = @$_POST["cancelUrl"];

/**
 * 決済エラー時URL
 */
$errorUrl = @$_POST["errorUrl"];

/**
 * pushURL
 */
$pushUrl = @$_POST["pushUrl"];

/**
 * openID
 */
$openId = @$_POST["openId"];

/**
 * 与信方法
 */
$is_with_capture = @$_POST["withCapture"];
if($accounting_type==0){
  if ("1" == $is_with_capture) {
    $is_with_capture = TRUE_FLAG_CODE;
  } else {
    $is_with_capture = FALSE_FLAG_CODE;
  }
}

/**
 * 3Dセキュア
 */
if($service_option_type == "sb_ktai"){
  $d3_flag = @$_POST["d3Flag"];
}

/**
 * 商品番号
 */
if(isset($_POST["itemId"]) && trim($_POST["itemId"])){
  $item_id = @$_POST["itemId"];
}

/**
 * 商品情報
 */
if(isset($_POST["itemInfo"]) && trim($_POST["itemInfo"])){
  $item_info = @$_POST["itemInfo"];
}

/**
 * フレッツエリア
 */
if($service_option_type == "flets"){
  $fletsArea = @$_POST["fletsArea"];
}

/**
 * auIDログインフラグ
 */
if($service_option_type == "au"){
  $loginAuId = @$_POST["loginAuId"];
  if ("1" == $loginAuId) {
    $loginAuId = TRUE_FLAG_CODE;
  } else {
    $loginAuId = FALSE_FLAG_CODE;
  }
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
 } else if (empty($service_option_type)) {
  $warning =  "<font color='#ff0000'><b>必須項目：キャリアが選択されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($payment_amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (isset($terminal_kind)===false) {
  $warning =  "<font color='#ff0000'><b>必須項目：端末種別が選択されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (isset($accounting_type)===false) {
  $warning =  "<font color='#ff0000'><b>必須項目：都度継続区分が選択されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }

/**
 * 要求電文パラメータ値の指定
 */
 $request_data = new CarrierAuthorizeRequestDto();

 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);
 $request_data->setAmount($payment_amount);
 $request_data->setTerminalKind($terminal_kind);
 $request_data->setAccountingType($accounting_type);
 $request_data->setItemType($item_type);
 if($accounting_type==0){
   $request_data->setWithCapture($is_with_capture);
 }
 elseif($accounting_type==1){
   $request_data->setMpFirstDate($mpFirstDate);
   $request_data->setMpDay($mpDay);
 }
 $request_data->setSuccessUrl($successUrl);
 $request_data->setCancelUrl($cancelUrl);
 $request_data->setErrorUrl($errorUrl);
 $request_data->setPushUrl($pushUrl);

 if(isset($d3_flag)){
   $request_data->setD3Flag($d3_flag);
 }
 if(isset($item_id)){
   $request_data->setItemId($item_id);
 }
 if(isset($item_info)){
   $request_data->setItemInfo($item_info);
 }

 if($service_option_type === "docomo" || $service_option_type === "au") {
   $request_data->setOpenId($openId);
 }
 if($service_option_type === "s_bikkuri") {
   $request_data->setSbUid("dummyUID");
 }

 if($service_option_type === "flets") {
   $request_data->setFletsArea($fletsArea);
 }

 if($service_option_type === "au") {
   $request_data->setLoginAuId($loginAuId);
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
      // 成功
      if (empty($redirect_url) === false) {
          header("Location: " . $response_data->getRedirectUrl(), true, 302);
          exit;
      } else {
          $response_html = $response_data->getResponseContents();
          if($service_option_type === "docomo" || $service_option_type === "sb_ktai"){
             header("Content-type: text/html; charset=Shift_JIS");
             $response_html = mb_convert_encoding($response_html, "SJIS", "UTF-8");
          } else {
             header("Content-type: text/html; charset=UTF-8");
          }
          echo $response_html . $test_log;
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
本画面はVeriTrans4G キャリア決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">キャリア決済：取引結果</div>
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

