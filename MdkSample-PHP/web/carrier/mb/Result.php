<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// �L�����A���ς̎��s����ь��ʉ�ʂ̃T���v��
// -------------------------------------------------------------------------

define('MDK_DIR', '../../tgMdk/');
require_once(MDK_DIR."3GPSMDK.php");

// ���ID
$result_order_id = htmlspecialchars(@$_GET["orderId"]);
// ����X�e�[�^�X
$txn_status = htmlspecialchars(@$_GET["mstatus"]);
// ���ʃR�[�h
$txn_result_code = htmlspecialchars(@$_GET["vResultCode"]);

/**
 * ���ώ��
 */
$command = htmlspecialchars(@$_GET["command"]);
if($command === "Authorize"){
    $str_command = "����";
}
elseif($command === "Terminate"){
    $str_command = "�p���ۋ��I��";
}

/**
 * �������
 */
$result = htmlspecialchars(@$_GET["result"]);
if($result === "SUCCESS"){
    $str_result = "����";
}
elseif($result === "CANCEL"){
    $str_result = "�L�����Z��";
}
elseif($result === "ERROR"){
    $str_result = "�G���[";
}

$conf = TGMDK_Config::getInstance();
$array = $conf->getConnectionParameters();
$merchant_cc_id = $array[TGMDK_Config::MERCHANT_CC_ID];
$merchant_pw = $array[TGMDK_Config::MERCHANT_SECRET_KEY];
$charset = "UTF-8";

$check_result = TGMDK_AuthHashUtil::checkAuthHash(@$_GET, $merchant_cc_id, $merchant_pw, $charset);
if (!isset($check_result) || $check_result == false) {
    $warn_msg = "<font color='#ff0000'><b>�y�p�����[�^��₁z�p�����[�^��񂪉�₂���Ă��܂��B</b></font><br/><br/>";
} else {
    echo "<!-- vAuthInfo check is OK -->";
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>������ʁi<?php echo $result ?>�j</title>
</head>
<body>
<img alt='Payment���S' src='../../WEB-IMG/VeriTrans_Payment.png'>
<br><br>
<font size="2">�g�їp�̎�����ʃT���v����ʂł��B</font>
<br><br>
�L�����A���ρF<br>
������ʁi<?php echo $str_command ?><?php echo $str_result ?>�j
<br><br>

<?php
    if (isset($warn_msg)) echo $warn_msg;
?>

=== �������� ===<br>
<br>

���ID<br>
<?php echo $result_order_id ?><br>
<br>

����X�e�[�^�X<br>
<?php echo $txn_status ?><br>
<br>

���ʃR�[�h<br>
<?php echo $txn_result_code ?><br>
<br>

================<br>
<br>
<img alt='VeriTrans���S' src='../../WEB-IMG/VeriTransLogo_WH.png'>
<br>Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>

