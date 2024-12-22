<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード決済(3D認証付き)の実行および結果画面のサンプル
// -------------------------------------------------------------------------

/**
 * MDK配置ディレクトリ
 */
define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');

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

require_once(MDK_DIR . "3GPSMDK.php");

/**
 * サンプルでは"env4sample.ini"ファイルから認証利用方式とリダイレクトされるURLを
 * 取得（サンプル使用の場合は設定ファイルを変更のこと）
 */
$config_file = "../env4sample.ini";

$payment_mode = null;
$redirection_url = null;
if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    /**
     * オプションタイプ
     * 1. MPIサービスのみ : mpi-none
     * 2. 完全認証 : mpi-complete
     * 3. 通常認証（カード会社リスク負担） ： mpi-company
     * 4. 通常認証（カード会社、加盟店リスク負担）: mpi-merchant
     */
    $payment_mode = @$_POST["paymentMode"];
    $redirection_url = $env_info["MPI"]["redirection.url"];
}

/**
 * 実使用コードに変換
 */
switch ($payment_mode) {
    case NON_MODE_CODE:
        $service_option_type = "mpi-none";
        break;
    case COMPLETE_MODE_CODE:
        $service_option_type = "mpi-complete";
        break;
    case COMPANY_MODE_CODE:
        $service_option_type = "mpi-company";
        break;
        case MERCHANT_MODE_CODE:
        $service_option_type = "mpi-merchant";
        break;
    default:
        break;
}

/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 決済金額
 */
$payment_amount = @$_POST["amount"];

/**
 * トークン
 */
$token = @$_POST["token"];

/**
 * 与信同時売上有無
 * false： 与信のみ
 * true: 同時売上
 */
if ("0" == @$_POST["withCapture"]) {
    $is_with_capture = FALSE_FLAG_CODE;
} else if ("1" == @$_POST["withCapture"]) {
    $is_with_capture = TRUE_FLAG_CODE;
} else {
    $is_with_capture = FALSE_FLAG_CODE;
}

/**
 * 支払オプション
 */
$jpo1 = @$_POST["jpo1"];
$jpo2 = @$_POST["jpo2"];

if ((!empty($jpo1)) && (("10" == $jpo1) || ("80" == $jpo1))) {
    $jpo = $jpo1;
} else if ((!empty($jpo1) && ("61" == $jpo1)) && (!empty($jpo2))) {
    $jpo = $jpo1 . "C" . $jpo2;
}

/**
 * プッシュ通知先URL
 */
$push_url = @$_POST["pushUrl"];

/**
 * HTTP Header
 */
$http_user_agent = $_SERVER["HTTP_USER_AGENT"];
$http_accept = $_SERVER["HTTP_ACCEPT"];

/**
 * 必須パラメータ値チェック（サイトのデータ形式にあわせてバリデートして下さい）
 */
if (empty($order_id)) {
    $warning = "<span style='color:red;'><b>必須項目：取引IDが指定されていません</b></span>";
    include_once(INPUT_PAGE);
    exit;
} else if (empty($payment_amount)) {
    $warning = "<span style='color:red;'><b>必須項目：金額が指定されていません</b></span>";
    include_once(INPUT_PAGE);
    exit;
}

session_start();
// 決済種別
$_SESSION["payment_mode"] = $payment_mode;
// 与信である事を示すフラグをセッションに格納
$_SESSION["reAuthorizeFlg"] = "2";

/**
 * 要求電文パラメータ値の設定
 */
$request_data = new MpiAuthorizeRequestDto();

$request_data->setServiceOptionType($service_option_type);
$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
$request_data->setToken($token);
$request_data->setWithCapture($is_with_capture);
if (isset($jpo)) {
    $request_data->setJpo($jpo);
}
if (isset($push_url)) {
    $request_data->setPushUrl($push_url);
}
if (isset($http_user_agent)) {
    $request_data->setHttpUserAgent($http_user_agent);
}
if (isset($http_accept)) {
    $request_data->setHttpAccept($http_accept);
}
if (isset($redirection_url)) {
    $request_data->setRedirectionUri($redirection_url);
}

/**
 * 実施
 */
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

//予期しない例外
if (!isset($response_data)) {
    $main_message = "<span style='font-size: small;'><b>応答が取得できませんでした。</b></span>";
//想定応答の取得
} else {

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
     * ログ
     */
    $test_log = "<!-- PaymentMode[" . $payment_mode . "] : vResultCode=" . $txn_result_code . " -->";

    if (TXN_SUCCESS_CODE === $txn_status) {
        // 成功
        $response_html = $response_data->getResResponseContents();
        echo $response_html . $test_log;
        exit;
    } else {
        // エラーページ表示
        $html = createErrorPage($response_data);
        print $html . $test_log;
        exit;
    }
}
?>

<?php
function createErrorPage($response) {
$html = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="ja" />
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <title>エラーページ</title>
    </head>
    <body>
    <img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png">
    <hr/>
    <div class="system-message">
        <span style="font-size: small;">
            本画面はVeriTrans4G カード決済与信(3D認証付き)の取引サンプル画面です。<br/>
            お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
        </span>
    </div>
    <div class="lhtitle">カード決済与信(3D認証付き)：取引結果</div>
    <table style="border-width: 0; padding: 0; border-collapse: collapse">
        <tr>
            <td class="rititlecommon">取引ID</td>
            <td class="rivaluecommon">'.$response->getOrderId().'<br/></td>
        </tr>
        <tr>
            <td class="rititlecommon">取引ステータス</td>
            <td class="rivaluecommon">'.$response->getMStatus().'</td>
        </tr>
        <tr>
            <td class="rititlecommon">結果コード</td>
            <td class="rivaluecommon">'.$response->getVResultCode().'</td>
        </tr>
        <tr>
            <td class="rititlecommon">結果メッセージ</td>
            <td class="rivaluecommon">'.$response->getMerrMsg().'</td>
        </tr>
    </table>

    <br/>

    <a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>

    <hr/>
    <img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


    </body>
    </html>
    ';

return $html;
}

function createSystemErrorPage($response) {
$html = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="ja" />
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <title>エラーページ</title>
    </head>
    <body>
    <img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png">
    <hr/>
    <div class="system-message">
        <span style="font-size: small;">
            本画面はVeriTrans4G カード決済与信(3D認証付き)の取引サンプル画面です。<br/>
            お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
        </span>
    </div>

    <div class="lhtitle">カード決済与信(3D認証付き)：取引結果</div>
    <table style="border-width: 0; padding: 0; border-collapse: collapse">
        <tr>
            <td class="rititlecommon">取引ID</td>
            <td class="rivaluecommon">'.$response->getOrderId().'<br/></td>
        </tr>
        <tr>
            <td class="rititlecommon">取引ステータス</td>
            <td class="rivaluecommon">'.$response->getMStatus().'</td>
        </tr>
        <tr>
            <td class="rititlecommon">結果コード</td>
            <td class="rivaluecommon">'.$response->getVResultCode().'</td>
        </tr>
        <tr>
            <td class="rititlecommon">結果メッセージ</td>
            <td class="rivaluecommon">'.$response->getMerrMsg().'</td>
        </tr>
    </table>

    <br/>

    <a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>

    <hr/>
    <img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


    </body>
    </html>
    ';

return $html;
}
?>
