<?php

# Copyright(C) 2013 VeriTrans Co., Ltd. All right reserved.

// -------------------------------------------------------------------------
// ショッピングクレジット決済画面表示実行サンプル
// -------------------------------------------------------------------------
define('MDK_DIR', '../tgMdk/');

define('RESULT_PAGE', 'Result.php');
define('INPUT_PAGE', 'Authorize.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

require_once(MDK_DIR."3GPSMDK.php");

/**
 * 設定ファイルから設定値を読み取り
 */
$config_file = "../env4sample.ini";
if (is_readable($config_file)) {
  $env_info = @parse_ini_file($config_file, true);
  $merchant_redirection_url = $env_info["ORICOSC"]["merchant_redirection_url.PC"];
}

/** 取引ID */
$order_id = @$_POST["orderId"];
/** 注文番号 */
$orico_order_no = @$_POST["oricoOrderNo"];
/** 会員番号(加盟店) */
$user_no = @$_POST["userNo"];
/** 商品名１ */
$item_name1 = @$_POST["itemName1"];
/** 数量１ */
$item_count1 = @$_POST["itemCount1"];
/** 商品価格１(税込) */
$item_amount1 = @$_POST["itemAmount1"];
/** 商品名２ */
$item_name2 = @$_POST["itemName2"];
/** 数量２ */
$item_count2 = @$_POST["itemCount2"];
/** 商品価格２(税込) */
$item_amount2 = @$_POST["itemAmount2"];
/** 商品名３ */
$item_name3 = @$_POST["itemName3"];
/** 数量３ */
$item_count3 = @$_POST["itemCount3"];
/** 商品価格３(税込) */
$item_amount3 = @$_POST["itemAmount3"];
/** 商品名４ */
$item_name4 = @$_POST["itemName4"];
/** 数量４ */
$item_count4 = @$_POST["itemCount4"];
/** 商品価格４(税込) */
$item_amount4 = @$_POST["itemAmount4"];
/** 商品名５ */
$item_name5 = @$_POST["itemName5"];
/** 数量５ */
$item_count5 = @$_POST["itemCount5"];
/** 商品価格５(税込) */
$item_amount5 = @$_POST["itemAmount5"];
/** 商品価格合計(税込) */
$total_item_amount = @$_POST["totalItemAmount"];
/** 送料合計(税込) */
$total_carriage = @$_POST["totalCarriage"];
/** 支払金額合計 */
$amount = @$_POST["amount"];
/** 頭金 */
$deposit = @$_POST["deposit"];
/** 配送先郵便番号 */
$shipping_zip_code = @$_POST["shippingZipCode"];
/** 取扱契約番号 */
$handling_contract_no = @$_POST["handlingContractNo"];
/** 契約書有無区分 */
$contract_document_kbn = @$_POST["contractDocumentKbn"];
/** WEB申込商品ID */
$web_description_id = @$_POST["webDescriptionId"];

// +++++++++++++++++++++++++++++++++++++++++++++++++++++
// 入力をチェックします。
// +++++++++++++++++++++++++++++++++++++++++++++++++++++
if (empty($order_id)){
    $warning =  "<font color='#ff0000'><b>必須項目：取引IDが指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($orico_order_no)) {
    $warning =  "<font color='#ff0000'><b>必須項目：注文番号が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($shipping_zip_code)) {
    $warning =  "<font color='#ff0000'><b>必須項目：配送先郵便番号が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($item_name1)) {
    $warning =  "<font color='#ff0000'><b>必須項目：商品名１が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($item_count1)) {
    $warning =  "<font color='#ff0000'><b>必須項目：数量１が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($item_amount1)) {
    $warning =  "<font color='#ff0000'><b>必須項目：商品価格１(税込)が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (!is_numeric($item_count1)) {
    $warning =  "<font color='#ff0000'><b>数量１は数値で入力しなければなりません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (!is_numeric($item_amount1)) {
    $warning =  "<font color='#ff0000'><b>商品価格１(税込)は数値で入力しなければなりません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($total_item_amount)) {
    $warning =  "<font color='#ff0000'><b>必須項目：商品価格合計(税込)が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (!is_numeric($total_item_amount)) {
    $warning =  "<font color='#ff0000'><b>商品価格合計(税込)は数値で入力しなければなりません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (empty($amount)) {
    $warning =  "<font color='#ff0000'><b>必須項目：支払金額合計が指定されていません</b></font>";
    include_once(INPUT_PAGE);
    exit();
} else if (!is_numeric($amount)) {
    $warning =  "<font color='#ff0000'><b>支払金額合計は数値で入力しなければなりません</b></font>";
    include_once(INPUT_PAGE);
    exit();
}

//商品２の整合性チェック
if (!empty($item_name2)) {
    if (empty($item_count2)) {
        $warning =  "<font color='#ff0000'><b>数量２が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
        } else if (empty($item_amount2)) {
        $warning =  "<font color='#ff0000'><b>商品価格２(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
} else if (!empty($item_count2)) {
    if (empty($item_name2)) {
        $warning =  "<font color='#ff0000'><b>商品名２が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_amount2)) {
        $warning =  "<font color='#ff0000'><b>商品価格２(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
} else if (!empty($item_amount2)) {
    if (empty($item_name2)) {
        $warning =  "<font color='#ff0000'><b>商品名２が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_count2)) {
        $warning =  "<font color='#ff0000'><b>数量２(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
}

// 商品３の整合性チェック
if (!empty($item_name3)) {
    if (empty($item_count3)) {
        $warning =  "<font color='#ff0000'><b>数量３が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_amount3)) {
        $warning =  "<font color='#ff0000'><b>商品価格３(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
} else if (!empty($item_count3)) {
    if (empty($item_name3)) {
        $warning =  "<font color='#ff0000'><b>商品名３が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_amount3)) {
        $warning =  "<font color='#ff0000'><b>商品価格３(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
} else if (!empty($item_amount3)) {
    if (empty($item_name3)) {
        $warning =  "<font color='#ff0000'><b>商品名３が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_count3)) {
        $warning =  "<font color='#ff0000'><b>数量３(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
}

// 商品４の整合性チェック
if (!empty($item_name4)) {
    if (empty($item_count4)) {
        $warning =  "<font color='#ff0000'><b>数量４が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_amount4)) {
        $warning =  "<font color='#ff0000'><b>商品価格４(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
} else if (!empty($item_count4)) {
    if (empty($item_name4)) {
        $warning =  "<font color='#ff0000'><b>商品名４が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_amount4)) {
        $warning =  "<font color='#ff0000'><b>商品価格４(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
} else if (!empty($item_amount4)) {
    if (empty($item_name4)) {
        $warning =  "<font color='#ff0000'><b>商品名４が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_count4)) {
        $warning =  "<font color='#ff0000'><b>数量４(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
}

// 商品５の整合性チェック
if (!empty($item_name5)) {
    if (empty($item_count5)) {
        $warning =  "<font color='#ff0000'><b>数量５が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_amount5)) {
        $warning =  "<font color='#ff0000'><b>商品価格５(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
} else if (!empty($item_count5)) {
    if (empty($item_name5)) {
        $warning =  "<font color='#ff0000'><b>商品名５が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_amount5)) {
        $warning =  "<font color='#ff0000'><b>商品価格５(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
} else if (!empty($item_amount5)) {
    if (empty($item_name5)) {
        $warning =  "<font color='#ff0000'><b>商品名５が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    } else if (empty($item_count5)) {
        $warning =  "<font color='#ff0000'><b>数量５(税込)が指定されていません</b></font>";
        include_once(INPUT_PAGE);
        exit();
    }
}

/**
 * 要求電文パラメータ値の指定
 */
$request_data = new OricoscAuthorizeRequestDto();
// 取引ID
$request_data->setOrderId($order_id);
// 注文番号
$request_data->setOricoOrderNo($orico_order_no);
// 会員番号(加盟店)
$request_data->setUserNo($user_no);
// 商品名１
$request_data->setItemName1($item_name1);
// 数量１
$request_data->setItemCount1($item_count1);
// 商品価格１(税込)
$request_data->setItemAmount1($item_amount1);
// 商品名２
$request_data->setItemName2($item_name2);
// 数量２
$request_data->setItemCount2($item_count2);
// 商品価格２(税込)
$request_data->setItemAmount2($item_amount2);
// 商品名３
$request_data->setItemName3($item_name3);
// 数量３
$request_data->setItemCount3($item_count3);
// 商品価格３(税込)
$request_data->setItemAmount3($item_amount3);
// 商品名４
$request_data->setItemName4($item_name4);
// 数量４
$request_data->setItemCount4($item_count4);
// 商品価格４(税込)
$request_data->setItemAmount4($item_amount4);
// 商品名５
$request_data->setItemName5($item_name5);
// 数量５
$request_data->setItemCount5($item_count5);
// 商品価格５(税込)
$request_data->setItemAmount5($item_amount5);
// 商品価格合計(税込)
$request_data->setTotalItemAmount($total_item_amount);
// 送料合計(税込)
$request_data->setTotalCarriage($total_carriage);
// 支払金額合計
$request_data->setAmount($amount);
// 頭金
$request_data->setDeposit($deposit);
// 配送先郵便番号
$request_data->setShippingZipCode($shipping_zip_code);
// マーチャントリダイレクションURL
$request_data->setMerchantRedirectionUrl($merchant_redirection_url);
// 取扱契約番号
$request_data->setHandlingContractNo($handling_contract_no);
// 契約書有無区分
$request_data->setContractDocumentKbn($contract_document_kbn);
// WEB申込商品ID
$request_data->setWebDescriptionId($web_description_id);

/**
 * 実施
 */
$transaction = new TGMDK_Transaction();
$response_data = $transaction->execute($request_data);

/**
 * 処理結果コードが成功なら、実施した結果から取得した次の画面URLへリダイレクト
 */
$txn_status = $response_data->getMStatus();

if (TXN_SUCCESS_CODE === $txn_status) {
// 成功
  $entry_form = $response_data->getResResponseContents();
  // IEを使用時はHTTPレスポンスのContent-Typeに"Shift-JIS"を指定してください。
  // また、resResponseContentの文字エンコーディングを"SJIS"に変換してください。
  header("Content-type: text/html; charset=Shift_JIS");
  $entry_form = mb_convert_encoding($entry_form, "SJIS", "UTF-8");
  echo $entry_form;
  exit();
}
$processName     = htmlspecialchars("画面表示");
$_screen         = $_POST["_screen"];
$orderId         = htmlspecialchars($response_data->getOrderId());
$mStatus         = htmlspecialchars($txn_status);
$vResultCode     = htmlspecialchars($response_data->getVResultCode());
$mErrMsg         = htmlspecialchars($response_data->getMerrMsg());
include_once(RESULT_PAGE);
exit();
?>
