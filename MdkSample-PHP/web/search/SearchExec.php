<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 検索実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR'   , '../tgMdk/');
define('INPUT_PAGE', 'Search.php');

require_once(MDK_DIR."3GPSMDK.php");

// 変数の初期化
$target_orderId = "";
$target_serviceTypeCd = "";
$target_orderStatus = "";
$transaction_command = "";
$transaction_mstatus = "";
$transaction_vResultCode = "";
$transaction_amount = "";
$em_amount = "";
$em_centerProcDatetime = "";
$cvs_amount = "";
$cvs_startDatetime = "";
$bank_amount = "";
$bank_startDatetime = "";
$card_requestCurrencyUnit = "";
$card_reqCardNumber = "";
$mpi_requestCurrencyUnit = "";
$mpi_reqCardNumber = "";
$paypal_invoiceId = "";
$paypal_amount = "";

// --------------------------------------------------------------
// 画面パラメータを取得します。
// --------------------------------------------------------------
// 共通項目
$requestId         = htmlspecialchars(@$_POST["requestId"]);       // リクエストID
$serviceTypeCdList = @$_POST["serviceTypeCd"];                     // 決済サービスタイプ
$orderId           = htmlspecialchars(@$_POST["orderId"]);         // 取引ID
$command           = @$_POST["command"];                           // コマンド
$mstatus           = @$_POST["mstatus"];                           // ステータスコード
$orderStatus       = @$_POST["orderStatus"];                       // オーダー決済状態
$txnDatatimeFrom   = htmlspecialchars(@$_POST["txnDatatimeFrom"]); // 取引日時 From
$txnDatatimeTo     = htmlspecialchars(@$_POST["txnDatatimeTo"]);   // 取引日時 To
$amountFrom        = htmlspecialchars(@$_POST["amountFrom"]);      // 金額 From
$amountTo          = htmlspecialchars(@$_POST["amountTo"]);        // 金額 To
$isNewerTxn        = @$_POST["isNewerTxn"];                        // 最新トランザクションのみ


// --------------------------------------------------------------
// 必須パラメータ値チェック
// --------------------------------------------------------------


// --------------------------------------------------------------
// 画面パラメータから新しいパラメータの型を生成します。
// --------------------------------------------------------------
// 取引日時の範囲指定パラメータを生成します。
$txnDatatimeRange = new SearchRange();
$txnDatatimeRange->setFrom($txnDatatimeFrom);
$txnDatatimeRange->setTo($txnDatatimeTo);
// 金額の範囲指定パラメータを生成します。
$amountRange = new SearchRange();
$amountRange->setFrom($amountFrom);
$amountRange->setTo($amountTo);


// --------------------------------------------------------------
// 要求DTOを生成し、値を設定します。
// --------------------------------------------------------------
// Commonパラメータクラスへのセット
$common_param = new CommonSearchParameter();
$common_param->setOrderId($orderId);
$common_param->setCommand($command);
$common_param->setMstatus($mstatus);
$common_param->setOrderStatus($orderStatus);
$common_param->setTxnDatetime($txnDatatimeRange);
$common_param->setAmount($amountRange);

// Searchパラメータクラスへのセット
$search_param = new SearchParameters();
$search_param->setCommon($common_param);


// --------------------------------------------------------------
// サービス固有項目のパラメータを設定します。
// --------------------------------------------------------------
// ========================================
// クレジットカード
// ========================================
if (checkService($serviceTypeCdList, "card")) {
  // サービス固有項目の画面パラメータを取得
  $card_dddTransactionId      = htmlspecialchars(@$_POST["card_dddTransactionId"]);      // 3d-xid

  // 設定
  $card_param = new CardSearchParameter();
  $card_param->setDddTransactionId($card_dddTransactionId);

  // 検索パラメータに設定
  $search_param->setCard($card_param);
}

// ========================================
// クレジットカード（3D認証有り）
// ========================================
if (checkService($serviceTypeCdList, "mpi")) {
  // サービス固有項目の画面パラメータを取得
  $mpi_res3dTransactionId     = htmlspecialchars(@$_POST["mpi_res3dTransactionId"]);     // 応答3DトランザクションID
  $mpi_res3dTransactionStatus = htmlspecialchars(@$_POST["mpi_res3dTransactionStatus"]); // 応答3Dトランザクションステータス
  $mpi_res3dEci               = htmlspecialchars(@$_POST["mpi_res3dEci"]);               // 応答3D ECI

  // 設定
  $mpi_param = new MpiSearchParameter();
  $mpi_param->setRes3dTransactionId($mpi_res3dTransactionId);
  $mpi_param->setRes3dTransactionStatus($mpi_res3dTransactionStatus);
  $mpi_param->setRes3dEci($mpi_res3dEci);

  // 検索パラメータに設定
  $search_param->setMpi($mpi_param);
}

// ========================================
// 電子マネー
// ========================================
if (checkService($serviceTypeCdList, "em")) {
  // サービス固有項目の画面パラメータを取得
  $em_emType               = @$_POST["em_emType"];                                 // 電子マネー種別
  $em_settlementLimitFrom  = htmlspecialchars(@$_POST["em_settlementLimitFrom"]);  // 支払/受取期限 From
  $em_settlementLimitTo    = htmlspecialchars(@$_POST["em_settlementLimitTo"]);    // 支払/受取期限 To
  $em_completeDatetimeFrom = htmlspecialchars(@$_POST["em_completeDatetimeFrom"]); // 支払完了日時 From
  $em_completeDatetimeTo   = htmlspecialchars(@$_POST["em_completeDatetimeTo"]);   // 支払完了日時 To
  $em_receiptNo            = htmlspecialchars(@$_POST["em_receiptNo"]);            // 受付番号

  // 支払/受取期限の範囲指定パラメータを生成
  $em_settlementLimitRange = new SearchRange();
  $em_settlementLimitRange->setFrom($em_settlementLimitFrom);
  $em_settlementLimitRange->setTo($em_settlementLimitTo);
  // 支払完了日時の範囲指定パラメータを生成
  $em_completeDatetimeRange = new SearchRange();
  $em_completeDatetimeRange->setFrom($em_completeDatetimeFrom);
  $em_completeDatetimeRange->setTo($em_completeDatetimeTo);

  // 設定
  $em_param = new EmSearchParameter();
  $em_param->setEmType($em_emType);
  $em_param->setSettlementLimit($em_settlementLimitRange);
  $em_param->setCompleteDatetime($em_completeDatetimeRange);
  $em_param->setReceiptNo($em_receiptNo);

  // 検索パラメータに設定
  $search_param->setEm($em_param);
}

