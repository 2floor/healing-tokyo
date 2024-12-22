<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード決済再与信(3D認証付き)入力画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - カード決済再与信(3D認証付き)サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
function jpoChk(jpoObj) {
    var val = jpoObj.value;
    if (val.length == 1) {
        if (isNaN(val) == false) {
            jpoObj.value = "0" + jpoObj.value;
        }
    }
}
</script>
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G カード決済再与信(3D認証付き)の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<div class="lhtitle">カード決済(3D認証付き)：再与信請求</div>
<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_MPI" method="post" action="ReAuthorizeExec.php">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="button" value="取引ID更新" onclick="reDrawing(FORM_MPI);"><input type="hidden" name="orderId" value="<?php echo $order_id ?>"></td>
</tr>
<tr>
  <td class="ititle">元取引ID</td>
  <td class="ivalue"><input type="text" maxlength="100" size="30" name="originalOrderId" value="<?php echo htmlspecialchars(@$_POST["originalOrderId"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">決済金額</td>
  <td class="ivalue"><input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">決済種別</td>
  <td class="ivalue">
    <select name="paymentMode">
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>1: 3D-Secure認証のみ(決済しない)</option>
      <option value="2"<?php if ("2" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>2: 完全認証(3D-Secure認証が完全に成功した場合のみ決済する)</option>
      <option value="3"<?php if ("3" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>3: 通常認証(カード会社リスク負担にて決済する)</option>
      <option value="4"<?php if ("4" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>4: 通常認証(カード会社か加盟店リスク負担にて決済する)</option>
    </select><br>
    &nbsp;&nbsp;<font size="2" color="red">※この項目は消費者が選択せず、内部的に設定いただく項目です。</font>
  </td>
</tr>
<tr>
  <td class="ititle">与信方法</td>
  <td class="ivalue">
    <select name="withCapture">
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信のみ(与信成功後に売上処理を行う必要があります)</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信売上(与信と同時に売上処理も行います)</option>
    </select>
  </td>
</tr>
<tr>
  <td class="ititle">支払方法</td>
  <td class="ivalue">
    <select name="jpo1">
      <option value="10"<?php if ("10" == htmlspecialchars(@$_POST["jpo1"])) { echo " selected"; } ?>>一括払い(支払回数の設定は不要)</option>
      <option value="61"<?php if ("61" == htmlspecialchars(@$_POST["jpo1"])) { echo " selected"; } ?>>分割払い(支払回数を設定してください)</option>
      <option value="80"<?php if ("80" == htmlspecialchars(@$_POST["jpo1"])) { echo " selected"; } ?>>リボ払い(支払回数の設定は不要)</option>
    </select>
  </td>
</tr>
<tr>
  <td class="ititle">支払回数</td>
  <td class="ivalue"><input type="text" maxlength="2" size="3" name="jpo2" value="<?php echo htmlspecialchars(@$_POST["jpo2"]) ?>" onBlur="jpoChk(this);">&nbsp;&nbsp;<font size="2" color="red">※一桁の場合は数値の前に&quot;0&quot;をつけてください。&nbsp;&nbsp;例：01</font></td>
</tr>
<tr>
  <td class="ititle">セキュリティコード</td>
  <td class="ivalue"><input type="text" maxlength="4" size="5" name="securityCode" value="<?php echo htmlspecialchars(@$_POST["securityCode"]) ?>">&nbsp;&nbsp;<font size="2" color="red">※必要な場合は入力してください。</font></td>
</tr>
<tr>
  <td class="ititle">プッシュ通知先URL</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="pushUrl" value="<?php echo htmlspecialchars(@$_POST["pushUrl"]) ?>"><br>
    &nbsp;&nbsp;<font size="2" color="red">※必要な場合は入力してください。</font>
  </td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><input type="submit" value="購入">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td></tr>
</form>
</table>

<br>
<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
