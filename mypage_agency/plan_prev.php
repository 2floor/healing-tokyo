<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$jis_common_logic = new jis_common_logic();
$front_disp_logic = new front_disp_logic();

// if($_GET['tid'] != null && $_GET['tid'] != ''){
	$tour = array(
			"tour_base" => $_POST,
			"tour" => $_POST,
	);

	$lat = explode("@", $_POST['lat']."@". $_POST['lng']);
// 	$jis_common_logic->cash_recent_view($_GET['tid']);



	$img = explode(",",$tour['tour_base']['img']);
	$img_html = '';
	$youtube_script = '';
	if($tour['tour_base']['youtube'] != null && $tour['tour_base']['youtube'] != ''){
		$img_html .= '<div>'.htmlspecialchars_decode($tour['tour_base']['youtube']).'</div>';
		$youtube_script = '<script>$("iframe").removeAttr("width").removeAttr("height");</script>';
	}
	foreach ($img as $im) {
		$img_html .= '<div><img src="../upload_files/tour/'.$im.'" alt=""></div>';
	}

	if($img[0] == null || $img[0] == ''){
		$img_html = '<!-- Slide 1 -->
					<div class="">
						<img src="../img/noimage.jpg" alt="noimage">
					</div>
					<div class="">
						<img src="../img/noimage.jpg" alt="noimage">
					</div>
					<div class="">
						<img src="../img/noimage.jpg" alt="noimage">
					</div>';
	}

	if((int)$tour['tour_base']['discount_rate_setting'] > 0){
// 		$descPrioce =   $jis_common_logic->add_tax($jis_common_logic->calc_discount($tour['tour_base']['adult_fee'], $tour['tour_base']['discount_rate_setting']));
// 		$childDescPrioce =   $jis_common_logic->add_tax($jis_common_logic->calc_discount($tour['tour_base']['children_fee'], $tour['tour_base']['discount_rate_setting']));
		$descPrioce =   $jis_common_logic->calc_discount($tour['tour_base']['adult_fee'], $tour['tour_base']['discount_rate_setting']);
		$childDescPrioce =   $jis_common_logic->calc_discount($tour['tour_base']['children_fee'], $tour['tour_base']['discount_rate_setting']);
		$child_price = '';
		if($childDescPrioce > 0){
			$child_price = '<div class="planDetailPrice2">chilren　: ￥'.number_format($childDescPrioce).' per person(IN TAX)</div><div class="planDetailPrice2">※Child fee applicable age:'.$tour['tour_base']['children_age_limit'].'</div>';
		}
		$descper =   $tour['tour_base']['discount_rate_setting'] . "% OFF";
		$dep_html  = '<div class="planPrice1 Before" style="text-decoration: line-through; text-align: left;margin-bottom: 10px;">
							<span class="planPrice2">Adult</span>￥'.number_format($tour['tour_base']['adult_fee']) .' per person<span class="planPrice2">(IN TAX)</span>→
						</div>
						<div class="planPrice1 Before" style="text-decoration: line-through; text-align: left;margin-bottom: 10px;">
							<span class="planPrice2">Child</span>￥'.number_format($tour['tour_base']['children_fee']) .' per person<span class="planPrice2">(IN TAX)</span>→
						</div>';
		$newPrice= $descPrioce;
// 		$newPrice= $jis_common_logic->add_tax($descPrioce);
	}else{
// 		$descPrioce = $jis_common_logic->add_tax($tour['tour_base']['adult_fee']);
// 		$childDescPrioce =   $jis_common_logic->add_tax($tour['tour_base']['children_fee'], $tour['tour_base']['discount_rate_setting']);
		$descPrioce = $tour['tour_base']['adult_fee'];
		$childDescPrioce =   $tour['tour_base']['children_fee'];


		$descper =   "";
		$dep_html  = "";
		$newPrice = $descPrioce;

	}
	$child_price = '';
	if($childDescPrioce > 0){
		$child_price = '<div class="planDetailPrice2">chilren　: ￥'.number_format($childDescPrioce).' per person(IN TAX)</div><div class="planDetailPrice2">※Child fee applicable age:'.$tour['tour_base']['children_age_limit'].'</div>';
	}

