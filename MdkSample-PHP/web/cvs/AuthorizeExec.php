<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// コンビニ決済実行および結果画面のサンプル
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

// 変数の初期化
$orderId = "";
$txn_status = "";
$txn_result_code = "";
$error_message = "";
$receipt_number = "";

/**
 * コンビニ区分定義
 */
define('SEVEN_ELEVEN_CODE', 'sej');
define('E_CONTEXT_CODE', 'econ');
define('WELL_NET_CODE', 'other');

require_once(MDK_DIR."3GPSMDK.php");

/**
 * コンビニタイプ
 */
$service_option_type = @$_POST["serviceOptionType"];

/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 支払金額
 */
$payment_amount = @$_POST["amount"];

/**
 * 氏名1（姓）
 */
$last_name = @$_POST["name1"];

/**
 * 氏名2(名)
 */
$first_name = @$_POST["name2"];

/**
 * 電話番号
 */
$tel_number = @$_POST["telNo"];

/**
 * 支払期限
 */
$payment_limit = @$_POST["payLimit"];

/**
 * 支払期限時分
 */
$payment_limit_hhmm = @$_POST["payLimitHhmm"];

/**
 * プッシュURL
 */
$push_url = @$_POST["pushUrl"];

/**
 * 必須パラメータ値チェック（サイトのデータ形式にあわせてバリデートして下さい）
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
 } else if (empty($last_name)) {
  $warning =  "<font color='#ff0000'><b>必須項目：姓が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($first_name)) {
  $warning =  "<font color='#ff0000'><b>必須項目：名が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($tel_number)) {
  $warning =  "<font color='#ff0000'><b>必須項目：電話番号が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($payment_limit)) {
  $warning =  "<font color='#ff0000'><b>必須項目：支払期限が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }

/**
 * 要求電文パラメータ値の指定
 */
 $request_data = new CvsAuthorizeRequestDto();

 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);
 $request_data->setAmount($payment_amount);
 $request_data->setName1($last_name);
 $request_data->setName2($first_name);
 $request_data->setTelNo($tel_number);
 $request_data->setPayLimit($payment_limit);
 $request_data->setPayLimitHhmm($payment_limit_hhmm);
 $request_data->setPushUrl($push_url);
 $request_data->setPaymentType("0");

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
  } else if (TXN_PENDING_CODE === $txn_status) {
  // 失敗
  } else if (TXN_FAILURE_CODE === $txn_status) {
  } else {
    $page_title = ERROR_PAGE_TITLE;
  }
 }

 $orderId = $response_data->getOrderId();
 $receipt_number = $response_data->getReceiptNo();
 $haraikomi_url = $response_data->getHaraikomiUrl();
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
本画面はVeriTrans4G コンビニ決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>
<div class="lhtitle">コンビニ決済：取引結果</div>
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
<br>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">受付番号</td>
    <td class="rivaluetop"><?php echo $receipt_number ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">払込票URL</td>
    <td class="rivalue">
<?php
  if (empty($haraikomi_url) == false) {
?>
      <a href="<?php echo $haraikomi_url ?>"><?php echo $haraikomi_url ?></a>
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
