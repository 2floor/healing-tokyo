<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$front_disp_logic = new front_disp_logic();
$jis_common_logic = new jis_common_logic();
$jis_common_logic->login_check();

$news_html = $front_disp_logic->get_news(2);

$reserve = $front_disp_logic->get_my_reserv();
$favorite = $front_disp_logic->get_my_favorite();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once "../required/html_head.php"?>

<style type="text/css">
.btnBg1 {
    color: #fff!important;
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
					<!-- AbstractPartsId:1010 LayoutNo:10 DeviceDivisionId:1 Rev:0 -->
					<!-- prts_10-2 画像ありボタン２個 -->
					<?php require_once "./member_top.php"?>

					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">Notice from operation</h3>
							<div class="mypageInfoBox" id="news_html">
								<?php print $news_html?>
							</div>
						</div>
					</section>


					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">Booking confirmation</h3>
							<?php print $reserve['f_html']?>

						</div>
					</section>

<!-- 					<section class="mB50"> -->
<!-- 						<div class="prts__contents_19"> -->
<!-- 							<h3 class="titleUnderline">Favorite list</h3> -->
<!-- 							<p class="mypageTxt"> -->
<!-- 								Not registered yet -->
<!-- 							</p> -->
<!-- 					</section> -->

					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">Past reservation list</h3>
							<?php print $reserve['p_html']?>

						</div>
					</section>
					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">Favorite list</h3>
							<?php print $favorite?>

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

	<script type="text/javascript">

		var fav = {
				get : function(post_data) {
					var defer = $.Deferred();
					$.ajax({
						type : 'POST',
						url : "../controller/front/valiable_ct.php",// コントローラURLを取得
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


		$('.delete_fav').off().on('click', function(){
			var $btn = $(this);
			var conf = confirm("Delete this favorite?")
			if(!conf) return false;
			var fd = new FormData();
			fd.append("method", "delete_fav");
			fd.append("fav", $(this).attr("fav"));
			fav.get(fd).done(function(result) {
				if (result.data.status) {
					alert("Delete Successfly.");
					$btn.parents('.favWrap').remove();
				} else if (!result.data.status && result.data.error_code == 0) {
					// PHP返却エラー
					alert(result.data.error_msg);
					location.href = result.data.return_url;
				}

			}).fail(function(result) {
				// 異常終了
				$('body').html(result.responseText);
			});
		});




	</script>

</body>
</html>
