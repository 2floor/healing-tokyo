<?php
/*
 * キャリア決済 売上要求サンプル
 * Created on 2013/06/21
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
 * 与信完了取引のIDを指定
 */
 $order_id = "dummy123456789";

 /**
  * サービスオプションタイプ
  *
  * au: auかんたん決済
  * docomo: ドコモケータイ払い
  * sb_ktai: ソフトバンクまとめて支払い（B）
  * s_bikkuri: S!まとめて支払い
  * flets: フレッツまとめて支払い
  */
 $service_option_type = "au";

 /**
  * 課金売上月
  *
  * 継続課金(docomo/flets)の場合、指定した年月の売り上げを行います
  * 形式は YYYYMM
  */
 $capture_month = "";

 /**
  * 要求電文パラメータ値の指定
  */ 
 $request_data = new CarrierCaptureRequestDto();

 $request_data->setOrderId($order_id); 
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setCaptureMonth($capture_month);

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
	echo "[Order ID]: ".$response_data->getOrderId()."\n";
 	echo "[Result Code]: ".$txn_result_code."\n";
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
