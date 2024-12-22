<?php
/*
 * MasterPass決済 申込要求サンプル
 * Created on 2015/03/11
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
  * 表示用商品説明1
  */
 $description1 = "sample商品";

 /**
  * 表示用商品数量1
  */
 $quantity1 = "1";

 /**
  * 表示用商品金額1
  */
 $value1 = "10";

 /**
  * 合計金額
  */
 $item_amount = "10";

 /**
  * 商品番号
  */
 $item_id = "123456";

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new MasterpassLoginRequestDto();

 $request_data->setOrderId($order_id);
 $request_data->setDescription1($description1);
 $request_data->setQuantity1($quantity1);
 $request_data->setValue1($value1);
 $request_data->setItemAmount($item_amount);
 $request_data->setItemId($item_id);

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
     echo "Check log file for more information\n";
 }
?>
