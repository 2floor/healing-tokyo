<?php
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
$jis_common_logic = new jis_common_logic();

if($_GET['sbid'] != null && $_GET['sbid'] != ''){
	$store_basic = $jis_common_logic->get_store_basic($_GET['sbid']);
	if($store_basic['public_flg'] == '1' || $store_basic['del_flg'] == '1' ){
		echo"<script>alert('Cannot found agency.');location.replace('../');</script>";eixt();
	}
}else{
	$store_basic = $_POST;
}
$area_array = $jis_common_logic->area_array();
$replace_k = array_keys($area_array);
$replace_v = array();
foreach ($area_array as $value) {
	array_push($replace_v, $value['eng']);
}
$area = str_replace($replace_k, $replace_v, $store_basic['area']);


$review_html = $jis_common_logic->get_review_point($_GET['sbid'])


?>
<section>
	<div class="searchResultBox2 mT10">
		<div class="searchResultNameBox">
			<div class="searchResultBoxArea"><?php print $area?></div>
			<h3 class="searchResultBoxName"><?php print $store_basic['company_name_eng']?></h3>
			<h4 class="searchResultBoxKana">(<?php print $store_basic['company_name']?>)</h4>
		</div>
		<div class="searchResultKuchi">
			<dl>
				<?php print $review_html?>
			</dl>
		</div>
	</div>
	<nav>
		<ul class="shopNav">
			<li><a href="agency_detail.php?sbid=<?php print $_GET['sbid'] ?>" class="ov">TOP</a></li>
			<li><a href="plan_list.php?sbid=<?php print $_GET['sbid'] ?>" class="ov">Tours</a></li>
			<li><a href="review_list.php?sbid=<?php print $_GET['sbid'] ?>" class="ov">Review</a></li>
		</ul>
	</nav>
</section>