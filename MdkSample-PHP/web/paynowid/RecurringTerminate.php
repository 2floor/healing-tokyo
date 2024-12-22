<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 継続課金停止(カード払い)サンプル画面
// -------------------------------------------------------------------------

$checked = "";
if (isset($_POST["finalCharge"])) {
    $checked = htmlspecialchars($_POST["finalCharge"]);
}
if (!empty($checked)) {
    $checked = "checked";
}
$groupIdList = array();
if (isset($_SESSION["groupIdList"])) {
    $groupIdList = $_SESSION["groupIdList"];
}
if (!isset($_SESSION) && isset($groupIdList)) {
    session_start();
}

$idSelected = "";
if (isset($_SESSION["selected"])) {
    $idSelected = $_SESSION["selected"];
}
$account_id = "";
if (isset($_POST["accountId"])) {
    $account_id = htmlspecialchars($_POST["accountId"]);
}
$end_date = "";
if (isset($_POST["endDate"])) {
    $end_date = htmlspecialchars($_POST["endDate"]);
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="ja" />
    <title>VeriTrans 4G - 継続課金停止(カード払い)サンプル画面</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        function submitForm(frm, action, execMode) {
            frm.execMode.value = execMode;
            frm.action = action;
            frm.method = "POST";
            frm.submit();
        }
    </script>
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
<hr />
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G 継続課金停止(カード払い)のサンプル画面です。<br />
        お客様ECサイトとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
        また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br />
    </span>
</div>
<?php
    if (!empty($warning)) {
        echo $warning."<br><br>";
    }
?>
<div class="lhtitle">継続課金停止(カード払い)</div>
<form name="FORM_PAY_NOW_ID" method="post" action="RecurringTerminateExec.php">
    <input type="hidden" name="execMode" value="">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="thl" colspan="2">会員情報</td>
        </tr>
        <tr>
            <td class="ititletop">会員ID</td>
            <td class="ivaluetop">
                <input type="text" size="50" name="accountId" value="<?php echo htmlspecialchars($account_id) ?>" maxLength="100">
                <input type="button" value="継続課金情報取得" onclick="submitForm(FORM_PAY_NOW_ID, 'RecurringTerminateExec.php', '1');" style ="WIDTH: 120px">
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td class="thl" colspan="2">継続課金情報</td>
        </tr>
        <tr>
            <td class="ititletop">課金グループID</td>
            <td class="ivalue">
                <select name="groupId">
<?php
    for ($i = 0; $i < count($groupIdList); $i++) {
        $selected = "";
        if (key($groupIdList[$i]) == $idSelected) {
            $selected = "selected";
        }
?>
                <option value="<?php echo key($groupIdList[$i]) ?>"<?php echo $selected ?> ><?php echo key($groupIdList[$i]). " : ". $groupIdList[$i][key($groupIdList[$i])] ?></option>
<?php
    }
?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="ititle">課金終了日</td>
            <td class="ivalue">
                <input type="text" size="8" name="endDate" value="<?php echo htmlspecialchars($end_date) ?>" maxLength="8" />
                &nbsp;&nbsp;<span style="font-size: small; color:red;">※形式:YYYYMMDD</span>
                <input type="checkbox" name="finalCharge" value="1" <?php echo $checked ?> /><span style="font-size: small;">次回課金で自動的に終了する。</span>
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td colspan="2"><input type="button" value="実行" onclick="submitForm(FORM_PAY_NOW_ID, 'RecurringTerminateExec.php', '2');">
            &nbsp;&nbsp;<span style="font-size: small; color:red;">※２回以上クリックしないでください。</span></td>
        </tr>
    </table>
</form>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>
<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>