<?php
session_start();
require_once __DIR__ . "/./logic/front/front_disp_logic.php";
$front_disp_logic = new front_disp_logic();

if($_GET['area'] === 'true'){
	include_once "area_html.php";
}else{
	$category_sl_html = $front_disp_logic->get_category_child_html($_GET);
}
$category_html = $front_disp_logic->get_category_html($_GET);



?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="assets/front/css/base.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="assets/front/css/top-prts.css">
<link rel="stylesheet" href="assets/front/css/special-prts.css">
<link rel="stylesheet" href="assets/front/css/top-prts.css">
<link rel="stylesheet" href="assets/front/css/pc.css">
<link rel="stylesheet" href="assets/front/css/restaurant_shop.css">
<link rel="stylesheet" href="assets/front/css/restaurant-top.css">
<link rel="stylesheet" href="assets/front/css/slider-pro.css">
<link rel="stylesheet" href="assets/front/css/slider.css">

<?php require_once './required/html_head.php'?>
<link href="assets/front/css/font-awesome.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="assets/front/css/design.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="assets/front/css/side200.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href="assets/front/css/commodity_client.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700|Noto+Serif:400,700' rel='stylesheet' type='text/css'>
<title>Travel JIS</title>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="assets/front/css/jquery.datepicker.css">
<script type='text/javascript' src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script type="text/javascript" src="assets/front/js/moment.js"></script>
<!-- <script type="text/javascript" src="assets/front/page_js/right2.js"></script> -->

<script src="assets/front/js/jquery.sliderPro.min.js"></script>
<script src="assets/front/js/slider.js"></script>
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
 arrows: false,
 fadeArrows: false,
 buttons: false,
 loop: false,
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
<script>
(function($) {
    $(function() {
		// 下部スライダー
    	$("#undSlider").slider({
    		loop: false, // 自動でループ
    		time: 10,
    		speed: 1,
    		direction: "left", // 「up」「down」「left」「right」を選択可能
    		reverse: true, // 逆再生
    		auto: false, // 自動再生
    		easing: "linear", // jQuery easing plugin に依存
    		guideSelector: ".slideGuide",
    		cellSelector: ".slideCell",
    		ctrlSelector: ".slideCtrl",
    		ctrlClick: false, // クリックでスクロール
    		ctrlHover: true, // マウスオーバーでスクロール
    		draggable: false, // ドラッグ対応
    		dragCursorOpen: "open.cur",
    		dragCursorClose: "close.cur",
    		shuttle: false,
    		once: false,
    		restart: true,
    		restartTime: 3000,
    		pause: true,
    		build: true,
    		sp: 1 // 初期設定スピード
    	});
    });
})(jQuery);
</script>
<script>
$(document).ready(function(){
	$(".acplus").addClass("active");
});
</script>
<style>
.l_in{
	margin: 0 0;
}



</style>
</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->


<link href="https://fonts.googleapis.com/earlyaccess/sawarabimincho.css" rel="stylesheet" />
<link rel="stylesheet" href="./assets/front/css/slick.css" />
<script src="./assets/front/js/slick.min.js"></script>
<script>
$(function() {
	$(".slick-box").slick({
		arrows:false,
		variableWidth: true,
		infinite:false,

	});
});
</script>

<script>
	$(function(){
		$(".logout_btn").on("click",function(){
			ret = confirm("ログアウトします。よろしいですか？");
			if (ret == true){
				$.ajax({
					type : "POST",
					url : "./controller/front/login_ct.php",//コントローラURLを取得
					dataType: "json",
					data: {
						"method" : "logout",//コントローラ内での処理判断用
					},
				}).done(function(result, datatype){
					alert("ログアウトしました。\r\nTOPページへ移動します。");
					location.href = "./";
				}).fail(function(XMLHttpRequest, textStatus, errorThrown) {
					//異常終了時
				});
			}
		});
	});
</script>

<?php require_once "./required/header_out_lower.php"?>

<script>
$(document).ready(function() {
	if(location.pathname != "/") {
	var $path = location.href.split('/');
	var $endPath = $path.slice($path.length-2,$path.length-1);
	$('ul.try__menu li a[href$="'+$endPath+'/"]').parent().addClass('active');
	}
	});
</script>	<!--▲▲▲▲▲ header ▲▲▲▲▲-->
	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="sliderBorBtm sli_height">
				<div class="container1080 marB0 posRel">
					<div class="visible-xs">
						<section>
							<div class="">
							    <div class="sp-slides">
							        <!-- Slide 1 -->
							        <div class="sp-slide sliderBorBtm">
							            <img class="sp-image" src="assets/front/img/sp_top1.jpg"/>
							        </div>
								 </div>
							  </div>
						</section>
				    </div>
					<div class="hidden-xs">
						<section>
							<div class="">
							    <div class="sp-slides">
							        <!-- Slide 1 -->
							        <div class="sp-slide sliderBorBtm">
							            <img class="sp-image" src="assets/front/img/top1.jpg"/>
							        </div>
							    </div>
							  </div>
						</section>
					</div>
					<?php require_once __DIR__ . "/./required/main_vi_post.php"?>
				</div>
			</div>

			<div class="container1080 cf">
				<div class="container760">

					<?php print $category_sl_html?>
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> New Arrival Tour</h2>
							</div>
						</div>
					</section>
					<section class="topBox">
						<div class="p__list-container">
							<div class="lunchDailyBox">
								<?php print $category_html['new_ar_html']?>
							</div>
						</div>
					</section>
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> Recommended Tour Ranking</h2>
							</div>
						</div>
					</section>
					<section class="topBox">
						<div class="p__list-container">
							<div class="lunchDailyBox">
								<?php print $category_html['reccomend_html']?>
							</div>
						</div>
					</section>


					<section class="shin">
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> Popularity Tour Ranking</h2>
							</div>
						</div>
					</section>
					<section class="topBox">
						<div class="p__list-container">
							<div class="lunchDailyBox">
								<?php print $category_html['reservation_rank_html']?>
							</div>
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
$(function() {
	$("[name=date]").datepicker();
});
</script>
	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
