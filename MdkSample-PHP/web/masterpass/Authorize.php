<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// MasterPass決済入力画面のサンプル
// -------------------------------------------------------------------------

  // 取引IDの作成
  $order_id = "dummy".time();


  if (!defined('MDK_DIR')) {
    define('MDK_DIR', '../tgMdk/');
  }
  require_once(MDK_DIR."3GPSMDK.php");

  // is dummy mode?
  $config = TGMDK_Config::getInstance();
  $conf   = $config->getServiceParameters();
  if (isset($conf)) {
    $dummyReq = $conf["DUMMY_REQUEST"];
  }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - MasterPass決済与信サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">

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
本画面はVeriTrans4G MasterPass決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>

<div class="lhtitle">MasterPass Authorize<br/>(決済：決済請求)</div>
<?php if (empty($warning)) { ?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">Order Id<br/>(取引ID)</td>
    <td class="rivaluetop"><?php echo htmlspecialchars(@$_POST["orderId"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Card Number<br/>(カード番号)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["cardNumber"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Name<br/>(配送先：氏名)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["shippingName"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Phone<br/>(配送先：電話番号)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["shippingPhone"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">City<br/>(配送先：市)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["shippingCity"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Country<br/>(配送先：国)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["shippingCountry"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Country Sub Division<br/>(配送先：地域)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["shippingCountrySubdivision"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Address1<br/>(配送先：住所１)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["shippingAddress1"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Address2<br/>(配送先：住所２)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["shippingAddress2"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">Address3<br/>(配送先：住所３)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["shippingAddress3"]) ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">PostalCode<br/>(配送先：郵便番号)</td>
    <td class="rivalue"><?php echo htmlspecialchars(@$_POST["shippingPostalCode"]) ?><br/></td>
  </tr>

</table>
<?php } ?>

</br>

<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_MASTERPASS" method="post" action="./AuthorizeExec.php">

<input type="hidden" name="orderId" value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>" >

<tr>
  <td class="ititleTop">Amount<br/>(決済金額)</td>
  <td class="ivalueTop"><input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?>"></td>
</tr>

<tr>
  <td class="ititle">With or Without Capture<br/>(与信方法)</td>
  <td class="ivalue">
    <select name="withCapture">
      <option value=""></option>
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>Authorize Only 与信のみ(与信成功後に売上処理を行う必要があります)</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>Authorize & Capture 与信売上(与信と同時に売上処理も行います)</option>
    </select>
    <br/>
  </td>
</tr>


<input type="hidden" name="dummyMode" value="<?php echo $dummyReq ?>" >

<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2"><input type="submit" value="Buy (購入)">&nbsp;&nbsp;<font size="2" color="red">※Please avoid double Click (２回以上クリックしないでください。)</font></td>
</tr>
</form>
</table>

<br>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
