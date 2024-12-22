<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// MasterPass決済（Login）取引画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();

  $config_file = "../env4sample.ini";

  if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $base_url = $env_info["Common"]["base.url"];
    $successUrl = $env_info["MasterPass"]["success.url"];
    $cancelUrl = $env_info["MasterPass"]["cancel.url"];
    $errorUrl = $env_info["MasterPass"]["error.url"];
  }

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
<title>VeriTrans 4G - MasterPass決済申込サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
</script>
</head>
<body onload="reCalcSum();">
  <script type="text/javascript">
    function reDrawing(frm, action) {
      frm.action = action;
      frm.method = "POST";
      frm.submit();
    }

    // 金額再計算
    function reCalcSum() {

      var value1  = Number(document.getElementById('value1').value);
      var value2  = Number(document.getElementById('value2').value);
      var value3  = Number(document.getElementById('value3').value);
      var value4  = Number(document.getElementById('value4').value);
      var value5  = Number(document.getElementById('value5').value);
      var value6  = Number(document.getElementById('value6').value);
      var value7  = Number(document.getElementById('value7').value);
      var value8  = Number(document.getElementById('value8').value);
      var value9  = Number(document.getElementById('value9').value);
      var value10 = Number(document.getElementById('value10').value);

      // 合計金額を算出
      var itemAmount = value1 + value2 + value3 + value4 + value5 +
      value6 + value7 + value8 + value9 + value10;
      document.getElementById('itemAmount').innerHTML = itemAmount;
      document.getElementById('inputItemAmount').value = itemAmount;
    }
  </script>
</head>
<body onload="setDisabled();">

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G MasterPass決済（Login）の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>

<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>


<div class="lhtitle">MasterPass Login<br/>(決済：申込)</div>
<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_MASTERPASS" method="post" action="./LoginExec.php">

<tr>
  <td class="ititletop">Order ID<br/>(取引ID)</td>
  <td class="ivaluetop"><span><?php echo $order_id ?></span>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><input type="button" value="Update Order ID (取引ID更新)" onclick="reDrawing(FORM_MASTERPASS, './Login.php');"></td>
</tr>
<tr>
  <td class="ititle">Product Number<br/>(商品番号)</td>
  <td class="ivalue"><input type="text" maxlength="64" size="20" name="itemId" value="<?php echo htmlspecialchars(@$_POST["itemId"]) ?>"><br/>
    <font size="2" color="red">64 byte Alphanumeric characters (64バイト以下の半角英数字)</font>
  </td>
</tr>
<tr>
  <td class="ititle">Supress Shipping Adress<br/>(配送先抑止フラグ)</td>
  <td class="ivalue">
    <select name="suppressShippingAddress">
      <option value=""></option>
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["suppressShippingAddress"])) { echo " selected"; } ?>>false</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["suppressShippingAddress"])) { echo " selected"; } ?>>true（Supress-抑止する）</option>
    </select><br/>
    </font>
  </td>
</tr>

<tr>
  <td class="ititle">Shipping Locations<br/>(配送先許可エリア)</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="shippingLocationProfile" value="<?php echo htmlspecialchars(@$_POST["shippingLocationProfile"]) ?>"></td>
</tr>


<input type="hidden" name="d3Flag" value="0" />

<tr>
  <td class="ititle">Success URL<br/>(決済完了時URL)</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="successUrl" value="<?php echo $successUrl ?>"></td>
</tr>

<tr>
  <td class="ititle">Cancel URL<br/>(決済キャンセル時URL)</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="cancelUrl" value="<?php echo $cancelUrl ?>"></td>
</tr>

<tr>
  <td class="ititle">Error URL<br/>(決済エラー時URL)</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="errorUrl" value="<?php echo $errorUrl ?>"></td>
</tr>

<input type="hidden" name="dummyMode" value="<?php echo $dummyReq ?>" />
</table>

