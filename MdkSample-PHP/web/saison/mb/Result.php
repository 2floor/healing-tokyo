<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - �i�v�s�Ń|�C���g(�i�v�s�ŃE�H���b�g)<?php echo $processName ?>�T���v�����</title>
</head>
<body>
<form method="post" action="./CaptureExec">
<img alt='Payment���S' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">�g�їp��<?php echo $processName ?>�T���v����ʂł��B</font>
<br>

<br>
�i�v�s�Ń|�C���g(�i�v�s�ŃE�H���b�g)���Ϗ������ʁF<br><?php echo $processName ?><br>
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

================<br>
<br>
<br>
<br>

<?php if ("Authorize" !== $_screen) { ?>
�J�[�h���Ϗ������ʁF<br><?php echo $processName ?><br>
<br>

=== �������� ===<br>
<br>

���ID�F<br>
<?php echo $cardOrderId ?><br>
<br>

����X�e�[�^�X�F<br>
<?php echo $cardMStatus ?><br>
<br>

���ʃR�[�h�F<br>
<?php echo $cardVResultCode ?><br>
<br>

���ʃ��b�Z�[�W�F<br>
<?php echo $cardMErrMsg ?><br>
<br>

<?php if ("Cancel" !== $_screen) { ?>
�J�[�h�ԍ��F<br>
<?php echo $reqCardNumber ?><br>
<br>

���F�ԍ��F<br>
<?php echo $resAuthCode ?><br>
<br>

<?php } ?>

<?php } ?>

<?php if ("success" === $mStatus && "Capture" === $_screen) { ?>
<a href="./Cancel.php?orderId=<?php echo $orderId ?>">���������</a><br>
<br>
<?php } ?>
<img alt='VeriTrans���S' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</form>
</body>
</html>
