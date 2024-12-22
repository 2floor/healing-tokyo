<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// メインメニュー画面のサンプル
// -------------------------------------------------------------------------

define('CARD_CODE', 'card');
define('E_MONEY_CODE', 'em');
define('CONVINIENCE_CODE', 'cvs');
define('BANK_CODE', 'bank');
define('PAYPAL_CODE', 'paypal');
define('MPI_CODE', 'mpi');
define('SAISON_CODE', 'saison');
define('UPOP_CODE', 'upop');
define('ALIPAY_CODE', 'alipay');
define('CARRIER_CODE', 'carrier');
define('ORICOSC_CODE', 'oricosc');
define('RAKUTEN_CODE', 'rakuten');
define('RECRUIT_CODE', 'recruit');
define('LINEPAY_CODE', 'linepay');
define('MASTERPASS_CODE', 'masterpass');
define('VIRTUALACC_CODE', 'virtualacc');

define('CARD_INVOICE', 'card/Authorize.php');
define('EM_INVOICE', 'em/Menu.php');
define('CVS_INVOICE', 'cvs/Authorize.php');
define('BANK_INVOICE', 'bank/Authorize.php');
define('PAYPAL_INVOICE', 'paypal/Authorize.php');
define('MPI_INVOICE', 'mpi/Authorize.php');
define('SAISON_INVOICE', 'saison/Authorize.php');
define('UPOP_INVOICE', 'upop/Authorize.php');
define('ALIPAY_INVOICE', 'alipay/Authorize.php');
define('CARRIER_INVOICE', 'carrier/Menu.php');
define('ORICOSC_INVOICE', 'oricosc/Authorize.php');
define('RAKUTEN_INVOICE', 'rakuten/Authorize.php');
define('RECRUIT_INVOICE', 'recruit/Authorize.php');
define('LINEPAY_INVOICE', 'linepay/Authorize.php');
define('MASTERPASS_INVOICE', 'masterpass/Login.php');
define('VIRTUALACC_INVOICE', 'virtualacc/Authorize.php');

$base_url = "";
$connect_system = "";
$connect_type = "";

$config_file = "./env4sample.ini";

if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $base_url = $env_info["Common"]["base.url"];

    $prop = @parse_ini_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . "tgMdk" . DIRECTORY_SEPARATOR . "3GPSMDK.properties", true);
    $connect_server_url = $prop["Connection"]["HOST_URL"];
    $connect_server_parts = parse_url( $connect_server_url );
    $connect_system = $connect_server_parts["host"] . "／" . gethostbyname($connect_server_parts["host"]);
    if ($prop["Service"]["DUMMY_REQUEST"] == "1") {
      $connect_type = "ダミーリクエスト";
    } else {
      $connect_type = "本番リクエスト";
    }
}

$item = "サンプル商品";

/**
 * 金額を支払い前に取得
 */
$price = "10";

if (isset($_POST["method"])) {
    $payment_method = htmlspecialchars(@$_POST["method"]);
    switch ($payment_method) {
    case CARD_CODE:
        $forward = CARD_INVOICE;
        break;
    case E_MONEY_CODE:
        $forward = EM_INVOICE;
        break;
    case CONVINIENCE_CODE:
        $forward = CVS_INVOICE;
        break;
    case BANK_CODE:
        $forward = BANK_INVOICE;
        break;
    case PAYPAL_CODE:
        $forward = PAYPAL_INVOICE;
        break;
    case MPI_CODE:
        $forward = MPI_INVOICE;
        break;
    case SAISON_CODE:
        $forward = SAISON_INVOICE;
        break;
    case UPOP_CODE:
        $forward = UPOP_INVOICE;
        break;
    case ALIPAY_CODE:
        $forward = ALIPAY_INVOICE;
         break;
    case CARRIER_CODE:
        $forward = CARRIER_INVOICE;
         break;
    case RAKUTEN_CODE:
        $forward = RAKUTEN_INVOICE;
        $item_name = "テスト商品";
        $price = "100";
        header('Location: ' . $base_url . $forward . "?price=" . $price . "&item_name=" . $item_name);
        exit;
    case RECRUIT_CODE:
        $forward = RECRUIT_INVOICE;
        $item_name = "テスト商品";
        header('Location: ' . $base_url . $forward . "?price=" . $price . "&item_name=" . $item_name);
        exit;
    case LINEPAY_CODE:
        $forward = LINEPAY_INVOICE;
        $item_name = "テスト商品";
        header('Location: ' . $base_url . $forward . "?price=" . $price . "&item_name=" . $item_name);
        exit;
    case ORICOSC_CODE:
        $forward = ORICOSC_INVOICE;
        $item1_quantity = "1";
        $item1_name = "テスト商品１";
        $price = "500";
        header('Location: ' . $base_url . $forward . "?price=" . $price . "&item1_quantity=" . $item1_quantity . "&item1_name=" . $item1_name);
        exit;
    case MASTERPASS_CODE:
        $forward = MASTERPASS_INVOICE;
        $quantity1 = "1";
        $item_name = "テスト商品";
        header('Location: ' . $base_url . $forward . "?quantity1=" . $quantity1 . "&value1=" . $price . "&description1=" . $item_name);
        exit;
     case VIRTUALACC_CODE:
        $forward = VIRTUALACC_INVOICE;
        $account_manage_type = "0";
        $entry_transfer_name = "テストタロウ";
        $entry_transfer_number = "００００１";
        header('Location: ' . $base_url . $forward . "?price=" . $price . "&account_manage_type=" . $account_manage_type . "&entry_transfer_name=" . $entry_transfer_name . "&entry_transfer_number=" . $entry_transfer_number);
        exit;
    default:
        break;
    }
}

