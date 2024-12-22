<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード情報取得処理の実行およびカード決済-本人認証無し(PayNowIDカード情報利用)サンプル画面
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');
define('INPUT_PAGE', 'CardAuthorize.php');

define('PAY_NOW_ID_FAILURE_CODE', 'failure');
define('PAY_NOW_ID_PENDING_CODE', 'pending');
define('PAY_NOW_ID_SUCCESS_CODE', 'success');

define('NORMAL_PAGE_TITLE', 'VeriTrans 4G - カード決済-本人認証無し(PayNowIDカード情報利用)サンプル画面');

require_once(MDK_DIR."3GPSMDK.php");

$card_number = "";
if (isset($_POST["cardNumber"])) {
    $card_number = htmlspecialchars($_POST["cardNumber"]);
}
$card_expire = "";
if (isset($_POST["cardNumber"])) {
    $card_expire = htmlspecialchars($_POST["cardExpire"]);
}

/**
 * 会員ID
 */
$account_id = htmlspecialchars(@$_POST["accountId"]);

/**
 * 取引ID
 */
$order_id = htmlspecialchars(@$_POST["orderId"]);

/**
 * 支払金額
 */
$payment_amount = htmlspecialchars(@$_POST["amount"]);

/**
 * 与信方法
 */
$with_capture = htmlspecialchars(@$_POST["withCapture"]);

/**
 * 必須パラメータ値チェック
 */
if (empty($order_id)){
    $warning =  "<span style='color:red;'><b>必須項目：取引IDが指定されていません</b></span>";
    include_once(INPUT_PAGE);
    exit;
} else if (empty($payment_amount)) {
    $warning =  "<span style='color:red;'><b>必須項目：金額が指定されていません</b></span>";
    include_once(INPUT_PAGE);
    exit;
} else if (empty($account_id)){
    $warning =  "<span style='color:red;'><b>必須項目：会員IDが指定されていません</b></span>";
    include_once(INPUT_PAGE);
    exit;
}

$request_data = new CardInfoGetRequestDto();
$request_data->setAccountId($account_id);


/**
 * 実施
 */
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

