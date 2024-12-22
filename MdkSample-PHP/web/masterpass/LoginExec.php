<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// MasterPass決済（Login）の実行および結果画面のサンプル
// -------------------------------------------------------------------------

define('MDK_DIR', '../tgMdk/');

define('INPUT_PAGE', 'Login.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '取引結果');

require_once(MDK_DIR."3GPSMDK.php");
/**
 * 取引ID
 */
$order_id = @$_POST["orderId"];

/**
 * 合計金額
 */
$item_amount = @$_POST["itemAmount"];

/**
 * 商品番号
 */
$item_id = @$_POST["itemId"];

/**
 * 配送先抑止フラグ
 */
$is_suppress_shipping_address = @$_POST["suppressShippingAddress"];
if ("1" == $is_suppress_shipping_address) {
  $is_suppress_shipping_address = TRUE_FLAG_CODE;
} else {
  $is_suppress_shipping_address = FALSE_FLAG_CODE;
}

/**
 * 配送先許可エリア
 */
$shipping_location_profile = @$_POST["shippingLocationProfile"];

/**
 * 3Dセキュア
 */
$d3flag = FALSE_FLAG_CODE;

/**
 * 決済完了時URL
 */
$successUrl = @$_POST["successUrl"];

/**
 * 決済キャンセル時URL
 */
$cancelUrl = @$_POST["cancelUrl"];

/**
 * 決済エラー時URL
 */
$errorUrl = @$_POST["errorUrl"];
/**
 * 表示用商品説明1
 */
$description1 = @$_POST["description1"];

/**
 * 表示用商品数量1
 */
$quantity1 = @$_POST["quantity1"];

/**
 * 表示用商品金額1
 */
$value1 = @$_POST["value1"];

/**
 * 表示用商品イメージURL1
 */
$image_url1 = @$_POST["imageUrl1"];
if (empty($image_url1) == "true") {
  $image_url1 = "";
}

/**
 * 表示用商品説明2
 */
$description2 = @$_POST["description2"];

/**
 * 表示用商品数量2
 */
$quantity2 = @$_POST["quantity2"];

/**
 * 表示用商品金額2
 */
$value2 = @$_POST["value2"];

/**
 * 表示用商品イメージURL2
 */
$image_url2 = @$_POST["imageUrl2"];
if (empty($image_url2) == "true") {
  $image_url2 = "";
}

/**
 * 表示用商品説明3
 */
$description3 = @$_POST["description3"];

/**
 * 表示用商品数量3
 */
$quantity3 = @$_POST["quantity3"];
/**

 * 表示用商品金額3
 */
$value3 = @$_POST["value3"];

/**
 * 表示用商品イメージURL3
 */
$image_url3 = @$_POST["imageUrl3"];
if (empty($image_url3) == "true") {
  $image_url3 = "";
}

/**
 * 表示用商品説明4
 */
$description4 = @$_POST["description4"];

/**
 * 表示用商品数量4
 */
$quantity4 = @$_POST["quantity4"];

/**
 * 表示用商品金額4
 */
$value4 = @$_POST["value4"];

/**
 * 表示用商品イメージURL4
 */
$image_url4 = @$_POST["imageUrl4"];
if (empty($image_url4) == "true") {
  $image_url4 = "";
}

/**
 * 表示用商品説明5
 */
$description5 = @$_POST["description5"];

/**
 * 表示用商品数量5
 */
$quantity5 = @$_POST["quantity5"];

/**
 * 表示用商品金額5
 */
$value5 = @$_POST["value5"];

/**
 * 表示用商品イメージURL5
 */
$image_url5 = @$_POST["imageUrl5"];
if (empty($image_url5) == "true") {
  $image_url5 = "";
}

/**
 * 表示用商品説明6
 */
$description6 = @$_POST["description6"];

/**
 * 表示用商品数量6
 */
$quantity6 = @$_POST["quantity6"];

/**
 * 表示用商品金額6
 */
$value6 = @$_POST["value6"];

/**
 * 表示用商品イメージURL6
 */
$image_url6 = @$_POST["imageUrl6"];
if (empty($image_url6) == "true") {
  $image_url6 = "";
}

/**
 * 表示用商品説明7
 */
$description7 = @$_POST["description7"];

/**
 * 表示用商品数量7
 */
$quantity7 = @$_POST["quantity7"];

/**
 * 表示用商品金額7
 */
$value7 = @$_POST["value7"];

/**
 * 表示用商品イメージURL7
 */
$image_url7 = @$_POST["imageUrl7"];
if (empty($image_url7) == "true") {
  $image_url7 = "";
}

/**
 * 表示用商品説明8
 */
$description8 = @$_POST["description8"];

/**
 * 表示用商品数量8
 */
$quantity8 = @$_POST["quantity8"];

/**
 * 表示用商品金額8
 */
$value8 = @$_POST["value8"];

/**
 * 表示用商品イメージURL8
 */
$image_url8 = @$_POST["imageUrl8"];
if (empty($image_url8) == "true") {
  $image_url8 = "";
}

/**
 * 表示用商品説明9
 */
$description9 = @$_POST["description9"];

/**
 * 表示用商品数量9
 */
$quantity9 = @$_POST["quantity9"];

/**
 * 表示用商品金額9
 */
$value9 = @$_POST["value9"];

/**
 * 表示用商品イメージURL9
 */
$image_url9 = @$_POST["imageUrl9"];
if (empty($image_url9) == "true") {
  $image_url9 = "";
}

/**
 * 表示用商品説明10
 */
$description10 = @$_POST["description10"];

/**
 * 表示用商品数量10
 */
$quantity10 = @$_POST["quantity10"];

/**
 * 表示用商品金額10
 */
$value10 = @$_POST["value10"];

/**
 * 表示用商品イメージURL10
 */
$image_url10 = @$_POST["imageUrl10"];
if (empty($image_url10) == "true") {
  $image_url10 = "";
}


/**
 * 必須パラメータ値チェック
 */
//サーバ内部指定
if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>Unset Order Id<br>(必須項目：取引IDが指定されていません)</b></font>";
  include_once(INPUT_PAGE);
  exit;
//サーバ内部指定
} else if (empty($item_amount)) {
  $warning =  "<font color='#ff0000'><b>Unset Total Amount<br>(必須項目：合計金額が指定されていません)</b></font>";
  include_once(INPUT_PAGE);
  exit;
}


