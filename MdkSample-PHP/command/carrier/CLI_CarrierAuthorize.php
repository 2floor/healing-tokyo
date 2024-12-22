<?php
/*
 * キャリア決済 与信要求サンプル
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
  */
 $order_id = "dummy".time();

 /**
  * サービスオプションタイプ
  *
  * au: auかんたん決済
  * docomo: ドコモケータイ払い
  * sb_ktai: ソフトバンクまとめて支払い（B）
  * sb_matomete: ソフトバンクまとめて支払い（A）
  * s_bikkuri: S!まとめて支払い
  * flets: フレッツまとめて支払い
  */
 $service_option_type = "au";
 
 /**
  * 支払金額
  */
 $payment_amount = "10";

 /**
  * 端末種別
  *
  * 0: PC
  * 1: スマートフォン
  * 2: フィーチャーフォン
  */
 $terminal_kind = "0";

 /**
  * 商品タイプ
  *
  * 0: デジタルコンテンツ
  * 1: 物販
  * 2: 役務
  */
 $item_type = "0";

 /**
  * 都度/継続区分
  * 
  * 0: 都度
  * 1: 継続
  */
 $accounting_type = "0";

 /**
  * 同時売上実施有無
  *
  * ソフトバンクまとめて支払い（A）は与信同時売上のみのため "true" を
  * 指定する必要があります
  */
 $is_with_capture = "false";

 /**
  * 本人認証(3Dセキュア)
  *
  * ソフトバンクまとめて支払い（B）のみの指定項目となります
  * 0: 無し
  * 1: バイパス
  * 2: 有り
  */
 $d3_flag = "";

 /**
  * 初回課金年月日
  *
  * 継続課金(au/docomo)のときのみ指定可能
  * YYYYMMDD形式
  */
 $mp_first_date = "";

 /**
  * 継続課金日
  *
  * 継続課金(au/docomo)のときのみ指定可能
  *
  * 01～28または99(月末)
  */
 $mp_day = "";

 /**
  * 商品番号
  */
 $item_id = "123456";

 /**
  * 商品情報
  */
 $item_info = "";

 /**
  * 決済完了時URL
  */
 $success_url = "";

 /**
  * 決済キャンセル時URL
  */
 $cancel_url = "";

 /**
  * 決済エラー時URL
  */
 $error_url = "";

 /**
  * プッシュURL(ダミー取引のときのみ)
  */
 $push_url = "";

 /**
  * OpenID
  */
 $open_id = "";
  
 /**
  * フレッツエリア
  *
  * フレッツまとめて支払いのみの指定項目となります
  * 0: 東日本
  * 1: 西日本
  */
 $flets_area = "";
  
 /**
  * 要求電文パラメータ値の指定
  */ 
 $request_data = new CarrierAuthorizeRequestDto();
 
 $request_data->setOrderId($order_id);
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setAmount($payment_amount);
 $request_data->setTerminalKind($terminal_kind);
 $request_data->setItemType($item_type);
 $request_data->setAccountingType($accounting_type);
 $request_data->setWithCapture($is_with_capture);
// $request_data->setD3Flag($d3_flag);
// $request_data->setMpFirstDate($mp_first_date);
// $request_data->setMpDay($mp_day);
// $request_data->setItemId($item_id);
// $request_data->setItemInfo($item_info);
// $request_data->setSuccessUrl($success_url);
// $request_data->setCancelUrl($cancel_url);
// $request_data->setErrorUrl($error_url);
// $request_data->setPushUrl($push_url);
// $request_data->setOpenId($open_id);
// $request_data->setFletsArea($flets_area);

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
