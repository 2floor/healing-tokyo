<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$front_disp_logic = new front_disp_logic();
$jis_common_logic = new jis_common_logic();
$jis_common_logic->login_check();

$rsv = $jis_common_logic->get_reserve_detail($_GET['rid']);

$msg ='';
if($_GET['er'] == 1){
	$msg ='<span style="color:red;">Error : Please Input Value.</span>';
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
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> MY PAGE</h2>
							</div>
							<div class="mypageTopNameBox">
								<div class="mypageTopName">Hello,<span class="mypageTopNameB"><?php print($_SESSION['jis']['login_member'] ['name']); ?></span></div>
								<div class="mypageTopEdit">
									<div class="mypageTopEditBtn"><a href="./">My page top</a></div>

									<div class="mypageTopEditBtn"><a href="../mypage_users/edit_information.php">Edit my information</a></div>
								</div>
							</div>
						</div>
					</section>

						<form action="./review_submit.php" method="post">
						<section class="borderBox">
						<?php print $msg?>
							<h3 class="titleUnderline">Review</h3>
							<div class="storeEditIn">

								<div class="storeEditItem">

									<div class="storeEditRow">
										<div class="storeEditCate">Tour name</div>
										<div class="storeEditForm">
											<p><?php print $rsv['tour_name']?></p>
										</div>
									</div>
								</div>
								<div class="storeEditItem">
									<h3 class="titleUnderline">Add information</h3>
									<div class="storeEditRow">
										<div class="storeEditCate">Number of pax</div>
										<div class="storeEditForm">
											<p>Male <?php print $rsv['men_num']?>/ Female <?php print $rsv['women_num']?> / Children <?php print $rsv['children_num']?></p>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">Tour date</div>
										<div class="storeEditForm">
											<p><?php print date("d/M/Y", strtotime($rsv['come_date']))?></p>

										</div>
									</div>
									</div>
								<div class="storeEditItem">
									<h3 class="titleUnderline">Evaluation(5 full marks)</h3>
									<div class="storeEditRow">
										<div class="storeEditCate">Total evaluation</div>
										<div class="storeEditForm">
												<select name="review_point" id="review_point" class="formTxt1 validate required">
													<option value="5">5</option>
													<option value="4">4</option>
													<option value="3">3</option>
													<option value="2">2</option>
													<option value="1">1</option>

												</select>
										</div>
									</div>
								</div>
								<div class="storeEditItem">

									<h3 class="titleUnderline">Comment</h3>
									<div class="storeEditRow">
										<div class="storeEditCate">Nickname</div>
										<div class="storeEditForm">
											<input type="text" name="nicname" class="formTxt1 " value="<?php print $_GET['nicname']?>">
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">Please let us know Your impressions</div>
										<div class="storeEditForm">
											<textarea name="comment" id="comment" rows="5" cols="" class="formTxt1 "><?php print $_GET['comment']?></textarea>
										</div>
									</div>

								</div>

								</div>

						</section>

						<section>
							<div class="storeEditBtnBox mT20">

								<button type="submit" class="btn btn-primary button_input button_form btnBase btnBg1 btnW1" >Post</button>

							</div>
						</section>
						<input type="hidden" name="rid" value="<?php print $_GET['rid']?>">
						<input type="hidden" name="tour_id" value="<?php print $rsv['tour']['tour_id']?>">
						<input type="hidden" name="store_basic_id" value="<?php print $rsv['store_basic_id']?>">
					</form>

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
</body>
</html>