// ========================================
// コンビニ
// ========================================
if (checkService($serviceTypeCdList, "cvs")) {
  // サービス固有項目の画面パラメータを取得
  $cvs_cvsType              = @$_POST["cvs_cvsType"];                                // コンビニタイプ
  $cvs_payLimitFrom         = htmlspecialchars(@$_POST["cvs_payLimitFrom"]);         // 支払期限 From
  $cvs_payLimitTo           = htmlspecialchars(@$_POST["cvs_payLimitTo"]);           // 支払期限 To
  $cvs_payLimitDatetimeFrom = htmlspecialchars(@$_POST["cvs_payLimitDatetimeFrom"]); // 支払期限日時 From
  $cvs_payLimitDatetimeTo   = htmlspecialchars(@$_POST["cvs_payLimitDatetimeTo"]);   // 支払期限日時 To
  $cvs_paidDatetimeFrom     = htmlspecialchars(@$_POST["cvs_paidDatetimeFrom"]);     // 入金受付日 From
  $cvs_paidDatetimeTo       = htmlspecialchars(@$_POST["cvs_paidDatetimeTo"]);       // 入金受付日 To

  // 支払期限の範囲指定パラメータを生成
  $cvs_payLimitRange = new SearchRange();
  $cvs_payLimitRange->setFrom($cvs_payLimitFrom);
  $cvs_payLimitRange->setTo($cvs_payLimitTo);
  // 支払期限日時の範囲指定パラメータを生成
  $cvs_payLimitDatetimeRange = new SearchRange();
  $cvs_payLimitDatetimeRange->setFrom($cvs_payLimitDatetimeFrom);
  $cvs_payLimitDatetimeRange->setTo($cvs_payLimitDatetimeTo);
  // 入金受付日の範囲指定パラメータを生成
  $cvs_paidDatetimeRange = new SearchRange();
  $cvs_paidDatetimeRange->setFrom($cvs_paidDatetimeFrom);
  $cvs_paidDatetimeRange->setTo($cvs_paidDatetimeTo);

  // 設定
  $cvs_param = new CvsSearchParameter();
  $cvs_param->setCvsType($cvs_cvsType);
  $cvs_param->setPayLimit($cvs_payLimitRange);
  $cvs_param->setPayLimitDatetime($cvs_payLimitDatetimeRange);
  $cvs_param->setPaidDatetime($cvs_paidDatetimeRange);

  // 検索パラメータに設定
  $search_param->setCvs($cvs_param);
}

// ========================================
// 銀行
// ========================================
if (checkService($serviceTypeCdList, "bank")) {
  // サービス固有項目の画面パラメータを取得
  $bank_payLimitFrom         = htmlspecialchars(@$_POST["bank_payLimitFrom"]);         // 支払期限 From
  $bank_payLimitTo           = htmlspecialchars(@$_POST["bank_payLimitTo"]);           // 支払期限 To
  $bank_receivedDatetimeFrom = htmlspecialchars(@$_POST["bank_receivedDatetimeFrom"]); // 収納日時 From
  $bank_receivedDatetimeTo   = htmlspecialchars(@$_POST["bank_receivedDatetimeTo"]);   // 収納日時 To
  $bank_shunoKikanNo         = htmlspecialchars(@$_POST["bank_shunoKikanNo"]);         // 収納機関番号
  $bank_shunoKigyoNo         = htmlspecialchars(@$_POST["bank_shunoKigyoNo"]);         // 収納企業コード
  $bank_customerNo           = htmlspecialchars(@$_POST["bank_customerNo"]);           // お客様番号
  $bank_confirmNo            = htmlspecialchars(@$_POST["bank_confirmNo"]);            // 確認番号

  // 支払期限の範囲指定パラメータを生成
  $bank_payLimitRange = new SearchRange();
  $bank_payLimitRange->setFrom($bank_payLimitFrom);
  $bank_payLimitRange->setTo($bank_payLimitTo);
  // 収納日時の範囲指定パラメータを生成
  $bank_receivedDatetimeRange = new SearchRange();
  $bank_receivedDatetimeRange->setFrom($bank_receivedDatetimeFrom);
  $bank_receivedDatetimeRange->setTo($bank_receivedDatetimeTo);

  // 設定
  $bank_param = new BankSearchParameter();
  $bank_param->setPayLimit($bank_payLimitRange);
  $bank_param->setReceivedDatetime($bank_receivedDatetimeRange);
  $bank_param->setShunoKikanNo($bank_shunoKikanNo);
  $bank_param->setShunoKigyoNo($bank_shunoKigyoNo);
  $bank_param->setCustomerNo($bank_customerNo);
  $bank_param->setConfirmNo($bank_confirmNo);

  // 検索パラメータに設定
  $search_param->setBank($bank_param);
}

// ========================================
// PayPal
// ========================================
if (checkService($serviceTypeCdList, "paypal")) {
  // サービス固有項目の画面パラメータを取得
  $paypal_paymentDatetimeFrom = htmlspecialchars(@$_POST["paypal_paymentDatetimeFrom"]); // 支払日時 From
  $paypal_paymentDatetimeTo   = htmlspecialchars(@$_POST["paypal_paymentDatetimeTo"]);   // 支払日時 To
  $paypal_invoiceId           = htmlspecialchars(@$_POST["paypal_invoiceId"]);           // 請求番号
  $paypal_payerId             = htmlspecialchars(@$_POST["paypal_payerId"]);             // 顧客番号

  // 支払日時の範囲指定パラメータを生成
  $paypal_paymentDatetimeRange = new SearchRange();
  $paypal_paymentDatetimeRange->setFrom($paypal_paymentDatetimeFrom);
  $paypal_paymentDatetimeRange->setTo($paypal_paymentDatetimeTo);

  // 設定
  $paypal_param = new PaypalSearchParameter();
  $paypal_param->setPaymentDatetime($paypal_paymentDatetimeRange);
  $paypal_param->setInvoiceId($paypal_invoiceId);
  $paypal_param->setPayerId($paypal_payerId);

  // 検索パラメータに設定
  $search_param->setPaypal($paypal_param);
}

