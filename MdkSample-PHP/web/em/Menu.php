<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 電子マネー決済処理選択画面のサンプル
// -------------------------------------------------------------------------
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 電子マネー決済処理選択サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 電子マネー決済のメニューのサンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>

<div class="lhtitle">電子マネー決済：取引選択</div>
<table border="1" cellpadding="0" cellspacing="0">
<tr>
<td>
<!-- 電子マネー決済では、決済請求と再決済請求請求（nanaco決済のみ）が存在するため、このサンプルでは選択できるようにしています。 -->
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400">&nbsp;</td></tr>
  <tr><td width="400"><a href="./Authorize.php?price=<?php echo htmlspecialchars(@$_GET["price"]) ?>">決済請求</a></td></tr>
  <tr><td width="400">&nbsp;</td></tr>
  <tr><td width="400"><a href="./ReAuthorize.php">再決済請求</a></td></tr>
  <tr><td width="400">&nbsp;</td></tr>
</table>
</td>
</tr>
</table>

<br>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;
<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
