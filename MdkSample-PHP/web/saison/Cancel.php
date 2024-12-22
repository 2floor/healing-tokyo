<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 永久不滅ポイント(永久不滅ウォレット)取消サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
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

<div class="lhtitle">永久不滅ポイント(永久不滅ウォレット)決済：取消請求</div>
<form name="FORM_SAISON" method="post" action="./CancelExec.php">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><input type="text" maxlength="100" size="30" name="orderId" value="<?php array_key_exists('orderId', $_GET) ? $_GET["orderId"] : "" ?>"></td>
</tr>
<tr>
  <td class="ititle">カード取消フラグ</td>
  <td class="ivalue">
    <table border="0">
        <tr>
          <td><input type="radio" name="cardCancelFlag" value="1" checked="checked"></td><td>永久不滅とカード決済の両方キャンセル</td>
        </tr>
        <tr>
          <td><input type="radio" name="cardCancelFlag" value="0"></td><td>永久不滅のみキャンセル</td>
        </tr>
    </table>
  </td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2"><input type="submit" value="取消">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</table>
<input type="hidden" name="_screen" value="Cancel">
</form>

<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