// ========================================
// Saison
// ========================================
if (checkService($serviceTypeCdList, "saison")) {
  // サービス固有項目の画面パラメータを取得
  $saison_totalAmountFrom  = htmlspecialchars(@$_POST["saison_totalAmountFrom"]);  // 合計決済金額 From
  $saison_totalAmountTo    = htmlspecialchars(@$_POST["saison_totalAmountTo"]);    // 合計決済金額 To
  $saison_walletAmountFrom = htmlspecialchars(@$_POST["saison_walletAmountFrom"]); // ウォレット決済金額 From
  $saison_walletAmountTo   = htmlspecialchars(@$_POST["saison_walletAmountTo"]);   // ウォレット決済金額 To
  $saison_cardAmountFrom   = htmlspecialchars(@$_POST["saison_cardAmountFrom"]);   // カード決済金額 From
  $saison_cardAmountTo     = htmlspecialchars(@$_POST["saison_cardAmountTo"]);     // カード決済金額 To

  // 合計決済金額の範囲指定パラメータを生成
  $saison_totalAmountRange = new SearchRange();
  $saison_totalAmountRange->setFrom($saison_totalAmountFrom);
  $saison_totalAmountRange->setTo($saison_totalAmountTo);

  // ウォレット決済金額の範囲指定パラメータを生成
  $saison_walletAmountRange = new SearchRange();
  $saison_walletAmountRange->setFrom($saison_walletAmountFrom);
  $saison_walletAmountRange->setTo($saison_walletAmountTo);

  // カード決済金額の範囲指定パラメータを生成
  $saison_cardAmountRange = new SearchRange();
  $saison_cardAmountRange->setFrom($saison_cardAmountFrom);
  $saison_cardAmountRange->setTo($saison_cardAmountTo);

  // 設定
  $saison_param = new SaisonSearchParameter();
  $saison_param->setTotalAmount($saison_totalAmountRange);
  $saison_param->setWalletAmount($saison_walletAmountRange);
  $saison_param->setCardAmount($saison_cardAmountRange);

  // 検索パラメータに設定
  $search_param->setSaison($saison_param);
}

// ========================================
// UPOP
// ========================================
if (checkService($serviceTypeCdList, "upop")) {
  // サービス固有項目の画面パラメータを取得
  $upop_settleDatetimeJpFrom   = htmlspecialchars(@$_POST["upop_settleDatetimeJpFrom"]);   // 決済日時(日本) From
  $upop_settleDatetimeJpTo     = htmlspecialchars(@$_POST["upop_settleDatetimeJpTo"]);     // 決済日時(日本) To
  $upop_settleDatetimeCnFrom   = htmlspecialchars(@$_POST["upop_settleDatetimeCnFrom"]);   // 決済日時(中国) From
  $upop_settleDatetimeCnTo     = htmlspecialchars(@$_POST["upop_settleDatetimeCnTo"]);     // 決済日時(中国) To
  $upop_detailOrderType        = @$_POST["detailOrderType"];

  // 決済日時(日本)の範囲指定パラメータを生成(日本が指定されている場合は中国は入ってこない)
  $upop_settleDatetimeJpRange = new SearchRange();
  $upop_settleDatetimeJpRange->setFrom($upop_settleDatetimeJpFrom);
  $upop_settleDatetimeJpRange->setTo($upop_settleDatetimeJpTo);
  // 決済日時(中国)の範囲指定パラメータを生成(中国が指定されている場合は日本は入ってこない)
  $upop_settleDatetimeCnRange = new SearchRange();
  $upop_settleDatetimeCnRange->setFrom($upop_settleDatetimeCnFrom);
  $upop_settleDatetimeCnRange->setTo($upop_settleDatetimeCnTo);

  // 設定
  $upop_param = new UpopSearchParameter();
  $upop_param->setSettleDatetimeJp($upop_settleDatetimeJpRange);
  $upop_param->setSettleDatetimeCn($upop_settleDatetimeCnRange);
  $upop_param->setDetailOrderType($upop_detailOrderType);

  // 検索パラメータに設定
  $search_param->setUpop($upop_param);
}

// ========================================
// Alipay
// ========================================
if (checkService($serviceTypeCdList, "alipay")) {
  // サービス固有項目の画面パラメータを取得
  $alipay_centerTradeId      = htmlspecialchars(@$_POST["alipay_centerTradeId"]);        // 取引ID
  $alipay_paymentTimeFrom    = htmlspecialchars(@$_POST["alipay_paymentTimeFrom"]);      // 支払い日時　From
  $alipay_paymentTimeTo      = htmlspecialchars(@$_POST["alipay_paymentTimeTo"]);        // 支払い日時　To
  $alipay_settlementTimeFrom = htmlspecialchars(@$_POST["alipay_settlementTimeFrom"]);   // 清算日時　From
  $alipay_settlementTimeTo   = htmlspecialchars(@$_POST["alipay_settlementTimeTo"]);     // 清算日時　To
  $alipay_payType            = @$_POST["alipay_payType"];
  $alipay_detailOrderType    = @$_POST["alipayDetailOrderType"];

  // 支払い日時の範囲指定パラメータを生成
  $alipay_paymentTimeRange = new SearchRange();
  $alipay_paymentTimeRange->setFrom($alipay_paymentTimeFrom);
  $alipay_paymentTimeRange->setTo($alipay_paymentTimeTo);
  // 清算日時の範囲指定パラメータを生成
  $alipay_settlementTimeRange = new SearchRange();
  $alipay_settlementTimeRange->setFrom($alipay_settlementTimeFrom);
  $alipay_settlementTimeRange->setTo($alipay_settlementTimeTo);

  // 設定
  $alipay_param = new AlipaySearchParameter();
  $alipay_param->setCenterTradeId($alipay_centerTradeId);
  $alipay_param->setPaymentTime($alipay_paymentTimeRange);
  $alipay_param->setSettlementTime($alipay_settlementTimeRange);
  $alipay_param->setPayType($alipay_payType);
  $alipay_param->setDetailOrderType($alipay_detailOrderType);

  // 検索パラメータに設定
  $search_param->setAlipay($alipay_param);
}

