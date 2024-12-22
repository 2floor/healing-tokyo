<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 継続課金管理(カード払い)の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');
define('INPUT_PAGE', 'Recurring.php');

define('PAY_NOW_ID_FAILURE_CODE', 'failure');
define('PAY_NOW_ID_PENDING_CODE', 'pending');
define('PAY_NOW_ID_SUCCESS_CODE', 'success');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', 'VeriTrans 4G - 継続課金管理(カード払い)サンプル画面');

require_once(MDK_DIR."3GPSMDK.php");

/**
 * 会員ID
 */
$account_id = @$_POST["accountId"];
/**
 * 処理モード
 */
$exec_mode = @$_POST["execMode"];
/**
 * カードID
 */
$card_id = @$_POST["cardSelect"];
/**
 * トークン
 */
$token = @$_POST["token"];
/**
 * 課金処理モード
 */
$charge_mode = @$_POST["chargeMode"];
/**
 * 課金グループID
 */
$group_id = @$_POST["groupId"];
/**
 * 課金開始日
 */
$start_date = @$_POST["startDate"];
/**
 * 課金終了日
 */
$end_date = @$_POST["endDate"];
/**
 * 都度／初回課金金額
 */
$one_time_amount = @$_POST["oneTimeAmount"];
/**
 * 継続課金金額
 */
$recarring_amount = $_POST["recarringAmount"];


// Session準備
session_start();
if (!empty($card_id)) {
    // 選択したカードIDをセッションに格納
    $_SESSION["selected"] = $card_id;
} else {
    $_SESSION = array();
}

// 選択した課金処理モードをセッションに格納
$_SESSION["chargeMode"] = $charge_mode;

/**
 * パラメータ値チェック
 */
if (empty($account_id)){
    $warning =  "<font color='#ff0000'><b>必須項目：会員IDが指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit;
}

if ("1" === $exec_mode) {
    // カード情報取得
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
        $pay_now_id_status = "";

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
                $cardInfos = $account->getCardInfo();
                $cardList = array();
                foreach ((array)$cardInfos as $cardInfo) {
                    $key = $cardInfo->getCardId();
                    $value = $cardInfo->getCardNumber(). ":". $cardInfo->getCardExpire();
                    $map = array($key => $value);
                    array_push($cardList, $map);
                }
                
                $_SESSION["cardList"] = $cardList;
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
            include_once 'Recurring.php';
            exit;
        } else {
            if (PAY_NOW_ID_PENDING_CODE === $pay_now_id_status) {
            } else if (PAY_NOW_ID_FAILURE_CODE === $pay_now_id_status) {
            } else {
                $page_title = ERROR_PAGE_TITLE;
            }
        }
    }
} else {
   // 課金管理登録・更新

   /**
    * パラメータ値チェック
    */

   if ("1" !== $charge_mode && !empty($start_date)){
       $warning =  "<font color='#ff0000'><b>課金開始日は指定できません</b></font>";
       include_once(INPUT_PAGE);
       exit;
   }
   if (empty($group_id)){
       $warning =  "<font color='#ff0000'><b>必須項目：課金グループIDが指定されていません</b></font>";
       include_once(INPUT_PAGE);
       exit;
   }

   if ("1" === $charge_mode) {
       // 課金管理登録
       $request_data = new RecurringAddRequestDto();
       $request_data->setAccountId($account_id);
       $request_data->setGroupId($group_id);
       $request_data->setStartDate($start_date);
       $request_data->setEndDate($end_date);
       $request_data->setOneTimeAmount($one_time_amount);
       $request_data->setAmount($recarring_amount);
       if (!empty($card_id)) {
           $request_data->setCardId($card_id);
       } else {
           $request_data->setToken($token);
       }
   } else if ("2" === $charge_mode) {
       // 更新
       $request_data = new RecurringUpdateRequestDto();
       $request_data->setAccountId($account_id);
       $request_data->setGroupId($group_id);
       $request_data->setStartDate($start_date);
       $request_data->setEndDate($end_date);
       $request_data->setOneTimeAmount($one_time_amount);
       $request_data->setAmount($recarring_amount);
       if (!empty($card_id)) {
           $request_data->setCardId($card_id);
       } else {
           $request_data->setToken($token);
       }
   }

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
        $pay_now_id_status = "";

        if (isset($pay_now_id_res)) {

            /**
             * PayNowID処理番号取得
             */
            $process_id = $pay_now_id_res->getProcessId();

            /**
             * PayNowIDステータス取得
             */
            $pay_now_id_status = $pay_now_id_res->getStatus();
        }

        /**
         * 詳細コード取得
         */
        $txn_result_code = $response_data->getVResultCode();

        /**
         * エラーメッセージ取得
         */
        $error_message = $response_data->getMerrMsg();

        if (PAY_NOW_ID_SUCCESS_CODE === $pay_now_id_status) {
        } else if (PAY_NOW_ID_PENDING_CODE === $pay_now_id_status) {
        } else if (PAY_NOW_ID_FAILURE_CODE === $pay_now_id_status) {
        } else {
            $page_title = ERROR_PAGE_TITLE;
        }
    }
}


?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="ja" />
    <title><?php echo $page_title ?></title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr/>
<div class="system-message">
    <span style="font-size: small;">
        本画面はVeriTrans4G 継続課金管理(カード払い)のサンプル画面です。<br/>
        お客様ECサイトのVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
    </span>
</div>

<div class="lhtitle">継続課金管理(カード払い)実行結果</div>
<table style="border-width: 0; padding: 0; border-collapse: collapse;">
    <tr>
        <td class="rititlecommon">PayNowID処理番号</td>
        <td class="rivaluecommon"><?php echo $process_id ?><br/></td>
    </tr>
    <tr>
        <td class="rititlecommon">PayNowIDステータス</td>
        <td class="rivaluecommon"><?php echo $pay_now_id_status ?><br/></td>
    </tr>
    <tr>
        <td class="rititlecommon">結果コード</td>
        <td class="rivaluecommon"><?php echo $txn_result_code ?><br/></td>
    </tr>
    <tr>
        <td class="rititlecommon">結果メッセージ</td>
        <td class="rivaluecommon"><?php echo $error_message ?><br/></td>
    </tr>
</table>

<br/>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr/>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>