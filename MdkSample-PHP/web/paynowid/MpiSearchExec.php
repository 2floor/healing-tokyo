<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード決済処理(3D認証付き)結果検索画面のサンプル
// 決済された情報を検索します。
// -------------------------------------------------------------------------

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

/**
 * 決済種別コード値（POSTされた値）
 */
define('NON_MODE_CODE', '1');
define('COMPLETE_MODE_CODE', '2');
define('COMPANY_MODE_CODE', '3');
define('MERCHANT_MODE_CODE', '4');

define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

require_once(MDK_DIR."3GPSMDK.php");


session_start();
// 再与信である事を示すフラグを取得
// 再与信の場合は"1"が入ってくる
// 画面の説明などの与信、再与信の文字列を切り替える
$AuthorizeTypeStr = "与信";
if ($_SESSION["reAuthorizeFlg"] == "1") {
    $AuthorizeTypeStr = "再与信";
}

// 決済種別
$payment_mode = $_SESSION["payment_mode"];

$_SESSION = array();
session_destroy();


/**
 * オプションタイプ
 * 1. MPIサービスのみ : mpi-none
 * 2. 完全認証 : mpi-complete
 * 3. 通常認証（カード会社リスク負担） ： mpi-company
 * 4. 通常認証（カード会社、加盟店リスク負担）: mpi-merchant
 */

/**
 * 取引ID
 * ブラウザにリダイレクトされたリクエストから取得
 */
$order_id = htmlspecialchars(@$_REQUEST["orderId"]);
if (isset($order_id) == false || empty($order_id)) {
    $order_id = "";
}

/**
 * リクエストID
 * ブラウザにリダイレクトされたリクエストから取得
 */
$request_id = htmlspecialchars(@$_REQUEST["RequestId"]);

$request_data = new SearchRequestDto();
$request_data->setRequestId($request_id);
$request_data->setNewerFlag("false");

/**
 * 検索トランザクションの実行
 */

$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

$txn_status = $response_data->getMStatus();

$message = "";

if (TXN_FAILURE_CODE == $txn_status
  || TXN_PENDING_CODE == $txn_status) {
    $html = createSystemErrorPage($order_id, $txn_status,
    $response_data->getVResultCode(), $message, $AuthorizeTypeStr);
    print $html;
    exit;
  }

/**
 * 取引情報の取得と確認
 */
$order_infos = $response_data->getOrderInfos();
$order_info_list = $order_infos->getOrderInfo();
$target_order_id = $order_info_list[0]->getOrderId();

$transaction_infos = $order_info_list[0]->getTransactionInfos();
$transaction_info_list = $transaction_infos->getTransactionInfo();

if (is_null($transaction_info_list)) {
    $html = createSystemErrorPage($target_order_id, $txn_status,
    $response_data->getVResultCode(), $message, $AuthorizeTypeStr);
    print $html;
    exit;
} else {
    $txn_id = 0;
    $mpi_txn_id = 0;
    $card_txn_id = 0;

    for($i = 0; $i < count($transaction_info_list); $i++) {
        $txn_id = $transaction_info_list[$i]->getTxnId();
        $m_status = $transaction_info_list[$i]->getMStatus();
        $v_result_code = $transaction_info_list[$i]->getVResultCode();

        $proper_transaction_info = $transaction_info_list[$i]->getProperTransactionInfo();
        // 取引種別の取得
        if (!is_null($proper_transaction_info)) {
            $txn_kind = $proper_transaction_info->getTxnKind();
        }

        // MPI～カード決済までが実行された場合
        // このタイミングでリクエストIDによる検索を実行すると
        // txnKindが"mpi"と"card"のレコードがそれぞれ１件取得できる

        $v_result_code_mpi = "";
        // MPI認証結果を取得(複数件の場合最新をチェックする)
        if (isset($txn_id) && "mpi" == $txn_kind) {
            if ($txn_id > $mpi_txn_id) {
                $m_status_mpi = $m_status;
                $v_result_code_mpi = $v_result_code;
                $mpi_txn_id = $txn_id;
            }
        }
        $v_result_code_card = "";
        // カード決済結果を取得（複数件の場合最新をチェックする）
        if (isset($txn_id) && "card" == $txn_kind) {
            if ($txn_id > $card_txn_id) {
                $m_status_card = $m_status;
                $v_result_code_card = $v_result_code;
                $card_txn_id = $txn_id;
            }
        }
    }// end of for loop

    // ログ
    $test_log = "<!-- PaymentMode[" . $payment_mode . "] : mStatusMPI=" . $m_status_mpi
            . ",vResultCodeMPI =" . $v_result_code_mpi . ", vResultCodeCard=" . $v_result_code_card
            . " -->";

    if (TXN_SUCCESS_CODE === $m_status_mpi) { // 成功
        if (NON_MODE_CODE == $payment_mode) {
            // 3D-Secure認証のみ(決済しない)
            $html = createResultPage($target_order_id, $m_status_mpi, $v_result_code_mpi, $message, $AuthorizeTypeStr);
        } else {
            // 3D-Secure認証のみ(決済しない)以外
            $html = createResultPage($target_order_id, $m_status_card, $v_result_code_card, $message, $AuthorizeTypeStr);
        }
        print $html . $test_log;
        exit;
    } else {
        // エラーページ表示
        $html = createErrorPage($target_order_id, $m_status_mpi, $v_result_code_mpi, $message, $AuthorizeTypeStr);
        print $html . $test_log;
        exit;
    }

}

