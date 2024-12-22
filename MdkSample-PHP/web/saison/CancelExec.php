<?php
# Copyright(C) 2012 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// 永久不滅ポイント(永久不滅ウォレット)取消実行サンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('RESULT_PAGE', 'Result.php');
define('INPUT_PAGE', 'Cancel.php');

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
 * カード取消フラグ
 */
$card_cancel_flag = @$_POST["cardCancelFlag"];

/**
 * 必須パラメータ値チェック
 */
if (empty($order_id)) {
  $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit();
}

/**
 * 要求電文パラメータ値の指定
 */
$request_data = new SaisonCancelRequestDto();
// オーダーIDの設定
$request_data->setOrderId($order_id);
// カード取消フラグの設定
$request_data->setCardCancelFlag($card_cancel_flag);

/**
 * 実施
 */
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

$processName     = htmlspecialchars("取消");
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
