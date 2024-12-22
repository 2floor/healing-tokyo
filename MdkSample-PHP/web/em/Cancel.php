<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 電子マネー決済 取消入力画面のサンプル
// -------------------------------------------------------------------------
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 電子マネー決済取消サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 電子マネー決済の取消取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<div class="lhtitle">電子マネー決済：取消請求</div>
<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_EM" method="post" action="CancelExec.php">
<tr>
  <td class="ititletop">決済サービスオプション</td>
  <td class="ivaluetop">
    <select name="serviceOptionType">
      <option value="suica-mobile-mail"<?php if ("suica-mobile-mail" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>モバイルSuica メール決済</option>
      <option value="suica-mobile-app"<?php if ("suica-mobile-app" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>モバイルSuica アプリ決済</option>
      <option value="suica-pc-mail"<?php if ("suica-pc-mail" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>Suicaインターネットサービス メール決済</option>
      <option value="suica-pc-app"<?php if ("suica-pc-app" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>Suicaインターネットサービス アプリ決済</option>
      <option value="tcc-redirect"<?php if ("tcc-redirect" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>nanaco決済</option>
    </select>
  </td>
</tr>
<tr>
  <td class="ititle">取引ID</td>
  <td class="ivalue"><input type="text" maxlength="100" size="30" name="orderId" value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">対象取引種別</td>
  <td class="ivalue">
    <select name="orderKind">
      <option value=""<?php if ("" == htmlspecialchars(@$_POST["orderKind"])) { echo " selected"; } ?>></option>
      <option value="authorize"<?php if ("authorize" == htmlspecialchars(@$_POST["orderKind"])) { echo " selected"; } ?>>決済請求</option>
      <option value="refund"<?php if ("refund" == htmlspecialchars(@$_POST["orderKind"])) { echo " selected"; } ?>>返金</option>
    </select>
    <font size="2" color="red">※nanaco決済の場合は入力する必要はありません。</font>
  </td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
  <td colspan="2"><input type="submit" value="取消">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</form>
</table>

<br>
<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
