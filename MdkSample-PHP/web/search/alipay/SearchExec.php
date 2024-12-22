<?php

define('MDK_DIR'   , '../../tgMdk/');
require_once(MDK_DIR."3GPSMDK.php");

$order_info_obj = new OrderInfo();
$orderId           = htmlspecialchars(@$_GET["orderId"]);         // 取引ID

// --------------------------------------------------------------
// 要求DTOを生成し、値を設定します。
// --------------------------------------------------------------
// Commonパラメータクラスへのセット
$common_param = new CommonSearchParameter();
$common_param->setOrderId($orderId);
// Searchパラメータクラスへのセット
$serach_param = new SearchParameters();
$serach_param->setCommon($common_param);

// 検索DTOへパラメータクラスをセット
$request_data = new SearchRequestDto();
$request_data->setContainDummyFlag("1");             // 検索対象にダミー決済のレコードを含めるかを示す
$request_data->setSearchParameters($serach_param);   // 各機能の固有条件

// --------------------------------------------------------------
// コマンドを実行し、応答DTOを取得します。
// --------------------------------------------------------------
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

// --------------------------------------------------------------
// 結果画面に表示します。
// --------------------------------------------------------------
// 処理結果メッセージを設定
$warning = $response_data->getMerrMsg();

// 配列データを設定
$order_infos = $response_data->getOrderInfos();
if (isset($order_infos) && $order_infos != null) {
  $order_info = $order_infos->getOrderInfo();
}

if (isset($order_info) && 0 < count($order_info)) {
  foreach ($order_info as $target) {
    $target_orderId       = $target->getOrderId();                        // オーダーID
    $target_serviceTypeCd = $target->getServiceTypeCd();                  // 決済サービスタイプ
    $target_orderStatus   = $target->getOrderStatus();                    // オーダー決済状態
    $target_lastSuccessTxnType   = $target->getLastSuccessTxnType();      // 最終成功トランザクションタイプ
    $target_successDetailTxnType   = $target->getSuccessDetailTxnType();  // 詳細トランザクションタイプ
  }

  $transactionInfos = $target->getTransactionInfos();
  $transactionInfo = $transactionInfos->getTransactionInfo();

  if (isset($transactionInfo) && 0 < count($transactionInfo)) {
    for ($i = 0; $i < count($transactionInfo); $i++) {
      $transaction_txnId[$i]       = $transactionInfo[$i]->getTxnId();       // トランザクション管理ID
      $transaction_command[$i]     = $transactionInfo[$i]->getCommand();     // コマンド
      $transaction_mstatus[$i]     = $transactionInfo[$i]->getMstatus();     // ステータスコード
      $transaction_vResultCode[$i] = $transactionInfo[$i]->getVResultCode(); // 結果コード
      $transaction_txnDatetime[$i] = $transactionInfo[$i]->getTxnDatetime(); // 取引日時
      $transaction_amount[$i]      = $transactionInfo[$i]->getAmount();      // 金額

      $properTransactionInfo = $transactionInfo[$i]->getProperTransactionInfo();
      if (isset($properTransactionInfo) && $properTransactionInfo instanceof ProperTransactionInfo) {
        $alipay_center_trade_id[$i] = $properTransactionInfo->getCenterTradeId();  // 決済センターとの取引ID
        $alipay_txn_type[$i]        = $properTransactionInfo->getAlipayTxnType();  // 詳細コマンドタイプ
        $alipay_settle_amount[$i]   = $properTransactionInfo->getSettleAmount();   // 清算金額
        $alipay_settle_currency[$i] = $properTransactionInfo->getSettleCurrency(); // 清算通貨
        $alipay_payment_time[$i]    = $properTransactionInfo->getPaymentTime();    // 支払い日付
        $alipay_settlement_time[$i] = $properTransactionInfo->getSettlementTime(); // 清算日付
        $alipay_pay_type[$i]        = $properTransactionInfo->getPayType();        // 決済種別
      }
    }
  }

}
?>


