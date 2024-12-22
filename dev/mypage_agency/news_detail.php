<?php
session_start();
require_once __DIR__ . '/../logic/common/common_logic.php';
$common_logic = new common_logic();
$news = $common_logic->select_logic("select * from t_news where news_id = ? ", array($_GET['nid']));

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once "../required/html_head.php"?>
</head>
<body>

	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once '../required/header_out_lower.php';?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="container1080 cf">
				<div class="container760">
					<?php require_once "./member_top.php"?>

					<section class="mB50">
						<div class="prts__contents_19">
							<h3 class="titleUnderline">JISからのお知らせ</h3>
						</div>
						<div class="newsDetailArea">
							<h4 class="newsDetailTtl"><?php print $news[0]['title']?></h4>
							<p class="newsDetail"><?php print nl2br($news[0]['detail'])?></p>
						</div>
					</section>

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


</body>
</html>
