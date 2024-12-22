<?php
# Copyright(C) 2012 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// 永久不滅ポイント(永久不滅ウォレット)ユーザ認可実行サンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('RESULT_PAGE', 'Result.php');
define('INPUT_PAGE', 'CaptureInp.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

require_once(MDK_DIR."3GPSMDK.php");

/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 合計決済金額
 */
$amount = @$_POST["amount"];

if (isset ($_POST["reOauth"])) {
    $new_order_id = @$_POST["newOrderId"];
    $_POST["orderId"] = $new_order_id;
    $_POST["amount"] = $amount;
    include_once("AuthorizeExec.php");
    exit();
}

/**
 * 永久不滅ウォレット決済金額
 */
$wallet_amount = @$_POST["walletAmount"];

/**
 * カード決済金額
 */
$card_amount = @$_POST["cardAmount"];

/**
 * トークン
 */
$token = @$_POST["token"];

/**
 * カード取引ＩＤ
 */
$card_order_id = @$_POST["cardOrderId"];

/**
 * カード売上フラグ
 */
$with_capture = @$_POST["withCapture"];

/**
 * 必須パラメータ値チェック
 */
if (empty($order_id)) {
    $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($amount)) {
    $warning =  "<font color='#ff0000'><b>必須項目：合計決済金額が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($wallet_amount)) {
    $warning =  "<font color='#ff0000'><b>必須項目：永久不滅ウォレット決済金額が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($amount) === FALSE && is_numeric($amount) === FALSE) {
    $warning =  "<font color='#ff0000'><b>合計決済金額は数値で入力しなければなりません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($wallet_amount) === FALSE && is_numeric($wallet_amount) === FALSE) {
    $warning =  "<font color='#ff0000'><b>永久不滅ウォレット決済金額は数値で入力しなければなりません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($card_amount) === FALSE && is_numeric($card_amount) === FALSE) {
    $warning =  "<font color='#ff0000'><b>カード決済金額は数値で入力しなければなりません</b></font>";
    include_once(INPUT_PAGE);
    exit();
}


/**
 * 要求電文パラメータ値の指定
 */
$request_data = new SaisonCaptureRequestDto();
// オーダーIDの設定
$request_data->setOrderId($order_id);
// 合計決済金額の設定
$request_data->setAmount($amount);
// 永久不滅ウォレット決済金額の設定
$request_data->setWalletAmount($wallet_amount);
// カード決済金額の設定
$request_data->setCardAmount($card_amount);
// カード取引IDの設定
$request_data->setCardOrderId($card_order_id);
// カード売上フラグの設定
$request_data->setWithCapture($with_capture);
// 合計決済金額と永久不滅ウォレット決済金額が等しくない場合のみ、トークンを設定
if($amount != $wallet_amount) {
    // トークンの設定
    $request_data->setToken($token);
}

/**
 * 実施
 */
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

$processName     = htmlspecialchars("売上");
$_screen         = $_POST["_screen"];

$orderId         = htmlspecialchars($response_data->getOrderId());
$mStatus         = htmlspecialchars($response_data->getMstatus());
$vResultCode     = htmlspecialchars($response_data->getVResultCode());
$mErrMsg         = htmlspecialchars($response_data->getMerrMsg());

$cardOrderId     = htmlspecialchars($response_data->getCardOrderId());
$cardMStatus     = htmlspecialchars($response_data->getCardMstatus());
$cardVResultCode = htmlspecialchars($response_data->getCardVResultCode());
$cardMErrMsg     = htmlspecialchars($response_data->getCardMerrMsg());
$reqCardNumber   = htmlspecialchars($response_data->getReqCardNumber());
$resAuthCode     = htmlspecialchars($response_data->getResAuthCode());

include_once(RESULT_PAGE);
exit();
?>
