<?php
/*
 * クレジットカード決済 再与信要求サンプル
 * Created on 2010/02/16
 * 
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
 */
$order_id = "dummy".time();

/**
 * 元取引ID
 * 対象とする過去の取引IDを指定
 */
$original_order_id = "";

/**
 * 同時売上実施有無
 */
$is_with_capture = "true";

/**
 * 支払金額
 */
$payment_amount = "5";

/**
 * 支払オプション
 */
$jpo = "10";

/**
 * セキュリティコード
 */
$security_code = "1234";

/**
 * 要求電文パラメータ値の指定
 */
$request_data = new CardReAuthorizeRequestDto();

$request_data->setOrderId($order_id);
$request_data->setOriginalOrderId($original_order_id);
$request_data->setAmount($payment_amount);
$request_data->setWithCapture($is_with_capture);
$request_data->setJpo($jpo);
$request_data->setSecurityCode($security_code);

**
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
    echo "[Card Number]: ".$response_data->getReqCardNumber()."\n";
    echo "[Center Reference Number]: ".$response_data->getCenterReferenceNumber()."\n";
//ペンディング
} else if (TXN_PENDING_CODE === $txn_status) {
    echo $txn_status."\n";
    echo "Transaction Pending\n";
    echo "[Message]: ".$error_message."\n"; 
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Card Number]: ".$response_data->getReqCardNumber()."\n";
    echo "Check log file for more information\n";
// 失敗
} else if (TXN_FAILURE_CODE === $txn_status) {
    echo $txn_status."\n";
    echo "Transaction Failure\n";
    echo "[Message]: ".$error_message."\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Card Number]: ".$response_data->getReqCardNumber()."\n";
    echo "[Center Reference Number]: ".$response_data->getCenterReferenceNumber()."\n";
    echo "Check log file for more information\n";
}
?>
