<?php
//$processName     = htmlspecialchars($_GET["processName"]);
//$_screen         = $_GET["_screen"];
//
//$orderId         = htmlspecialchars($_GET["orderId"]);
//$mStatus         = htmlspecialchars($_GET["mStatus"]);
//$vResultCode     = htmlspecialchars($_GET["vResultCode"]);
//$mErrMsg         = htmlspecialchars($_GET["mErrMsg"]);
//
//$cardOrderId     = htmlspecialchars($_GET["cardOrderId"]);
//$cardMStatus     = htmlspecialchars($_GET["cardMStatus"]);
//$cardVResultCode = htmlspecialchars($_GET["cardVResultCode"]);
//$cardMErrMsg     = htmlspecialchars($_GET["cardMErrMsg"]);
//$reqCardNumber   = htmlspecialchars($_GET["reqCardNumber"]);
//$resAuthCode     = htmlspecialchars($_GET["resAuthCode"]);
//
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>永久不滅ポイント(永久不滅ウォレット)決済処理結果</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 永久不滅ポイント(永久不滅ウォレット)決済の<?php echo $processName ?>処理結果表示画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">永久不滅ポイント(永久不滅ウォレット)決済処理結果：<?php echo $processName ?></div>
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
</table>
<br/>

<?php if ("Authorize" !== $_screen) { ?>
<div class="lhtitle">カード決済処理結果：<?php echo $processName ?></div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">取引ID</td>
    <td class="rivaluetop"><?php echo $cardOrderId ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">取引ステータス</td>
    <td class="rivalue"><?php echo $cardMStatus ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">結果コード</td>
    <td class="rivalue"><?php echo $cardVResultCode ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">結果メッセージ</td>
    <td class="rivalue"><?php echo $cardMErrMsg ?><br/></td>
  </tr>
</table>
<br/>

<?php if ("Cancel" !== $_screen) { ?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">カード番号</td>
    <td class="rivaluetop"><?php echo $reqCardNumber ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">承認番号</td>
    <td class="rivalue"><?php echo $resAuthCode ?><br/></td>
  </tr>
</table>
<br/>
<?php } ?>

<?php } ?><?php if ("Authorize" === $_screen || "Capture" === $_screen) { ?>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;
<?php } else { ?>
<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;
<?php } ?>

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>

