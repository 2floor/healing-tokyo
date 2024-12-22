<?php
session_start();
require_once("Facebook/autoload.php");
//コールバックURLをセッションに保存
$_SESSION['fb_callback_ulr'] = 'https://jis-j.com/fb_callback.php';
$fb = new Facebook\Facebook([
    'app_id' => '552489118891493',
    'app_secret' => '014486a76e906eeb2a0ce773812600ce',
    'default_graph_version' => 'v2.8',
]);