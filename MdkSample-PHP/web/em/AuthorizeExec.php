<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 電子マネー決済 決済請求実行および結果画面のサンプル
// -------------------------------------------------------------------------

/**
 * MDK配置ディレクトリ
 */
define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');
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
 * モバイル Edy : edy-mobile
 * サイバーEdy : edy-pc
 * モバイルEdyダイレクト : edy-direct
 * モバイルSuicaメール決済 : suica-mobile-mail
 * モバイルSuicaアプリ決済 : suica-mobile-app
 * Suicaインターネット決済メール連携 : suica-pc-mail
 * Suicaインターネット決済アプリ連携 : suica-pc-app
 * WAON PC決済 : waon-pc
 * WAON モバイル決済 : waon-mobile
 * nanaco決済：tcc-redirect
 */
$service_option_type = @$_POST["serviceOptionType"];

/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 決済金額
 */
$payment_amount = @$_POST["amount"];

/**
 * 決済期限
 * パソリ未使用
 */
$settlement_limit = @$_POST["settlementLimit"];

/**
 * 支払取消期限
 * WAONネット決済、WAONネット決済のみ
 */
$cancel_limit = @$_POST["cancelLimit"];

/**
 * メールアドレス
 * Cyber Edy、Suica決済アプリ連携未使用
 */
$mail_address = @$_POST["mailAddress"];

/**
 * 画面タイトル
 */
$screen_title = "画面タイトルサンプル";

/**
 * ユーザID
 */
$user_id = @$_POST["userId"];

/**
 * 必須パラメータ値チェック
 */
 if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($payment_amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($settlement_limit)) {
  if ("edy-pc" != $service_option_type && "edy-direct" != $service_option_type && "tcc-redirect" != $service_option_type) {
   $warning =  "<font color='#ff0000'><b>必須項目：決済期限が指定されていません</b></font>";
   include_once(INPUT_PAGE);
   exit;
  }
 } else if (empty($cancel_limit)) {
  if ("waon-pc" === $service_option_type
   || "waon-mobile" === $service_option_type) {
   $warning =  "<font color='#ff0000'><b>必須項目：支払取消期限が指定されていません</b></font>";
   include_once(INPUT_PAGE);
   exit;
  }
 } else if ("edy-pc" != $service_option_type
 && "edy-direct" != $service_option_type
 && "suica-mobile-app" != $service_option_type
 && "suica-pc-app" != $service_option_type
 && "tcc-redirect" != $service_option_type && empty($mail_address)) {
  $warning =  "<font color='#ff0000'><b>必須項目：メールアドレスが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }

 if ("tcc-redirect" === $service_option_type) {
  if (empty($user_id)) {
   $warning =  "<font color='#ff0000'><b>必須項目：ユーザIDが指定されていません</b></font>";
   include_once(INPUT_PAGE);
   exit;
  }
 } else {
  if (!empty($user_id)) {
   $warning =  "<font color='#ff0000'><b>ユーザIDは指定できません</b></font>";
   include_once(INPUT_PAGE);
   exit;
  }
 }

 /**
  * 設定ファイルから設定値を読み取り
  */
 $config_file = "../env4sample.ini";
 if (is_readable($config_file)) {
  $env_info = @parse_ini_file($config_file, true);
  $completeNoticeUrl = $env_info["EM"]["tcc.completeNoticeUrl"];
 }

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new EmAuthorizeRequestDto();
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);
 $request_data->setAmount($payment_amount);
 if ("edy-pc" != $service_option_type
  && "edy-direct" != $service_option_type
  && "tcc-redirect" != $service_option_type) {
  $request_data->setSettlementLimit($settlement_limit);
 }
 if ("edy-pc" != $service_option_type
  && "edy-direct" != $service_option_type
  && "suica-mobile-app" != $service_option_type
  && "suica-pc-app" != $service_option_type
  && "tcc-redirect" != $service_option_type) {
  $request_data->setMailAddr($mail_address);
 }
 if ("edy-pc" != $service_option_type
  && "edy-mobile" != $service_option_type
  && "edy-direct" != $service_option_type
  && "waon-pc" != $service_option_type
  && "waon-mobile" != $service_option_type
  && "tcc-redirect" != $service_option_type) {
  $request_data->setScreenTitle($screen_title);
 }
 if ("waon-pc" === $service_option_type) {
  $request_data->setSuccessUrl("http://127.0.0.1/web/PaymentMethodSelect.php?status=success");
  $request_data->setFailureUrl("http://127.0.0.1/web/PaymentMethodSelect.php?status=failure");
  $request_data->setCancelUrl("http://127.0.0.1/web/PaymentMethodSelect.php?status=cancel");
 }
 if ("waon-pc" === $service_option_type
  || "waon-mobile" === $service_option_type) {
  $request_data->setCancelLimit($cancel_limit);
 }
 if ("tcc-redirect" === $service_option_type) {
  $request_data->setTransactionKind("02");
  $request_data->setUserId($user_id);
  $request_data->setCompleteNoticeUrl($completeNoticeUrl);
 }

//TGMDK_MerchantSettingContext::set_merchant_ccid("0");       // マーチャントCCID
//TGMDK_MerchantSettingContext::set_merchant_secret_key("0"); // マーチャントパスワード
//TGMDK_MerchantSettingContext::set_timeout("0");             // コネクションタイムアウト
//TGMDK_MerchantSettingContext::set_dummy_request("0");       // ダミーリクエスト

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

  if ("tcc-redirect" === $service_option_type){
    if (TXN_SUCCESS_CODE === $txn_status) {
      // nanaco決済の場合はリダイレクトする
      header("Location: " . $response_data->getAppUrl(), true, 301);
      exit();
    }
  } else {
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
本画面はVeriTrans4G 電子マネー決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>
<div class="lhtitle">電子マネー決済：取引結果</div>
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
      if (empty($application_url) === false) {
    ?>
      <a href="<?php echo $application_url ?>">起動url</a>
    <?php
      }
    ?>
    <br/>
    </td>
  </tr>
</table>

<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
