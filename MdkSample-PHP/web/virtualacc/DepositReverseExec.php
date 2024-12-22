<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 銀行振込入金取消の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'DepositReverse.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_SUCCESS_CODE', 'success');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '入金取消結果');

require_once(MDK_DIR."3GPSMDK.php");
/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 入金ID
 */
$deposit_id = @$_POST["depositId"];

/**
 * サービスオプションタイプ
 */
$service_option_type = "resona";


/**
 * 必須パラメータ値チェック
 */
//サーバ内部指定
if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>Unset Order Id<br>(必須項目：取引IDが指定されていません)</b></font>";
  include_once(INPUT_PAGE);
  exit;
}


/**
 * 要求電文パラメータ値の指定
 */
$request_data = new VirtualaccDepositReverseRequestDto();
$request_data->setOrderId($order_id);
$request_data->setDepositId($deposit_id);
$request_data->setServiceOptionType($service_option_type);

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
   * 取引ステータス取得
   */
  $txn_status = $response_data->getMStatus();
  /**
   * 結果コード取得
   */
  $txn_result_code = $response_data->getVResultCode();
  /**
   * 結果メッセージ取得
   */
  $error_message = $response_data->getMerrMsg();
  /**
   * 入金総額取得
   */
  $total_deposit_amount = $response_data->getTotalDepositAmount();
  

  // 成功
  if (TXN_SUCCESS_CODE === $txn_status) {
  // 失敗
  } else if (TXN_FAILURE_CODE === $txn_status) {
  } else {
    $page_title = ERROR_PAGE_TITLE;
  }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title><?php echo $page_title ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 銀行振込決済の入金取消取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>


<div class="lhtitle">銀行振込決済入金取消：取引結果</div>

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
  <tr>
    <td class="rititle">入金総額</td>
    <td class="rivalue"><?php echo $total_deposit_amount ?><br/></td>
  </tr>
</table>
<br>

<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>

