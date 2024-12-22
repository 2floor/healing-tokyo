<?php
# Copyright(C) 2013 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// ショッピングクレジット決済画面表示サンプル画面
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
  $orico_order_no = $order_id;
  
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - ショッピングクレジット画面表示サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
function reDrawing() {
  location.href = "./Authorize.php?amount=" + document.FORM_ORICOSC.amount.value;
}

function reDrawing(frm, action) {
	frm.action = action;
	frm.method = "POST";
	frm.submit();
}

function reCalcSum() {
      // 各商品価格を計算
      var itemAmount1 = Number(document.FORM_ORICOSC.itemAmount1.value);
      var itemAmount2 = Number(document.FORM_ORICOSC.itemAmount2.value);
      var itemAmount3 = Number(document.FORM_ORICOSC.itemAmount3.value);
      var itemAmount4 = Number(document.FORM_ORICOSC.itemAmount4.value);
      var itemAmount5 = Number(document.FORM_ORICOSC.itemAmount5.value);

      // 商品価格合計と支払金額合計算出
      // 送料合計
      var totalCarriage = Number(document.FORM_ORICOSC.totalCarriage.value);
      var totalItemAmount = itemAmount1 + itemAmount2 + itemAmount3 + itemAmount4 + itemAmount5;
      var amount = totalItemAmount + totalCarriage;
      document.getElementById('totalItemAmount').innerHTML = totalItemAmount;
      document.getElementById('HtotalItemAmount').value = totalItemAmount;
      document.getElementById('amount').innerHTML = amount;
      document.getElementById('Hamount').value = amount;
}
</script>
</head>
<body onload="reCalcSum();">

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G ショッピングクレジット決済の決済サンプル画面です。<br/>
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
  <td>
    <div class="lhtitle">ショッピングクレジット決済：画面表示</div>
  </td>
  <td>
    <img  src='../WEB-IMG/Oricosc.png' width="140" height="30"/>
  </td>
</tr>
</table>
<form name="FORM_ORICOSC" method="post" action="./AuthorizeExec.php">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><input type="button" value="取引ID更新" onclick="reDrawing(FORM_ORICOSC, 'Authorize.php');"></td>
</tr>
<tr>
  <td class="ititle">注文番号</td>
  <td class="ivalue"><?php echo $orico_order_no ?>&nbsp;&nbsp;<input type="hidden" name="oricoOrderNo" value="<?php echo $orico_order_no ?>"></td>
</tr>
<tr>
  <td class="ititle">会員番号</td>
  <td class="ivalue"><input type="text" maxlength="20" size="20" name="userNo" value="<?php echo htmlspecialchars(@$_POST["userNo"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">配送先郵便番号</td>
  <td class="ivalue"><input type="text" maxlength="8" size="20" name="shippingZipCode" value="<?php echo htmlspecialchars(@$_POST["shippingZipCode"]) ?>">&nbsp;&nbsp;<font size="2" color="red">※形式：000-0000</font></td>
</tr>
<tr>
  <td class="ititle">取扱契約番号</td>
  <td class="ivalue"><input type="text" maxlength="3" size="3" name="handlingContractNo" value="<?php echo htmlspecialchars(@$_POST["handlingContractNo"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">契約書有無区分</td>
  <td class="ivalue"><input type="text" maxlength="1" size="1" name="contractDocumentKbn" value="<?php echo htmlspecialchars(@$_POST["contractDocumentKbn"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">WEB申込商品ID</td>
  <td class="ivalue"><input type="text" maxlength="4" size="4" name="webDescriptionId" value="<?php echo htmlspecialchars(@$_POST["webDescriptionId"]) ?>"></td>
