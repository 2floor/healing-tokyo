<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード決済の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '取引結果');

require_once(MDK_DIR . "3GPSMDK.php");

/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 支払金額
 */
$payment_amount = @$_POST["amount"];

/**
 * トークン
 */
$token = @$_POST["token"];

/**
 * 与信方法
 */
$is_with_capture = @$_POST["withCapture"];
if ("1" == $is_with_capture) {
    $is_with_capture = TRUE_FLAG_CODE;
} else {
    $is_with_capture = FALSE_FLAG_CODE;
}

/**
 * 支払オプション
 */
$jpo1 = @$_POST["jpo1"];
$jpo2 = @$_POST["jpo2"];

if ((!empty($jpo1)) && (("10" == $jpo1) || ("80" == $jpo1))) {
    $jpo = $jpo1;
} else if ((!empty($jpo1) && ("61" == $jpo1)) && (!empty($jpo2))) {
    $jpo = $jpo1 . "C" . $jpo2;
}

/**
 * 必須パラメータ値チェック
 */
if (empty($order_id)) {
    $warning = "<span style='color:red;'><b>必須項目：取引IDが指定されていません</b></span>";
    include_once(INPUT_PAGE);
    exit;
} else if (empty($payment_amount)) {
    $warning = "<span style='color:red;'><b>必須項目：金額が指定されていません</b></span>";
    include_once(INPUT_PAGE);
    exit;
}

/**
 * 要求電文パラメータ値の指定
 */
$request_data = new CardAuthorizeRequestDto();

$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
$request_data->setToken($token);
$request_data->setWithCapture($is_with_capture);
if (isset($jpo)) {
    $request_data->setJpo($jpo);
}

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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Language" content="ja"/>
    <title><?php echo $page_title ?></title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
<hr/>
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G カード決済の取引サンプル画面です。<br/>
        お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
    </span>
</div>

<div class="lhtitle">カード決済：取引結果</div>
<table style="border-width: 0; padding: 0; border-collapse: collapse;">
    <tr>
        <td class="rititlecommon">取引ID</td>
        <td class="rivaluecommon"><?php echo $result_order_id ?><br/></td>
    </tr>
    <tr>
        <td class="rititlecommon">取引ステータス</td>
        <td class="rivaluecommon"><?php echo $txn_status ?><br/></td>
    </tr>
    <tr>
        <td class="rititlecommon">結果コード</td>
        <td class="rivaluecommon"><?php echo $txn_result_code ?><br/></td>
    </tr>
    <tr>
        <td class="rititlecommon">結果メッセージ</td>
        <td class="rivaluecommon"><?php echo $error_message ?><br/></td>
    </tr>
</table>
<br/>
<table style="border-width: 0; padding: 0; border-collapse: collapse">
    <tr>
        <td class="rititlecommon">カード番号</td>
        <td class="rivaluecommon"><?php echo $response_data->getReqCardNumber() ?><br/></td>
    </tr>
    <tr>
        <td class="rititlecommon">承認番号</td>
        <td class="rivaluecommon"><?php echo $response_data->getResAuthCode() ?><br/></td>
    </tr>
</table>

<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>

<hr/>
<img alt="VeriTransロゴ" src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>

