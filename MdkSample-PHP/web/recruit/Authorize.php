<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// リクルートかんたん支払い入力画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();

  $config_file = "../env4sample.ini";

  if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $base_url = $env_info["Common"]["base.url"];
    $successUrl = $env_info["Recruit"]["success.url"];
    $errorUrl = $env_info["Recruit"]["error.url"];
    $pushUrl = $env_info["Recruit"]["push.url"];
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
<title>VeriTrans 4G - リクルートかんたん支払いサンプル画面</title>
<link href="../css/style.css?1286186298" media="all" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
function reDrawing(frm, action) {
    frm.action = action;
    frm.method = "POST";
    frm.submit();
}
</script>
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G リクルートかんたん支払いの取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>

<table>
<tr>
  <td>
    <div class="lhtitle">リクルートかんたん支払い：決済請求</div>
  </td>
  <td>
    <img width="auto" height="54" src="../WEB-IMG/recruit.png"/>
  </td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_RECRUIT" method="post" action="AuthorizeExec.php" accept-charset="UTF-8">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><input type="button" value="取引ID更新" onclick="reDrawing(FORM_RECRUIT, 'Authorize.php');"></td>
</tr>
<tr>
  <td class="ititle">金額</td>
  <td class="ivalue"><input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
</tr>

<tr>
  <td class="ititle">与信方法</td>
  <td class="ivalue">
    <select name="withCapture">
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信のみ(与信成功後に売上処理を行う必要があります)</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信売上(与信と同時に売上処理も行います)</option>
    </select>
  </td>
</tr>

<tr>
  <td class="ititle">商品番号</td>
  <td class="ivalue"><input type="text" maxlength="64" size="20" name="itemId" value="<?php echo htmlspecialchars(@$_POST["itemId"]) ?>"></td>
</tr>

<tr>
  <td class="ititle">商品名</td>
  <td class="ivalue"><input type="text" maxlength="255" size="40" name="itemName" value="<?php echo htmlspecialchars(@$_POST["itemName"]) ?><?php echo htmlspecialchars(@$_GET["item_name"]) ?>"></td>
</tr>

<tr id="success" style="display:">
  <td class="ititle">決済完了時URL</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="successUrl" value="<?php if (isset($_POST["successUrl"])) { echo htmlspecialchars(@$_POST["successUrl"]); } else{ echo $successUrl; } ?>"></td>
</tr>

<tr id="error" style="display:">
  <td class="ititle">決済エラー時URL</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="errorUrl" value="<?php if (isset($_POST["errorUrl"])) { echo htmlspecialchars(@$_POST["errorUrl"]); } else{ echo $errorUrl; } ?>"></td>
</tr>
<?php if($dummyReq === "1") { ?>
<tr>
  <td class="ititle">プッシュURL</td>
  <td class="ivalue">
    <input type="text" maxlength="256" size="70" name="pushUrl" value="<?php if (isset($_POST["pushUrl"])) { echo htmlspecialchars(@$_POST["pushUrl"]); } else{ echo $pushUrl; } ?>"><br/>
    <font size="2" color="red">※ダミー決済の場合のみ指定可能</font>
  </td>
</tr>
<?php } ?>

<tr>
  <td colspan="2">&nbsp;</td>
</tr>

<tr>
  <td colspan="2"><input type="submit" value="購入">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</form>
</table>

<br>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>
