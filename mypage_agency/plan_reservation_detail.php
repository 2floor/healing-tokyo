<?php
// session_start ();
// // ログイン判定
// $script_html = '';
// if (!$_SESSION ['try_login_status']) {
// 	$script_html = '
// 			<script>
// 				alert("ログイン後にご利用になれるページです。\r\nTOPページへ移動します。");
// 				location.href = "../";
// 			</script>';
// } else {
// 	require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/common_logic.php';

// 	if ($_GET['id'] == null || $_GET['id'] == '') {
// 		$script_html = '
// 			<script>
// 				alert("存在しない情報です。\r\nTOPページへ移動します。");
// 				location.href = "../";
// 			</script>';
// 	} else {
// 		$common_logic = new common_logic();
// 		$result = $common_logic->select_logic('select * from t_reservation where reservation_id = ? limit 1', array($_GET['id']));

// 		if ($result == null) {
// 			$script_html = '
// 				<script>
// 					alert("存在しない情報です。\r\nTOPページへ移動します。");
// 					location.href = "../";
// 				</script>';
// 		} else {
// 			$row = $result[0];

// 			//来店日成型
// 			$come_date_array = explode(' ', $row['come_date']);
// 			$date_no_kugiri = str_replace('-', '', $come_date_array[0]);
// 			$time_array = explode(':', $come_date_array[1]);
// 			$come_date_array2 = explode('-', $come_date_array[0]);
// 			$come_date_wareki = $come_date_array2[0] . '年' . $come_date_array2[1] . '月' . $come_date_array2[2] . '日';

// 			$date = $come_date_array[0];
// 			$datetime = date_create($date);
// 			$week = array("日", "月", "火", "水", "木", "金", "土");
// 			$w = (int)date_format($datetime, 'w');
// 			$week_str = $week[$w];

// 			//プラン座席関連情報取得
// 			$result_relation = $common_logic->select_logic('select * from t_seat_plan_relation where seat_plan_relation_id = ? limit 1', array($row['seat_plan_relation_id']));
// 			$row_relation = $result_relation[0];

// 			//座席情報取得
// 			$result_seat = $common_logic->select_logic('select * from t_store_seat where store_seat_id = ? limit 1', array($row_relation['store_seat_id']));
// 			$row_seat = $result_seat[0];

// 			//プラン情報取得
// 			$taget_tb_name = '';
// 			$taget_tb_id_name = '';
// 			if ($row_relation['day_night_flg'] == 0) {
// 				$taget_tb_name = 't_store_plan_lunch';
// 				$taget_tb_id_name = 'store_plan_lunch_id';
// 			} else if ($row_relation['day_night_flg'] == 1) {
// 				$taget_tb_name = 't_store_plan_dinner';
// 				$taget_tb_id_name = 'store_plan_dinner_id';
// 			} else if ($row_relation['day_night_flg'] == 2) {
// 				$taget_tb_name = 't_store_plan_bar';
// 				$taget_tb_id_name = 'store_plan_bar_id';
// 			} else if ($row_relation['day_night_flg'] == 3) {
// 				$taget_tb_name = 't_store_plan_club';
// 				$taget_tb_id_name = 'store_plan_club_id';
// 			}
// 			$result_plan = $common_logic->select_logic('select * from '.$taget_tb_name.' where '.$taget_tb_id_name.' = ? limit 1', array($row_relation['store_plan_id']));
// 			$row_plan = $result_plan[0];




// 		}
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

					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title">マイページ</h2>
							</div>
							<div class="mypageTopNameBox">
								<div class="mypageTopName">ようこそ、<span class="mypageTopNameB"><?php print $_SESSION ['try_login_member_data'] ['name']?></span>さん</div>
								<div class="mypageTopEdit">
									<div class="mypageTopEditBtn"><a href="withdrawal.php">会員退会手続き</a></div>
									<div class="mypageTopEditBtn"><a href="edit.php">会員情報変更</a></div>
								</div>
							</div>
						</div>
					</section>

					<h3 class="titleUnderline">予約詳細</h3>

					<section class="borderBox">
						<div class="storeEditIn">
							<h3 class="titleUnderline">ご来店予定</h3>
							<div class="storeEditItem">
								<div class="storeEditRow">
									<div class="storeEditCate">ご予約のプラン</div>
									<div class="storeEditForm">
										<div class="reservPlanName">
											<?php print $row['plan_name']?>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">ご来店予定日</div>
									<div class="storeEditForm">
										<?php print $come_date_wareki?>(<?php print $week_str?>)
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">ご来店時間</div>
									<div class="storeEditForm">
										<?php print $time_array[0]?>:<?php print $time_array[1]?>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">ご予約の席</div>
									<div class="storeEditForm">
										<?php print $row_seat['seat_title']?>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">ご利用人数</div>
									<div class="storeEditForm">
										<span class="registItem">男性</span>
										<span class="registBox33">
											<?php print $row['men_num']?><span class="registItem">名</span>
										</span>
										<span class="registItem">女性</span>
										<span class="registBox33">
											<?php print $row['women_num']?><span class="registItem">名</span>
										</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">料金</div>
									<div class="storeEditForm">
										<?php print number_format($row_plan['charge'])?>円（税・サ込）
									</div>
								</div>

								<h3 class="titleUnderline mT30">リクエスト</h3>
								<div class="storeEditRow">
									<div class="storeEditCate">アレルギー食品（予約者本人）</div>
									<div class="storeEditForm">
										<div class="editRow100">
											<?php print $row['allergy_principal']?>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">アレルギー食品（同伴者）</div>
									<div class="storeEditForm">
										<div class="editRow100">
											<?php print $row['allergy_companion']?>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">苦手な食材（予約者本人）</div>
									<div class="storeEditForm">
										<div class="editRow100">
											<?php print $row['dislike_principal']?>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">苦手な食材（同伴者）</div>
									<div class="storeEditForm">
										<div class="editRow100">
											<?php print $row['dislike_companion']?>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">店舗への質問</div>
									<div class="storeEditForm">
										<?php print $row['question']?>
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
								<div class="storeEditRow">
									<div class="storeEditCate">職業</div>
									<div class="storeEditForm">
										<span class="registBox33">
											<?php print $row['etc1'] //TODO?>
										</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">連絡可能な携帯電話の番号</div>
									<div class="storeEditForm">
										<?php print $row['tel']?>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">メールアドレス</div>
									<div class="storeEditForm">
										<?php print $row['mail']?>
									</div>
								</div>
							</div>
						</div>
					</section>

					<section>
						<div class="storeEditBtnBox mT20">
							<button type="button" class="btnBase btnBg1 btnW1" onclick="location.href='index.php'"><span class="btnLh2">マイページトップにもどる</span></button>
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
