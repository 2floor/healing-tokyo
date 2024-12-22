<?php
# Copyright © VeriTrans Inc. All right reserved.
// -------------------------------------------------------------------------
// VeriTrans 4G - Alipay確認の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Confirm.php');

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
 * レスポンスタイプ
 */
$response_type = @$_POST["responseType"];


/**
 * 必須パラメータ値チェック
 */
if (empty($order_id)){
    $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit;
}
/**
 * 要求電文パラメータ値の指定
 */
$request_data = new AlipayConfirmRequestDto();
$request_data->setOrderId($order_id);
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

    //  var_dump($response_data);
    $page_title = NORMAL_PAGE_TITLE;

    $vResultCode="";
    $mErrMsg="";
    $mStatus="";
    $orderId="";
    $centerTradeId="";
    $custTxn="";
    $payTimeJp="";
    $payTimeCn="";
    $buyerChargedAmountCny="";

    $vResultCode=$response_data->getVResultCode();
    $mErrMsg=$response_data->getMerrMsg();
    $mStatus=$response_data->getMstatus();
    $orderId=$response_data->getOrderId();
    $centerTradeId=$response_data->getCenterTradeId();
    $custTxn=$response_data->getCustTxn();
    $payTimeJp=$response_data->getPayTimeJp();
    $payTimeCn=$response_data->getPayTimeCn();
    $buyerChargedAmountCny=$response_data->getBuyerChargedAmountCny();


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
    <div class="lhtitle">Alipay決済確認：取引結果</div>
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
            <td class="rititle">トランザクションID(取引毎につけるID)</td>
            <td class="rivalue"><?php echo  $custTxn ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">決済センターとの取引ID</td>
            <td class="rivalue"><?php echo  $centerTradeId ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">決済時刻（日本時間）</td>
            <td class="rivalue"><?php echo  $payTimeJp ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">決済時刻（中国時間）</td>
            <td class="rivalue"><?php echo  $payTimeCn ?><br /></td>
        </tr>
        <tr>
            <td class="rititle">請求金額（中国元）</td>
            <td class="rivalue"><?php echo  $buyerChargedAmountCny ?><br /></td>
        </tr>
    </table>

    <br/>
    <a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy;
    VeriTrans Inc. All rights reserved
</body>
</html>