</tr>
</table>
<br/>
<font size="2" color="red">※必ず「商品１」は設定してください。</font>
<br/>
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <th></th>
    <th>商品名</th>
    <th>数量</th>
    <th>商品価格(税込)</th>
  </tr>
  <tr>
    <td class="ititle">商品１</td>
    <td style="border-style:none;">
      <input type="text" name="itemName1" value="<?php echo htmlspecialchars(@$_POST["itemName1"]) ?><?php echo htmlspecialchars(@$_GET["item1_name"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" align="right" name="itemCount1" size="4" maxlength="3" value="<?php echo htmlspecialchars(@$_POST["itemCount1"]) ?><?php echo htmlspecialchars(@$_GET["item1_quantity"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" name="itemAmount1" size="20" maxlength="8" value="<?php echo htmlspecialchars(@$_POST["itemAmount1"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"  onchange="reCalcSum()">
    </td>
  </tr>
  <tr>
    <td class="ititle">商品２</td>
    <td style="border-style:none;">
      <input type="text" name="itemName2" size="20" value="<?php echo htmlspecialchars(@$_POST["itemName2"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" name="itemCount2" size="4" maxlength="3" value="<?php echo htmlspecialchars(@$_POST["itemCount2"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" name="itemAmount2" size="20" maxlength="8" value="<?php echo htmlspecialchars(@$_POST["itemAmount2"]) ?>" id="itemAmount2" onchange="reCalcSum()">
    </td>
  </tr>
  <tr>
    <td class="ititle">商品３</td>
    <td style="border-style:none;">
      <input type="text" name="itemName3" size="20" value="<?php echo htmlspecialchars(@$_POST["itemName3"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" name="itemCount3" size="4" value="<?php echo htmlspecialchars(@$_POST["itemCount3"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" name="itemAmount3" size="20" maxlength="8" value="<?php echo htmlspecialchars(@$_POST["itemAmount3"]) ?>" id="itemAmount3" onchange="reCalcSum()">
    </td>
  </tr>
  <tr>
    <td class="ititle">商品４</td>
    <td style="border-style:none;">
      <input type="text" name="itemName4" size="20" value="<?php echo htmlspecialchars(@$_POST["itemName4"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" name="itemCount4" size="4" value="<?php echo htmlspecialchars(@$_POST["itemCount4"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" name="itemAmount4" size="20" maxlength="8" value="<?php echo htmlspecialchars(@$_POST["itemAmount4"]) ?>" id="itemAmount4" onchange="reCalcSum()">
    </td>
  </tr>
  <tr>
    <td class="ititle">商品５</td>
    <td style="border-style:none;">
      <input type="text" name="itemName5" size="20" value="<?php echo htmlspecialchars(@$_POST["itemName5"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" name="itemCount5" size="4" value="<?php echo htmlspecialchars(@$_POST["itemCount5"]) ?>">
    </td>
    <td style="border-style:none;">
      <input type="text" name="itemAmount5" size="20" maxlength="8" value="<?php echo htmlspecialchars(@$_POST["itemAmount5"]) ?>" id="itemAmount5" onchange="reCalcSum()">
    </td>
  </tr>
  <tr>
    <td class="ititle">商品価格合計(税込)</td>
    <td colspan="3" align="right">
      <span id="totalItemAmount">-</span>円
      <input type="hidden" name="totalItemAmount" value="0"id="HtotalItemAmount">
    </td>
  </tr>
  <tr>
    <td class="ititle">送料合計(税込)</td>
    <td colspan="3" align="right">
      <input type="text" maxlength="8" size="8" name="totalCarriage" value="<?php echo htmlspecialchars(@$_POST["totalCarriage"]) ?>"  onchange="reCalcSum()" id="totalCarriage">
    </td>
  </tr>
  <tr>
    <td class="ititle">支払金額合計</td>
    <td colspan="3" align="right">
      <span id="amount">-</span>円
      <input type="hidden" name="amount" value="0" id="Hamount">
    </td>
  </tr>
  <tr>
    <td class="ititle">頭金</td>
    <td colspan="3" align="right">
    <input type="text" maxlength="8" size="8" name="deposit" value="<?php echo htmlspecialchars(@$_POST["deposit"]) ?>">
    </td>
  </tr>
</table>

<br/>
<input type="submit" value="購入">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font>
<input type="hidden" name="_screen" value="Authorize">
</form>


<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>