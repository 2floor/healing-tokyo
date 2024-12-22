<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 電子マネー決済 カード情報削除入力画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 電子マネー決済 サンプル画面</title>
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
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 電子マネー決済のカード情報削除サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<div class="lhtitle">電子マネー決済：カード情報削除</div>
<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_EM" method="post" action="RemoveExec.php">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="button" value="取引ID更新" onclick="reDrawing(FORM_EM, 'Remove.php');"><input type="hidden" name="orderId" value="<?php echo $order_id ?>"></td>
</tr>
<tr>
  <td class="ititle">決済サービスオプション</td>
  <td class="ivalue">
    <select name="serviceOptionType">
      <option value="tcc-redirect"<?php if ("tcc-redirect" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>nanaco決済</option>
    </select>
  </td>
</tr>

<tr>
  <td class="ititle">ユーザID</td>
  <td class="ivalue">
  <input type="text" maxlength="64" size="50" name="userId" value="<?php echo htmlspecialchars(@$_POST["userId"]) ?>"><br/>
  <font size="2" color="red">※nanaco決済のみ必須です。</font>
  </td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><input type="submit" value="削除">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td></tr>
</form>
</table>

<br>
<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
