<?php
/*
 * PayNowId(カード決済 + 会員入会)処理サンプル
 * Created on 2014/01/20
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
* 同時売上実施有無
*/
$is_with_capture = "false";

/**
* 支払金額
*/
$payment_amount = "30";

// /**
// * カード番号
// */
// $card_number = "4111-1111-1111-1111";

// /**
// * カード有効期限 MM/YY
// */
// $card_expire = "12/13";

/**
* 支払オプション
*/
$jpo = "10";

// /**
// * セキュリティコード
// */
// $security_code = "1234";

/**
 * トークン
 */
$token = "0a812412-682c-4dad-8a5d-720caf23bca0";

/**
 * 会員ID
 */
$account_id = "account".time();

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
$end_date = date(Ymd);

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
$request_data = new CardAuthorizeRequestDto();
$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
// $request_data->setCardNumber($card_number);
// $request_data->setCardExpire($card_expire);
$request_data->setWithCapture($is_with_capture);
$request_data->setJpo($jpo);
// $request_data->setSecurityCode($security_code);
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
* 結果コード取得
*/
$txn_status = $response_data->getMStatus();
/**
* 取引ID取得
*/
$result_order_id = $response_data->getOrderId();

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
} else if (TXN_SUCCESS_CODE === $txn_status) {
    echo $txn_status."\n";
    echo "Transaction Successfully Complete\n";
    echo "[Order ID]: ".$response_data->getOrderId()."\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Process ID]: ".$process_id."\n";
    echo "[PayNowID STATUS]: ".$pay_now_id_status."\n";
//ペンディング
} else if (TXN_PENDING_CODE === $txn_status) {
    echo $txn_status."\n";
    echo "Transaction Pending\n";
    echo "[Order ID]: ".$response_data->getOrderId()."\n";
    echo "[Message]: ".$error_message."\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Process ID]: ".$process_id."\n";
    echo "[PayNowID STATUS]: ".$pay_now_id_status."\n";
    echo "Check log file for more information\n";
// 失敗
} else if (TXN_FAILURE_CODE === $txn_status) {
    echo $txn_status."\n";
    echo "Transaction Failure\n";
    echo "[Order ID]: ".$response_data->getOrderId()."\n";
    echo "[Message]: ".$error_message."\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Process ID]: ".$process_id."\n";
    echo "[PayNowID STATUS]: ".$pay_now_id_status."\n";
    echo "Check log file for more information\n";
}
?>