if (isset($forward)) {
    header('Location: ' . $base_url . $forward . "?price=" . $price);
    exit;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>決済方法選択</title>
<link href="./css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='./WEB-IMG/VeriTrans_Payment.png'><hr/>
<table border="0">
  <tr>
    <td>接続先</td>
    <td>：</td>
    <td><?php echo $connect_system ?></td>
  </tr>
  <tr>
    <td>接続モード</td>
    <td>：</td>
    <td><?php echo $connect_type ?></td>
  </tr>
</table><hr/>
<div class="system-message">
<font size="2">
本プログラムはVeriTrans4Gをご利用して頂くためのサンプルプログラムです。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
尚、本サンプルプログラムはVeriTrans4Gと連動させるための基本的な処理手順を示したものになりますので、<br/>
導入の際においては開発ガイドも合わせてご参照して頂いたうえ、お客様ECサイトに適した形式にカスタマイズしてください。<br/>
</font>
</div>

<div class="lhtitle">購入商品</div>
<table>
<tr>
<td width="150" valign="top" class="imgItemFrm"><img src="./WEB-IMG/VeriTrans_TestProduct.png" width="150" height="150"/></td>
<td valign="top">
<table class="MsoTableMediumShading1Accent5" border="1" cellspacing="0" cellpadding="0" style="margin-left:20pt;">
  <tr>
    <td width="120" valign="top" class="hPayItem itemrbn"><strong>商品番号</strong></td>
    <td width="150" valign="top" class="hPayItem itemrbn"><strong>商品名</strong></td>
    <td width="60" valign="top" class="hPayItem itemrbn"><strong>数量</strong></td>
    <td width="90" valign="top" class="hPayItem"><strong>金額</strong></td>
  </tr>
  <tr>
    <td valign="top" class="payItem itemrbn">4G-S-001</td>
    <td valign="top" class="payItem itemrbn"><?php echo $item ?></td>
    <td valign="top" class="payItem itemrbn" style="text-align:right;">1</td>
    <td valign="top" class="payItem" style="text-align:right;">10 円</td>
  </tr>
  <tr>
    <td valign="top" colspan="3" class="fPayItem itemrbn"><strong>合計金額</strong></td>
    <td valign="top" class="fPayItem" style="text-align:right;"><strong><?php echo $price ?></strong> 円</td>
  </tr>
</table>
</td>
</tr>
</table>
<div style="font-size:80%">（注）画像はイメージです。</div>
<br/><br/>
<div class="lhtitle">決済方法選択</div>
下記から決済方法を選択してください。
<form method="POST" action="./PaymentMethodSelect.php">
<ul style="list-style:none">
  <li><input type="radio" name="method" value="card" checked/>クレジットカード</li>
  <li><input type="radio" name="method" value="mpi"/>クレジットカード（本人認証あり）</li>
  <li><input type="radio" name="method" value="cvs"/>コンビニエンスストア</li>
  <li><input type="radio" name="method" value="em"/>電子マネー</li>
  <li><input type="radio" name="method" value="bank"/>銀行</li>
  <li><input type="radio" name="method" value="paypal"/>PayPal</li>
  <li><input type="radio" name="method" value="saison"/>永久不滅ポイント(永久不滅ウォレット)</li>
  <li><input type="radio" name="method" value="upop"/>銀聯ネット決済(UPOP)</li>
  <li><input type="radio" name="method" value="alipay"/>Alipay</li>
  <li><input type="radio" name="method" value="carrier" />キャリア決済</li>
  <li><input type="radio" name="method" value="oricosc"/>ショッピングクレジット</li>
  <li><input type="radio" name="method" value="rakuten"/>楽天ID決済</li>
  <li><input type="radio" name="method" value="recruit"/>リクルートかんたん支払い</li>
  <li><input type="radio" name="method" value="linepay"/>LINE Pay</li>
  <li><input type="radio" name="method" value="masterpass"/>MasterPass決済</li>
  <li><input type="radio" name="method" value="virtualacc"/>銀行振込決済</li>
</ul>
<input type="submit" value="決済手続きへ"/>
</form>
<hr/>
<ul class="flinkmenu">
  <li><a href="./AdminMenu.php">管理者向けメニューサンプルはこちら</a></li>
  <li><a href="./PayNowIdMenu.php">PayNowIDメニューサンプルはこちら</a></li>
</ul>
<hr/>
<img alt='VeriTransロゴ' src='./WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
