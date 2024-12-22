<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 銀行振込決済の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_SUCCESS_CODE', 'success');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '取引結果');

require_once(MDK_DIR."3GPSMDK.php");
/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 金額
 */
$amount = @$_POST["amount"];

/**
 * 登録時振込人名
 */
$entry_transfer_name = @$_POST["entryTransferName"];

/**
 * 登録時振込番号
 */
$entry_transfer_number = @$_POST["entryTransferNumber"];

/**
 * 振込期限
 */
$transfer_expired_date = @$_POST["transferExpiredDate"];

/**
 * 口座管理方式
 */
$account_manage_type = @$_POST["accountManageType"];

/**
 * 支店コード
 */
$branch_code = @$_POST["branchCode"];

/**
 * 口座番号
 */
$account_number = @$_POST["accountNumber"];

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
//サーバ内部指定
} else if (empty($amount)) {
  $warning =  "<font color='#ff0000'><b>Unset Amount<br>(必須項目：金額が指定されていません)</b></font>";
  include_once(INPUT_PAGE);
  exit;
}


/**
 * 要求電文パラメータ値の指定
 */
$request_data = new VirtualaccAuthorizeRequestDto();

$request_data->setOrderId($order_id);
$request_data->setAmount($amount);
$request_data->setEntryTransferName($entry_transfer_name);
$request_data->setEntryTransferNumber($entry_transfer_number);
$request_data->setTransferExpiredDate($transfer_expired_date);
$request_data->setAccountManageType($account_manage_type);
$request_data->setBranchCode($branch_code);
$request_data->setAccountNumber($account_number);
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
   * 振込人名取得
   */
  $transfer_name = $response_data->getTransferName();
  /**
   * 銀行名取得
   */
  $bank_name = $response_data->getBankName();
  /**
   * 銀行コード取得
   */
  $bank_code = $response_data->getBankCode();
  /**
   * 支店名取得
   */
  $branch_name = $response_data->getBranchName();
  /**
   * 支店コード取得
   */
  $branch_code = $response_data->getBranchCode();
  /**
   * 口座種別取得
   */
  $account_type = $response_data->getAccountType();
  /**
   * 口座番号取得
   */
  $account_number = $response_data->getAccountNumber();
  /**
   * 口座名義取得
   */
  $account_name = $response_data->getAccountName();
  
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
本画面はVeriTrans4G 銀行振込決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>


<div class="lhtitle">銀行振込決済：取引結果</div>

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
    <td class="rititle">振込人名</td>
    <td class="rivalue"><?php echo $transfer_name ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">銀行名</td>
    <td class="rivalue"><?php echo $bank_name ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">銀行コード</td>
    <td class="rivalue"><?php echo $bank_code ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">支店名</td>
    <td class="rivalue"><?php echo $branch_name ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">支店コード</td>
    <td class="rivalue"><?php echo $branch_code ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">口座種別</td>
    <td class="rivalue"><?php echo $account_type ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">口座番号</td>
    <td class="rivalue"><?php echo $account_number ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">口座名義</td>
    <td class="rivalue"><?php echo $account_name ?><br/></td>
  </tr>
</table>
<br>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>

