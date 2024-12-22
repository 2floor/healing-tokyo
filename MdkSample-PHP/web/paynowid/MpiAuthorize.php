<?php

# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード決済-3D認証有り(PayNowIDカード情報利用)サンプル画面
// -------------------------------------------------------------------------
$order_id = "dummy".time();

$account_id = "";
if (isset($_POST["accountId"])) {
    $account_id = htmlspecialchars($_POST["accountId"]);
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="ja" />
    <title>VeriTrans 4G - カード決済-3D認証無し(PayNowIDカード情報利用)サンプル画面</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript">
        function reDrawing(frm, action) {
            frm.action = action;
            frm.method = "POST";
            frm.submit();
        }
    </script>
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr />
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G カード決済-3D認証有り(PayNowIDカード情報利用)のサンプル画面です。<br />
        お客様ECサイトとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
        また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br />
    </span>
</div>
<?php
    if (!empty($warning)) {
        echo $warning."<br><br>";
    }
?>
<div class="lhtitle">カード決済-3D認証有り(PayNowIDカード情報利用)</div>
<form name="FORM_PAY_NOW_ID" method="post" action="MpiAuthorizeSelect.php">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="thl" colspan="2">決済情報</td>
        </tr>
        <tr>
            <td class="ititle">会員ID</td>
            <td class="ivalue">
                <input type="text" size="50" name="accountId" value="<?php echo htmlspecialchars($account_id) ?>" maxLength="100">
            </td>
        </tr>
        <tr>
            <td class="ititle">取引ID</td>
            <td class="ivalue">
                <?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>">
                <input type="button" value="取引ID更新" onclick="reDrawing(FORM_PAY_NOW_ID, 'MpiAuthorize.php');">
            </td>
        </tr>
        <tr>
            <td class="ititle">金額</td>
            <td class="ivalue">
                <input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>">
            </td>
        </tr>
        <tr>
            <td class="ititle">決済種別</td>
            <td class="ivalue">
                <select name="paymentMode">
                    <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>1: 3D-Secure認証のみ(決済しない)</option>
                    <option value="2"<?php if ("2" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>2: 完全認証(3D-Secure認証が完全に成功した場合のみ決済する)</option>
                    <option value="3"<?php if ("3" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>3: 通常認証(カード会社リスク負担にて決済する)</option>
                    <option value="4"<?php if ("4" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>4: 通常認証(カード会社か加盟店リスク負担にて決済する)</option>
                </select><br/>
                <span style="font-size: small; color:red;">※この項目は消費者が選択せず、内部的に設定いただく項目です。</span>
            </td>
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
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="次へ">&nbsp;&nbsp;<span style="font-size: small; color:red;">※２回以上クリックしないでください。</span>
            </td>
        </tr>
    </table>
</form>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;
<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>