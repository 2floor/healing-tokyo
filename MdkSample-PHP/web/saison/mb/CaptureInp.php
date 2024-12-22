<?php
// セッションから合計決済金額を取得するための準備
if (isset($_GET["session_id"])) session_id($_GET["session_id"]);
session_start();

$order_id = "";
$point_balance = "";
$aqf_point_balance = "";
$available_value = "";

if (empty($_POST["orderId"]) === FALSE) {
    $order_id = $_POST["orderId"];
} else if (empty($_GET["orderId"]) === FALSE) {
    $order_id = $_GET["orderId"];
}

if (empty($_POST["pointBalance"]) === FALSE) {
    $point_balance = $_POST["pointBalance"];
} else if (empty($_GET["pointBalance"]) === FALSE) {
    $point_balance = $_GET["pointBalance"];
}

if (empty($_POST["aqfPointBalance"]) === FALSE) {
    $aqf_point_balance = $_POST["aqfPointBalance"];
} else if (empty($_GET["aqfPointBalance"]) === FALSE) {
    $aqf_point_balance = $_GET["aqfPointBalance"];
}

if (empty($_POST["availableValue"]) === FALSE) {
    $available_value = $_POST["availableValue"];
} else if (empty($_GET["availableValue"]) === FALSE) {
    $available_value = $_GET["availableValue"];
}

// 設定ファイルの読み込み
$config_file = "../../env4sample.ini";
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
    $token_api_url = ((isset($url["scheme"])) ? $url["scheme"] : null) . "://" . ((isset($url["host"])) ? $url["host"] : null) . "/4gtoken";
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
    <meta http-equiv="Content-Language" content="ja" />
    <title>VeriTrans 4G - 永久不滅ポイント(永久不滅ウォレット)売上サンプル画面</title>
    <script language="JavaScript" type="text/javascript">
        function initializeVal() {
            document.getElementById('card_number').value = "";
            document.getElementById('cc-exp').value = "";
            document.getElementById('cc-csc').value = "";
        }

        function submitToken(e) {
            var card_amount_elm = document.getElementById('card_amount');
            if (!card_amount_elm || card_amount_elm.value == 0) {
                initializeVal();
                document.forms[0].submit();
                return;
            }

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
                    document.forms[0].submit();
                } else {
                    alert(response.message);
                }

            });
            xhr.send(JSON.stringify(data));
        }
    </script>
</head>
<body>
<form method="post" action="./CaptureExec.php">
<img alt='Paymentロゴ' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">携帯用の売上サンプル画面です。</font>
<br>

<?php
    if (!empty($warning)) {
      echo $warning."<br><br>";
    }
?>


<br>
永久不滅ポイント(永久不滅ウォレット)決済：<br>売上請求<br>
<br>

=== 決済内容 ===<br>
<br>

取引ID：<br>
<?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><br>
<br>

永久不滅ウォレット残高：<br>
<?php echo $point_balance ?><input type="hidden" name="pointBalance" value="<?php echo $point_balance ?>"><br>
<br>

永久不滅ポイント残高：<br>
<?php echo $aqf_point_balance ?><input type="hidden" name="aqfPointBalance" value="<?php echo $aqf_point_balance ?>"><br>
<br>

交換後利用可能バリュー：<br>
<?php echo $available_value ?><input type="hidden" name="availableValue" value="<?php echo $available_value ?>"><br>
<br>

合計決済金額：<br>
<?php echo $_SESSION["amount"] ?>&nbsp;&nbsp;<input type="hidden" name="amount" value="<?php echo ((isset($_SESSION["amount"])) ? $_SESSION["amount"]: null) ?>"><br>
<br>

永久不滅ウォレット決済金額：<br>
<input type="text" name="walletAmount" value="<?php echo htmlspecialchars((isset($_POST["walletAmount"])) ? $_POST["walletAmount"]: null) ?>"><br>
<br>

カード決済金額：<br>
<input type="text" name="cardAmount" id="card_amount" value="<?php echo htmlspecialchars((isset($_POST["cardAmount"])) ? $_POST["cardAmount"]: null) ?>"><br>
<br>

カード番号：<br>
<input id="card_number" type="tel" x-autocompletetype="cc-number" autocompletetype="cc-number" autocorrect="off" spellcheck="false" autocapitalize="off" maxlength="19" size="19"><br>
<br>

カード有効期限：<br>
<input id="cc-exp" type="tel" x-autocompletetype="off" autocompletetype="off" autocorrect="off" spellcheck="false" autocapitalize="off" placeholder="MM/YY" maxlength="5" size="5"><br>
<br>

セキュリティコード：<br>
<input id="cc-csc" type="tel" autocomplete="off" autocorrect="off" spellcheck="false" autocapitalize="off" maxlength="4" size="4"><br>
<br>

カード取引ＩＤ：<br>
<input type="text" name="cardOrderId" value="<?php echo htmlspecialchars((isset($_POST["cardOrderId"])) ? $_POST["cardOrderId"]: null) ?>"><br>
<br>

<tr>
    <td class="ititle">カード与信方法：</td>
    <td class="ivalue">
        <table border="0">
            <tr>
                <td>
                    <input type="radio" name="withCapture" value="false" checked="checked"></td><td>与信のみ(与信成功後に売上処理を行う必要があります)
                </td>
            </tr>
            <tr>
                <td>
                    <input type="radio" name="withCapture" value="true"></td><td>与信売上(与信と同時に売上処理も行います)
                </td>
            </tr>
        </table>
    </td>
</tr>
<br>

=== MDKトークン設定情報 ===<br>
<br>
トークンAPIキー：<br>
<span id="token_api_key"><?php echo htmlspecialchars($token_api_key) ?></span><br>
<br>

トークンAPI URL：<br>
<span id="token_api_url"><?php echo htmlspecialchars($token_api_url) ?></span><br>

<br>
<input type="submit" onclick="submitToken();return false;" value="購入"><br>
<br>

================<br>
<br>

<input type="hidden" id="token" name="token">
<input type="hidden" name="_screen" value="Capture">
<img alt='VeriTransロゴ' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</form>
</body>
</html>
