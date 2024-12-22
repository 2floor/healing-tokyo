<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 電子マネー決済 決済請求入力画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
本画面はVeriTrans4G 電子マネー決済の取引サンプル画面です。<br/>
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
  <td class="ptitle"><div class="lhtitle">電子マネー決済：決済請求</div></td>
  <td class="pcxts">
    <img src="../WEB-IMG/EM_Edy.jpg"/>
    <img src="../WEB-IMG/EM_Suica.jpg"/>
  </td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_EM" method="post" action="AuthorizeExec.php">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="button" value="取引ID更新" onclick="reDrawing(FORM_EM, 'Authorize.php');"><input type="hidden" name="orderId" value="<?php echo $order_id ?>"></td>
</tr>
<tr>
  <td class="ititle">決済サービスオプション</td>
  <td class="ivalue">
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
      <option value="tcc-redirect"<?php if ("tcc-redirect" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>nanaco決済</option>
    </select>
  </td>
</tr>
<tr>
  <td class="ititle">決済金額</td>
  <td class="ivalue"><input type="text" maxlength="5" size="6" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">決済期限</td>
  <td class="ivalue">
    <input type="text" maxlength="14" size="15" name="settlementLimit" value="<?php echo htmlspecialchars(@$_POST["settlementLimit"]) ?>"><br/>
    <font size="2" color="red">※形式：YYYYMMDDhhmmss</font><br/>
    <font size="2" color="red">※ｻｲﾊﾞｰEdy決済、ﾓﾊﾞｲﾙEdyﾀﾞｲﾚｸﾄ決済、nanaco決済の場合は入力不要です。</font><br/>
  </td>
</tr>
<tr>
  <td class="ititle">支払取消期限</td>
  <td class="ivalue">
    <input type="text" maxlength="14" size="15" name="cancelLimit" value="<?php echo htmlspecialchars(@$_POST["cancelLimit"]) ?>"><br/>
    <font size="2" color="red">※形式：YYYYMMDDhhmmss</font><br/>
    <font size="2" color="red">※WAONﾈｯﾄ決済、WAONﾓﾊﾞｲﾙ決済のみ必須です。</font><br/>
  </td>
</tr>
<tr>
  <td class="ititle">メールアドレス</td>
  <td class="ivalue">
    <input type="text" maxlength="256" size="50" name="mailAddress" value="<?php echo htmlspecialchars(@$_POST["mailAddress"]) ?>"><br/>
    <font size="2" color="red">※ｻｲﾊﾞｰEdy決済､ﾓﾊﾞｲﾙEdyﾀﾞｲﾚｸﾄ決済、ﾓﾊﾞｲﾙSuica ｱﾌﾟﾘ決済､Suicaｲﾝﾀｰﾈｯﾄｻｰﾋﾞｽ ｱﾌﾟﾘ決済、nanaco決済の場合は入力不要です。</font><br/>
  </td>
</tr>
<tr>
  <td class="ititle">ユーザID</td>
  <td class="ivalue">
  <input type="text" maxlength="64" size="50" name="userId" value="<?php echo htmlspecialchars(@$_POST["userId"]) ?>"><br/>
  <font size="2" color="red">※nanaco決済のみ必須です</font>
  </td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><input type="submit" value="購入">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td></tr>
</form>
</table>

<br>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
