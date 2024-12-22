<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 銀行決済の実行および結果画面のサンプル
// -------------------------------------------------------------------------

/**
 * MDK配置ディレクトリ
 */
define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');
/**
 * 結果ステータスコード
 */
define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '取引結果');

require_once(MDK_DIR."3GPSMDK.php");

// 変数の初期化
$orderId = "";
$txn_status = "";
$txn_result_code = "";
$error_message = "";
$org_number = "";
$customer_number = "";
$confirm_number = "";
$url = "";
$org_number = "";
$billPattern = "";
$bill = "";

/**
 * 決済方式
 *
 * ATM決済 : atm
 * ネットバンク決済銀行リンク方式（PC） : netbank-pc
 * ネットバンク決済銀行リンク方式（docomo） : netbank-docomo
 * ネットバンク決済銀行リンク方式（SoftBank） : netbank-softbank
 * ネットバンク決済銀行リンク方式（au） : netbank-au
 */
$service_option_type = @$_POST["serviceOptionType"];

/**
 * 取引ID
 */
 $order_id = @$_POST["orderId"];

/**
 * 決済金額
 */
 $payment_amount = @$_POST["amount"];

 /**
  * 顧客名1
  */
 $name1 = @$_POST["name1"];

 /**
  * 顧客名2
  */
 $name2 = @$_POST["name2"];

 /**
  * 顧客名カナ1
  */
 $kana1 = @$_POST["kana1"];

 /**
  * 顧客名カナ2
  */
 $kana2 = @$_POST["kana2"];

 /**
  * 支払期限
  */
 $payment_limit = @$_POST["payLimit"];

 /**
  * プッシュURL
  */
 $push_url = @$_POST["pushUrl"];

 /**
  * 請求内容
  */
 $contents = @$_POST["contents"];

 /**
  * 請求内容カナ
  */
 $contents_kana = @$_POST["contentsKana"];

 /**
  * 決済機関
  */
 $pay_csv = @$_POST["payCsv"];

  /**
  * 必須パラメータチェック
  */
 if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($payment_amount)) {
  $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($name1)) {
  $warning = "<font color='#ff0000'><b>必須項目：顧客名1が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($kana1)) {
  $warning = "<font color='#ff0000'><b>必須項目：カナ1が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($payment_limit)) {
  $warning = "<font color='#ff0000'><b>必須項目：支払期限が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($contents)) {
  $warning = "<font color='#ff0000'><b>必須項目：請求内容（漢字）が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($contents_kana)) {
  $warning = "<font color='#ff0000'><b>必須項目：請求内容（カナ）が指定されていません</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }

 /**
  * 設定ファイルから設定値を読み取り
  */
 $config_file = "../env4sample.ini";
 if (is_readable($config_file)) {
  $env_info = @parse_ini_file($config_file, true);
  $termUrl = $env_info["BANK"]["term.url"];
 }

 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new BankAuthorizeRequestDto();
 $request_data->setServiceOptionType($service_option_type);
 $request_data->setOrderId($order_id);
 $request_data->setAmount($payment_amount);
 $request_data->setName1($name1);
 if (isset($name2)) {
  $request_data->setName2($name2);
 }
 $request_data->setKana1($kana1);
 if (isset($kana2)) {
  $request_data->setKana2($kana2);
 }
 $request_data->setPayLimit($payment_limit);
 $request_data->setPushUrl($push_url);
 $request_data->setContents($contents);
 $request_data->setContentsKana($contents_kana);
 $request_data->setPayCsv($pay_csv);
 if ("netbank-pc" === $service_option_type) {
  // ネットバンク決済(PC)の場合にのみ"決済結果戻り先URL"を設定可能
  $request_data->setTermUrl($termUrl);
 }

 /**
  * 実施
  */
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
 $orderId = $response_data->getOrderId();
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

// 成功
  if (TXN_SUCCESS_CODE === $txn_status) {

    if ("atm" == $service_option_type) {
      /**
       * 収納機関番号
       */
      $org_number = $response_data->getShunoKikanNo();
      /**
       * お客様番号
       */
      $customer_number = $response_data->getCustomerNo();
      /**
       * 確認番号
       */
      $confirm_number = $response_data->getConfirmNo();
    } else {
      /**
       * 収納機関番号
       */
      $org_number = $response_data->getShunoKikanNo();
      /**
       * アクセスURL
       */
      $url = $response_data->getUrl();
      /**
       * 画面情報
       */
      $view = $response_data->getView();
      /**
       * 支払パターン
       */
      $billPattern = $response_data->getBillPattern();
      /**
       * 支払暗号文字列
       */
      $bill = $response_data->getBill();

      //ブラウザへのアクション
      if (!empty($view)) {
//        print $view;
//        exit;
      }
    }
  } else {
    $page_title = ERROR_PAGE_TITLE;
  }
 }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title><?php echo $page_title ?></title>
<script language="javascript" type="text/javascript">
<!--
function jumpToBankSelect() {
  if (document.getElementById("login_url") == null) {return;}
  var f = document.pec;
  f.action = document.getElementById("login_url").value;
  f.submit();
}
// -->
</script>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body onload="jumpToBankSelect()">
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 銀行決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">銀行決済：取引結果</div>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
  <td class="rititletop">取引ID</td>
  <td class="rivaluetop"><?php echo $orderId ?><br/></td>
</tr>
<tr>
  <td class="rititle">取引ステータス</td>
  <td class="rivalue"><?php echo $txn_status ?><br/></td>
</tr>
<tr>
  <td class="rititle">結果コード</td>
  <td class="rivalue"><?php echo $txn_result_code ?><br/></td>
</tr>
<tr>
  <td class="rititle">結果メッセージ</td>
  <td class="rivalue"><?php echo $error_message ?><br/></td>
</tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
  <td class="rititletop" nowrap>収納機関番号</td>
  <td class="rivaluetop"><?php echo $org_number ?><br/></td>
</tr>
<tr>
  <td class="rititle" nowrap>お客様番号</td>
  <td class="rivalue"><?php echo $customer_number ?><br/></td>
</tr>
<tr>
  <td class="rititle" nowrap>確認番号</td>
  <td class="rivalue"><?php echo $confirm_number ?><br/></td>
</tr>
<tr>
  <td class="rititle" nowrap>URL</td>
  <td class="rivalue"><?php echo $url ?><br/></td>
</tr>
</table>
<?php
  if (TXN_SUCCESS_CODE == $txn_status && "atm" != $service_option_type) {
?>
  <form name="pec" method="post" action="<?php echo $url ?>">
    <input type="hidden" name="skno" value="<?php echo $org_number ?>">
    <input type="hidden" name="bptn" value="<?php echo $billPattern ?>">
    <input type="hidden" name="bill" value="<?php echo $bill ?>">
  </form>

  <form method="post">
    <input type="hidden" name="login_url" id="login_url" value="<?php echo $url ?>">
  </form>

<?php
  }
?>
<br/>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;
<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>
