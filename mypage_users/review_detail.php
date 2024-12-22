<?php
// session_start();
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/common_logic.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_member_model.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_store_basic_model.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/jis_common_logic.php';
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
// 	$_SESSION['member_data'] = $member_data[0];
// 	$_SESSION['member_data']['password'] = '';

// 	$store_data = $t_store_basic_model->get_store_basic_detail($member_data[0]['store_basic_id']);
// 	$_SESSION['member_data']['store_name'] .= $store_data[0]['store_name'];
// 	//バナー処理
// 	$jis_common_logic = new jis_common_logic();
// 	$banner_html = $jis_common_logic->mypage_banner('../', '4', null);

// 	$common_logic = new common_logic();
// 	$review_result = $common_logic->select_logic("select * from t_review where review_id = ? and del_flg = '0' limit 1", array($_GET['id']));
// 	$review_row = $review_result[0];

// 	$review_member_result = $common_logic->select_logic("select * from t_member where member_id = ? limit 1", array($review_row['member_id']));
// 	$review_member_row = $review_member_result[0];

// 	$reservation_result = $common_logic->select_logic("select * from t_reservation where reservation_id = ? limit 1", array($review_row['etc1']));
// 	$reservation_row = $reservation_result[0];

// 	$reservation_row['come_date'];
// 	$come_date = substr($reservation_row['come_date'], 0, -3);

// 	$come_date_array = explode(' ', $come_date);

// 	// 口コミプラン評価★画像処理
// 	$floor_evaluation_plan = floor ( $review_row ['evaluation_plan'] );
// 	$plan_icon_star_hmtl = '';
// 	for($n = 0; $n < $floor_evaluation_plan; $n ++) {
// 		$plan_icon_star_hmtl .= '<img src="../assets/front/img/icon_star.png" alt="">';
// 	}

// 	// 小数点以下判定(0.5を超えていたら★半分表示)
// 	if (strpos ( $review_row ['evaluation_plan'], '.' ) !== false) {
// 		$evaluation_plan_dot_array = explode ( '.', $review_row ['evaluation_plan'] );

// 		if (( int ) substr ( $evaluation_plan_dot_array [1], 0, 1 ) >= ( int ) 5) {
// 			$plan_icon_star_hmtl .= '<img src="../assets/front/img/icon_star_half.png" alt="">';
// 		}
// 	}

// 	// 口コミ雰囲気評価★画像処理
// 	$floor_evaluation_mood = floor ( $review_row ['evaluation_mood'] );
// 	$mood_icon_star_hmtl = '';
// 	for($n = 0; $n < $floor_evaluation_mood; $n ++) {
// 		$mood_icon_star_hmtl .= '<img src="../assets/front/img/icon_star.png" alt="">';
// 	}

// 	// 小数点以下判定(0.5を超えていたら★半分表示)
// 	if (strpos ( $review_row ['evaluation_mood'], '.' ) !== false) {
// 		$evaluation_mod_dot_array = explode ( '.', $review_row ['evaluation_mood'] );

// 		if (( int ) substr ( $evaluation_mod_dot_array [1], 0, 1 ) >= ( int ) 5) {
// 			$mood_icon_star_hmtl .= '<img src="../assets/front/img/icon_star_half.png" alt="">';
// 		}
// 	}

// 	// 口コミ料理評価★画像処理
// 	$floor_evaluation_cuisine = floor ( $review_row ['evaluation_cuisine'] );
// 	$cuisine_icon_star_hmtl = '';
// 	for($n = 0; $n < $floor_evaluation_cuisine; $n ++) {
// 		$cuisine_icon_star_hmtl .= '<img src="../assets/front/img/icon_star.png" alt="">';
// 	}

// 	// 小数点以下判定(0.5を超えていたら★半分表示)
// 	if (strpos ( $review_row ['evaluation_cuisine'], '.' ) !== false) {
// 		$evaluation_cuisine_dot_array = explode ( '.', $review_row ['evaluation_cuisine'] );

