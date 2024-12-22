<?php
# Copyright(C) 2012 VeriTrans Inc., Ltd. All right reserved.
//-------------------------------------------------------------------------
// VeriTrans4G UPOP決済の結果確認サンプル画面です
// -------------------------------------------------------------------------


define('MDK_DIR', '../tgMdk/');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '取引結果');

require_once(MDK_DIR."3GPSMDK.php");

$page_title = NORMAL_PAGE_TITLE;
$vResultCode="";
$merrMsg="";
$mStatus="";
$serviceType="";
$orderId="";
$custTxn="";
$marchTxn="";
$txnDatetimeJp="";
$txnDatetimeCn="";
$capturedAmount="";
$remainingAmount="";
$settleAmount="";
$settleDate="";
$settleCurrency="";
$settleRate="";
$upopOrderId="";

$vResultCode=htmlspecialchars(@$_POST["vResultCode"]);
$merrMsg=htmlspecialchars(@$_POST["merrMsg"]);
$mstatus=htmlspecialchars(@$_POST["mstatus"]);
$serviceType=htmlspecialchars(@$_POST["serviceType"]);
$orderId=htmlspecialchars(@$_POST["orderId"]);
$custTxn=htmlspecialchars(@$_POST["custTxn"]);
$txnDatetimeJp=htmlspecialchars(@$_POST["txnDatetimeJp"]);
$txnDatetimeCn=htmlspecialchars(@$_POST["txnDatetimeCn"]);
$capturedAmount=htmlspecialchars(@$_POST["capturedAmount"]);
$settleAmount=htmlspecialchars(@$_POST["settleAmount"]);
$settleDate=htmlspecialchars(@$_POST["settleDate"]);
$settleCurrency=htmlspecialchars(@$_POST["settleCurrency"]);
$settleRate=htmlspecialchars(@$_POST["settleRate"]);
$upopOrderId=htmlspecialchars(@$_POST["upopOrderId"]);

$authInfo = htmlspecialchars(@$_POST["authInfo"]);
// マーチャントユーティリティクラス作成
$m_util = new TGMDK_MerchantUtility();
$keys = preg_split("/-/", "$authInfo");
$auth = 1;

if (sizeof($keys) != 3 ) {
    $auth = 0;

}else {
    // base64エンコード用クラス
    $cipher = new TGMDK_Cipher();
    $merchant_cc_id = $cipher->base64Dec($keys[0]);
    $now = $cipher->base64Dec($keys[1]);
    $received_hash = $cipher->base64Dec($keys[2]);
    $conf  = TGMDK_Config::getInstance();
    $array = $conf->getTransactionParameters();
    $merchant_secret_key = $array[TGMDK_Config::MERCHANT_SECRET_KEY]; // マーチャントパスワード

    // ハッシュ生成
    $hash = TGMDK_Util::get_hash_256($merchant_cc_id . $now . $merchant_secret_key);
    if (strcmp($hash,  $received_hash) != 0 ) {
        $auth = 0;
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
    <img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
    <hr />
    <div class="system-message">
        <font size="2"> 本画面はVeriTrans4G UPOP決済の取引サンプル画面です。<br />
            お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
        </font>
    </div>
    <div class="lhtitle">UPOP決済：取引結果</div>
    <table border="0" cellpadding="0" cellspacing="0">
        <?php  if ($auth == 0)  { ?>

        <tr>
            <td class="rititletop">認証情報</td>
            <td class="rivaluetop"><?php echo "認証失敗した、改竄されたおそれがあります！" ?><br /></td>
        </tr>
        <?php  } else {?>
        <tr>
            <td class="rititletop">取引ステータス</td>
            <td class="rivaluetop"><?php echo  $mstatus ?><br /></td>
        </tr>

        <tr>
            <td class="rititle">結果コード</td>
            <td class="rivalue"><?php echo  $vResultCode ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">結果メッセージ</td>
            <td class="rivalue"><?php echo  $merrMsg ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">取引ID</td>
            <td class="rivalue"><?php echo  $orderId ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">トランザクションID(取引毎につけるID)</td>
            <td class="rivalue"><?php echo  $custTxn ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">決済時刻（日本時間）</td>
            <td class="rivalue"><?php echo  $txnDatetimeJp ?><br /></td>
        </tr>

        <tr>
            <td class="rititle">決済時刻（中国時間）</td>
            <td class="rivalue"><?php echo  $txnDatetimeCn ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">元売上金額</td>
            <td class="rivalue"><?php echo  $capturedAmount ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">清算金額</td>
            <td class="rivalue"><?php echo  $settleAmount ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">清算日付</td>
            <td class="rivalue"><?php echo  $settleDate ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">清算通貨種類</td>
            <td class="rivalue"><?php echo  $settleCurrency ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">清算レート</td>
            <td class="rivalue"><?php echo  $settleRate ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">決済センターとの取引ID</td>
            <td class="rivalue"><?php echo  $upopOrderId ?><br /></td>
        </tr>
        <?php  } ?>

    </table>

    <br>
    <a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy;
    VeriTrans Inc. All rights reserved
