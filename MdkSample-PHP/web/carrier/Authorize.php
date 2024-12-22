<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// キャリア決済入力画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".ceil(microtime(true)*1000);

  $config_file = "../env4sample.ini";

  if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $base_url = $env_info["Common"]["base.url"];
    $successUrl = $env_info["Carrier"]["success.url"];
    $cancelUrl = $env_info["Carrier"]["cancel.url"];
    $errorUrl = $env_info["Carrier"]["error.url"];
    $pushUrl = $env_info["Carrier"]["push.url"];
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

  $mpFirstDate = array_key_exists('mpFirstDate', $_POST) ? $_POST['mpFirstDate'] : "";
  $mpDay = array_key_exists('mpDay', $_POST) ? $_POST['mpDay'] : "";
  $itemId = array_key_exists('itemId', $_POST) ? $_POST['itemId'] : "";
  $itemInfo = array_key_exists('itemInfo', $_POST) ? $_POST['itemInfo'] : "";
  $openId = array_key_exists('openId', $_POST) ? $_POST['openId'] : "";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - キャリア決済サンプル画面</title>
<link href="../css/style.css?1286186298" media="all" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
<!--
function reDrawing(frm, action) {
    frm.action = action;
    frm.method = "POST";
    frm.submit();
}
// -->
</script>
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
<table>
<tr>
  <td>
    <div class="lhtitle">キャリア決済：決済請求</div>
  </td>
  <td>
    <img src="../WEB-IMG/Carrier_Docomo.jpg" height=45 width=120/>
    <img src="../WEB-IMG/Carrier_Au.jpg" height=45 width=150/>
    <img src="../WEB-IMG/Carrier_Softbank.jpg" height=45 width=160/>
    <img src="../WEB-IMG/Carrier_Flets.jpg" height=45 width=73/>
  </td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_CARRIER" method="post" action="AuthorizeExec.php">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop">
    <span><?php echo $order_id ?></span>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><input type="button" value="取引ID更新" onclick="reDrawing(FORM_CARRIER, 'Authorize.php');">
  </td>
