<?php
/*
 * Alipay決済 返金要求サンプル
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
  * 対象の取引IDを指定します
  */
 $order_id = "change_order_here";

 /**
  * 支払金額
  */
 $request_amount = "5";

 /**
  * 返金理由
  */
 $request_reason = "返金理由";

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new AlipayRefundRequestDto();
 $request_data->setOrderId($order_id);
 $request_data->setAmount($request_amount);
 $request_data->setReason($request_reason);

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
 if (TXN_SUCCESS_CODE === $txn_status) {
   // 成功
   echo $txn_status."\n";
   echo "Transaction Successfully Complete\n";
   echo "[Result Code]: ".$txn_result_code."\n";
   echo "[Order ID]: ".$response_data->getOrderId()."\n";
   echo "[Balance]: ".$response_data->getBalance()."\n";

 } else if (TXN_PENDING_CODE === $txn_status) {
   // ペンディング
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
