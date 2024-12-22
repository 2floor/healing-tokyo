<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード決済処理の実行および結果画面のサンプル
// -------------------------------------------------------------------------

 define('MDK_DIR', '../tgMdk/');
 define('INPUT_PAGE', 'CardAuthorizeSelect.php');

 define('TXN_FAILURE_CODE', 'failure');
 define('TXN_PENDING_CODE', 'pending');
 define('TXN_SUCCESS_CODE', 'success');

 define('NORMAL_PAGE_TITLE', 'VeriTrans 4G - カード決済-本人認証無し(PayNowIDカード情報利用)サンプル画面');

 define('TRUE_FLAG_CODE', 'true');
 define('FALSE_FLAG_CODE', 'false');

 require_once(MDK_DIR."3GPSMDK.php");

 /**
  * カード情報取得時のステータス
  */
 $card_info_get_status = @$_POST["cardInfoGetStatus"];
 if ("success" === $card_info_get_status) {

     /**
      * 会員ID
      */
     $account_id = @$_POST["accountId"];
     /**
      * 取引ID
      */
     $order_id = @$_POST["orderId"];
     /**
      * 支払金額
      */
     $payment_amount = @$_POST["amount"];
     /**
      * 与信方法
      */
     $is_with_capture = @$_POST["withCapture"];
     if ("1" == $is_with_capture) {
         $is_with_capture = TRUE_FLAG_CODE;
     } else {
         $is_with_capture = FALSE_FLAG_CODE;
     }
     /**
      * カードID
      */
     $card_id = @$_POST["cardId"];
     /**
      * 支払い方法,支払い回数
      */
     $jpo1 = @$_POST["jpo1"];
     $jpo2 = @$_POST["jpo2"];

     if ((!empty($jpo1)) && (("10" == $jpo1)|| ("80" == $jpo1))) {
         $jpo = $jpo1;
     }else if ((!empty($jpo1) && ("61" == $jpo1)) && (!empty($jpo2))) {
         $jpo = $jpo1."C".$jpo2;
     }
     /**
      * セキュリティコード
      */
     $security_code = @$_POST["securityCode"];
     /**
      * カード番号
      */
     $card_number = @$_POST["cardNumber"];
     /**
      * 有効期限
      */
     $card_expire = @$_POST["cardExpire"];

     /**
      * パラメータ値チェック
      */
      if (empty($order_id)){
          $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
          include_once(INPUT_PAGE);
          exit;
      } else if (empty($payment_amount)) {
          $warning =  "<font color='#ff0000'><b>必須項目：金額が指定されていません</b></font>";
          include_once(INPUT_PAGE);
          exit;
      }

      /**
       * 要求電文パラメータ値の指定
       */
      $request_data = new CardAuthorizeRequestDto();

      $request_data->setOrderId($order_id);
      $request_data->setAmount($payment_amount);
      $request_data->setWithCapture($is_with_capture);
      if (isset($jpo)) {
          $request_data->setJpo($jpo);
      }
      if (isset($security_code)) {
          $request_data->setSecurityCode($security_code);
      }
      $request_data->setCardNumber($card_number);
      $request_data->setCardExpire($card_expire);
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
           * 取引ID取得
           */
          $result_order_id = $response_data->getOrderId();
          /**
           * 結果コード取得
           */
          $txn_status = $response_data->getMStatus();
          /**
           * 詳細コード取得
           */
          $txn_result_code = $response_data->getVResultCode();
          /**
           * エラーメッセージ取得
           */
          $error_message = $response_data->getMerrMsg();

          /**
           * PayNowIDレスポンス取得
           */
          $pay_now_id_res = $response_data->getPayNowIdResponse();

          if (isset($pay_now_id_res)) {
              /**
               * PayNowIDステータス取得
               */
              $pay_now_id_status = $pay_now_id_res->getStatus();
          }
          // 成功
          if (TXN_SUCCESS_CODE === $txn_status) {
          } else if (TXN_PENDING_CODE === $txn_status) {
          // 失敗
          } else if (TXN_FAILURE_CODE === $txn_status) {
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
本画面はVeriTrans4G カード決済-本人認証無し(PayNowIDカード情報利用)のサンプル画面です。<br/>
お客様ECサイトのVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">カード決済-本人認証無し(PayNowIDカード情報利用)実行結果</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">取引ID</td>
    <td class="rivaluetop"><?php echo $result_order_id ?><br/></td>
  </tr>
  <tr>
    <td class="rititle">取引ステータス</td>
    <td class="rivalue"><?php echo $txn_status ?><br/></td>
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
