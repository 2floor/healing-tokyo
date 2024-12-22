<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済継続課金終了の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

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
 * 端末種別
 */
$terminal_kind = @$_POST["terminalKind"];

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
 * 強制終了
 */
$force = @$_POST["force"];

/**
 * 必須パラメータ値チェックエラー時遷移先
 */
if($force === "true") {
  define('INPUT_PAGE', 'Terminate_Admin.php');
} else {
  define('INPUT_PAGE', 'Terminate.php');
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
 }

/**
 * 要求電文パラメータ値の指定
 */
 $request_data = new CarrierTerminateRequestDto();

 $request_data->setOrderId($order_id);
 $request_data->setServiceOptionType($service_option_type);
 if ($service_option_type === "sb_matomete" ||
     $service_option_type === "flets" ||
     $service_option_type === "docomo" && $force !== "true") {
  $request_data->setTerminalKind($terminal_kind);
 }
 $request_data->setSuccessUrl($successUrl);
 $request_data->setCancelUrl($cancelUrl);
 $request_data->setErrorUrl($errorUrl);
 $request_data->setPushUrl($pushUrl);

 // 強制解約かどうかの設定
 if ($service_option_type === "docomo" || $service_option_type === "sb_matomete") {
  $request_data->setForce($force);
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
  /**
   * レスポンスコンテンツ取得
   */
  $response_html = $response_data->getResponseContents();
  /**
   * 継続課金終了日時取得
   */
  $terminateDateTime = $response_data->getTerminateDatetime();
  // ログ
  $test_log = "<!-- vResultCode=" . $txn_result_code . " -->";


  if($response_html){
    if (TXN_SUCCESS_CODE === $txn_status) {
      // 成功
      echo $response_html . $test_log;
      exit;
    } else {
      // エラーページ表示
      $page_title = ERROR_PAGE_TITLE;
    }
  } else{
    // 成功
    if (TXN_SUCCESS_CODE === $txn_status) {
      $terminateDateTime = $response_data->getTerminateDatetime();
    } else if (TXN_PENDING_CODE === $txn_status) {
      // 失敗
    } else if (TXN_FAILURE_CODE === $txn_status) {
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
<img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G キャリア決済の継続課金終了取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">キャリア決済継続課金終了：取引結果</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">取引ID</td>
    <td class="rivaluetop"><?php echo $result_order_id ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">取引ステータス</td>
    <td class="rivalue"><?php echo $txn_status ?></td>
  </tr>
  <tr>
    <td class="rititle">結果コード</td>
    <td class="rivalue"><?php echo $txn_result_code ?></td>
  </tr>
  <tr>
    <td class="rititle">結果メッセージ</td>
    <td class="rivalue"><?php echo $error_message ?></td>
  </tr>
<?php if(isset($terminateDateTime)) { ?>
   <tr>
    <td class="rititle">継続課金終了日時</td>
    <td class="rivalue"><?php echo $terminateDateTime ?><br/></td>
  </tr>
<?php } ?>
</table>

<br/>

<?php if($force === "true") { ?>
<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;
<?php } else { ?>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;
<?php } ?>

<hr>
<img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>

