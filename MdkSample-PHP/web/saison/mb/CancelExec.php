<?php
# Copyright(C) 2012 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// 永久不滅ポイント(永久不滅ウォレット)取消実行サンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../../tgMdk/');

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
  $warning = mb_convert_encoding($warning, "SJIS", "UTF-8");
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

$processName     = htmlspecialchars(mb_convert_encoding("取消", "SJIS", "UTF-8"), ENT_COMPAT | 'ENT_HTML401', "Shift_JIS");
$_screen         = $_POST["_screen"];

$orderId         = htmlspecialchars($response_data->getOrderId());
$mStatus         = htmlspecialchars($response_data->getMstatus());
$vResultCode     = htmlspecialchars($response_data->getVResultCode());
$mErrMsg         = htmlspecialchars(mb_convert_encoding($response_data->getMerrMsg(), "SJIS", "UTF-8"), ENT_COMPAT | 'ENT_HTML401', "Shift_JIS");

$cardOrderId     = htmlspecialchars($response_data->getCardOrderId());
$cardMStatus     = htmlspecialchars($response_data->getCardMstatus());
$cardVResultCode = htmlspecialchars($response_data->getCardVResultCode());
$cardMErrMsg     = htmlspecialchars(mb_convert_encoding($response_data->getCardMerrMsg(), "SJIS", "UTF-8"), ENT_COMPAT | 'ENT_HTML401', "Shift_JIS");
$reqCardNumber   = htmlspecialchars($response_data->getReqCardNumber());
$resAuthCode     = htmlspecialchars($response_data->getResAuthCode());

include_once(RESULT_PAGE);
exit();
?>
