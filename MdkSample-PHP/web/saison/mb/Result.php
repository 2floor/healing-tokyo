<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 永久不滅ポイント(永久不滅ウォレット)<?php echo $processName ?>サンプル画面</title>
</head>
<body>
<form method="post" action="./CaptureExec">
<img alt='Paymentロゴ' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">携帯用の<?php echo $processName ?>サンプル画面です。</font>
<br>

<br>
永久不滅ポイント(永久不滅ウォレット)決済処理結果：<br><?php echo $processName ?><br>
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

================<br>
<br>
<br>
<br>

<?php if ("Authorize" !== $_screen) { ?>
カード決済処理結果：<br><?php echo $processName ?><br>
<br>

=== 処理結果 ===<br>
<br>

取引ID：<br>
<?php echo $cardOrderId ?><br>
<br>

取引ステータス：<br>
<?php echo $cardMStatus ?><br>
<br>

結果コード：<br>
<?php echo $cardVResultCode ?><br>
<br>

結果メッセージ：<br>
<?php echo $cardMErrMsg ?><br>
<br>

<?php if ("Cancel" !== $_screen) { ?>
カード番号：<br>
<?php echo $reqCardNumber ?><br>
<br>

承認番号：<br>
<?php echo $resAuthCode ?><br>
<br>

<?php } ?>

<?php } ?>

<?php if ("success" === $mStatus && "Capture" === $_screen) { ?>
<a href="./Cancel.php?orderId=<?php echo $orderId ?>">取消請求へ</a><br>
<br>
<?php } ?>
<img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</form>
</body>
</html>
