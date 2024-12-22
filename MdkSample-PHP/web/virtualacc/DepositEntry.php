<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 銀行振込の入金請求画面のサンプル
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
<title>VeriTrans 4G - 銀行振込入金請求サンプル画面</title>
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
本画面はVeriTrans4G 銀行振込決済の入金取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>

<div class="lhtitle">銀行振込決済：入金請求</div>

<form name="FORM_VIRTUALACC" method="post" action="DepositEntryExec.php" accept-charset="UTF-8">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><input type="text" maxlength="100" size="30" name="orderId" value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?><?php echo htmlspecialchars(@$_GET["order_id"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">金額</td>
  <td class="ivalue"><input type="text" maxlength="12" size="13" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">振込人名</td>
  <td class="ivalue"><input type="text" maxlength="69" size="70" name="transferName" value="<?php echo htmlspecialchars(@$_POST["transferName"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">入金日</td>
  <td class="ivalue"><input type="text" maxlength="8" size="9" name="depositDate" value="<?php echo htmlspecialchars(@$_POST["depositDate"]) ?>">
    &nbsp;&nbsp;<font size="2" color="red">※形式:YYYYMMDD</font>
  </td>
</tr>

<tr>
  <td class="ititle">消込フラグ</td>
  <td class="ivalue">
    <select name="withReconcile">
      <option value=""></option>
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["withReconcile"])) { echo " selected"; } ?>>消込しない</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["withReconcile"])) { echo " selected"; } ?>>消込(強制)</option>
      <option value="2"<?php if ("2" == htmlspecialchars(@$_POST["withReconcile"])) { echo " selected"; } ?>>消込(自動)</option>
    </select>
  </td>
</tr>

<tr>
  <td class="ititle">登録方法</td>
  <td class="ivalue">
    <select name="registrationMethod">
      <option value=""></option>
      <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["registrationMethod"])) { echo " selected"; } ?>>手動</option>
      <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["registrationMethod"])) { echo " selected"; } ?>>自動</option>
    </select>
  </td>
</tr>


<tr>
  <td colspan="2">&nbsp;</td>
</tr>

<tr>
  <td colspan="2"><input type="submit" value="入金">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
</tr>
</table>
</form>

<a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>
