<?php
# Copyright(C) 2012 VeriTrans Inc., Ltd. All right reserved.
// -------------------------------------------------------------------------
//VeriTrans 4G - UPOP決済取消入力画面のサンプル
// -------------------------------------------------------------------------

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - UPOP取消サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

    <img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
    <hr />
    <div class="system-message">
        <font size="2"> 本画面はVeriTrans4G UPOP決済の取消取引サンプル画面です。<br />
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
                <div class="lhtitle">UPOP決済：取消請求</div>
            </td>
            <td><img src='../WEB-IMG/upop.gif' />
        
        </tr>

    </table>
    <form name="FORM_UPOP" method="post" action="CancelExec.php">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td class="ititletop">取引ID</td>
                <td class="ivaluetop"><input type="text" size="20" name="orderId"
                    value="<?php echo htmlspecialchars(@$_POST["orderId"]) ?>"></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="取消"></td>
            </tr>
        </table>
    </form>

    <a href="../AdminMenu.php">管理メニューへ戻る</a>&nbsp;&nbsp;

    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy;
    VeriTrans Inc. All rights reserved

</body>
</html>
