<?php
// session_start();
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/common_logic.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/jis_common_logic.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_member_model.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_store_basic_model.php';
// $t_member_model = new t_member_model();
// $t_store_basic_model = new t_store_basic_model();


// //ログイン状態処理
// $script_html = '';
// if ($_SESSION ['try_login_member_data'] ['member_id'] == null || $_SESSION ['try_login_member_data'] ['member_id'] == '') {
// 	$script_html = '
// 			<script>
// 				alert("ログイン後にご利用になれる機能です。\r\nTOPページへ移動します。");
// 				location.href = "../";
// 			</script>
// 			';
// } else {

// 	$member_data = $t_member_model->get_member_detail($_SESSION ['try_login_member_data'] ['member_id']);
// 	// $member_data = $t_member_model->get_member_detail(6);
// 	$_SESSION['try_login_member_data']  = $member_data[0];
// 	$_SESSION['try_login_member_data'] ['password'] = '';

// 	$store_data = $t_store_basic_model->get_store_basic_detail($member_data[0]['store_basic_id']);
// 	$_SESSION['member_data'] ['store_name'] = $store_data[0]['store_name'];

// 	$plan_regist_html = '';
// 	$plan_regist_msg = '';
// 	if($store_data[0]['public_flg'] == 0){
// 		$plan_regist_html = '<a href="./plan_regist.php"><span class="btnBase btnBg1 btnW1 btnM1"><span class="btnLh2">新規プラン登録</span></span></a>';
// 	}else{
// 		$plan_regist_msg = '※サービスを開始する場合は、下記の「店舗情報管理」ボタンから店舗詳細情報のご登録をお願い致します。';
// 	}

// 	//バナー処理
// 	$jis_common_logic = new jis_common_logic();
// 	$banner_html = $jis_common_logic->mypage_banner('../', '4', null);

// 	$common_logic = new common_logic();
// 	$review_result = $common_logic->select_logic("select * from t_review where store_basic_id = ? and del_flg = '0' order by create_at desc", array($member_data[0]['store_basic_id']));

// 	$review_html = '';
// 	for ($i = 0; $i < count($review_result); $i++) {
// 		$review_row = $review_result[$i];

// 		$reservation_result = $common_logic->select_logic("select * from t_reservation where reservation_id = ? limit 1", array($review_row['etc1']));
// 		$reservation_row = $reservation_result[0];

// 		$reservation_row['come_date'];
// 		$come_date = substr($reservation_row['come_date'], 0, -3);

// 		$review_html = '
// 							<div class="mypageReservBox">
// 								<div class="mypageReservStoreRow">
// 									<div class="mypageReservDate">
// 										<span>'.$review_row['when_use'].'</span><br>
// 										<span>'.$review_row['number_of_people'].'名様ご利用</span>
// 									</div>
// 									<div class="mypageReservNameBox">
// 										<div class="mypageStoreInfoName">'.$review_row['plan_name'].'</div>
// 										<p class="mypageReservAdd">
// 											<span>'.$review_row['name'].'</span>
// 										</p>
// 									</div>
// 								</div>
// 								<div class="mypageReviewBtnBox">
// 									<button type="button" class="btnBase btnBg2 btnW1 btnH2" onclick="location.href=\'review_detail.php?id='.$review_row['review_id'].'\'">口コミ詳細を見る</button>
// 								</div>
// 							</div>';

// 	}

// 	if ($review_html == '') {
// 		$review_html = '現在登録されている口コミはありません';
// 	}
// }



?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once "../required/html_head.php"?>
<script type='text/javascript' src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script type="text/javascript" src="../assets/front/js/moment.js"></script>
<script type="text/javascript" src="../assets/front/page_js/right2.js"></script>

<!-- システム用 -->
<script type="text/javascript" src="../assets/admin/js/common/validate.js"></script>
<!-- <script type="text/javascript" src="../assets/front/js/store_index.js"></script> -->

