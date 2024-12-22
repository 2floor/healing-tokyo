<?php
/*
 * 銀行決済申込要求サンプル
 * Created on 2010/02/19
 *
 */
 
 /**
 * MDK配置ディレクトリ
 */
define('MDK_DIR', '../tgMdk/');
 
define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');

require_once(MDK_DIR."3GPSMDK.php");

/**
 * 決済方式
 * 
 * ATM決済 : atm
 * ネットバンク決済銀行リンク方式（PC） : netbank-pc
 * ネットバンク決済銀行リンク方式（docomo） : netbank-docomo
 * ネットバンク決済銀行リンク方式（SoftBank） : netbank-softbank
 * ネットバンク決済銀行リンク方式（au） : netbank-au
 * (※ご注意： ネットバンク決済の部分は、コマンドラインサンプルで
 *    画面のリンクはできないため、参考としてここに記述しております。)
 */
$service_option_type = "atm";

/**
 * 取引ID
 */
 $order_id = "dummy".time();
 
/**
 * 決済金額
 */
 $payment_amount = "10";
 
 /**
  * 顧客名1
  */
  $client_name1 = "顧客　氏名";
 
 /**
  * 顧客名カナ1
  */
  $client_kana1 = "コキャクシメイカナ";
  
 /**
  * 郵便番号1
  */
 $postal_code1 = "123";
   
 /**
  * 郵便番号2
  */
  $postal_code2 = "4567";
 
 /**
  * 住所
  */
  $address = "東京都港区１－６－１";
 /**
  * 電話番号
  */ 
  $telephone_number = "0123456789";
  
 /**
  * 支払期限
  */
  $payment_limit = date("Ymd", time()+3600*24*10);
  
 /**
  * 成約日
  */
 $agreement_date = date("Ymd");
  
 /**
  * 請求内容
  */
 $contents = "表示インフォメーション";
 
 /**
  * 請求内容カナ
  */
 $contentsKana = "ヒョウジインフォメーションカナ";
 
 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new BankAuthorizeRequestDto();
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);
 $request_data->setAmount($payment_amount);
 $request_data->setName1($client_name1);
 $request_data->setKana1($client_kana1);
 $request_data->setPost1($postal_code1);
 $request_data->setPost2($postal_code2);
 $request_data->setAddress1($address);
 $request_data->setTelNo($telephone_number);
 $request_data->setPayLimit($payment_limit);
 $request_data->setAgreementDate($agreement_date);
 $request_data->setContents($contents);
 $request_data->setContentsKana($contentsKana);

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

 //ペンディング
 } else if (TXN_PENDING_CODE === $txn_status) {
 	echo $txn_status."\n";
 	echo "Transaction Pending\n";
 	echo "[Message]: ".$error_message."\n";
 	echo "[Result Code]: ".$txn_result_code."\n";
 	echo "Check log file for more information\n";
 // 失敗
 } else if (TXN_FAILURE_CODE === $txn_status) {
 	echo $txn_status."\n";
 	echo "Transaction Failure\n";
 	echo "[Message]: ".$error_message."\n";
 	echo "[Result Code]: ".$txn_result_code."\n";
 	echo "Check log file for more information\n";
 }
?>
