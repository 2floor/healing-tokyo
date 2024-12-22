<?php
# Copyright © VeriTrans Inc. All rights reserved.

define('MDK_DIR', '../tgMdk/');
require_once(MDK_DIR."3GPSMDK.php");

// -------------------------------------------------------------------------
// MasterPass決済の実行および結果画面のサンプル
// -------------------------------------------------------------------------

/**
 * 取引ID
 */
$result_order_id = htmlspecialchars(@$_POST["orderId"]);

/**
 * 取引ステータス
 */
$txn_status = htmlspecialchars(@$_POST["mstatus"]);

/**
 * 結果コード
 */
$txn_result_code = htmlspecialchars(@$_POST["vResultCode"]);

/**
 * 決済種別
 */
$txn_command = htmlspecialchars(@$_GET["command"]);
$str_commandEng = "";
$str_commandJpn = "";
if($txn_command === "Authorize"){
    $str_commandEng = "Authorize";
    $str_commandJpn = "決済";
}

/**
 * 取引結果
 */
$result = htmlspecialchars(@$_GET["result"]);
if($result === "SUCCESS"){
    $str_resultEng = "Success";
    $str_resultJpn = "完了";
}
elseif($result === "CANCEL"){
    $str_resultEng = "Cancel";
    $str_resultJpn = "キャンセル";
}
elseif($result === "ERROR"){
    $str_resultEng = "Error";
    $str_resultJpn = "エラー";
}
$conf = TGMDK_Config::getInstance();
$array = $conf->getConnectionParameters();
$merchant_cc_id = $array[TGMDK_Config::MERCHANT_CC_ID];
$merchant_pw = $array[TGMDK_Config::MERCHANT_SECRET_KEY];
$charset = "UTF-8";

$check_result = TGMDK_AuthHashUtil::checkAuthHash(@$_POST,$merchant_cc_id, $merchant_pw, $charset);
if (!isset($check_result) || $check_result == false) {
    $warn_msg = "<font color='#ff0000'><b>Parameter is altered dishonestly<br>(【パラメータ改竄】パラメータ情報が改竄されています。)</b></font><br/><br/>";
} else {
    echo "<!-- vAuthInfo check is OK -->";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>Transaction Result (<?php echo $str_resultEng ?>)</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G MasterPass決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<?php
  if (!empty($warn_msg)) {
    echo $warn_msg."<br>";
  }
?>


<div class="lhtitle">MasterPass Transaction Result (<?php echo $str_commandEng ?><?php echo $str_resultEng ?>)<br/>(決済：取引結果 (<?php echo $str_commandJpn ?><?php echo $str_resultJpn ?>))</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">Order ID<br/>(取引ID)</td>
    <td class="rivaluetop"><?php echo $result_order_id ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Status<br/>(取引ステータス)</td>
    <td class="rivalue"><?php echo $txn_status ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Code<br/>(結果コード)</td>
    <td class="rivalue"><?php echo $txn_result_code ?><br/></td>
  </tr>
</table>

<br/>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;
<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>

