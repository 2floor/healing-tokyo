<?php
// セッションから合計決済金額を取得するための準備
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

$wallet_amount = array_key_exists('walletAmount', $_POST) ? htmlspecialchars($_POST['walletAmount']) : "";
$card_amount = array_key_exists('cardAmount', $_POST) ? htmlspecialchars($_POST['cardAmount']) : "";
$card_order_id = array_key_exists('cardOrderId', $_POST) ? htmlspecialchars($_POST['cardOrderId']) : "";

$new_order_id = "dummy".time();

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
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VeriTrans 4G - 永久不滅ポイント(永久不滅ウォレット)売上サンプル画面</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
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

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G 永久不滅ポイント(永久不滅ウォレット)決済の売上サンプル画面です。<br/>
        お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
        また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
    </span>
</div>
<?php
if (!empty($warning)) {
  echo $warning."<br><br>";
}
?>
<table style="border-width: 0; padding: 0; border-collapse: collapse;">
    <tr>
        <td>
            <div class="lhtitle">永久不滅ポイント(永久不滅ウォレット)決済：売上</div>
        </td>
        <td width="20"><br></td>
        <?php
        $amount = $_SESSION["amount"];
        if ($aqf_point_balance >= 100 && $amount > $point_balance) {
        ?>
        <td>
            <!-- 永久不滅ウォレット交換へ接続 -->
            <a href="javascript:void(0);" onclick="window.open('https://www.a-q-f.com/hpc/AuthenticationPHC.do');"><font size="2">永久不滅ウォレットへ交換</font></a>
        </td>
        <?php
        }
        ?>
    </tr>
</table>
<form name="FORM_SAISON" method="post" action="./CaptureExec.php">
    <table style="border-width: 0; padding: 0; border-collapse: collapse;">
        <tr>
            <td class="ititlecommon">取引ID</td>
            <td class="ivaluecommon">
                <?php echo $order_id ?>&nbsp;&nbsp;
                <input type="hidden" name="orderId" value="<?php echo $order_id ?>">
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">永久不滅ウォレット残高</td>
            <td class="ivaluecommon">
                <table border="0">
                    <tr>
                        <td><?php echo $point_balance ?><input type="hidden" name="pointBalance" value="<?php echo $point_balance ?>"><br></td>
                        <td/>
                            <?php
                            if ($aqf_point_balance >= 100 && $amount > $point_balance) {
                            ?>
                        <td colspan="2"><input type="submit" name="reOauth" onclick="initializeVal()" value="残高再確認"></td>
                        <td>    </td>
                        <td>新取引ID : </td>
                        <td><?php echo $new_order_id ?><input type="hidden" name="newOrderId" value="<?php echo $new_order_id ?>"></td>
                        <?php
                        }
                        ?>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">永久不滅ポイント残高</td>
            <td class="ivaluecommon"><?php echo $aqf_point_balance ?><input type="hidden" name="aqfPointBalance" value="<?php echo $aqf_point_balance ?>"><br></td>
        </tr>
        <tr>
            <td class="ititlecommon">交換後利用可能バリュー</td>
            <td class="ivaluecommon"><?php echo $available_value ?><input type="hidden" name="availableValue" value="<?php echo $available_value ?>"><br></td>
        </tr>
        <tr>
            <td class="ititlecommon">合計決済金額</td>
            <td class="ivaluecommon"><?php echo $_SESSION["amount"] ?>&nbsp;&nbsp;<input type="hidden" name="amount" value="<?php echo $_SESSION["amount"] ?>"></td>
        </tr>
        <tr>
            <td class="ititlecommon">永久不滅ウォレット決済金額</td>
            <td class="ivaluecommon"><input type="text" name="walletAmount" value="<?php echo $wallet_amount ?>"></td>
        </tr>
        <tr>
            <td class="ititlecommon">カード決済金額</td>
            <td class="ivaluecommon"><input type="text" name="cardAmount" id="card_amount" value="<?php echo $card_amount ?>"></td>
        </tr>
        <tr>
            <td class="ititlecommon">カード番号</td>
            <td class="ivaluecommon">
                <input id="card_number" type="tel" x-autocompletetype="cc-number" autocompletetype="cc-number"
                       autocorrect="off" spellcheck="false" autocapitalize="off" maxlength="19" size="19">
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">カード有効期限</td>
            <td class="ivaluecommon">
                <input id="cc-exp" type="tel" x-autocompletetype="off" autocompletetype="off" autocorrect="off"
                       spellcheck="false" autocapitalize="off" placeholder="MM/YY" maxlength="5"
                       size="5">&nbsp;&nbsp;<span style="font-size: small; color: red;">※形式：MM/YY</span>
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
            <td class="ititlecommon">カード取引ＩＤ</td>
            <td class="ivaluecommon"><input type="text" name="cardOrderId" value="<?php echo $card_order_id ?>"></td>
        </tr>
        <tr>
            <td class="ititlecommon">カード与信方法</td>
            <td class="ivaluecommon">
                <table border="0">
                    <tr>
                        <td><input type="radio" name="withCapture" value="false" checked="checked"></td><td>与信のみ(与信成功後に売上処理を行う必要があります)</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="withCapture" value="true"></td><td>与信売上(与信と同時に売上処理も行います)</td>
                    </tr>
                </table>
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
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <button id="submit_btn" onclick="submitToken();return false;">購入</button>
                    &nbsp;&nbsp;<span style="font-size: small; color: red;">※2回以上クリックしないでください。</span>
            </td>
        </tr>
    </table>
    <input type="hidden" id="token" name="token">
    <input type="hidden" name="_screen" value="Capture">
</form>

<br/>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
