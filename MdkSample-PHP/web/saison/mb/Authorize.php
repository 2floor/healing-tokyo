<?php
# Copyright(C) 2012 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// 永久不滅ポイント(永久不滅ウォレット)ユーザ認可サンプル画面
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 永久不滅ポイント(永久不滅ウォレット)ユーザ認可サンプル画面</title>
</head>
<body>
<form method="post" action="./AuthorizeExec.php">
<img alt='Paymentロゴ' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">携帯用のユーザ認可サンプル画面です。</font>
<br>

<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>

<br>
永久不滅ポイント(永久不滅ウォレット)決済：<br>ユーザ認可<br>
<br>

=== 決済内容 ===<br>
<br>

取引ID：<br>
<?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><br>
<input type="submit" name="updateOrderIdButton" value="取引ID更新"><br>
<br>

金額：<br>
<input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"><br>
<br>

<input type="submit" name="button"  value="購入"><br>
</form>

================<br>
<br>

<input type="hidden" name="_screen" value="Authorize">
<img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