// ========================================
// キャリア
// ========================================
if (checkService($serviceTypeCdList, "carrier")) {
  // サービス固有項目の画面パラメータを取得
  $carrier_detailOrderType      = @$_POST["carrier_detailOrderType"];                    // 詳細取引決済状態
  $carrier_crServiceType        = @$_POST["carrier_crServiceType"];                      // キャリアサービスタイプ
  $carrier_accountingType       = @$_POST["carrier_accountingType"];                     // 課金種別
  $carrier_itemType             = @$_POST["carrier_itemType"];                           // 商品タイプ
  $carrier_mpStatus             = @$_POST["carrier_mpStatus"];                           // 継続状態フラグ
  $carrier_terminalKind         = @$_POST["carrier_terminalKind"];                       // 端末種別
  $carrier_detailCommandType    = @$_POST["carrier_detailCommandType"];                  // 詳細コマンドタイプ
  $carrier_mpFirstDate          = htmlspecialchars(@$_POST["carrier_mpFirstDate"]);      // 初回課金年月日
  $carrier_mpDay                = htmlspecialchars(@$_POST["carrier_mpDay"]);            // 継続年月日
  $carrier_itemId               = htmlspecialchars(@$_POST["carrier_itemId"]);           // 商品番号

  // 設定
  $carrier_param = new CarrierSearchParameter();
  $carrier_param->setDetailOrderType($carrier_detailOrderType);
  $carrier_param->setCrServiceType($carrier_crServiceType);
  $carrier_param->setAccountingType($carrier_accountingType);
  $carrier_param->setItemType($carrier_itemType);
  $carrier_param->setMpStatus($carrier_mpStatus);
  $carrier_param->setTerminalKind($carrier_terminalKind);
  $carrier_param->setDetailCommandType($carrier_detailCommandType);
  $carrier_param->setMpFirstDate($carrier_mpFirstDate);
  $carrier_param->setMpFirstDate($carrier_mpDay);
  $carrier_param->setItemId($carrier_itemId);

  // 検索パラメータに設定
  $search_param->setCarrier($carrier_param);
}

// ========================================
// ショッピングクレジット
// ========================================
if (checkService($serviceTypeCdList, "oricosc")) {
  // サービス固有項目の画面パラメータを取得
  $oricosc_oricoOrderNo   = htmlspecialchars(@$_POST["oricosc_oricoOrderNo"]);             // 注文番号
  $oricosc_amountFrom  = htmlspecialchars(@$_POST["oricosc_amountFrom"]);                  // 支払金額合計 From
  $oricosc_amountTo    = htmlspecialchars(@$_POST["oricosc_amountTo"]);                    // 支払金額合計 To
  $oricosc_totalItemAmountFrom = htmlspecialchars(@$_POST["oricosc_totalItemAmountFrom"]); // 商品価格合計 From
  $oricosc_totalItemAmountTo   = htmlspecialchars(@$_POST["oricosc_totalItemAmountTo"]);   // 商品価格合計 To

  // 支払金額合計の範囲指定パラメータを生成
  $oricosc_amountRange = new SearchRange();
  $oricosc_amountRange->setFrom($oricosc_amountFrom);
  $oricosc_amountRange->setTo($oricosc_amountTo);

  // 商品価格合計の範囲指定パラメータを生成
  $oricosc_totalItemAmountRange = new SearchRange();
  $oricosc_totalItemAmountRange->setFrom($oricosc_totalItemAmountFrom);
  $oricosc_totalItemAmountRange->setTo($oricosc_totalItemAmountTo);

  // 設定
  $oricosc_param = new OricoscSearchParameter();
  $oricosc_param->setOricoOrderNo($oricosc_oricoOrderNo);
  $oricosc_param->setAmount($oricosc_amountRange);
  $oricosc_param->setTotalItemAmount($oricosc_totalItemAmountRange);

  // 検索パラメータに設定
  $search_param->setOricosc($oricosc_param);
}

// ========================================
// 楽天
// ========================================
if (checkService($serviceTypeCdList, "rakuten")) {
  // サービス固有項目の画面パラメータを取得
  $rakuten_detailOrderType      = @$_POST["rakuten_detailOrderType"];          // 詳細取引決済状態
  $rakuten_detailCommandType    = @$_POST["rakuten_detailCommandType"];        // 詳細コマンドタイプ
  $rakuten_itemId               = htmlspecialchars(@$_POST["rakuten_itemId"]); // 商品番号

  // 設定
  $rakuten_param = new RakutenSearchParameter();
  $rakuten_param->setDetailOrderType($rakuten_detailOrderType);
  $rakuten_param->setDetailCommandType($rakuten_detailCommandType);
  $rakuten_param->setItemId($rakuten_itemId);

  // 検索パラメータに設定
  $search_param->setRakuten($rakuten_param);
}

// ========================================
// リクルート
// ========================================
if (checkService($serviceTypeCdList, "recruit")) {
  // サービス固有項目の画面パラメータを取得
  $recruit_detailOrderType      = @$_POST["recruit_detailOrderType"];          // 詳細取引決済状態
  $recruit_detailCommandType    = @$_POST["recruit_detailCommandType"];        // 詳細コマンドタイプ
  $recruit_itemId               = htmlspecialchars(@$_POST["recruit_itemId"]); // 商品番号

  // 設定
  $recruit_param = new RecruitSearchParameter();
  $recruit_param->setDetailOrderType($recruit_detailOrderType);
  $recruit_param->setDetailCommandType($recruit_detailCommandType);
  $recruit_param->setItemId($recruit_itemId);

  // 検索パラメータに設定
  $search_param->setRecruit($recruit_param);
}

// ========================================
// LINE Pay
// ========================================
if (checkService($serviceTypeCdList, "linepay")) {
    // サービス固有項目の画面パラメータを取得
    $linepay_detailOrderType      = @$_POST["linepay_detailOrderType"];          // 詳細取引決済状態
    $linepay_detailCommandType    = @$_POST["linepay_detailCommandType"];        // 詳細コマンドタイプ
    $linepay_itemId               = htmlspecialchars(@$_POST["linepay_itemId"]); // 商品番号

    // 設定
    $linepay_param = new LinepaySearchParameter();
    $linepay_param->setDetailOrderType($linepay_detailOrderType);
    $linepay_param->setDetailCommandType($linepay_detailCommandType);
    $linepay_param->setItemId($linepay_itemId);

    // 検索パラメータに設定
    $search_param->setLinepay($linepay_param);
}

// ========================================
// MasterPass決済
// ========================================
if (checkService($serviceTypeCdList, "masterpass")) {
    // サービス固有項目の画面パラメータを取得
    $masterpass_detailOrderType      = @$_POST["masterpass_detailOrderType"];                // 詳細取引決済状態
    $masterpass_detailCommandType    = @$_POST["masterpass_detailCommandType"];              // 詳細コマンドタイプ
    $masterpass_itemId               = htmlspecialchars(@$_POST["masterpass_itemId"]);       // 商品番号
    $masterpass_acquirerCode         = htmlspecialchars(@$_POST["masterpass_acquirerCode"]); // 仕向け先コード

    // 設定
    $masterpass_param = new MasterpassSearchParameter();
    $masterpass_param->setDetailOrderType($masterpass_detailOrderType);
    $masterpass_param->setDetailCommandType($masterpass_detailCommandType);
    $masterpass_param->setItemId($masterpass_itemId);
    $masterpass_param->setAcquirerCode($masterpass_acquirerCode);

    // 検索パラメータに設定
    $search_param->setMasterpass($masterpass_param);
}

