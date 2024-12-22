<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <meta http-equiv="Content-Language" content="ja" />
<title>ショッピングクレジット決済処理結果</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G ショッピングクレジット決済の<?php echo $processName ?>処理結果表示画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>
<div class="lhtitle">ショッピングクレジット決済処理結果：<?php echo $processName ?></div>
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
<?php if ("Authorize" !== $_screen) { ?>
  <tr>
    <td class="rititle">受付番号</td>
    <td class="rivalue"><?php echo $receiptNo ?><br/></td>
  </tr>
<?php } ?>
</table>
<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>