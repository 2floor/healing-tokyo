<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 継続課金停止(カード払い)の実行および結果画面のサンプル
// -------------------------------------------------------------------------

 define('MDK_DIR', '../tgMdk/');
 define('INPUT_PAGE', 'RecurringTerminate.php');

 define('PAY_NOW_ID_FAILURE_CODE', 'failure');
 define('PAY_NOW_ID_PENDING_CODE', 'pending');
 define('PAY_NOW_ID_SUCCESS_CODE', 'success');

 define('ERROR_PAGE_TITLE', 'System Error');
 define('NORMAL_PAGE_TITLE', 'VeriTrans 4G - 継続課金停止(カード払い)サンプル画面');

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
  * 課金グループID
  */
 $group_id = @$_POST["groupId"];
 /*
  * 課金終了日
  */
 $end_date = @$_POST["endDate"];
 /**
  * 次回課金自動終了フラグ
  */
 $final_charge = @$_POST["finalCharge"];
 
 
 /**
  * パラメータ値チェック
  */
 if (empty($account_id)){
     $warning =  "<font color='#ff0000'><b>必須項目：会員IDが指定されていません</b></font>";
     include_once(INPUT_PAGE);
     exit;
 }
 
// Sessionに準備
 session_start();
 
 if ("1" === $exec_mode) {
     // 課金情報取得
     $request_data = new RecurringGetRequestDto();
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
                   * 課金情報取得
                   */
                  $recurringCharges = $account->getRecurringCharge();
                  /**
                   * カード情報取得
                   */
                  $cardInfos = $account->getCardInfo();
                  
                  $groupIdList = array();
                  foreach ($recurringCharges as $recurringCharge) {
                      $key = $recurringCharge->getGroupId();
                      foreach ($cardInfos as $cardInfo) {
                          if ($cardInfo->getCardId() === $recurringCharge->getCardId()) {
                              $value = $cardInfo->getCardNumber(). ":". $cardInfo->getCardExpire();
                              break;
                          }
                      }
                      $map = array($key => $value);
                      array_push($groupIdList, $map);
                  }
              }
              
              $_SESSION = array();
              $_SESSION["groupIdList"] = $groupIdList;
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
              include_once 'RecurringTerminate.php';
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
     // 課金削除
     /**
      * パラメータ値チェック
      */
     if (empty($group_id)){
         $warning =  "<font color='#ff0000'><b>必須項目：課金グループIDが指定されていません</b></font>";
         include_once(INPUT_PAGE);
         exit;
     }

     $request_data = new RecurringDeleteRequestDto();
     $request_data->setAccountId($account_id);
     $request_data->setGroupId($group_id);
     $request_data->setEndDate($end_date);
     $request_data->setFinalCharge($final_charge);
   
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
本画面はVeriTrans4G 継続課金停止(カード払い)のサンプル画面です。<br/>
お客様ECサイトのVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">継続課金停止(カード払い)実行結果</div>
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