function createResultPage($order_id, $mstatus, $result_code, $message, $AuthorizeTypeStr) {

 $html = '<html>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="Content-Language" content="ja" />
  <title>認証結果ページ</title>
 <link href="../css/style.css" rel="stylesheet" type="text/css">
 </head>
 <body><img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"><hr/>
 <div class="system-message">
 <font size="2">
 本画面はVeriTrans4G カード決済-3D認証有り(PayNowIDカード情報利用)サンプル画面です。<br/>
 お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
 </font>
 </div>
 <div class="lhtitle">カード決済-3D認証有り(PayNowIDカード情報利用)実行結果</div>
  <table border="0" cellpadding="0" cellspacing="0">' .
      '<tr><td class="rititletop">取引ID</td><td class="rivaluetop">' .
      ''.$order_id.'<br/></td></tr>'.'<tr><td class="rititle">取引ステータス</td><td class="rivalue">'
    .$mstatus.'<br/></td></tr><tr><td class="rititle">結果コード</td><td class="rivalue">'
    .$result_code.'<br/></td></tr><tr><td class="rititle">結果メッセージ</td><td class="rivalue">'
    .$message.'<br/></td></tr>
  </table>

<br>

<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

 </body>
 </html>';

 return $html;
}

function createErrorPage($order_id, $mstatus, $result_code, $message, $AuthorizeTypeStr) {

 $html = '<html>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="Content-Language" content="ja" />
  <title>認証エラーページ</title>
 </head>
 <link href="../css/style.css" rel="stylesheet" type="text/css">
 <body><img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"><hr/>
 <div class="system-message">
 <font size="2">
 本画面はVeriTrans4G カード決済-3D認証有り(PayNowIDカード情報利用)サンプル画面です。<br/>
 お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
 </font>
 </div>
 <div class="lhtitle">カード決済-3D認証有り(PayNowIDカード情報利用)：認証エラーページ</div>
  <table border="0" cellpadding="0" cellspacing="0">' .
      '<tr><td class="rititletop">取引ID</td><td class="rivaluetop">' .
      ''.$order_id.'<br/></td></tr>'.'<tr><td class="rititle">取引ステータス</td><td class="rivalue">'
    .$mstatus.'<br/></td></tr><tr><td class="rititle">結果コード</td><td class="rivalue">'
    .$result_code.'<br/></td></tr><tr><td class="rititle">結果メッセージ</td><td class="rivalue">'
    .$message.'<br/></td></tr>
  </table><br/>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


 </body>
 </html>';

 return $html;
}

function createSystemErrorPage($order_id, $mstatus, $result_code, $message, $AuthorizeTypeStr) {

 $html = '<html>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="Content-Language" content="ja" />
  <title>エラーページ</title>
 <link href="../css/style.css" rel="stylesheet" type="text/css">
 </head>
 <body><img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"><hr/>
 <div class="system-message">
 <font size="2">
 本画面はVeriTrans4G カード決済-3D認証有り(PayNowIDカード情報利用)サンプル画面です。<br/>
 お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
 </font>
 </div>
 <div class="lhtitle">カード決済-3D認証有り(PayNowIDカード情報利用)：システムエラーページ</div>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr><td class="rititletop">取引ID</td><td class="rivaluetop">'
    .$order_id.'<br/></td></tr><tr><td class="rititle">取引ステータス</td><td class="rivalue">'
    .$mstatus.'<br/></td></tr><tr><td class="rititle">結果コード</td><td class="rivalue">'
    .$result_code.'<br/></td></tr><tr><td class="rititle">結果メッセージ</td><td class="rivalue">'
    .$message.'<br/></td></tr></table><br/>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

  </body></html>';

 return $html;
}
?>
?>
