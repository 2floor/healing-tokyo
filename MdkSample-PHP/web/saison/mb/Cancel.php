<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - �i�v�s�Ń|�C���g(�i�v�s�ŃE�H���b�g)����T���v�����</title>
</head>
<body>
<form method="post" action="./CancelExec.php">
<img alt='Payment���S' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">�g�їp�̎���T���v����ʂł��B</font>
<br>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<br>
�i�v�s�Ń|�C���g(�i�v�s�ŃE�H���b�g)���ρF<br>�������<br>
<br>

=== ���ϓ��e ===<br>
<br>

���ID�F<br>
<input type="text" maxlength="100" size="30" name="orderId" value="<?php echo $_GET['orderId'] ?>"><br>
<br>

�J�[�h����t���O�F<br>
<input type="radio" name="cardCancelFlag" value="1" checked="checked">&nbsp;�i�v�s�łƃJ�[�h���ς̗����L�����Z��<br>
<input type="radio" name="cardCancelFlag" value="0">&nbsp;�i�v�s�ł̂݃L�����Z��<br>
<br>

<input type="submit" value="���"><br>
<br>

================<br>
<br>

<input type="hidden" name="_screen" value="Cancel">
<img alt='VeriTrans���S' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</form>
</body>
</html>
