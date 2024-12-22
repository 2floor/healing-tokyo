<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$jis_common_logic = new jis_common_logic();
$front_disp_logic = new front_disp_logic();

$row = $jis_common_logic->get_store_basic($_GET['sbid']);
$img = explode(",", $row['img']);

$html = $front_disp_logic->get_review_list_for_front($_GET['sbid']);

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
<!-- <script type="text/javascript" src="../assets/front/page_js/right2.js"></script> -->


<!-- システム用 -->
<script type="text/javascript" src="../assets/admin/js/common/validate.js"></script>
<!-- <script type="text/javascript" src="../assets/front/js/edit_store.js"></script> -->


<?php print $script_html?>
<script src="../assets/front/js/jquery.sliderPro.min.js"></script>
<script type="text/javascript">
	$( document ).ready(function( $ ) {
		$('#slider2').sliderPro({
			width: "100%",//横幅
			height: 456,
			fade: true,
			arrows: false,//左右の矢印
			buttons: false,//ナビゲーションボタン
			loop: false,//ループ
			thumbnailsPosition: 'right',//サムネイルの位置
			thumbnailPointer: false,//アクティブなサムネイルにマークを付ける
			thumbnailWidth: 229,//サムネイルの横幅
			thumbnailHeight: 152,//サムネイルの縦幅
			touchSwipe:false,
			orientation: 'vertical',//スライドの方向
			breakpoints: {
				600: {//表示方法を変えるサイズ
					thumbnailsPosition: 'bottom',
					thumbnailWidth: 200,
					thumbnailHeight: 80
				},
				480: {//表示方法を変えるサイズ
					thumbnailsPosition: 'bottom',
					thumbnailWidth: 110,
					thumbnailHeight: 60
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
			<div class="BreadcrumbList">
		</div>
			<div class="container1080 cf">

				<section class="mB50">
					<?php require_once "common.php"?>
				</section>

					<section class="mB50">
						<div class="cmsi__head mL0 mR0">
							<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji">Review List</h2>
						</div>
						<div class="reviewWrap">
							<?php print $html;?>
						</div>
					</section>

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
