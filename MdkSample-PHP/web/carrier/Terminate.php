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
    $successUrl = array_key_exists('successUrl', $_POST) ? $_POST['successUrl'] : $env_info["Carrier"]["success.url"];
    $cancelUrl = array_key_exists('cancelUrl', $_POST) ? $_POST['cancelUrl'] : $env_info["Carrier"]["cancel.url"];
    $errorUrl = array_key_exists('errorUrl', $_POST) ? $_POST['errorUrl'] : $env_info["Carrier"]["error.url"];
    $pushUrl = array_key_exists('pushUrl', $_POST) ? $_POST['pushUrl'] : $env_info["Carrier"]["push.url"];
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
<title>VeriTrans 4G - キャリア決済継続課金終了サンプル画面</title>
<link href="../css/style.css?1286186298" media="all" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">

function setUrl() {
    var obj = document.FORM_CARRIER.elements;
    var force = obj.force.value;
    if (force == "false") {
        var index = obj.serviceOptionType.selectedIndex;
        if (index == 1 || index == 3) {
            obj.successUrl.value = "";
            obj.cancelUrl.value = "";
            obj.errorUrl.value = "";
        } else {
            if (obj.successUrl.value == "") {
                obj.successUrl.value = obj.hidSuccessUrl.value;
            }
            if (obj.cancelUrl.value == "") {
                obj.cancelUrl.value = obj.hidCancelUrl.value;
            }
            if (obj.errorUrl.value == "") {
                obj.errorUrl.value = obj.hidErrorUrl.value;
            }
        }
    }
}

// onLoadイベント
window.onload= function() {
  setUrl();
}
//-->

</script>
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G キャリア決済の継続課金終了取引サンプル画面です。<br/>
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
    <select name="serviceOptionType" onchange="setUrl();">
      <option value="docomo" <?php if ("docomo" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ドコモ</option>
      <option value="au" <?php if ("au" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>au</option>
      <option value="sb_matomete" <?php if ("sb_matomete" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ソフトバンクまとめて支払い（A）</option>
      <option value="sb_ktai" <?php if ("sb_ktai" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ソフトバンクまとめて支払い（B）</option>
      <option value="flets" <?php if ("flets" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>フレッツまとめて支払い</option>
    </select>
  </td>
</tr>
<tr>
  <td class="ititle">取引ID</td>
  <td class="ivalue"><input type="text" maxlength="100" size="30" name="orderId" value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>"></td>
</tr>
<tr id="terminalKind" style="display:">
  <td class="ititle">端末種別</td>
  <td class="ivalue">
    <select name="terminalKind">
      <option value="0">PC</option>
      <option value="1">スマートフォン</option>
      <option value="2">フィーチャーフォン</option>
    </select>
  </td>
</tr>
<tr id="success" style="display:">
  <td class="ititle">継続課金終了完了時URL</td>
  <td class="ivalue">
    <input type="text" maxlength="256" size="70" name="successUrl" value="<?php echo htmlSpecialChars($successUrl); ?>">
    <br/>
    <font size="2" color="red">※au・ソフトバンクまとめて支払い（B）は指定不可</font>
  </td>
</tr>

<tr id="cancel" style="display:">
  <td class="ititle">継続課金終了キャンセル時URL</td>
  <td class="ivalue">
    <input type="text" maxlength="256" size="70" name="cancelUrl" value="<?php echo htmlSpecialChars($cancelUrl); ?>">
    <br/>
    <font size="2" color="red">※au・ソフトバンクまとめて支払い（B）は指定不可</font>
  </td>
</tr>

<tr id="error" style="display:">
  <td class="ititle">継続課金終了エラー時URL</td>
  <td class="ivalue">
    <input type="text" maxlength="256" size="70" name="errorUrl" value="<?php echo htmlSpecialChars($errorUrl); ?>">
    <br/>
    <font size="2" color="red">※au・ソフトバンクまとめて支払い（B）は指定不可</font>
  </td>
</tr>
<?php if($dummyReq === "1") { ?>
<tr>
  <td class="ititle">プッシュURL</td>
  <td class="ivalue">
    <input type="text" maxlength="256" size="70" name="pushUrl" value="<?php echo htmlSpecialChars($pushUrl); ?>"><br/> 
    <font size="2" color="red">※ダミー決済の場合のみ指定可能</font>
  </td>
</tr>
<?php } ?>
<input type="hidden" name="force" value="false" />
<input type="hidden" name="hidSuccessUrl" value="<?php echo htmlSpecialChars($successUrl); ?>" />
<input type="hidden" name="hidCancelUrl" value="<?php echo htmlSpecialChars($cancelUrl); ?>" />
<input type="hidden" name="hidErrorUrl" value="<?php echo htmlSpecialChars($errorUrl); ?>" />
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
  <td colspan="2"><input type="submit" value="継続課金終了">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</form>
</table>

<br>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>
