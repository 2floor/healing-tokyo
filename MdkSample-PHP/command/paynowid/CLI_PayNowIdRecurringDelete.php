<?php
/*
 * PayNowId(継続課金削除)処理サンプル
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
 * グループID
 */
$group_id = "DEFAULT";

 /**
  * 課金終了日
  */
 $end_date = date(Ymd);

 /**
  * 課金自動終了フラグ
  */
 $final_charge = "0";

 
/**
 * 要求電文パラメータ値の指定
 */ 
$request_data = new RecurringDeleteRequestDto();
$request_data->setAccountId($account_id);
$request_data->setGroupId($group_id);
$request_data->setEndDate($end_date);
$request_data->setFinalCharge($final_charge);

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
// 成功
if (PAY_NOW_ID_SUCCESS_CODE === $pay_now_id_status) {
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
