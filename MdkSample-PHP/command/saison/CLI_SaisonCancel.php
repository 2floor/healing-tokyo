<?php
/*
 * 永久不滅ポイント(永久不滅ウォレット) 取消要求サンプル
 * Created on 2012/06/12
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
 * ※キャンセルしたい取引IDを指定する
 */
$order_id = "";

/**
 * カード取消フラグ
 * ※1（永久不滅とカード決済の両方キャンセル） or 0（永久不滅のみキャンセル）
 */
$card_cancel_flag = "1";



/**
 * 要求電文パラメータ値の指定
 */
$request_data = new SaisonCancelRequestDto();

$request_data->setOrderId($order_id);
$request_data->setCardCancelFlag($card_cancel_flag);

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
  echo "[OrderId]        : ".$response_data->getOrderId()."\n";
  echo "[MerrMsg]        : ".$response_data->getMerrMsg()."\n";
  echo "[VResultCode]    : ".$response_data->getVResultCode()."\n";
  echo "[CardOrderId]    : ".$response_data->getCardOrderId()."\n";
  echo "[CardMstatus]    : ".$response_data->getCardMstatus()."\n";
  echo "[CardMerrMsg]    : ".$response_data->getCardMerrMsg()."\n";
  echo "[CardVResultCode]: ".$response_data->getCardVResultCode()."\n";
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
  echo "[Center Reference Number]: ".$response_data->getCenterReferenceNumber()."\n";
  echo "Check log file for more information\n";
}
?>
