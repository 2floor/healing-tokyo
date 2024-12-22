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
    $target_orderId       = $target->getOrderId();       // オーダーID
    $target_serviceTypeCd = $target->getServiceTypeCd(); // 決済サービスタイプ
    $target_orderStatus   = $target->getOrderStatus();   // オーダー決済状態
    $target_lastSuccessTxnType   = $target->getLastSuccessTxnType();   // オーダー決済状態
    $target_successDetailTxnType   = $target->getSuccessDetailTxnType();   // オーダー決済状態

    $properOrderInfo = $target->getProperOrderInfo();
    if (isset($properOrderInfo) && 0 < count($properOrderInfo)) {
      $target_crServiceType       = $properOrderInfo->getCrServiceType();       // キャリアサービスタイプ
      $target_withCapture         = $properOrderInfo->getWithCapture();         // 与信同時売上フラグ
      $target_accountingType      = $properOrderInfo->getAccountingType();      // 課金タイプ
      $target_itemInfo            = $properOrderInfo->getItemInfo();            // 商品情報
      $target_itemId              = $properOrderInfo->getItemId();              // 商品ID
      $target_itemType            = $properOrderInfo->getItemType();            // 商品タイプ
      $target_terminalKind        = $properOrderInfo->getTerminalKind();        // 端末種別
      $target_authorizeDatetime   = $properOrderInfo->getAuthorizeDatetime();   // 決済申込日時
      $target_captureDatetime     = $properOrderInfo->getCaptureDatetime();     // 売上日時
      $target_cancelDatetime      = $properOrderInfo->getCancelDatetime();      // 取消日時
      $target_mpFirstDate         = $properOrderInfo->getMpFirstDate();         // 初回課金日付
      $target_mpDay               = $properOrderInfo->getMpDay();               // 継続課金日
      $target_mpStatus            = $properOrderInfo->getMpStatus();            // 継続状態フラグ (月額課金状態フラグ)
      $target_mpOrderId           = $properOrderInfo->getMpOrderId();           // 継続課金オーダーID
      $target_mpTxnStatusType     = $properOrderInfo->getMpTxnStatusType();     // 継続課金状態タイプ
      $target_mpCaptureDatetime   = $properOrderInfo->getMpCaptureDatetime();   // 継続売上日時
      $target_mpCancelDatetime    = $properOrderInfo->getMpCancelDatetime();    // 継続取消日時
      $target_mpTerminateDatetime = $properOrderInfo->getMpTerminateDatetime(); // 継続終了日時
      $target_crOrderId           = $properOrderInfo->getCrOrderId();           // キャリアオーダーID
      $target_d3Flag              = $properOrderInfo->getD3Flag();              // 本人認証(３Ｄセキュア)
      $target_fletsArea           = $properOrderInfo->getFletsArea();           // フレッツエリア
    }
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
      if (isset($properOrderInfo) && $properTransactionInfo instanceof ProperTransactionInfo) {
        $carrier_crResultCode[$i]       = $properTransactionInfo->getCrResultCode();        // キャリア結果コード
        $carrier_detailCommandType[$i]  = $properTransactionInfo->getDetailCommandType();   // 詳細コマンドタイプ
        $carrier_crRequestDatetime[$i]  = $properTransactionInfo->getCrRequestDatetime();   // キャリアへの要求日時
        $carrier_crResponseDatetime[$i] = $properTransactionInfo->getCrResponseDatetime();  // キャリアからの返戻日時
      }
    }
  }

}
?>


<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="Content-Language" content="ja" />
    <title>取引検索結果(キャリア)</title>
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

  <div class="lhtitle">検索結果（キャリア）</div>
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
  <table border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#ffeebb">
      <th class="rititle2" nowrap colspan="10">固有オーダー情報</th>
    </tr>

    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>キャリアサービスタイプ</td>
      <td class="rivalue2" nowrap width="170"><?php echo $target_crServiceType; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>商品タイプ</td>
      <td class="rivalue2" nowrap width="170"><?php echo $target_itemType; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>初回課金日付</td>
      <td class="rivalue2" nowrap width="170"><?php echo $target_mpFirstDate; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>継続売上日時</td>
      <td class="rivalue2" nowrap width="170"><?php echo $target_mpCaptureDatetime; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>フレッツエリア</td>
      <td class="rivalue2" nowrap width="170"><?php echo $target_fletsArea; ?><br/></td>
    </tr>
    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>与信同時売上フラグ</td>
      <td class="rivalue2" nowrap><?php echo $target_withCapture; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>端末種別</td>
      <td class="rivalue2" nowrap><?php echo $target_terminalKind; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>継続課金日</td>
      <td class="rivalue2" nowrap><?php echo $target_mpDay; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>継続取消日時</td>
      <td class="rivalue2" nowrap><?php echo $target_mpCancelDatetime; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap></td>
      <td class="rivalue2" nowrap><br/></td>
    </tr>
    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>課金タイプ</td>
      <td class="rivalue2" nowrap><?php echo $target_accountingType; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>決済申込日時</td>
      <td class="rivalue2" nowrap><?php echo $target_authorizeDatetime; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>継続状態フラグ</td>
      <td class="rivalue2" nowrap><?php echo $target_mpStatus; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>継続終了日時</td>
      <td class="rivalue2" nowrap><?php echo $target_mpTerminateDatetime; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap></td>
      <td class="rivalue2" nowrap><br/></td>
    </tr>
    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>商品情報</td>
      <td class="rivalue2" nowrap><?php echo $target_itemInfo; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>売上日時</td>
      <td class="rivalue2" nowrap><?php echo $target_captureDatetime; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>継続課金オーダーID</td>
      <td class="rivalue2" nowrap><?php echo $target_mpOrderId; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>キャリアオーダーID</td>
      <td class="rivalue2" nowrap><?php echo $target_crOrderId; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap></td>
      <td class="rivalue2" nowrap><br/></td>
    </tr>
    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>商品ID</td>
      <td class="rivalue2" nowrap><?php echo $target_itemId; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>取消日時</td>
      <td class="rivalue2" nowrap><?php echo $target_cancelDatetime; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>継続課金状態タイプ</td>
      <td class="rivalue2" nowrap><?php echo $target_mpTxnStatusType; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>本人認証(３Ｄセキュア)</td>
      <td class="rivalue2" nowrap><?php echo $target_d3Flag; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap></td>
      <td class="rivalue2" nowrap><br/></td>
    </tr>

  </table>
<br/>
  <h2>トランザクション情報</h2>
  <table border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#ffeebb">
      <th class="rititle2" nowrap colspan="6">決済トランザクション情報</th>
      <th class="rititle2" nowrap colspan="4">固有トランザクション情報</th>
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
      <th class="rititle2" nowrap width="145">キャリア結果コード</th>
      <th class="rititle2" nowrap width="145">詳細コマンドタイプ</th>
      <th class="rititle2" nowrap width="170">キャリアへの要求日時</th>
      <th class="rititle2" nowrap width="185">キャリアからの返戻日時</th>
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
      <td class="rivalue2" nowrap><?php if (isset($carrier_crResultCode[$i])) { echo $carrier_crResultCode[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($carrier_detailCommandType[$i])) { echo $carrier_detailCommandType[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($carrier_crRequestDatetime[$i])) { echo $carrier_crRequestDatetime[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($carrier_crResponseDatetime[$i])) { echo $carrier_crResponseDatetime[$i]; } ?><br/></td>
    </tr>
<?php } ?>

  </table>

  <br/>
  <a href="../Search.php">検索条件へ戻る</a>&nbsp;&nbsp;

  <hr>
  <img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>
