<?php
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/logic/front/ad_logic.php';
// $ad_logic = new ad_logic ();

// // ログイン判定
// if (!$_SESSION ['try_login_status']) {
// 		$login_script_html = '
// 			<script>
// 				alert("ログイン後にご利用になれる機能です。\r\nTOPページへ移動します。");
// 				location.href = "../";
// 			</script>';
// }

// $select_ad_plan_html = '';

// //外部広告セレクトボックスHTML
// $select_ad_plan_html = $ad_logic->create_select_ad_plan('1');

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once '../required/html_head.php';?>
<script type="text/javascript" src="../assets/front/js/front_validate.js"></script>
<script type="text/javascript" src="../assets/front/page_js/ad_form.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="../assets/front/css/jquery.datepicker.css">
<script type='text/javascript' src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script type="text/javascript" src="../assets/front/js/moment.js"></script>
<script type="text/javascript" src="../assets/front/page_js/right2.js"></script>

<script type="text/javascript">
$(window).load(function() {
	var text = $('[name=ad_type] option:selected').text();
	$('[name=hid_ad_type]').val(text);
	$('[name=ad_type]').change(function(){
		var text = $('[name=ad_type] option:selected').text();
		$('[name=hid_ad_type]').val(text);
	});
});
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
	<?php require_once '../required/header_out_lower.php';?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->
	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="container1080">
				<!--prts_32 メインビジュアル（画像スライダー) -->
				<section>
					<img class="topsp-image w100" src="../assets/front/img/top1.jpg">
				</section>
				<!-- AbstractPartsId:1027 LayoutNo:1 DeviceDivisionId:1 Rev:0 -->
			</div>
			<div class="container1080 cf">
				<form action="ad_form_conf.php" name="frm" method="post" id="frm">
					<div class="container760">
						<section>
							<div class="prts__contents_19">
								<div class="cmsi__head">
									<h2 class="cmp__head__title">広告掲載申請フォーム</h2>
								</div>
							</div>
						</section>
						<section class="mB50">
							<div class="prts__contents_19">
								<h3 class="titleUnderline">本サイトの広告掲載について</h3>
								<div class="mypageReservBox">
									<p class="adFormTxt1">ここには広告掲載についての説明が入ります。 ここには広告掲載についての説明が入ります。 ここには広告掲載についての説明が入ります。 ここには広告掲載についての説明が入ります。 ここには広告掲載についての説明が入ります。 ここには広告掲載についての説明が入ります。</p>
								</div>
							</div>
						</section>
						<section>
							<div class="prts__contents_19">
								<h3 class="titleUnderline">広告掲載申込フォーム</h3>
								<p class="mypageTxt">
									以下の情報をご入力ください。
									<br>
									折り返し登録メールアドレス宛にご案内メールをお送りさせて頂きます。
									<br>
									（広告掲載には所定の審査がございます）
								</p>
							</div>
						</section>
						<section class="borderBox">
							<div class="storeEditIn">
								<div class="storeEditItem">
									<div class="storeEditRow">
										<div class="storeEditCate">広告種類</div>
										<div class="storeEditForm">
											<select name="ad_type">
												<?php print $select_ad_plan_html?>
											</select>
											<input type="hidden" name="hid_ad_type" value="">
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">URL</div>
										<div class="storeEditForm">
											<input type="text" name="url" class="formTxt1 validate required">
										</div>
									</div>
								</div>
							</div>
						</section>
						<section>
							<div class="storeEditBtnBox mT20">
								<button type="button" class="btnBase btnBg1 btnW1" name="inputSubmit" value="inputSubmit">
									<span class="btnLh2">確認画面へ進む</span>
								</button>
							</div>
						</section>
					</div>
				</form>
				<!-- left -->
				<?php require_once '../right_out.php';?>
			</div>
		</div>
	</div>
	<!--▼▼▼▼▼ footer ▼▼▼▼▼-->
	<?php require_once '../required/footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->
	<!-- ページTOPへ-->
	<p id="try__page-top">
		<a data-prop2="1051--1--0--186--3351--#wrap" href="#wrap">TOP</a>
	</p>
	<!-- ページTOPへ-->
	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
