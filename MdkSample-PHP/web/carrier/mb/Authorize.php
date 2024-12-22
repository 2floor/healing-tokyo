<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// �L�����A���ϓ��͉�ʂ̃T���v��(�g��)
// -------------------------------------------------------------------------

  $order_id = "dummy".ceil(microtime(true)*1000);

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
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - �L�����A���σT���v�����</title>
</head>
<body>

<form name="FORM_CARRIER" method="post" action="./AuthorizeExec.php">
<img alt='Payment���S' src='../../WEB-IMG/VeriTrans_Payment.png'>
<br><br><font size="2">�g�їp�̎���T���v����ʂł��B</font><br>

<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<br>
�L�����A���ρF���ϐ���<br>
<br>
=== ���ϓ��e ===<br>
<br>

���ID�F<br>
<?php echo $order_id ?>
<input type="hidden" name="orderId" value="<?php echo $order_id ?>">
<br><br>

<!-- �[����� -->
<input type="hidden" name="terminalKind" value="2">

�L�����A�I��<br>
<select name="serviceOptionType">
      <option value="docomo" <?php if ("docomo" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>�h�R��</option>
      <option value="au" <?php if ("au" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>au</option>
      <option value="s_bikkuri" <?php if ("s_bikkuri" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>S!�܂Ƃ߂Ďx����</option>
</select>
<br><br>

���z<br>
<input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>">
<br><br>

���i�^�C�v<br>
<select name="itemType">
      <option value="0" <?php if ("0" === htmlspecialchars(@$_POST["itemType"])) { echo " selected"; } ?> >�f�W�^���R���e���c</option>
      <option value="1" <?php if ("1" === htmlspecialchars(@$_POST["itemType"])) { echo " selected"; } ?> >����</option>
      <option value="2" <?php if ("2" === htmlspecialchars(@$_POST["itemType"])) { echo " selected"; } ?> >��</option>
</select>
<br><br>

�s�x�p���敪<br>
<select name="accountingType">
      <option value="0" <?php if ("0" === htmlspecialchars(@$_POST["accountingType"])) { echo " selected"; } ?>>�s�x</option>
      <option value="1" <?php if ("1" === htmlspecialchars(@$_POST["accountingType"])) { echo " selected"; } ?>>�p��</option>
</select>
<br><br>

�^�M���@<br>
<select name="withCapture">
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>�^�M�̂�(�^�M������ɔ��㏈�����s���K�v������܂�)</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>�^�M����(�^�M�Ɠ����ɔ��㏈�����s���܂�)</option>
</select>
<br><br>

����ۋ��N����<br>
<input type="text" maxlength="8" size="9" name="mpFirstDate" value="<?php if (isset($_POST["mpFirstDate"])) { echo htmlspecialchars(@$_POST["mpFirstDate"]); } else{ echo $mpFirstDate; } ?>"><br>
<font size="2" color="red">���`��:YYYYMMDD</font>
<br><br>

�p���ۋ���(01-28)<br>
<input type="text" maxlength="2" size="3" name="mpDay" value="<?php if (isset($_POST["mpDay"])) { echo htmlspecialchars(@$_POST["mpDay"]); } else{ echo $mpDay; } ?>">
<br><br>

���i�ԍ�<br>
<input type="text" maxlength="18" size="20" name="itemId" value="<?php if (isset($_POST["itemId"])) { echo htmlspecialchars(@$_POST["itemId"]); } else{ echo $itemId; } ?>">
<br><br>

OpenID<br>
<input type="text"  maxlength="256" size="27" name="openId" value="<?php if (isset($_POST["openId"])) { echo htmlspecialchars(@$_POST["openId"]); } else{ echo $openId; } ?>">
<br><br>
<!-- �e��URL��hidden�� -->
<input type="hidden" name="successUrl" value="<?php echo $successUrl; ?>">
<input type="hidden" name="cancelUrl"  value="<?php echo $cancelUrl;  ?>">
<input type="hidden" name="errorUrl"   value="<?php echo $errorUrl;   ?>">
<input type="hidden" name="pushUrl"    value="<?php if ($dummyReq === "1") { echo $pushUrl; } ?>">


<br/><!-- space -->
================<br/>

<input type="submit" value="�w��">
</form>

<img alt='VeriTrans���S' src='../../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
