<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済売上入力画面のサンプル
// -------------------------------------------------------------------------

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - キャリア決済売上サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G キャリア決済の売上取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<div class="lhtitle">キャリア決済：売上請求</div>
<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_CARD" method="post" action="CaptureExec.php">
<tr>
  <td class="ititletop">キャリア選択</td>
  <td class="ivaluetop">
    <select name="serviceOptionType">
      <option value="docomo" <?php if ("docomo" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ドコモ</option>
      <option value="au" <?php if ("au" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>au</option>
      <option value="sb_ktai" <?php if ("sb_ktai" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ソフトバンクまとめて支払い（B）</option>
      <option value="s_bikkuri" <?php if ("s_bikkuri" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>S!まとめて支払い</option>
      <option value="flets" <?php if ("flets" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>フレッツまとめて支払い</option>
    </select><br/>
    <font size="2" color="red">※ソフトバンクまとめて支払い（B）：旧ソフトバンクケータイ支払い</font>
  </td>
</tr>
<tr>
  <td class="ititle">取引ID</td>
  <td class="ivalue"><input type="text" maxlength="100" size="30" name="orderId" value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">課金売上月(YYYYMM)</td>
  <td class="ivalue" style="width:540px;"><input type="text" maxlength="6" size="7" name="captureMonth" value="<?php echo htmlspecialchars(@$_POST["captureMonth"]) ?>"><br/>
    <font size="2" color="red">※継続課金でドコモ・フレッツまとめて支払い・ソフトバンクまとめて支払い（B）は指定可能</font>
  </td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
  <td colspan="2"><input type="submit" value="売上">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</form>
</table>

<br>
<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>
