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
      $target_withCapture         = $properOrderInfo->getWithCapture();         // 与信同時売上フラグ
      $target_itemName            = $properOrderInfo->getItemName();            // 商品名
      $target_itemId              = $properOrderInfo->getItemId();              // 商品ID
      $target_authorizeAmount     = $properOrderInfo->getAuthorizeAmount();     // 商品タイプ
      $target_balance            = $properOrderInfo->getBalance();             // 残高
      $target_usedPoint           = $properOrderInfo->getUsedPoint();           // 利用ポイント
      $target_authorizeDatetime   = $properOrderInfo->getAuthorizeDatetime();   // 決済申込日時
      $target_rakutenOrderId      = $properOrderInfo->getRakutenOrderId();      // 楽天オーダーID
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
      if (isset($properTransactionInfo) && $properTransactionInfo instanceof ProperTransactionInfo) {
        $rakuten_rakutenApiErrorCode[$i]     = $properTransactionInfo->getRakutenApiErrorCode();     // 楽天APIエラーコード
        $rakuten_rakutenOrderErrorCode[$i]   = $properTransactionInfo->getRakutenOrderErrorCode();   // 楽天取引エラーコード
        $rakuten_detailCommandType[$i]       = $properTransactionInfo->getDetailCommandType();       // 詳細コマンドタイプ
        $rakuten_rakutenRequestDatetime[$i]  = $properTransactionInfo->getRakutenRequestDatetime();  // 楽天への要求日時
        $rakuten_rakutenResponseDatetime[$i] = $properTransactionInfo->getRakutenResponseDatetime(); // 楽天からの返戻日時
      }
    }
  }

}
?>


<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="Content-Language" content="ja" />
    <title>取引検索結果(楽天)</title>
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

  <div class="lhtitle">検索結果（楽天）</div>
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
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>与信同時売上フラグ</td>
      <td class="rivalue2" nowrap><?php echo $target_withCapture; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>商品名</td>
      <td class="rivalue2" nowrap><?php echo $target_itemName; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>商品ID</td>
      <td class="rivalue2" nowrap><?php echo $target_itemId; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>楽天オーダーID</td>
      <td class="rivalue2" nowrap><?php echo $target_rakutenOrderId; ?><br/></td>
    </tr>
    <tr>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>申込金額</td>
      <td class="rivalue2" nowrap><?php echo $target_authorizeAmount; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>残高</td>
      <td class="rivalue2" nowrap><?php echo $target_balance; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>利用ポイント</td>
      <td class="rivalue2" nowrap><?php echo $target_usedPoint; ?><br/></td>
      <td class="rivalue2" bgcolor="#ffeebb" nowrap>決済申込確定日時</td>
      <td class="rivalue2" nowrap><?php echo $target_authorizeDatetime; ?><br/></td>
    </tr>

  </table>
<br/>
  <h2>トランザクション情報</h2>
  <table border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#ffeebb">
      <th class="rititle2" nowrap colspan="6">決済トランザクション情報</th>
      <th class="rititle2" nowrap colspan="5">固有トランザクション情報</th>
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
      <th class="rititle2" nowrap width="200">楽天APIエラーコード</th>
      <th class="rititle2" nowrap width="200">楽天注文エラーコード</th>
      <th class="rititle2" nowrap width="145">詳細コマンドタイプ</th>
      <th class="rititle2" nowrap width="170">楽天への要求日時</th>
      <th class="rititle2" nowrap width="185">楽天からの返戻日時</th>
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
      <td class="rivalue2" nowrap><?php if (isset($rakuten_rakutenApiErrorCode[$i])) { echo $rakuten_rakutenApiErrorCode[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($rakuten_rakutenOrderErrorCode[$i])) { echo $rakuten_rakutenOrderErrorCode[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($rakuten_detailCommandType[$i])) { echo $rakuten_detailCommandType[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($rakuten_rakutenRequestDatetime[$i])) { echo $rakuten_rakutenRequestDatetime[$i]; } ?><br/></td>
      <td class="rivalue2" nowrap><?php if (isset($rakuten_rakutenResponseDatetime[$i])) { echo $rakuten_rakutenResponseDatetime[$i]; } ?><br/></td>
    </tr>
<?php } ?>

  </table>

  <br/>
  <a href="../Search.php">検索条件へ戻る</a>&nbsp;&nbsp;

  <hr>
  <img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>
