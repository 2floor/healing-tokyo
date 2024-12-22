<?php
// アプリケーション設定
define('CONSUMER_KEY', '82653686778-628hbsuc01u30ttc75smhl6u6o503osl.apps.googleusercontent.com');
define('CALLBACK_URL', 'https://jis-j.com/mypage_users/new_member.php');

// URL
define('AUTH_URL', 'https://accounts.google.com/o/oauth2/auth');


$params = array(
    'client_id' => CONSUMER_KEY,
    'redirect_uri' => CALLBACK_URL,
    'scope' => 'https://www.googleapis.com/auth/userinfo.profile email',
    'response_type' => 'code',
);

// 認証ページにリダイレクト
header("Location: " . AUTH_URL . '?' . http_build_query($params));
?>