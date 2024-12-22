<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 決済同時会員入会処理の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');
define('INPUT_PAGE', 'EntryAndCard.php');

define('PAY_NOW_ID_FAILURE_CODE', 'failure');
define('PAY_NOW_ID_PENDING_CODE', 'pending');
define('PAY_NOW_ID_SUCCESS_CODE', 'success');
define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');

define('NORMAL_PAGE_TITLE', 'VeriTrans 4G - 決済同時会員入会サンプル画面');

define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

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
 * 与信方法
 */
$is_with_capture = @$_POST["withCapture"];
if ("1" == $is_with_capture) {
    $is_with_capture = TRUE_FLAG_CODE;
} else {
    $is_with_capture = FALSE_FLAG_CODE;
}
/**
 * 支払い方法,支払い回数
 */
$jpo1 = @$_POST["jpo1"];
$jpo2 = @$_POST["jpo2"];

if ((!empty($jpo1)) && (("10" == $jpo1)|| ("80" == $jpo1))) {
    $jpo = $jpo1;
}else if ((!empty($jpo1) && ("61" == $jpo1)) && (!empty($jpo2))) {
    $jpo = $jpo1."C".$jpo2;
}
/**
 * トークン
 */
$token = @$_POST["token"];

/**
 * 会員ID
 */
$account_id = @$_POST["accountId"];

/**
 * 課金グループID
 */
$group_id = @$_POST["groupId"];

/**
 * 課金開始日
 */
$start_date = @$_POST["startDate"];

/**
 * 課金終了日
 */
$end_date = @$_POST["endDate"];

/**
 * 都度／初回課金金額
 */
$one_time_amount = @$_POST["oneTimeAmount"];

/**
 * 継続課金金額
 */
$recarring_amount = $_POST["recarringAmount"];

/**
 * パラメータ値チェック
 */
if (empty($order_id)){
    $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit;
} else if (empty($payment_amount)) {
    $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit;
}

/**
 * 要求電文パラメータ値の指定
 */
$request_data = new CardAuthorizeRequestDto();
$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
$request_data->setWithCapture($is_with_capture);
if (isset($jpo)) {
    $request_data->setJpo($jpo);
}
$request_data->setToken($token);
$request_data->setAccountId($account_id);
$request_data->setGroupId($group_id);
$request_data->setStartDate($start_date);
$request_data->setEndDate($end_date);
$request_data->setOneTimeAmount($one_time_amount);
$request_data->setRecurringAmount($recarring_amount);

/**
 * 実施
 */
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

//予期しない例外
if (!isset($response_data)) {
    $page_title = ERROR_PAGE_TITLE;
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
     * PayNowIDレスポンス取得
     */
    $pay_now_id_res = $response_data->getPayNowIdResponse();
    $pay_now_id_status = "";
    if (isset($pay_now_id_res)) {
        /**
         * PayNowIDステータス取得
         */
        $pay_now_id_status = $pay_now_id_res->getStatus();
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
    <span style="font-size: small;">
        本画面はVeriTrans4G 決済同時会員入会のサンプル画面です。<br/>
        お客様ECサイトのVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
    </span>
</div>

<div class="lhtitle">決済同時会員入会実行結果</div>
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
       <td class="rititlecommon">PayNowIDステータス</td>
       <td class="rivaluecommon"><?php echo $pay_now_id_status ?><br/></td>
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
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>
