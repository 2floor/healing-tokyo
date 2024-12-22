<?php
/*
 * PayNowId(会員入会)処理サンプル
 * Created on 2014/01/20
 */

/**
 * MDK配置ディレクトリ
 */
define('MDK_DIR', '../tgMdk/');

/**
 * PayNowIDステータスコード
 */
define('PAY_NOW_ID_FAILURE_CODE', 'failure');
define('PAY_NOW_ID_PENDING_CODE', 'pending');
define('PAY_NOW_ID_SUCCESS_CODE', 'success');

require_once(MDK_DIR."3GPSMDK.php");

/**
 * 会員ID
 */
$account_id = "testAccount";

/**
 * 入会年月日
 */
$create_date = date('Ymd');

/**
 * 要求電文パラメータ値の指定
 */
$request_data = new AccountAddRequestDto();
$request_data->setAccountId($account_id);
$request_data->setCreateDate($create_date);

/**
 * 実施
 */
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

/**
 * PayNowIDレスポンス取得
 */
$pay_now_id_res = $response_data->getPayNowIdResponse();

if (isset($pay_now_id_res)) {
    /**
     * PayNowID処理番号取得
     */
    $process_id = $pay_now_id_res->getProcessId();
    /**
     * PayNowIDステータス取得
     */
    $pay_now_id_status = $pay_now_id_res->getStatus();
}

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
// $pay_now_id_status が 存在しない
if (!isset($pay_now_id_status)) {
    echo "I do not know the status because of PayNowIdResponse is null.\n";
    echo "[Message]: ".$error_message."\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "Check log file for more information\n";
// 成功
} else if (PAY_NOW_ID_SUCCESS_CODE === $pay_now_id_status) {
    echo $pay_now_id_status."\n";
    echo "Transaction Successfully Complete\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Process ID]: ".$process_id."\n";
//ペンディング
} else if (PAY_NOW_ID_PENDING_CODE === $pay_now_id_status) {
    echo $pay_now_id_status."\n";
    echo "Transaction Pending\n";
    echo "[Message]: ".$error_message."\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Process ID]: ".$process_id."\n";
    echo "Check log file for more information\n";
// 失敗
} else if (PAY_NOW_ID_FAILURE_CODE === $pay_now_id_status) {
    echo $pay_now_id_status."\n";
    echo "Transaction Failure\n";
    echo "[Message]: ".$error_message."\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Process ID]: ".$process_id."\n";
    echo "Check log file for more information\n";
}
?>
