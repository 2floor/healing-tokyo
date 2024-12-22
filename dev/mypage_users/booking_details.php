<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/common/common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$front_disp_logic = new front_disp_logic();
$jis_common_logic = new jis_common_logic();
$common_logic = new common_logic();
$jis_common_logic->login_check();


$rsv = $jis_common_logic->get_reserve_detail($_GET['rid']);
$newA_Price = number_format(($rsv['men_num'] + $rsv['women_num'])  * $rsv['adult_fee']);
$newC_Price = number_format(($rsv['children_num'] )  * $rsv['children_fee'] );
$price = ( ($rsv['men_num'] + $rsv['women_num'])  * $rsv['adult_fee'] ) +( ($rsv['children_num'] )  * $rsv['children_fee'] );
$price = $price;//$jis_common_logic->add_tax($price);
if(date('Y-m-d', strtotime($rsv['come_date'])) < date('Y-m-d H:i:s') ){
	$rev = $common_logic->select_logic("select * from t_review where member_id = ? and reservation_id = ? ", array($_SESSION['jis']['login_member']['member_id'], $_GET['rid']));
	if($rev != null && $rev!= ''){
	}else{
		$btn = '<button type="button" class="btn btn-primary button_input button_form btnBase btnBg1 btnW1" onclick="location.href=\'review.php?rid='.$_GET['rid'].'\'">
			Write Review
		</button>';
	}
}else{
	$btn = '<button type="button" class="btn btn-primary button_input button_form btnBase btnBg1 btnW1 cancel_rsv" rid="'.$_GET['rid'].'">
			Cancel reservation
		</button>';
}

$store_basic = $common_logic->select_logic("select * from t_store_basic where store_basic_id = ? ", array($rsv['store_basic_id']));

if(strpos($rsv['payment_way'], "1") !== false ){
	$payment_way = 'Cash on site';
}elseif(strpos($rsv['payment_way'], "3") !== false ){
	$payment_way  = 'Credit card('.$rsv['tour']['card_choice'].')';
}elseif(strpos($rsv['payment_way'], "2") !== false ){
	$payment_way = 'Immediate payment by credit card';
}



?>


<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once '../required/html_head.php';?>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="../assets/front/css/jquery.datepicker.css">
<script type='text/javascript' src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script type="text/javascript" src="../assets/front/js/moment.js"></script>
<script type="text/javascript" src="../assets/front/page_js/right2.js"></script>


<!-- システム用 -->
<script type="text/javascript" src="../assets/admin/js/common/validate.js"></script>
<!-- <script type="text/javascript" src="../assets/front/js/edit_store.js"></script> -->


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

					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji">MY PAGE</h2>
							</div>
							<div class="mypageTopNameBox">
								<div class="mypageTopName">Hello,<span class="mypageTopNameB"><?php print $_SESSION ['jis']['login_member']['name']?></span></div>
								<div class="mypageTopEdit">

									<div class="mypageTopEditBtn"><a href="./">My page top</a></div>
									<div class="mypageTopEditBtn"><a href="../mypage_users/edit_information.php">Edit my information</a></div>
								</div>
							</div>
						</div>
					</section>

					<section>
						<h3 class="titleUnderline">Booking details</h3>

					</section>

					<section class="borderBox">
						<div class="storeEditIn">

							<div class="storeEditItem">
								<div class="storeEditRow">
									<div class="storeEditCate"> Booking number</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print $rsv['order_id']?></span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Tour name</div>
									<div class="storeEditForm">
										<span><a href="../search/plan.php?tid=<?php print $rsv['tour']['tour_id']?>&sbid=<?php print $rsv['store_basic_id']?>">　<?php print $rsv['tour']['title']?></a></span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate"> Date</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print date("d/M/Y H:i", strtotime($rsv['come_date']))?></span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate"> Operator</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print $store_basic[0]['company_name_eng']?></span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate"> Emergency contact</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print $store_basic[0]['emergency_tel']?></span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate"> Number of pax</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span>Male: <?php print $rsv['men_num']?><br>
											Female: <?php print $rsv['women_num']?><br>
											Child: <?php print $rsv['children_num']?></span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate"> Adult fee(JPY)</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print $newA_Price?></span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate"> Child fee(JPY)</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print $newC_Price?></span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate"> Total fee(JPY)</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print number_format($price)?></span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate"> Details</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<a href="dl_pdf.php?rsv=<?php print $_GET['rid']?>" target="_blank"><span>PDF download  <i class="far fa-file-pdf"></i></span></a>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate"> Payment method</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print $payment_way?></span>
										</div>
									</div>
								</div>

							</div>

					</section>

					<section>
						<div class="storeEditBtnBox mT20">

							<?php print $btn;?>

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
<!-- 	<input type="hidden" id="ct_url" value="../controller/front/edit_store_ct.php"> -->
	<input type="hidden" id="id" value="">
	<input type="hidden" id="page_type" value="edit_init">
	<input type="password" id="before_password" value="" style="display: none;">



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

	$('.cancel_rsv').off().on('click', function(){
		var rid = $(this).attr('rid');
		var msg = "Cancel the reservation.\nIs it OK?";
		if(confirm(msg)){
			var fd = new FormData();
			fd.append("method","cancel_rsv");
			fd.append("rsv_id",rid);
			st.get(fd).done(function(result) {
				if (result.data.status) {
					alert("Cancellation completed.")
					location.replace("./");
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
