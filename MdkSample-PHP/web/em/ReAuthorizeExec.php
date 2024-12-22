<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 電子マネー決済 再決済請求実行および結果画面のサンプル
// -------------------------------------------------------------------------
/**
 * MDK配置ディレクトリ
 */
define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'ReAuthorize.php');
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
  * nanaco決済：tcc-redirect
  */
  $service_option_type = @$_POST["serviceOptionType"];

 /**
  * 取引ID
  */
  $order_id = @$_POST["orderId"];

 /**
  * 必須パラメータ値チェック
  */
 if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }

 /**
  * 設定ファイルから設定値を読み取り
  */
 $config_file = "../env4sample.ini";
 if (is_readable($config_file)) {
   $env_info = @parse_ini_file($config_file, true);
   $reAuthorizeRedirectionUrl = $env_info["EM"]["tcc.reAuthorizeRedirectionUrl"];
 }

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new EmReAuthorizeRequestDto();
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);

 $request_data->setReAuthorizeRedirectionUrl($reAuthorizeRedirectionUrl);

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
    $application_url = $response_data->getReAuthAppUrl();
    if ("tcc-redirect" === $service_option_type){
        // nanaco決済の場合はリダイレクトする
        header("Location: " . $response_data->getReAuthAppUrl(), true, 301);
        exit();
    }
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
    <td class="rititletop">復旧用アプリケーション起動URL</td>
    <td class="rivaluetop">
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
