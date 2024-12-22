<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
$jis_common_logic = new jis_common_logic();
$jis_common_logic->login_check();

require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$front_disp = new front_disp_logic();

$rsv_html = $front_disp->get_reserve_list_for_top($_GET['tid']);
$rsv_opt = $front_disp->get_reserve_list__opt($_GET['tid']);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once "../required/html_head.php"?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/ja.js"></script>

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
							<h3 class="titleUnderline">予約一覧<span class="reserv">現在の予約一覧です。</span></h3>
							<form action="./dl_csv.php" method="post">
								<div>
									<select class="formTxt1 orderSelect " name="order_type" style="display:inline-block;width: auto;">
										<option value="1">予約一覧</option>
										<option value="2">過去の予約</option>
										<option value="3">キャンセル済み</option>
									</select>
									<select class="formTxt1 numberSelect " name="come_date">
										<option value="">全表示</option>
										<?php print $rsv_opt?>
									</select>
									<input type="hidden" name="tour_id" value="<?php print $_GET['tid']?>">
									<button type="submit" class="mypageStoreInfoEditBtn1 s2">CSVダウンロード</button>
								</div>
							</form>
							<?php print $rsv_html?>
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




	order ();
	$('.numberSelect, .orderSelect').off().on('change', function(){
		order ();
	});


	function order (){
		var Sdt = $('.numberSelect').val();
		var od = $('.orderSelect').val();
		if(od == '1'){
			var bool = true;
			var bool2 =  function ($elem){return true;}
			var bool3 =  function ($elem){return true;}
		}else if(od == '2'){
			var bool = true;
			var bool3 = function ($elem){return true;}
			var bool2 = function ($elem){
				return (moment($elem.attr("dt")).diff(moment(), "days") > 0)
			}
		}else if(od == '3'){
			var bool = true;
			var bool2 = function ($elem){return true;}
			var bool3 = function ($elem){
				return ($elem.attr("canc") == '1');
			}
		}
		$('.mypageReservBox').each(function(i,e){
			console.log(bool2($(e)));

			if(Sdt == '' && bool &&  bool2($(e)) && bool3($(e))){
				$(e).show();
				return true;
			}
			if(Sdt == $(e).attr("dt") && bool && bool2($(e)) && bool3($(e))){
				$(e).show();
			}else{
				$(e).hide();
			}
		});
	}
})


</script>

</body>
</html>
