<?php
session_start();
require_once __DIR__ . '/../logic/common/common_logic.php';
$common_logic = new common_logic();

$rev = $common_logic->select_logic("select * from t_review where review_id = ? and del_flg = 0  and public_flg = 0 ", array($_GET['revid']));
$row = $rev[0];
$star = str_repeat("★", $row['review_point']) . str_repeat("☆", 5 -$row['review_point']);
$tour  = $common_logic->select_logic("select * from t_member where member_id = ? ", array($row['member_id']));
$t  = $common_logic->select_logic("select * from t_tour where tour_id = ? ", array($row['tour_id']));
$img = explode(",", $tour[0]['icon']);
if($img[0] == null || $img[0] == ''){
	$img_tag = '<img src="../img/noimage.jpg" alt="noimage">';
}else{
	$img_tag = '<img class="rankingBoxInImg" src="../upload_files/member/'.$img[0].'" alt="'.$tour[0]['title'].'">';
}



?>
<!DOCTYPE html>
<html lang="ja">
<head>


	<?php require_once "../required/html_head.php"?>

<!-- システム用 -->


</head>
<body>

	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once "../required/header_out_lower.php"?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="container1080 cf">
				<div class="container760">
					<!-- AbstractPartsId:1010 LayoutNo:10 DeviceDivisionId:1 Rev:0 -->
					<!-- prts_10-2 画像ありボタン２個 -->
					<?php require_once "./member_top.php"?>

					<form action="review_conf.php" method="post" name="frm" id="frm">
						<section class="borderBox">
							<div class="storeEditIn">
								<h3 class="titleUnderline">口コミ内容</h3>
								<p>返信の登録が完了しました。</p>
							</div>
						</section>

						<section>
							<div class="storeEditBtnBox mT20">
							</div>
						</section>
					</form>
					</div>

	<!--▼▼▼▼▼ right ▼▼▼▼▼-->
	<?php require_once '../right_out.php';?>
	<!--▲▲▲▲▲ right ▲▲▲▲▲-->

			</div>
		</div>
	</div>

	<!--▼▼▼▼▼ footer ▼▼▼▼▼-->
	<?php require_once "../required/footer_out.php"?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->

	<!-- ページTOPへ-->
	<p id="try__page-top">
		<a href="#wrap">TOP</a>
	</p>
	<!-- ページTOPへ-->


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->




</body>
</html>
