<?php
require_once __DIR__ .  '/./logic/front/front_disp_logic.php';
require_once __DIR__ . "/./logic/common/common_logic.php";
$front_disp_logic = new front_disp_logic();
$common_logic = new common_logic();

$wad = '';
if($_GET['cate']){
    $wad = '&cate='.$_GET['cate'];
}elseif($_GET['area']){
    $wad = '&area='.$_GET['area'];
}

$ad_res = $common_logic->select_logic_no_param("select * from t_ad where del_flg = '0' and public_flg = '0' ORDER BY RAND() LIMIT 10 ");

$ad_html = '';
for ($i = 0; $i < count($ad_res); $i++) {
    $ad_row = $ad_res[$i];
    $ad_html .= '
    <section>
		<div class="prts__contents_12">
			<div class="cmsi__banner">
				<div class="cmp__banner-item">
					<a href="' . $ad_row['ad_eng'] . '" style="height:50px" target="_blank">
                        <img src="'.$path.'upload_files/ad/'.$ad_row['thumbnail'].'" alt="" class=" ">
					</a>
				</div>
			</div>
		</div>
	</section>';
}


?>

<div class="container300">
	<section>
		<div class="prts__top-aside-link_02">
			<div class="cmsi__right-area-head cmsi__head">
				<h2 class="cmp__head__title jisTtlArea"><img src="<?php print $path ?>img/ttl_icon.png" alt="Fuji"> Date</h2>
			</div>
			<div class="cmm__right-area-box">
				<div class="cmsi__link-box02">
					<div class="cmm__txt-area">
						<a href="<?php print $path?>search?date=<?php print urlencode(date('m/d/Y')).$wad?>">
							<p class="cmp__txt-aside">TODAY</p>
						</a>
					</div>
					<div class="cmm__txt-area">
						<a href="<?php print $path?>search?date=<?php print urlencode(date('m/d/Y', strtotime(date('m/d/Y') . " +1 day "))).$wad?>">
							<p class="cmp__txt-aside">TOMORROW</p>
						</a>
					</div>
					<div class="cmm__txt-area">
						<a href="<?php print $path?>search?date=<?php print urlencode(date('m/d/Y', strtotime(" next saturday"))).$wad?>">
							<p class="cmp__txt-aside">NEXT Saturday</p>
						</a>
					</div>
					<div class="cmm__txt-area">
						<a href="<?php print $path?>search?date=<?php print urlencode(date('m/d/Y', strtotime(" next sunday"))).$wad?>">
							<p class="cmp__txt-aside">NEXT Sunday</p>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="prts__contents_12">
			<p class="top_bannertxt">Recently Reviewed</p>
		</div>
	</section>


	<section>
		<div class="prts__contents_12">
			<div class="cmsi__banner">
					<?php print $front_disp_logic->create_recent_view($path);?>
			</div>
		</div>
	</section>

	<?php print $ad_html?>


	<!-- /広告エリア-->
</div>
