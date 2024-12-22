<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 会員退会処理サンプル画面
// -------------------------------------------------------------------------

$account_id = "";
if (isset($_POST["accountId"])) {
    $account_id = htmlspecialchars($_POST["accountId"]);
}
$delete_date = "";
if (isset($_POST["deleteDate"])) {
    $delete_date = htmlspecialchars($_POST["deleteDate"]);
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="ja" />
    <title>VeriTrans 4G - 会員退会処理サンプル画面</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr />
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G 会員退会処理のサンプル画面です。<br />
        お客様ECサイトとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
        また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br />
    </span>
</div>
<?php
    if (!empty($warning)) {
        echo $warning."<br><br>";
    }
?>
<div class="lhtitle">会員退会処理</div>
<form name="FORM_PAY_NOW_ID" method="post" action="./AccountWithdrawExec.php">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="thl" colspan="2">退会情報</td>
        </tr>
        <tr>
            <td class="ititle">会員ID</td>
            <td class="ivalue">
                <input type="text" size="50" name="accountId" value="<?php echo htmlspecialchars($account_id) ?>" maxLength="100">
            </td>
        </tr>
        <tr>
            <td class="ititle">退会年月日</td>
            <td class="ivalue">
                <input type="text" size="8" name="deleteDate" value="<?php echo htmlspecialchars($delete_date) ?>" maxLength="8">
                &nbsp;&nbsp;<span style="font-size: small; color:red;">※形式:YYYYMMDD</span>
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="実行">
                &nbsp;&nbsp;<span style="font-size: small; color:red;">※２回以上クリックしないでください。</span>
            </td>
        </tr>
    </table>
</form>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>
<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
