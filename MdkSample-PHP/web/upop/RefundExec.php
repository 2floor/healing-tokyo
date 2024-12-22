<?php
# Copyright(C) 2012 VeriTrans Inc., Ltd. All right reserved.
// -------------------------------------------------------------------------
// VeriTrans 4G - UPOP返金の実行および結果画面のサンプル
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
$amount= @$_POST["amount"];


/**
 * 必須パラメータ値チェック
 */
if (empty($order_id)){
    $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit;
}else if (empty($amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
  //消費者指定
 }
/**
 * 要求電文パラメータ値の指定
 */
$request_data = new UpopRefundRequestDto();
$request_data->setOrderId($order_id);
$request_data->setAmount($amount);

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

    //var_dump($response_data);
    $page_title = NORMAL_PAGE_TITLE;

    $vResultCode="";
    $mErrMsg="";
    $mStatus="";
    $serviceType="";
    $orderId="";
    $custTxn="";
    $marchTxn="";
    $txnVersion="";
    $txnDatetimeJp="";
    $txnDatetimeCn="";
    $capturedAmount="";
    $remainingAmount="";
    $settleAmount="";
    $ssettleDate="";
    $settleCurrency="";
    $settleRate="";
    $upopOrderId="";

    $vResultCode=$response_data->getVResultCode();
    $mErrMsg=$response_data->getMerrMsg();
    $mStatus=$response_data->getMstatus();
    $serviceType=$response_data->getServiceType();
    $orderId=$response_data->getOrderId();
    $custTxn=$response_data->getCustTxn();
    $marchTxn=$response_data->getMarchTxn();
    $txnVersion=$response_data->getTxnVersion();
    $txnDatetimeJp=$response_data->getTxnDatetimeJp();
    $txnDatetimeCn=$response_data->getTxnDatetimeCn();
    $capturedAmount=$response_data->getCapturedAmount();
    $remainingAmount=$response_data->getRemainingAmount();
    $settleAmount=$response_data->getSettleAmount();
    $settleDate=$response_data->getSettleDate();
    $settleCurrency=$response_data->getSettleCurrency();
    $settleRate=$response_data->getSettleRate();
    $upopOrderId=$response_data->getUpopOrderId();

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
        <font size="2"> 本画面はVeriTrans4G UPOP決済の取引サンプル画面です。<br />
            お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
        </font>
    </div>
    <div class="lhtitle">UPOP決済：取引結果</div>
    <table border="0" cellpadding="0" cellspacing="0">

        <tr>
            <td class="rititletop">取引ステータス</td>
            <td class="rivaluetop"><?php echo  $mStatus ?><br /></td>
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
            <td class="rititle">取引ID</td>
            <td class="rivalue"><?php echo  $orderId ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">トランザクションID(取引毎につけるID)</td>
            <td class="rivalue"><?php echo  $custTxn ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">電文ＩＤ</td>
            <td class="rivalue"><?php echo  $marchTxn ?><br /></td>
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
            <td class="rititle">返品後の金額</td>
            <td class="rivalue"><?php echo  $remainingAmount ?><br /></td>
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
    </table>

    <br>
    <a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy;
    VeriTrans Inc. All rights reserved