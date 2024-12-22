<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 電子マネー決済 返金入力画面のサンプル
// -------------------------------------------------------------------------
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 電子マネー決済返金要求サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 電子マネー決済の返金取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<div class="lhtitle">電子マネー決済：返金請求</div>
<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_EM" method="post" action="RefundExec.php">
<tr>
  <td class="ititletop">決済サービスオプション</td>
  <td class="ivaluetop">
    <select name="serviceOptionType">
      <option value="edy-pc"<?php if ("edy-pc" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>サイバーEdy決済</option>
      <option value="edy-mobile"<?php if ("edy-mobile" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>モバイルEdy決済</option>
      <option value="edy-direct"<?php if ("edy-direct" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>モバイルEdyダイレクト決済</option>
      <option value="suica-mobile-mail"<?php if ("suica-mobile-mail" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>モバイルSuica メール決済</option>
      <option value="suica-mobile-app"<?php if ("suica-mobile-app" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>モバイルSuica アプリ決済</option>
      <option value="suica-pc-mail"<?php if ("suica-pc-mail" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>Suicaインターネットサービス メール決済</option>
      <option value="suica-pc-app"<?php if ("suica-pc-app" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>Suicaインターネットサービス アプリ決済</option>
      <option value="waon-pc"<?php if ("waon-pc" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>WAONネット決済PC</option>
      <option value="waon-mobile"<?php if ("waon-mobile" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>WAONネット決済モバイル</option>
    </select>
    <!-- 対象取引種別 -->
    <input type="hidden" name="orderKind" value="refund">
  </td>
</tr>
<tr>
  <td class="ititle">決済金額</td>
  <td class="ivalue"><input type="text" maxlength="5" size="6" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">対象取引ID</td>
  <td class="ivalue"><input type="text" maxlength="100" size="30" name="refundOrderId" value="<?php echo htmlspecialchars(@$_POST["refundOrderId"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">決済期限</td>
  <td class="ivalue">
    <input type="text" maxlength="14" size="15" name="settlementLimit" value="<?php echo htmlspecialchars(@$_POST["settlementLimit"]) ?>"><br/>
    <font size="2" color="red">※形式：YYYYMMDDhhmmss</font><br/>
    <font size="2" color="red">※Suica系決済の場合のみ必須です。</font><br/>
  </td>
</tr>
<tr>
  <td class="ititle">画面タイトル</td>
  <td class="ivalue">
    <input type="text" maxlength="40" size="50" name="screenTitle" value="<?php echo htmlspecialchars(@$_POST["screenTitle"]) ?>"><br/>
    <font size="2" color="red">※Suica系決済以外の場合は入力不要です。</font><br/>
  </td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
  <td colspan="2"><input type="submit" value="返金">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</form>
</table>

<br>
<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
