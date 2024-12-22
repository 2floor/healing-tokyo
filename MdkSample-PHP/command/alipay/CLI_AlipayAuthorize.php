<?php
/*
 * Alipay決済 決済要求サンプル
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
  * 金額
  *
  * 通貨がCNYの場合は、100以上の値の指定が必須
  */
 $amount = "10";

 /**
  * 通貨
  *
  * "JPY"：日本円、"CNY"：中国元
  */
 $currency = "JPY";

 /**
  * 決済種別
  *
  * "0"：オンライン決済、"1"：バーコード決済(店舗スキャン型)、"2"：バーコード決済(消費者スキャン型)
  */
 $pay_type = "0";

 /**
  * ユーザ識別コード
  *
  * 決済種別がバーコード決済(店舗スキャン型)の場合は指定必須
  * 決済種別がオンライン決済、バーコード決済(消費者スキャン型)の場合は指定不可
  */
 $identity_code = "1234567890";

 /**
  * 商品名
  */
 $commodity_name = "新製品";

 /**
  * 商品詳細
  *
  * 決済種別がオンライン決済、バーコード決済(消費者スキャン型)の場合は指定任意
  * 決済種別がバーコード決済(店舗スキャン型)の場合は指定不可
  */
 $commodity_description = "新製品詳細";

 /**
  * 商品ID
  *
  * 決済種別がバーコード決済(消費者スキャン型)、かつ、商品詳細を指定する場合は指定必須
  * 決済種別がオンライン決済、バーコード決済(店舗スキャン型)の場合は指定不可
  */
 $commodity_id = "newItemId";

 /**
  * 決済完了時URL
  *
  * 決済種別がオンライン決済の場合は指定必須
  * 決済種別がバーコード決済(店舗スキャン型)、バーコード決済(消費者スキャン型)の場合は指定不可
  */
 $success_url = "http://localhost/web/alipay/AuthorizeResult.php";

 /**
  * 決済エラー時URL
  *
  * 決済種別がオンライン決済の場合は指定必須
  * 決済種別がバーコード決済(店舗スキャン型)、バーコード決済(消費者スキャン型)の場合は指定不可
  */
 $error_url = "http://localhost/web/alipay/AuthorizeResult.php";

 /**
  * レスポンスタイプ
  * 決済種別がバーコード決済(店舗スキャン型)の場合は指定可能
  * 決済種別がオンライン決済、バーコード決済(消費者スキャン型)の場合は指定不可
  * "0" : 取引確定時にレスポンスを返却する。
  * "1" : 即時にレスポンスを返却する。
  */
 $response_type = "0";

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new AlipayAuthorizeRequestDto();
 $request_data->setOrderId($order_id);
 $request_data->setAmount($amount);
 $request_data->setCurrency($currency);
 $request_data->setPayType($pay_type);
 $request_data->setCommodityName($commodity_name);
 if ("0" === $request_data->getPayType()) {
   $request_data->setCommodityDescription($commodity_description);
   $request_data->setSuccessUrl($success_url);
   $request_data->setErrorUrl($error_url);
 } else if ("1" === $request_data->getPayType()) {
   $request_data->setIdentityCode($identity_code);
   $request_data->setResponseType($response_type);
 } else if ("2" === $request_data->getPayType()) {
   $request_data->setCommodityDescription($commodity_description);
   $request_data->setCommodityId($commodity_id);
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
   if ("1" === $request_data->getPayType() || "2" === $request_data->getPayType()) {
       echo "[Cust Txn]: ".$response_data->getCustTxn()."\n";
       echo "[Center Trade ID]: ".$response_data->getCenterTradeId()."\n";
   }
   if ("1" === $request_data->getPayType()) {
       echo "[Pay Time JP]: ".$response_data->getPayTimeJp()."\n";
       echo "[Pay Time CN]: ".$response_data->getPayTimeCn()."\n";
       echo "[Buyer Charged Amount Cny]: ".$response_data->getBuyerChargedAmountCny()."\n";
   } else if ("2" === $request_data->getPayType()) {
       echo "[QR Code]: ".$response_data->getQrCode()."\n";
       echo "[QR Code Img Url]: ".$response_data->getQrCodeImgUrl()."\n";
       echo "[QR Code Small Img Url]: ".$response_data->getQrCodeSmallImgUrl()."\n";
       echo "[QR Code Large Img Url]: ".$response_data->getQrCodeLargeImgUrl()."\n";
   }

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