// 		if (( int ) substr ( $evaluation_cuisine_dot_array [1], 0, 1 ) >= ( int ) 5) {
// 			$cuisine_icon_star_hmtl .= '<img src="../assets/front/img/icon_star_half.png" alt="">';
// 		}
// 	}

// 	// 口コミプラン評価★画像処理
// 	$floor_evaluation_cost = floor ( $review_row ['evaluation_cost'] );
// 	$cost_icon_star_hmtl = '';
// 	for($n = 0; $n < $floor_evaluation_cost; $n ++) {
// 		$cost_icon_star_hmtl .= '<img src="../assets/front/img/icon_star.png" alt="">';
// 	}

// 	// 小数点以下判定(0.5を超えていたら★半分表示)
// 	if (strpos ( $review_row ['evaluation_cost'], '.' ) !== false) {
// 		$evaluation_cost_dot_array = explode ( '.', $review_row ['evaluation_cost'] );

// 		if (( int ) substr ( $evaluation_cost_dot_array [1], 0, 1 ) >= ( int ) 5) {
// 			$cost_icon_star_hmtl .= '<img src="../assets/front/img/icon_star_half.png" alt="">';
// 		}
// 	}

// 	// 口コミプラン評価★画像処理
// 	$floor_evaluation_service = floor ( $review_row ['evaluation_service'] );
// 	$service_icon_star_hmtl = '';
// 	for($n = 0; $n < $floor_evaluation_service; $n ++) {
// 		$service_icon_star_hmtl .= '<img src="../assets/front/img/icon_star.png" alt="">';
// 	}

// 	// 小数点以下判定(0.5を超えていたら★半分表示)
// 	if (strpos ( $review_row ['evaluation_service'], '.' ) !== false) {
// 		$evaluation_service_dot_array = explode ( '.', $review_row ['evaluation_service'] );

// 		if (( int ) substr ( $evaluation_service_dot_array [1], 0, 1 ) >= ( int ) 5) {
// 			$service_icon_star_hmtl .= '<img src="../assets/front/img/icon_star_half.png" alt="">';
// 		}
// 	}


// 	$floor_evaluation_all_unit =  (int)$review_row ['evaluation_all'] / 5 ;

// 	$btn_html = '<button type="button" class="btnBase btnBg2 btnW1 btnH2">返信済です</button>';
// 	if ($review_row['reply'] == null && $review_row['reply'] == '') {
// 		$btn_html = '<button type="button" class="btnBase btnBg2 btnW1 btnH2" onclick="location.href=\'review_reply.php?id='.$_GET['id'].'\'">返信する</button>';
// 	}



