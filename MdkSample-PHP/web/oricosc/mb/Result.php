<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - �V���b�s���O�N���W�b�g<?php echo $processName ?>�T���v�����</title>
</head>
<body>
<img alt='Payment���S' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">�g�їp��<?php echo $processName ?>�T���v����ʂł��B</font>
<br>

<br>
�V���b�s���O�N���W�b�g���Ϗ������ʁF<br><?php echo $processName ?><br>
<br>

=== �������� ===<br>
<br>
���ID�F<br>
<?php echo $orderId ?><br>
<br>

����X�e�[�^�X�F<br>
<?php echo $mStatus ?><br>
<br>

���ʃR�[�h�F<br>
<?php echo $vResultCode ?><br>
<br>

���ʃ��b�Z�[�W�F<br>
<?php echo $mErrMsg ?><br>
<br>

<?php if ("Authorize" !== $_screen) { ?>
  ��t�ԍ��F<br>
  <?php echo $receiptNo ?>
<?php } ?>
<br>
================<br>
<br>
<br>
<br>

<img alt='VeriTrans���S' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
