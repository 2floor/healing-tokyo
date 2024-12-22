<?php
/*
 * 銀聯ネット決済(UPOP) 取消要求サンプル
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

// ---------------------------------
// テスト用リクエスト電文項目設定
// ---------------------------------
 /**
  * 取引ID
  * 与信完了または売上完了状態の取引のIDを指定
  */
 $order_id = "";

// ---------------------------------
// 要求電文パラメータ値の指定
// ---------------------------------
 $request_data = new UpopCancelRequestDto();
 $request_data->setOrderId($order_id); 

// ---------------------------------
// 決済実行と結果表示
// ---------------------------------
 // 実施
 $transaction = new TGMDK_Transaction();
 $response_data = $transaction->execute($request_data);
 
 // 結果コード取得
 $txn_status = $response_data->getMStatus();
 // 詳細コード取得
 $txn_result_code = $response_data->getVResultCode();
 // エラーメッセージ取得
 $error_message = $response_data->getMerrMsg();
   
 // 表示
 if (TXN_SUCCESS_CODE === $txn_status) {
    // 成功
    echo $txn_status."\n";
    echo "Transaction Successfully Complete\n";
    echo "[Result Code]: ".$txn_result_code."\n";
    echo "[Order ID]: ".$response_data->getOrderId()."\n";
    echo "[Txn Datetime Jp]: ".$response_data->getTxnDatetimeJp()."\n";
    echo "[Txn Datetime Cn]: ".$response_data->getTxnDatetimeCn()."\n";
    echo "[Captured Amount]: ".$response_data->getCapturedAmount()."\n";
    echo "[Remaining Amount]: ".$response_data->getRemainingAmount()."\n";
    echo "[Settle Amount]: ".$response_data->getSettleAmount()."\n";
    echo "[Settle Date]: ".$response_data->getSettleDate()."\n";
    echo "[Settle Currency]: ".$response_data->getSettleCurrency()."\n";
    echo "[Settle Rate]: ".$response_data->getSettleRate()."\n";
    echo "[Upop Order Id]: ".$response_data->getUpopOrderId()."\n";

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
