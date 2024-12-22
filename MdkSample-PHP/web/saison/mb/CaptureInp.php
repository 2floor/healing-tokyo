<?php
// �Z�b�V�������獇�v���ϋ��z���擾���邽�߂̏���
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

// �ݒ�t�@�C���̓ǂݍ���
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
    <title>VeriTrans 4G - �i�v�s�Ń|�C���g(�i�v�s�ŃE�H���b�g)����T���v�����</title>
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
                    alert("�g�[�N���T�[�o�[�Ƃ̐ڑ��Ɏ��s���܂���");
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
<img alt='Payment���S' src='../../WEB-IMG/VeriTrans_Payment.png'><br>
<br>
<font size="2">�g�їp�̔���T���v����ʂł��B</font>
<br>

<?php
    if (!empty($warning)) {
      echo $warning."<br><br>";
    }
?>


<br>
�i�v�s�Ń|�C���g(�i�v�s�ŃE�H���b�g)���ρF<br>���㐿��<br>
<br>

=== ���ϓ��e ===<br>
<br>

���ID�F<br>
<?php echo $order_id ?>&nbsp;&nbsp;<input type="hidden" name="orderId" value="<?php echo $order_id ?>"><br>
<br>

�i�v�s�ŃE�H���b�g�c���F<br>
<?php echo $point_balance ?><input type="hidden" name="pointBalance" value="<?php echo $point_balance ?>"><br>
<br>

�i�v�s�Ń|�C���g�c���F<br>
<?php echo $aqf_point_balance ?><input type="hidden" name="aqfPointBalance" value="<?php echo $aqf_point_balance ?>"><br>
<br>

�����㗘�p�\�o�����[�F<br>
<?php echo $available_value ?><input type="hidden" name="availableValue" value="<?php echo $available_value ?>"><br>
<br>

���v���ϋ��z�F<br>
<?php echo $_SESSION["amount"] ?>&nbsp;&nbsp;<input type="hidden" name="amount" value="<?php echo ((isset($_SESSION["amount"])) ? $_SESSION["amount"]: null) ?>"><br>
<br>

�i�v�s�ŃE�H���b�g���ϋ��z�F<br>
<input type="text" name="walletAmount" value="<?php echo htmlspecialchars((isset($_POST["walletAmount"])) ? $_POST["walletAmount"]: null) ?>"><br>
<br>

�J�[�h���ϋ��z�F<br>
<input type="text" name="cardAmount" id="card_amount" value="<?php echo htmlspecialchars((isset($_POST["cardAmount"])) ? $_POST["cardAmount"]: null) ?>"><br>
<br>

�J�[�h�ԍ��F<br>
<input id="card_number" type="tel" x-autocompletetype="cc-number" autocompletetype="cc-number" autocorrect="off" spellcheck="false" autocapitalize="off" maxlength="19" size="19"><br>
<br>

�J�[�h�L�������F<br>
<input id="cc-exp" type="tel" x-autocompletetype="off" autocompletetype="off" autocorrect="off" spellcheck="false" autocapitalize="off" placeholder="MM/YY" maxlength="5" size="5"><br>
<br>

�Z�L�����e�B�R�[�h�F<br>
<input id="cc-csc" type="tel" autocomplete="off" autocorrect="off" spellcheck="false" autocapitalize="off" maxlength="4" size="4"><br>
<br>

�J�[�h����h�c�F<br>
<input type="text" name="cardOrderId" value="<?php echo htmlspecialchars((isset($_POST["cardOrderId"])) ? $_POST["cardOrderId"]: null) ?>"><br>
<br>

<tr>
    <td class="ititle">�J�[�h�^�M���@�F</td>
    <td class="ivalue">
        <table border="0">
            <tr>
                <td>
                    <input type="radio" name="withCapture" value="false" checked="checked"></td><td>�^�M�̂�(�^�M������ɔ��㏈�����s���K�v������܂�)
                </td>
            </tr>
            <tr>
                <td>
                    <input type="radio" name="withCapture" value="true"></td><td>�^�M����(�^�M�Ɠ����ɔ��㏈�����s���܂�)
                </td>
            </tr>
        </table>
    </td>
</tr>
<br>

=== MDK�g�[�N���ݒ��� ===<br>
<br>
�g�[�N��API�L�[�F<br>
<span id="token_api_key"><?php echo htmlspecialchars($token_api_key) ?></span><br>
<br>

�g�[�N��API URL�F<br>
<span id="token_api_url"><?php echo htmlspecialchars($token_api_url) ?></span><br>

<br>
<input type="submit" onclick="submitToken();return false;" value="�w��"><br>
<br>

================<br>
<br>

<input type="hidden" id="token" name="token">
<input type="hidden" name="_screen" value="Capture">
<img alt='VeriTrans���S' src='../../WEB-IMG/VeriTransLogo_WH.png'><br>
Copyright &copy; VeriTrans Inc. All rights reserved

</form>
</body>
</html>
