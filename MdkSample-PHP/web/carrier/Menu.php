<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済取引選択画面
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - キャリア決済処理選択サンプル画面</title>
<link href="../css/style.css?1286186298" media="all" rel="stylesheet" type="text/css">
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G キャリア決済のメニューのサンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<div class="lhtitle">キャリア決済：取引選択</div>
<table border="1" cellpadding="0" cellspacing="0">
<tr>
<td>
<!-- キャリア決済では、消費者から決済請求と継続課金終了請求が可能なため、このサンプルでは選択できるようにしている。 -->
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400">&nbsp;</td></tr>
  <tr><td width="400"><a href="./Authorize.php?price=10">決済請求</a></td></tr>
  <tr><td width="400">&nbsp;</td></tr>
  <tr><td width="400"><a href="./Terminate.php">継続課金終了請求</a></td></tr>
  <tr><td width="400">&nbsp;</td></tr>
</table>
</td>
</tr>
</table>

<input type="hidden" name="amount" value="10">

<br>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>
