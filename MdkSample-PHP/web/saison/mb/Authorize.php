<?php
# Copyright(C) 2012 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// �i�v�s�Ń|�C���g(�i�v�s�ŃE�H���b�g)���[�U�F�T���v�����
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - �i�v�s�Ń|�C���g(�i�v�s�ŃE�H���b�g)���[�U�F�T���v�����</title>
</head>
<body>
<form method="post" action="./AuthorizeExec.php">
<img alt='Payment���S' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">�g�їp�̃��[�U�F�T���v����ʂł��B</font>
<br>

<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>

<br>
�i�v�s�Ń|�C���g(�i�v�s�ŃE�H���b�g)���ρF<br>���[�U�F��<br>
<br>

=== ���ϓ��e ===<br>
<br>

���ID�F<br>
<?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><br>
<input type="submit" name="updateOrderIdButton" value="���ID�X�V"><br>
<br>

���z�F<br>
<input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"><br>
<br>

<input type="submit" name="button"  value="�w��"><br>
</form>

================<br>
<br>

<input type="hidden" name="_screen" value="Authorize">
<img alt='VeriTrans���S' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
