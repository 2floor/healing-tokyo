<?php
# Copyright(C) 2013 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// �V���b�s���O�N���W�b�g���ω�ʕ\���T���v�����
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
  $orico_order_no = $order_id;
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - �V���b�s���O�N���W�b�g���ω�ʕ\���T���v�����</title>
</head>
<body>
<form method="post" action="./AuthorizeExec.php">
<img alt='Payment���S' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">�g�їp�̉�ʕ\���T���v����ʂł��B</font>
<br>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>

<br>
�V���b�s���O�N���W�b�g���ρF<br>��ʕ\��<br>
<br>
=== ���ϓ��e ===<br>
<br>
���ID�F<br>
<?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><br>
<input type="submit" name="updateOrderIdButton" value="���ID�X�V"><br>
<br>

�����ԍ��F<br>
<?php echo $orico_order_no ?>&nbsp;&nbsp;<input type="hidden" name="oricoOrderNo" value="<?php echo $orico_order_no ?>"><br>
<br>

����ԍ��F<br>
<input type="text" name="userNo" maxlength="20" value="<?php echo htmlspecialchars(@$_POST["userNo"]) ?>"><br>
<br>

�z����X�֔ԍ��F<br>
<input type="text" name="shippingZipCode" maxlength="8" value="<?php echo htmlspecialchars(@$_POST["shippingZipCode"]) ?>"><br>
<font size="2" color="red">���`���F000-0000</font><br>
<br>

�戵�_��ԍ��F<br>
<input type="text" name="handlingContractNo" maxlength="3" value="<?php echo htmlspecialchars(@$_POST["handlingContractNo"]) ?>"><br>
<br>

�_�񏑗L���敪�F<br>
<input type="text" name="contractDocumentKbn" maxlength="1" value="<?php echo htmlspecialchars(@$_POST["contractDocumentKbn"]) ?>"><br>
<br>

WEB�\�����iID�F<br>
<input type="text" name="webDescriptionId" maxlength="4" value="<?php echo htmlspecialchars(@$_POST["webDescriptionId"]) ?>"><br>
<br>

<font size="2" color="red">���K���u���i���P�v�A�u���ʂP�v�A�u���i���i�P�i�ō��j�v�͎w�肵�Ă��������B</font><br>
���i���P�F<br>
<input type="text" maxlength="256" name="itemName1" value="<?php echo htmlspecialchars(@$_POST["itemName1"]) ?><?php echo htmlspecialchars(@$_GET["item1_name"]) ?>"><br>
<br>

���ʂP�F<br>
<input type="text" maxlength="3" name="itemCount1" value="<?php echo htmlspecialchars(@$_POST["itemCount1"]) ?><?php echo htmlspecialchars(@$_GET["item1_quantity"]) ?>"><br>
<br>

���i���i�P(�ō�)�F<br>
<input type="text" maxlength="8" name="itemAmount1" value="<?php echo htmlspecialchars(@$_POST["itemAmount1"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"><br>
<br>

���i���Q�F<br>
<input type="text" maxlength="256" name="itemName2" value="<?php echo htmlspecialchars(@$_POST["itemName2"]) ?>"><br>
<br>

���ʂQ�F<br>
<input type="text" maxlength="3" name="itemCount2" value="<?php echo htmlspecialchars(@$_POST["itemCount2"]) ?>"><br>
<br>

���i���i�Q(�ō�)�F<br>
<input type="text" maxlength="8" name="itemAmount2" value="<?php echo htmlspecialchars(@$_POST["itemAmount2"]) ?>"><br>
<br>

���i���R�F<br>
<input type="text" maxlength="256" name=itemName3 value="<?php echo htmlspecialchars(@$_POST["itemName3"]) ?>"><br>
<br>

���ʂR�F<br>
<input type="text" maxlength="3" name="itemCount3" value="<?php echo htmlspecialchars(@$_POST["itemCount3"]) ?>"><br>
<br>

���i���i�R(�ō�)�F<br>
<input type="text" maxlength="8" name="itemAmount3" value="<?php echo htmlspecialchars(@$_POST["itemAmount3"]) ?>"><br>
<br>

���i���S�F<br>
<input type="text" maxlength="256" name="itemName4" value="<?php echo htmlspecialchars(@$_POST["itemName4"]) ?>"><br>
<br>

���ʂS�F<br>
<input type="text" maxlength="3" name="itemCount4" value="<?php echo htmlspecialchars(@$_POST["itemCount4"]) ?>"><br>
<br>

���i���i�S(�ō�)�F<br>
<input type="text" maxlength="8" name="itemAmount4" value="<?php echo htmlspecialchars(@$_POST["itemAmount4"]) ?>"><br>
<br>

���i���T�F<br>
<input type="text" maxlength="256" name="itemName5" value="<?php echo htmlspecialchars(@$_POST["itemName5"]) ?>"><br>
<br>

���ʂT�F<br>
<input type="text" maxlength="3" name="itemCount5" value="<?php echo htmlspecialchars(@$_POST["itemCount5"]) ?>"><br>
<br>

���i���i�T(�ō�)�F<br>
<input type="text" maxlength="8" name="itemAmount5" value="<?php echo htmlspecialchars(@$_POST["itemAmount5"]) ?>"><br>
<br>

���i���i���v(�ō�)�F<br>
<input type="text" maxlength="8" name="totalItemAmount" value="<?php echo htmlspecialchars(@$_POST["totalItemAmount"]) ?>"><br>
<br>

�������v(�ō�)�F<br>
<input type="text" maxlength="8" name="totalCarriage" value="<?php echo htmlspecialchars(@$_POST["totalCarriage"]) ?>"><br>
<br>

�x�����z���v�F<br>
<input type="text" maxlength="8" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?>"><br>
<br>

�����F<br>
<input type="text" maxlength="8" name="deposit" value="<?php echo htmlspecialchars(@$_POST["deposit"]) ?>"><br>
<br>

<input type="submit" name="button"  value="�w��"><br>
================<br>
<br>

<input type="hidden" name="_screen" value="Authorize">
</form>
<img alt='VeriTrans���S' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>