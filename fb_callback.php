<?php
// ini_set( 'display_errors', 1 );
session_start();

header("Content-type: text/html; charset=utf-8");

//設定ファイル
require_once("fb_config.php");

//コールバックURLの取得
$callcak_url = $_SESSION['fb_callback_ulr'];

//タイムゾーンの設定
date_default_timezone_set('asia/tokyo');

$helper = $fb->getRedirectLoginHelper();

try {
    if (isset($_SESSION['facebook_access_token'])) {
        $accessToken = $_SESSION['facebook_access_token'];
    } else {
        //アクセストークンを取得する
        $accessToken = $helper->getAccessToken($callcak_url);
    }
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (isset($accessToken)) {
    //アクセストークンをセッションに保存
    $_SESSION['facebook_access_token'] = (string) $accessToken;

    header('Location: ./mypage_users/new_member.php?oauth_t=fb');
    exit();
}