// }else{
// 	header("Location: ./");
// 	exit();
// }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once '../required/html_head.php';?>
<style type="text/css">
@media print
{
    @page
    {
        size: 297mm 210mm; /* landscape */
        /* you can also specify margins here: */
        margin: 250mm;
        margin-right: 450mm; /* for compatibility with both A4 and Letter */
    }
}


.slick-slide{
	height: 320px;
}
.slick-slide > img{
	width: 100%;
	height: 100%;
	object-fit: cover;
	font-family: "object-fit: cover;";
}

.slick-slide > iframe{
	width: 100%;
	height: 100%;

}
.slick-dots{
	display: flex;
	align-items: center;
	justify-content: center;
}
.slick-dots > li{
	margin: 10px;
}

.slick-dotted.slick-slider
{
    margin-bottom: 30px;
}

.slick-dots
{
    position: absolute;
    bottom: -25px;

    display: block;

    width: 100%;
    padding: 0;
    margin: 0;

    list-style: none;

    text-align: center;
}
.slick-dots li
{
    position: relative;

    display: inline-block;

    width: 20px;
    height: 20px;
    margin: 0 5px;
    padding: 0;

    cursor: pointer;
}
.slick-dots li button
{
    font-size: 0;
    line-height: 0;

    display: block;

    width: 20px;
    height: 20px;
    padding: 5px;

    cursor: pointer;

    color: transparent;
    border: 0;
    outline: none;
    background: transparent;
}
.slick-dots li button:hover,
.slick-dots li button:focus
{
    outline: none;
}
.slick-dots li button:hover:before,
.slick-dots li button:focus:before
{
    opacity: 1;
}
.slick-dots li button:before
{
    font-family: 'slick';
    font-size: 30px;
    line-height: 20px;

    position: absolute;
    top: 0;
    left: 0;

    width: 20px;
    height: 20px;

    content: '•';
    text-align: center;

    opacity: .25;
    color: black;

    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.slick-dots li.slick-active button:before
{
    opacity: .75;
    color: black;
}
.planCalRemain  a{
	text-decoration: underline;
}
@media print
{
    html
    {
/*         transform: scale(0.5);transform-origin: 0 0; */
        zoom: 100%;
    }
}
@media (max-width: 767px){
	.smallBtn {
	    width: 100%;
	    margin-bottom: 10px;
	}
}


</style>
</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
<?php require_once '../required/header_out_lower.php';?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->
	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="BreadcrumbList"></div>
			<div class="container1080 cf">
				<section>
					<?php require_once "../search/common.php"?>
					<section class="mB50 mT20">
						<div class="planDetailBox">
							<div class="planDetailBoxLeft">
								<div id="sliderCate">
									<?php print $img_html?>
								</div>
							</div>
							<?php print $youtube_script?>
							<div class="planDetailBoxRight">
								<h2 class="planDetailTtl">
								<?php print $tour['tour_base']['title']?>
							</h2>
								<div class="planPriceBox2">
									<?php print $dep_html;?>
									<div class="planPrice1"><span class="planPrice2">Adult</span>￥<?php print number_format($descPrioce) ;?> per person<span class="planPrice2">(IN TAX)</span><?php print $descper?>
									<div class="planPrice1"><span class="planPrice2">Child</span>￥<?php print number_format($childDescPrioce) ;?> per person<span class="planPrice2">(IN TAX)</span><?php print $descper?>
									</div>
								</div>
								<?php print nl2br($tour['tour_base']['title'])?>
								<div class="planDetailBtnBox">
									<button type="button" class="smallBtn" onclick="window.print();">
										<i class="fas fa-print"></i>　Print
									</button>
									<a href="#travel">
									<button type="button"
										class="btnBase btnBg2 btnW2 btnH1 scr_btn">Reserve</button></a>
								</div>
							</div>
						</div>
					</section>

					<section class="mB50">
						<div class="planDetailMenuBgBox">
							<div class="planDetailBoxIn">
								<h3 class="planDetailMenuTtl"><?php print $tour['tour_base']['d_title']?></h3>
								<p class="planDetailMenuTxt">
								<?php print nl2br($tour['tour_base']['d_detail'])?>
								</p>
							</div>

					</section>

					<section class="mB50">
						<div class="planDetailPriceBox">
							<div class="planDetailPriceLeft">
								<div class="planDetailPrice1">Fee</div>
								<div class="planDetailPrice2">Adult　　: ￥<?php print number_format($descPrioce)  ?> per person(IN TAX)</div>
								<?php print $child_price?>
							</div>
							<div class="planDetailPriceRight">
								<div class="planDetailPrice1">Duration</div>
								<div class="planDetailPrice2"><?php print $tour['tour_base']['duration']?></div>
							</div>
						</div>
						<div class="planDetailPriceBox">
							<div class="planDetailPriceLeft">
								<div class="planDetailPrice1">Inclusion</div>
								<div class="planDetailPrice2"><?php print $tour['tour_base']['inclusion'] ?></div>
							</div>
							<div class="planDetailPriceRight">
								<div class="planDetailPrice1">What to bring</div>
								<div class="planDetailPrice2"><?php print $tour['tour_base']['what_to_bring']?></div>
							</div>
						</div>

						<h4 class="planDetailCautionTtl">Itinerary</h4>
						<p class="planDetailCautionTxt">
							<?php print nl2br($tour['tour_base']['tranvel'])?>
						</p>

						<h4 class="planDetailCautionTtl">Meeting place</h4>
						<p class="planDetailCautionTxt">
							<?php print nl2br($tour['tour_base']['meeting_place'])?>
							<div id="map" style="width: 100%; height: 500px"></div>
									<!--     <div id="map"></div> -->
									<script>

	function initAutocomplete() {
		var icon = {
				icon: 'img/map-icon.png',
			};

		var map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: <?php print $lat[0]?>, lng: <?php print $lat[1]?>},
			zoom: 16,
			mapTypeId: 'roadmap',
				styles: [{
			}]
		});
		marker = new google.maps.Marker({ // マーカーの追加
	        position:{lat: <?php print $lat[0]?>, lng: <?php print $lat[1]?>},
	      map: map // マーカーを立てる地図を指定
	   });
	}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC50D68hnfmHwA2uN9fOTlRNbtA5IyxOzc&libraries=places&callback=initAutocomplete" async defer></script>
						</p>

						<h4 class="planDetailCautionTtl">Method of payment</h4>
						<p class="planDetailCautionTxt">
							<?php print nl2br($tour['payment_way'])?>
						</p>
						<h4 class="planDetailCautionTtl">Cancellation policy</h4>
						<p class="planDetailCautionTxt">
							<?php print nl2br($tour['tour_base']['note'])?>
						</p>

					</section>

					<section class="mB50 resv_area" id="travel">
						<div class="cmsi__head mL0 mR0">
							<h2 class="cmp__head__title jisTtlArea">
								<img src="../img/ttl_icon.png" alt="Fuji"> Availavillty
							</h2>
						</div>
						<p class="storeTxt">
							Number : Recruitment Capacity<br> ×  : No seat
						</p>

						<?php print $tour['rsv_html'][0]?>
						<?php print $tour['rsv_html'][1]?>
						<?php print $tour['rsv_html'][2]?>



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
	<script type="text/javascript">
		$('a').each(function (i,e){$(e).attr("href", "javascript:void(0);");});
	</script>

</body>
</html>
