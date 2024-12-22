<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 会員カードの登録・更新・削除の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');
define('INPUT_PAGE', 'CardManage.php');

define('PAY_NOW_ID_FAILURE_CODE', 'failure');
define('PAY_NOW_ID_PENDING_CODE', 'pending');
define('PAY_NOW_ID_SUCCESS_CODE', 'success');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', 'VeriTrans 4G - 会員カード管理サンプル画面');

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


// Session準備
session_start();
if (!empty($card_id)) {
   // 選択したカードIDをセッションに格納
   $_SESSION["selected"] = $card_id;
} else {
   $_SESSION = array();
}


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
             include_once 'CardManage.php';
             exit;
         } else {
             if (PAY_NOW_ID_PENDING_CODE === $pay_now_id_status) {
             } else if (PAY_NOW_ID_FAILURE_CODE === $pay_now_id_status) {
             } else {
                 $page_title = ERROR_PAGE_TITLE;
             }
         }
     }
} else if ("2" === $exec_mode) {
    // カード削除
    if (empty($card_id)) {
        $warning =  "<font color='#ff0000'><b>必須項目：削除対象カードを選択してください</b></font>";
        include_once(INPUT_PAGE);
        exit;
    }

    $request_data = new CardInfoDeleteRequestDto();
    $request_data->setAccountId($account_id);
    $request_data->setCardId($card_id);

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

} else if ("3" === $exec_mode) {
    if (empty($card_id)) {

        $request_data = new CardInfoAddRequestDto();
        $request_data->setAccountId($account_id);
        $request_data->setToken($token);

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
    } else {
        // カード更新
        $request_data = new CardInfoUpdateRequestDto();
        $request_data->setAccountId($account_id);
        $request_data->setCardId($card_id);
        $request_data->setToken($token);

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
} else {
    $warning =  "<font color='#ff0000'><b>不正な処理です</b></font>";
    include_once(INPUT_PAGE);
    exit;
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
本画面はVeriTrans4G 会員カード管理のサンプル画面です。<br/>
お客様ECサイトのVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
    </span>
</div>

<div class="lhtitle">会員カード管理実行結果</div>
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

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>