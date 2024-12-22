<?php
# Copyright © VeriTrans Inc. All rights reserved.

define('MDK_DIR', '../tgMdk/');
require_once(MDK_DIR."3GPSMDK.php");

// -------------------------------------------------------------------------
// LINE Payの実行および結果画面のサンプル
// -------------------------------------------------------------------------

/**
 * 取引ID
 */
$result_order_id = htmlspecialchars(@$_GET["orderId"]);

/**
 * 取引ステータス
 */
$txn_status = htmlspecialchars(@$_GET["mstatus"]);

/**
 * 結果コード
 */
$txn_result_code = htmlspecialchars(@$_GET["vResultCode"]);

/**
 * 決済種別
 */
$txn_type = htmlspecialchars(@$_GET["txnType"]);
if($txn_type === "Authorize"){
    $str_command = "決済";
}

/**
 * LINE Pay取引ID
 */
$txn_linepay_order_id = htmlspecialchars(@$_GET["linepayOrderId"]);

/**
 * 取引結果
 */
$result = htmlspecialchars(@$_GET["result"]);
if($result === "SUCCESS"){
    $str_result = "完了";
}
elseif($result === "CANCEL"){
    $str_result = "キャンセル";
}
elseif($result === "ERROR"){
    $str_result = "エラー";
}
$conf = TGMDK_Config::getInstance();
$array = $conf->getConnectionParameters();
$merchant_cc_id = $array[TGMDK_Config::MERCHANT_CC_ID];
$merchant_pw = $array[TGMDK_Config::MERCHANT_SECRET_KEY];
$charset = "UTF-8";

$check_result = TGMDK_AuthHashUtil::checkAuthHash(@$_GET, $merchant_cc_id, $merchant_pw, $charset);
if (!isset($check_result) || $check_result == false) {
    $warn_msg = "<font color='#ff0000'><b>【パラメータ改竄】パラメータ情報が改竄されています。</b></font><br/><br/>";
} else {
    echo "<!-- vAuthInfo check is OK -->";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>取引結果（<?php echo $result ?>）</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G LINE Payの取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<?php
  if (!empty($warn_msg)) {
    echo $warn_msg."<br>";
  }
?>

<div class="lhtitle">LINE Pay：取引結果（<?php echo $str_command ?><?php echo $str_result ?>）</div>
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
    <td class="rititle">LINE Pay取引ID</td>
    <td class="rivalue"><?php echo $txn_linepay_order_id ?><br/></td>
  </tr>
</table>
<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>

