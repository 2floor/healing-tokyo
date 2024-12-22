<?php
/*
 * 銀行振込決済 入金要求サンプル
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
  * 取引ID(申込請求時に利用したものを設定してください)
  */
 $order_id = "";

 /**
  * 支払金額
  */
 $amount = "";

 /**
  * 入金日の設定(YYYYMMDD)
  */
 $deposit_date = "";

 /**
  * 振込人名の設定
  */
 $transfer_name = "テストフリコミタロウ";

 /**
  * 消込フラグの設定
  * 消込しない : 0 or 未指定
  * 消込(強制) : 1
  * 消込(自動) : 2
  */
 $with_reconcile = "";

 /**
  * 登録方法の設定
  * 手動 : 0 or 未指定
  * 自動 : 1
  */
 $registration_method = "0";

 /**
  * サービスオプションタイプ
  * りそな : resona
  */
 $service_option_type = "resona";

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new VirtualaccDepositEntryRequestDto();

 $request_data->setOrderId($order_id);
 $request_data->setAmount($amount);
 $request_data->setDepositDate($deposit_date);
 $request_data->setTransferName($transfer_name);
 $request_data->setWithReconcile($with_reconcile);
 $request_data->setRegistrationMethod($registration_method);
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
     echo "[Deposit ID]: ".$response_data->getDepositId()."\n";
     echo "[Order Status]: ".$response_data->getOrderStatus()."\n";
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
