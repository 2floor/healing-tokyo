<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// LINE Pay入力画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();

  $config_file = "../env4sample.ini";

  if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $base_url = $env_info["Common"]["base.url"];
    $successUrl = array_key_exists('successUrl', $_POST) ? $_POST['successUrl'] : $env_info["Linepay"]["success.url"];
    $cancelUrl = array_key_exists('cancelUrl', $_POST) ? $_POST['cancelUrl'] : $env_info["Linepay"]["cancel.url"];
    $errorUrl = array_key_exists('errorUrl', $_POST) ? $_POST['errorUrl'] : $env_info["Linepay"]["error.url"];
    $pushUrl = array_key_exists('pushUrl', $_POST) ? $_POST['pushUrl'] : $env_info["Linepay"]["push.url"];
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
<title>VeriTrans 4G - LINE Payサンプル画面</title>
<link href="../css/style.css?1286186298" media="all" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
function reDrawing(frm, action) {
    frm.action = action;
    frm.method = "POST";
    frm.submit();
}
function changePaymentConfirmType() {
    var obj = document.FORM_LINEPAY.elements;
    var index = obj.paymentConfirmType.selectedIndex;
    if (index == 1) {
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

// onLoadイベント
window.onload = function() {
   changePaymentConfirmType();
}
</script>
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G LINE Payの取引サンプル画面です。<br/>
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
    <div class="lhtitle">LINE Pay：決済請求</div>
  </td>
  <td>
    <img src="../WEB-IMG/linepay.png"/>
  </td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_LINEPAY" method="post" action="AuthorizeExec.php" accept-charset="UTF-8">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><input type="button" value="取引ID更新" onclick="reDrawing(FORM_LINEPAY, 'Authorize.php');"></td>
</tr>
<tr>
  <td class="ititle">金額</td>
  <td class="ivalue"><input type="text" maxlength="7" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
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
  <td class="ivalue"><input type="text" maxlength="4000" size="70" name="itemName" value="<?php echo htmlspecialchars(@$_POST["itemName"]) ?><?php echo htmlspecialchars(@$_GET["item_name"]) ?>"></td>
</tr>

<tr>
  <td class="ititle">商品画像URL</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="itemImageUrl" value="<?php echo htmlspecialchars(@$_POST["itemImageUrl"]) ?><?php echo htmlspecialchars(@$_GET["item_image_url"]) ?>"></td>
</tr>

<tr>
  <td class="ititle">使用ブラウザ判定</td>
  <td class="ivalue">
    <select name="checkUseBrowser">
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["checkUseBrowser"])) { echo " selected"; } ?>>LINE Pay側でブラウザ判定しない</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["checkUseBrowser"])) { echo " selected"; } ?>>LINE Pay側でブラウザ判定する</option>
    </select>
  </td>
</tr>

<tr>
  <td class="ititle">アプリ起動URLスキーム</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="appUrlScheme" value="<?php echo htmlspecialchars(@$_POST["appUrlScheme"]) ?><?php echo htmlspecialchars(@$_GET["app_url_scheme"]) ?>"></td>
</tr>

<tr>
  <td class="ititle">独自アプリ起動時のオプション指定</td>
  <td class="ivalue">
    <select name="useOriginalApp">
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["useOriginalApp"])) { echo " selected"; } ?>>オプションを使用しない</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["useOriginalApp"])) { echo " selected"; } ?>>URLエンコーディングを使用する</option>
    </select>
  </td>
</tr>

<tr>
  <td class="ititle">packageName</td>
  <td class="ivalue"><input type="text" maxlength="4000" size="70" name="packageName" value="<?php echo htmlspecialchars(@$_POST["packageName"]) ?><?php echo htmlspecialchars(@$_GET["package_name"]) ?>"></td>
</tr>

<tr id="success" style="display:">
  <td class="ititle">決済完了時URL</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="successUrl" value="<?php echo htmlspecialchars($successUrl); ?>"></td>
</tr>

<tr id="cancel" style="display:">
  <td class="ititle">決済キャンセル時URL</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="cancelUrl" value="<?php echo htmlspecialchars($cancelUrl); ?>"></td>
</tr>

<tr id="error" style="display:">
  <td class="ititle">決済エラー時URL</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="errorUrl" value="<?php echo htmlspecialchars($errorUrl); ?>"></td>
</tr>

<tr>
  <td class="ititle">決済確認方法</td>
  <td class="ivalue">
    <select name="paymentConfirmType" onChange="changePaymentConfirmType()">
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["paymentConfirmType"])) { echo " selected"; } ?>>ブラウザを介する通信</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["paymentConfirmType"])) { echo " selected"; } ?>>サーバ間通信</option>
    </select>
  </td>
</tr>

<tr>
  <td class="ititle">ワンタイムキー</td>
  <td class="ivalue"><input type="text" maxlength="12" size="20" name="oneTimeKey" value="<?php echo htmlspecialchars(@$_POST["oneTimeKey"]) ?><?php echo htmlspecialchars(@$_GET["oneTimeKey"]) ?>"></td>
</tr>

<?php if($dummyReq === "1") { ?>
<tr>
  <td class="ititle">プッシュURL</td>
  <td class="ivalue">
    <input type="text" maxlength="256" size="70" name="pushUrl" value="<?php echo htmlspecialchars($pushUrl); ?>"><br/>
    <font size="2" color="red">※ダミー決済の場合のみ指定可能</font>
  </td>
</tr>
<?php } ?>

<input type="hidden" name="hidSuccessUrl" value="<?php echo htmlspecialchars($successUrl); ?>" />
<input type="hidden" name="hidCancelUrl" value="<?php echo htmlspecialchars($cancelUrl); ?>" />
<input type="hidden" name="hidErrorUrl" value="<?php echo htmlspecialchars($errorUrl); ?>" />

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
