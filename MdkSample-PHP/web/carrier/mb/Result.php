<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../../tgMdk/');
require_once(MDK_DIR."3GPSMDK.php");

// 取引ID
$result_order_id = htmlspecialchars(@$_GET["orderId"]);
// 取引ステータス
$txn_status = htmlspecialchars(@$_GET["mstatus"]);
// 結果コード
$txn_result_code = htmlspecialchars(@$_GET["vResultCode"]);

/**
 * 決済種別
 */
$command = htmlspecialchars(@$_GET["command"]);
if($command === "Authorize"){
    $str_command = "決済";
}
elseif($command === "Terminate"){
    $str_command = "継続課金終了";
}

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
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>取引結果（<?php echo $result ?>）</title>
</head>
<body>
<img alt='Paymentロゴ' src='../../WEB-IMG/VeriTrans_Payment.png'>
<br><br>
<font size="2">携帯用の取引結果サンプル画面です。</font>
<br><br>
キャリア決済：<br>
取引結果（<?php echo $str_command ?><?php echo $str_result ?>）
<br><br>

<?php
    if (isset($warn_msg)) echo $warn_msg;
?>

=== 処理結果 ===<br>
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

================<br>
<br>
<img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'>
<br>Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>