<br/>
<font size="2" color="red">※必ず「商品１」は設定してください。</font>
<br/>
<table border="1" cellpadding="0" cellspacing="0">

  <tr>
    <th>
    <th>Product Description<br/>(商品説明)</th>
    <th>Product Quantity<br/>(商品数量)</th>
    <th>Product Value<br/>(商品金額)</th>
    <th>Product Image URL<br/>(商品イメージURL)</th>
  </tr>
  <tr>
    <td class="ititle">Product1<br/>(商品１)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="100" size="30" name="description1" value="<?php echo htmlspecialchars(@$_POST["description1"]) ?><?php echo htmlspecialchars(@$_GET["description1"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12" name="quantity1" value="<?php echo htmlspecialchars(@$_POST["quantity1"]) ?><?php echo htmlspecialchars(@$_GET["quantity1"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value1" size="20" value="<?php echo htmlspecialchars(@$_POST["value1"]) ?><?php echo htmlspecialchars(@$_GET["value1"]) ?>" id="value1" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="256" size="45" name="imageUrl1" value="<?php echo htmlspecialchars(@$_POST["imageUrl1"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl1"]) ?>">
    </td>
  </tr>
  <tr>
    <td class="ititle">Product2<br/>(商品２)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="100" size="30" name="description2" value="<?php echo htmlspecialchars(@$_POST["description2"]) ?><?php echo htmlspecialchars(@$_GET["description2"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12"  name="quantity2" value="<?php echo htmlspecialchars(@$_POST["quantity2"]) ?><?php echo htmlspecialchars(@$_GET["quantity2"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value2" value="<?php echo htmlspecialchars(@$_POST["value2"]) ?><?php echo htmlspecialchars(@$_GET["value2"]) ?>" id="value2" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="256" size="45" name="imageUrl2" value="<?php echo htmlspecialchars(@$_POST["imageUrl2"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl2"]) ?>">
    </td>
  </tr>
  <tr>
    <td class="ititle">Product3<br/>(商品３)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="100" size="30" name="description3" value="<?php echo htmlspecialchars(@$_POST["description3"]) ?><?php echo htmlspecialchars(@$_GET["description3"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12"  name="quantity3" value="<?php echo htmlspecialchars(@$_POST["quantity3"]) ?><?php echo htmlspecialchars(@$_GET["quantity3"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value3" value="<?php echo htmlspecialchars(@$_POST["value3"]) ?><?php echo htmlspecialchars(@$_GET["value3"]) ?>" id="value3" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text"maxlength="256" size="45"  name="imageUrl3" value="<?php echo htmlspecialchars(@$_POST["imageUrl3"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl3"]) ?>">
    </td>
  </tr>
  <tr>
    <td class="ititle">Product4<br/>(商品４)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="20" size="30" name="description4" value="<?php echo htmlspecialchars(@$_POST["description4"]) ?><?php echo htmlspecialchars(@$_GET["description4"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12"  name="quantity4" value="<?php echo htmlspecialchars(@$_POST["quantity4"]) ?><?php echo htmlspecialchars(@$_GET["quantity4"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value4" value="<?php echo htmlspecialchars(@$_POST["value4"]) ?><?php echo htmlspecialchars(@$_GET["value4"]) ?>" id="value4" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="256" size="45" name="imageUrl4" value="<?php echo htmlspecialchars(@$_POST["imageUrl4"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl4"]) ?>">
    </td>
  </tr>
  <tr>
    <td class="ititle">Product5<br/>(商品５)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="20" size="30" name="description5" value="<?php echo htmlspecialchars(@$_POST["description5"]) ?><?php echo htmlspecialchars(@$_GET["description5"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12"  name="quantity5" value="<?php echo htmlspecialchars(@$_POST["quantity5"]) ?><?php echo htmlspecialchars(@$_GET["quantity5"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value5" value="<?php echo htmlspecialchars(@$_POST["value5"]) ?><?php echo htmlspecialchars(@$_GET["value5"]) ?>" id="value5" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="256" size="45" name="imageUrl5" value="<?php echo htmlspecialchars(@$_POST["imageUrl5"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl5"]) ?>">
    </td>
  </tr>
  <tr>
    <td class="ititle">Product6<br/>(商品６)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="20" size="30" name="description6" value="<?php echo htmlspecialchars(@$_POST["description6"]) ?><?php echo htmlspecialchars(@$_GET["description6"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12"  name="quantity6" value="<?php echo htmlspecialchars(@$_POST["quantity6"]) ?><?php echo htmlspecialchars(@$_GET["quantity6"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value6" value="<?php echo htmlspecialchars(@$_POST["value6"]) ?><?php echo htmlspecialchars(@$_GET["value6"]) ?>" id="value6" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="256" size="45" name="imageUrl6" value="<?php echo htmlspecialchars(@$_POST["imageUrl6"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl6"]) ?>">
    </td>
  </tr>
  <tr>
    <td class="ititle">Product7<br/>(商品７)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="20" size="30" name="description7" value="<?php echo htmlspecialchars(@$_POST["description7"]) ?><?php echo htmlspecialchars(@$_GET["description7"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12"  name="quantity7" value="<?php echo htmlspecialchars(@$_POST["quantity7"]) ?><?php echo htmlspecialchars(@$_GET["quantity7"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value7" value="<?php echo htmlspecialchars(@$_POST["value7"]) ?><?php echo htmlspecialchars(@$_GET["value7"]) ?>" id="value7" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="256" size="45" name="imageUrl7" value="<?php echo htmlspecialchars(@$_POST["imageUrl7"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl7"]) ?>">
    </td>
  </tr>
  <tr>
    <td class="ititle">Product8<br/>(商品８)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="20" size="30" name="description8" value="<?php echo htmlspecialchars(@$_POST["description8"]) ?><?php echo htmlspecialchars(@$_GET["description8"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12"  name="quantity8" value="<?php echo htmlspecialchars(@$_POST["quantity8"]) ?><?php echo htmlspecialchars(@$_GET["quantity8"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value8" value="<?php echo htmlspecialchars(@$_POST["value8"]) ?><?php echo htmlspecialchars(@$_GET["value8"]) ?>" id="value8" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="256" size="45" name="imageUrl8" value="<?php echo htmlspecialchars(@$_POST["imageUrl8"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl8"]) ?>">
    </td>
  </tr>
  <tr>
    <td class="ititle">Product9<br/>(商品９)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="20" size="30" name="description9" value="<?php echo htmlspecialchars(@$_POST["description9"]) ?><?php echo htmlspecialchars(@$_GET["description9"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12"  name="quantity9" value="<?php echo htmlspecialchars(@$_POST["quantity9"]) ?><?php echo htmlspecialchars(@$_GET["quantity9"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value9" value="<?php echo htmlspecialchars(@$_POST["value9"]) ?><?php echo htmlspecialchars(@$_GET["value9"]) ?>" id="value9" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="256" size="45" name="imageUrl9" value="<?php echo htmlspecialchars(@$_POST["imageUrl9"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl9"]) ?>">
    </td>
  </tr>
  <tr>
    <td class="ititle">Product10<br/>(商品１０)</td>
    <td style="border-style:none;">
      <input type="text" maxlength="20" size="30" name="description10" value="<?php echo htmlspecialchars(@$_POST["description10"]) ?><?php echo htmlspecialchars(@$_GET["description10"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="12"  name="quantity10" value="<?php echo htmlspecialchars(@$_POST["quantity10"]) ?><?php echo htmlspecialchars(@$_GET["quantity10"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="8" name="value10" value="<?php echo htmlspecialchars(@$_POST["value10"]) ?><?php echo htmlspecialchars(@$_GET["value10"]) ?>" id="value10" onchange="reCalcSum()">
    </td>
    <td style="border-style:none;">
      <input type="text" maxlength="256" size="45" name="imageUrl10" value="<?php echo htmlspecialchars(@$_POST["imageUrl10"]) ?><?php echo htmlspecialchars(@$_GET["imageUrl10"]) ?>">
    </td>
  </tr>
</table>
<br>
<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td class="ititle">Total Amount<br/>(合計金額)</td>
    <td style="border-style:none;" align="right">
      <span id="itemAmount">-</span>円
      <input type="hidden" name="itemAmount" value="<?php echo htmlspecialchars(@$_POST["itemAmount"]) ?><?php echo htmlspecialchars(@$_GET["itemAmount"]) ?>" id="inputItemAmount">
    </td>
  </tr>
</table>
<br/>
<table>
<tr>
  <td>
  <a href="#" onclick="document.FORM_MASTERPASS.submit()"><img src="https://www.mastercard.com/mc_us/wallet/img/en/US/mcpp_wllt_btn_chk_147x034px.png" alt="Buy with MasterPass"></a>
  &nbsp;&nbsp;<font size="2" color="red">※Please avoid double Click (２回以上クリックしないでください。)</font>
  </td>
</tr>
</form>
</table>

<br>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
