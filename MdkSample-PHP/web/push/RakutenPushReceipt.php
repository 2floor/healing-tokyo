<?php

/*
 * 楽天ID決済通知データ受取用サンプル
 */

# MDK配置ディレクトリ
define('MDK_DIR', '../tgMdk/');

# ファイル出力時のセパレータ定義
define('SEPARATOR', ",");
define('QUOTATION', "\"");

require_once(MDK_DIR."3GPSMDK.php");

# プッシュデータ保存ディレクトリ
$SAVE_PATH = '/tmp/test-push/';


# ログ出力オブジェクトを作成
$logger = TGMDK_Logger::getInstance();
$logger->info("楽天ID決済通知データ受取開始。");

# ベリトランスペイメントゲートウェイからの通知電文を取得
$headers = apache_request_headers();
foreach ($headers as $header => $value) {
    $logger->debug("$header: $value");
}

if($headers{'Content-Length'} <= 0){
    # 読み込めないので 500 を応答
    header("HTTP/1.0 500 Internal Server Error\r\n");
    header("Content-Type: text/html\r\n\r\n");
    exit;
}

$body = "";
$fp = fopen("php://input", "r");
if ($fp == FALSE) {
    $logger->error('通知データの受信に失敗しました。');
    # 読み込めないので 500 を応答
    header("HTTP/1.0 500 Internal Server Error\r\n");
    header("Content-Type: text/html\r\n\r\n");
    #echo ("<html><head><title>Input failed.</title></head>");
    #echo ("<body>Input failed.</body></html>");
    exit;
}

while (!feof($fp)) {
    $body .= fgets($fp);
}
fclose($fp);
$logger->debug("Body: $body");

# Content-HMAC を利用して電文の改竄チェックを行う
$hmac = $headers{'content-hmac'};
$logger->info("content-hmac: $hmac");
if (strlen($hmac) <= 0) {
    # Content-HMACがありません
    $logger->error('content-hmacがありません。');
    header("HTTP/1.0 500 Internal Server Error\r\n");
    header("Content-Type: text/html\r\n\r\n");
    exit;
}
if (!TGMDK_MerchantUtility::checkMessage($body, $hmac)) {
    $logger->error('通知データの検証に失敗しました。');
    # 改竄の疑いあり 500 を応答
    header("HTTP/1.0 500 Internal Server Error\r\n");
    header("Content-Type: text/html\r\n\r\n");
    #echo ("<html><head><title>HMAC failed.</title></head>");
    #echo ("<body>HMAC failed.</body></html>");
    exit;
}
$logger->info('通知データの検証に成功しました。');

# データを保存するファイル名を決定する
$file = $SAVE_PATH;
if (substr($file, -1, 1) != '/') $file .= '/';
$pushtime = $_POST['pushTime'];
$pushid = $_POST['pushId'];
$file .= 'Rakuten' . '-' . $pushtime . '-' . $pushid . '.csv';


# ファイルを開く
$fp = fopen($file, "a+");
if ($fp == FALSE) {
    $logger->error("$file が開けませんでした。");
    # ファイルが開けなかったので 500 を返す.
    header("HTTP/1.0 500 Internal Server Error\r\n");
    header("Content-Type: text/html\r\n\r\n");
    exit;
}

# CSV ファイルに書き込む
$number_of_notify = $_POST['numberOfNotify'];
$logger->info("通知CSVファイル($file)へ書込開始。");


for ($i = 0 ; $i < $number_of_notify ; $i++) {
    $index = sprintf("%04s", $i);
    # レコード文字列を生成
    $buf = "";

    # オーダーID
    $key = 'orderId' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # 楽天注文番号
    $key = 'rakutenOrderId' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # 通知種類
    $key = 'txnType' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # 発生時刻
    $key = 'txnTime' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # 結果コード
    $key = 'vResultCode' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # ステータス
    $key = 'mstatus' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # 残高
    $key = 'balance' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # 利用ポイント
    $key = 'usedPoint' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # 楽天APIエラーコード
    $key = 'rakutenApiErrorCode' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # 楽天取引エラーコード
    $key = 'rakutenOrderErrorCode' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;
    $buf .= SEPARATOR;

    # ダミーフラグ
    $key = 'dummy' . $index;
    $value = $_POST[$key];
    $buf .=  $value ;

    $buf .= "\n";

    # レコードを書き込む
    fwrite($fp, $buf);
}
fclose($fp);

$logger->info("通知CSVファイル($file)書込終了。");
$logger->info("通知処理終了。ベリトランスペイメントゲートウェイへ 200 OK を応答。");

# ダミーの HTML 文を出力
print "Content-type: text/html\r\n\r\n";
print "Push data Accepted.\n";

?>