<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="Content-Language" content="ja" />
    <title>取引検索結果(Alipay)</title>
  <link href="../../css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
  <img alt="Paymentロゴ" src="../../WEB-IMG/VeriTrans_Payment.png"/><hr/>
  <div class="system-message">
    <font size="2">
    本画面はVeriTrans4G 取引検索のサンプル画面です。<br/>
    お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
    </font>
  </div>


<?php
  if (!empty($warning)) {
    echo "<font color='#ff0000' size='2'><b>$warning</b></font><br/><br/>";
  }
?>

  <div class="lhtitle">検索結果（Alipay）</div>
  <h2>オーダー情報</h2>
  <table border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#ffeebb">
      <th class="rititle2" nowrap colspan="2">オーダー情報</th>
    </tr>

    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>取引ID</td>
      <td class="rivalue2" nowrap><?php echo $target_orderId; ?><br/></td>
    </tr>
    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>決済サービスタイプ</td>
      <td class="rivalue2" nowrap><?php echo $target_serviceTypeCd; ?><br/></td>
    </tr>
    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>オーダー決済状態</td>
      <td class="rivalue2" nowrap><?php echo $target_orderStatus; ?><br/></td>
    </tr>
    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>最終成功トランザクションタイプ</td>
      <td class="rivalue2" nowrap><?php echo $target_lastSuccessTxnType; ?><br/></td>
    </tr>
    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>詳細トランザクションタイプ</td>
      <td class="rivalue2" nowrap><?php echo $target_successDetailTxnType; ?><br/></td>
    </tr>

  </table>
<br/>
  <h2>トランザクション情報</h2>
  <table border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#ffeebb">
      <th class="rititle2" nowrap colspan="6">決済トランザクション情報</th>
      <th class="rititle2" nowrap colspan="7">固有トランザクション情報</th>
    </tr>
    <tr bgcolor="#ffeebb">
      <!-- 決済トランザクション情報 -->
      <th class="rititle2" nowrap width="65">管理ID</th>
      <th class="rititle2" nowrap width="120">コマンド</th>
      <th class="rititle2" nowrap width="130">ステータスコード</th>
      <th class="rititle2" nowrap width="145">結果コード</th>
      <th class="rititle2" nowrap width="180">取引日時</th>
      <th class="rititle2" nowrap width="100">金額</th>

      <!-- 固有トランザクション情報 -->
      <th class="rititle2" nowrap width="210">決済センターとの取引ID</th>
      <th class="rititle2" nowrap width="210">詳細トランザクションタイプ</th>
      <th class="rititle2" nowrap width="120">清算金額</th>
      <th class="rititle2" nowrap width="120">清算通貨</th>
      <th class="rititle2" nowrap width="120">支払い日付</th>
      <th class="rititle2" nowrap width="120">清算日付</th>
      <th class="rititle2" nowrap width="120">決済種別</th>
    </tr>

<?php for($i=0; $i<count($transactionInfo); $i++) { ?>
    <tr>
      <!-- 決済トランザクション情報 -->
      <td class="rivalue2" nowrap><?php echo $transaction_txnId[$i]; ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $transaction_command[$i]; ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $transaction_mstatus[$i]; ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $transaction_vResultCode[$i]; ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $transaction_txnDatetime[$i]; ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $transaction_amount[$i]; ?><br/></td>
      <!-- 固有トランザクション情報 -->
      <td class="rivalue2" nowrap><?php if (isset($alipay_center_trade_id[$i])) { echo $alipay_center_trade_id[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($alipay_txn_type[$i])) { echo $alipay_txn_type[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($alipay_settle_amount[$i])) { echo $alipay_settle_amount[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($alipay_settle_currency[$i])) { echo $alipay_settle_currency[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($alipay_payment_time[$i])) { echo $alipay_payment_time[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($alipay_settlement_time[$i])) { echo $alipay_settlement_time[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($alipay_pay_type[$i])) { echo $alipay_pay_type[$i]; } ?><br/></td>
    </tr>
<?php } ?>

  </table>

  <br/>
  <a href="../Search.php">検索条件へ戻る</a>&nbsp;&nbsp;

  <hr>
  <img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>