// 	if ($review_row == null) {
// 		$script_html = '
// 			<script>
// 				alert("該当する情報がありません。\r\nマイページへ移動します。");
// 				location.href = "./";
// 			</script>
// 			';
// 	}
// }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once "../required/html_head.php"?>

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
					<!-- AbstractPartsId:1010 LayoutNo:10 DeviceDivisionId:1 Rev:0 -->
					<!-- prts_10-2 画像ありボタン２個 -->
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji">My Page</h2>
							</div>
							<div class="mypageTopNameBox">
								<div class="mypageTopName">ようこそ、<span class="mypageTopNameB"><?php print($_SESSION['member_data']['store_name']); ?></span>さん</div>
								<div class="mypageTopEdit">
									<div class="mypageTopEditBtn"><a href="../mypage/withdrawal.php">会員退会手続き</a></div>
								</div>
							</div>

					</section>
					<h3 class="titleUnderline">口コミ返信</h3>
					<section class="borderBox">
						<div class="storeEditIn">

							<div class="storeEditItem">
							<h3 class="titleUnderline">参加アクティビティ</h3>
								<div class="storeEditRow">
									<div class="storeEditCate">参加アクティビティ</div>
									<div class="storeEditForm">
										<div class="reservPlanName">
											<?php print $row['plan_name']?>
										</div>
									</div>
								</div>

								<h3 class="titleUnderline">ご利用内容</h3>
								<div class="storeEditRow">
									<div class="storeEditCate">ご利用人数</div>
									<div class="storeEditForm customerNumFieldArea">
										<div class="customerNumField">
											<span class="customerNumFieldItem">男性　Man</span>
											<span class="customerNumFieldNum"><?php print $row['men_num']?></span>名
										</div>
										<div class="customerNumField">
											<span class="customerNumFieldItem">女性　Woman</span>
											<span class="customerNumFieldNum"><?php print $row['men_num']?></span>名
										</div>
										<div class="customerNumField">
											<span class="customerNumFieldItem">子ども　Children</span>
											<span class="customerNumFieldNum"><?php print $row['men_num']?></span>名
										</div>

									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">参加日</div>
									<div class="storeEditForm">
										<?php print $come_date_wareki?>(<?php print $week_str?>)
									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">料金</div>
									<div class="storeEditForm">
										<?php print number_format($row_plan['charge'])?>円（税・サ込）
									</div>
								</div>

								<h3 class="titleUnderline mT30">総合評価</h3>
								<div class="storeEditRow">
									<div class="storeEditCate">総合評価</div>
									<div class="storeEditForm">
										<div class="editRow100">
											<?php print $row['allergy_principal']?>
										</div>
									</div>
								</div>

								<h3 class="titleUnderline mT30">お客様情報</h3>
								<div class="storeEditRow">
									<div class="storeEditCate">お名前</div>
									<div class="storeEditForm">
										<?php print $row['name']?>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">フリガナ</div>
									<div class="storeEditForm">
										<?php print $row['name_kana']?>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">年齢</div>
									<div class="storeEditForm">
										<span class="registBox33">
											<?php print $row['age']?><!--  --><span class="registItem">才</span>
										</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">性別</div>
									<div class="storeEditForm">
										<?php if ($row['sex'] == '0') { print '男性'; } else { print '女性'; }?>
									</div>
								</div>
								<h3 class="titleUnderline mT30">コメント</h3>
								<div class="storeEditRow">
									<div class="storeEditCate">利用者のコメント</div>
									<div class="storeEditForm">
										<span class="registBox33">
											<?php print $row['etc1'] //TODO?>
										</span>
									</div>
								</div>
								<h3 class="titleUnderline mT30">返信</h3>
								<div class="reviewReply">
									<?php print nl2br($review_row['reply'])?>
									<span class="reviewReplyName"><?php print $review_row['etc3']?></span>
								</div>


							</div>
						</div>
					</section>
					<section>
						<div class="storeEditBtnBox mT20">
							<button type="button" class="btnBase btnBg1 btnW1" onclick="location.href=''"><span class="btnLh2">登録する</span></button>
							<button type="button" class="btnBase btnBg1 btnW1" onclick="location.href=''"><span class="btnLh2">削除する</span></button>
						</div>
					</section>




<!-- 					<section class="mB50"> -->
<!-- 						<div class="prts__contents_19"> -->
<!-- 							<h3 class="titleUnderline">JISからのおすすめ<span class="reserv">JISからのおすすめを紹介します。</span></h3> -->
<!-- 							<div class="mypageAdRow"> -->
<!-- 								<div class="mypageBnr1"><a href="#"><img alt="" src="../assets/front/img/bnr1.jpg"></a></div> -->
<!-- 							</div> -->
<!-- 							<div class="mypageAdRow"> -->
								<?php //print $banner_html?>
<!-- 								<div class="mypageBnr2Left"><a href="#"><img alt="" src="../assets/front/img/bnr2.jpg"></a></div> -->
<!-- 								<div class="mypageBnr2Right"><a href="#"><img alt="" src="../assets/front/img/bnr2.jpg"></a></div> -->
<!-- 							</div> -->
<!-- 						</div> -->
<!-- 					</section> -->
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
