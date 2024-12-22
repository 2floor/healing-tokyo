<?php
# Copyright © VeriTrans Inc. All right reserved.
// -------------------------------------------------------------------------
// VeriTrans 4G - Alipay決済の確認画面のサンプル
// -------------------------------------------------------------------------

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - Alipay確認サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

    <img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
    <hr />
    <div class="system-message">
        <font size="2"> 本画面はVeriTrans4G Alipay決済の返金取引サンプル画面です。<br />
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
                <div class="lhtitle">Alipay決済：確認請求</div>
            </td>
            <td><img src='../WEB-IMG/alipay.png' />
            </td>
        </tr>

    </table>

    <form name="FORM_ALIPAY" method="post" action="ConfirmExec.php">
        <table border="0" cellpadding="0" cellspacing="0">

            <tr>
                <td class="ititletop">取引ID</td>
                <td class="ivaluetop"><input type="text" size="20" name="orderId"
                    value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>"></td>
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
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="確認">&nbsp;&nbsp;<font
                    size="2" color="red">※２回以上クリックしないでください。</font></td>
            </tr>
        </table>
    </form>

    <a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy;
    VeriTrans Inc. All rights reserved

</body>
</html>
