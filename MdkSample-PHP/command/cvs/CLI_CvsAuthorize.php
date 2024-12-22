<?php
/*
 * コンビニ決済申込要求サンプル
 * Created on 2010/02/17
 * Update History:
 *  2012/01/27: #23 not set mail address to DTO
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
/**
 * コンビニ区分定義
 */
define('SEVEN_ELEVEN_CODE', 'sej');
define('E_CONTEXT_CODE', 'econ');
define('WELL_NET_CODE', 'other');

require_once(MDK_DIR."3GPSMDK.php");

/**
 * コンビニエンスストアの分類を指定
 */
$service_option_type = SEVEN_ELEVEN_CODE;

/**
 * 取引ID
 */
 $order_id = "dummy".time();
 
 /**
  * 支払金額
  */
 $payment_amount = "5";
 
 /**
  * 氏名1(姓)
  */
 $last_name = "顧客姓";
 
 /**
  * 氏名2（名）
  */
 $first_name = "顧客名";
 
 /**
  * 電話番号
  * 注）ダミーリクエストフラグが1のとき使用可能な番号体系は制限されています
  * 電話番号の上２桁が次の場合、successを返します。
  * "09", "08", "07", "06", "05"
  * 上記以外の場合、failureを返します。
  *
  * 取消の場合、決済取消（ Other）：
  * 電話番号の上2桁が次の場合、successを返します。
  * "06", "05"
  * 上記以外の場合、failureを返します。
  */
  $tel_number = "05-1234-5678";
  
 /**
  * 支払期限
  */
  $payment_limit = date('Y/m/d', time()+3600*24*10);
  
 /**
  * 要求電文パラメータ値の指定
  */ 
 $request_data = new CvsAuthorizeRequestDto();
 
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);
 $request_data->setAmount($payment_amount);
 $request_data->setName1($last_name);
 $request_data->setName2($first_name);
 $request_data->setTelNo($tel_number);
 $request_data->setPayLimit($payment_limit);
 $request_data->setPaymentType("0");
 
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
 	echo "[Receipt Number]: ".$response_data->getReceiptNo()."\n";
 	echo "[Url]: ".$response_data->getHaraikomiUrl()."\n";
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
