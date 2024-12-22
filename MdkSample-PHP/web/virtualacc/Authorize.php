<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 銀行振込の決済請求画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();

  $config_file = "../env4sample.ini";

  if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $base_url = $env_info["Common"]["base.url"];
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
<title>VeriTrans 4G - 銀行振込決済申込サンプル画面</title>
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
本画面はVeriTrans4G 銀行振込決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>

<div class="lhtitle">銀行振込決済：決済請求</div>

<form name="FORM_VIRTUALACC" method="post" action="AuthorizeExec.php" accept-charset="UTF-8">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><input type="button" value="取引ID更新" onclick="reDrawing(FORM_VIRTUALACC, 'Authorize.php');"></td>
</tr>
<tr>
  <td class="ititle">金額</td>
  <td class="ivalue"><input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">登録時振込人名</td>
  <td class="ivalue"><input type="text" maxlength="64" size="80" name="entryTransferName" value="<?php echo htmlspecialchars(@$_POST["entryTransferName"]) ?><?php echo htmlspecialchars(@$_GET["entry_transfer_name"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">登録時振込番号</td>
  <td class="ivalue"><input type="text" maxlength="5" size="10" name="entryTransferNumber" value="<?php echo htmlspecialchars(@$_POST["entryTransferNumber"]) ?><?php echo htmlspecialchars(@$_GET["entry_transfer_number"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">振込期限</td>
  <td class="ivalue"><input type="text" maxlength="8" size="10" name="transferExpiredDate" value="<?php echo htmlspecialchars(@$_POST["transferExpiredDate"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">口座管理方式</td>
  <td class="ivalue">
    <select name="accountManageType">
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["accountManageType"])) { echo " selected"; } ?>>実口座</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["accountManageType"])) { echo " selected"; } ?>>バーチャル口座</option>
    </select>
  </td>
</tr>
<tr>
  <td class="ititle">支店コード</td>
  <td class="ivalue"><input type="text" maxlength="3" size="10" name="branchCode" value="<?php echo htmlspecialchars(@$_POST["branchCode"]) ?>">
    <font size="2" color="red"><br/>
            ※口座管理方式が実口座の場合は利用不可項目となります。<br/>
            ※口座管理方式がバーチャル口座の場合は任意項目となります。<br/>
            ⇒未入力時は登録済の口座情報を自動で払い出します。
    </font>
  </td>
</tr>
<tr>
  <td class="ititle">口座番号</td>
  <td class="ivalue"><input type="text" maxlength="7" size="10" name="accountNumber" value="<?php echo htmlspecialchars(@$_POST["accountNumber"]) ?>">
    <font size="2" color="red"><br/>
            ※口座管理方式が実口座の場合は利用不可項目となります。<br/>
            ※口座管理方式がバーチャル口座の場合は任意項目となります。<br/>
            ⇒未入力時は登録済の口座情報を自動で払い出します。
    </font>
  </td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
</tr>

<tr>
  <td colspan="2"><input type="submit" value="購入">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</table>
</form>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>
