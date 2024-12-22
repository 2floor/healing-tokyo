<?php
# Copyright © VeriTrans Inc. All right reserved.
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
 * 外貨
 */
$currency = @$_POST["currency"];

/**
 * ユーザ識別コード
 */
$identity_code = @$_POST["identityCode"];


/**
 * 商品名
 */
$commodity_name = @$_POST["commodityName"];

/**
 * 商品紹介
 */
$commodity_description = @$_POST["commodityDescription"];

/**
 * 商品ID
 */
$commodity_id = @$_POST["commodityId"];

/**
 * 決済種別
 */
$pay_type = @$_POST["payType"];

/**
 * 決済完了時URL
 */
$successUrl = @$_POST["successUrl"];

/**
 * 決済エラー時URL
 */
$errorUrl = @$_POST["errorUrl"];

/**
 * レスポンスタイプ
 */
$response_type = @$_POST["responseType"];

$prop = @parse_ini_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "tgMdk" . DIRECTORY_SEPARATOR . "3GPSMDK.properties", true);

/**
 * 必須パラメータ値チェック
 */
// 取引ID指定
if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
// 金額指定
} else if (empty($payment_amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
// 外貨指定
} else if (empty($currency)){
  $warning =  "<font color='#ff0000'><b>必須項目：通貨が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
} else if ($prop["Service"]["DUMMY_REQUEST"] === "1" && "CNY" === $currency && $payment_amount < 100){
  $warning =  "<font color='#ff0000'><b>不正項目：金額には100以上の値を指定してください</b></font>";
  include_once(INPUT_PAGE);
  exit;
// 決済完了時URL指定
} else if (empty($successUrl) && $pay_type === "0") {
  $warning =  "<font color='#ff0000'><b>必須項目：決済完了時URLが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
// 決済エラー時URL指定
} else if (empty($errorUrl) && $pay_type === "0") {
  $warning =  "<font color='#ff0000'><b>必須項目：決済エラー時URLが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
// 商品名指定
} else if (empty($commodity_name)){
  $warning =  "<font color='#ff0000'><b>必須項目：商品名が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
}

/**
 * 要求電文パラメータ値の指定
 */
$request_data = new AlipayAuthorizeRequestDto();

$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
$request_data->setCurrency($currency);
$request_data->setIdentityCode($identity_code);
$request_data->setCommodityName($commodity_name);
$request_data->setCommodityDescription($commodity_description);
$request_data->setCommodityId($commodity_id);
$request_data->setSuccessUrl($successUrl);
$request_data->setErrorUrl($errorUrl);
$request_data->setPayType($pay_type);
$request_data->setResponseType($response_type);

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
  $entry_form = $response_data->getEntryForm();

  if ($pay_type === "1" || $pay_type === "2") {
    /**
     * トランザクションID(取引毎につけるID)取得
     */
    $cust_txn = $response_data->getCustTxn();
    /**
     * 決済センターとの取引ID取得
     */
    $center_trade_id = $response_data->getCenterTradeId();
  }
  if ($pay_type === "1") {
    /**
     * 決済時刻（日本時間）取得
     */
    $pay_time_jp = $response_data->getPayTimeJp();
    /**
     * 決済時刻（中国時間）取得
     */
    $pay_time_cn = $response_data->getPayTimeCn();
    /**
     * 請求金額（中国元）取得
     */
    $buyer_charged_amount_cny = $response_data->getBuyerChargedAmountCny();
  } else if ($pay_type === "2") {
    /**
     * QRコード取得
     */
    $qr_code = $response_data->getQrCode();
    /**
     * QRコード画像URL（標準）取得
     */
    $qr_code_img_url = $response_data->getQrCodeImgUrl();
    /**
     * QRコード画像URL（縮小）取得
     */
    $qr_code_small_img_url = $response_data->getQrCodeSmallImgUrl();
    /**
     * QRコード画像URL（拡大）取得
     */
    $qr_code_large_img_url = $response_data->getQrCodeLargeImgUrl();
  }

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
本画面はVeriTrans4G Alipay決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>
<?php echo $entry_form ?>
<div class="lhtitle">Alipay決済：取引結果</div>
<?php if($pay_type === "2" && $txn_status === "success") { ?>
<table border="0" cellpadding="0" cellspacing="0" style="width:1830px;">
<?php } else { ?>
<table border="0" cellpadding="0" cellspacing="0">
<?php } ?>
  <tr>
    <td class="rititletop" style="width:180px;">取引ID</td>
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
<?php if($pay_type === "1" || $pay_type === "2") { ?>
  <tr>
    <td class="rititle">トランザクションID(取引毎につけるID)</td>
    <td class="rivalue"><?php echo $cust_txn ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">決済センターとの取引ID</td>
    <td class="rivalue"><?php echo $center_trade_id ?><br/></td>
  </tr>
<?php } ?>
<?php if($pay_type === "1") { ?>
  <tr>
    <td class="rititle">決済時刻（日本時間）</td>
    <td class="rivalue"><?php echo $pay_time_jp ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">決済時刻（中国時間）</td>
    <td class="rivalue"><?php echo $pay_time_cn ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">請求金額（中国元）</td>
    <td class="rivalue"><?php echo $buyer_charged_amount_cny ?><br/></td>
  </tr>
<?php } else if($pay_type === "2") { ?>
  <tr>
    <td class="rititle">QRコード</td>
<?php if($txn_status === "success") { ?>
    <td class="rivalue" style="width:1620px;"><?php echo $qr_code ?><br/>
<?php } else { ?>
    <td class="rivalue"><br/>
<?php } ?>
    </td>
  </tr>
  <tr>
    <td class="rititle">QRコード画像URL（標準）</td>
<?php if($txn_status === "success") { ?>
    <td class="rivalue" style="width:1620px;"><?php echo $qr_code_img_url ?><br/>
      <iframe frameborder="0" height="552" width="552" scrolling="NO" src="<?php echo $qr_code_img_url ?>" marginwidth="0"></iframe><br />
<?php } else { ?>
    <td class="rivalue"><br/>
<?php } ?>
    </td>
  </tr>
  <tr>
    <td class="rititle">QRコード画像URL（縮小）</td>
<?php if($txn_status === "success") { ?>
    <td class="rivalue" style="width:1620px;"><?php echo $qr_code_small_img_url ?><br/>
      <iframe frameborder="0" height="296" width="296" scrolling="NO" src="<?php echo $qr_code_small_img_url ?>" marginwidth="0"></iframe><br />
<?php } else { ?>
    <td class="rivalue"><br/>
<?php } ?>
    </td>
  </tr>
  <tr>
    <td class="rititle">QRコード画像URL（拡大）</td>
<?php if($txn_status === "success") { ?>
    <td class="rivalue" style="width:1620px;"><?php echo $qr_code_large_img_url ?><br/>
      <iframe frameborder="0" height=1586" width="1586" scrolling="NO" src="<?php echo $qr_code_large_img_url ?>" marginwidth="0"></iframe><br />
<?php } else { ?>
    <td class="rivalue"><br/>
<?php } ?>
    </td>
  </tr>
<?php } ?>
</table>
<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>

