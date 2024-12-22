<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 継続課金管理(カード払い)サンプル画面
// -------------------------------------------------------------------------

$chargeMode_1 = "";
$chargeMode_2 = "";
// セッションからカード情報を取得するための準備
if (isset ($_SESSION["cardList"])) {
    $cardList = $_SESSION["cardList"];
}
$chargeMode = htmlspecialchars(@$_POST["chargeMode"]);
if (!isset($_SESSION) && isset($cardList)) {
    session_start();
}

if ("1" === $chargeMode) {
    $chargeMode_1 = "selected";
} else if ("2" === $chargeMode) {
    $chargeMode_2 = "selected";
}

// 設定ファイルの読み込み
$config_file = "../env4sample.ini";
$token_api_key = null;
$token_api_url = null;
if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $token_api_key = $env_info["TOKEN"]["token.api.key"];
    $token_api_url = $env_info["TOKEN"]["token.api.url"];
}
if (empty($token_api_url)) {
    $prop = @parse_ini_file(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "tgMdk" . DIRECTORY_SEPARATOR . "3GPSMDK.properties", true);
    $url = parse_url($prop["Connection"]["HOST_URL"]);
    $token_api_url = $url["scheme"] . "://" . $url["host"] . "/4gtoken";
}

$account_id = "";
if (isset($_POST["accountId"])) {
    $account_id = htmlspecialchars($_POST["accountId"]);
}
$group_id = "";
if (isset($_POST["groupId"])) {
    $group_id = htmlspecialchars($_POST["groupId"]);
}
$start_date = "";
if (isset($_POST["startDate"])) {
    $start_date = htmlspecialchars($_POST["startDate"]);
}
$end_date = "";
if (isset($_POST["endDate"])) {
    $end_date = htmlspecialchars($_POST["endDate"]);
}
$one_time_amount = "";
if (isset($_POST["oneTimeAmount"])) {
    $one_time_amount = htmlspecialchars($_POST["oneTimeAmount"]);
}
$recarring_amount = "";
if (isset($_POST["recarringAmount"])) {
    $recarring_amount = htmlspecialchars($_POST["recarringAmount"]);
}

?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VeriTrans 4G - 継続課金管理(カード払い)サンプル画面</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        function initializingVal() {
            document.getElementById('card_number').value = "";
            document.getElementById('cc-exp').value = "";
        }

        function submitForm(frm, action, execMode) {
            frm.execMode.value = execMode;
            frm.action = action;
            frm.method = "POST";
            frm.submit();
        }

        function submitToken(frm, action, execMode) {
            if (!document.FORM_PAY_NOW_ID.cardSelect.value) {
                var data = {};
                data.token_api_key = document.getElementById('token_api_key').innerText;
                if (document.getElementById('card_number')) {
                    data.card_number = document.getElementById('card_number').value;
                }
                if (document.getElementById('cc-exp')) {
                    data.card_expire = document.getElementById('cc-exp').value;
                }
                data.lang = "ja";

                var url = document.getElementById('token_api_url').innerText;

                var xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
                xhr.addEventListener('loadend', function () {
                    if (xhr.status === 0) {
                        alert("トークンサーバーとの接続に失敗しました");
                        return;
                    }
                    var response = JSON.parse(xhr.response);
                    if (xhr.status == 200) {
                        document.getElementById('token').value = response.token;
                        initializingVal();
                        submitForm(frm, action, execMode);
                    } else {
                        alert(response.message);
                    }

                });
                xhr.send(JSON.stringify(data));
            } else {
                initializingVal();
                submitForm(frm, action, execMode);
            }
        }

    </script>
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
<hr />
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G 継続課金管理(カード払い)のサンプル画面です。<br />
        お客様ECサイトとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
        また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br />
    </span>
</div>
<?php
    if (!empty($warning)) {
        echo $warning."<br><br>";
    }
