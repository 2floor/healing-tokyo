<?php
/*
 * 電子マネー決済 再決済申込サンプル
 * Created on 2014/05/01
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
  * 決済方式
  *
  * nanaco決済 : tcc-redirect
  */
 $service_option_type = "tcc-redirect";

 /**
  * 取引ID
  * 申込実施時の対象取引IDを指定
  */
 $order_id = "dummy";

 /**
  * 復旧リダイレクションURL
  */
 $re_authorize_redirection_url = "http://127.0.0.1/web/em/Complete.php";

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new EmReAuthorizeRequestDto();
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);
 $request_data->setReAuthorizeRedirectionUrl($re_authorize_redirection_url);

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
   echo "[ReAuth Application URL]: ".$response_data->getReAuthAppUrl()."\n";

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
