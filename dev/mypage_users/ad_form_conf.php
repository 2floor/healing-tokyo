<?php
// session_start();

// //ログイン状態振り分け用
// $data_script_html = '';

// // ログイン判定
// if (!$_SESSION ['try_login_status']) {
// 		$login_script_html = '
// 			<script>
// 				alert("ログイン後にご利用になれる機能です。\r\nTOPページへ移動します。");
// 				location.href = "../";
// 			</script>';
// }



// //確認ボタンクリック時
// if ($_POST['url'] != '' && $_POST['url'] != null) {
// 	//入力内容を保持用セッションに設定
// 	$_SESSION ['try_ad_form_data'] = $_POST;

// }

// if ($_SESSION ['try_ad_form_data'] == null) {
// 	//入力情報がなく遷移してきた場合
// 	$data_script_html = '
// 			<script>
// 				alert("不正な遷移が行われました。");
// 				location.href = "./";
// 			</script>';
// }

// if ($_POST['confSubmit'] != null && $_POST['confSubmit'] != '') {
// 	require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/front/ad_logic.php';
// 	$ad_logic = new ad_logic();

// 	$ad_logic->ad_request();
// 	$data_script_html = '
// 			<script>
// 				alert("広告掲載申込を受付ました。\r\nMaypageページへ移動します。");
// 				location.href = "./";
// 			</script>';
// }


// var_dump('POST');
// var_dump($_POST);
// var_dump('SESSION');
// var_dump($_SESSION['try_ad_form_data']);


// ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once "../required/html_head.php"?>
<?php print $set_data_script_html?>
<?php print $data_script_html?>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="../assets/front/css/jquery.datepicker.css">
<script type='text/javascript' src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script type="text/javascript" src="../assets/front/js/moment.js"></script>
<script type="text/javascript" src="../assets/front/page_js/right2.js"></script>


<script src="../assets/front/js/jquery.sliderPro.min.js"></script>
<script type="text/javascript">
            $(document).ready(function($) {
 var slideImageWidth = (screen.width > 768) ? 760 : 300,
 slideImageHeight = (screen.width > 768) ? 452 : 3000 / 19 + 40;
 var $slides = $('.sp-slide'),
 slideCount = $slides.length;
 if (slideCount < 3 || slideCount === 3) {
 $slides.clone(true).appendTo('.sp-slides');
 }
 $('.slider-pro').sliderPro({
 width: '1090px',
 autoHeight: true,
 slideDistance: 0,
 arrows: true,
 fadeArrows: false,
 buttons: false,
 loop: true,
 visibleSize: '100%',
 init: function() {
 if (
 (navigator.userAgent.indexOf('iPad')) > 0 ||
 (navigator.userAgent.indexOf('Android')) > 0 &&
 (navigator.userAgent.indexOf('Mobile')) === -1
 ) {
 $('.sp-slides-container').css('overflow', 'hidden');
 } else {
 $(".sp-slides .sp-slide a").each(function(i, el) {
 $(el).addClass("sp-selectable").css("cursor", "pointer");
 });
 }
 }
 });
 });
</script>
</head>
<body>

	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once  "../required/header_out_lower.php"?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
<!-- 			<div class="container1080"> -->
<!-- 				<section> -->
<!-- 					<div class="slider-pro"> -->
<!-- 					    <div class="sp-slides"> -->
					        <!-- Slide 1 -->
<!-- 					        <div class="sp-slide"> -->
<!-- 					            <img class="sp-image" src="../assets/front/img/top1.jpg"/> -->
<!-- 					        </div> -->
					        <!-- Slide 2 -->
<!-- 					        <div class="sp-slide"> -->
<!-- 					            <img class="sp-image" src="../assets/front/img/top1.jpg"/> -->
<!-- 					        </div> -->
					        <!-- Slide 3 -->
<!-- 					        <div class="sp-slide"> -->
<!-- 					            <img class="sp-image" src="../assets/front/img/top1.jpg"/> -->
<!-- 					        </div> -->
					        <!-- Slide 4 -->
<!-- 					        <div class="sp-slide"> -->
<!-- 					            <img class="sp-image" src="../assets/front/img/top1.jpg"/> -->
<!-- 					        </div> -->
					        <!-- Slide 5 -->
<!-- 					        <div class="sp-slide"> -->
<!-- 					            <img class="sp-image" src="../assets/front/img/top1.jpg"/> -->
<!-- 					        </div> -->
<!-- 					    </div> -->
<!-- 					  </div> -->
<!-- 				</section> -->
<!-- 			</div> -->
			<div class="container1080 cf">
				<form action="ad_form_conf.php" name="frm" method="post" id="frm">
				<div class="container760">

					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
									<h2 class="cmp__head__title">広告掲載申請&nbsp;&nbsp;&nbsp;確認</h2>
							</div>
						</div>
					</section>

					<section>
						<div class="prts__contents_19">
								<h3 class="titleUnderline">広告掲載申込&nbsp;&nbsp;&nbsp;確認</h3>
							<p class="mypageTxt">
									以下の情報でよろしければ「申込みをする」ボタンをクリックしてください。<br>
							</p>
						</div>
					</section>

					<section class="borderBox">
						<div class="storeEditIn">
							<div class="storeEditItem">
								<div class="storeEditRow">
										<div class="storeEditCate">広告種類</div>
									<div class="storeEditForm">
											<?php print $_SESSION ['try_ad_form_data']['hid_ad_type'] ?>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">URL</div>
									<div class="storeEditForm">
											<?php print $_SESSION ['try_ad_form_data']['url'] ?>
									</div>
								</div>

							</div>

						</div>
					</section>

					<section>
						<div class="storeEditBtnBox mT20">
								<button type="button" class="btnBase btnBg1 btnW1" name="return" onclick="history.back();"><span class="btnLh2">入力画面へ戻る</span></button>
								<button type="submit" class="btnBase btnBg1 btnW1" name="confSubmit" value="confSubmit"><span class="btnLh2">申込みをする</span></button>
						</div>
					</section>
				</div>

	<!--▼▼▼▼▼ right ▼▼▼▼▼-->
	<?php require_once '../right_out.php';?>
	<!--▲▲▲▲▲ right ▲▲▲▲▲-->

			</div>
		</div>
	</div>

	<!--▼▼▼▼▼ footer ▼▼▼▼▼-->
	<?php require_once "../required/footer_out.php"?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->

	<!-- ページTOPへ-->
	<p id="try__page-top">
		<a href="#wrap">TOP</a>
	</p>
	<!-- ページTOPへ-->


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->


</body>
</html>
