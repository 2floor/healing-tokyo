<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード決済(3D認証付き)入力画面のサンプル
// -------------------------------------------------------------------------

$order_id = "dummy".time();

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
    <title>VeriTrans 4G - カード決済与信(3D認証付き)サンプル画面</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript">
        function jpoChk(jpoObj) {
            var val = jpoObj.value;
            if (val.length == 1) {
                if (isNaN(val) == false) {
                    jpoObj.value = "0" + jpoObj.value;
                }
            }
        }

        function reDrawing(frm, action) {
            frm.action = action;
            frm.method = "POST";
            frm.submit();
        }

        function submitToken(e) {
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
                    document.getElementById('card_number').value = "";
                    document.getElementById('cc-exp').value = "";
                    document.getElementById('cc-csc').value = "";
                    document.getElementById('token').value = response.token;
                    document.forms[0].submit();
                }
                else {
                    alert(response.message);
                }

            });
            xhr.send(JSON.stringify(data));
        }
    </script>
</head>
<body>
<img alt="Paymentロゴ" src='../WEB-IMG/VeriTrans_Payment.png'>
<hr/>
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G カード決済与信(3D認証付き)の取引サンプル画面です。<br/>
        お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
        また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
    </span>
</div>

<?php
if (!empty($warning)) {
    echo $warning."<br/><br/>";
}
?>

<table style="border-width: 0; padding: 0; border-collapse: collapse;">
    <tr>
        <td>
            <div class="lhtitle">カード決済与信(3D認証付き)：決済請求</div>
        </td>
        <td>
            <img alt="LOGO" src='../WEB-IMG/MPI_VerifiedByVisa.png'>
            <img alt="LOGO" src='../WEB-IMG/MPI_MasterSecureCode.png'>
            <img alt="LOGO" src='../WEB-IMG/MPI_JSecure.png'>
        </td>
    </tr>
</table>

<form name="FORM_MPI" method="post" action="AuthorizeExec.php">
    <table style="border-width: 0; padding: 0; border-collapse: collapse;">
        <tr>
            <td class="ititlecommon">取引ID</td>
            <td class="ivaluecommon">
                <?php echo $order_id ?>&nbsp;&nbsp;
                <input type="hidden" name="orderId" value="<?php echo $order_id ?>">
                <input type="button" value="取引ID更新" onclick="reDrawing(FORM_MPI, 'Authorize.php');">
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">決済金額</td>
            <td class="ivaluecommon">
                <input type="text" maxlength="8" size="9" name="amount" value="<?php echo htmlspecialchars(@$_POST["amount"]) ?><?php echo htmlspecialchars(@$_GET["price"]) ?>">
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">決済種別</td>
            <td class="ivaluecommon">
                <select name="paymentMode">
                    <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>1: 3D-Secure認証のみ(決済しない)</option>
                    <option value="2"<?php if ("2" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>2: 完全認証(3D-Secure認証が完全に成功した場合のみ決済する)</option>
                    <option value="3"<?php if ("3" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>3: 通常認証(カード会社リスク負担にて決済する)</option>
                    <option value="4"<?php if ("4" == htmlspecialchars(@$_POST["paymentMode"])) { echo " selected"; } ?>>4: 通常認証(カード会社か加盟店リスク負担にて決済する)</option>
                </select><br/>
                <span style="font-size: small; color: red;">※この項目は消費者が選択せず、内部的に設定いただく項目です。</span>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">与信方法</td>
            <td class="ivaluecommon">
                <select name="withCapture">
                    <option value="0"<?php if ("0" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信のみ(与信成功後に売上処理を行う必要があります)</option>
                    <option value="1"<?php if ("1" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信売上(与信と同時に売上処理も行います)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">クレジットカード番号</td>
            <td class="ivaluecommon">
                <input id="card_number" type="tel" x-autocompletetype="cc-number" autocompletetype="cc-number"
                       autocorrect="off" spellcheck="false" autocapitalize="off" maxlength="19" size="19">
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">有効期限</td>
            <td class="ivaluecommon">
                <input id="cc-exp" type="tel" x-autocompletetype="off" autocompletetype="off" autocorrect="off"
                       spellcheck="false" autocapitalize="off" placeholder="MM/YY" maxlength="5"
                       size="5">&nbsp;&nbsp;<span style="font-size: small; color: red;">※形式：MM/YY</span>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">支払方法</td>
            <td class="ivaluecommon">
                <select name="jpo1">
                    <option value="10"<?php if ("10" == htmlspecialchars(@$_POST["jpo1"])) { echo " selected"; } ?>>一括払い(支払回数の設定は不要)</option>
                    <option value="61"<?php if ("61" == htmlspecialchars(@$_POST["jpo1"])) { echo " selected"; } ?>>分割払い(支払回数を設定してください)</option>
                    <option value="80"<?php if ("80" == htmlspecialchars(@$_POST["jpo1"])) { echo " selected"; } ?>>リボ払い(支払回数の設定は不要)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="ititlecommon">支払回数</td>
            <td class="ivaluecommon">
                <input type="text" maxlength="2" size="3" name="jpo2" value="<?php echo htmlspecialchars(@$_POST["jpo2"]) ?>" onBlur="jpoChk(this);">
                &nbsp;&nbsp;<span style="font-size:small;color:red;">※一桁の場合は数値の前に&quot;0&quot;をつけてください。&nbsp;&nbsp;例：01</span>
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
            <td class="ititlecommon">プッシュ通知先URL</td>
            <td class="ivaluecommon"><input type="text" maxlength="256" size="70" name="pushUrl" value="<?php echo htmlspecialchars(@$_POST["pushUrl"]) ?>"><br/>
                <font size="2" color="red">※必要な場合は入力してください。</font>
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
                <button id="btnSubmit" onclick="submitToken();return false;">購入</button>
                &nbsp;&nbsp;<span style="font-size: small; color: red;">※2回以上クリックしないでください。</span>
            </td>
        </tr>

    </table>
    <input type="hidden" id="token" name="token">
</form>

<br/>
<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>

<hr/>
<img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png"/>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
