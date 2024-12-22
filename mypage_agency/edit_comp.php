<?php session_start();?>
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

			<div class="container1080 cf conf_top">
				<div class="container760">
					<?php require_once "./member_top.php"?>

					<section>
						<h3 class="titleUnderline">Information</h3>
						<p class="planDetailCautionTxt noteTextArea">アクティビティ情報の登録が完了しました。</p>

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
	<script type="text/javascript">

	na();
	$('[name=nationality]').on("change", function(){na();});
		function na(){
			if( $('[name=nationality]').val() == 'Other'){
				$('.nationality_othre_form').css("visibility", "visible");
			}else{
				$('.nationality_othre_form').css("visibility", "hidden");
			}
		}
	</script>

</body>
</html>
