<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// �L�����A���όp���ۋ��I����ʂ̃T���v���F���o�C��
// -------------------------------------------------------------------------

  $order_id = "dummy".time();

  $config_file = "../../env4sample.ini";

  if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $base_url = $env_info["Common"]["base.url"];
    $successUrl = $env_info["Carrier"]["success.url.mb"];
    $cancelUrl = $env_info["Carrier"]["cancel.url.mb"];
    $errorUrl = $env_info["Carrier"]["error.url.mb"];
    $pushUrl = $env_info["Carrier"]["push.url.mb"];
  }

  if (!defined('MDK_DIR')) {
    define('MDK_DIR', '../../tgMdk/');
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
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<title>VeriTrans 4G - �L�����A���όp���ۋ��I���T���v�����</title>
</head>
<body>

<form name="FORM_CARRIER" method="post" action="./TerminateExec.php">
<img alt='Payment���S' src='../../WEB-IMG/VeriTrans_Payment.png'>
<br><br><font size="2"> �g�їp�̌p���ۋ��I������T���v����ʂł��B</font><br>

<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<br>
�L�����A���ρF�p���ۋ��I������<br>
<br>
=== ���ϓ��e ===<br>
<br>
<!-- �t�B�[�`���[�t�H�������ɂ�3�ҊԂ̂� -->
<input type="hidden" name="force" value="false" />
<!-- �t�B�[�`���[�t�H���Ȃ̂ŁA�[����ʂ̓K���P�[ -->
<input type="hidden" name="terminalKind" value="2" />

�L�����A�I��<br>
<select name="serviceOptionType">
      <option value="docomo" <?php if ("docomo" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>�h�R��</option>
      <option value="au" <?php if ("au" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>au</option>
</select>
<br><br>

���ID<br>
<input type="text" maxlength="100" size="30" name="orderId" value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>">
<br><br>

<!-- �e��URL��hidden�� -->
<input type="hidden" name="successUrl" value="<?php echo $successUrl; ?>">
<input type="hidden" name="cancelUrl"  value="<?php echo $cancelUrl;  ?>">
<input type="hidden" name="errorUrl"   value="<?php echo $errorUrl;   ?>">
<input type="hidden" name="pushUrl"    value="<?php if ($dummyReq === "1") { echo $pushUrl; } ?>">
<!-- submit button -->
<input type="submit" value="�p���ۋ��I��">
</form>

<img alt='VeriTrans���S' src='../../WEB-IMG/VeriTransLogo_WH.png'>
<br>Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
