<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 会員カード管理処理サンプル画面
// -------------------------------------------------------------------------

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

// セッションからカード情報を取得するための準備
if (isset ($_SESSION["cardList"])) {
    $cardList = $_SESSION["cardList"];
}
if (isset ($cardList) && !isset($_SESSION)) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VeriTrans 4G - 会員カード管理サンプル画面</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<script language="JavaScript" type="text/javascript">
    function initializeVal() {
        document.getElementById('card_number').value = "";
        document.getElementById('cc-exp').value = "";
        document.getElementById('cc-csc').value = "";
    }

    function submitForm(frm, action, execMode) {
        initializeVal();
        frm.execMode.value = execMode;
        frm.action = action;
        frm.method = "POST";
        frm.submit();
    }

    function submitToken(frm, action, execMode) {
        var data = {};
        data.token_api_key = document.getElementById('token_api_key').innerText;
        if (document.getElementById('card_number')) {
            data.card_number = document.getElementById('card_number').value;
        }
        if (document.getElementById('cc-exp')) {
            data.card_expire = document.getElementById('cc-exp').value;
        }
        if (document.getElementById('cc-csc')) {
            data.security_code = document.getElementById('cc-csc').value;
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
                initializeVal();
                document.getElementById('token').value = response.token;
                submitForm(frm, action, execMode);
            } else {
                alert(response.message);
            }

        });
        xhr.send(JSON.stringify(data));
    }
</script>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr />
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G 会員カード管理のサンプル画面です。<br />
        お客様ECサイトとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
        また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br />
    </span>
</div>
<?php
    if (!empty($warning)) {
        echo $warning."<br><br>";
    }
?>
<div class="lhtitle">会員カード管理</div>
<form name="FORM_PAY_NOW_ID" method="post" action="CardManageExec.php">
    <input type="hidden" name="execMode" value="">
    <table style="border-width: 0; padding: 0; border-collapse: collapse;">
        <tr>
            <td class="thl" colspan="2">カード情報</td>
        </tr>
        <tr>
            <td class="ititlecommon">会員ID</td>
            <td class="ivaluecommon">
                <input type="text" size="50" name="accountId" value="<?php if (isset($_POST["accountId"])) {echo htmlspecialchars($_POST["accountId"]);} ?>" maxLength="100">
                <input type="button" value="カード情報取得" onclick="submitForm(FORM_PAY_NOW_ID, 'CardManageExec.php', '1');">
            </td>
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
                        if (isset($_SESSION["selected"])) {
                            $cardSelected = $_SESSION["selected"];
                        }
                        if (isset($cardList)) {
                            for ($i = 0; $i < count($cardList); $i++) {
                                $selected = "";
                                if (isset($cardSelected)) {
                                    if (key($cardList[$i]) == $cardSelected) {
                                        $selected = "selected";
                                    }
                                }
                    ?>
                    <option value="<?php echo key($cardList[$i]) ?>"<?php echo $selected ?> ><?php echo $cardList[$i][key($cardList[$i])] ?></option>
                    <?php } } ?>
                </select>
                <input type="button" value="削除" onclick="submitForm(FORM_PAY_NOW_ID, 'CardManageExec.php', '2');">
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">クレジットカード番号</td>
            <td class="ivaluecommon">
                <input id="card_number" type="tel" x-autocompletetype="cc-number" autocompletetype="cc-number"
                   autocorrect="off" spellcheck="false" autocapitalize="off" maxlength="19" size="19">
                <br/><span style="font-size: small; color:red;">&nbsp;(カード選択時に入力した場合、カード番号の変更扱い)</span>
            </td>
        </tr>

        <tr>
            <td class="ititlecommon">有効期限</td>
            <td class="ivaluecommon">
                <input id="cc-exp" type="tel" x-autocompletetype="off" autocompletetype="off" autocorrect="off"
                   spellcheck="false" autocapitalize="off" placeholder="MM/YY" maxlength="5"
                   size="5">&nbsp;&nbsp;
                <span style="font-size: small; color: red;">※形式：MM/YY
                    <br/>&nbsp;(カード選択時に入力した場合、有効期限の延長扱い)
                </span>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">セキュリティコード</td>
            <td class="ivaluecommon">
                <input id="cc-csc" type="tel" autocomplete="off" autocorrect="off" spellcheck="false" autocapitalize="off" maxlength="4" size="4">
                &nbsp;&nbsp;<span style="font-size: small; color: red;">※必要な場合は入力してください。</span>
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
            <td colspan="2">
                <button id="submit_btn" onclick="submitToken(FORM_PAY_NOW_ID, 'CardManageExec.php', '3');return false;">実行</button>
                &nbsp;&nbsp;<span style="font-size: small; color: red;">※2回以上クリックしないでください。</span>
            </td>
        </tr>
    </table>
    <input type="hidden" id="token" name="token">
</form>
<br/>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>
<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>
