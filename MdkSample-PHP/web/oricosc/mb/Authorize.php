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
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - ショッピングクレジット決済画面表示サンプル画面</title>
</head>
<body>
<form method="post" action="./AuthorizeExec.php">
<img alt='Paymentロゴ' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">携帯用の画面表示サンプル画面です。</font>
<br>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>

<br>
ショッピングクレジット決済：<br>画面表示<br>
<br>
=== 決済内容 ===<br>
<br>
取引ID：<br>
<?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><br>
<input type="submit" name="updateOrderIdButton" value="取引ID更新"><br>
<br>

注文番号：<br>
<?php echo $orico_order_no ?>&nbsp;&nbsp;<input type="hidden" name="oricoOrderNo" value="<?php echo $orico_order_no ?>"><br>
<br>

会員番号：<br>
<input type="text" name="userNo" maxlength="20" value="<?php echo htmlspecialchars(@$_POST["userNo"]) ?>"><br>
<br>

配送先郵便番号：<br>
<input type="text" name="shippingZipCode" maxlength="8" value="<?php echo htmlspecialchars(@$_POST["shippingZipCode"]) ?>"><br>
<font size="2" color="red">※形式：000-0000</font><br>
<br>

取扱契約番号：<br>
<input type="text" name="handlingContractNo" maxlength="3" value="<?php echo htmlspecialchars(@$_POST["handlingContractNo"]) ?>"><br>
<br>

契約書有無区分：<br>
<input type="text" name="contractDocumentKbn" maxlength="1" value="<?php echo htmlspecialchars(@$_POST["contractDocumentKbn"]) ?>"><br>
<br>

WEB申込商品ID：<br>
<input type="text" name="webDescriptionId" maxlength="4" value="<?php echo htmlspecialchars(@$_POST["webDescriptionId"]) ?>"><br>
<br>

<font size="2" color="red">※必ず「商品名１」、「数量１」、「商品価格１（税込）」は指定してください。</font><br>
商品名１：<br>
<input type="text" maxlength="256" name="itemName1" value="<?php echo htmlspecialchars(@$_POST["itemName1"]) ?><?php echo htmlspecialchars(@$_GET["item1_name"]) ?>"><br>
<br>

数量１：<br>
<input type="text" maxlength="3" name="itemCount1" value="<?php echo htmlspecialchars(@$_POST["itemCount1"]) ?><?php echo htmlspecialchars(@$_GET["item1_quantity"]) ?>"><br>
<br>

商品価格１(税込)：<br>
<input type="text" maxlength="8" name="itemAmount1" value="<?php echo htmlspecialchars(@$_POST["itemAmount1"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"><br>
<br>

商品名２：<br>
<input type="text" maxlength="256" name="itemName2" value="<?php echo htmlspecialchars(@$_POST["itemName2"]) ?>"><br>
<br>

数量２：<br>
<input type="text" maxlength="3" name="itemCount2" value="<?php echo htmlspecialchars(@$_POST["itemCount2"]) ?>"><br>
<br>

商品価格２(税込)：<br>
<input type="text" maxlength="8" name="itemAmount2" value="<?php echo htmlspecialchars(@$_POST["itemAmount2"]) ?>"><br>
<br>

商品名３：<br>
<input type="text" maxlength="256" name=itemName3 value="<?php echo htmlspecialchars(@$_POST["itemName3"]) ?>"><br>
<br>

数量３：<br>
<input type="text" maxlength="3" name="itemCount3" value="<?php echo htmlspecialchars(@$_POST["itemCount3"]) ?>"><br>
<br>

商品価格３(税込)：<br>
<input type="text" maxlength="8" name="itemAmount3" value="<?php echo htmlspecialchars(@$_POST["itemAmount3"]) ?>"><br>
<br>

商品名４：<br>
<input type="text" maxlength="256" name="itemName4" value="<?php echo htmlspecialchars(@$_POST["itemName4"]) ?>"><br>
<br>

数量４：<br>
<input type="text" maxlength="3" name="itemCount4" value="<?php echo htmlspecialchars(@$_POST["itemCount4"]) ?>"><br>
<br>

商品価格４(税込)：<br>
<input type="text" maxlength="8" name="itemAmount4" value="<?php echo htmlspecialchars(@$_POST["itemAmount4"]) ?>"><br>
<br>

商品名５：<br>
<input type="text" maxlength="256" name="itemName5" value="<?php echo htmlspecialchars(@$_POST["itemName5"]) ?>"><br>
<br>

数量５：<br>
<input type="text" maxlength="3" name="itemCount5" value="<?php echo htmlspecialchars(@$_POST["itemCount5"]) ?>"><br>
<br>

商品価格５(税込)：<br>
<input type="text" maxlength="8" name="itemAmount5" value="<?php echo htmlspecialchars(@$_POST["itemAmount5"]) ?>"><br>
<br>

商品価格合計(税込)：<br>
<input type="text" maxlength="8" name="totalItemAmount" value="<?php echo htmlspecialchars(@$_POST["totalItemAmount"]) ?>"><br>
<br>

送料合計(税込)：<br>
<input type="text" maxlength="8" name="totalCarriage" value="<?php echo htmlspecialchars(@$_POST["totalCarriage"]) ?>"><br>
<br>

支払金額合計：<br>
<input type="text" maxlength="8" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?>"><br>
<br>

頭金：<br>
<input type="text" maxlength="8" name="deposit" value="<?php echo htmlspecialchars(@$_POST["deposit"]) ?>"><br>
<br>

<input type="submit" name="button"  value="購入"><br>
================<br>
<br>

<input type="hidden" name="_screen" value="Authorize">
</form>
<img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>