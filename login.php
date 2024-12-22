<?php
// ini_set( 'display_errors', 1 );
session_start();
header("Content-type: text/html; charset=utf-8");

//設定ファイルを読み込み
require_once("fb_config.php");

//コールバックURLの取得
$callcak_url = $_SESSION['fb_callback_ulr'];
$helper = $fb->getRedirectLoginHelper();

//オプションによって認証画面の文言が変わる
//$permissions = ['email', 'user_likes','user_posts']; //あなたの公開プロフィール、メールアドレス、タイムライン投稿、いいね！。
//$permissions = ['email', 'user_likes']; //あなたの公開プロフィール、メールアドレス、いいね！。
//$permissions = ['email', 'user_posts'];//あなたのタイムライン投稿。
//$permissions = ['email','user_friends'];//あなたの公開プロフィール、友達リスト、メールアドレス。
$permissions = ['email'];//あなたの公開プロフィール、メールアドレス。
// $permissions = [];//あなたの公開プロフィール。
$loginUrl = $helper->getLoginUrl($callcak_url, $permissions);


// アプリケーション設定
define('CONSUMER_KEY', '82653686778-628hbsuc01u30ttc75smhl6u6o503osl.apps.googleusercontent.com');
define('CALLBACK_URL', 'http://localhost/test/oauth.php');

// URL
define('AUTH_URL', 'https://accounts.google.com/o/oauth2/auth');


$params = array(
    'client_id' => CONSUMER_KEY,
    'redirect_uri' => CALLBACK_URL,
    'scope' => 'https://www.googleapis.com/auth/userinfo.profile',
    'response_type' => 'code',
);

// 認証ページにリダイレクト
// header("Location: " . AUTH_URL . '?' . http_build_query($params));
?>

<!DOCTYPE html>
<html lang="ja">
<head>

<?php require_once './required/html_head.php'?>
<style type="text/css">

@media (max-width: 767px){
    .sns_b{
        display: inherit
    }
}

</style>
<script src="https://d.shutto-translation.com/trans.js?id=62902"></script>
</head>
<body>
<div id="fb-root"></div>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once "./required/header_out_lower.php"?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">

			<div class="container1080 cf">

				<div class="container760">
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> Login(ログイン)</h2>
							</div>
							<div class="mypageTopNameBox">
								<div class="registTopTxt">
									Login is required to use this service. If you are not a member, please <a href="mypage_users/new_member.php">click here<i class="fas fa-external-link-alt"></i></a> for membership registration procedures.<br>

								</div>
							</div>
						</div>
					</section>
					<section class="borderBox">
						<form action="./logic/front/login_logic.php?er=<?php print $_GET["er"]?>" name="login_form" method="post">
							<div class="storeEditIn">
								<div class="storeEditItem">
									<div class="storeEditRow">
										<div class="storeEditCate loginW">ID (Mail Address)</div>
										<div class="storeEditForm">
											<input type="text" name="mail" class="formTxt1 validate mail">
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate loginW">PASSWORD</div>
										<div class="storeEditForm">
											<input type="password" name="password" class="formTxt1 validate required">
										</div>
									</div>
								</div>
							</div>
							<div style="color: red; text-align: center;">
								<?php
								if($_GET['er'] == '1'){
									print "The entered ID or password was not found.";
								}elseif($_GET['er'] == '99'){
									print "Logged out.";
								}elseif($_GET['er'] == 'rsv'){
									print "Login to make a reservation.";
								}
								if($_GET['r'] != '' && $_GET['r'] != null){
									print "<input type='hidden' name='r' value='".$_GET['r']."'>";
									print "<input type='hidden' name='d' value='".$_GET['d']."'>";
								}
								?>
							</div>

							<div class="storeEditBtnBox mT20">
								<button type="button" class="btnBase btnBg1 btnW1" name="login_btn">
									<span class="">LOGIN<br>(ログイン)</span>
								</button>
							</div>
						</form>



						<h4 class="loginReissue">
							<a href="reminder.php"><strong>Forget password ? Click here.</strong></a>
						</h4>

						<div class="storeEditBtnBox mT20" style="  padding-block-start: 57px;">
                            <h2 class="loginReissue">
                                <strong style="color: #ee0e5a">Registration</strong>
                            </h2>
								<a href="mypage_users/new_member.php">
								<button type="button" class="btnBase btnBg1_wh  btnW1">
									<span class="">for User</span>
								</button></a>
								<a href="agency_signup.php">
								<button type="button" class="btnBase btnBg1_wh  btnW1">
									<span class="">事業者様</span>
								</button></a>
								<br><p>(初めての事業者様は<a href="agency_signup.php">こちら<i class="fas fa-external-link-alt"></i></a>からお手続きをお願い致します)</p>
							</div>


					</section>


				</div>

	<!--▼▼▼▼▼ right ▼▼▼▼▼-->
	<?php require_once 'right_out.php';?>
	<!--▲▲▲▲▲ right ▲▲▲▲▲-->

			</div>
		</div>
	</div>


	<!--▼▼▼▼▼ bottomslider ▼▼▼▼▼-->
	<?php print $buttom_bunner?>
	<!--▲▲▲▲▲ bottomslider ▲▲▲▲▲-->

	<!--▼▼▼▼▼ footer ▼▼▼▼▼-->
	<?php require_once './required/footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->



	<script type="text/javascript">
		$(function(){
			$('[name=login_btn]').off().on('click',function(){
				$("[name=login_form]").submit();
			});
		});
	</script>

	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
