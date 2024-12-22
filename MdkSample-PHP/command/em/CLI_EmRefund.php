<?php
/*
 * 電子マネー決済 返金要求サンプル
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
  * サイバーEdy : edy-pc
  * モバイルEdy : edy-mobile
  * モバイルEdyダイレクト : edy-direct
  * モバイルSuicaメール決済 : suica-mobile-mail
  * モバイルSuicaアプリ決済 : suica-mobile-app
  * Suicaインターネット決済メール連携 : suica-pc-mail
  * Suicaインターネット決済アプリ連携 : suica-pc-app
  * WAON モバイルアプリ決済 : waon-mobile
  * WAON PaSoRi決済 : waon-pc
  */
 $service_option_type = "suica-mobile-app";

 /**
  * 取引ID
  */
 $order_id = "dummy".time();

 /**
  * 返金依頼金額
  */
 $request_amount = "100";

 /**
  * オーダー種別
  * 返金：refund
  * 新規返金: refund_new
  */
 $order_kind = "refund";

 /**
  * 返金対象取引ID
  */
 $refund_order_id = "dummy_target_id";

 /**
  * 消費者メールアドレス
  */
 $requester_mail_address = "sample.dummy@vt-mdk.co.jp";

 /**
  * 決済期限
  */
 $settlement_limit = date('YmdHis', time()+ 36000);

 /**
  * 画面タイトル
  */
 $screen_title = "For Suica";

 /**
  * 成功時戻りURL
  */
 $success_url = "http://127.0.0.1/web/PaymentMethodSelect.php?status=success";

 /**
  * 失敗時戻りURL
  */
 $failure_url = "http://127.0.0.1/web/PaymentMethodSelect.php?status=failure";

 /**
  * キャンセル時戻りURL
  */
 $cancel_url = "http://127.0.0.1/web/PaymentMethodSelect.php?status=cancel";

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new EmRefundRequestDto();
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);
 $request_data->setRefundOrderId($refund_order_id);
 $request_data->setOrderKind($order_kind);
 $request_data->setAmount($request_amount);

 if ("suica-mobile-mail" === $service_option_type
  || "suica-mobile-app" === $service_option_type
  || "suica-pc-mail" === $service_option_type
  || "suica-pc-app" === $service_option_type) {
   $request_data->setSettlementLimit($settlement_limit);
   $request_data->setScreenTitle($screen_title);
 }
 if ("waon-pc" === $service_option_type) {
   $request_data->setSuccessUrl($success_url);
   $request_data->setFailureUrl($failure_url);
   $request_data->setCancelUrl($cancel_url);
 }

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
