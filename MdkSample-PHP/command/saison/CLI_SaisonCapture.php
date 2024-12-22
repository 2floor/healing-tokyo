<?php
/*
 * 永久不滅ポイント(永久不滅ウォレット) 売上要求サンプル
 * Created on 2017/02/17
 *
 */

/**
 * MDK配置ディレクトリ
 */
define('MDK_DIR', '../tgMdk/');

/**
 * ステータスコード
 */
define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');

require_once(MDK_DIR."3GPSMDK.php");

/**
 * 取引ID
 * 認可完了取引のIDを指定
 */
$order_id = "change_order_id";

/**
 * 決済金額
 */
$amount = "100";

/**
 * 永久不滅ウォレット決済金額
 */
$wallet_amount = "70";

/**
 * カード決済金額
 */
$card_amount = "30";

/**
 * トークン
 */
$token = "0a812412-682c-4dad-8a5d-720caf23bca0";

/**
 * カード取引ID
 */
$card_order_id = "";

/**
 * カード売上フラグ
 * "true"： 与信・売上、"false"： 与信のみ
 */
$with_capture = "true";



/**
 * 要求電文パラメータ値の指定
 */
$request_data = new SaisonCaptureRequestDto();

$request_data->setOrderId($order_id);
$request_data->setAmount($amount);
$request_data->setWalletAmount($wallet_amount);
$request_data->setCardAmount($card_amount);
$request_data->setToken($token);
$request_data->setCardOrderId($card_order_id);
$request_data->setWithCapture($with_capture);

/**
 * 実施
 */
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

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
 * 結果表示
 */
// 成功
if (TXN_SUCCESS_CODE === $txn_status) {
    echo $txn_status."\n";
    echo "Transaction Successfully Complete\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Order ID]: ".$response_data->getOrderId()."\n";
    echo "[Res Auth Code]: ".$response_data->getResAuthCode()."\n";
//ペンディング
} else if (TXN_PENDING_CODE === $txn_status) {
    echo $txn_status."\n";
    echo "Transaction Pending\n";
    echo "[Message]: ".$error_message."\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Order ID]: ".$response_data->getOrderId()."\n";
    echo "Check log file for more information\n";
// 失敗
} else if (TXN_FAILURE_CODE === $txn_status) {
    echo $txn_status."\n";
    echo "Transaction Failure\n";
    echo "[Message]: ".$error_message."\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Order ID]: ".$response_data->getOrderId()."\n";
    echo "[Res Auth Code]: ".$response_data->getResAuthCode()."\n";
    echo "Check log file for more information\n";
}
?>
