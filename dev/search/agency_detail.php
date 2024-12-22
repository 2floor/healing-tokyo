<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$jis_common_logic = new jis_common_logic();
$front_disp_logic = new front_disp_logic();

$prev_sc = '';
if($_POST['preview'] == 'on'){
	$row = $_POST;
	$prev_sc = '<script type="text/javascript">
		$(\'a\').each(function (i,e){$(e).attr("href", "javascript:void(0);");});
	</script>';
}else{
	$row = $jis_common_logic->get_store_basic($_GET['sbid']);
	if($row ==null || $row == ''){
		$prev_sc = '<script type="text/javascript">
			alert("Cannot find the agency");location.replace("../");
	</script>';
	}

}

$img = explode(",", $row['img']);

$img_html = '';
$thumb = '';
foreach ((array)$img as $im) {
	$img_html .= '<!-- Slide 1 -->
								<div class="sp-slide">
									<img class="sp-image" src="../upload_files/store_basic/'.$im.'" alt="">
								</div>';
	$thumb .= '<img class="sp-thumbnail" src="../upload_files/store_basic/'.$im.'" alt="">';
}

if($img[0] == null || $img[0] == ''){
	$img_htm = '<!-- Slide 1 -->
					<div class="sp-slide">
						<img src="../img/noimage.jpg" alt="noimage">
					</div>
					<div class="sp-slide">
						<img src="../img/noimage.jpg" alt="noimage">
					</div>
					<div class="sp-slide">
						<img src="../img/noimage.jpg" alt="noimage">
					</div>';
	$thumb = '<img src="../img/noimage.jpg" alt="noimage">
				<img src="../img/noimage.jpg" alt="noimage">
				<img src="../img/noimage.jpg" alt="noimage">';
}

$youtube = '';
$youtube_tumb = '';
$youtube_script = '';
if($row['youtube_tag'] != null && $row['youtube_tag'] != ''){
	$youtube = '<div class="sp-slide youtubeScri">
					'.htmlspecialchars_decode($row['youtube_tag']).'
				</div>';
	$youtube_tumb = '<div class="sp-thumbnail-container youtubeLayer">'.htmlspecialchars_decode($row['youtube_tag']).'</div>';
	$youtube_script = '<script>$("iframe").removeAttr("width").removeAttr("height");</script>';
}


$relational_tour = $front_disp_logic->get_tour_from_store($_GET['sbid']);


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

<?php print $prev_sc?>

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

<style type="text/css">
@media (max-width: 767px){
    .GselectionL, .GselectionR {
        width: 100%;
    }
}

.sub_catch{
margin: 0px 10px;
}

</style>


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

				<section>
					<?php require_once "common.php"?>
					<section class="mB50 mT20">
						<div class="slider-pro" id="slider2">
							<div class="sp-slides">
								<?php print $youtube?>
								<?php print $img_html?>
							</div>
							<div class="sp-thumbnails">
								<?php print $youtube_tumb?>
								<?php print $thumb?>
							</div>
							<?php print $youtube_script?>
						</div>
						<h1 class="tryp_catch">
						<?php print nl2br($row['cd_title'])?> <!-- FANTASTIC FUJI ＆ HAKONE return by Bullet Train with Lunch -->
					</h1>
					<p class="sub_catch" style="">
						<?php print nl2br($row['cd_deatil'])?><!-- Discover Mt. Fuji, the highest mountain in Japan and listed as the World Heritage in 2013, This tour will also take you to Hakone which is famous for its natural beauty and having such a breathtaking view through Lake Ashi. -->
					</p>
					<p class="mT20 tC spBtnBoxW">
						<a href="plan_list.php?sbid=<?php print $_GET['sbid']?>">
							<button type="button" class="btnBase btnBg2 btnW2 btnH1">View the list</button>
						</a>
					</p>
					</section>
					<section>
					<div class="bgGselectionM mT20">
						<div class="bgGselection1">
							<div class="bgGselectionB">
								<h1 class="GselectionTitle ffMintyo"><?php print nl2br($row['cdf_title'])?><!-- company that is loved by our customers trust. --></h1>
								<div class="GselectionL">
									<div class="bgSelectPhB">
<!-- 										<img src="../assets/front/img/agency_05.jpg" alt=""> -->
										<img src="../upload_files/store_basic/<?php print $row['cdf_img1']?>" alt="">
									</div>
									<h2 class="selectTitle mT10 mB15">
										<span><?php print nl2br($row['cdf_detail1'])?><!-- DOA Japan Corporation is established by DOA Australia in 2014.
											We aimed to advertise traveling to Australia.
											In 2015, we changed purpose to help foreign travelers in Japan. --></span>
									</h2>
								</div>
								<div class="GselectionR">
									<div class="cf">
										<div class="bgSelectPhS fl mR18">
<!-- 											<img src="../assets/front/img/agency_07.jpg" alt="" width="210"> -->
										<img src="../upload_files/store_basic/<?php print $row['cdf_img2']?>" alt="">
										</div>
										<h2 class="selectTitle fr w200">
											<span><?php print nl2br($row['cdf_detail2'])?><!-- Moreover DOA group such as Australia and Japan has purpose to be a travel company that is loved by our customers trust. --></span>
										</h2>
									</div>
									<div class="cf mT40">
										<div class="bgSelectPhS fr mL18">
<!-- 											<img src="../assets/front/img/agency_06.jpg" alt="" width="210"> -->
										<img src="../upload_files/store_basic/<?php print $row['cdf_img3']?>" alt="">
										</div>
										<h2 class="selectTitle">
											<span><?php print nl2br($row['cdf_detail3'])?><!-- Humbly, patronage of everyone who, you look forward to your support,
												hank you from the bottom of my heart. --></span>
										</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<p class="mT30 tC spBtnBoxW">
						<a href="plan_list.php?sbid=<?php print $_GET['sbid']?>">
							<button type="button" class="btnBase btnBg2 btnW2 btnH1">View the list</button>
						</a>
					</p>
				</section>
				<section class="mB50">
					<div class="cmsi__head mL0 mR0">
						<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> Company details</h2>
					</div>
					<table class="shopdetails">
						<tr>
							<th>Company name</th>
							<td>
								<p class="storeDataTxt"><?php print $row['company_name_eng']?><!-- JAPAN PANORAMIC TOURS --></p>
							</td>
						</tr>
						<tr>
							<th>TEL</th>
							<td>
								<p class="storeDataTxt">
									<?php print $row['tel']?><!-- 03-6279-2988 -->
								</p>
							</td>
						</tr>
						<tr>
							<th>Address</th>
							<td>
								<p class="storeDataTxt">
									<?php print $row['location']?><!-- 4F Nisi shinjuku AI Buliding, 7-20-11 Nishi shinjuku, Shinjuku -->
								</p>
							</td>
						</tr>
						<tr>
							<th>Trading hours</th>
							<td>
								<p class="storeDataTxt">
									<?php print $row['trading_hours']?><!-- Office hours 7am - 6pm *Japan time -->
								</p>
							</td>
						</tr>

					</table>
					<p class="mT40 tC spBtnBoxW">
						<a href="plan_list.php?sbid=<?php print $_GET['sbid']?>">
							<button type="button" class="btnBase btnBg2 btnW2 btnH1">View the list</button>
						</a>
					</p>
				</section>

				<section class="mB50">
					<div class="cmsi__head mL0 mR0">
						<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> Word of month ranking</h2>
					</div>
					<?php print $relational_tour;?>
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
