<?php

# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード決済処理(3D認証付き)の実行サンプル
// -------------------------------------------------------------------------

 define('MDK_DIR', '../tgMdk/');
 define('INPUT_PAGE', 'MpiAuthorizeSelect.php');

 define('TXN_FAILURE_CODE', 'failure');
 define('TXN_PENDING_CODE', 'pending');
 define('TXN_SUCCESS_CODE', 'success');

 define('NORMAL_PAGE_TITLE', 'VeriTrans 4G - カード決済-3D認証有り(PayNowIDカード情報利用)サンプル画面');
 define('TRUE_FLAG_CODE', 'true');
 define('FALSE_FLAG_CODE', 'false');

 /**
  * 決済種別コード値（POSTされた値）
  */
 define('NON_MODE_CODE', '1');
 define('COMPLETE_MODE_CODE', '2');
 define('COMPANY_MODE_CODE', '3');
 define('MERCHANT_MODE_CODE', '4');

 require_once(MDK_DIR."3GPSMDK.php");

 /**
  * カード情報取得時のステータス
  */
 $card_info_get_status = @$_POST["cardInfoGetStatus"];
 if ("success" === $card_info_get_status) {

     /**
      * サンプルでは"env4sample.ini"ファイルから認証利用方式とリダイレクトされるURLを
      * 取得（サンプル使用の場合は設定ファイルを変更のこと）
      */
     $config_file = "../env4sample.ini";

     if (is_readable($config_file)) {
         $env_info = @parse_ini_file($config_file, true);
         /**
          * オプションタイプ
          * 1. MPIサービスのみ : mpi-none
          * 2. 完全認証 : mpi-complete
          * 3. 通常認証（カード会社リスク負担） ： mpi-company
          * 4. 通常認証（カード会社、加盟店リスク負担）: mpi-merchant
          *
          */
         $payment_mode = @$_POST["paymentMode"];
         $redirection_url = $env_info["PAYNOWID-MPI"]["redirection.url"];
     }
     /**
      * 実使用コードに変換
      */
     switch ($payment_mode) {
         case NON_MODE_CODE:
             $service_option_type = "mpi-none";
             break;
         case COMPLETE_MODE_CODE:
             $service_option_type = "mpi-complete";
             break;
         case COMPANY_MODE_CODE:
             $service_option_type = "mpi-company";
             break;
         case MERCHANT_MODE_CODE:
             $service_option_type = "mpi-merchant";
             break;
         default:
             break;
     }

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

      session_start();
      // 決済種別
      $_SESSION["payment_mode"] = $payment_mode;
      // 与信である事を示すフラグをセッションに格納
      $_SESSION["reAuthorizeFlg"] = "2";

      /**
      * 要求電文パラメータ値の指定
      */
      $request_data = new MpiAuthorizeRequestDto();
      $request_data->setServiceOptionType($service_option_type);
      $request_data->setOrderId($order_id);
      $request_data->setAmount($payment_amount);
      $request_data->setWithCapture($is_with_capture);

      if (isset($jpo)) {
          $request_data->setJpo($jpo);
      }
      if (isset($security_code)) {
          $request_data->setSecurityCode($security_code);
      }
      if (isset($http_user_agent)) {
          $request_data->setHttpUserAgent($http_user_agent);
      }
      if (isset($http_accept)) {
          $request_data->setHttpAccept($http_accept);
      }
      if (isset($redirection_url)) {
          $request_data->setRedirectionUri($redirection_url);
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
         $main_message = "<font color='#ff0000'><b>応答が取得できませんでした。</b></font>";
     //想定応答の取得
     } else {
         $page_title = NORMAL_PAGE_TITLE;

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

         // ログ
         $test_log = "<!-- PaymentMode[" . $payment_mode . "] : vResultCode=" . $txn_result_code . " -->";

         if (TXN_SUCCESS_CODE === $txn_status) {
             // 成功
             $response_html = $response_data->getResResponseContents();
             echo $response_html . $test_log;
             exit;
         } else {
             // エラーページ表示
             $html = createErrorPage($response_data);
             print $html . $test_log;
             exit;
         }
     }
 }
?>
 <?php

 function createErrorPage($response) {

 $html = '<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="Content-Language" content="ja" />
  <title>エラーページ</title>
 <link href="../css/style.css" rel="stylesheet" type="text/css">
 </head>
 <body>
 <img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"><hr/>
 <div class="system-message">
 <font size="2">
 本画面はVeriTrans4G カード決済-3D認証有り(PayNowIDカード情報利用)サンプル画面です。<br/>
 お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
 </font>
 </div>
 <div class="lhtitle">カード決済与信(3D認証付き)：取引結果</div>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="rititletop">取引ID</td>
      <td class="rivaluetop">'.$response->getOrderId().'<br/></td>
    </tr>
    <tr>
      <td class="rititle">取引ステータス</td>
      <td class="rivalue">'.$response->getMStatus().'</td>
    </tr>
    <tr>
      <td class="rititle">結果コード</td>
      <td class="rivalue">'.$response->getVResultCode().'</td>
    </tr>
    <tr>
      <td class="rititle">結果メッセージ</td>
      <td class="rivalue">'.$response->getMerrMsg().'</td>
    </tr>
  </table><br>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved


 </body>
 </html>';

 return $html;
}

function createSystemErrorPage($response) {

 $html = '<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="Content-Language" content="ja" />
  <title>エラーページ</title>
 <link href="../css/style.css" rel="stylesheet" type="text/css">
 </head>
 <body>
 <img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"><hr/>
 <div class="system-message">
 <font size="2">
 本画面はVeriTrans4G カード決済-3D認証有り(PayNowIDカード情報利用)サンプル画面です。<br/>
 お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
 </font>
 </div>
 <div class="lhtitle">カード決済与信(3D認証付き)：取引結果</div>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="rititletop">取引ID</td>
      <td class="rivaluetop">'.$response->getOrderId().'<br/></td>
    </tr>
    <tr>
      <td class="rititle">取引ステータス</td>
      <td class="rivalue">'.$response->getMStatus().'</td>
    </tr>
    <tr>
      <td class="rititle">結果コード</td>
      <td class="rivalue">'.$response->getVResultCode().'</td>
    </tr>
    <tr>
      <td class="rititle">結果メッセージ</td>
      <td class="rivalue">'.$response->getMerrMsg().'</td>
    </tr>
  </table><br>
<a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body></html>';

 return $html;
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
本画面はVeriTrans4G カード決済-3D認証有り(PayNowIDカード情報利用)のサンプル画面です。<br/>
お客様ECサイトのVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>

<div class="lhtitle">カード決済-3D認証有り(PayNowIDカード情報利用)実行結果</div>
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
