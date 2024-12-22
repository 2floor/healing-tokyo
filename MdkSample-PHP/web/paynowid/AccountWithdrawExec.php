<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 会員退会処理の実行および結果画面のサンプル
// -------------------------------------------------------------------------

 define('MDK_DIR', '../tgMdk/');
 define('INPUT_PAGE', 'AccountWithdraw.php');

 define('PAY_NOW_ID_FAILURE_CODE', 'failure');
 define('PAY_NOW_ID_PENDING_CODE', 'pending');
 define('PAY_NOW_ID_SUCCESS_CODE', 'success');

 define('ERROR_PAGE_TITLE', 'System Error');
 define('NORMAL_PAGE_TITLE', 'VeriTrans 4G - 会員退会処理サンプル画面');

 require_once(MDK_DIR."3GPSMDK.php");
 
 /**
  * 会員ID
  */
 $account_id = @$_POST["accountId"];

 /**
  * 退会年月日
  */
 $delete_date = @$_POST["deleteDate"];
 
 /**
  * 必須パラメータ値チェック
  */
 if (empty($account_id)){
     $warning =  "<font color='#ff0000'><b>必須項目：会員IDが指定されていません</b></font>";
     include_once(INPUT_PAGE);
     exit;
 }
 
 /**
  * 要求電文パラメータ値の指定
  */
 $request_data = new AccountDeleteRequestDto();
 $request_data->setAccountId($account_id);
 $request_data->setDeleteDate($delete_date);
 
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
   
     // 成功
     if (PAY_NOW_ID_SUCCESS_CODE === $pay_now_id_status) {
     } else if (PAY_NOW_ID_PENDING_CODE === $pay_now_id_status) {
     // 失敗
     } else if (PAY_NOW_ID_FAILURE_CODE === $pay_now_id_status) {
     } else {
         $page_title = ERROR_PAGE_TITLE;
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
<font size="2">
本画面はVeriTrans4G 会員退会処理のサンプル画面です。<br/>
お客様ECサイトのVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">会員退会処理実行結果</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">PayNowID処理番号</td>
    <td class="rivaluetop"><?php echo $process_id ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">PayNowIDステータス</td>
    <td class="rivalue"><?php echo $pay_now_id_status ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">結果コード</td>
    <td class="rivalue"><?php echo $txn_result_code ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">結果メッセージ</td>
    <td class="rivalue"><?php echo $error_message ?><br/></td>
  </tr>
</table>

<br/>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


</body>
</html>