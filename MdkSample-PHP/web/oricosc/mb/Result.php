<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - ショッピングクレジット<?php echo $processName ?>サンプル画面</title>
</head>
<body>
<img alt='Paymentロゴ' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">携帯用の<?php echo $processName ?>サンプル画面です。</font>
<br>

<br>
ショッピングクレジット決済処理結果：<br><?php echo $processName ?><br>
<br>

=== 処理結果 ===<br>
<br>
取引ID：<br>
<?php echo $orderId ?><br>
<br>

取引ステータス：<br>
<?php echo $mStatus ?><br>
<br>

結果コード：<br>
<?php echo $vResultCode ?><br>
<br>

結果メッセージ：<br>
<?php echo $mErrMsg ?><br>
<br>

<?php if ("Authorize" !== $_screen) { ?>
  受付番号：<br>
  <?php echo $receiptNo ?>
<?php } ?>
<br>
================<br>
<br>
<br>
<br>

<img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