// ========================================
// 銀行振込
// ========================================
if (checkService($serviceTypeCdList, "virtualacc")) {
    // サービス固有項目の画面パラメータを取得
    $virtualacc_detailOrderType      = @$_POST["virtualacc_detailOrderType"];          // 詳細取引決済状態
    $virtualacc_detailCommandType    = @$_POST["virtualacc_detailCommandType"];        // 詳細コマンドタイプ
    $virtualacc_entryTransferName    = htmlspecialchars(@$_POST["virtualacc_entryTransferName"]); // 登録時振込人名
    $virtualacc_entryTransferNumber  = htmlspecialchars(@$_POST["virtualacc_entryTransferNumber"]); // 登録時振込番号
    $virtualacc_accountNumber        = htmlspecialchars(@$_POST["virtualacc_accountNumber"]); // 口座番号

    // 設定
    $virtualacc_param = new VirtualaccSearchParameter();
    $virtualacc_param->setDetailOrderType($virtualacc_detailOrderType);
    $virtualacc_param->setDetailCommandType($virtualacc_detailCommandType);
    $virtualacc_param->setEntryTransferName($virtualacc_entryTransferName);
    $virtualacc_param->setEntryTransferNumber($virtualacc_entryTransferNumber);
    $virtualacc_param->setAccountNumber($virtualacc_accountNumber);

    // 検索パラメータに設定
    $search_param->setVirtualacc($virtualacc_param);
}

// 検索DTOへパラメータクラスをセット
if (isset($isNewerTxn) && $isNewerTxn === "true") {
    $isNewerTxn = "true";
} else {
    $isNewerTxn = "false";
}
$request_data = new SearchRequestDto();
$request_data->setRequestId($requestId);             // リクエストID
$request_data->setNewerFlag($isNewerTxn);            // 商品に紐付く最後の取引のみ対象にするかを示す
$request_data->setContainDummyFlag("1");             // 検索対象にダミー決済のレコードを含めるかを示す
$request_data->setServiceTypeCd($serviceTypeCdList); // 検索対象のサービスタイプを示す
$request_data->setSearchParameters($search_param);   // 各機能の固有条件

// --------------------------------------------------------------
// コマンドを実行し、応答DTOを取得します。
// --------------------------------------------------------------
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);


// --------------------------------------------------------------
// 結果画面に表示します。
// --------------------------------------------------------------
// 処理結果メッセージを設定
$warning = $response_data->getMerrMsg();

// 配列データを設定
$order_infos = $response_data->getOrderInfos();
if (empty($order_infos) == false && $order_infos instanceof OrderInfos) {
  $order_info = $order_infos->getOrderInfo();
}


/**
 * 検索対象の決済サービスタイプであるかをチェックする。
 */
function checkService($serviceTypeCdList, $target) {
  if (isset($serviceTypeCdList) && empty($serviceTypeCdList) == false) {
    foreach($serviceTypeCdList as $serviceType) {
      if ($serviceType == $target) {
        return true;
      }
    }
  }
  return false;
}
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="ja" />
    <title>取引検索結果</title>
  <link href="../css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
  <img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"/><hr/>
  <div class="system-message">
    <font size="2">
    本画面はVeriTrans4G 取引検索のサンプル画面です。<br/>
    お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
    </font>
  </div>
<?php
  if (empty($warning) == false) {
    echo "<font color='#ff0000' size='2'><b>$warning</b></font><br/><br/>";
  }
