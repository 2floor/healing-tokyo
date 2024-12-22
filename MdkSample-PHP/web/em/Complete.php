<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 電子マネー決済結果取得画面表示サンプル
// -------------------------------------------------------------------------

 $orderId         = htmlspecialchars($_GET["orderId"]);
 $mStatus         = htmlspecialchars($_GET["mstatus"]);
 $vResultCode     = htmlspecialchars($_GET["vResultCode"]);
 $mErrMsg         = htmlspecialchars($_GET["merrMsg"]);
 $balance         = array_key_exists('balance', $_GET) ? htmlspecialchars($_GET['balance']) : "";
 $completeDate    = array_key_exists('completeDate', $_GET) ? htmlspecialchars($_GET['completeDate']) : "";
 $cardNo          = htmlspecialchars($_GET["cardNo"]);
 $cardBrandCode   = htmlspecialchars($_GET["cardBrandCode"]);
 $cardKind        = htmlspecialchars($_GET["cardKind"]);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title><?php echo "取引結果" ?></title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 電子マネー決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>
<div class="lhtitle">電子マネー決済：取引結果</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">取引ID</td>
    <td class="rivaluetop"><?php echo $orderId ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">取引ステータス</td>
    <td class="rivalue"><?php echo $mStatus ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">結果コード</td>
    <td class="rivalue"><?php echo $vResultCode ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">結果メッセージ</td>
    <td class="rivalue"><?php echo $mErrMsg ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">取引成立日時</td>
    <td class="rivalue"><?php echo $completeDate ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">残高</td>
    <td class="rivalue"><?php echo $balance ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">取引カード番号</td>
    <td class="rivalue"><?php echo $cardNo ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">取引カードブランドコード</td>
    <td class="rivalue"><?php echo $cardBrandCode ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">カード種別</td>
    <td class="rivalue"><?php echo $cardKind ?><br/></td>
  </tr>
</table>

<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
