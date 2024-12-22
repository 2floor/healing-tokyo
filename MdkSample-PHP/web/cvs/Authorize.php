<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// コンビニ決済入力画面のサンプル
// -------------------------------------------------------------------------

  $order_id = "dummy".time();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - コンビニ決済 サンプル画面</title>
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
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G コンビニ決済の取引サンプル画面です。<br/>
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
  <td class="ptitle"><div class="lhtitle">コンビニ決済：決済請求</div></td>
  <td class="pcxts">
  <img src="../WEB-IMG/CVS_CirclekSunkus.jpg"/>
  <img src="../WEB-IMG/CVS_Dailyyamazaki.jpg"/>
  <img src="../WEB-IMG/CVS_Famima.jpg"/>
  <img src="../WEB-IMG/CVS_Lawson.jpg"/>
  <img src="../WEB-IMG/CVS_Ministop.jpg"/>
  <img src="../WEB-IMG/CVS_Seicomart.jpg"/>
  <img src="../WEB-IMG/CVS_SevenEleven.jpg"/>
  </td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0">
<form name="FORM_CVS" method="post" action="AuthorizeExec.php">
<tr>
  <td class="ititletop">取引ID</td>
  <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input type="button" value="取引ID更新" onclick="reDrawing(FORM_CVS, 'Authorize.php');"><input type="hidden" name="orderId" value="<?php echo $order_id ?>"></td>
</tr>
<tr>
  <td class="ititle">決済サービスオプション</td>
  <td class="ivalue">
    <select name="serviceOptionType">
      <option value="sej"<?php if ("sej" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>セブンイレブン</option>
      <option value="econ"<?php if ("econ" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>ローソン､ファミリーマートetc</option>
      <option value="other"<?php if ("other" == htmlspecialchars(@$_POST["serviceOptionType"])) { echo " selected"; } ?>>サークルKサンクス、デイリーヤマザキetc</option>
    </select>
  </td>
</tr>
<tr>
  <td class="ititle">決済金額</td>
  <td class="ivalue"><input type="text" maxlength="6" size="7" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">姓</td>
  <td class="ivalue"><input type="text" maxlength="20" size="21" name="name1" value="<?php echo htmlspecialchars(@$_POST["name1"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">名</td>
  <td class="ivalue"><input type="text" maxlength="20" size="21" name="name2" value="<?php echo htmlspecialchars(@$_POST["name2"]) ?>"></td>
</tr>
<tr>
  <td class="ititle">電話番号</td>
  <td class="ivalue"><input type="text" maxlength="13" size="14" name="telNo" value="<?php echo htmlspecialchars(@$_POST["telNo"]) ?>">&nbsp;&nbsp;<font size="2" color="red">※"-"(ハイフン)区切りも可能</font></td>
</tr>
<tr>
  <td class="ititle">支払期限</td>
  <td class="ivalue"><input type="text" maxlength="10" size="11" name="payLimit" value="<?php echo htmlspecialchars(@$_POST["payLimit"]) ?>">&nbsp;&nbsp;<font size="2" color="red">※形式：YYYYMMDD or YYYY/MM/DD</font></td>
</tr>
<tr>
  <td class="ititle">支払期限時分</td>
  <td class="ivalue"><input type="text" maxlength="5" size="6" name="payLimitHhmm" value="<?php echo htmlspecialchars(@$_POST["payLimitHhmm"]) ?>">&nbsp;&nbsp;<font size="2" color="red">※形式：HH:mm or HHmm</font></td>
</tr>
<tr>
  <td class="ititle">プッシュURL</td>
  <td class="ivalue">
    <input type="text" maxlength="256" size="70" name="pushUrl" value="<?php echo htmlspecialchars(@$_POST["pushUrl"]) ?>"><br/>
    <span style="font-size: small; color: red;">※必要な場合は入力してください。</span>
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
