<?php
# Copyright © VeriTrans Inc. All right reserved.
// -------------------------------------------------------------------------
// VeriTrans 4G - Alipay決済与信サンプル画面
// -------------------------------------------------------------------------

$order_id = "dummy".time();
$price = array_key_exists('amount', $_POST) ? $_POST['amount'] : "10";
$commodityName = array_key_exists('commodityName', $_POST) ? $_POST['commodityName'] : "新製品";
$commodityDescription = array_key_exists('commodityDescription', $_POST) ? $_POST['commodityDescription'] : "新製品詳細";
$currency = array_key_exists('currency', $_POST) ? $_POST['currency'] : "JPY";
$payType = array_key_exists('payType', $_POST) ? $_POST['payType'] : "0";
$identityCode = array_key_exists('identityCode', $_POST) ? $_POST['identityCode'] : "";
$commodityId = array_key_exists('commodityId', $_POST) ? $_POST['commodityId'] : "";
$checked = "checked='checked'";
if ($currency === "CNY") {
    $currency_cny = $checked;
    $currency_jpy = "";
} else {
    $currency_jpy = $checked;
    $currency_cny = "";
}
if ($payType === "1") {
    $payType_online = "";
    $payType_barcode = $checked;
    $payType_scan_code = "";
} else if ($payType === "2") {
    $payType_online = "";
    $payType_barcode = "";
    $payType_scan_code = $checked;
} else {
    $payType_online = $checked;
    $payType_barcode = "";
    $payType_scan_code = "";
}
$config_file = "../env4sample.ini";

