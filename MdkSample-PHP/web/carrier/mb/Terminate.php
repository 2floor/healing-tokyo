<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済継続課金終了画面のサンプル：モバイル
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
<title>VeriTrans 4G - キャリア決済継続課金終了サンプル画面</title>
</head>
<body>

<form name="FORM_CARRIER" method="post" action="./TerminateExec.php">
<img alt='Paymentロゴ' src='../../WEB-IMG/VeriTrans_Payment.png'>
<br><br><font size="2"> 携帯用の継続課金終了取引サンプル画面です。</font><br>

<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
<br>
キャリア決済：継続課金終了請求<br>
<br>
=== 決済内容 ===<br>
<br>
<!-- フィーチャーフォン向けには3者間のみ -->
<input type="hidden" name="force" value="false" />
<!-- フィーチャーフォンなので、端末種別はガラケー -->
<input type="hidden" name="terminalKind" value="2" />

キャリア選択<br>
<select name="serviceOptionType">
      <option value="docomo" <?php if ("docomo" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ドコモ</option>
      <option value="au" <?php if ("au" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>au</option>
</select>
<br><br>

取引ID<br>
<input type="text" maxlength="100" size="30" name="orderId" value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>">
<br><br>

<!-- 各種URLはhiddenで -->
<input type="hidden" name="successUrl" value="<?php echo $successUrl; ?>">
<input type="hidden" name="cancelUrl"  value="<?php echo $cancelUrl;  ?>">
<input type="hidden" name="errorUrl"   value="<?php echo $errorUrl;   ?>">
<input type="hidden" name="pushUrl"    value="<?php if ($dummyReq === "1") { echo $pushUrl; } ?>">
<!-- submit button -->
<input type="submit" value="継続課金終了">
</form>

<img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'>
<br>Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