<title>Activities in Japan</title>
<?php print $script_html?>
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
	<?php require_once '../required/header_out_lower.php';?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="container1080 cf">
				<div class="container760">
					<!-- AbstractPartsId:1010 LayoutNo:10 DeviceDivisionId:1 Rev:0 -->
					<!-- prts_10-2 画像ありボタン２個 -->
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> マイページ</h2>
							</div>
							<div class="mypageTopNameBox">
								<div class="mypageTopName">ようこそ、<span class="mypageTopNameB"><?php print($_SESSION['member_data'] ['store_name']); ?></span>さん</div>
								<div class="mypageTopEdit">
									<div class="mypageTopEditBtn"><a href="../mypage/withdrawal.php">会員退会手続き</a></div>
								</div>
							</div>
							<div class="mypageAttention">
								<?php print $plan_regist_msg?>
							</div>
						</div>
					</section>

					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">口コミ一覧</h3>
						</div>
						<div class="reviewWrap">
							<div class="reviewArea">
								<h4 class="reviewAreaTtl">Tsukiji (Old) vs Toyosu (Now) S.S Tour</h4>
								<time class="reviewAreaTime"2019.05.01></time>
								<div class="reviewStar">
									<p>Taro SMITH</p>
									<p>★★★★☆</p>
								</div>
								<p class="reviewStrDetail">Under constructionUnder constructionUnder constructionUnder construction</p>
								<div class="storeEditBtnBox reviewStrLink">
									<a href="review_detail.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">詳細を見る</span></span></a>
								</div>
							</div>
							<div class="reviewArea">
								<h4 class="reviewAreaTtl">Tsukiji (Old) vs Toyosu (Now) S.S Tour</h4>
								<time class="reviewAreaTime"2019.05.01></time>
								<div class="reviewStar">
									<p>Taro SMITH</p>
									<p>★★★★☆</p>
								</div>
								<p class="reviewStrDetail">Under constructionUnder constructionUnder constructionUnder construction</p>
								<div class="storeEditBtnBox reviewStrLink">
									<a href="review_detail.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">詳細を見る</span></span></a>
								</div>
							</div>
							<div class="reviewArea">
								<h4 class="reviewAreaTtl">Tsukiji (Old) vs Toyosu (Now) S.S Tour</h4>
								<time class="reviewAreaTime"2019.05.01></time>
								<div class="reviewStar">
									<p>Taro SMITH</p>
									<p>★★★★☆</p>
								</div>
								<p class="reviewStrDetail">Under constructionUnder constructionUnder constructionUnder construction</p>
								<div class="storeEditBtnBox reviewStrLink">
									<a href="review_detail.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">詳細を見る</span></span></a>
								</div>
							</div>
							<div class="reviewArea">
								<h4 class="reviewAreaTtl">Tsukiji (Old) vs Toyosu (Now) S.S Tour</h4>
								<time class="reviewAreaTime"2019.05.01></time>
								<div class="reviewStar">
									<p>Taro SMITH</p>
									<p>★★★★☆</p>
								</div>
								<p class="reviewStrDetail">Under constructionUnder constructionUnder constructionUnder construction</p>
								<div class="storeEditBtnBox reviewStrLink">
									<a href="review_detail.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">詳細を見る</span></span></a>
								</div>
							</div>
							<div class="reviewArea">
								<h4 class="reviewAreaTtl">Tsukiji (Old) vs Toyosu (Now) S.S Tour</h4>
								<time class="reviewAreaTime"2019.05.01></time>
								<div class="reviewStar">
									<p>Taro SMITH</p>
									<p>★★★★☆</p>
								</div>
								<p class="reviewStrDetail">Under constructionUnder constructionUnder constructionUnder construction</p>
								<div class="storeEditBtnBox reviewStrLink">
									<a href="review_detail.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">詳細を見る</span></span></a>
								</div>
							</div>
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
	<?php require_once '../required/footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->

	<!-- ページTOPへ-->
	<p id="try__page-top">
		<a href="#wrap">TOP</a>
	</p>
	<!-- ページTOPへ-->


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->


<!-- システム用 -->
	<input type="hidden" id="ct_url" value="../controller/front/edit_store_ct.php">
	<input type="hidden" id="id" value="">
	<input type="hidden" id="page_type" value="edit_init">
	<input type="password" id="before_password" value="" style="display: none;">

</body>
</html>
