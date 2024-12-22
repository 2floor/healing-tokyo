<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 永久不滅ポイント(永久不滅ウォレット)取消サンプル画面</title>
</head>
<body>
<form method="post" action="./CancelExec.php">
<img alt='Paymentロゴ' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">携帯用の取消サンプル画面です。</font>
<br>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<br>
永久不滅ポイント(永久不滅ウォレット)決済：<br>取消請求<br>
<br>

=== 決済内容 ===<br>
<br>

取引ID：<br>
<input type="text" maxlength="100" size="30" name="orderId" value="<?php echo $_GET['orderId'] ?>"><br>
<br>

カード取消フラグ：<br>
<input type="radio" name="cardCancelFlag" value="1" checked="checked">&nbsp;永久不滅とカード決済の両方キャンセル<br>
<input type="radio" name="cardCancelFlag" value="0">&nbsp;永久不滅のみキャンセル<br>
<br>

<input type="submit" value="取消"><br>
<br>

================<br>
<br>

<input type="hidden" name="_screen" value="Cancel">
<img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</form>
</body>
</html>
