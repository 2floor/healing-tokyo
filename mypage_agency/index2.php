<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
$jis_common_logic = new jis_common_logic();
$jis_common_logic->login_check();

require_once __DIR__ .  '/../logic/front/front_disp_logic2.php';
$front_disp = new front_disp_logic();

$news_html = $front_disp->get_news(1);

$tour_html = $front_disp->get_my_tour();

$rsv_html = $front_disp->get_reserve_list_for_top();

$review_html = $front_disp->get_review_list_for_qg($_SESSION['jis']['login_member']['store_basic_id']);


?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once "../required/html_head.php"?>

<style type="text/css">

@media screen and (max-width: 767px){
.mypageReservBox {
width:97%;}
}
</style>


</head>
<body>

	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once '../required/header_out_lower.php';?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="container1080 cf">
				<div class="container760">
				<?php require_once "./member_top.php"?>
					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">JISからのお知らせ</h3>
							<div class="mypageInfoBox" id="news_html">
								<?php print $news_html?>
							</div>
						</div>
					</section>

					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">情報管理</h3>
							<div class="mypageManage">
								<?php print $plan_regist_html?>
								<a href="./regist_tour.php"><span class="btnBase btnBg1 btnW1 btnM1"><span class="btnLh2">アクティビティ登録</span></span></a>
								<a href="./edit_information.php"><span class="btnBase btnBg1 btnW1 btnM1"><span class="btnLh2">会員情報編集</span></span></a>
<!-- 								<a href="#"><span class="btnBase btnBg1 btnW1 btnM1"><span class="btnLh2">口コミ回答</span></span></a> -->
							</div>
						</div>
					</section>

					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">掲載マニュアル</h3>
							<div class="mypageManage">
								<?php print $plan_regist_html?>

								<a href="../manual/Company_Information_Management_Registration_Manual.pdf" target="_blank"><span class="btnBase btnBg1 btnW1 btnM1"><span class="btnLh2">事業者様情報管理登録説明書</span></span></a>
								<a href="../manual/Activity_registration_manual_basics.pdf" target="_blank"><span class="btnBase btnBg1 btnW1 btnM1"><span class="btnLh2">アクティビティ登録説明書基本編</span></span></a>
								<a href="../manual/Activity_registration_manual_application.pdf" target="_blank"><span class="btnBase btnBg1 btnW1 btnM1"><span class="btnLh2">アクティビティ登録説明書応用編</span></span></a>
								<a href="../manual/Block_management_manual.pdf" target="_blank"><span class="btnBase btnBg1 btnW1 btnM1"><span class="btnLh2">ブロック管理説明書</span></span></a>
							</div>
						</div>
					</section>



					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">登録アクティビティ一覧<span class="reserv">現在、登録しているアクティビティ情報の一覧です。</span></h3>
							<?php print $tour_html?>
						</div>
					</section>

					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">予約アクティビティ一覧<span class="reserv">現在、予約が入っている一覧です。</span></h3>

							<?php print $rsv_html?>
						</div>
					</section>

					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">口コミ一覧<span class="reserv">現在、口コミが入っている一覧です。</span></h3>
							<?php print $review_html?>
						</div>
					</section>
<!-- 					<section class="mB50"> -->
<!-- 						<div class="prts__contents_19"> -->
<!-- 							<h3 class="titleUnderline">Activities in Japanからのおすすめ<span class="reserv">Activities in Japanからのおすすめを紹介します。</span></h3> -->
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
	<?php require_once '../required/footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->

	<!-- ページTOPへ-->
	<p id="try__page-top">
		<a href="#wrap">TOP</a>
	</p>
	<!-- ページTOPへ-->


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->


<!-- システム用 -->

<script type="text/javascript">
$(function(){

	var st = {
			get : function(post_data) {
				var defer = $.Deferred();
				$.ajax({
					type : 'POST',
					url : "../logic/front/tour_logic.php",// コントローラURLを取得
					data : post_data,
					processData : false,
					contentType : false,
					dataType : 'json',
					success : defer.resolve,
					error : defer.reject,
				});
				return defer.promise();
			}
	};


	$('.public_tour').off().on('click', function(){
		var t = $(this).attr('t');
		var tid = $(this).attr('tid');
		var msg = "アクティビティを公開します\nよろしいですか？";
		if(t == '1') msg = "アクティビティを非公開にします\nよろしいですか？";
		if(confirm(msg)){
			var fd = new FormData();
			fd.append("method","status_change");
			fd.append("tour_id",tid);
			fd.append("status_change_col","public_flg");
			fd.append("status_change_val",t);
			st.get(fd).done(function(result) {
				if (result.data.status) {
					location.reload();
				} else if (!result.data.status && result.data.error_code == 0) {
					location.href = result.data.return_url;
				}

			}).fail(function(result) {
				// 異常終了
				$('body').html(result.responseText);
			});


		}
	});

	$('.del_tour').off().on('click', function(){
		var tid = $(this).attr('tid');
		var msg = "アクティビティを削除します\nよろしいですか？";
		if(confirm(msg)){
			var fd = new FormData();
			fd.append("method","status_change");
			fd.append("tour_id",tid);
			fd.append("status_change_col","del_flg");
			fd.append("status_change_val",1);
			st.get(fd).done(function(result) {
				if (result.data.status) {
					location.reload();
				} else if (!result.data.status && result.data.error_code == 0) {
					location.href = result.data.return_url;
				}

			}).fail(function(result) {
				// 異常終了
				$('body').html(result.responseText);
			});


		}
	});
	$('.cancel_rsv').off().on('click', function(){
		var rid = $(this).attr('rid');
		var msg = "予約をキャンセルします\nよろしいですか？";
		if(confirm(msg)){
			var fd = new FormData();
			fd.append("method","cancel_rsv");
			fd.append("rsv_id",rid);
			st.get(fd).done(function(result) {
				if (result.data.status) {
					alert("キャンセルが完了しました")
					location.reload();
				} else if (!result.data.status && result.data.error_code == 0) {
					location.href = result.data.return_url;
				}

			}).fail(function(result) {
				// 異常終了
				$('body').html(result.responseText);
			});


		}
	});
})


</script>

</body>
</html>
