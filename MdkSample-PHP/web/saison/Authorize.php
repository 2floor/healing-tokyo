<?php
# Copyright(C) 2012 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// 永久不滅ポイント(永久不滅ウォレット)ユーザ認可サンプル画面
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 永久不滅ポイント(永久不滅ウォレット)ユーザ認可サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
function reDrawing() {
  location.href = "./Authorize.php?amount=" + document.FORM_SAISON.amount.value;
}

function reDrawing(frm, action) {
  frm.action = action;
  frm.method = "POST";
  frm.submit();
}
</script>
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 永久不滅ポイント(永久不滅ウォレット)決済の決済サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<table>
<tr>
  <td>
    <div class="lhtitle">永久不滅ポイント(永久不滅ウォレット)決済：ユーザ認可</div>
  </td>
  <td>
    <img  src='../WEB-IMG/saison.jpg' width="80%" height="80%"/>
  </td>
  <td width="20"><br></td>
</tr>
</table>

<form name="FORM_SAISON" method="post" action="./AuthorizeExec.php">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><input type="button" value="取引ID更新" onclick="reDrawing(FORM_SAISON, 'Authorize.php');"></td>
</tr>
<tr>
  <td class="ititle">金額</td>
  <td class="ivalue"><input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2"><input type="submit" value="購入">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</table>
<input type="hidden" name="_screen" value="Authorize">
</form>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
