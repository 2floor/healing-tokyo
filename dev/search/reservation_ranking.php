<?php
session_start();
require_once __DIR__ . "/../logic/front/front_disp_logic.php";
require_once __DIR__ . "/../logic/common/jis_common_logic.php";
$jis_common_logic = new jis_common_logic();
$front_disp_logic = new front_disp_logic();
$data = $front_disp_logic->get_reservation_rank_data(10);
$i = 0;
foreach ((array)$data as $d){
	$row = $front_disp_logic->get_tour_detail_data($d['tour_id']);


	++$i;
	$rank = (strlen($i) == 1) ? "0".$i: $i;
	$img = explode(",", $row['img']);
	$store = $jis_common_logic->get_store_basic($d['store_basic_id']);

	$html .= '<div class="planBox1 mT40">
							<div class="rankingIcon">
								<img src="../assets/front/img/rank'.$rank.'.png" alt="ランキング'.$rank.'位">
							</div>
							<div class="searchResultBoxPlan">
								<h4 class="rankingStoreName">
									<a href="./plan.php?tid='.$row['tour_id'].'&sbid='.$row['store_basic_id'].'">'.$row['title'].'</a>
									<span class="rankingNameArea"></span>
								</h4>
								<div class="searchResultBoxPlanImg">
									<img src="../upload_files/tour/'.$img[0].'" alt="'.$row['title'].'">
								</div>
								<div class="searchResultBoxPlanList">
									<h2 class="rankingCatch">
										'.$row['d_title'].'
									</h2>
									<p class="rankingTxt">
										'.$row['d_detail'].'
									</p>
									<div class="rankingPlanBox">
										<a href="agency_detail.php">
											'.$store['company_name_eng'].'
											<div class="rankingBtnBox">
												<a href="./agency_detail.php?sbid='.$row['store_basic_id'].'" type="button" class="btnBase btnBg2 btnW1 btnH2">View the detail</a>
											</div>
										</a>
									</div>
								</div>
							</div>

						</div>';
}
if($html == '' || $html == null){
	$html = '
		<p class="mypageTxt">
			No Data.
		</p>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>

<?php require_once '../required/html_head.php'?>

</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once "../required/header_out_lower.php"?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="sliderBorBtm sli_height">
				<div class="container1080 marB0 posRel">
					<div class="visible-xs">
						<section>
							<div class="">
							    <div class="sp-slides">
							        <!-- Slide 1 -->
							        <div class="sp-slide sliderBorBtm">
							            <img class="sp-image" src="../assets/front/img/tit_reservation_rank.jpg"/>
							        </div>
								 </div>
							  </div>
						</section>
				    </div>
					<div class="hidden-xs">
						<section>
							<div class="">
							    <div class="sp-slides">
							        <!-- Slide 1 -->
							        <div class="sp-slide sliderBorBtm">
							            <img class="sp-image" src="../assets/front/img/tit_reservation_rank.jpg"/>
							        </div>
							    </div>
							  </div>
						</section>
					</div>
					<?php require_once __DIR__ . "/../required/main_vi_post.php"?>
				</div>
			</div>



			<div class="container1080 cf">
				<div class="container760">
					<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> Ranking</h2>
							</div>
					<section>
						<h3 class="titleUnderline">Reservation number ranking</h3>

					</section>

					<section class="borderBox">
						<?php print $html?>

					</section>


				</div>

	<!--▼▼▼▼▼ right ▼▼▼▼▼-->
	<?php require_once '../right_out.php';?>
	<!--▲▲▲▲▲ right ▲▲▲▲▲-->

			</div>
		</div>
	</div>

	<!--▼▼▼▼▼ bottomslider ▼▼▼▼▼-->
	<?php print $buttom_bunner?>
	<!--▲▲▲▲▲ bottomslider ▲▲▲▲▲-->

	<!--▼▼▼▼▼ footer ▼▼▼▼▼-->
	<?php require_once '../required/footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
