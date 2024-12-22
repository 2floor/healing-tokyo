<?php
// $data_script_html = '';
// if ($_GET ['q'] == null || $_GET ['q'] == '') {
// 	$data_script_html = '
// 			<script>
// 				alert("存在しないURLです。");
// 				location.href = "../";
// 			</script>';
// } else {
// 	require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/logic/front/ad_logic.php';
// 	require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/common/security_common_logic.php';

// 	// セキュリティロジック
// 	$security_common_logic = new security_common_logic ();
// 	$query = $security_common_logic->session_security_exection ( $_GET );

// 	// 広告決済情報取得
// 	$ad_logic = new ad_logic ();
// 	$result = $ad_logic->chk_ad_data ( $query ['q'] );

// 	if ($result ['status']) {

// 		$advertisement_request_id = $result ['data'] ['advertisement_request_id'];
// 		$yen_nocommma = $result ['ad_data'] ['cost'];
// 		$plan = $result ['ad_data'] ['term'] . 'ヶ月プラン';
// 		$yen = number_format ( $result ['ad_data'] ['cost'] ) . '円';
// 	} else {
// 		$data_script_html = '
// 			<script>
// 				alert("既に決済が完了しているか削除された情報です。");
// 				location.href = "../";
// 			</script>';
// 	}
// }

// if ($_POST ['zeus_submit'] == 'zeus_submit') {
// 	// 決済会社へ TODO ダミー処理
// 	require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/logic/front/ad_logic.php';
// 	$ad_logic = new ad_logic ();
// 	$result = $ad_logic->zeus_logic ( $_POST );

// 	if ($result) {
// 		$data_script_html = '
// 			<script>
// 				alert("決済が完了しました。\r\nTOPページへ戻ります");
// 				location.href = "../";
// 			</script>';
// 	} else {
// 		$data_script_html = '
// 			<script>
// 				alert("決済に失敗しました。\r\nTOPページへ戻ります");
// 				location.href = "../";
// 			</script>';
// 	}
// }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once "../required/html_head.php"?>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="../assets/front/css/jquery.datepicker.css">
<script type='text/javascript' src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script type="text/javascript" src="../assets/front/js/moment.js"></script>
<script type="text/javascript" src="../assets/front/page_js/right2.js"></script>
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
</script></head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once "../required/header_out_lower.php"?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->
	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
<!-- 			<div class="container1080"> -->
<!-- 				<div class="visible-xs"> -->
<!-- 					<section> -->
<!-- 						<div class="slider-pro"> -->
<!-- 						    <div class="sp-slides"> -->
						        <!-- Slide 1 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/sp_top1.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 2 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/sp_top2.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 3 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/sp_top3.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 4 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/sp_top4.jpg"/> -->
<!-- 						        </div> -->
<!-- 							 </div> -->
<!-- 						  </div> -->
<!-- 					</section> -->
<!-- 			    </div> -->
<!-- 				<div class="hidden-xs"> -->
<!-- 					<section> -->
<!-- 						<div class="slider-pro"> -->
<!-- 						    <div class="sp-slides"> -->
						        <!-- Slide 1 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/top1.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 2 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/top2.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 3 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/top3.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 4 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/top4.jpg"/> -->
<!-- 						        </div> -->
<!-- 						    </div> -->
<!-- 						  </div> -->
<!-- 					</section> -->
<!-- 				</div> -->
<!-- 			</div> -->
			<div class="container1080 cf">
				<div class="container760">
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title">決済</h2>
							</div>
						</div>
					</section>
					<section class="borderBox">
						<div class="storeEditIn">
							<div class="storeEditItem">
								<div class="storeEditRow">
									<div class="storeEditCate loginW">サービス名</div>
									<div class="storeEditForm"><?php print $plan?></div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate loginW">料金</div>
									<div class="storeEditForm"><?php print $yen?></div>
								</div>
							</div>
						</div>
					</section>
					<section>
						<div class="storeEditBtnBox mT20">
							<form action="" method="post" name="frm">
								<button type="submit" class="btnBase btnBg1 btnW1" name="zeus_submit" value="zeus_submit">
									<span class="btnLh2">決済する</span>
								</button>
								<input type="hidden" name="hid_advertisement_request_id" value="<?php print $advertisement_request_id?>">
								<input type="hidden" name="hid_yen" value="<?php print $yen_nocommma?>">
								<button type="button" class="btnBase btnBg1 btnW1" onclick="history.back();">
									<span class="btnLh2">もどる</span>
								</button>
							</form>
						</div>
					</section>
					<section>
						<div class="storeEditBtnBox mT20">
							<button type="button" class="btnBase btnBg1 btnW1">
								<span class="btnLh2">決済する</span>
							</button>
							<button type="button" class="btnBase btnBg1 btnW1">
								<span class="btnLh2">もどる</span>
							</button>
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
