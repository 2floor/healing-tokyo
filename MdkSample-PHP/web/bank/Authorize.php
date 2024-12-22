<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 銀行決済入力画面のサンプル
// -------------------------------------------------------------------------

$order_id = "dummy".time();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 銀行決済 サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <script type="text/javascript">
        function reDrawing(frm, action) {
            frm.action = action;
            frm.method = "POST";
            frm.submit();
        }
    </script>
<img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"/><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 銀行決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<?php
  if (!empty($warning)) {
    echo $warning."<br>";
  }
?>
<div class="lhtitle">銀行決済：決済請求</div>
<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_BANK" method="post" action="AuthorizeExec.php">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;<input type="button" value="取引ID更新" onclick="reDrawing(FORM_BANK, 'Authorize.php');"><input type="hidden" name="orderId" value="<?php echo $order_id ?>"></td>
</tr>
<tr>
  <td class="ititle">決済サービスオプション</td>
  <td class="ivalue">
  <select name="serviceOptionType">
    <option value="atm"<?php if ("atm" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ATM決済</option>
    <option value="netbank-pc"<?php if ("netbank-pc" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ネットバンク決済 (PC)</option>
    <option value="netbank-docomo"<?php if ("netbank-docomo" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ネットバンク決済 (docomo)</option>
    <option value="netbank-softbank"<?php if ("netbank-softbank" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ネットバンク決済 (SoftBank)</option>
    <option value="netbank-au"<?php if ("netbank-au" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ネットバンク決済 (au)</option>
  </select>
  </td>
</tr>
  <tr>
    <td class="ititle">決済金額</td>
    <td class="ivalue"><input type="text" maxlength="10" size="11" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
  </tr>
  <tr>
    <td class="ititle">姓</td>
    <td class="ivalue"><input type="text" maxlength="20" size="21" name="name1" value="<?php echo htmlspecialchars(@$_POST["name1"]) ?>"></td>
  </tr>
  <tr>
    <td class="ititle">名&nbsp;&nbsp;<font size="1" color="red">※任意項目</font></td>
    <td class="ivalue"><input type="text" maxlength="20" size="21" name="name2" value="<?php echo htmlspecialchars(@$_POST["name2"]) ?>"></td>
  </tr>
  <tr>
    <td class="ititle">カナ（姓）</td>
    <td class="ivalue"><input type="text" maxlength="20" size="21" name="kana1" value="<?php echo htmlspecialchars(@$_POST["kana1"]) ?>"></td>
  </tr>
  <tr>
    <td class="ititle">カナ（名）&nbsp;&nbsp;<font size="1" color="red">※任意項目</font></td>
    <td class="ivalue"><input type="text" maxlength="20" size="21" name="kana2" value="<?php echo htmlspecialchars(@$_POST["kana2"]) ?>"></td>
  </tr>
  <tr>
    <td class="ititle">支払期限</td>
    <td class="ivalue"><input type="text" maxlength="8" size="9" name="payLimit" value="<?php echo htmlspecialchars(@$_POST["payLimit"]) ?>">&nbsp;&nbsp;<font size="2" color="red">※形式：YYYYMMDD</font></td>
  </tr>
  <tr>
    <td class="ititle">プッシュURL</td>
    <td class="ivalue">
      <input type="text" maxlength="256" size="70" name="pushUrl" value="<?php echo htmlspecialchars(@$_POST["pushUrl"]) ?>"><br/>
      <span style="font-size: small; color: red;">※必要な場合は入力してください。</span>
    </td>
  </tr>
  <tr><td colspan="2"><font size="2">※請求内容は、インフォメーションとしてATMなどに表示されます。</font></td></tr>
  <tr>
    <td class="ititletop">請求内容（漢字）</td>
    <td class="ivaluetop"><input type="text" maxlength="24" size="25" name="contents" value="<?php echo htmlspecialchars(@$_POST["contents"]) ?>"></td>
  </tr>
   <tr>
    <td class="ititle">請求内容（カナ）</td>
    <td class="ivalue"><input type="text" maxlength="48" size="60" name="contentsKana" value="<?php echo htmlspecialchars(@$_POST["contentsKana"]) ?>"></td>
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
