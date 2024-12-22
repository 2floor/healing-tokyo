<?php
/*
 * 銀行振込決済 決済要求サンプル
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
  * 取引ID
  */
 $order_id = "dummy".time();

 /**
  * 支払金額
  */
 $amount = "10";

 /**
  * 口座振込人名
  */
 $entry_transfer_name = "テストタロウ";

 /**
  * 口座振込番号
  */
 $entry_transfer_number = "００００１";

 /**
  * 振込期限(YYYYMMDD)
  */
 $transfer_expired_date = "";

 /**
  * 口座管理方式
  * 実口座 : 0
  * バーチャル口座 : 1
  */
 $account_manage_type = "0";

 /**
  * 支店コード(口座管理方式がバーチャル口座のみ設定)
  */
 $branch_code = "";

 /**
  * 口座番号(口座管理方式がバーチャル口座のみ設定)
  */
 $account_number = "";

 /**
  * サービスオプションタイプ
  * りそな : resona
  */
 $service_option_type = "resona";

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new VirtualaccAuthorizeRequestDto();

 $request_data->setOrderId($order_id);
 $request_data->setAmount($amount);
 $request_data->setEntryTransferName($entry_transfer_name);
 $request_data->setEntryTransferNumber($entry_transfer_number);
 $request_data->setTransferExpiredDate($transfer_expired_date);
 $request_data->setAccountManageType($account_manage_type);
 $request_data->setBranchCode($branch_code);
 $request_data->setAccountNumber($account_number);
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
     echo "[Transfer Name]: ".$response_data->getTransferName()."\n";
     echo "[Bank Name]: ".$response_data->getBankName()."\n";
     echo "[Bank Code]: ".$response_data->getBankCode()."\n";
     echo "[Branch Name]: ".$response_data->getBranchName()."\n";
     echo "[Branch Code]: ".$response_data->getBranchCode()."\n";
     echo "[Account Type]: ".$response_data->getAccountType()."\n";
     echo "[Account Number]: ".$response_data->getAccountNumber()."\n";
     echo "[Account Name]: ".$response_data->getAccountName()."\n";
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
