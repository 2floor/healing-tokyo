<?php
/*
 * 銀行振込決済 入金取消要求サンプル
 * Created on 2015/12/21
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
define('TXN_SUCCESS_CODE', 'success');

require_once(MDK_DIR."3GPSMDK.php");

 /**
  * 取引ID(入金請求時に利用したものを設定してください)
  */
 $order_id = "";
 
 /**
  * 入金ID(入金請求時に受け取ったものを設定して下さい)
  */
 $deposit_id = "";

 /**
  * サービスオプションタイプ
  * りそな : resona
  */
 $service_option_type = "resona";

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new VirtualaccDepositReverseRequestDto();

 $request_data->setOrderId($order_id);
 $request_data->setDepositId($deposit_id);
 $request_data->setServiceOptionType($service_option_type);

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
     echo "[Status]: ".$txn_status."\n";
     echo "[Message]: ".$error_message."\n";
     echo "[Result Code]: ".$txn_result_code."\n";
     echo "[Order ID]: ".$response_data->getOrderId()."\n";
     echo "[Total Deposit Amount]: ".$response_data->getTotalDepositAmount()."\n";
 // 失敗
 } else if (TXN_FAILURE_CODE === $txn_status) {
     echo $txn_status."\n";
     echo "Transaction Failure\n";
     echo "[Message]: ".$error_message."\n";
     echo "[Result Code]: ".$txn_result_code."\n";
     echo "[Order ID]: ".$response_data->getOrderId()."\n";
     echo "Check log file for more information\n";
 }
?>
