<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '取引結果');

require_once(MDK_DIR."3GPSMDK.php");

// is dummy mode?
// is dummy mode?
$config = TGMDK_Config::getInstance();
$conf   = $config->getServiceParameters();
if (isset($conf)) {
    $dummyReq = $conf["DUMMY_REQUEST"];
}

// 取引ID
$order_id = @$_POST["orderId"];
// キャリア選択
$service_option_type = @$_POST["serviceOptionType"];
// 支払金額
$payment_amount = @$_POST["amount"];
// 端末種別
$terminal_kind = @$_POST["terminalKind"];
// 商品タイプ
$item_type = @$_POST["itemType"];
// 都度継続区分
$accounting_type = @$_POST["accountingType"];
// 初回課金年月日
$mpFirstDate = @$_POST["mpFirstDate"];
// 継続課金日
$mpDay = @$_POST["mpDay"];

// 決済完了時URL
$successUrl = @$_POST["successUrl"];
// 決済キャンセル時URL
$cancelUrl = @$_POST["cancelUrl"];
// 決済エラー時URL
$errorUrl = @$_POST["errorUrl"];
// pushURL
$pushUrl = @$_POST["pushUrl"];
// openID
$openId = @$_POST["openId"];

// 与信方法
$is_with_capture = @$_POST["withCapture"];
if($accounting_type==0){
  if ("1" == $is_with_capture) {
    $is_with_capture = TRUE_FLAG_CODE;
  } else {
    $is_with_capture = FALSE_FLAG_CODE;
  }
}

// 3Dセキュアは sb_ktai が対象外なので、設定しない
// 商品情報は入力フィールドを用意していません

// 商品番号
if(isset($_POST["itemId"]) && trim($_POST["itemId"])){
  $item_id = @$_POST["itemId"];
}

//サーバ内部指定
 if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
  //サーバ内部指定
 } else if (empty($service_option_type)) {
  $warning =  "<font color='#ff0000'><b>必須項目：キャリアが選択されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($payment_amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (isset($accounting_type)===false) {
  $warning =  "<font color='#ff0000'><b>必須項目：都度継続区分が選択されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }

// 要求電文パラメータ値の指定
$request_data = new CarrierAuthorizeRequestDto();

$request_data->setServiceOptionType($service_option_type);
$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
$request_data->setTerminalKind($terminal_kind);
$request_data->setAccountingType($accounting_type);
$request_data->setItemType($item_type);
if($accounting_type==0){
  $request_data->setWithCapture($is_with_capture);
} elseif($accounting_type==1){
  $request_data->setMpFirstDate($mpFirstDate);
  $request_data->setMpDay($mpDay);
}
$request_data->setSuccessUrl($successUrl);
$request_data->setCancelUrl($cancelUrl);
$request_data->setErrorUrl($errorUrl);
// set push url in only dummy mode.
if ($dummyReq === "1") {
  $request_data->setPushUrl($pushUrl);
}

if(isset($item_id)){
  $request_data->setItemId($item_id);
}

if($service_option_type === "docomo" || $service_option_type === "au"){
   $request_data->setOpenId($openId);
}
if($service_option_type === "s_bikkuri") {
    $sbUid = "dummyUID";
    $headers = getallheaders();
    while (list ($header, $value) = each ($headers)) {
        if ($header === "x-jphone-uid") {
            $sbUid = $value;
        }
    }
    $request_data->setSbUid($sbUid);
}

// 実施
 $transaction = new TGMDK_Transaction();
 $response_data = $transaction->execute($request_data);

 //予期しない例外
 if (!isset($response_data)) {
  $page_title = ERROR_PAGE_TITLE;
 //想定応答の取得
 } else {
  $page_title = NORMAL_PAGE_TITLE;

    /**
     * 取引ID取得
     */
    $result_order_id = $response_data->getOrderId();
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
     * redirect URL取得
     */
    $redirect_url = $response_data->getRedirectUrl();

  // ログ
  $test_log = "<!-- vResultCode=" . $txn_result_code . " -->";

  if (TXN_SUCCESS_CODE === $txn_status) {
      // 成功
      if (empty($redirect_url) === false) {
          header("Location: " . $response_data->getRedirectUrl(), true, 301);
          exit;
      } else {
          header("Content-type: text/html; charset=Shift-JIS");
          $response_html = mb_convert_encoding($response_data->getResponseContents(), "SJIS", "UTF-8");
          echo $response_html . $test_log;
          exit;
      }
  } else {
      // エラーページ表示
      $html = createErrorPage($response_data);
      print $html . $test_log;
      exit;
  }
 }


 function createErrorPage($response) {

 $html = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>エラーページ</title>
</head>
<body>
<img alt="Paymentロゴ" src="../../WEB-IMG/VeriTrans_Payment.png">
<br>
キャリア決済：取引結果<br>
<br/>
取引ID<br>
'.$response->getOrderId().'<br>
<br>
取引ステータス<br>
'.$response->getMStatus().'<br>
<br>
結果コード<br>
'.$response->getVResultCode().'<br>
<br>
結果メッセージ<br>
'.mb_convert_encoding($response->getMerrMsg(), "SJIS", "UTF-8").'<br>
<br>

<img alt="VeriTransロゴ" src="../../WEB-IMG/VeriTransLogo_WH.png"><br>
Copyright &copy; VeriTrans Inc. All rights reserved
</body></html>';

 return $html;
}
?>

