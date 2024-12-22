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
								<div class="storeEditItem">
									<div class="storeEditRow">
										<div class="storeEditCate">利用したプラン</div>
										<div class="storeEditForm">
											<div class="reservPlanName">
												<?php print $t[0]['title']?>
											</div>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">利用者氏名</div>
										<div class="storeEditForm">
												<?php print $row['nicname']?>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">点数（5点満点）</div>
										<div class="storeEditForm">
											<span class="registBox33"> <?php print $star?></span>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">コメント</div>
										<div class="storeEditForm">
											<?php print nl2br($row['comment'])?>
										</div>
									</div>

									<h3 class="titleUnderline mT30">返信</h3>
									<div class="storeEditRow">
										<div class="storeEditCate">返信内容</div>
										<div class="storeEditForm">
											<textarea name="reply" rows="5" cols="" class="formTxt1"><?php print $row['reply']?></textarea>
											<input type="hidden" name="review_id" value="<?php print $row['review_id']?>">
										</div>
									</div>
								</div>
							</div>
						</section>

						<section>
							<div class="storeEditBtnBox mT20">
								<button type="submit" class="btnBase btnBg1 btnW1" name="conf_submit" id="conf_submit" value="conf_submit"><span class="btnLh2">確認画面へ進む</span></button>
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