//予期しない例外
if (!isset($response_data)) {
    $page_title = ERROR_PAGE_TITLE;
//想定応答の取得
} else {
    $page_title = NORMAL_PAGE_TITLE;
    /**
     * PayNowIDレスポンス取得
     */
    $pay_now_id_res = $response_data->getPayNowIdResponse();

    if (isset($pay_now_id_res)) {
        /**
         * PayNowID処理番号取得
         */
        $process_id = $pay_now_id_res->getProcessId();
        /**
         * PayNowIDステータス取得
         */
        $pay_now_id_status = $pay_now_id_res->getStatus();

        $account = $pay_now_id_res->getAccount();
        if (isset($account)) {
             /**
              * カード情報取得
              */
             $cardInfo = $account->getCardInfo();
        }
    }

    /**
     * 詳細コード取得
     */
    $txn_result_code = $response_data->getVResultCode();
    /**
     * エラーメッセージ取得
     */
    $error_message = $response_data->getMerrMsg();

    // 成功
    if (PAY_NOW_ID_SUCCESS_CODE === $pay_now_id_status) {
    } else {
    // 失敗
        include_once 'CardAuthorizeExec.php';
        exit;
    }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="ja" />
    <title><?php echo $page_title ?></title>
    <link href="../css/style.css?1286186298" media="all" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript">
    function jpoChk(jpoObj) {
        var val = jpoObj.value;
        if (val.length == 1 && isNaN(val) == false) {
            jpoObj.value = "0" + jpoObj.value;
        }
    }

    function reDrawing(frm, action) {
        frm.action = action;
        frm.method = "POST";
        frm.submit();
    }

    function selectCard(arg) {
        var radioList = document.getElementsByName("cardId");
        if (radioList[arg].checked) {
            var secureCd = document.getElementById('securityCode' + arg).value;
            document.getElementById('securityCode').value = secureCd;
        }
    }
</script>
</head>
<body>

<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
<hr/>
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G カード決済-本人認証無し(PayNowIDカード情報利用)のサンプル画面です。<br/>
        お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
        また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
    </span>
</div>
<?php
    if (!empty($warning)) {
        echo $warning."<br><br>";
    }
?>
<div class="lhtitle">カード決済-本人認証無し(PayNowIDカード情報利用)</div>
<form name="FORM_CARD" method="post" action="CardAuthorizeExec.php">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr><td class="thl" colspan="2">決済方法入力</td></tr>
        <tr>
            <td class="ititle">カード選択</td>
            <td class="ivalue">
                <table style="width:95%;">
                    <tr><td>選択</td><td>カード番号</td><td>(有効期限)</td><td>セキュリティコード</td></tr>
<?php
    $cnt = 0;
    for ($i = 0; $i < count($cardInfo); $i++) {
?>
                    <tr>
                        <td><input type="radio" name="cardId" value="<?php echo $cardInfo[$i]->getCardId(); ?>" onChange="selectCard(<?php echo $i ?>)"></td>
                        <td><?php echo $cardInfo[$i]->getCardNumber(); ?></td>
                        <td><?php echo $cardInfo[$i]->getCardExpire(); ?></td>
                        <td><input type="text" size="4" maxlength="4" name="securityCode" id="securityCode<?php echo $i ?>" onChange="selectCard(<?php echo $i ?>)"></td>
                    </tr>
<?php
        $cnt = $i;
    }
?>
                    <tr>
                        <td><input type="radio" name="cardId" value="" onChange="selectCard(<?php echo $cnt ?>)"></td>
                        <td><input type="text" size="20" maxlength="19" name="cardNumber" value="<?php echo htmlspecialchars($card_number) ?>"></td>
                        <td><input type="text" size="5" maxlength="5" name="cardExpire" value="<?php echo htmlspecialchars($card_expire) ?>"></td>
                        <td><input type="text" size="4" maxlength="4" name="securityCode<?php echo $cnt ?>" id="securityCode<?php echo $cnt ?>" onChange="selectCard(<?php echo $cnt ?>)"></td>
                    </tr>
                    <input type="hidden" name="securityCode" value="" id="securityCode">
                </table>
            </td>
        </tr>
        <tr>
            <td class="ititle">支払方法</td>
            <td class="ivalue">
                <select name="jpo1">
                    <option value="10"<?php if ("10" == htmlspecialchars(@$_POST["jpo1"])) { echo " selected"; } ?>>一括払い(支払回数の設定は不要)</option>
                    <option value="61"<?php if ("61" == htmlspecialchars(@$_POST["jpo1"])) { echo " selected"; } ?>>分割払い(支払回数を設定してください)</option>
                    <option value="80"<?php if ("80" == htmlspecialchars(@$_POST["jpo1"])) { echo " selected"; } ?>>リボ払い(支払回数の設定は不要)</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="ititle">支払回数</td>
            <td class="ivalue">
                <input type="text" maxlength="2" size="3" name="jpo2" value="<?php echo htmlspecialchars(@$_POST["jpo2"]) ?>" onBlur="jpoChk(this);">
                &nbsp;&nbsp;<span style="font-size: small; color:red;">※一桁の場合は数値の前に&quot;0&quot;をつけてください。&nbsp;&nbsp;例：01</span>
            </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="実行">
                &nbsp;&nbsp;<span style="font-size: small; color:red;">※２回以上クリックしないでください。</span>
            </td>
        </tr>
        <input type="hidden" name="accountId" value="<?php echo $account_id ?>">
        <input type="hidden" name="orderId" value="<?php echo $order_id ?>">
        <input type="hidden" name="amount" value="<?php echo $payment_amount ?>">
        <input type="hidden" name="withCapture" value="<?php echo $with_capture ?>">
        <input type="hidden" name="cardInfoGetStatus" value="<?php echo $pay_now_id_status ?>">
    </table>
</form>

<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>