if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $successUrl = array_key_exists('successUrl', $_POST) ? $_POST['successUrl'] : $env_info["Alipay"]["success.url"];
    $errorUrl = array_key_exists('errorUrl', $_POST) ? $_POST['errorUrl'] : $env_info["Alipay"]["error.url"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - Alipay決済与信サンプル画面</title>
<link href="../css/style.css?1286186298" media="all" rel="stylesheet", type="text/css">
<script type="text/javascript">

function reDrawing(frm, action) {
    frm.action = action;
    frm.method = "POST";
    frm.submit();
}
function changePayType() {
    var rdo = document.FORM_ALIPAY.payType;
    if (rdo != null) {
        var obj = document.FORM_ALIPAY.elements;
        var pulldown_option = obj.responseType.getElementsByTagName('option');
        for (i = 0; i < rdo.length; i++) {
            if (rdo[i].checked) {
                if (rdo[i].value == "1") {
                    obj.commodityDescription.value = "";
                    obj.commodityId.value = "";
                    obj.successUrl.value = "";
                    obj.errorUrl.value = "";
                } else if (rdo[i].value == "2") {
                    obj.identityCode.value = "";
                    if (obj.commodityId.value == "") {
                        obj.commodityId.value = obj.hidCommodityId.value;
                    }
                    if (obj.commodityDescription.value == "") {
                        obj.commodityDescription.value = obj.hidCommodityDescription.value;
                    }
                    obj.successUrl.value = "";
                    obj.errorUrl.value = "";
                    pulldown_option[0].selected = true;
                } else {
                    obj.identityCode.value = "";
                    if (obj.commodityDescription.value == "") {
                        obj.commodityDescription.value = obj.hidCommodityDescription.value;
                    }
                    obj.commodityId.value = "";
                    if (obj.successUrl.value == "") {
                        obj.successUrl.value = obj.hidSuccessUrl.value;
                    }
                    if (obj.errorUrl.value == "") {
                        obj.errorUrl.value = obj.hidErrorUrl.value;
                    }
                    pulldown_option[0].selected = true;
                }
            }
        }
    }
}

// onLoadイベント
window.onload = function() {
    changePayType();
}
</script>
</head>
<body>
    <img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
    <hr />
    <div class="system-message">
        <font size="2"> 本画面はVeriTrans4G Alipay決済の取引サンプル画面です。<br />
            お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
            また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br />
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
                <div class="lhtitle">Alipay決済：決済請求</div>
            </td>
            <td><img src='../WEB-IMG/alipay.png' />
        </tr>
    </table>
    <form name="FORM_ALIPAY" method="post" action="AuthorizeExec.php">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td class="ititletop">取引ID</td>
                <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;
                    <input type="hidden" name="orderId" value="<?php echo $order_id ?>">
                    <input type="button" value="取引ID更新" onclick="reDrawing(FORM_ALIPAY, 'Authorize.php');">
                </td>
            </tr>
            <tr>
                <td class="ititle">金額</td>
                <td class="ivalue" style="width:640px;"><input type="text" maxlength='7' size="12"
                    name="amount" value="<?php echo htmlSpecialChars($price)?>">
                    <input type="radio" name="currency" value="JPY" <?php echo $currency_jpy; ?>>JPY
                    <input type="radio" name="currency" value="CNY" <?php echo $currency_cny; ?>>CNY
                    <font size="2" color="red">※CNYの場合は、金額には100以上の値を指定する必要があります。</font>
                </td>
            </tr>
            <tr>
                <td class="ititle">決済種別</td>
                <td class="ivalue" style="width:640px;">
                    <input type="radio" name="payType" onClick="changePayType();" value="0" <?php echo $payType_online; ?>>オンライン決済
                    <input type="radio" name="payType" onClick="changePayType();" value="1" <?php echo $payType_barcode; ?>>バーコード決済(店舗スキャン型)
                    <input type="radio" name="payType" onClick="changePayType();" value="2" <?php echo $payType_scan_code; ?>>バーコード決済(消費者スキャン型)
                </td>
            </tr>
            <tr>
                <td class="ititle">ユーザ識別コード</td>
                <td class="ivalue"><input type="text" size="35" maxLength="32"
                    name="identityCode" value="<?php if (isset($_POST["identityCode"])) { echo htmlspecialchars(@$_POST["identityCode"]); } else{ echo $identityCode; } ?>">
                </td>
            </tr>
            <tr>
                <td class="ititle">商品名</td>
                <td class="ivalue"><input type="text" size="35" maxLength="100"
                    name="commodityName" value="<?php echo htmlSpecialChars($commodityName)?>">
                </td>
            </tr>
            <tr>
                <td class="ititle">商品詳細</td>
                <td class="ivalue">
                    <textarea name="commodityDescription" cols="75" rows="6" maxLength="200"><?php echo htmlSpecialChars($commodityDescription)?></textarea>
                </td>
            </tr>
            <tr>
                <td class="ititle">商品ID</td>
                <td class="ivalue"><input type="text" size="35" maxLength="64"
                    name="commodityId" value="<?php if (isset($_POST["commodityId"])) { echo htmlspecialchars(@$_POST["commodityId"]); } else{ echo $commodityId; } ?>">
                </td>
            </tr>
            <tr>
                <td class="ititle">決済完了時URL</td>
                <td class="ivalue"><input type="text" maxlength="256" size="70"
                    name="successUrl" value="<?php echo htmlSpecialChars($successUrl)?>">
                </td>
            </tr>
            <tr>
                <td class="ititle">決済エラー時URL</td>
                <td class="ivalue"><input type="text" maxlength="256" size="70"
                    name="errorUrl" value="<?php echo htmlSpecialChars($errorUrl)?>">
                </td>
            </tr>
            <tr>
                <td class="ititle">レスポンスタイプ</td>
                <td class="ivalue">
                    <select name="responseType">
                        <option value=""></option>
                        <option value="0" <?php if ("0" === htmlspecialchars(@$_POST["responseType"])) { echo " selected"; } ?>>取引確定時にレスポンスを返却</option>
                        <option value="1" <?php if ("1" === htmlspecialchars(@$_POST["responseType"])) { echo " selected"; } ?>>即時にレスポンスを返却</option>
                    </select>
                </td>
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr>
                <td colspan="2"><input type="submit" value="購入">&nbsp;&nbsp;<font
                    size="2" color="red">※２回以上クリックしないでください。</font></td>
            </tr>
        </table>
        <input type="hidden" name="hidCommodityId" value="<?php echo htmlSpecialChars($commodityId); ?>">
        <input type="hidden" name="hidCommodityDescription" value="<?php echo htmlSpecialChars($commodityDescription); ?>">
        <input type="hidden" name="hidSuccessUrl" value="<?php echo htmlSpecialChars($successUrl); ?>">
        <input type="hidden" name="hidErrorUrl" value="<?php echo htmlSpecialChars($errorUrl); ?>">
    </form>
    <a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;
    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy;
    VeriTrans Inc. All rights reserved

</body>
</html>
