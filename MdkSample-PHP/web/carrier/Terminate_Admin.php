<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済継続課金終了画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();

  $config_file = "../env4sample.ini";

  if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $base_url = $env_info["Common"]["base.url"];
    $pushUrl  = $env_info["Carrier"]["push.url"];
  }

  if (!defined('MDK_DIR')) {
    define('MDK_DIR', '../tgMdk/');
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - キャリア決済サンプル画面</title>
<link href="../css/style.css?1286186298" media="all" rel="stylesheet" type="text/css">
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G キャリア決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>

<div class="lhtitle">キャリア決済：継続課金終了請求</div>
<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_CARRIER" method="post" action="TerminateExec.php">
<tr>
  <td class="ititletop">キャリア選択</td>
  <td class="ivaluetop">
    <select name="serviceOptionType" onchange="changeServiceOptionType();">
      <option value="docomo" <?php if ("docomo" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ドコモ</option>
      <option value="au" <?php if ("au" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>au</option>
      <option value="sb_matomete" <?php if ("sb_matomete" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ソフトバンクまとめて支払い（A）</option>
      <option value="sb_ktai" <?php if ("sb_ktai" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ソフトバンクまとめて支払い（B）</option>
    </select>
  </td>
</tr>
<tr>
  <td class="ititle">取引ID</td>
  <td class="ivalue"><input type="text" maxlength="100" size="30" name="orderId" value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>"></td>
</tr>
<input type="hidden" name="force" value="true" />
<input type="hidden" name="Admin" value="true" />

<tr><td colspan="2">&nbsp;</td></tr>
<tr>
  <td colspan="2"><input type="submit" value="継続課金終了">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</form>
</table>

<br>
<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>
