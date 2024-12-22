<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// コンビニ決済取消入力画面のサンプル
// -------------------------------------------------------------------------

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - コンビニ決済取消サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G コンビニ決済の取消取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<div class="lhtitle">コンビニ決済：取消請求</div>
<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_CVS" method="post" action="CancelExec.php">
<tr>
  <td class="ititletop">決済サービスオプション</td>
  <td class="ivaluetop">
    <select name="serviceOptionType">
      <option value="sej"<?php if ("sej" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>セブンイレブン</option>
      <option value="econ"<?php if ("econ" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ローソン､ファミリーマートetc</option>
      <option value="other"<?php if ("other" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>サークルKサンクス、デイリーヤマザキetc</option>
    </select>
  </td>
</tr>
<tr>
  <td class="ititle">取引ID</td>
  <td class="ivalue"><input type="text" maxlength="100" size="30" name="orderId" value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>"></td>
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
