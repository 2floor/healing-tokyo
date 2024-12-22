<?php
# Copyright © VeriTrans Inc. All right reserved.
// -------------------------------------------------------------------------
// VeriTrans 4G - Alipay返金の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Refund.php');

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
 * 取引ID
 */
$order_id = @$_POST["orderId"];
/**
 * 金額
 */
$amount= @$_POST["amount"];
/**
 * 返金理由
 */
$reason= @$_POST["reason"];


/**
 * 必須パラメータ値チェック
 */
if (empty($order_id)){
    $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit;
}else if (empty($amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：返金金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }
/**
 * 要求電文パラメータ値の指定
 */
$request_data = new AlipayRefundRequestDto();
$request_data->setOrderId($order_id);
$request_data->setAmount($amount);
$request_data->setReason($reason);


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

    //  var_dump($response_data);
    $page_title = NORMAL_PAGE_TITLE;

    $vResultCode="";
    $mErrMsg="";
    $mStatus="";
    $orderId="";
    $centerTradeId="";
    $balance="";

    $vResultCode=$response_data->getVResultCode();
    $mErrMsg=$response_data->getMerrMsg();
    $mStatus=$response_data->getMstatus();
    $orderId=$response_data->getOrderId();
    $centerTradeId=$response_data->getCenterTradeId();
    $balance=$response_data->getBalance();
    

    // 成功
    if (TXN_SUCCESS_CODE === $mStatus) {
    } else if (TXN_PENDING_CODE === $mStatus) {
        // 失敗
    } else if (TXN_FAILURE_CODE === $mStatus) {
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
    <img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
    <hr />
    <div class="system-message">
        <font size="2"> 本画面はVeriTrans4G Alipay決済の取引サンプル画面です。<br />
            お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
        </font>
    </div>
    <div class="lhtitle">Alipay決済返金：取引結果</div>
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="rititletop">取引ID</td>
            <td class="rivaluetop"><?php echo  $orderId ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">取引ステータス</td>
            <td class="rivalue"><?php echo  $mStatus ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">結果コード</td>
            <td class="rivalue"><?php echo  $vResultCode ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">結果メッセージ</td>
            <td class="rivalue"><?php echo  $mErrMsg ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">決済センターとの取引ID</td>
            <td class="rivalue"><?php echo  $centerTradeId ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">残高</td>
            <td class="rivalue"><?php echo  $balance ?><br /></td>
        </tr>
    </table>

    <br/>
    <a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy;
    VeriTrans Inc. All rights reserved
</body>
</html>