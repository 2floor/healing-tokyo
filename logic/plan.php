<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$jis_common_logic = new jis_common_logic();
$front_disp_logic = new front_disp_logic();

if($_GET['tid'] != null && $_GET['tid'] != ''){
	$tour = $front_disp_logic->get_tour_detail($_GET['tid']);
	$jis_common_logic->cash_recent_view($_GET['tid']);

	$img = explode(",",$tour['tour_base']['img']);
}else{
	header("Location: ./");
	exit();
}

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
					<?php require_once "common.php"?>
					<section class="mB50 mT20">
						<div class="planDetailBox">
							<div class="planDetailBoxLeft">
								<img src="../upload_files/tour/<?php print $img[0]?>" alt="">
							</div>
							<div class="planDetailBoxRight">
								<h2 class="planDetailTtl">
								<?php print $tour['tour_base']['title']?>
							</h2>
								<div class="planPriceBox2">
									<div class="planPrice1 Before" style="text-decoration: line-through; text-align: left;margin-bottom: 10px;">
										￥<?php print number_format($tour['tour_base']['adult_fee']) ;?> per person
										<span class="planPrice2">(IN TAX)</span> → <?php print  $tour['tour_base']['discount_rate_setting']?>% OFF
									</div>
									<div class="planPrice1">￥<?php print number_format($tour['tour_base']['adult_fee']) ;?> per person<span class="planPrice2">(IN TAX)</span>
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
								<div class="planDetailPrice2"><?php print number_format($tour['tour_base']['adult_fee'])  ?>per person(IN TAX)</div>
							</div>
							<div class="planDetailPriceRight">
								<div class="planDetailPrice1">Duration</div>
								<div class="planDetailPrice2"><?php print $tour['tour_base']['duration']?></div>
							</div>
						</div>
						<h4 class="planDetailCautionTtl">method of payment</h4>
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
							〇 Reservation available<br> × No seat
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
		var nowPage= 0;
		var view= 13;
		cal_difp(nowPage);

		$("#prev").off().on('click', function(){nowPage -= view;cal_difp(nowPage);});
		$("#next").off().on('click', function(){nowPage += view;cal_difp(nowPage);});
		function cal_difp(add_date){
			$('.f_date').hide();
			var nowDate = moment().add('days', add_date);

			$('.f_date').each(function(i,e){
				var d = moment($(e).attr('date'));
				var diff = d.diff(nowDate, 'days')
				if(add_date == 0) add_date = view;
				if (diff <= add_date && diff > add_date - view ) {
					$(e).show();
				}
			});
		}
	</script>

</body>
</html>