</tr>
<tr>
  <td class="ititle">キャリア選択</td>
  <td class="ivalue">
    <select name="serviceOptionType">
      <option value="docomo" <?php if ("docomo" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ドコモ</option>
      <option value="au" <?php if ("au" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>au</option>
      <option value="sb_ktai" <?php if ("sb_ktai" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?> >ソフトバンクまとめて支払い（B）</option>
      <option value="sb_matomete" <?php if ("sb_matomete" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ソフトバンクまとめて支払い（A）</option>
      <option value="s_bikkuri" <?php if ("s_bikkuri" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>S!まとめて支払い</option>
      <option value="flets" <?php if ("flets" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>フレッツまとめて支払い</option>
    </select><br/>
    <font size="2" color="red">※ソフトバンクまとめて支払い（B）：旧ソフトバンクケータイ支払い
      <br/>※ソフトバンクまとめて支払い（A）：旧ソフトバンクまとめて支払い
    </font>
  </td>
</tr>
<tr>
  <td class="ititle">金額</td>
  <td class="ivalue"><input type="text" maxlength="9" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">端末種別</td>
  <td class="ivalue">
    <select name="terminalKind">
      <option value="0" <?php if ("0" === htmlspecialchars(@$_POST["terminalKind"])) { echo " selected"; } ?> >PC</option>
      <option value="1" <?php if ("1" === htmlspecialchars(@$_POST["terminalKind"])) { echo " selected"; } ?> >スマートフォン</option>
      <option value="2" <?php if ("2" === htmlspecialchars(@$_POST["terminalKind"])) { echo " selected"; } ?> >フィーチャーフォン</option>
    </select><br/>
    <font size="2" color="red">※ドコモ：PC不可<br/>※ソフトバンクまとめて支払い（B）：フィーチャーフォン不可
      <br/>※ソフトバンクまとめて支払い（A）：フィーチャーフォン不可<br/>※S!まとめて支払い：フィーチャーフォンのみ可
      <br/>※フレッツまとめて支払い：フィーチャーフォン不可
    </font>
  </td>
</tr>
<tr>
  <td class="ititle">商品タイプ</td>
  <td class="ivalue">
    <select name="itemType">
      <option value="0" <?php if ("0" === htmlspecialchars(@$_POST["itemType"])) { echo " selected"; } ?> >デジタルコンテンツ</option>
      <option value="1" <?php if ("1" === htmlspecialchars(@$_POST["itemType"])) { echo " selected"; } ?> >物販</option>
      <option value="2" <?php if ("2" === htmlspecialchars(@$_POST["itemType"])) { echo " selected"; } ?> >役務</option>
    </select><br/>
    <font size="2" color="red">※ソフトバンクまとめて支払い（A）：デジタルコンテンツのみ可
    <br/>※S!まとめて支払い：役務不可
    </font>
  </td>
</tr>

<tr>
  <td class="ititle">都度継続区分</td>
  <td class="ivalue">
    <select name="accountingType">
      <option value="0" <?php if ("0" === htmlspecialchars(@$_POST["accountingType"])) { echo " selected"; } ?>>都度</option>
      <option value="1" <?php if ("1" === htmlspecialchars(@$_POST["accountingType"])) { echo " selected"; } ?>>継続</option>
    </select><br/>
    <font size="2" color="red">※継続が可能なのはドコモ・au・ソフトバンクまとめて支払い（A）・ソフトバンクまとめて支払い（B）・フレッツまとめて支払い</font>
  </td>
</tr>
<tr>
  <td class="ititle">与信方法</td>
  <td class="ivalue">
    <select name="withCapture">
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信のみ(与信成功後に売上処理を行う必要があります)</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信売上(与信と同時に売上処理も行います)</option>
    </select><br/>
    <font size="2" color="red">※ソフトバンクまとめて支払い（A）は「与信売上」のみ可能</font>
  </td>
</tr>

<tr>
  <td class="ititle">本人認証(３Ｄセキュア)</td>
  <td class="ivalue">
    <select name="d3Flag">
      <option value="0" <?php if ("0" === htmlspecialchars(@$_POST["d3Flag"])) { echo " selected"; } ?>>無し</option>
      <option value="1" <?php if ("1" === htmlspecialchars(@$_POST["d3Flag"])) { echo " selected"; } ?>>バイパス</option>
      <option value="2" <?php if ("2" === htmlspecialchars(@$_POST["d3Flag"])) { echo " selected"; } ?>>有り</option>
    </select>
    <font size="2" color="red">※ソフトバンクまとめて支払い（B）のみのパラメータ</font>
  </td>
</tr>

<tr>
  <td class="ititle">初回課金年月日</td>
  <td class="ivalue"><input type="text" maxlength="8" size="9" name="mpFirstDate" value="<?php if (isset($_POST["mpFirstDate"])) { echo htmlspecialchars(@$_POST["mpFirstDate"]); } else{ echo $mpFirstDate; } ?>"><br/>
  <font size="2" color="red">※継続課金でドコモ・au・ソフトバンクまとめて支払い（B）・フレッツまとめて支払いは指定可能(形式：YYYYMMDD)<br/>
                             ※フレッツまとめて支払いの場合、DD部分は&quot;25&quot;以下しか指定できません。</font>
  </td>
</tr>

<tr>
  <td class="ititle">継続課金日(01-28)</td>
  <td class="ivalue">
    <input type="text" maxlength="2" size="3" name="mpDay" value="<?php if (isset($_POST["mpDay"])) { echo htmlspecialchars(@$_POST["mpDay"]); } else{ echo $mpDay; } ?>"><br/>
    <font size="2" color="red">※継続課金でドコモ・au・ソフトバンクまとめて支払い（B）・フレッツまとめて支払いは指定可能<br/>
         ※月末日を指定する場合は&quot;99&quot;を指定してください。<br/>
         ※一桁の場合は数値の前に&quot;0&quot;をつけてください。&nbsp;&nbsp;例：01<br/>
         ※フレッツまとめて支払いの場合、&quot;25&quot;以下しか指定できません。</font>
  </td>
</tr>

<tr>
  <td class="ititle">商品番号</td>
  <td class="ivalue"><input type="text" maxlength="18" size="20" name="itemId" value="<?php if (isset($_POST["itemId"])) { echo htmlspecialchars(@$_POST["itemId"]); } else{ echo $itemId; } ?>"><br/>
    <font size="2" color="red">
           ※au：15バイト以下の任意の値(継続課金の場合は提供商品ごとに変更する必要あり)<br/>
           ※ソフトバンクまとめて支払い（A）：継続の場合はソフトバンクより払い出されたサービス識別子(18バイト以下)<br/>
           ※フレッツまとめて支払い：8バイト以下の数字<br/>
           ※上記以外：15バイト以下の任意の値</font>
  </td>
</tr>

<tr>
  <td class="ititle">商品情報</td>
  <td class="ivalue"><input type="text" maxlength="24" size="48" name="itemInfo" value="<?php if (isset($_POST["itemInfo"])) { echo htmlspecialchars(@$_POST["itemInfo"]); } else{ echo $itemInfo; } ?>"><br/>
    <font size="2" color="red">※ドコモ・au・ソフトバンクまとめて支払い（A）・フレッツまとめて支払いで指定可能<br/>
             ※ソフトバンクまとめて支払い（B）は直接契約の場合のみ指定可能<br/>
             ※au：都度課金の場合は全角24文字以内、継続課金の場合は全角15文字以内<br/>
             ※au以外：全角20文字以内</font>
  </td>
</tr>

<tr id="success" style="display:">
  <td class="ititle">決済完了時URL</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="successUrl" value="<?php if (isset($_POST["successUrl"])) { echo htmlspecialchars(@$_POST["successUrl"]); } else{ echo $successUrl; } ?>"></td>
</tr>

<tr id="cancel" style="display:">
  <td class="ititle">決済キャンセル時URL</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="cancelUrl" value="<?php if (isset($_POST["cancelUrl"])) { echo htmlspecialchars(@$_POST["cancelUrl"]); } else{ echo $cancelUrl; } ?>"></td>
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
  <td class="ititle">OpenID</td>
  <td class="ivalue"><input type="text" maxlength="256" size="70" name="openId" value="<?php if (isset($_POST["openId"])) { echo htmlspecialchars(@$_POST["openId"]); } else{ echo $openId; } ?>"><br/>
    <font size="2" color="red">※ドコモ・auは指定可能</font>
  </td>
</tr>
<tr>
  <td class="ititle">フレッツエリア</td>
  <td class="ivalue">
    <select name="fletsArea">
      <option value="0" <?php if ("0" === htmlspecialchars(@$_POST["fletsArea"])) { echo " selected"; } ?>>東日本</option>
      <option value="1" <?php if ("1" === htmlspecialchars(@$_POST["fletsArea"])) { echo " selected"; } ?>>西日本</option>
    </select>
    <font size="2" color="red">※フレッツまとめて支払いのみのパラメータ</font>
  </td>
</tr>
<tr>
  <td class="ititle">auIDログインフラグ</td>
  <td class="ivalue">
    <select name="loginAuId">
      <option value="0" <?php if ("0" === htmlspecialchars(@$_POST["loginAuId"])) { echo " selected"; } ?>>ID連携</option>
      <option value="1" <?php if ("1" === htmlspecialchars(@$_POST["loginAuId"])) { echo " selected"; } ?>>auIDログイン</option>
    </select>
    <font size="2" color="red">※auのみのパラメータ</font>
  </td>
</tr>


<tr><td colspan="2">&nbsp;</td></tr>
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
