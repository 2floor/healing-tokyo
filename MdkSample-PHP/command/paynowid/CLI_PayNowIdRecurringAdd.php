<?php
/*
 * PayNowId(継続課金登録)処理サンプル
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

// /**
// * カード番号
// */
// $card_number = "4111-1111-1111-1111";

// /**
// * カード有効期限 MM/YY
// */
// $card_expire = "12/13";

/**
 * トークン
 */
$token = "0a812412-682c-4dad-8a5d-720caf23bca0";

/**
 * グループID
 */
$group_id = "DEFAULT";

/**
 * 課金開始日
 */
$start_date = date(Ymd);

/**
 * 課金終了日
 */
$end_date = date(Ymd, strtotime("1 day"));

/**
 * 都度／初回課金金額
 */
$one_time_amount = "10";

/**
 * 継続課金金額
 */
$recarring_amount = "20";

/**
 * 要求電文パラメータ値の指定
 */ 
$request_data = new RecurringAddRequestDto();
$request_data->setAccountId($account_id);
// $request_data->setCardNumber($card_number);
// $request_data->setCardExpire($card_expire);
$request_data->setToken($token);
$request_data->setGroupId($group_id);
$request_data->setStartDate($start_date);
$request_data->setEndDate($end_date);
$request_data->setOneTimeAmount($one_time_amount);
$request_data->setAmount($recarring_amount);

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
