<?php

/*
 * カード決済(3D認証付き)結果通知データ受取用サンプル
 */

# MDK配置ディレクトリ
define('MDK_DIR', '../tgMdk/');

# ファイル出力時のセパレータ定義
define('SEPARATOR', ",");
define('QUOTATION', "\"");

require_once(MDK_DIR."3GPSMDK.php");

# プッシュデータ保存ディレクトリ
$SAVE_PATH = '/tmp/';


# ログ出力オブジェクトを作成
$logger = TGMDK_Logger::getInstance();
$logger->info("カード決済(3D認証付き)結果通知データ受取開始。");

# ベリトランスペイメントゲートウェイからの入金通知電文を取得
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
    $logger->error('結果通知データの受信に失敗しました。');
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
    $logger->error('入金通知データの検証に失敗しました。');
    # 改竄の疑いあり 500 を応答
    header("HTTP/1.0 500 Internal Server Error\r\n");
    header("Content-Type: text/html\r\n\r\n");
    #echo ("<html><head><title>HMAC failed.</title></head>");
    #echo ("<body>HMAC failed.</body></html>");
    exit;
}
$logger->info('入金通知データの検証に成功しました。');

# データを保存するファイル名を決定する
$file = $SAVE_PATH;
if (substr($file, -1, 1) != '/') $file .= '/';
$pushtime = $_POST['pushTime'];
$pushid = $_POST['pushId'];
$file .= 'Mpi' . '-' . $pushtime . '-' . $pushid . '.csv';

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
$logger->info("入金通知CSVファイル($file)へ書込開始。");

for ($i = 0 ; $i < $number_of_notify ; $i++) {
    $index = sprintf("%04s", $i);

    # レコード文字列を生成
    $buf = "";

    # オーダーID
    $key = 'orderId' . $index;
    $value = $_POST[$key];
    $buf .= QUOTATION . $value . QUOTATION;
    $buf .= SEPARATOR;

    # 詳細結果コード
    $key = 'vResultCode' . $index;
    $value = $_POST[$key];
    $buf .= QUOTATION . $value . QUOTATION;
    $buf .= SEPARATOR;

    # トランザクションタイプ
    $key = 'txnType' . $index;
    $value = $_POST[$key];
    $buf .= QUOTATION . $value . QUOTATION;
    $buf .= SEPARATOR;

    # MPI結果コード
    $key = 'mpiMstatus' . $index;
    $value = $_POST[$key];
    $buf .= QUOTATION . $value . QUOTATION;
    $buf .= SEPARATOR;

    # カード結果コード
    $key = 'cardMstatus' . $index;
    $value = $_POST[$key];
    $buf .= QUOTATION . $value . QUOTATION;
    $buf .= SEPARATOR;

    # ダミー決済フラグ
    $key = 'dummy' . $index;
    $value = $_POST[$key];
    $buf .= QUOTATION . $value . QUOTATION;

    $buf .= "\n";

    # レコードを書き込む
    fwrite($fp, $buf);
}
fclose($fp);

$logger->info("結果通知CSVファイル($file)書込終了。");
$logger->info("結果通知処理終了。ベリトランスペイメントゲートウェイへ 200 OK を応答。");

# ダミーの HTML 文を出力
print "Content-type: text/html\r\n\r\n";
print "Push data Accepted.\n";

?>
