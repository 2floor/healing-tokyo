<?php
/**
 * ログを生成処理
 */
header ( 'Content-Type: text/html; charset="UTF-8"' );
$path = __DIR__ .  '/../log/';

$date = date ( 'Ymd' );
$now_time = date ( 'Gis' );

$today_csv_name2 = $date . ".log";

if (! file_exists ( $today_csv_name2 )) {
	clearstatcache();
	// ファイル作成
	touch ( $path . $today_csv_name2 );
	chmod ( $path . $today_csv_name2, 0644 );
}

// 日付の取得
$time = date ( "Y/m/d H:i:s" );
// ＵＲＬの取得
$requestUrl = $_SERVER ['REQUEST_URI'];
// リクエストメソッドの取得
$requestMethod = $_SERVER ['REQUEST_METHOD'];
// ブラウザ情報の取得
$requestbrowser = $_SERVER ['HTTP_USER_AGENT'];
// IPアドレス(ローカルでの::1は自分を示す)
$requestIp = $_SERVER ['REMOTE_ADDR'];
// ホスト名を取得
$hostName = @gethostbyaddr ( $requestIp );
// 遷移元ページを取得
$httpReferer = $_SERVER ['HTTP_REFERER'];


$log = "date:" . chk_null_empty_conv($time) . ",  ip:" . chk_null_empty_conv($requestIp) . ",  hostname:" . chk_null_empty_conv($hostName) . ",  requestUrl:" . chk_null_empty_conv($requestUrl) . ",  method:" . chk_null_empty_conv($requestMethod) . ",  browser:" . chk_null_empty_conv($requestbrowser) . ",  遷移元:" . chk_null_empty_conv($httpReferer);

$log_data .= $log . "\r\n";

$file2 = fopen ( $path . $today_csv_name2, "a" );

fwrite ( $file2, $log_data );

fclose ( $file2 );

chmod ( $path . $today_csv_name2, 0644 );

function chk_null_empty_conv($value){
	if ($value == "" || $value == null) {
		$value = "取得できませんでした";
	}
	return $value;
}

?>