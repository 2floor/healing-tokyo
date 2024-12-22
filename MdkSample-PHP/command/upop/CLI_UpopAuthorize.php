<?php
/*
 * 銀聯ネット決済(UPOP) 決済要求サンプル
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

// ----------------------------
// テスト用リクエスト電文項目設定
// ----------------------------
 /**
  * 取引ID
  */
 $order_id = "dummy".time();

 /**
  * 金額
  */
 $amount = "10";

 /**
  * 売上フラグ
  * "true"： 与信・売上、"false"： 与信のみ
  */
 $with_capture = "true";

 /**
  * 決済結果戻り先URL
  */
 $term_url = "http://localhost/web/upop/AuthorizeResult";

 /**
  * 消費者IPアドレス
  */
 $customer_ip = "111.111.111.111";

// ----------------------------
// 要求電文パラメータ値の指定
// ----------------------------
 $request_data = new UpopAuthorizeRequestDto();
 $request_data->setOrderId($order_id);
 $request_data->setAmount($amount);
 $request_data->setWithCapture($with_capture);
 $request_data->setTermUrl($term_url);
 $request_data->setCustomerIp($customer_ip);

// ----------------------------
// 決済実行と結果表示
// ----------------------------
 // 実施
 $transaction = new TGMDK_Transaction();
 $response_data = $transaction->execute($request_data);

 // 結果コード取得
 $txn_status = $response_data->getMStatus();
 // 詳細コード取得
 $txn_result_code = $response_data->getVResultCode();
 // エラーメッセージ取得
 $error_message = $response_data->getMerrMsg();

 // 表示
 if (TXN_SUCCESS_CODE === $txn_status) {
   // 成功
   echo $txn_status."\n";
   echo "Transaction Successfully Complete\n";
   echo "[Result Code]: ".$txn_result_code."\n";
   echo "[Order ID]: ".$response_data->getOrderId()."\n";
   echo "[Entry Form]: ".$response_data->getEntryForm()."\n";

 } else if (TXN_PENDING_CODE === $txn_status) {
   //ペンディング
   echo $txn_status."\n";
   echo "Transaction Pending\n";
   echo "[Message]: ".$error_message."\n";
   echo "[Result Code]: ".$txn_result_code."\n";
   echo "[Order ID]: ".$response_data->getOrderId()."\n";
   echo "Check log file for more information\n";

 } else if (TXN_FAILURE_CODE === $txn_status) {
   // 失敗
   echo $txn_status."\n";
   echo "Transaction Failure\n";
   echo "[Message]: ".$error_message."\n";
   echo "[Result Code]: ".$txn_result_code."\n";
   echo "[Order ID]: ".$response_data->getOrderId()."\n";
   echo "Check log file for more information\n";
 }
?>