/**
 * 要求電文パラメータ値の指定
 */
$request_data = new MasterpassLoginRequestDto();

$request_data->setOrderId($order_id);
$request_data->setItemId($item_id);
$request_data->setItemAmount($item_amount);
$request_data->setSuppressShippingAddress($is_suppress_shipping_address);
$request_data->setShippingLocationProfile($shipping_location_profile);
$request_data->setSuccessUrl($successUrl);
$request_data->setCancelUrl($cancelUrl);
$request_data->setErrorUrl($errorUrl);
$request_data->setDescription1($description1);
$request_data->setQuantity1($quantity1);
$request_data->setValue1($value1);
$request_data->setImageUrl1($image_url1);
$request_data->setDescription2($description2);
$request_data->setQuantity2($quantity2);
$request_data->setValue2($value2);
$request_data->setImageUrl2($image_url2);
$request_data->setDescription3($description3);
$request_data->setQuantity3($quantity3);
$request_data->setValue3($value3);
$request_data->setImageUrl3($image_url3);
$request_data->setDescription4($description4);
$request_data->setQuantity4($quantity4);
$request_data->setValue4($value4);
$request_data->setImageUrl4($image_url4);
$request_data->setDescription5($description5);
$request_data->setQuantity5($quantity5);
$request_data->setValue5($value5);
$request_data->setImageUrl5($image_url5);
$request_data->setDescription6($description6);
$request_data->setQuantity6($quantity6);
$request_data->setValue6($value6);
$request_data->setImageUrl6($image_url6);
$request_data->setDescription7($description7);
$request_data->setQuantity7($quantity7);
$request_data->setValue7($value7);
$request_data->setImageUrl7($image_url7);
$request_data->setDescription8($description8);
$request_data->setQuantity8($quantity8);
$request_data->setValue8($value8);
$request_data->setImageUrl8($image_url8);
$request_data->setDescription9($description9);
$request_data->setQuantity9($quantity9);
$request_data->setValue9($value9);
$request_data->setImageUrl9($image_url9);
$request_data->setDescription10($description10);
$request_data->setQuantity10($quantity10);
$request_data->setValue10($value10);
$request_data->setImageUrl10($image_url10);

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

  // ログ
  $test_log = "<!-- vResultCode=" . $txn_result_code . " -->";


  if (TXN_SUCCESS_CODE === $txn_status) {
      // 成功
      $response_html = $response_data->getResponseContents();
      header("Content-type: text/html; charset=UTF-8");
      echo $response_html . $test_log;
      exit;
  } else {
      // エラーページ表示
      $html = createErrorPage($response_data);
      print $html . $test_log;
      exit;
  }
 }

 function createErrorPage($response) {

 $html = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>'.$page_title.'</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"><hr/>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G MasterPass決済の取引サンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
</font>
</div>


<div class="lhtitle">MasterPass Transaction Result<br/>(決済：取引結果)</div>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="rititletop">Order ID<br/>(取引ID)</td>
    <td class="rivaluetop">'.$response->getOrderId().'<br/></td>
  </tr>
  <tr>
    <td class="rititle">Status<br/>(取引ステータス)</td>
    <td class="rivalue">'.$response->getMStatus().'<br/></td>
  </tr>
  <tr>
    <td class="rititle">Code<br/>(結果コード)</td>
    <td class="rivalue">'.$response->getVResultCode().'<br/></td>
  </tr>
  <tr>
    <td class="rititle">Message<br/>(結果メッセージ)</td>
    <td class="rivalue">'.$response->getMerrMsg().'<br/></td>
  </tr>
</table>
<br/>

<a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

<hr>
<img alt="VeriTransロゴ" src="../WEB-IMG/VeriTransLogo_WH.png">&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body></html>';

 return $html;
}
?>