?>
<form name="FORM_PAY_NOW_ID" method="post" action="RecurringExec.php">
    <input type="hidden" name="execMode" value="">
    <select name="chargeMode">
        <option value="1" <?php echo $chargeMode_1 ?>>新規課金開始</option>
        <option value="2" <?php echo $chargeMode_2 ?>>更新</option>
    </select>
    <div class="lhtitle">継続課金管理(カード払い)</div>
    <table style="border-width: 0; padding: 0; border-collapse: collapse;">
        <tr><td class="thl" colspan="2">会員情報</td></tr>
        <tr>
            <td class="ititlecommon">会員ID</td>
            <td class="ivaluecommon">
                <input type="text" size="50" name="accountId" value="<?php echo $account_id ?>" maxLength="100">
                <input type="button" value="カード情報取得" onclick="submitForm(FORM_PAY_NOW_ID, 'RecurringExec.php', '1');">
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td class="thl" colspan="2">継続課金情報</td></tr>
        <tr>
            <td class="ititlecommon">課金グループID</td>
            <td class="ivaluecommon">
                <input type="text" size="30" name="groupId" value="<?php echo $group_id ?>" maxLength="24">
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">課金開始日</td>
            <td class="ivaluecommon">
                <input type="text" size="8" name="startDate" value="<?php echo $start_date ?>" maxLength="8">
                &nbsp;&nbsp;<span style="font-size: small; color:red;">※形式:YYYYMMDD</span>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">課金終了日</td>
            <td class="ivaluecommon">
                <input type="text" size="8" name="endDate" value="<?php echo $end_date ?>" maxLength="8" />
                &nbsp;&nbsp;<span style="font-size: small; color:red;">※形式:YYYYMMDD</span><br />
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">都度／初回課金金額</td>
            <td class="ivaluecommon">
                <input type="text" size="12" name="oneTimeAmount" value="<?php echo $one_time_amount ?>" maxLength="12">
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">継続課金金額</td>
            <td class="ivaluecommon">
                <input type="text" size="12" name="recarringAmount" value="<?php echo $recarring_amount ?>" maxLength="12">
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td class="thl" colspan="2">カード情報</td>
        </tr>
        <tr>
            <td class="ititlecommon">カード選択</td>
            <td class="ivaluecommon">
                <select name="cardSelect">
                    <option value="">新しいカードを登録する</option>
                    <?php
                        if (isset($_SESSION["cardList"])) {
                            $cardList = $_SESSION["cardList"];
                        }
                        $cardSelected = "";
                        if (isset($_SESSION["selected"])) {
                            $cardSelected = $_SESSION["selected"];
                        }
                        if (isset($cardList)) {
                            for ($i = 0; $i < count($cardList); $i++) {
                                $selected = "";
                                if (key($cardList[$i]) == $cardSelected) {
                                    $selected = "selected";
                                }
                    ?>
                    <option value="<?php echo key($cardList[$i]) ?>"<?php echo $selected ?> ><?php echo $cardList[$i][key($cardList[$i])] ?></option>
                    <?php } } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">クレジットカード番号</td>
            <td class="ivaluecommon">
                <input id="card_number" type="tel" x-autocompletetype="cc-number" autocompletetype="cc-number"
                   autocorrect="off" spellcheck="false" autocapitalize="off" maxlength="19" size="19">
                <span style="font-size: small; color:red;">&nbsp;(新しいカードを登録する場合のみ入力可)</span>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">有効期限</td>
            <td class="ivaluecommon">
                <input id="cc-exp" type="tel" x-autocompletetype="off" autocompletetype="off" autocorrect="off"
                   spellcheck="false" autocapitalize="off" placeholder="MM/YY" maxlength="5" size="5">
                   &nbsp;&nbsp;<span style="font-size: small; color:red;">※形式：MM/YY&nbsp;(新しいカードを登録する場合のみ入力可)</span>
            </td>
        </tr>
        <tr>
            <td class="thlToken" colspan="2">
                MDKトークン設定情報
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">トークンAPIキー</td>
            <td class="ivaluecommon">
                <span id="token_api_key"><?php echo htmlspecialchars($token_api_key) ?></span>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">トークンAPI URL</td>
            <td class="ivaluecommon">
                <span id="token_api_url"><?php echo htmlspecialchars($token_api_url) ?></span><br/>
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td colspan="2"><input type="button" value="実行" onclick="submitToken(FORM_PAY_NOW_ID, 'RecurringExec.php', '2');">
            &nbsp;&nbsp;<span style="font-size: small; color:red;">※２回以上クリックしないでください。</span></td>
        </tr>
    </table>
    <input type="hidden" id="token" name="token">
</form>

<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>
<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>