?>
  <div class="lhtitle">検索結果</div>
  <table border="1" cellpadding="0" cellspacing="0">
    <tr bgcolor="#ffeebb">
      <th class="rititle2" nowrap colspan="3" rowspan="2">オーダー情報</th>
      <th class="rititle2" nowrap colspan="4" rowspan="2">決済トランザクション情報</th>
      <th class="rititle2" nowrap colspan="47">サービス固有項目</th>
    </tr>
    <tr bgcolor="#ffeebb">
      <th class="rititle2" nowrap colspan="2">電子マネー</th>
      <th class="rititle2" nowrap colspan="2">コンビニ</th>
      <th class="rititle2" nowrap colspan="2">銀行</th>
      <th class="rititle2" nowrap colspan="2">クレジットカード</th>
      <th class="rititle2" nowrap colspan="2">クレジットカード（MPI）</th>
      <th class="rititle2" nowrap colspan="2">PayPal</th>
      <th class="rititle2" nowrap colspan="2">永久不滅ポイント(永久不滅ウォレット)</th>
      <th class="rititle2" nowrap colspan="6">銀聯ネット決済(UPOP)</th>
      <th class="rititle2" nowrap colspan="7">Alipay</th>
      <th class="rititle2" nowrap colspan="3">キャリア</th>
      <th class="rititle2" nowrap colspan="2">ショッピングクレジット</th>
      <th class="rititle2" nowrap colspan="4">楽天ID決済</th>
      <th class="rititle2" nowrap colspan="3">リクルートかんたん支払い</th>
      <th class="rititle2" nowrap colspan="3">LINE Pay</th>
      <th class="rititle2" nowrap colspan="2">MasterPass決済</th>
      <th class="rititle2" nowrap colspan="3">銀行振込決済</th>
    </tr>
    <tr bgcolor="#ffeebb">
      <!-- オーダー情報 -->
      <th class="rititle2" nowrap>取引ID</th>
      <th class="rititle2" nowrap>決済サービスタイプ</th>
      <th class="rititle2" nowrap>オーダー決済状態</th>

      <!-- 決済トランザクション情報 -->
      <th class="rititle2" nowrap>コマンド</th>
      <th class="rititle2" nowrap>ステータスコード</th>
      <th class="rititle2" nowrap>結果コード</th>
      <th class="rititle2" nowrap>金額</th>

      <!-- 電子マネー -->
      <th class="rititle2" nowrap>決済金額</th>
      <th class="rititle2" nowrap>取引日時</th>

      <!-- コンビニ -->
      <th class="rititle2" nowrap>決済金額</th>
      <th class="rititle2" nowrap>取引日時</th>

      <!-- 銀行 -->
      <th class="rititle2" nowrap>金額</th>
      <th class="rititle2" nowrap>取引日時</th>

      <!-- クレジットカード -->
      <th class="rititle2" nowrap>要求通貨単位</th>
      <th class="rititle2" nowrap>要求カード番号</th>

      <!-- クレジットカード（MPI） -->
      <th class="rititle2" nowrap>要求通貨単位</th>
      <th class="rititle2" nowrap>要求カード番号</th>

      <!-- PayPal -->
      <th class="rititle2" nowrap>請求番号</th>
      <th class="rititle2" nowrap>金額</th>

      <!-- 永久不滅ポイント -->
      <th class="rititle2" nowrap>ウォレット決済金額</th>
      <th class="rititle2" nowrap>永久不滅ウォレット残高</th>

      <!-- UPOP -->
      <th class="rititle2" nowrap>清算金額</th>
      <th class="rititle2" nowrap>清算日付</th>
      <th class="rititle2" nowrap>清算通貨</th>
      <th class="rititle2" nowrap>為替日付</th>
      <th class="rititle2" nowrap>清算レート</th>
      <th class="rititle2" nowrap>決済センターとの取引ID</th>

      <!-- Alipay -->
      <th class="rititle2" nowrap>決済センターとの取引ID</th>
      <th class="rititle2" nowrap>詳細コマンドタイプ</th>
      <th class="rititle2" nowrap>清算金額</th>
      <th class="rititle2" nowrap>清算通貨</th>
      <th class="rititle2" nowrap>支払い日付</th>
      <th class="rititle2" nowrap>清算日付</th>
      <th class="rititle2" nowrap>決済種別</th>

      <!-- キャリア -->
      <th class="rititle2" nowrap>キャリア結果コード</th>
      <th class="rititle2" nowrap>キャリアへの要求日時</th>
      <th class="rititle2" nowrap>キャリアからの返戻日時</th>

      <!-- ショッピングクレジット -->
      <th class="rititle2" nowrap>商品価格合計</th>
      <th class="rititle2" nowrap>審査結果コード</th>

      <!-- 楽天 -->
      <th class="rititle2" nowrap>楽天APIエラーコード</th>
      <th class="rititle2" nowrap>楽天取引エラーコード</th>
      <th class="rititle2" nowrap>楽天への要求日時</th>
      <th class="rititle2" nowrap>楽天からの返戻日時</th>

      <!-- リクルート -->
      <th class="rititle2" nowrap>リクルートエラーコード</th>
      <th class="rititle2" nowrap>リクルートへの要求日時</th>
      <th class="rititle2" nowrap>リクルートからの返戻日時</th>
      
      <!-- LINE Pay -->
      <th class="rititle2" nowrap>LINE Payエラーコード</th>
      <th class="rititle2" nowrap>LINE Payへの要求日時</th>
      <th class="rititle2" nowrap>LINE Payからの返戻日時</th>

      <!-- MasterPass -->
      <th class="rititle2" nowrap>MasterPassへの要求日時</th>
      <th class="rititle2" nowrap>MasterPassからの返戻日時</th>
      
      <!-- 銀行振込 -->
      <th class="rititle2" nowrap>入金総額</th>
      <th class="rititle2" nowrap>登録時振込番号</th>
      <th class="rititle2" nowrap>入金日</th>
    </tr>
