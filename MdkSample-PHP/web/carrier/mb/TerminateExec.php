<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済継続課金終了の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../../tgMdk/');

define('INPUT_PAGE', 'Terminate.php');

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
 if($service_option_type === "docomo"){
   $force = @$_POST["force"];
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
 if ($service_option_type !== "au") {
  $request_data->setTerminalKind($terminal_kind);
  $request_data->setSuccessUrl($successUrl);
  $request_data->setCancelUrl($cancelUrl);
  $request_data->setErrorUrl($errorUrl);
 }
 $request_data->setPushUrl($pushUrl);

 if($service_option_type === "docomo"){
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
    $response_html = mb_convert_encoding($response_data->getResponseContents(), "SJIS", "UTF-8");
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
    }
    else{
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
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title><?php echo $page_title ?></title>
</head>
<body>
<img alt="Paymentロゴ" src="../../WEB-IMG/VeriTrans_Payment.png">
<br><br>
キャリア決済：取引結果<br>
<br>
取引ID<br>
<?php echo $result_order_id ?><br>
<br>
取引ステータス<br>
<?php echo $txn_status ?><br>
<br>
結果コード<br>
<?php echo $txn_result_code ?><br>
<br>
<?php if(isset($terminateDateTime)) { ?>
継続課金終了日時<br>
<?php echo $terminateDateTime ?><br>
<br>
<?php } ?>
結果メッセージ<br>
<?php echo mb_convert_encoding($error_message, "SJIS", "UTF-8") ?><br>
<br/>
<img alt="VeriTransロゴ" src="../../WEB-IMG/VeriTransLogo_WH.png">
<br>Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>

