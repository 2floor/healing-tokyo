<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// PayPal決済入力画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - PayPal決済 サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<script type="text/javascript">
		function reDrawing(frm, action) {
			frm.action = action;
			frm.method = "POST";
			frm.submit();
		}
	</script>
<img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"/><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G PayPal決済の取引サンプル画面です。<br/>
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
  <td class="ptitle"><div class="lhtitle">PayPal決済：決済請求</div></td>
  <td class="pcxts">
  <img src="../WEB-IMG/PayPal.gif"/>
  </td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_PAYPAL" method="post" action="./AuthorizeInit.php">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="button" value="取引ID更新" onclick="reDrawing(FORM_PAYPAL, 'Authorize.php');"><input type="hidden" name="orderId" value="<?php echo $order_id ?>"></td>
</tr>
<tr>
  <td class="ititle">決済金額</td>
  <td class="ivalue"><input type="text" maxlength="7" size="8" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">決済方法</td>
  <td class="ivalue">
  <select name="paymentAction">
    <option value="capture"<?php if ("capture" == htmlspecialchars(@$_POST["paymentAction"])) { echo " selected"; } ?>>与信同時売上</option>
    <option value="authorize"<?php if ("authorize" == htmlspecialchars(@$_POST["paymentAction"])) { echo " selected"; } ?>>与信のみ</option>
  </select>
  </td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
  <td colspan="2"><input type="submit" value="購入">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</form>
</table>

<br>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>