<?php
  if (isset($order_info)) {
    foreach ($order_info as $target) {
      $target_orderId       = $target->getOrderId();       // オーダーID
      $target_serviceTypeCd = $target->getServiceTypeCd(); // 決済サービスタイプ
      $target_orderStatus   = $target->getOrderStatus();   // オーダー決済状態

      $transactionInfos = $target->getTransactionInfos();
      $transactionInfo  = $transactionInfos->getTransactionInfo();

      $properOrderInfo = $target->getProperOrderInfo();
      if (isset($transactionInfo) && 0 < count($transactionInfo)) {
        $properTransactionInfo   = $transactionInfo[0]->getProperTransactionInfo();

        $transaction_command     = $transactionInfo[0]->getCommand();     // コマンド
        $transaction_mstatus     = $transactionInfo[0]->getMstatus();     // ステータスコード
        $transaction_vResultCode = $transactionInfo[0]->getVResultCode(); // 結果コード
        $transaction_amount      = $transactionInfo[0]->getAmount();      // 金額
      }

      // サービス固有項目
      $em_amount                      = "";
      $em_centerProcDatetime          = "";
      $cvs_amount                     = "";
      $cvs_startDatetime              = "";
      $bank_amount                    = "";
      $bank_startDatetime             = "";
      $card_requestCurrencyUnit       = "";
      $card_reqCardNumber             = "";
      $mpi_requestCurrencyUnit        = "";
      $mpi_reqCardNumber              = "";
      $paypal_invoiceId               = "";
      $paypal_amount                  = "";
      $saison_walletAmount            = "";
      $saison_aqAqfWalletBalance      = "";
      $upop_settle_amount             = "";
      $upop_settle_date               = "";
      $upop_settle_currency           = "";
      $upop_exchangedate              = "";
      $upop_exchangerate              = "";
      $upop_order_id                  = "";
      $alipay_center_trade_id         = "";
      $alipay_txn_type                = "";
      $alipay_settle_amount           = "";
      $alipay_settle_currency         = "";
      $alipay_payment_time            = "";
      $alipay_settlement_time         = "";
      $alipay_pay_type                = "";
      $carrier_crResultCode           = "";
      $carrier_crRequestDatetime      = "";
      $carrier_crResponseDatetime     = "";
      $oricosc_totalItemAmount        = "";
      $oricosc_orderStateCode         = "";
      $rakuten_apiErrorCode           = "";
      $rakuten_orderErrorCode         = "";
      $rakuten_requestDatetime        = "";
      $rakuten_responseDatetime       = "";
      $recruit_errorCode              = "";
      $recruit_requestDatetime        = "";
      $recruit_responseDatetime       = "";
      $linepay_errorCode              = "";
      $linepay_requestDatetime        = "";
      $linepay_responseDatetime       = "";
      $masterpass_requestDatetime     = "";
      $masterpass_responseDatetime    = "";
      $virtualacc_totalDepositAmount  = "";
      $virtualacc_entryTransferNumber = "";
      $virtualacc_depositDate         = "";

      // 電子マネー
      if ($target_serviceTypeCd == "em") {
        if (isset($properOrderInfo)) {
          $em_amount = $properOrderInfo->getAmount(); // オーダー情報 : 決済金額
        }
        if (isset($properTransactionInfo)) {
          $em_centerProcDatetime = $properTransactionInfo->getCenterProcDatetime(); // トランザクション情報 : 取引日時
        }
      }

      // コンビニ
      if ($target_serviceTypeCd == "cvs") {
        if (isset($properOrderInfo)) {
          $cvs_amount = $properOrderInfo->getAmount(); // オーダー情報 : 決済金額
        }
        if (isset($properTransactionInfo)) {
          $cvs_startDatetime = $properTransactionInfo->getStartDatetime(); // トランザクション情報 : 取引日時
        }
      }

      // 銀行
      if ($target_serviceTypeCd == "bank") {
        if (isset($properOrderInfo)) {
          $bank_amount = $properOrderInfo->getAmount(); // オーダー情報 : 金額
        }
        if (isset($properTransactionInfo)) {
          $bank_startDatetime = $properTransactionInfo->getStartDatetime(); // トランザクション情報 : 取引日時
        }
      }

      // クレジットカード
      if ($target_serviceTypeCd == "card") {
        if (isset($properOrderInfo)) {
          $card_requestCurrencyUnit = $properOrderInfo->getRequestCurrencyUnit(); // オーダー情報 : 要求通貨単位
        }
        if (isset($properTransactionInfo)) {
          $card_reqCardNumber = $properTransactionInfo->getReqCardNumber(); // トランザクション情報 : 要求カード番号
        }
      }

      // クレジットカード（MPI）
      if ($target_serviceTypeCd == "mpi") {
        if (isset($properOrderInfo)) {
          $mpi_requestCurrencyUnit = $properOrderInfo->getRequestCurrencyUnit(); // オーダー情報 : 要求通貨単位
        }
        if (isset($properTransactionInfo)) {
          $mpi_reqCardNumber = $properTransactionInfo->getReqCardNumber(); // トランザクション情報 : 要求カード番号
        }
      }

      // PayPal
      if ($target_serviceTypeCd == "paypal") {
        if (isset($properOrderInfo)) {
          $paypal_invoiceId = $properOrderInfo->getInvoiceId(); // オーダー情報 : 請求番号
        }
        if (isset($properTransactionInfo)) {
          $paypal_amount = $properTransactionInfo->getAmount(); // トランザクション情報 : 金額
        }
      }

      // Saison
      if ($target_serviceTypeCd == "saison") {
        if (isset($properOrderInfo)) {
          $saison_walletAmount = $properOrderInfo->getWalletAmount(); // オーダー情報 : ウォレット決済金額
        }
        if (isset($properTransactionInfo)) {
          $saison_aqAqfWalletBalance = $properTransactionInfo->getAqAqfWalletBalance(); // トランザクション情報 : 永久不滅ウォレット残高
        }
      }

      // UPOP
      if ($target_serviceTypeCd == "upop") {
        if (isset($properTransactionInfo)) {
          $upop_settle_amount = $properTransactionInfo->getResUpopSettleAmount();
          $upop_settle_date =  $properTransactionInfo->getResUpopSettleDate();
          $upop_settle_currency= $properTransactionInfo->getResUpopSettleCurrency();
          $upop_exchangedate =$properTransactionInfo->getResUpopExchangeDate();
          $upop_exchangerate =$properTransactionInfo->getResUpopExchangeRate();
          $upop_order_id = $properTransactionInfo->getResUpopOrderId();
        }
      }

      // Alipay
      if ($target_serviceTypeCd == "alipay") {
        if (isset($properTransactionInfo)) {
          $alipay_center_trade_id = $properTransactionInfo->getCenterTradeId();
          $alipay_txn_type = $properTransactionInfo->getAlipayTxnType();
          $alipay_settle_amount = $properTransactionInfo->getSettleAmount();
          $alipay_settle_currency =  $properTransactionInfo->getSettleCurrency();
          $alipay_payment_time = $properTransactionInfo->getPaymentTime();
          $alipay_settlement_time = $properTransactionInfo->getSettlementTime();
          $alipay_pay_type = $properTransactionInfo->getPayType();
        }
      }

      // Carrier
      if ($target_serviceTypeCd == "carrier") {
        if (isset($properTransactionInfo)) {
           $carrier_crResultCode = $properTransactionInfo->getCrResultCode();
           $carrier_crRequestDatetime = $properTransactionInfo->getCrRequestDatetime();
           $carrier_crResponseDatetime = $properTransactionInfo->getCrResponseDatetime();
        }
      }

      // ショッピングクレジット
      if ($target_serviceTypeCd == "oricosc") {
        if (isset($properOrderInfo)) {
            $oricosc_totalItemAmount = $properOrderInfo->getTotalItemAmount();
        }
        if (isset($properTransactionInfo)) {
            $oricosc_orderStateCode = $properTransactionInfo->getOrderStateCode();
        }
      }

      // 楽天
      if ($target_serviceTypeCd == "rakuten") {
        if (isset($properTransactionInfo) && $properTransactionInfo instanceof ProperTransactionInfo) {
            $rakuten_apiErrorCode = $properTransactionInfo->getRakutenApiErrorCode();
            $rakuten_orderErrorCode = $properTransactionInfo->getRakutenOrderErrorCode();
            $rakuten_requestDatetime = $properTransactionInfo->getRakutenRequestDatetime();
            $rakuten_responseDatetime = $properTransactionInfo->getRakutenResponseDatetime();
        }
      }

      // リクルート
      if ($target_serviceTypeCd == "recruit") {
        if (isset($properTransactionInfo) && $properTransactionInfo instanceof ProperTransactionInfo) {
            $recruit_errorCode = $properTransactionInfo->getRecruitErrorCode();
            $recruit_requestDatetime = $properTransactionInfo->getRecruitRequestDatetime();
            $recruit_responseDatetime = $properTransactionInfo->getRecruitResponseDatetime();
        }
      }
      
      // LINE Pay
      if ($target_serviceTypeCd == "linepay") {
        if (isset($properTransactionInfo) && $properTransactionInfo instanceof ProperTransactionInfo) {
            $linepay_errorCode = $properTransactionInfo->getLinepayErrorCode();
            $linepay_requestDatetime = $properTransactionInfo->getLinepayRequestDatetime();
            $linepay_responseDatetime = $properTransactionInfo->getLinepayResponseDatetime();
        }
      }
      
      // MasterPass
      if ($target_serviceTypeCd == "masterpass") {
        if (isset($properTransactionInfo) && $properTransactionInfo instanceof ProperTransactionInfo) {
            $masterpass_requestDatetime = $properTransactionInfo->getMasterpassRequestDatetime();
            $masterpass_responseDatetime = $properTransactionInfo->getMasterpassResponseDatetime();
        }
      }
      
      // 銀行振込
      if ($target_serviceTypeCd == "virtualacc") {
        if (isset($properOrderInfo) && $properOrderInfo instanceof ProperOrderInfo) {
            $virtualacc_totalDepositAmount = $properOrderInfo->getTotalDepositAmount();
            $virtualacc_entryTransferNumber = $properOrderInfo->getEntryTransferNumber();
            $virtualacc_depositDate = $properTransactionInfo->getDepositDate();
        }
      }
?>
    <tr>
      <!-- オーダー情報 -->
<?php if ($target_serviceTypeCd == "carrier") { ?>
      <td class="rivalue2" nowrap><a href="./carrier/SearchExec.php?orderId=<?php echo $target_orderId ?>"><?php echo $target_orderId ?></a><br/></td>
<?php } else if ($target_serviceTypeCd == "rakuten") { ?>
      <td class="rivalue2" nowrap><a href="./rakuten/SearchExec.php?orderId=<?php echo $target_orderId ?>"><?php echo $target_orderId ?></a><br/></td>
<?php } else if ($target_serviceTypeCd == "recruit") { ?>
      <td class="rivalue2" nowrap><a href="./recruit/SearchExec.php?orderId=<?php echo $target_orderId ?>"><?php echo $target_orderId ?></a><br/></td>
<?php } else if ($target_serviceTypeCd == "linepay") { ?>
      <td class="rivalue2" nowrap><a href="./linepay/SearchExec.php?orderId=<?php echo $target_orderId ?>"><?php echo $target_orderId ?></a><br/></td>
<?php } else if ($target_serviceTypeCd == "masterpass") { ?>
      <td class="rivalue2" nowrap><a href="./masterpass/SearchExec.php?orderId=<?php echo $target_orderId ?>"><?php echo $target_orderId ?></a><br/></td>
<?php } else if ($target_serviceTypeCd == "virtualacc") { ?>
      <td class="rivalue2" nowrap><a href="./virtualacc/SearchExec.php?orderId=<?php echo $target_orderId ?>"><?php echo $target_orderId ?></a><br/></td>
<?php } else if ($target_serviceTypeCd == "alipay") { ?>
      <td class="rivalue2" nowrap><a href="./alipay/SearchExec.php?orderId=<?php echo $target_orderId ?>"><?php echo $target_orderId ?></a><br/></td>
<?php } else if ($target_serviceTypeCd == "upop") { ?>
      <td class="rivalue2" nowrap><a href="./upop/SearchExec.php?orderId=<?php echo $target_orderId ?>"><?php echo $target_orderId ?></a><br/></td>
<?php } else { ?>
      <td class="rivalue2" nowrap><?php echo $target_orderId ?><br/></td>
<?php } ?>
      <td class="rivalue2" nowrap><?php echo $target_serviceTypeCd ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $target_orderStatus ?><br/></td>

      <!-- 決済トランザクション情報 -->
      <td class="rivalue2" nowrap><?php echo $transaction_command ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $transaction_mstatus ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $transaction_vResultCode ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $transaction_amount ?><br/></td>

      <!-- 電子マネー -->
      <td class="rivalue2" nowrap><?php echo $em_amount ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $em_centerProcDatetime ?><br/></td>

      <!-- コンビニ -->
      <td class="rivalue2" nowrap><?php echo $cvs_amount ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $cvs_startDatetime ?><br/></td>

      <!-- 銀行 -->
      <td class="rivalue2" nowrap><?php echo $bank_amount ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $bank_startDatetime ?><br/></td>

      <!-- クレジットカード -->
      <td class="rivalue2" nowrap><?php echo $card_requestCurrencyUnit ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $card_reqCardNumber ?><br/></td>

      <!-- クレジットカード（MPI） -->
      <td class="rivalue2" nowrap><?php echo $mpi_requestCurrencyUnit ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $mpi_reqCardNumber ?><br/></td>

      <!-- PayPal -->
      <td class="rivalue2" nowrap><?php echo $paypal_invoiceId ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $paypal_amount ?><br/></td>

      <!-- 永久不滅ポイント(永久不滅ウォレット) -->
      <td class="rivalue2" nowrap><?php echo $saison_walletAmount ?><br/></td>
      <td class="rivalue2" nowrap><?php echo $saison_aqAqfWalletBalance ?><br/></td>

      <!-- UPOP -->
      <td class="rivalue2" nowrap><?php echo $upop_settle_amount ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $upop_settle_date ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $upop_settle_currency ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $upop_exchangedate ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $upop_exchangerate ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $upop_order_id ?><br /></td>

      <!-- Alipay -->
      <td class="rivalue2" nowrap><?php echo $alipay_center_trade_id ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $alipay_txn_type ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $alipay_settle_amount ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $alipay_settle_currency ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $alipay_payment_time ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $alipay_settlement_time ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $alipay_pay_type ?><br /></td>

      <!-- Carrier -->
      <td class="rivalue2" nowrap><?php echo $carrier_crResultCode ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $carrier_crRequestDatetime ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $carrier_crResponseDatetime ?><br /></td>

      <!-- ショッピングクレジット -->
      <td class="rivalue2" nowrap><?php echo $oricosc_totalItemAmount ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $oricosc_orderStateCode ?><br /></td>

      <!-- 楽天 -->
      <td class="rivalue2" nowrap><?php echo $rakuten_apiErrorCode ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $rakuten_orderErrorCode ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $rakuten_requestDatetime ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $rakuten_responseDatetime ?><br /></td>

      <!-- リクルート -->
      <td class="rivalue2" nowrap><?php echo $recruit_errorCode ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $recruit_requestDatetime ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $recruit_responseDatetime ?><br /></td>
    
      <!-- LINE Pay -->
      <td class="rivalue2" nowrap><?php echo $linepay_errorCode ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $linepay_requestDatetime ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $linepay_responseDatetime ?><br /></td>
    
      <!-- MasterPass決済 -->
      <td class="rivalue2" nowrap><?php echo $masterpass_requestDatetime ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $masterpass_responseDatetime ?><br /></td>
      
      <!-- 銀行振込 -->
      <td class="rivalue2" nowrap><?php echo $virtualacc_totalDepositAmount ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $virtualacc_entryTransferNumber ?><br /></td>
      <td class="rivalue2" nowrap><?php echo $virtualacc_depositDate ?><br /></td>
    </tr>
<?php
    }
  }
?>
  </table>

  <br/>
  <a href="./Search.php">検索条件へ戻る</a>&nbsp;&nbsp;

  <hr>
  <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>
